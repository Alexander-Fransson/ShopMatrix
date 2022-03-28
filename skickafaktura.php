<?php

/*---------------------------------
Send mail to every user every month
---------------------------------*/

$args = ['post_type' => 'customers',];
$date = getdate();
$query = new \WP_Query($args);

while($query->have_posts()): $query->the_post();

    $adress = get_field('shopaddress');
    $street = str_replace(',' , '<br>', $adress['address']) .'<br>'. str_replace(',' , '<br>', $adress['post_code']);

    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

    $html ='<!DOCTYPE html>

    <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>

            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <meta name="x-apple-disable-message-reformatting">

            <title></title>

            <!--[if mso]>
            <noscript>
                <xml>
                <o:OfficeDocumentSettings>
                    <o:PixelsPerInch>96</o:PixelsPerInch>
                </o:OfficeDocumentSettings>
                </xml>
            </noscript>
            <![endif]-->

            <style>
                table, td, div, h1, p {font-family: Arial, sans-serif;}
            </style>

        </head>

        <body style="margin:0;padding:0;">

            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">

                <tr>
                <td align="center" style="padding:0;">

                    <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">

                        <tr>
                            <td style="padding:36px 30px 42px 30px;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                
                                <!--Min Logo och rubrik-->

                                <tr>
                                <td style="padding:0;">
                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                    <tr>
                                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                                        <img src="https://shopmatrix54.com/wp-content/uploads/2021/11/KikstarterLogo-1.jpg" alt="the shopmatrix logo" width="100%">
                                        </td>

                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>

                                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                                        <h1 style="text-align:center;vertical-align:center;margin-top:115px;">Faktura</h1>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                                </tr>

                                <!--Kontacktuppgifter-->

                                <tr>
                                <td style="padding:0;">
                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                    <tr>
                                        <td style="width:173px;padding:0;vertical-align:top;color:#153643;">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Date: '.$date['mday'].'/'.$date['mon'].'-'.$date['year'].'<br>
                                            Billingnumber: '.rand(1,999999).'<br>
                                            User ID:'.get_the_ID().'<br>
                                            Shall be payed in 30 days                                                
                                        </p>
                                        </td>

                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>

                                        <td style="width:173px;padding:0;vertical-align:top;color:#153643;">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Our referens: Alexander Fransson <br>
                                            Your referens: '.get_field('email').'
                                        </p>
                                        </td>

                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>

                                        <td style="width:173px;padding:0;vertical-align:top;color:#153643;">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;text-align:right;">
                                            '.get_the_title().'<br>
                                            '.$street.'
                                        </p>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                                </tr>

                                <hr><!--Priser-->

                                <tr>
                                <td style="padding:0;">
                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                    <tr>
                                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Number of clicks:<br>
                                            Pric per click:<br>
                                            VAT:
                                        </p>
                                        </td>

                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>

                                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;text-align:right">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            '. (get_field('successfultransactions')) .' st<br>
                                            5 kr<br>
                                            0 kr<br>
                                        </p>
                                        <b style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Total:'. (get_field('successfultransactions')*5) .'kr 
                                        </b>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                                </tr>

                                <hr><!--Slut-->

                                <tr>
                                <td style="padding:0;">
                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                    <tr>
                                        <td style="width:520px;padding:0;vertical-align:top;color:#153643;">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Shop Matrix UF<br>
                                            Kronhusgatan 9 Göteborg<br>
                                            41105</p><br>

                                            VAT-number: No VAT-number due to registration as UF<br>

                                            Approved for F-tax<br>
                                            Bankgiro: 5781-8247<br>
                                        </p>
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
    </html>'; 

    mail( get_field('email') ,'Faktura', $html, $headers);
    mail( 'shopmatrix54@gmail.com' ,'Faktura', $html, $headers);

endwhile;