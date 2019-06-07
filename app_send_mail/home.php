<?php //processa_envio.php

require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";

require "../../app_send_email/sending_process.php";
?>
<html>
      <head>
        <title>App Send Email</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      </head>
      <body>
          <div class="container">

            <div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>

            <div class="row">
                <div class="col-md-12">
                    <?php if($message->status['codigo_status'] == 1){ ?>
                        <div class="container">
                            <h2 class="display-4 text-success">Sucesso</h2>    
                            <p class="text-success"><?=$message->status['descricao_status']?></p>
                            <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                        </div>
                    <?php } ?>



                    <?php if($message->status['codigo_status'] == 2){ ?>
                        <div class="container">
                            <h2 class="display-4 text-danger">Ops!</h2>    
                            <p><?=$message->status['descricao_status']?></p>
                            <a href="index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>
                        </div>
                    <?php } ?>

                </div>
            </div>


          </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      </body>
    </html>
    

<!-- /*
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
        $mail->SMTPDebug = false; //era 2                     // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  //Specify main and backup SMTP servers. no caso: https://support.google.com/a/answer/176600?hl=pt-BR  
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'guigoshow08@gmail.com';  //digitar email  SMTP username
        $mail->Password = 'kuiyml5q';  //digitar senha do email               SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('guigoshow08@gmail.com', 'guigoshow08gmail.com'); //digitar email, usuario
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
*/
     -->