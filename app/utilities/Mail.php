<?php
/**
 * Created by PhpStorm.
 * UsersManager: jlbokass
 * Date: 24/01/2019
 * Time: 16:47
 */

namespace App\Utilities;

use Config\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public static function send($to, $subject, $text, $html)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings

            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = Config::SMTP_HOST;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = Config::USER_NAME;                 // SMTP username
            $mail->Password = Config::PASSWORD_MAIL;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = Config::SMTP_PORT;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(Config::USER_NAME, 'John');
            $mail->addAddress($to);               // Name is optional

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = $text;

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo htmlentities('Message could not be sent. Mailer Error: '), $mail->ErrorInfo;
        }
    }
}
