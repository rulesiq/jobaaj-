<?php
include "../db.php";

include_once('../../../../../vendor/autoload.php');
include_once('../../../../vendor/autoload.php');


date_default_timezone_set('Asia/Kolkata');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendPosts($db, $to)
{

    $m = mysqli_fetch_assoc(mysqli_query($db, "select * from mails order by id desc limit 1"));
    $subject = $m['subject'];
    $message = $m['message'];
    $post_ids = $m['post_id'];
    $data = '';

    $post = mysqli_query($db, "select * from st_post where id in($post_ids) ");
    while ($row = mysqli_fetch_assoc($post)) {
        $post_title = $row['post_title'];
        $post_content = substr(strip_tags($row['post_content']), 0, 150);
        $image = $row['thumbnail'];
        $post_slug = $row['post_name'];

        $category = mysqli_fetch_assoc(mysqli_query($db, "select * from blog_category where id='$row[cat_id]' "));
        $cat_title = $category['title'];
        $cat_slug = $category['slug'];

        $data .= " <tr>
                    <td style='padding: 1.5rem 0 1rem 0; border-bottom: 1px solid #e6e6e6;'>
                        <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td style='padding-bottom: 1rem;'>
                                    <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                                        <tr>
                                            <td style='padding-right: 1rem;'>
                                                <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                                                    <tr>
                                                        <td style='font-size: 1.3rem; font-weight: 600; padding-bottom: 0.3rem;'><a href='https://stories.jobaaj.com/$post_slug' style='text-decoration: none; color: #000;'>$post_title</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 1rem;'><a href='https://stories.jobaaj.com/$post_slug' style='text-decoration: none; color: #000;'>$post_content</a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <a href='https://stories.jobaaj.com/$post_slug' style='text-decoration: none; color: #000;'><img src='https://stories.jobaaj.com/files/manage/thumb/$image' style='width: 8rem; border-radius: 0.5rem;' alt=''></a>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class='card-footer'>
                                    <table>
                                        <tr>
                                            <td style='padding-right: 0.5rem;'>
                                                <a href='https://stories.jobaaj.com/category/$cat_slug' style='text-decoration: none; color: #000;'><img src='https://stories.jobaaj.com/files/manage/thumb/$image' style='width:2.5rem; height:2.5rem; border-radius: 2rem;' alt=''></a>
                                            </td>
                                            <td style='padding-right: 0.5rem; font-size:0.875rem; font-weight:600;'>
                                                <a href='https://stories.jobaaj.com/category/$cat_slug' style='text-decoration: none; color: #000;'>$cat_title</a>
                                            </td>
                                            <td style='padding-right: 0.5rem; font-size:0.875rem; font-weight:600;'>4 min read</td>
                                            <td style='padding-right: 0.5rem;'><img src='https://stories.jobaaj.com/files/manage/thumb/star-fill.svg' style='width: 1rem;' alt=''></td>

                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>";
    }


    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = 0;
        // $mail->isSMTP();                                            
        $mail->Host       = 'mail.jobaajlearnings.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'no-reply@jobaajlearnings.com';
        $mail->Password   = 'NOReply@12##21';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 465;

        $mail->setFrom('no-reply@jobaajlearnings.com', 'Jobaaj');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;


        $mail->Body = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
        <head>
            <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
                <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1' />
                <meta http-equiv='X-UA-Compatible' content='IE=edge' />
                <meta name='format-detection' content='date=no' />
                <meta name='format-detection' content='address=no' />
                <meta name='format-detection' content='telephone=no' />
                <meta name='x-apple-disable-message-reformatting' />
            <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap' rel='stylesheet'>
            <title>Email Template</title>
            <style>
             body{
                font-family: Helvetica,Arial,sans-serif;
             }
            </style>
        </head>
        <body>
            <table width='100%' style='margin-left:auto; margin-right:auto; width:100%; max-width:680px;' align='center' border='0' cellpadding='0' cellspacing='0' style='font-family: \"Poppins\", sans-serif;'>
                <tr>
                    <td>
                        <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td>
                                    <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                                        <tr>
                                            <td style='width:100%; text-align:center; padding-bottom:1rem;'>
                                                <img src='https://stories.jobaaj.com/files/manage/thumb/jobaaj-stories-iconhd.png' style='width:2.2rem;' alt='' />
                                                <span style='font-size:1.3rem; font-weight:700;'>Jobaaj Weekly Chirps</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size:1rem; text-align:center; padding-bottom:2rem; font-weight:500;'>Newsletter presented to you by Jobaaj Stories, the finance and story-telling arm of <a href='https://www.jobaaj.com/'>Jobaaj.com</a></td>
                                        </tr>
                                        <tr>
                                            <td style='background:#fafafa59; padding:2rem 1.5rem; border-top:1px solid #e6e6e6;'>
                                                <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                                                    <tr>
                                                        <td>
                                                            <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                                                                <tr>
                                                                    <td style='font-size: 1.4rem; padding-bottom: 1rem; border-bottom: 1px solid #000; font-weight: 600;'>Weekly Wrap-up</td>
                                                                </tr>

                                                                $data

                                                            </table>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-left:2rem; padding-right:2rem;'>
                                                <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
                                                    <tr>
                                                        <td style='font-size:0.9rem; padding-bottom:0.3rem;'>Hope you find this useful! ❤️</td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:0.9rem; padding-bottom:0.3rem;'>This was a special one time weekly news blast, but if you want to <strong>keep receiving these every week,</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:0.9rem; padding-bottom:0.3rem;'><a href='#'>Feel free to subscribe!</a></td>
                                                    </tr>

                                                </table>
                                            </td>
                                            <td >

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
        </html>";


        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        // $mail->send();
        if ($mail->send()) {
            echo "Mail has been sent successfully! on $to <br>";
        } else {
            echo "Mail has not been sent <br>";
        }
        // echo $mail->Body;
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$e->ErrorInfo}";
    }
}


