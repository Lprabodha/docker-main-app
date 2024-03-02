<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Alerts;
use Altum\Database\Database;
use Altum\Date;
use Altum\Models\QrCode;
use Altum\Response;
use Altum\Traits\Apiable;
use Altum\Uploads;
use Unirest\Request;
use DateTime;

class ApiQrCode extends Controller
{
    use Apiable;


    public function index()
    {
        $this->verify_request(false, true);

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $this->get();
        }

        $this->return_404();
    }

    public function get()
    {
        $uId = $_GET['uId'];
        $path = $_GET['path']; // Untrackable URL 
        $activeArchivedQR = false;

        /* Try to get details about the resource id */
        $qr_code = db()->where('uId', $uId)->getOne('qr_codes');

        /* We haven't found the resource */
        if (!$qr_code) {
            $this->return_404();
        }

        $user = db()->where('user_id', $qr_code->user_id)->getOne('users');

        if (!$user) {
            if ($qr_code->user_id == null && date_diff(new DateTime($qr_code->datetime), new DateTime())->days < 7) {
                $activeArchivedQR = true;
            } else {
                $this->return_404();
            }
        }

        $isPlanExpire = $activeArchivedQR == false ? ((new DateTime($user->plan_expiration_date) < new DateTime()) ? true : false) : false;

        if ($user && (!$user->re_active_qr_reminder && $isPlanExpire &&  $user->email_subscription_type != 2)) {
            /* Prepare the email */

            $isDelenquent = check_delinquent_user($user);

            if ($isDelenquent) {
                $link = 'update-payment-method?referral_key=' . $user->referral_key;
            } else {
                $link = 'plans-and-prices?referral_key=' . $user->referral_key . '&email=scan_expired';
            }

            $template = 'reactivate-qrcode';
            $email    = trigger_email($user->user_id, $template, $link);

            if ($email['complete']) {

                /* Update user */
                db()->where('user_id', $user->user_id)->update('users', ['re_active_qr_reminder' => 1]);

                // Update user_emails table
                db()->where('user_id', $user->user_id)->update('user_emails', ['re_active_qr_reminder' => 1]);
            }


            $dpfUser = db()->where('user_id', $user->user_id)->getOne('dpf_user_emails');
            if ($dpfUser) {
                db()->where('user_id', $user->user_id)->update('dpf_user_emails', ['re_active_qr_reminder' => 1]);
            }
        }

        $qr_data = json_decode($qr_code->data);

        /* Prepare the data */
        $data = [
            'id'            => (int) $qr_code->qr_code_id,
            'link_id'       => (int) $qr_code->link_id,
            'project_id'    => (int) $qr_code->project_id,
            'name'          => $qr_code->name,
            'type'          => $qr_code->type,
            'data'          => $this->manipulateData($qr_code->type,$qr_data),
            'last_datetime' => $qr_code->last_datetime,
            'datetime'      => $qr_code->datetime,
            'is_expire'     => $isPlanExpire,
            'status'        => $qr_code->status
        ];
    
        $uniqueUser = "SELECT COUNT(*) FROM qrscan_statistics WHERE qr_code_id = '{$qr_code->qr_code_id}' AND os_name = '{$_GET['os_name']}' AND ip_address = '{$_GET['ip_address']}' AND browser_name = '{$_GET['browser_name']}'";
        $queryResource = database()->query($uniqueUser);
        $count = $queryResource->fetch_row()['0'];
        $isUnique = ($count == 0) ? 1 : 0;

        if ($path == 'null' &&  $qr_code->status == 1) { //Trackable URL scan count 
            $insertData = [
                'qr_code_id'        => $qr_code->qr_code_id,
                'country_code'      => $_GET['country_code'] ?? null,
                'os_name'           => $_GET['os_name'] ?? null,
                'city_name'         => $_GET['city_name'] ?? null,
                'country_name'      => $_GET['country_name'] ?? null,
                'browser_name'      => $_GET['browser_name'] ?? null,
                'referrer_host'     => $_GET['referrer_host'] ?? null,
                'referrer_path'     => $_GET['referrer_path'] ?? null,
                'device_type'       => $_GET['device_type'],
                'browser_language'  => $_GET['browser_language'] ?? null,
                'utm_source'        => $_GET['utm_source'] ?? null,
                'utm_medium'        => $_GET['utm_medium'] ?? null,
                'utm_campaign'      => $_GET['utm_campaign'] ?? null,
                'is_unique'         => $isUnique,
                'ip_address'        => $_GET['ip_address'] ?? NULL,
                'datetime'          => date('Y-m-d H:i:s'),
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];
            /* Insert the log */
            db()->insert('qrscan_statistics', $insertData);
        }


        $meta = [
            'status'        => 1
        ];

        Response::jsonapi_success($data, $meta);
    }


    private function manipulateData(string $type,object $data){
        
        switch($type){
            case 'url':
                $response = [
                    'url' => $data->url,
                ];
                break;
            case 'pdf':
                $response = [
                    'button'=>$data->button,
                    'company'=>$data->company,
                    'description'=>$data->description,
                    'pdf'=>$data->pdfFile,
                    'pdftitle'=>$data->pdftitle,
                    'primaryColor'=>$data->primaryColor,
                    'website'=>$data->website,
                    'directly_show_pdf'=> $this->checkIsset($data, 'direct_pdf'),
                    'metaData'=>[
                        'title'=>$data->pdftitle,
                        'description'=>$data->description,
                        'image'=>LANDING_PAGE_URL.'logo_512x512.png'
                    ]
                ];
                break;
            case 'images':
                $response = [
                    'horizontal'=>$data->uploadCheckbox ?? false,
                    'image_description'=>$data->image_description,
                    'image_title'=>$data->image_title,
                    'website'=>$data->website,
                    'images'=>$data->images,
                    'buttons'=>!empty($data->button_text) ? array_map(function($t,$l){
                        return([
                            'text'=>$t,
                            'url'=>$l
                        ]);
                    },$data->button_text,$data->button_url) : [],
                    'metaData'=>[
                        'title'=>$data->image_title,
                        'description'=>$data->image_description,
                        'image'=>$data->images[0]
                    ]
                ];
                break;
            case 'video':
                $response = [
                    'Autoplay'=>$data->Autoplay ?? false,
                    'Highlight'=>false,
                    'button_text'=>$this->checkIsset($data,'button_text'),
                    'button_url'=>$this->checkIsset($data,'button_url'),
                    'companyName'=>$data->companyName,
                    'direct_video'=>$data->direct_video ?? false,
                    'videoDescription'=>$data->videoDescription,
                    'videoTitle'=>$data->videoTitle,
                    'videos'=>!empty($data->allValues) ? array_map(function($u,$t,$d){
                        return([
                            'url'=>$u,
                            'type'=>$t,
                            'description'=>$d
                        ]);
                    },$data->allValues,$data->video_types,$data->videos_desc) : [],
                    'metaData'=>[
                        'title'=>$data->videoTitle,
                        'description'=>$data->videoDescription,
                        'image'=>LANDING_PAGE_URL.'logo_512x512.png'
                    ]
                ];
                break;
            case 'menu':
                $weekDays = $this->getWeekDays($data);
                $response = [
                    'companyTitle'=>$data->companyTitle,
                    'companyLogo'=> $data->companyLogoImage,
                    'companyDescription'=>$data->companyDescription,
                    'socialLinks'=>$this->getSocialLinks($data),
                    'areAllDaysNull'=>sizeof(array_filter($weekDays,function($e){
                        return empty($e) ? true : false;
                    })) === 7 ? true : false,
                    'weekDays'=>$weekDays,
                    'contactName'=>$data->contactName,
                    'contactWebsite'=>$data->contactWebsite,
                    'contactEmails'=>isset($data->contactEmailTitles) ? array_map(function($t,$e){
                        return [
                            'title'=>$t,'email'=>$e
                        ];
                    },$data->contactEmailTitles,$data->contactEmails) : [],
                    'contactMobiles'=>isset($data->contactMobileTitles) ? array_map(function($t,$n){
                        return [
                            'title'=>$t,'number'=>$n
                        ];
                    },$data->contactMobileTitles,$data->contactMobiles) : [],
                    'sections'=>$this->getSections($data),
                    'metaData'=>[
                        'title'=>$data->companyTitle,
                        'description'=>$data->companyDescription,
                        'image'=>$this->checkEmpty($data->companyLogoImage,$data->companyLogoImage,LANDING_PAGE_URL.'logo_512x512.png')
                    ]
                ];
                break;
            case 'business':
                $facilities = [];
                foreach(["ficon","ficon1","ficon2","ficon3","ficon4","ficon5","ficon6","ficon7","ficon8","ficon9","ficon10","ficon11","ficon12"] as $e){
                    if(isset($data->{$e})) array_push($facilities,$e);
                };
                $response = [
                    'company'=>$data->company,
                    'companyTitle'=>$data->companyTitle,
                    'companySubtitle'=>$data->companySubtitle,
                    'companyLogo'=>$data->companyLogoImage,
                    'aboutCompany'=>$data->aboutCompany,
                    'businessButtonUrls'=>$this->checkIsset($data,'businessButtonUrls'),
                    'businessButtons'=>$this->checkIsset($data,'businessButtons'),
                    'businessButtonsCreated'=> $this->checkEmpty($this->checkIsset($data,'businessButtons'),'1'),
                    'contactName'=>$data->contactName,
                    'contactWebsite'=>$data->contactWebsite,
                    'latitude'=>$this->checkIsset($data,'latitude'),
                    'longitude'=>$this->checkIsset($data,'longitude'),
                    'offer_city'=>$this->checkIsset($data,'offer_city'),
                    'offer_country'=>$this->checkIsset($data,'offer_country'),
                    'offer_number'=>$this->checkIsset($data,'offer_number'),
                    'offer_postalcode'=>$this->checkIsset($data,'offer_postalcode'),
                    'offer_state'=>$this->checkIsset($data,'offer_state'),
                    'offer_street'=>$this->checkIsset($data,'offer_street'),
                    'offer_url1'=>$this->checkIsset($data,'offer_url1'),
                    'ship_address'=>$this->checkIsset($data,'ship_address'),
                    'street_number'=>$this->checkEmpty($this->checkIsset($data,'street_number')),
                    'socialLinks'=>$this->getSocialLinks($data),
                    'weekDays'=>$this->getWeekDays($data),
                    'contactEmails'=>isset($data->contactEmailTitles) ? array_map(function($t,$e){
                        return [
                            'title'=>$t,'email'=>$e
                        ];
                    },$data->contactEmailTitles,$data->contactEmails) : [],
                    'contactMobiles'=>isset($data->contactMobileTitles) ? array_map(function($t,$n){
                        return [
                            'title'=>$t,'number'=>$n
                        ];
                    },$data->contactMobileTitles,$data->contactMobiles) : [],
                    'ficons'=>$facilities,
                    'uId'=>$data->uId,
                    'metaData'=>[
                        'title'=>$data->companyTitle,
                        'description'=>$this->checkEmpty($data->aboutCompany,$data->aboutCompany,$data->companySubtitle),
                        'image'=>$this->checkEmpty($data->companyLogoImage,$data->companyLogoImage,LANDING_PAGE_URL.'logo_512x512.png')
                    ]
                ];
                break;
            case 'vcard':
                $response = [
                    'images'=>$data->companyLogoImage,
                    'latitude'=>$this->checkIsset($data,'latitude'),
                    'longitude'=>$this->checkIsset($data,'longitude'),
                    'offer_city'=>$this->checkIsset($data,'offer_city'),
                    'offer_country'=>$this->checkIsset($data,'offer_country'),
                    'offer_number'=>$this->checkIsset($data,'offer_number'),
                    'offer_postalcode'=>$this->checkIsset($data,'offer_postalcode'),
                    'offer_state'=>$this->checkIsset($data,'offer_state'),
                    'offer_street'=>$this->checkIsset($data,'offer_street'),
                    'offer_url1'=>$this->checkIsset($data,'offer_url1'),
                    'socialLinks'=>$this->getSocialLinks($data),
                    'street_number'=>$this->checkIsset($data,'offer_number'),
                    'vcard_add_contact_at_top'=>$this->checkEmpty($this->checkIsset($data,'vcard_add_contact_at_top')),
                    'vcard_company'=>$data->vcard_company,
                    'vcard_email'=>!empty($data->vcard_emailLabel) ? array_map(function($t,$e){
                        return [
                            'title'=>$t,
                            'email'=>$e
                        ];
                    },$data->vcard_emailLabel,$data->vcard_email) : [],
                    'vcard_first_name'=>$data->vcard_first_name,
                    'vcard_last_name'=>$data->vcard_last_name,
                    'vcard_note'=>$data->vcard_note,
                    'vcard_phone'=>!empty($data->vcard_phone) ? array_map(function($n,$l,$t){
                        return [
                            'number'=>$n,
                            'label'=>$l,
                            'type'=>$t
                        ];
                    },$data->vcard_phone,$data->vcard_phoneLabel,$data->vcard_phoneIcon) : [] ,
                    'vcard_profession'=>$data->vcard_profession,
                    'vcard_social_label'=>$this->checkIsset($data,'vcard_social_label'),
                    'vcard_social_value'=>$this->checkIsset($data,'vcard_social_value'),
                    'vcard_website'=>!empty($data->vcard_website_title) ? array_map(function($t,$w){
                        return [
                            'title'=>$t,
                            'website'=>$w
                        ];
                    },$data->vcard_website_title,$data->vcard_website) : [],
                    'metaData'=>[
                        'title'=>$data->vcard_first_name." ".$data->vcard_last_name,
                        'description'=>$data->vcard_note,
                        'image'=>$this->checkEmpty($data->companyLogoImage,$data->companyLogoImage,LANDING_PAGE_URL.'logo_512x512.png')
                    ]
                ];
                break;
            case 'mp3':
                $response = [
                    'addDownloadOption'=>$this->checkEmpty($this->checkIsset($data,'addDownloadOption')),
                    'button_created'=>$this->checkEmpty($this->checkIsset($data,'button_text'),'1'),
                    'button_text'=>$this->checkIsset($data,'button_text'),
                    'button_url'=>$this->checkIsset($data,'button_url'),
                    'image'=>$data->companyLogoImage,
                    'images'=>[],
                    'mmp3'=>$data->mp3File,
                    'mp3_description'=>$data->mp3_description,
                    'mp3_title'=>$data->mp3_title,
                    'mp3_website'=>$data->mp3_website,
                    'uId'=>$data->uId,
                    'metaData'=>[
                        'title'=>$data->mp3_title,
                        'description'=>$data->mp3_description,
                        'image'=>$this->checkEmpty($data->companyLogoImage,$data->companyLogoImage,LANDING_PAGE_URL.'logo_512x512.png')
                    ]
                ];
                break;
            case 'app':
                $response = [
                    'images'=>[],
                    'companyLogo'=>$data->companyLogoImage,
                    'app_title'=>$data->app_title,
                    'app_description'=>$data->app_description,
                    'app_company'=>$data->app_company,
                    'app_website'=>$data->app_website,
                    'apple'=>$data->apple,
                    'amazon'=>$data->amazon,
                    'google'=>$data->google,
                    'metaData'=>[
                        'title'=>$data->app_title,
                        'description'=>$data->app_description,
                        'image'=>$this->checkEmpty($data->companyLogoImage,$data->companyLogoImage,LANDING_PAGE_URL.'logo_512x512.png')
                    ]
                ];
                break;
            case 'links':
                $response = [
                    'companyLogo'=> $data->companyLogoImage,
                    'linkColor'=> $data->linkColor,
                    'linkTextColor'=> $data->SecondaryColor,
                    'list_description'=> $data->list_description,
                    'list_title'=> $data->list_title,
                    'primaryColor'=> $data->primaryColor,
                    'linkList'=> !empty($data->list_text) ? array_map(function($n,$l,$i){
                                    return ([
                                        'name'=>$n,
                                        'link'=>$l,
                                        'image'=>$i,
                                    ]);
                                },$data->list_text,$data->list_URL,$data->linkImg) : [],
                    'socialLinks'=> $this->getSocialLinks($data),
                    'metaData'=>[
                        'title'=>$data->list_title,
                        'description'=>$data->list_description,
                        'image'=>$this->checkEmpty($data->companyLogoImage,$data->companyLogoImage,LANDING_PAGE_URL.'logo_512x512.png')
                    ]
                ];
                break;
            case 'coupon':
                $response = [
                    "barCodeTgl"=>$this->checkEmpty($this->checkIsset($data,'couponTgl')),
                    "buttonText"=>$data->buttonText,
                    "buttonToSeeCode"=>$data->buttonToSeeCode,
                    "buttonUrl"=>$data->buttonUrl,
                    "company"=>$data->company,
                    "companyLogo"=>$data->companyLogoImage,
                    "couponCode"=>$data->couponCode,
                    "description"=>$data->description,
                    "latitude"=>$this->checkIsset($data,'latitude'),
                    "longitude"=>$this->checkIsset($data,'longitude'),
                    "offerImage"=>$this->checkIsset($data,'offerImg'),
                    "offer_city"=>$this->checkIsset($data,'offer_city'),
                    "offer_country"=>$this->checkIsset($data,'offer_country'),
                    "offer_number"=>$this->checkIsset($data,'offer_number'),
                    "offer_postalcode"=>$this->checkIsset($data,'offer_postalcode'),
                    "offer_state"=>$this->checkIsset($data,'offer_state'),
                    "offer_street"=>$this->checkIsset($data,'offer_street'),
                    "offer_url1"=>$this->checkIsset($data,'offer_url1'),
                    "salesBadge"=>$data->salesBadge,
                    "ship_address"=>$data->ship_address,
                    "street_number"=>$this->checkEmpty($this->checkIsset($data,'offer_number')),
                    "terms"=>[$data->terms],
                    "title"=>$data->title,
                    "validTillDate"=>$data->validTillDate,
                    'uId'=>$data->uId,
                    'metaData'=>[
                        'title'=>$data->title,
                        'description'=>$data->description,
                        'image'=>$this->checkEmpty($data->companyLogoImage,$data->companyLogoImage,LANDING_PAGE_URL.'logo_512x512.png')
                    ]
                ];
                break;
            default:
                return $data;
                break;
        }

        //Common
        if(isset($data->password) && $data->password){
            $response['password'] = md5($data->password);
        }

    
        if($type != 'url' && $type != 'wifi'){
            $response['font_text'] = $data->font_text;
            $response['font_title'] = $data->font_title;
            $response['screen'] = $data->welcomescreen ?? false;
            $response['SecondaryColor'] = $data->SecondaryColor ?? null;
            $response['primaryColor'] = $data->primaryColor ?? null;
           
        }

        $response['status'] = true;

        return $response;
    }

    private function getSocialLinks(object $data) : array{
        if(empty($data->social_icon)){
            return [];
        }

        return array_map(function($i,$n,$t,$u){
            return([
                'icon'=>$i,
                'name'=>$n,
                'text'=>$t,
                'url'=>$u
            ]);
        },$data->social_icon,$data->social_icon_name,$data->social_icon_text,$data->social_icon_url);
    }
    private function getWeekDays(object $data) :array {
        return [
            'Monday'=> isset($data->Monday_From) ? array_map(function($f,$t){
                return [
                    'from'=>$f,'to'=>$t
                ];
            },$data->Monday_From,$data->Monday_To) : [],
            'Tuesday'=>isset($data->Tuesday_From) ? array_map(function($f,$t){
                return [
                    'from'=>$f,'to'=>$t
                ];
            },$data->Tuesday_From,$data->Tuesday_To) : [],
            'Wednesday'=>isset($data->Wednesday_From) ? array_map(function($f,$t){
                return [
                    'from'=>$f,'to'=>$t
                ];
            },$data->Wednesday_From,$data->Wednesday_To) : [],
            'Thursday'=>isset($data->Thursday_From) ? array_map(function($f,$t){
                return [
                    'from'=>$f,'to'=>$t
                ];
            },$data->Thursday_From,$data->Thursday_To) : [],
            'Friday'=>isset($data->Friday_From) ? array_map(function($f,$t){
                return [
                    'from'=>$f,'to'=>$t
                ];
            },$data->Friday_From,$data->Friday_To) : [],
            'Saturday'=>isset($data->Saturday_From) ? array_map(function($f,$t){
                return [
                    'from'=>$f,'to'=>$t
                ];
            },$data->Saturday_From,$data->Saturday_To) : [],
            'Sunday'=>isset($data->Sunday_From) ? array_map(function($f,$t){
                return [
                    'from'=>$f,'to'=>$t
                ];
            },$data->Sunday_From,$data->Sunday_To) : [],
        ]; 
    }
    private function getSections(object $data) : array {
        $sections = [];
        foreach($data->sectionId as $sec){
            $products = [];
            foreach($data->{"productId_".$sec} as $i=>$pi){
                array_push($products,[
                    'id'=>$pi,
                    'image'=>$data->{"productImg_".$sec}[$i],
                    'name'=>$data->{"productNames_".$sec}[$i],
                    'price'=>$data->{"productPrices_".$sec}[$i],
                    'description'=>$data->{"productDescriptions_".$sec}[$i],
                    'translated'=>$data->{"productNamesTranslated_".$sec}[$i],
                    'allergens'=>$data->{"allergens_".$sec."_".$pi} ?? []
                ]);
            };

            array_push($sections,[
                'id'=>$sec,
                'name'=>$data->{"sectionNames_".$sec}[0],
                'description'=>$data->{"sectionDescriptions_".$sec}[0],
                'products'=>$products
            ]);
        }


        return $sections;
    }
    private function checkEmpty($value,$true=true,$false=false) {
        return isset($value) && !empty($value) ? $true : $false ;
    }
    private function checkIsset(object $dataObject,string $property){
        return !empty($dataObject->{$property}) && isset($dataObject->{$property}) ? $dataObject->{$property} : null;
    }
}
