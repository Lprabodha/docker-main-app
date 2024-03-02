<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Models;

use Altum\Uploads;
use SimpleSoftwareIO\QrCode\Generator;
use SVG\Nodes\Embedded\SVGImage;
use SVG\SVG;

class QrCode extends Model
{

    public function delete($qr_code_id)
    {

        if (!$qr_code = db()->where('qr_code_id', $qr_code_id)->getOne('qr_codes', ['qr_code_id', 'qr_code', 'qr_code_logo'])) {
            return;
        }

        foreach (['qr_code', 'qr_code_logo'] as $image_key) {
            Uploads::delete_uploaded_file($qr_code->{$image_key}, 'qr_codes/logo');
        }

        /* Delete from database */
        db()->where('qr_code_id', $qr_code_id)->delete('qr_codes');
    }

    public function GenerateQrWithFrame($settings, string $qrData, string $logoName = null)
    {

        //QR Code Creation.
        $qr = new Generator;
        $qr->size($settings->size);
        $qr->errorCorrection($settings->ecc);
        $qr->encoding('UTF-8');
        $qr->margin($settings->margin);
        $qr->style($settings->style, 0.9);
        /* QR Code Eyes */
        if ($settings->custom_eyes_color) {
            $eyes_inner_color = hex_to_rgb($settings->eyes_inner_color);
            $eyes_outer_color = hex_to_rgb($settings->eyes_outer_color);

            $qr->eyeColor(0, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
            $qr->eyeColor(1, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
            $qr->eyeColor(2, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
        }

        $qr->eye(\BaconQrCode\Renderer\Module\EyeCombiner::instance($settings->cEye, $settings->fEye));

        $settings->foreground_type = isset($settings->foreground_type)  ? $settings->foreground_type : 'color';
        $settings->background_type = isset($settings->background_type)  ? $settings->background_type : 'color';

        // QR Code Foreground
        switch ($settings->foreground_type) {
            case 'color':

                $foreground_color = hex_to_rgb($settings->foreground_color);
                $qr->color($foreground_color['r'], $foreground_color['g'], $foreground_color['b']);
                break;

            case 'gradient':
                $foreground_gradient_one = hex_to_rgb($settings->foreground_gradient_one);
                $foreground_gradient_two = hex_to_rgb($settings->foreground_gradient_two);
                $qr->gradient($foreground_gradient_one['r'], $foreground_gradient_one['g'], $foreground_gradient_one['b'], $foreground_gradient_two['r'], $foreground_gradient_two['g'], $foreground_gradient_two['b'], $settings->foreground_gradient_style);
                break;
        }

        // QR Code Background 
        switch ($settings->background_type) {

            case 'color':
                $background_color = hex_to_rgb($settings->background_color);
                $qr->backgroundColor($background_color['r'], $background_color['g'], $background_color['b'], 100 - $settings->background_color_transparency);

                break;

            case 'gradient':
                $background_color = hex_to_rgb('#ffffff');
                $qr->backgroundColor($background_color['r'], $background_color['g'], $background_color['b'], 0);

                break;
        }

        //QR Code Generate
        $svg = $qr->generate($qrData);

        // QR Code Logo Process
        if ($logoName) {

            $logo_width_percentage = 26;

            /* Start doing custom changes to the output SVG */
            $custom_svg_object = SVG::fromString($svg);
            $custom_svg_doc = $custom_svg_object->getDocument();

            $qr_code_logo_link =  "uploads/qr_codes/logo/" . $logoName;
            $qr_code_logo_extension = explode('.', $logoName);
            $qr_code_logo_extension = mb_strtolower(end($qr_code_logo_extension));


            if ($qr_code_logo_extension == 'png' && $settings->background_type == 'color') {

                $src = imagecreatefromstring(file_get_contents($qr_code_logo_link));
                $src_w = imagesx($src);
                $src_h = imagesy($src);
                $dest_w = $src_w;
                $dest_h = $src_h;
                $dest = imagecreatetruecolor($dest_w, $dest_h);

                if($_POST['background_color_transparency'] == 100){
                    if ($_POST['qr_frame_id']) {
                        if (array_search($_POST['qr_frame_id'], [9, 24, 27]) !== false) {
                            if (isset($_POST['frame_color_type']) && $_POST['frame_color_type'] === 'gradient') {
                                $this->changeLogoBgColor($dest,null);
                            } else {
                                $this->changeLogoBgColor($dest,$_POST['frame_color']);
                            }
                        } else {
                            if (isset($_POST['frame_background_color_transparency'])) {
                                $this->changeLogoBgColor($dest,"#FFFFFF");
                            } elseif(isset($_POST['frame_background_color_type']) && $_POST['frame_background_color_type'] === 'gradient'){
                                $this->changeLogoBgColor($dest,null);
                            } else {
                                $this->changeLogoBgColor($dest,$_POST['frame_background_color']);
                            }
                        }
                    } else {
                        $this->changeLogoBgColor($dest,"#FFFFFF");
                    }
                }else{
                    $this->changeLogoBgColor($dest,$_POST['background_color']);
                }

                imagecopy($dest, $src, 0, 0, 0, 0, $src_w, $src_h);
                $stream = fopen('php://memory', 'r+');
                imagepng($dest, $stream);
                rewind($stream);
                $logo = stream_get_contents($stream);
            } else {
                $logo = file_get_contents($qr_code_logo_link);
            }

            $logo_base64 = 'data:image/' . $qr_code_logo_extension . ';base64,' . base64_encode($logo);

            /* Size of the logo */
            list($logo_width, $logo_height) = getimagesize($qr_code_logo_link);
            $logo_ratio = $logo_height / $logo_width;

            if ($logo_ratio > 1.5) {
                $logo_new_width = $settings->size * 18 / 100;
            } else {
                $logo_new_width = $settings->size * $logo_width_percentage / 100;
            }
            $logo_new_height = $logo_new_width * $logo_ratio;

            /* Calculate center of the QR code */
            $logo_x = $settings->size / 2 - $logo_new_width / 2;
            $logo_y = $settings->size / 2 - $logo_new_height / 2;

            /* Add the logo to the QR code */
            $logo = new SVGImage($logo_base64, $logo_x, $logo_y, $logo_new_width, $logo_new_height);

            $custom_svg_doc->addChild($logo);

            /* Export the QR code with the logo on top */
            $svg = $custom_svg_object->toXMLString();
        }


        if ($settings->background_type == 'gradient') {

            $backgound_gradient_style = $settings->backgound_gradient_style;
            $one = $settings->background_gradient_one;
            $two = $settings->background_gradient_two;


            if ($backgound_gradient_style == 'linear') {

                $gradiant_object = '<svg width="500" height="500" version="1.1" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">            
                <defs>
                    <linearGradient id="backGradient">
                    <stop class="stop1" offset="20%"/>
                    <stop class="stop2" offset="100%"/>               
                    </linearGradient>
                
                    <style type="text/css"><![CDATA[
                    #rect1 { fill: url(#backGradient); }
                    .stop1 { stop-color: ' . $one . '; }
                    .stop2 { stop-color: ' . $two . ';  }                
                    ]]></style>
                </defs>        
                <rect id="rect1" x="0" y="0" width="500" height="500"/>     
            
            </svg>';
            } else {
                $gradiant_object = '<svg width="500" height="500" version="1.1" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">            
                <defs>
                    <radialGradient id="backGradient">
                    <stop  class="stop1" offset="0%"  />
                    <stop   class="stop2" offset="100%" />
                    </radialGradient>     
                    
                    <style type="text/css"><![CDATA[
                        #rect1 { fill: url(#backGradient); }
                        .stop1 { stop-color: ' . $one . '; }
                        .stop2 { stop-color: ' . $two . ';  }                
                        ]]></style>

                </defs>     
                <rect
                x="0"
                y="0"
                width="500"
                height="500"
                fill="url(#backGradient)" />
            
            </svg>';
            }

            $custom_svg_object = SVG::fromString($gradiant_object);
            $custom_svg_doc = $custom_svg_object->getDocument();

            $gradiant_object = new SVGImage('data:image/svg+xml;base64,' . base64_encode($svg), 0, 0, 500, 500);
            $custom_svg_doc->addChild($gradiant_object);
            $svg = $custom_svg_object->toXMLString();
        }

        //QR code dynamic frame code
        $qr_frame_parameter_array = [
            '1' => [35, 30, 250, 250],
            '2' => [35, 30, 250, 250],
            '3' => [35, 30, 250, 250],
            '4' => [35, 30, 250, 250],//
            '5' => [35, 30, 250, 250],
            '6' => [35, 30, 250, 250],
            '7' => [35, 30, 250, 250],
            '8' => [60, 65, 200, 200],
            '9' => [60, 75, 200, 200],
            '10' => [50, 45, 200, 200],
            '11' => [50, 140, 200, 200],
            '12' => [75, 80, 200, 200],
            '13' => [35, 30, 250, 250],
            '14' => [35, 30, 250, 250],
            '15' => [42, 145, 350, 350],
            '16' => [65, 30, 250, 250],
            '17' => [105, 110, 200, 200],
            '18' => [70, 125, 200, 200],
            '19' => [75, 145, 200, 200],
            '20' => [150, 75, 200, 200],
            '21' => [110, 60, 200, 200],
            '22' => [45, 55, 200, 200],
            '23' => [120, 110, 200, 200],
            '24' => [185, 130, 200, 200],
            '25' => [60, 95, 200, 200],
            '26' => [95, 120, 200, 200],
            '27' => [95, 195, 200, 200],
            '28' => [115, 155, 200, 250],
            '29' => [50, 250, 200, 200],
            '30' => [95, 160, 200, 200],
            '31' => [115, 175, 200, 200],
        ];
        if ($settings->qr_frame_id) {
            $qr_frame_id = $settings->qr_frame_id;
            $frame1 = file_get_contents($settings->qr_frame_path);
            $frame_svg_object = SVG::fromString($frame1);
            $frame_svg_doc = $frame_svg_object->getDocument();
            $frame_data = new SVGImage('data:image/svg+xml;base64,' . base64_encode($svg), $qr_frame_parameter_array[$qr_frame_id][0], $qr_frame_parameter_array[$qr_frame_id][1], $qr_frame_parameter_array[$qr_frame_id][2], $qr_frame_parameter_array[$qr_frame_id][3]);
            $frame_svg_doc->addChild($frame_data);
            $svg = $frame_svg_object->toXMLString();

            $svg = $this->changeFrameText($svg, $settings->frame_text);

            $svg = $this->changeTextColor($svg, $settings->qr_text_color);

            $svg = $this->qrFrameFontSize($svg, $settings->qr_frame_font_size);

            $svg = $this->frameTextYPosition($svg, $settings->frame_text_y_position);

            if (!empty($settings->frame_color_type) && ($settings->frame_color_type ?? '') == 'gradient') {

                $svg = $this->changeFrameGradientColor($svg, $settings->frame_gradient_one, $settings->frame_gradient_two, $settings->frame_gradient_style);

                $rgb = $this->HTMLToRGB($settings->frame_gradient_one);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness > 150) {
                    $svg = str_replace('.text-color{fill:#FFF;}', '.text-color{fill:#000;}', $svg);
                }
            } else {

                $svg = $this->changeFrameColor($svg, $settings->frame_color);

                $rgb = $this->HTMLToRGB($settings->frame_color);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness > 150) {
                    $svg = str_replace('.text-color{fill:#FFF;}', '.text-color{fill:#000;}', $svg);
                }
            }

            if (!empty($settings->frame_background_color_type) && $settings->frame_background_color_type == 'gradient') {

                $svg = $this->changeFrameBackgroundGradientColor($svg, $settings->frame_background_gradient_one, $settings->frame_background_gradient_two, $settings->frame_background_gradient_style);
                $rgb = $this->HTMLToRGB($settings->frame_background_gradient_one);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness < 150) {
                    $svg = str_replace('.text-color-dark{fill:#000;}', '.text-color{fill:#FFF;}', $svg);
                }
            } else {
                $svg = $this->changeFrameBackgroundColor(
                    $svg,
                    $settings->frame_background_color,
                    !empty($settings->frame_background_color_transparency) && $settings->frame_background_color_transparency ? true : false
                );

                $rgb = $this->HTMLToRGB($settings->frame_background_color);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness < 150) {
                    $svg = str_replace('.text-color-dark{fill:#000;}', '.text-color{fill:#FFF;}', $svg);
                }
            }
        }

