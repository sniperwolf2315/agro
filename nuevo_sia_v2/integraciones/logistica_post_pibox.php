<?php
// http://192.168.1.115/nuevo_sia_v2/integraciones/logistica_post_pibox.php

// include 'mysqli.php';

// $mysqli = new mysqli('67.225.177.134', 'logistica_integra', 'He4tOno;eduY?*OwPxYM?i?3', '3306');
// phpinfo();



if (!function_exists('ssh2_connect')) { die('No existe la funcion ssh2_connect.');}
if (!($connection = ssh2_connect('67.225.177.134', 522))) { die('No se puede conectar con el servidor'); }

    return;














// 67.225.177.136 
$server     = '67.225.177.134' ;
$user       = 'logistica_integra' ;
$pass       = '@gro2023*%' ;
$bd         = 'logistica_integraciones' ;
$rta_consul = ''  ;

$connection = ssh2_connect('67.225.177.134', 522, array('hostkey'=>'ssh-rsa'));
if (ssh2_auth_pubkey_file($connection, 'username',
                          './id_rsa.pub',
                          './id_rsa', 'secret')) {
  echo "Public Key Authentication Successful\n";
} else {
    die('Public Key Authentication Failed');
}

return;




    $User = 'logistica'; 
    $Pass = 'He4tOno;eduY?*OwPxYM?i?3'; 
    $remotehost = '67.225.177.134'; 
    $host = '67.225.177.134';
    $Servidor = '67.225.177.134';
    $connection = ssh2_connect('67.225.177.134', '522');     
    if( !$connection ) {
        $connection.= "Connection failed ! <br> "; 
      }

      echo "$connection.";
     if (ssh2_auth_password($connection, 'logistica','He4tOno;eduY?*OwPxYM?i?3')) 
         {  
            echo "Conexion exitosa\n"; 
            print"<br><br>";
            if ($tunnel = ssh2_tunnel($connection, $host,'3306')){ 
             echo "Tunnel OK";
              print"<br><br>";
            }else{ 
                    echo "Fallo el Tunel.";
                } 
        }else{  
            die('Authenticacion Fallida...');  
        } 
   
  echo "Proceso terminado";  
  print"<br><br>";

$IdConexion = mysql_connect($Servidor, $User, $Pass) or die ("Error al Conectar!");
mysql_select_db($NombreBD, $IdConexion) or die ("Error con Base de Datos! Cinco");


$rows = mysqli_query("Select * from Logistica_logs");

while($a = mysqli_fetch_array($rows)){
    echo $a[0]."<br>";
}





return;
$connection = ssh2_connect('67.225.177.134', 522);
ssh2_auth_password($connection, 'logistica', 'He4tOno;eduY?*OwPxYM?i?3');
$tunnel = ssh2_tunnel($connection, '67.225.177.134', 3306);
$db = mysqli_connect('67.225.177.134', 'logistica_integra', '@gro2023*%', 'logistica_integraciones', 3306, $tunnel)or die ('Fail: '.mysql_error());



return; 




Shell_exec("ssh -f -L 67.225.177.134:522:67.225.177.134:3306 logistica@67.225.177.134 -i /home/usuario/.ssh/id_rsa sleep 60  >> /tmp/logfile");

$db = mysqli_connect("67.225.177.134", "logistica_integra", "@gro2023*%", "logistica_integraciones", 3306);
echo (!$db )?'No se pudo conectar':'Si se conecto';


$rows = mysqli_query("Select * from Logistica_logs");

while($a = mysqli_fetch_array($rows)){
    echo $a[0]."<br>";
}


print_r ( $rows);
return;



$con = ssh2_connect ( "67.225.177.134", 522);
ssh2_auth_password ($con, "logistica", "He4tOno;eduY?*OwPxYM?i?3");

$link = mysql_connect($server, $user , $pass);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_close($link);

// $conn = mysqli_connect( $server, $user, $pass ) or die("Sin conexion server");
//     if ( $conn ) {
//        $db =  mysqli_select_db( $conn , $bd )or die("Sin conectar a la BD");
//         $this->rta_consul = mysqli_query( $conn,$query_consulta )or die ("no se puedo ejecutar la consulta");
//         return ( $this->rta_consul ) ;
//     } else {
//         $this->rta_consul = '!Error no se puede conectar a la base de datos MYSQL'.mysqli_connect_error() ;
//     }
// mysqli_close( $conn );


// public function __construct( $base_datos ) {
//     $this->bd = $base_datos;
// }

// public function conectar( $query_consulta ) {
//     $conn = mysqli_connect( $this->server, $this->user, $this->pass) or die("Sin Conexion SERVER");
//     if ( $conn ) {
//        $db =  mysqli_select_db( $conn , $this->bd )or die("Sin conectar a la BD");
//         $this->rta_consul = mysqli_query( $conn,$query_consulta )or die ("no se puedo ejecutar la consulta");
//         return ( $this->rta_consul ) ;
//     } else {
//         $this->rta_consul = 'error no se puede conectar a la base de datos MYSQL'.mysqli_connect_error() ;
//     }
//     mysqli_close( $conn );
// }

// $mysqli->close();

// $curl = curl_init();

// curl_setopt_array($curl, [
//   CURLOPT_URL => "https://integrations.picapdb.co/api/third/bookings?t=KkYjA-Y-tkCvSy3spy6-4X9FYvZ1mEYNHdJfBxTrfdwC-Q_3_nKjvQ",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_HTTPHEADER => [
//     "Accept: */*",
//     "User-Agent: Thunder Client (https://www.thunderclient.com)"
//   ],
// ]);

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }


?>