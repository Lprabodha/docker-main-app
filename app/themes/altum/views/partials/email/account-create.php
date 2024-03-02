<?php defined('ALTUMCODE') || die() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="<?= \Altum\Language::$active_languages[$data->language] ?>" dir="<?= l('direction', $data->language) ?>" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Creation | Online-QR-Creation</title>
    <style type="text/css" emogrify="no">
        #outlook a {
            padding: 0;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        table td {
            border-collapse: collapse;
            mso-line-height-rule: exactly;
        }

        .editable.image {
            font-size: 0 !important;
            line-height: 0 !important;
        }

        .nl2go_preheader {
            display: none !important;
            mso-hide: all !important;
            mso-line-height-rule: exactly;
            visibility: hidden !important;
            line-height: 0px !important;
            font-size: 0px !important;
        }

        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
            direction: <?= l('direction', $data->language) ?>;
        }

        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        th {
            font-weight: normal;
            text-align: left;
        }

        *[class="gmail-fix"] {
            display: none !important;
        }
    </style>
    <style type="text/css" emogrify="no">
        @media (max-width: 600px) {
            .gmx-killpill {
                content: ' \03D1';
            }
        }
    </style>
    <style type="text/css" emogrify="no">
        @media (max-width: 600px) {
            .gmx-killpill {
                content: ' \03D1';
            }

            .r0-c {
                box-sizing: border-box !important;
                width: 100% !important
            }

            .r1-o {
                border-style: solid !important;
                width: 100% !important
            }

            .r2-i {
                background-color: transparent !important
            }

            .r3-c {
                box-sizing: border-box !important;
                text-align: center !important;
                valign: top !important;
                width: 320px !important
            }

            .r4-o {
                border-style: solid !important;
                margin: 0 auto 0 auto !important;
                width: 320px !important
            }

            .r5-i {
                padding-bottom: 5px !important;
                padding-top: 5px !important
            }

            .r6-c {
                box-sizing: border-box !important;
                display: block !important;
                valign: top !important;
                width: 100% !important
            }

            .r7-i {
                padding-left: 0px !important;
                padding-right: 0px !important
            }

            .r8-c {
                box-sizing: border-box !important;
                text-align: center !important;
                width: 100% !important
            }

            .r9-o {
                border-style: solid !important;
                margin: 0 auto 0 auto !important;
                width: 100% !important
            }

            .r10-i {
                padding-left: 10px !important;
                padding-right: 10px !important;
                padding-top: 15px !important;
                text-align: center !important
            }

            .r11-c {
                box-sizing: border-box !important;
                text-align: center !important;
                valign: top !important;
                width: 100% !important
            }

            .r12-i {
                padding-bottom: 0px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                padding-top: 20px !important
            }

            .r13-i {
                padding-left: 20px !important;
                padding-right: 20px !important;
                padding-top: 20px !important
            }

            .r14-c {
                box-sizing: border-box !important;
                text-align: left !important;
                valign: top !important;
                width: 100% !important
            }

            .r15-o {
                border-style: solid !important;
                margin: 0 auto 0 0 !important;
                width: 100% !important
            }

            .r16-i {
                padding-top: 10px !important;
                text-align: left !important
            }

            .r17-i {
                padding-left: 20px !important;
                padding-right: 20px !important;
                padding-top: 30px !important
            }

            .r18-o {
                border-bottom-width: 0px !important;
                border-left-width: 0px !important;
                border-right-width: 0px !important;
                border-style: solid !important;
                border-top-width: 0px !important;
                margin: 0 auto 0 0 !important;
                width: 100% !important
            }

            .r19-i {
                text-align: left !important
            }

            .r20-c {
                box-sizing: border-box !important;
                valign: top !important;
                width: 100% !important
            }

            .r21-i {
                padding-right: 0px !important;
                padding-top: 15px !important
            }

            .r22-c {
                box-sizing: border-box !important;
                valign: top !important;
                width: 25% !important
            }

            .r23-c {
                box-sizing: border-box !important;
                valign: top !important;
                width: 75% !important
            }

            .r24-c {
                box-sizing: border-box !important;
                text-align: center !important;
                valign: top !important;
                width: auto !important
            }

            .r25-o {
                background-size: auto !important;
                border-style: solid !important;
                margin: 0 auto 0 auto !important;
                max-width: 320px !important;
                width: auto !important
            }

            .r26-i {
                padding-top: 30px !important
            }

            .r27-i {
                padding-left: 20px !important;
                padding-right: 20px !important;
                padding-top: 80px !important
            }

            .r28-i {
                text-align: center !important
            }

            .r29-r {
                background-color: #27c056 !important;
                border-radius: 25px !important;
                box-sizing: border-box;
                height: initial !important;
                padding-bottom: 15px !important;
                padding-top: 15px !important;
                text-align: center !important;
                width: 100% !important
            }

            .r30-i {
                padding-bottom: 20px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                padding-top: 20px !important
            }

            .r31-i {
                padding-bottom: 15px !important;
                padding-top: 15px !important;
                text-align: left !important
            }

            .r32-o {
                border-style: solid !important;
                margin-top: 40px !important;
                width: 100% !important
            }

            .r33-i {
                background-color: #EFF2F7 !important
            }

            .r34-i {
                padding-bottom: 20px !important;
                padding-top: 20px !important
            }

            .r35-o {
                border-style: solid !important;
                margin-left: 0px !important;
                width: 100% !important
            }

            body {
                -webkit-text-size-adjust: none;
                direction: <?= l('direction', $data->language) ?>;
            }

            .nl2go-responsive-hide {
                display: none
            }

            .nl2go-body-table {
                min-width: unset !important
            }

            .mobshow {
                height: auto !important;
                overflow: visible !important;
                max-height: unset !important;
                visibility: visible !important;
                border: none !important
            }

            .resp-table {
                display: inline-table !important
            }

            .magic-resp {
                display: table-cell !important
            }
        }
    </style><!--[if !mso]><!-->
    <style type="text/css" emogrify="no"> </style><!--<![endif]-->
    <style type="text/css">
        p,
        h1,
        h2,
        h3,
        h4,
        ol,
        ul {
            margin: 0;
        }

        a,
        a:link {
            color: #3f3d56;
            text-decoration: none
        }

        .nl2go-default-textstyle {
            color: #3f3d56;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 20px;
            line-height: 1.4;
            word-break: break-word
        }

        .default-button {
            color: #ffffff;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 20px;
            font-style: normal;
            font-weight: bold;
            line-height: 1.15;
            text-decoration: none;
            word-break: break-word
        }

        .sib_class_16_black_reg {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 16px;
            word-break: break-word
        }

        .sib_class_16_black_b {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 16px;
            font-weight: 700;
            word-break: break-word
        }

        .sib_class_20_white_b {
            color: #ffffff;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 20px;
            font-weight: 700;
            word-break: break-word
        }

        .sib_class_28_black_reg {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 28px;
            word-break: break-word
        }

        .sib_class_26_black_b {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 26px;
            font-weight: 700;
            word-break: break-word
        }

        .sib_class_35_black_b {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 35px;
            font-weight: 700;
            word-break: break-word
        }

        .sib_class_50_black_b {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 50px;
            font-weight: 700;
            word-break: break-word
        }

        .sib_class_70_black_reg {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 70px;
            word-break: break-word
        }

        .nl2go_class_impressum {
            color: #999999;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 12px;
            font-style: italic;
            word-break: break-word
        }

        .default-heading1 {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 50px;
            word-break: break-word
        }

        .default-heading2 {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 35px;
            word-break: break-word
        }

        .default-heading3 {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 26px;
            word-break: break-word
        }

        .default-heading4 {
            color: #434343;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
            font-size: 18px;
            word-break: break-word
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: inherit !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .no-show-for-you {
            border: none;
            display: none;
            float: none;
            font-size: 0;
            height: 0;
            line-height: 0;
            max-height: 0;
            mso-hide: all;
            overflow: hidden;
            table-layout: fixed;
            visibility: hidden;
            width: 0;
        }
    </style>
    <!--[if mso]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml><![endif]-->
    <style type="text/css">
        a:link {
            color: #3f3d56;
            text-decoration: none;
        }
    </style>
</head>

<body text="#3f3d56" link="#3f3d56" yahoo="fix" style="">
    <table cellspacing="0" cellpadding="0" border="0" role="presentation" class="nl2go-body-table" width="100%" style="width: 100%;">

        <tr>
            <td align="center" class="r3-c">
                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="600" class="r4-o" style="table-layout: fixed; width: 600px;">
                    <tr>
                        <td valign="top" class="">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r12-i" style="padding-top: 20px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="100%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i" style="padding-left: 15px; padding-right: 15px;">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r11-c" align="center">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="234" class="r9-o" style="table-layout: fixed; width: 234px;">
                                                                                            <tr>
                                                                                                <td class="" style="font-size: 0px; line-height: 0px;">
                                                                                                    <a style="text-decoration: none;" href="<?php echo url('login?redirect=qr-codes')  ?>">
                                                                                                        <img src="https://online-qr-generator.com/themes/altum/assets/images/email/logo-new.png" width="234" border="0" class="" style="display: block; width: 100%;">
                                                                                                    </a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r13-i" style="padding-top: 14px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="100%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r14-c" align="left">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" valign="top" class="r16-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; word-break: break-word; line-height: 1.3; padding-top: 10px; text-align: left;">
                                                                                                    <div>
                                                                                                        <h3 class="default-heading3" style="margin: 0; color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 26px; word-break: break-word;">
                                                                                                            <span style="font-size: 17px;">
                                                                                                                <?= l('emails_account_create.content_default_heading', $data->language) ?>
                                                                                                            </span>
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r17-i" style="padding-top: 50px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="100%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r14-c" align="left">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r18-o" style="table-layout: fixed; width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; word-break: break-word; line-height: 1.3; text-align: left;">
                                                                                                    <div>
                                                                                                        <h2 class="default-heading2" style="margin: 0; color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 35px; word-break: break-word;">
                                                                                                            <?= l('emails_account_create.content_default_next_steps', $data->language) ?></span>
                                                                                                        </h2>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r17-i" style="padding-top: 17px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="58.33%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r14-c" align="left">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                    <div>
                                                                                                        <h3 class="default-heading3" style="margin: 0; color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 26px; word-break: break-word;">
                                                                                                            <?= l('emails_account_create.content_step_1_title', $data->language) ?>
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="r20-c">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                            <!-- -->
                                                                                            <tr>
                                                                                                <td class="r21-i" style="padding-right: 24px; padding-top: 15px;">
                                                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                        <tr>
                                                                                                            <th width="25%" valign="top" class="r22-c" style="font-weight: normal;">
                                                                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                                                    <!-- -->
                                                                                                                    <tr>
                                                                                                                        <td valign="top" class="r7-i">
                                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                                                <tr>
                                                                                                                                    <td class="r14-c" align="left">
                                                                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                            <tr>
                                                                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                                                                    <div>
                                                                                                                                                        <div class="sib_class_70_black_reg" style="color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 70px; word-break: break-word;">
                                                                                                                                                            <span style="font-size: 48px;">1.</span>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </th>
                                                                                                            <th width="75%" valign="top" class="r23-c" style="font-weight: normal;">
                                                                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                                                    <!-- -->
                                                                                                                    <tr>
                                                                                                                        <td valign="top" class="r7-i">
                                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                                                <tr>
                                                                                                                                    <td class="r14-c" align="left">
                                                                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                            <tr>
                                                                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                                                                    <div>
                                                                                                                                                        <p style="margin: 0;">
                                                                                                                                                            <span style="font-size: 15px;">
                                                                                                                                                                <?= l('emails_account_create.content_step_1_desc', $data->language) ?>
                                                                                                                                                            </span>
                                                                                                                                                        </p>
                                                                                                                                                    </div>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th width="41.67%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r24-c" align="center">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="190" class="r25-o" style="table-layout: fixed; width: 190px;">
                                                                                            <tr>
                                                                                                <td class="r26-i" style="font-size: 0px; line-height: 0px;">
                                                                                                    <img src="https://online-qr-generator.com/themes/altum/assets/images/email/step-1.png" width="190" border="0" class="" style="display: block; width: 100%;">
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r17-i" style="padding-top: 45px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="58.33%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r14-c" align="left">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                    <div>
                                                                                                        <h3 class="default-heading3" style="margin: 0; color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 26px; word-break: break-word;">
                                                                                                            <?= l('emails_account_create.content_step_2_title', $data->language) ?>
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="r20-c">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                            <!-- -->
                                                                                            <tr>
                                                                                                <td class="r21-i" style="padding-right: 24px; padding-top: 15px;">
                                                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                        <tr>
                                                                                                            <th width="25%" valign="top" class="r22-c" style="font-weight: normal;">
                                                                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                                                    <!-- -->
                                                                                                                    <tr>
                                                                                                                        <td valign="top" class="r7-i">
                                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                                                <tr>
                                                                                                                                    <td class="r14-c" align="left">
                                                                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                            <tr>
                                                                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                                                                    <div>
                                                                                                                                                        <div class="sib_class_70_black_reg" style="color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 70px; word-break: break-word;">
                                                                                                                                                            <span style="font-size: 48px;">2.</span>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </th>
                                                                                                            <th width="75%" valign="top" class="r23-c" style="font-weight: normal;">
                                                                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                                                    <!-- -->
                                                                                                                    <tr>
                                                                                                                        <td valign="top" class="r7-i">
                                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                                                <tr>
                                                                                                                                    <td class="r14-c" align="left">
                                                                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                            <tr>
                                                                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                                                                    <div>
                                                                                                                                                        <p style="margin: 0;">
                                                                                                                                                            <span style="font-size: 15px;">
                                                                                                                                                                <?= l('emails_account_create.content_step_2_desc', $data->language) ?>
                                                                                                                                                            </span>
                                                                                                                                                        </p>
                                                                                                                                                    </div>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th width="41.67%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r24-c" align="center">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="190" class="r25-o" style="table-layout: fixed; width: 190px;">
                                                                                            <tr>
                                                                                                <td class="r26-i" style="font-size: 0px; line-height: 0px;">
                                                                                                    <img src="https://online-qr-generator.com/themes/altum/assets/images/email/step-2.png" width="190" border="0" class="" style="display: block; width: 100%;">
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r17-i" style="padding-top: 45px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="58.33%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r14-c" align="left">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; word-break: break-word; line-height: 1; text-align: left;">
                                                                                                    <div>
                                                                                                        <h3 class="default-heading3" style="margin: 0; color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 26px; word-break: break-word;">
                                                                                                            <span style="font-size: 26px;">
                                                                                                                <?= l('emails_account_create.content_step_3_title', $data->language) ?>
                                                                                                            </span>
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="r20-c">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                            <!-- -->
                                                                                            <tr>
                                                                                                <td class="r21-i" style="padding-right: 24px; padding-top: 15px;">
                                                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                        <tr>
                                                                                                            <th width="25%" valign="top" class="r22-c" style="font-weight: normal;">
                                                                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                                                    <!-- -->
                                                                                                                    <tr>
                                                                                                                        <td valign="top" class="r7-i">
                                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                                                <tr>
                                                                                                                                    <td class="r14-c" align="left">
                                                                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                            <tr>
                                                                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                                                                    <div>
                                                                                                                                                        <div class="sib_class_70_black_reg" style="color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 70px; word-break: break-word;">
                                                                                                                                                            <span style="font-size: 48px;">3.</span>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </th>
                                                                                                            <th width="75%" valign="top" class="r23-c" style="font-weight: normal;">
                                                                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;">
                                                                                                                    <!-- -->
                                                                                                                    <tr>
                                                                                                                        <td valign="top" class="r7-i">
                                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                                                <tr>
                                                                                                                                    <td class="r14-c" align="left">
                                                                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                            <tr>
                                                                                                                                                <td align="left" valign="top" class="r19-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; text-align: left;">
                                                                                                                                                    <div>
                                                                                                                                                        <p style="margin: 0;">
                                                                                                                                                            <span style="font-size: 15px;">
                                                                                                                                                                <?= l('emails_account_create.content_step_3_desc', $data->language) ?>
                                                                                                                                                            </span>
                                                                                                                                                        </p>
                                                                                                                                                    </div>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th width="41.67%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r24-c" align="center">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="190" class="r25-o" style="table-layout: fixed; width: 190px;">
                                                                                            <tr>
                                                                                                <td class="r26-i" style="font-size: 0px; line-height: 0px;">
                                                                                                    <img src="https://online-qr-generator.com/themes/altum/assets/images/email/step3.png" width="190" border="0" class="" style="display: block; width: 100%;">
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r27-i" style="padding-top: 80px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="100%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r11-c" align="center">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="318" class="r9-o" style="table-layout: fixed; width: 318px;">
                                                                                            <tr>
                                                                                                <td height="23" align="center" valign="top" class="r28-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word;">
                                                                                                    <!--[if mso]> <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://online-qr-generator.com/login" style="v-text-anchor:middle; height: 52px; width: 317px; background-color: #27c056;" arcsize="48%" fillcolor="#27c056" strokecolor="#27c056" strokeweight="1px" data-btn="1"> <w:anchorlock> </w:anchorlock> <v:textbox inset="0,0,0,0"> <div style="display:none;"> <center class="default-button"><p>Create QR Codes</p></center> </div> </v:textbox> </v:roundrect> <![endif]-->
                                                                                                    <!--[if !mso]><!-- -->
                                                                                                    <a href="https://online-qr-generator.com/login" class="r29-r default-button" target="_blank" data-btn="1" style="font-style: normal; font-weight: bold; line-height: 1.15; text-decoration: none; word-break: break-word; border-style: solid; word-wrap: break-word; display: inline-block; -webkit-text-size-adjust: none; mso-hide: all; background-color: #27c056; border-bottom-width: 0px; border-color: #27c056; border-left-width: 0px; border-radius: 25px; border-right-width: 0px; border-top-width: 0px; color: #ffffff; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 20px; height: 23px; padding-bottom: 15px; padding-top: 15px; width: 318px;">
                                                                                                        <?= l('emails_account_create.create_qr', $data->language) ?>
                                                                                                    </a>
                                                                                                    <!--<![endif]-->

                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r11-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                            <tr>
                                                <td class="r30-i" style="padding-bottom: 20px; padding-top: 20px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="100%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r1-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i" style="padding-left: 15px; padding-right: 15px;">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r14-c" align="left">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r15-o" style="table-layout: fixed; width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" valign="top" class="r31-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; line-height: 1.4; word-break: break-word; padding-bottom: 15px; padding-top: 15px; text-align: left;">
                                                                                                    <div>
                                                                                                        <p style="margin: 0;">
                                                                                                            <?= l('emails_account_create.support', $data->language) ?>
                                                                                                        <p style="margin: 0;">
                                                                                                             </p>
                                                                                                        <p style="margin: 0;">
                                                                                                            <span style="font-size: 19px;">
                                                                                                                <?= l('emails_account_create.salutation_end', $data->language) ?> Online-QR-Generator
                                                                                                            </span>
                                                                                                        </p>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="" class="r0-c">
                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r32-o" style="table-layout: fixed; width: 100%;"><!-- -->
                    <tr class="nl2go-responsive-hide">
                        <td height="50" style="font-size: 50px; line-height: 50px;">­</td>
                    </tr>
                    <tr>
                        <td valign="top" class="r33-i" style="background-color: #EFF2F7;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                <tr>
                                    <td class="r3-c" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="600" class="r4-o" style="table-layout: fixed; width: 600px;"><!-- -->
                                            <tr>
                                                <td class="r34-i" style="padding-bottom: 55px; padding-top: 40px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                        <tr>
                                                            <th width="100%" valign="top" class="r6-c" style="font-weight: normal;">
                                                                <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r35-o" style="table-layout: fixed; width: 100%;"><!-- -->
                                                                    <tr>
                                                                        <td valign="top" class="r7-i" style="padding-left: 10px; padding-right: 10px;">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                <tr>
                                                                                    <td class="r11-c" align="center">
                                                                                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r9-o" style="table-layout: fixed; width: 100%;">
                                                                                            <tr>
                                                                                                <td align="center" valign="top" class="r28-i nl2go-default-textstyle" style="color: #3f3d56; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 20px; word-break: break-word; line-height: 1.3; text-align: center;">
                                                                                                    <div>
                                                                                                        <div class="sib_class_16_black_reg" style="color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 16px; word-break: break-word;">
                                                                                                            <span style="font-size: 17px;"><b>Online-QR-Generator.com</b></span>
                                                                                                        </div>
                                                                                                        <div class="sib_class_16_black_reg" style="color: #434343; font-family: Montserrat,Arial,Helvetica,sans-serif; font-size: 16px; word-break: break-word;">
                                                                                                            <a href="mailto:support@online-qr-generator.com" style="color: #3f3d56; text-decoration: none;"><span style="font-size: 12px;">support@online-qr-generator.com</span></a><br>
                                                                                                            <span style="font-size: 12px;">©
                                                                                                                <?php echo date("Y"); ?>,
                                                                                                                Online-QR-Generator
                                                                                                                <?= l('global.emails.all_rights', $data->language) ?>

                                                                                                            </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>