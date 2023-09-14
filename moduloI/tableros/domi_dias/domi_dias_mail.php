<?
include ('../../../nuevo_sia_v2/conection/conexion_sql.php');
include("user_con.php");
include("../../../integrator_php/funciones.php");

$con_sql = new con_sql('sqlFacturas');

/* original
$destinatario = [
  'WEB'            =>['destino'=>'ventasweb@agrocampo.tienda','copia'=>['analista.estadistico@agrocampo.com.co','desarrollador2@agrocampo.com.co','analista.costos@agrocampo.com.co']]
  ,'CALLCENTER'    =>['destino'=>'jenny.cantor@agrocampo.com.co','copia'=>['juan.silva@agrocampo.com.co','desarrollador2@agrocampo.com.co']]
  ,'VENTA EXTERNA' =>['destino'=>'ricardo.ferro@agrocampo.com.co','copia'=>['desarrollador2@agrocampo.com.co']]
  ,'ALMACEN'       =>['destino'=>'william.castillo@agrocampo.com.co','copia'=>['flor.martinez@agrocampo.com.co','desarrollador2@agrocampo.com.co']]
];
*/


$destinatario = [
  'WEB'            =>['destino'=>'desarrollador2@agrocampo.com.co','copia'=>['cesar.torres@agrocampo.com.co','daniel.diaz@agrocampo.com.co']]
];
// ,'CALLCENTER'    =>['destino'=>'desarrollador2@agrocampo.com.co','copia'=>['cesar.torres@agrocampo.com.co','daniel.diaz@agrocampo.com.co']]
// ,'VENTA EXTERNA' =>['destino'=>'desarrollador2@agrocampo.com.co','copia'=>['cesar.torres@agrocampo.com.co','daniel.diaz@agrocampo.com.co']]
// ,'ALMACEN'       =>['destino'=>'desarrollador2@agrocampo.com.co','copia'=>['cesar.torres@agrocampo.com.co','daniel.diaz@agrocampo.com.co']]

$area_tok = [
 'ALMACEN'=>'6aaacef41ca892843921b67f3d810c2e',
 'CALLCENTER'=>'45323aae323bcd418a48000fa0f3fa77',
 'VENTA EXTERNA'=>'2456da3802bb9cca78ed50285dc48282',
 'WEB'=>'d925b5029c401ac9efacf2beae480ef9'
];

$hoy = date("Y-m-d");
$ahora = date("Y-m-d H:i");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));
$fecha      = date("Ymd");

/* REVISAMOS LAS AREAS QUE ESTAN LISTAS EN LA TBL_VIS_TABLERO */
$result = $con_sql->consultar("SELECT  DISTINCT TOP 1 SECTOR FROM TBL_VIS_TABLERO");
// $result = $con_sql->consultar("SELECT DISTINCT TOP 4 SECTOR FROM TBL_VIS_TABLERO");

/* TENERMOS LAS AREAS A ENVIAR */
while($area = mssql_fetch_array($result)){

  /* esta linea trae los correos que corresponden a cada area */
  $area_con        = $area[SECTOR];
  $cod_area_consul = mssql_fetch_array($con_sql->consultar("select VALOR from API_CONFIGURACION where DESCRIPCION like'CODIGO%' and CAMPO='$area_con ' "));
  $cod_area_consul = $cod_area_consul[0];
  $tok_area_mail   = $area_tok[$area_con];

  $destinatarios_area = $destinatario[$area_con];
  $destinatario_area  = $destinatarios_area['destino'];
  $copias             = $destinatarios_area['copia'];
  $asunto             = "$area_con Pedidos pendientes por Area";
  $cuerpo             = " 
  Buenos dias.
  <br>
  <br>
  Si haz recibido este mensaje eres lider o encargado, favor dar click en este enlace para descargar los pedidos pendientes por despachar de $area_con.<br>
  <br>
  <a href=\"sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias.php?to=$tok_area_mail&ar=$cod_area_consul\" style=\"width:10%;height:30%;background-color:lightgray;font-size:16px;border-radius:20px;padding:3px;border: lightgray 2px solid ;margin-bottom:10px;margin-top:10px;color:black;\">
  <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-file-arrow-right' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
   <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
   <path d='M14 3v4a1 1 0 0 0 1 1h4'></path>
   <path d='M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z'></path>
   <path d='M9 15h6'></path>
   <path d='M12.5 17.5l2.5 -2.5l-2.5 -2.5'></path>
  </svg>
  Ver tablero $area_con 
   </a> 
  <br>
  <br>
  <a href=\"sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias_csv.php?mail=SI&area=$area_con\" style=\"width:10%;height:30%;background-color:lightgray;font-size:16px;border-radius:20px;padding:3px;border: lightgray 2px solid ;margin-bottom:2px;color:black;\"  
  >
  <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-file-arrow-right' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
   <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
   <path d='M14 3v4a1 1 0 0 0 1 1h4'></path>
   <path d='M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z'></path>
   <path d='M9 15h6'></path>
   <path d='M12.5 17.5l2.5 -2.5l-2.5 -2.5'></path>
  </svg>
   Descargar Informe $area_con
   </a> 
  <br>
  <br>
  <br><label>Mensaje agrocampo</label><br>
  <img src=\"../../../nuevo_sia_v2/assets/images/logo_agro.png\"><br>
  ";
  /*
   echo "sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias_csv.php?mail=SI&area=$area_con";
   echo "http://sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias.php?to=$tok_area_mail&ar=$cod_area_consul";
   // echo "$destinatario_area <br> $copias <br> $cuerpo <br> $fecha <br> $asunto <br> <br> <br>";
   */
  envio_mail( $destinatario_area, $copias, $cuerpo, $fecha, $asunto );
}
odbc_close();				
?>
  
  