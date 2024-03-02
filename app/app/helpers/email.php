<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

function get_email_template($email_template_subject_array, $email_template_subject, $email_template_body_array, $email_template_body)
{

    $email_template_subject = str_replace(
        array_keys($email_template_subject_array),
        array_values($email_template_subject_array),
        $email_template_subject
    );

    $email_template_body = str_replace(
        array_keys($email_template_body_array),
        array_values($email_template_body_array),
        $email_template_body
    );

    return (object) [
        'subject' => $email_template_subject,
        'body' => $email_template_body
    ];
}

function send_server_mail($to, $from, $title, $content, $reply_to = null)
{

    $headers = "From: " . strip_tags($from) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "Reply-To: " . ($reply_to ?? $from) . " . \r\n";

    /* Sent to multiple addresses if $to variable is array of emails */
    $to_processed = $to;

    if (is_array($to)) {
        $to_processed = '';

        foreach ($to as $address) {
            $to_processed .= ',' . $address;
        }
    }

    return mail($to_processed, $title, $content, $headers);
}

function send_mail($to, $title, $content, $data = [], $reply_to = null, $debug = false)
{
   
    /* Templating for the title */
    $replacers = [
        '{{WEBSITE_TITLE}}' => settings()->main->title,
    ];

    $title = str_replace(
        array_keys($replacers),
        array_values($replacers),
        $title
    );

    /* Prepare the content */
    $replacers = [
        '{{WEBSITE_TITLE}}' => settings()->main->title,
    ];

    $content = str_replace(
        array_keys($replacers),
        array_values($replacers),
        $content
    );

   
    switch ($data['type']) {
        
        case 'reset-password':
            $template = THEME_PATH . 'views/partials/email/reset-password.php';
            break;
        case 'subscription':
            $template = THEME_PATH . 'views/partials/email/subscription-confirmed.php';
            break;
        case 'admin-contact':
            $template = THEME_PATH . 'views/partials/email/admin-contact.php';
            break;
        case 'new-account':
            $template = THEME_PATH . 'views/partials/email/account-create.php';
            break;
        case 'trial-end':
            $template = THEME_PATH . 'views/partials/email/trial-end.php';
            break;
        case 'subscription-canceled':
            $template = THEME_PATH . 'views/partials/email/subscription-canceled.php';
            break;
        case 'new-subscription':
            $template = THEME_PATH . 'views/partials/email/new-subscription.php';
            break;
        case 'change-password':
            $template = THEME_PATH . 'views/partials/email/password-change.php';
            break;
        case 'reactivate-qrcode':
            $template = THEME_PATH . 'views/partials/email/reactivate-qrcode.php';
            break;
        case 'declined-payment':
            $template = THEME_PATH . 'views/partials/email/declined-payment.php';
            break;
        case 'download-qr':
            $template = THEME_PATH . 'views/partials/email/download-qr.php';
            break;
        case 'verification-code':
            $template = THEME_PATH . 'views/partials/email/verification_code.php';
            break;
        case 'email-change':
            $template = THEME_PATH . 'views/partials/email/email-change.php';
            break;
        case 'share-qrcode':
            $template = THEME_PATH . 'views/partials/email/share-qr.php';
            break;
        case 'promo-70':           
            $template = THEME_PATH . 'views/partials/email/promo_70.php';
            break;
        case 'qr-download-reminder':
            $template = THEME_PATH . 'views/partials/email/qr-download-reminder.php';
            break;
        case 'scan-and-track-qr':
            $template = THEME_PATH . 'views/partials/email/scan-and-track-qr.php';
            break;
        case 'print-qr':
            $template = THEME_PATH . 'views/partials/email/print-qr.php';
            break;
        case 'trial-expire-1day-reminder':
            $template = THEME_PATH . 'views/partials/email/trial-expire-1day-reminder.php';
            break;    
        case 'dpf-welcome':
            $template = THEME_PATH . 'views/partials/email/dpf-welcome.php';
            break;
        case 'dpf-download-qr':
            $template = THEME_PATH . 'views/partials/email/dpf-qr-download.php';
            break;
        case 'dpf-one-hour':
            $template = THEME_PATH . 'views/partials/email/dpf-one-hour.php';
            break;
        case 'dpf-14-day-trial-expire-1day-reminder':
            $template = THEME_PATH . 'views/partials/email/dpf-14-day-trial-expire-1day-reminder.php';
            break;
        case 'dpf-14-day-plan-end':
            $template = THEME_PATH . 'views/partials/email/dpf-14-day-plan-end.php';
            break;
        default:
            $template = THEME_PATH . 'views/partials/email_wrapper.php';
    }


    /* Get the email template */
    $email_template = include_view($template, [
        'anti_phishing_code' => $data['anti_phishing_code'] ?? null,
        'code'               => $data['code'] ?? null,
        'referral_key'       => $data['referral_key'] ?? null,
        'link'               => $data['link'] ?? null,
        'promo_img'          => $data['promo_img'] ?? null,
        'user_name'          => $data['user_name'] ?? null,
        'language'           => settings()->main->default_language,
        'content'            => $content,
    ]);


    if (!empty(settings()->smtp->host)) {
        try {
            /* Initiate phpMailer */
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->isHTML(true);

            /* Set the debugging for phpMailer */
            $mail->SMTPDebug = $debug ? 2 : 0;

            /* SMTP settings */
            if (settings()->smtp->encryption != '0') {
                $mail->SMTPSecure = settings()->smtp->encryption;
            }
            $mail->SMTPAuth = settings()->smtp->auth;
            $mail->Host = settings()->smtp->host;
            $mail->Port = settings()->smtp->port;
            $mail->Username = settings()->smtp->username;
            $mail->Password = settings()->smtp->password;

            /* Email sent from */
            if ($reply_to) {
                $mail->setFrom($reply_to, settings()->smtp->from_name);
            } else {
                $mail->setFrom(settings()->smtp->from, settings()->smtp->from_name);
            }


            /* Reply to */
            if ($reply_to) {
                $mail->addReplyTo($reply_to);
            } else {
                $mail->addReplyTo(settings()->smtp->from, settings()->smtp->from_name);
            }

            /* Sent to multiple addresses if $to variable is array of emails */
            if (is_array($to)) {
                foreach ($to as $address) {
                    $mail->addAddress($address);
                }
            } else {
                $mail->addAddress($to);
            }
            
            /* Email title & content */
            $mail->Subject = $title;
            $mail->Body = $email_template;
            $mail->AltBody = strip_tags($email_template);

            /* Save errors in array for debugging */
            $errors = [];

            if ($debug) {
                $mail->Debugoutput = function ($string, $level) use (&$errors) {
                    $errors[] = $string;
                };
            }

            // Attach QR codes
            if ($data['type'] == 'share-qrcode') {
                if ($content['is_bulk'] == "false") {
                    $files = $_FILES['file'];
                    $fileName = $files['type'] == "application/pdf" ?  $files['name'] . '.pdf' :  $files['name'];
                    $mail->addStringAttachment(file_get_contents($files['tmp_name']), $fileName, 'base64', $files['type']);
                } else {
                    $files = $_FILES['file'];

                    foreach ($files['name'] as $index => $name) {
                        $tmpName = $files['tmp_name'][$index];
                        $name = $files['name'][$index];
                        $type = $files['type'][$index];
                        $mail->addStringAttachment(file_get_contents($tmpName), $name, 'base64', $type);
                    }
                }
            }

            /* Send the mail */
            $send = $mail->send();

            /* Save the errors in the returned object for output purposes */
            if ($debug) {
                $mail->errors = $errors;
            }

            return $debug ? $mail : $send;
        } catch (Exception $e) {
            return $debug ? $mail : false;
        }
    } else {
        return send_server_mail($to, settings()->smtp->from, $title, $email_template, $reply_to);
    }
}