        return $svg;
    }

    private function changeFrameText($svg, $text)
    {
        return str_replace("#text", $text, $svg);
    }

    private function changeTextColor($svg, $frame_text_color)
    {
        return str_replace("frame_text_color", $frame_text_color, $svg);
    }

    private function qrFrameFontSize($svg, $qr_frame_font_size)
    {
        return str_replace("qr_frame_font_size", $qr_frame_font_size, $svg);
    }

    private function frameTextYPosition($svg, $frame_text_y_position)
    {
        return str_replace("frame_text_y_position", $frame_text_y_position, $svg);
    }

    private function changeFrameGradientColor($svg, $one, $two, $style)
    {
        if ($style == 'linear') {
            $svg = str_replace('GLC1', $one, $svg);
            $svg = str_replace('GLC2', $two, $svg);

            return str_replace('.black-area{fill:#000;}', '.black-area{fill: url(#linear);}', $svg);
            // $svg = str_replace('style="fill: #000; fill-opacity: 0.5"', 'style="fill: url(#linear); fill-opacity: 0.5"', $svg);
        } else {
            $svg = str_replace('GRC1', $one, $svg);

            $svg = str_replace('GRC2', $two, $svg);
            return str_replace('.black-area{fill:#000;}', '.black-area{fill: url(#radial);}', $svg);
        }
    }

    private function HTMLToRGB($htmlCode)
    {
        if ($htmlCode[0] == '#')
            $htmlCode = substr($htmlCode, 1);

        if (strlen($htmlCode) == 3) {
            $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
        }

        $r = hexdec($htmlCode[0] . $htmlCode[1]);
        $g = hexdec($htmlCode[2] . $htmlCode[3]);
        $b = hexdec($htmlCode[4] . $htmlCode[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }

    private function RGBToHSL($RGB)
    {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if ($maxC == $minC) {
            $s = 0;
            $h = 0;
        } else {
            if ($l < .5) {
                $s = ($maxC - $minC) / ($maxC + $minC);
            } else {
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            }
            if ($r == $maxC)
                $h = ($g - $b) / ($maxC - $minC);
            if ($g == $maxC)
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if ($b == $maxC)
                $h = 4.0 + ($r - $g) / ($maxC - $minC);

            $h = $h / 6.0;
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }

    private function changeFrameColor($svg, $color)
    {
        return str_replace('.black-area{fill:#000;}', '.black-area{fill:' . $color . ';}', $svg);
    }

    private function changeFrameBackgroundGradientColor($svg, $one, $two, $style)
    {
        if ($style == 'linear') {
            $svg = str_replace('GLCB1', $one, $svg);
            $svg = str_replace('GLCB2', $two, $svg);

            return str_replace('.white-area{fill:#FFF;}', '.white-area{fill: url(#linear-b);}', $svg);
            // $svg = str_replace('style="fill: #000; fill-opacity: 0.5"', 'style="fill: url(#linear); fill-opacity: 0.5"', $svg);
        } else {
            $svg = str_replace('GRCB1', $one, $svg);

            $svg = str_replace('GRCB2', $two, $svg);
            return str_replace('.white-area{fill:#FFF;}', '.white-area{fill: url(#radial-b);}', $svg);
        }
    }

    private function changeFrameBackgroundColor($svg, $color, $transparent)
    {
        if ($transparent) {
            return  str_replace('.white-area{fill:#FFF;}', '.white-area{fill:#ffffff80;}', $svg);
        } else {
            return str_replace('.white-area{fill:#FFF;}', '.white-area{fill:' . $color . ';}', $svg);
        }
    }

    private function changeLogoBgColor($imgObject,$hexColor){
        if($hexColor){
            $background_color = hex_to_rgb($hexColor);
            $background_color = imagecolorallocate($imgObject,  $background_color['r'], $background_color['g'], $background_color['b']);
            imagefill($imgObject, 0, 0, $background_color);
        }else{
            $color = imagecolorallocatealpha($imgObject, 0, 0, 0, 127);
            imagefill($imgObject, 0, 0, $color);
            imagesavealpha($imgObject, TRUE);
        }
    }
}
