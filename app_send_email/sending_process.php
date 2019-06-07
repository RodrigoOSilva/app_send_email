<?php //processa_envio.php

// require "./bibliotecas/PHPMailer/Exception.php";
// require "./bibliotecas/PHPMailer/OAuth.php";
// require "./bibliotecas/PHPMailer/PHPMailer.php";
// require "./bibliotecas/PHPMailer/POP3.php";
// require "./bibliotecas/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


    class Message {
        private $email = null;
        private $subject = null;
        private $message  = null;
        public $status  = ['codigo_status' => null, 'descricao_status' => ''];

        public function __get($attr){ //chama o valor do campo
            return $this->$attr;
        }

        public function __set($attr, $value){ //libeara a atribuição de valor 
            $this->$attr = $value;
        }

        public function validMessage(){
            if(empty($this->email) || empty($this->subject) || empty($this->message)){
                return false;
            } return true;
        }

    }

    $message = new Message();
    $message->__set('email', $_POST['email']); //atribui valor
    $message->__set('subject', $_POST['subject']); //atribui valor
    $message->__set('message', $_POST['message']); //atribui valor

    if(!$message->validMessage()){
        header('Location: index.php');
    }

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = false; //era 2, para debug                    // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';//smtp do gmail. para outra extençao, mudar o smtp. Specify main and backup SMTP servers. no caso: https://support.google.com/a/answer/176600?hl=pt-BR  
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'info@example.com';  //digitar email            SMTP username
        $mail->Password = '***';  //digitar senha do email               SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        // ***IMPORTANTE *** No gmail: > conta do google > segurança > Acesso a app menos seguro > habilitar.

        //Recipients
        $mail->setFrom('info@example.com', 'info@example.com'); //digitar email, usuario
        $mail->addAddress($message->__get('email'));     // Add a recipient
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com'); copia
        //$mail->addBCC('bcc@example.com'); copia oculta

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $message->__get('subject');
        $mail->Body    = $message->__get('message');
        $mail->AltBody = 'Erro: sem client que suporte HTML';

        $mail->send();
        $message->status['codigo_status'] = 1;
        $message->status['descricao_status'] = 'Email enviado com sucesso';
        
    } catch (Exception $e) {

        $message->status['codigo_status'] = 2;
        $message->status['descricao_status'] = 'Não foi possível enviar a mensagem. Detalhes do erro: ' . $mail->ErrorInfo;
        
    }

    // 1- adicionar metodo e name no formulário
    // 2 - criar classe para recebimento dos valores
    //     2.1 - atributos e métodos
    //     2.1.1 - atributos privados e métodos mágicos __get/set
    // 3- instanciar a classe
    // 4- setar dinamicamente o valor nas variaveis atravez dos métodos mágicos
    //     4.1 $className->__set('attrName', $_POST['nomeDoCampo']); //nomeDoCampo = indice do array
        

?>  
