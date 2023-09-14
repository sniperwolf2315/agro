<?php
/*
DESCRIPTION: ESTE SERVICIO SOLO DEBE EJCUTARSE A LA MEDIA NOCHE , LA INTECIÓN ES DE SOLO ALMACENAR EL HISTRICO DE LOS TERCEROS POR DÍAS PARA CONTINGENCIAS 

http://192.168.1.115/nuevo_sia_v2/services/srv_historico_domicilios.php
http://192.168.6.55/nuevo_sia_v2/services/srv_historico_domicilios.php
*/

// IMPORTAMOS LIBRERIAS 
include "../conection/conexion_sql.php";
include "../environments/production.php";

/* CONECTORES  */
$CONN = new con_sql('');

/* VARIABLES */
$fecha_hoy = date('Y/m/d');
$ulr_pibox = "https://integrations.picapdb.co/api/third/bookings?t=$PROD_TOKEN_PIBOX";




/* RAPIBOY */

$curl_r = curl_init();

curl_setopt_array($curl_r, [
  CURLOPT_URL             => "https://rapiboy.com/v1/NextDayBasic/GetList",
  CURLOPT_RETURNTRANSFER  => true,
  CURLOPT_ENCODING        => "",
  CURLOPT_MAXREDIRS       => 10,
  CURLOPT_TIMEOUT         => 30,
  CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST   => "GET",
  CURLOPT_POSTFIELDS      => "{\n  \"FechaDesde\": \"$fecha_hoy\",\n  \"FechaHasta\": \"$fecha_hoy\"\n}",
  CURLOPT_HTTPHEADER      => ["Accept: */*","Content-Type: application/json","Token: 64f7261e-26ec-44e7-8977-0055feaecaf7"],
]);

$response_r = curl_exec($curl_r);
$err_r = curl_error($curl_r);
curl_close($curl_r);

if ($err_r) {
  echo "cURL Error #:" . $err_r;
} else {
  // echo $response_r;
  $insert_rapiboy = "INSERT INTO API_LOGS(DESC_LOG,VALOR_LOG,HORA_REGISTRO,SERVICIO_ORIGEN,IP_ORIGEN) VALUES('API_RAPIBOY','$response_r',GETDATE(),'CONSULTA_HIST_SERVICIO_RAPIBOY','INTEGRA'); ";
  echo ($CONN->consultar($insert_rapiboy))?'1 <br>':"0 $err_r <br>";
  
}



/* PIBOX*/

$curl_p = curl_init();

curl_setopt_array($curl_p, [
  CURLOPT_URL            => "$ulr_pibox",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING       => "",
  CURLOPT_MAXREDIRS      => 10,
  CURLOPT_TIMEOUT        => 30,
  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST  => "GET",
  CURLOPT_HTTPHEADER     => ["Accept: */*"],
]);

$response_p = curl_exec($curl_p);
$err_p = curl_error($curl_p);

curl_close($curl_p);

if ($err_p) {
  echo "cURL Error #:" . $err_p;
} else {
  $insert_pibox = "INSERT INTO API_LOGS(DESC_LOG,VALOR_LOG,HORA_REGISTRO,SERVICIO_ORIGEN,IP_ORIGEN) VALUES('API_PIBOX','$response_p',GETDATE(),'CONSULTA_HIST_SERVICIO_PIBOX','INTEGRA'); ";
  echo ($CONN->consultar($insert_pibox))?'1 <br>':"0 $err_p<br>";
}
?>