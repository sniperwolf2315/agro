<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar pedido web</title>

  <!-- STILOS -->
  <link rel="stylesheet" type="text/css" href="ordenes.css" >
 

  <!-- LINK -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <!-- SCRIPT  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="ordenes.js"></script>  

</head>
<body>
<div class="container text-center">
<label for="formGroupExampleInput" class="form-label" style="color: lightgray">
    <strong>
    Estamos trabajando para mejorar, ahora implementando el servicio de consulta de guía Servientrega
    </strong> 
</label>
<br>
<label for="formGroupExampleInput" class="form-label"><strong> Tracking de pedido</strong> </label>
<form id="frm-factura" name="frm-factura" action="#" method="POST">
    <input type="text" id="num_orden" name="num_orden" class="num_orden border-1 border border-success rounded" placeholder="Ingrese número pedido web">
    <br>
    <input type="submit" value="Buscar pedido" id="buscar_pedido" name="buscar_pedido" onclick="viewspinner();">
</form>

<?php

/*
http://192.168.1.115/nuevo_sia_v2/modules/mod_magento/consulta_ordenes/
*/
if(!isset($_POST['num_orden']) || $_POST['num_orden']==''){
    echo "No se ha pasado ningun parametro";
    echo "<script> loadspinner('Sin resultados');</script> ";
    return;
    exit;
}
/*██████████████████████████████████████████████ LIBRERIAS RECURSOS ███████████████████████████████████████████████████████*/
include('../../../conection/conexion_sql.php');
include('../../../conection/conexion_ibs.php');
include('../../../environments/production.php');
include('../../../environments/develop.php');
include('../../../../general_funciones.php');
include('../../../functions/json_formater_php.php');

/*██████████████████████████████████████████████ LIBRERIAS RECURSOS ███████████████████████████████████████████████████████*/

/*██████████████████████████████████████████████ VARIABLES ███████████████████████████████████████████████████████*/
$fechaActual    = date( 'Ymd' );
$fechaActualcom = date( 'Y-m-d h:i:s' );
$ini_corte      = date( 'Ym', strtotime( $fechaActual.'- 2 month' ) ).'16';
$fin_corte      = date( 'Ym', strtotime( $fechaActual ) ).'15';
$url_pedido     = "";
$evidencia      = "";
/*██████████████████████████████████████████████ VARIABLES ███████████████████████████████████████████████████████*/

$conn= new con_sql();
$conn_ibs= new con_ibs('IBM-AGROCAMPO-P','ODBC','ODBC');
$status_permitidos_nom =[
    0=>"Buscando conductor",
    1=>"Conductor en camino",
    5=>"Recogiendo paquete",
    6=>"Paquete a bordo",
    7=>"Entregando paquete",
    4=>"Pedido finalizado"
  ];
?>
<?php

$numero_pedido_consulta = $_POST['num_orden'];

