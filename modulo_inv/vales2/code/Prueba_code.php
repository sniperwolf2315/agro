<?php



    // Abrir el archivo en modo de sólo lectura:
    $archivo = fopen("tarea.txt","rb");
    if( $archivo == false ) {
      echo "Error al abrir el archivo";
    }
    else
    {
         $cadena1 = fread($archivo, 18); // Leemos un determinado número de caracteres
         rewind($archivo);   // Volvemos a situar el puntero al principio del archivo
         $cadena2 = fread($archivo, filesize("tarea.txt"));  // Leemos hasta el final del archivo
        if( ($cadena1 == false) || ($cadena2 == false) ){
            echo "Error al leer el archivo";
        }else{
            echo nl2br("El archivo .TXT fue abierto \n");
        }
    }
    // Cerrar el archivo:
    fclose($archivo);
    $pun = explode("url", $cadena2);
    $ur = explode(",", $pun[1]);
    $ur1 = explode("/", $pun[1]);
    
    $pun1 = explode("parentId", $pun[0]);
    $pun2 = explode(",", $pun1[1]);
    $pun3 = explode(":", $pun2[0]);
    //echo nl2br("jorge base1 // ".$ur1[4]." // jorge base2 <p>\n");
    echo nl2br("parentId: ".$pun3[1]."\n");


$id=$pun3;
$str = $ur1[4];
$res=base64_decode($str);
$input =$res;
$porciones = explode("}", $input);
$porciones1 = explode("a", $porciones[1]);
$porciones3 = explode(":", $porciones1[1]);
$porciones4 = explode(",", $porciones3[1]);
echo nl2br("valor encode: ".$porciones4[0]."\n");

?>