
<br>
<?php
// echo "se importo";
require( '../../../services/rest_pibox_service.php' );/* IMPORTAMOS LA CLASE DE API_REST */
require( '../../../environments/production.php' );/* IMPORTAMOS LAS VARIABLES DE API_REST  */
// require( '../../../conection/conexion_sql.php' );
include( '../../../funciones.php' );

$existen_pedidos=0;

$sql_con = new con_sql('sqlfacturas');
$end_point  = '?t=';
$rs 	      = API_REST::GET( $PROD_URL_PIBOX_BOOKING_ALL.$end_point, $PROD_TOKEN_PIBOX );
$array      = API_REST::JSON_TO_ARRAY( $rs );
echo '<br>PEDIDOS PIBOX: <br>';       


// $status_permitidos =[0,1,5,6,7,4];
$status_permitidos =[0,1,5,6];
$status_permitidos_nom =[
  0=>"Buscando conductor",
  1=>"Conductor en camino",
  5=>"Recogiendo paquete",
  6=>"Paquete a bordo",
  7=>"Entregando paquete",
  4=>"Pedido finalizado"
];
echo "<div>";
foreach ($array[data] as $key => $value) {
  // echo "<br>ESTADO FINALZIADO<br>";
  if(in_array(intval($value["status_cd"]),$status_permitidos)){
    $existen_pedidos ++;
    $paquetes='';
    $cedula = $value[driver][fiscal_number];
    $pedido = strval($value["_id"]);
    echo "
    <details>
    ";
    echo "<img class="."ph_rep"." src=".$value["driver"]["photo_url"]." style="."height:90px;border-radius:40px;width: 80px;"."> ";
    echo "<br> 
    <summary> ID_PEDIDO=> ".$value["_id"]
    ."</summary>
      <br> 
      <label>ESTADO=> ".$value["status_cd"]." = ".$status_permitidos_nom[intval($value["status_cd"])] 
    ."</label><br><label>CELULAR:".$value["driver"]["name"]
    ."</label><br><label>CEDULA:".$value["driver"]["fiscal_number"]
    ."</label><br><label>VEHICULO:".$value["served_vehicle"]["plates"]
    ."</label><br><label>FECHA ACTUALIZACIÓN: ".substr($value["updated_at"],0,10)
    ."</label><br><label>CELULAR:".$value["driver"]["phone"]
    ."</label><br><label>PEDIDOS:<br>";
      foreach ($value["stops"] as $stop_key => $stop_value) {
          foreach ($stop_value["packages"] as $key => $value) {
              $paquetes .=strval($value["reference"].'-') ;
              echo '📦'.$value["reference"].'<br>';
            }
      }
    echo"
    </details>
    <br>";
  }
}
  if ($existen_pedidos==0){
    echo "
    <br><span>No tenemos pedidos por ahora!</span><br>
    ";
  }

echo "</div>";
?>
<?php
    return; 
    exit;
    // echo "si se importo";
    
    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://integrations.picapdb.co/api/third/bookings?t=KkYjA-Y-tkCvSy3spy6-4X9FYvZ1mEYNHdJfBxTrfdwC-Q_3_nKjvQ",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Accept: */*"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    echo $response;
    }
?>