/* PROCEDEMOS A LLAMAR EL SERVICIO DE CONSULTA DE ORDENES*/
$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "http://".SERVERD."/nuevo_sia_v2/services/mg_consulta_ped.php?T=".TOKEN_SERVICE_MG."&ped=$numero_pedido_consulta",
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
    /* CONVERTIMOS LA RESPUESTA EN UN ARRAY Y PODER MANIPULAR */
    $responses  = json_decode($response,TRUE);
    $pedido     = $responses["agr-response"]["Pedido_pagina"];
    $orden      = $responses["agr-response"]["Orden_ibs"];
    $nombre     = $responses["agr-response"]["Nombre"];
    $documento  = $responses["agr-response"]["Documento"];
    $estado     = $responses["agr-response"]["Estado"];
    $existe_en  = $responses["agr-response"]["existe"];


    echo '
    <div class="card" style="width:100%;">
    <img class="card-img-top" src="../../../assets/images/logo_agro.png" alt="Agrocampo logo" id="logo" name="logo" style="width:10%;>
    <div class="card-body">
        <h5 class="card-title">PEDIDO</h5>
        <p class="card-text">Información del pedido </p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">Pedido pagina       : '.$pedido.'</li>
        <li class="list-group-item">Orden ibs           : '.$orden.'</li>
        <li class="list-group-item">Nombre cliente      : '.$nombre.'</li>
        <li class="list-group-item">Documento cliente   : '.$documento.'</li>
        <li class="list-group-item">Estado agrocampo    : '.$estado.'</li>
    ';

    if ($estado=='60-1 En ruta'){
    // if ($estado=='60 Facturado' || $estado=='60-1 En ruta'){
        $fecha_despacho        = $responses["agr-response"]["Transporte"]["Fecha"];
        $factura_despacho      = $responses["agr-response"]["Transporte"]["Factura"];
        $direccion_despacho    = $responses["agr-response"]["Transporte"]["Direccion"];
        $ruta_despacho         = $responses["agr-response"]["Transporte"]["Ruta"];
        $guia_despacho         = $responses["agr-response"]["Transporte"]["Guia"];
        
        $lleva_agro =  mssql_fetch_array($conn->consultar("SELECT count(*) as total from facRegistroFactura where Factura='$factura_despacho' order by fecha desc"));
       
        /* SE LA LLEVA CONDUCTOR DE AGROCAMPO */
        if($lleva_agro[0]==1){
            $datos_evio =  mssql_fetch_array($conn->consultar("SELECT *  from facRegistroFactura where Factura= '$factura_despacho' order by fecha desc"));
            $direccion_despacho = $datos_evio[23];
            $estado_servicio= "Agendado - Despachado "; 
            $empresa_responsable = "AGROCAMPO";        
            
            /* se lo lleva el tercero */
            $lo_lleva_otro =  mssql_fetch_array($conn->consultar("SELECT EMPRESA FROM API_REPARTIDORES where PEDIDO like '%$factura_despacho%'"));
            $emp_tercero = $lo_lleva_otro[0];
            
        }else{
        /* SE VALIDA SI SE LA LLEVA UN TERCERO */            
            $esta_pendiente =  mssql_fetch_array($conn->consultar("SELECT count(*) as total  from API_ASIGNACION where ID_PEDIDOS_AGRO like'%$factura_despacho%'"));

            if($esta_pendiente[0]!=0){
                /* SI EL RESULTADO ES > 0 QUIERE DECIR QUE ESTA EN LA TABLA DE LOS REPARTIDORES POR TERCEROS */
                // $estado_servicio="Aun no esta agendado "; 
                if($factura_despacho==''){
                    echo "Sin asiganción de domicilio";
                }else{
                    $estado_servicio= "Agendado para un tercero "; 
                    $empresa =  mssql_fetch_array($conn->consultar("SELECT EMPRESA,PLACA,CELULAR,NOMBRE  from API_ASIGNACION where ID_PEDIDOS_AGRO like'%$factura_despacho%'"));
                }
            }
        }
        
        /* ██████████████████████████████████████████████████████████████████████████████████████████████████████ */
        /* API RAPIBOY */
        include("../../../functions/tracking_rapiboy.php");
        $fecha_despacho_rapiboy = substr(str_replace("-","-",$fecha_despacho),0,11);
        $url_pedido_r = url_pedido_r($factura_despacho,$fecha_despacho_rapiboy);
        
        if(count($url_pedido_r)>0){
            echo '<li class="list-group-item">Empresa transporta:   RAPIBOY</li>';
            $url_pedido         = $url_pedido_r [0];
            $foto_evidencia     = $url_pedido_r [1];
            $estado_servicio    = $url_pedido_r [0]["estado"];
            $direccion_despacho = $responses["agr-response"]["Transporte"]["Direccion"]; 
            $num_guia           = "SIN GUIA";
        }
        
        /* ██████████████████████████████████████████████████████████████████████████████████████████████████████ */
        /* API PIBOX */
        include("../../../functions/tracking_pibox.php");
        $url_pedido_p = url_pedido_p($factura_despacho,$fecha_despacho,$fechaActualcom);
           
        if(count($url_pedido_p) >0){
            echo '<li class="list-group-item">Empresa transporta:   PIBOX</li>';

            $url_pedido         = $url_pedido_p [0];
            $foto_evidencia     = $url_pedido_p [1];
            $estado_servicio    = $url_pedido_p [0]["estado"];
            $direccion_despacho = $responses["agr-response"]["Transporte"]["Direccion"]; 
            $num_guia           = "SIN GUIA";
        }        
        
        /* ██████████████████████████████████████████████████████████████████████████████████████████████████████ */
        /* API SERVIENTREGA */
        include("../../../functions/tracking_servientrega.php");
        $url_pedido_s = url_pedido_s($numero_pedido_consulta);
        
        if(count($url_pedido_s)>3){
            echo '<li class="list-group-item">Empresa transporta:   SERVIENTREGA</li>';
            $direccion_despacho         = $url_pedido_s["DirDes"]; 
            $estado_servicio            = strlen($url_pedido_s["EstAct"])>0?$url_pedido_s["EstAct"]:'Sin movimientos registrados';
            $url_pedido['seguimiento']  = $url_pedido_s["Mov"];
        }
        /* ████████████████████████████████████████████ FOOTER CONTENT ██████████████████████████████████████████████████████████ */


        echo ' 
        <li class="list-group-item">Ruta             : '.$empresa_responsable.' '. $ruta_despacho.'</li>
        <li class="list-group-item">Fecha Despacho   : '.$fecha_despacho.'</li>
        <li class="list-group-item">Factura          : '.$factura_despacho.'</li>
        <li class="list-group-item">Direccion        : '.$direccion_despacho.'</li>
        <li class="list-group-item">Estado repartidor: '.$estado_servicio.'</li>
        ';
        /* SI EL SEGUMIENTO O RITA ESTA DIFERENTE A VACIO SE RECORREN LA CANTIDAD DE PASOS QUE CONTENGA EL XML DE SERVI ENTREGA */
        if($url_pedido['seguimiento']!=''){
                    if(is_array($url_pedido['seguimiento'])){
                    $movimientos_pedido = $url_pedido['seguimiento'];
                    $movimientos_pedido = $movimientos_pedido['InformacionMov'];
                    $contador = 1;
                        foreach ($movimientos_pedido as &$valores_movimientos) {
                            /* ESCENARIO PARA LOS CASOS DE SERVIENTREGA */
                            $movimiento      = $valores_movimientos["NomMov"];
                            $origen_mov      = $valores_movimientos["OriMov"];
                            $fecha_mov       = $valores_movimientos["FecMov"];
                            $descripcion_mov = $valores_movimientos["DesMov"];

                            echo "
                            <div class=\"container-fluid\" id= \"movimientos_pedidos\" name=\"movimientos_pedidos\">
                                <details>
                                <summary> Movimiento $contador</summary>
                                        <span> Movimiento             : $movimiento      </span>    <br>
                                        <span> Origen                 : $origen_mov      </span>    <br>
                                        <span> Fecha movimiento       : $fecha_mov       </span>    <br>
                                        <span> Descripción movimiento : $descripcion_mov </span>    <br>
                                </details>
                            </div>
                            ";
                            $contador++;
                        }
                        /* SE REALIZA ESTE PASO PARA INSETAR EN LA TABLA DE LOGS */
                        $url_pedido = json_encode($url_pedido['seguimiento']);
                    }else{
                        echo '<li class="list-group-item">Link seguimiento:<a href="'.$url_pedido['seguimiento'].'" target="_blank" > Seguir</a></li>';
                    }
            if($url_pedido['evidencia']!=''){
                /* SI  AÚN NO TIENE PRUEBA DE EVIDENCIA NO SE DEBE MOSTRAR  */
                $evidencia = ($url_pedido['evidencia']!='')?$url_pedido['evidencia']:'/nuevo_sia_v2/assets/images/SIN_FOTO_2.png';
                // echo '<li class="list-group-item">Foto evidencia: <br>  <a href="'.$url_pedido['evidencia'].'" target="_blank" ><img src="'.$url_pedido['evidencia'].'" width="20%" height="200px"> </a></li> ';
                echo '<li class="list-group-item">Foto evidencia: <br>  <a href="'.$evidencia.'" target="_blank" ><img src="'.$evidencia.'" width="20%" height="200px" style="border-radius:20px"> </a></li> ';
            }
        }

    }else{
        echo'</ul>';
    }
    echo '</div>';

     if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip_consulta = $_SERVER['HTTP_CLIENT_IP'];
     }else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip_consulta = $_SERVER['HTTP_X_FORWARDED_FOR'];
     }else{
        $ip_consulta = $_SERVER['REMOTE_ADDR'];
     }
    
    $JSON_RESPONSE =  '
    {
    "agr-response":{
        "Ip_consulta":"'.$ip_consulta.'",
        "Pedido_pagina":"'.$$pedido.'",
        "Orden_ibs":"'.$orden.'",
        "Nombre":"'.$nombre.'",
        "Documento":"'.$documento.'",
        "Estado agro":"'.$estado.'",
        "Transporte":{
            "Fecha":"'.$fecha_despacho.'",
            "Factura":"'.$factura_despacho.'",
            "Direccion":"'.$direccion.'",
            "Ruta":"'.$empresa_responsable.' '.$ruta_despacho.'",
            "Responsable_entrega":"'.$empresa_lleva.' '. $placa_lleva.' '.$nombre_completo.'",
            "Estado_domicilio":"'.$estado_servicio.'",
            "Link_seguimiento":"'.$url_pedido.'",
            "Evidencia":"'.$evidencia.'"            
            }
        }
    }';

    $insert_json = "'$JSON_RESPONSE'";
    $conn->consultar("insert into API_LOGS (DESC_LOG,VALOR_LOG,HORA_REGISTRO,SERVICIO_ORIGEN,IP_ORIGEN)VALUES('API_CONSULTA_ESTADO',$insert_json,getdate(),'SRV_MG_ORDENES_INT','$ip_consulta')");
    echo "<script>closespinner();</script> ";
}

unset($_POST['num_orden']);
?>

</div>

</body>
</html>

