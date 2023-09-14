<?php
// echo "llamamos funciones generales";

function remove_characters( $str_cadena )
 {
    // ARREGLO DE CARACTERES A BUSCAR
    $char_especial = array( '\u00e1' ,'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'À', 'Ã', 'Ì', 'Ò', 'Ù', 'Ã™', 'Ã ', 'Ã¨', 'Ã¬', 'Ã²', 'Ã¹', 'ç', 'Ç', 'Ã¢', 'ê', 'Ã®', 'Ã´', 'Ã»', 'Ã‚', 'ÃŠ', 'ÃŽ', 'Ã”', 'Ã›', 'ü', 'Ã¶', 'Ã–', 'Ã¯', 'Ã¤', '«', 'Ò', 'Ã', 'Ã„', 'Ã‹', '´', '>', '<', '-', '_', '�', '�', '/[^a-zA-Z0-9\_\-]+/', 'à');
    /* ARREGLO DE PERMITIDAS PARAEL REEMPLAZO */
    $char_comun    = array( 'a','a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'A', 'E', 'I', 'O', 'U', 'a' , 'e' , 'i' , 'o', 'u', 'c', 'C', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'u', 'o', 'O', 'i', 'a', 'e', 'U', 'I', 'A', 'E' );
    $str_cadena = str_replace( $char_especial, $char_comun, utf8_encode( $str_cadena ) );
    /*  REEMPLAZAMOS LOS CARACTERES DE LA CADENA ORIGINAL */
    // $str_cadena = strtolower( $str_cadena );
    /* CAMBIAMOS LAS MAYUSCULAS POR MINUSCULAS DE TODA LA CADENA*/
    /* RETORNAMOS LA LA CADENA MODIFICADA*/
    return utf8_encode( $str_cadena );
}
function getRealIP() {

    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    
    return $_SERVER['REMOTE_ADDR'];
    }
    

?>