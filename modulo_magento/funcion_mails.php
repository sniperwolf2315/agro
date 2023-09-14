<?php
// echo "ya pude llamar la func mail";
  function envio_mail($destino,$copias,$cuerpo,$fecha){

    require_once('./class/class.phpmailer.php');


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
    // $mail-$Port = 587;
    //indico un usuario / clave de un usuario de gmail
    $mail->Username = "no_responder@agrocampo.tienda";
    $mail->Password = "Agro2022*";
    // RESPONSABLE
    $mail->SetFrom('no_responder@agrocampo.tienda', 'Errores Integracion '.$fecha);

    /* DESTINATARIOS*/
    $mail->AddAddress("$destino[0]");
    $mail->AddAddress("$destino[1]");
    $mail->AddAddress("$destino[2]");
    $mail->AddAddress("$destino[3]");
    
    //copia
    $mail->addCC("$copias[0]");
    $mail->addCC("$copias[1]");
    $mail->addCC("$copias[2]");
    // ASUNTO
    $mail->Subject = "Errores Integracion Magento-IBS";

    // CONTENIDO DEL MAIL
    $mail->MsgHTML("$cuerpo");
    

    //indico destinatario
    $address = "desarrollador2@agrocampo.com.co";
    $mail->AddAddress($address, "Errores Integracion $fecha");
  
    $address = "analista.estadistico@agrocampo.com.co";
    $mail->AddAddress($address, "Errores Integracion $fecha");
 
    $address = "analista.costos@agrocampo.com.co";
    $mail->AddAddress($address, "Errores Integracion $fecha");


    if(!$mail->Send()) {
      echo "<br>Error al enviar: " . $mail->ErrorInfo;
    } else {
      echo "<br>Mensaje enviado!<br>";
    }
  }
?>
