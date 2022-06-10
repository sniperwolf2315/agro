<?php
function remove_characters($str_cadena){
    // ARREGLO DE NO PERMITIDAS PARA LA BUSQUEDA
    $char_especial= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","´",">","<","-","_","�",'�',"/[^a-zA-Z0-9\_\-]+/",'à');
    // ARREGLO DE PERMITIDAS PERMITIDAS PARA LA BUSQUEDA
    $char_comun= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    /*  REEMPLAZAMOS LOS CARACTERES DE LA CADENA ORIGINAL */
    $str_cadena = str_replace($char_especial, $char_comun ,utf8_encode($str_cadena));
    /* CAMBIAMOS LAS MAYUSCULAS POR MINUSCULAS DE TODA LA CADENA*/
    // $str_cadena = strtolower($str_cadena);
    /* RETORNAMOS LA LA CADENA MODIFICADA*/
    return utf8_encode ($str_cadena);
}
   // echo remove_characters('esto es la prueba de comparacíon para mañana y Reemplazar mayúsculas y minusculas');
?>