function sendResearch($email, $db)
{

        $mail = new PHPMailer(true);
        try {

            $mail->SMTPDebug = 0;
            $mail->isSMTP();

        	require "../../../mail_send_credential.php";

            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Hello! Premium Subscriber - Jobaaj Stories';


            $mail->Body = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
            
            <head>
                <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
                <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1' />
                <meta http-equiv='X-UA-Compatible' content='IE=edge' />
                <meta name='format-detection' content='date=no' />
                <meta name='format-detection' content='address=no' />
                <meta name='format-detection' content='telephone=no' />
                <meta name='x-apple-disable-message-reformatting' />
                <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap' rel='stylesheet' />
                <title>Email Template</title>
            </head>
            <style>
                body{
                    font-family: Arial, Helvetica, sans-serif;
                }
            </style>
            <body style='background:#f3f7f5;'>
                <table width='100%' style='margin-left:auto; margin-right:auto; width:100%; max-width:680px;' align='center' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td style='margin: 0; padding: 0; width: 100%; height: 100%;' align='center' valign='top'>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tr>
                                    <td>
                                        <!-- Container -->
                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td>
                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td style='padding-top:20px; padding-bottom:5px; text-align:center;'>
                                                            <a href='https://employee.nishtyainfotech.com'>
                                                                <img class='logo' src='https://stories.jobaaj.com/assets/images/logo.png' width='100'>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding-top:5px; padding-bottom:20px; padding-left:20px; padding-right:20px;'>
                                                            <p style='line-height:40px;font-size:15px;'>
                                                                Keeping up with the Jobaaj Stories Starts Here <br>
                                                                Dear learner,<br>
                                                                You have successfully subscribed to our premium newsletter.<br>
                                                                Thanks for subscribing, it means a lot!!<br>
                                                                You have just entered the next level of Jobaaj stories. Here you will gain access to the most critical financial developments around the world, delivered to you in an easy and jargon-free format.<br>
                                                                But that's not the end of it!! <br>
                                                            </p>
                                                            <p style='line-height:40px;font-size:15px;'>
                                                             You will also receive access to the Premium E-Books on the financial markets! Click on the link below for the e-books:<br>

                                                            </p>
                                                            <p style='font-size:18px;'>
                                                                <a href='https://www.procapitas.com/course/free-e-books/66'>Read Free E-Books</a>
                                                            </p>
                                                             <p style='line-height:40px;font-size:15px;'>
                                                             Once again, thank you and welcome!!<br>
                                                                Warm Regards <br>
                                                                Jobaaj Group. 
                                                                </p>
                                                        </td>
                                                    </tr>
                                                    

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tr>
                                
                                  <td class='p-50 mpx-15'   style='border-radius: 0 0 10px 10px; padding: 50px;background: linear-gradient(to right,#4e4e4e 0%,#222a35 100%);'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                      <tr>
                                        <td align='center' class='pb-20' style='padding-bottom: 20px;'>
                                          <!-- Socials -->
                                          <table border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                              <td class='img' width='34' style='font-size:0pt; line-height:0pt; text-align:left;'>
                                                <a href='https://www.facebook.com/jobaaj.com95' target='_blank'><img src='https://jobaaj.com/mail/images/Facebook.png' width='34' height='34' border='0' alt='' /></a>
                                              </td>
                                              <td class='img' width='15' style='font-size:0pt; line-height:0pt; text-align:left;'></td>
                                              <td class='img' width='34' style='font-size:0pt; line-height:0pt; text-align:left;'>
                                                <a href='https://www.instagram.com/jobaaj.com_/' target='_blank'><img src='https://jobaaj.com/mail/images/Instagram.png' width='34' height='34' border='0' alt='' /></a>
                                              </td>
                                              <td class='img' width='15' style='font-size:0pt; line-height:0pt; text-align:left;'></td>
                                              <td class='img' width='34' style='font-size:0pt; line-height:0pt; text-align:left;'>
                                                <a href='https://www.linkedin.com/company/jobaaj-com' target='_blank'><img src='https://jobaaj.com/mail/images/linkedin-logo.png' width='50' height='50' border='0' alt='' /></a>
                                              </td>
                                              <td class='img' width='15' style='font-size:0pt; line-height:0pt; text-align:left;'></td>
                                              <td class='img' width='34' style='font-size:0pt; line-height:0pt; text-align:left;'>
                                                <a href='https://t.me/jobaaj' target='_blank'><img src='https://jobaaj.com/mail/images/telegram.png' width='34' height='34' border='0' alt='' /></a>
                                              </td>
                                              <td class='img' width='15' style='font-size:0pt; line-height:0pt; text-align:left;'></td>
                                              <td class='img' width='34' style='font-size:0pt; line-height:0pt; text-align:left;'>
                                                <a href='https://www.youtube.com/channel/UCwZd2VGQ-tHUgrhG5gJbT2A' target='_blank'><img src='https://jobaaj.com/mail/images/youtube.png' width='34' height='34' border='0' alt='' /></a>
                                              </td>
                                            </tr>
                                          </table>
                                          <!-- END Socials -->
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class='text-14 lh-24 a-center c-white l-white pb-20' style='font-size:14px; font-family:Arial, sans-serif; min-width:auto !important; line-height: 24px; text-align:center; color:#ffffff; padding-bottom: 20px;'>
                                          Nishtya Infotech Pvt. Ltd<br>
                                                  379, Vardhman Grand Plaza, Plot No.7, Manglam Place, Sector-3, Rohini, Delhi - 110085
                                        </td>
                                      </tr>
                                      <tr>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>											<!-- END Footer -->
                            
                            <!-- Bottom -->
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                  <tr>
                    <td class='text-12 lh-26 a-center' style='font-size:13px; color:#6e6e6e; font-family:`PT Sans`, Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:center;padding-bottom: 5px; padding-top:30px'>
                      You have received this mail because your e-mail is registered with Jobaaj.com. This is a system-generated e-mail regarding your account, please don't reply to this message.
                    </td>
                  </tr>
                  <tr>
                    <td class='text-12 lh-26 a-center' style='font-size:13px; color:#6e6e6e; font-family:`PT Sans`, Arial, sans-serif; min-width:auto !important; line-height: 26px;text-align:center; padding-bottom: 5px;'>
                      If you face any issues, please reach out to us at <a href='mailto:contact@jobaaj.com'><u>contact@jobaaj.com</u></a>
                    </td>
                  </tr>
                                <tr>
                                  <td class='text-12 lh-22 a-center c-grey- l-grey py-20' style='font-size:12px; color:#6e6e6e; font-family: `PT Sans`,Arial, sans-serif; min-width:auto !important; line-height: 22px; text-align:center; padding-top: 20px; padding-bottom: 20px;'>
                                  
                                    Copyright &copy; 2022 Nishtya Infotech Pvt.Ltd All right reserved.
                                  </td>
                                </tr>
                            </table>											<!-- END Bottom -->
                          </td>
                        </tr>
                      </table>
                                        
                                    
                                        <!-- END Container -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            
            </html>    
        ";
            $mail->AltBody = 'Body in plain text for non-HTML mail clients';
            // $mail->send();
            if ($mail->send()) {
                return 1;
            } else {
                return 2;
            }
            // echo $mail->Body;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$e->ErrorInfo}";
        }
    
}


//sendPosts($db, 'iqbalshah9368@gmail.com');
//sendPosts($db, 'Vaibhavsinghal17.10.2000@gmail.com');
// sendPosts($db, 'k.developer.x@gmail.com');
