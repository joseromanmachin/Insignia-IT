<?php
session_start();
$nombre = Trim(stripslashes($_POST['Nombre'])); 
$email = Trim(stripslashes($_POST['email'])); 
$comentario = Trim(stripslashes($_POST['mensaje'])); 
$asunto = "Contacto Web: ".Trim(stripslashes($_POST['asunto'])); 
$salt = 'D54C43B824AC3E305A5EBB282CBF33733DC112387EC92C633790BDF301AE855D'; 
$token = sha1($salt . $_SESSION['time']);

// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=no_confirmacion.html\">";
  exit;
}

////////////------------
if($token != $_POST['token']){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=no_confirmacion.html\">";
} else {
  $body = "<strong>Nombre:</strong> ".$nombre."<br /> 
  <strong>E-mail:</strong> ".$email."<br />
  <strong>Mensaje:</strong> ".$comentario;
  $text_body = "Nombre: ".$nombre."\r\n 
  E-mail: ".$email."\r\n
  Mensaje: ".$comentario;


  require_once('PHPMailer/class.phpmailer.php');
  //include("PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

  $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

  $mail->IsSMTP(); // telling the class to use SMTP

    $mail->Host       = "mail.insigniait.com.mx"; // SMTP server
    $mail->CharSet  = 'UTF-8';
    $mail->Encoding = 'quoted-printable';
    //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    //$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    //$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    //$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "webmaster@insigniait.com.mx";  // GMAIL username
    $mail->Password   = "yGrUbQfg";            // GMAIL password
    //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
    $mail->AddAddress('contacto@insigniait.com.mx', 'Contacto Insignia');
    $mail->SetFrom('webmaster@insigniait.com.mx', 'Notificaciones Web');
    $mail->AddReplyTo($email, $nombre);
    $mail->Subject = $asunto;
    $mail->AltBody = $text_body; // optional - MsgHTML will create an alternate automatically
    $mail->MsgHTML($body);
    $mail->Send();
    //echo "Message Sent OK</p>\n";

  // redirect to success page 
  if ($mail){
    print "<meta http-equiv=\"refresh\" content=\"0;URL=confirmacion.html\">";
  }
  else{
    print "<meta http-equiv=\"refresh\" content=\"0;URL=no_confirmacion.html\">";
  }
}
?>



