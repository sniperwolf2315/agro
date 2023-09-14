<?php
require( 'funciones.php' );
$destino    = ['desarrollador2@agrocampo.com.co','desarrollador2@agrocampo.com.co'];
$copias     = ['desarrollador2@agrocampo.com.co'];
$asunto     = 'Area de tecnologia pruebas de correo ';
$fecha      = date("Ymd");
$cuerpo     = 'Esto son unas pruebas de tecnologia, para validar servicio de correo <br> gracias por su colaboracion ';
envio_mail( $destino, $copias, $cuerpo, $fecha, $asunto );

?>
