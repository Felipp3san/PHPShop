<?php

namespace core\classes;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {

    public static function send_email($customer_email, $body, $subject) {

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
            $mail->addAddress($customer_email);     //Add a recipient

            // Conteúdo do email

            // Cabeçalho
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;

            // Corpo do email
            $mail->Body = $body; 

            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function send_verification_email($customer_email, $purl) {

        $confirmation_link = APP_BASEURL . "?a=confirm_email&purl=" . $purl;
        $subject = APP_NAME . ' - Confirmação de Email'; 

        // Corpo do email

        $html = '<p>Olá,</p>';
        $html .= '<p>Bem-vindo(a) à nossa loja! Estamos muito felizes em tê-lo(a) como parte da nossa comunidade.</p>';
        $html .= '<p>Para garantir a segurança da sua conta e proporcionar uma experiência personalizada, é necessário confirmar seu endereço de email.</p>';
        $html .= '<p>Por favor, clique no link abaixo para confirmar seu endereço de email e acessar nossa loja:</p>';
        $html .= '<p><a href="'. $confirmation_link .'">Clique aqui para confirmar seu email</a></p>';
        $html .= '<p>Se você não se cadastrou em nossa loja, por favor, ignore este email.</p>';
        $html .= '<p>Agradecemos por se juntar a nós e esperamos que aproveite a sua experiência de compras em nossa loja!</p>';
        $html .= '<p>Atenciosamente, ' . APP_NAME . '<br>';

        return self::send_email($customer_email, $html, $subject);
    }

    public static function send_recovery_email($customer_email, $purl) {

        $recuperation_link = APP_BASEURL . "?a=recovery&purl=" . $purl;
        $subject = APP_NAME . ' - Recuperar Acesso a Conta'; 

        // Corpo do email
        $html = '<p>Prezado(a) utilizador,</p>';
        $html .= '<p>Recebemos uma solicitação de recuperação de senha para a sua conta.</p>'; 
        $html .= '<p>Para garantir a segurança da sua conta, você precisará realizar uma mudança de senha.</p>';
        $html .= '<p>Por favor, clique no link abaixo para continuar com o processo de recuperação de senha:</p>';
        $html .= '<p><a href="'. $recuperation_link .'">Clique aqui para recuperar sua senha</a></p>';
        $html .= '<p>Se você não solicitou essa alteração de senha, ignore este email ou entre em contato conosco imediatamente.</p>';
        $html .= '<p>O link de recuperação expirará em [número de horas/dias], portanto, certifique-se de concluí-lo o mais rápido possível.</p>';
        $html .= '<p>Obrigado por escolher a ' .APP_NAME. '!</p>';

        return self::send_email($customer_email, $html, $subject);
    }
} 