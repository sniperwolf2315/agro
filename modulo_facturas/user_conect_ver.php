<? session_start();
$lOGin= sha1(date("Y-m-d:H"));  
$loginBO = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));

$pASs=  sha1(date("H:Y-m-d"));
$passBO = strtolower($_POST["$pASs"]);

//encrypta .NET
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
//$Clave=Encrypt('FACTURAS','grcp461036');

$claveEN=Encrypt($loginBO,$passBO);
//echo $Clave."<br>";

//CONECCION MSSSQL

$cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);


$sql ="select Login from autFuncionario WHERE Login ='$loginBO' AND Passwd = '$claveEN'";
$result = mssql_query($sql);
while($row = mssql_fetch_assoc($result)){
$emP = "DeNtR";
}
    

if($emP == "DeNtR" ){
    $_SESSION['usuARioF'] = $loginBO;
    $_SESSION['clAVeF'] = $passBO;
    
    header("location:index.php");
    }
    else{
    echo "<BR>".odbc_errormsg()."<BR><BR>El registro fallo<BR><BR><a href='user_conect.php' target='_self'><BR><BR> Click aca para Intentar loguearse de nuevo</a>";	
     die;
    }

?>
