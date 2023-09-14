<?php
// echo "ya pude llamar la func mail";
  function envio_mail($destino,$copias,$cuerpo,$fecha,$asunto){

    require_once('class.phpmailer.php');


    $mail = new PHPMailer();
    
    //indico a la clase que use SMTP
    $mail->IsSMTP();
    
    //permite modo debug para ver mensajes de las cosas que van ocurriendo
    $mail->SMTPDebug = 0;
    
    //Debo de hacer autenticación SMTP
    $mail->SMTPAuth = true;
    
    //indico el servidor para SMTP
    $mail->Host = "mail.agrocampo.tienda";

    //indico el puerto que usa el proveedor
    $mail-$Port = 465;
    //indico un usuario / clave de un usuario de gmail
    $mail->Username = "no_responder@agrocampo.tienda";
    $mail->Password = "Agro2022*";
    // RESPONSABLE
    $mail->SetFrom('no_responder@agrocampo.tienda', $asunto.$fecha);

    /* DESTINATARIOS*/
    $mail->AddAddress("$destino[0]");
    
    //copia
    $mail->addCC("$copias[0]");


    // ASUNTO
    // $mail->Subject = "Errores Integracion Magento-IBS";
    $mail->Subject = $asunto;

    // CONTENIDO DEL MAIL
    $mail->MsgHTML("$cuerpo");
    

    //indico destinatario
    $address = "desarrollador2@agrocampo.com.co";
    $mail->AddAddress($address, "Errores Integracion $fecha");
  
 
    if(!$mail->Send()) {
      echo "<br>Error al enviar: " . $mail->ErrorInfo;
    } else {
      echo "<br>Mensaje enviado!<br>";
    }
  }
?>
