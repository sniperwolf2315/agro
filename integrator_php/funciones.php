<?php
//  echo 'ya pude llamar la func mail';

if(file_exists('../../modulo_magento/class/class.phpmailer.php') ){
    require( '../../modulo_magento/class/class.phpmailer.php' );
}else if(file_exists('../../../modulo_magento/class/class.phpmailer.php'))
    require( '../../../modulo_magento/class/class.phpmailer.php' );
else{
    require( '../modulo_magento/class/class.phpmailer.php' );
}

function envio_mail( $destino, $copias, $cuerpo, $fecha, $asunto ) {



    // include( '../modulo_magento/class/class.phpmailer.php' );
    $mail = new PHPMailer();

    //indico a la clase que use SMTP
    $mail->IsSMTP();

    //permite modo debug para ver mensajes de las cosas que van ocurriendo
    // $mail->SMTPDebug = 2;

    //Debo de hacer autenticación SMTP
    $mail->SMTPAuth = true;

    //indico el servidor para SMTP
    $mail->SMTPSecure = 'tls';

    $mail->Host     = 'mail.agrocampo.tienda';
    $mail-$Port     = 465;
    $mail->Username = 'no_responder@agrocampo.tienda';
    $mail->Password = 'Agro2022*';
    /*
    // indico un usuario / clave de un usuario
    
    
    $mail->Host     = 'smtp.gmail.com';
    $mail-$Port     = 587;
    $mail->Username = 'agrocamposistemas@gmail.com';
    $mail->Password = 'nzbtithexecegtdg';
    // $mail->Password = 'Colombia2021*';
    */

    // RESPONSABLE
    $mail->SetFrom( 'no_responder@agrocampo.tienda'," $asunto"," $fecha" );

    /* DESTINATARIOS*/

    // $con=0;
    // while($con<intval(count($destino))){
    //     $mail->AddAddress( "$destino[$con]" );
    //     $con++;
    // }
   
    $con=0;
    while($con<intval(count($copias))){
        $mail->addCC( "$copias[$con]" );
        $con++;
    }


    //copia
    // $mail->addCC( "$copias[1]" );

    // ASUNTO
    $mail->Subject = $asunto;

    // CONTENIDO DEL MAIL
    $mail->MsgHTML( "$cuerpo" );

    //indico destinatario
    // $address = 'desarrollador2@agrocampo.com.co';
    $address = $destino;

    $mail->AddAddress( $address, "Errores Integracion $fecha" );
    if ( !$mail->Send() ) {
        echo 'Error al enviar: ' . $mail->ErrorInfo;
    } else {
        echo 'Mensaje enviado!';
    }
}
?>
