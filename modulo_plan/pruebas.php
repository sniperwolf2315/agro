<?php
function Encrypt($secret,$data) 
{  
    //Generate a key from a hash 
    $key = md5(utf8_encode($secret), true); 
    //$key = md5(utf8_encode($data), true); 
   
    //toma primero 8 bytes de $key and agrega estos al final de la llave $key. 
    $key .= substr($key, 0, 8); 

    //Pad for PKCS7 
    $blockSize = mcrypt_get_block_size('tripledes', 'ecb'); 
    $len = strlen($data); 
    $pad = $blockSize - ($len % $blockSize); 
    $data .= str_repeat(chr($pad), $pad); 
    
    //Encrypt data 
    $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb'); 

    return base64_encode($encData); 

}

//USUARIO(mayusculas), clave(minusculas)

//$Clave=Encrypt('GOMEZJ','2105');
//$Clave=Encrypt('CARDOZOJ','cardozoj');

$Clave=Encrypt('FACTURAS','grcp461036');
echo $Clave."<br>";

?>