<?php

namespace core\classes;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {

    public function send_verification_email($customer_email, $name, $purl) {

        $confirmation_link = APP_BASEURL . "?a=confirm_email&purl=" . $purl;

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
       
        try {
            // Configuraçãos do servidor de email
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = EMAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL_FROM;                     //SMTP username
            $mail->Password   = EMAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = EMAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Emissor e Receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($customer_email, ucfirst($name));     //Add a recipient

            // Conteúdo do email

            // Cabeçalho
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = APP_NAME . ' - Confirmação de Email';

            // Corpo
            $html = '<p>Seja bem vindo a nossa loja!</p>';
            $html .= '<p>Para acessar nossa loja, é necessário que verifique seu endereço de email.</p>';
            $html .= '<p>Clique no link abaixo para confirmar seu email.</p>';
            $html .= '<p><a href="'. $confirmation_link .'">LINK DE CONFIRMAÇÃO</a></p>';

            $mail->Body = $html; 
            $mail->AltBody = "Clique no link para confirmar seu email : {$confirmation_link}";

            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}