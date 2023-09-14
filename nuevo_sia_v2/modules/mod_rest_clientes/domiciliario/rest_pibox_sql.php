<!DOCTYPE html>
<html lang="en">
<head>
    <title>NUEVO SIA AGROCAMPO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<?php


require('../../../services/rest_pibox_service.php');/* IMPORTAMOS LA CLASE DE API_REST */
include('../../../environments/production.php');/* IMPORTAMOS LAS VARIABLES DE API_REST  */
include('../../../funciones.php');
require('../../../conection/conexion_sql.php');
require('funciones_dom.php');/* IMPORTAR FUNCIONES PARA ESTE MODULO */
// include_once( '../../services/json_formater_php.php' );/* IMPORTAMOS LA FUNCION JSON FORMATER */


session_start();
$con_sql = new con_sql( 'SQLFACTURAS' );
$con_sql->consultar("truncate table API_ASIGNACION");
$con = new API_REST();

/** hora  */
$hora = time();
$hora_actual =  date("Y-m-d H:i:s", $hora);


$apellido1     = $_POST['Apellido1'];
$apellido2     = $_POST['Apellido2'];
$nombre1       = $_POST['Nombre1'];
$nombre2       = $_POST['Nombre2'];
$Genero        = $_POST['Genero'];
$Fecha         = $_POST['Fecha'];
$Sanguineo     = $_POST['Sanguineo'];
// $empresa       = $_POST['empresa'];
$empresa       = 'PIBOX';
$nacionalidad  = $_GET['nacion'];

// echo "Hola Mensajero $empresa <br>";
// $status_permitidos =[0,1,5,6,7,4];
$status_permitidos =[1,5,6];
// $status_permitidos =[1];
$status_permitidos_nom =[
  0=>"Buscando conductor",
  1=>"Conductor en camino",
  5=>"Recogiendo paquete",
  6=>"Paquete a bordo",
  7=>"Entregando paquete",
  4=>"Pedido finalizado"
];

/** SECCION PARA INTEGRAR LOS REPARTIDORES DE PIBOX*/
 /* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
 /* ████████████████████████████████████████            PIBOX           ████████████████████████████████████████████████ */
 /* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
$end_point    = '?t=';
$rs 	      = API_REST::GET_BODY( $PROD_URL_PIBOX_BOOKING_ALL.$end_point, $PROD_TOKEN_PIBOX );
$array        = API_REST::JSON_TO_ARRAY( $rs );
echo "<br><span>PIBOX</span><br>";

  foreach ($array[data] as $key => $value) {
     // echo "<br>ESTADO FINALZIADO<br>";
     if(in_array(intval($value["status_cd"]),$status_permitidos)){
         $paquetes_q        = '';
         $cantidad_pedidos  = 0;
         $cedula            = $value[driver][fiscal_number];
         $fecha_ingreso     =  strval($value["updated_at"]);
         $id_pedido_prov    = $value["_id"];
         $nombre            = $value["driver"]["name"];
         $placa             = str_replace(' ','',$value["served_vehicle"]["plates"]);
         $celular           = $value["driver"]["phone"];

        //  echo "<img src=".$value["driver"]["photo_url"]." style="."height:90px;border-radius:40px;width: 80px;"."> ";
    //  echo "<br> 
    //  <details>
    //     <summary> ID_PEDIDO=> ".$value['_id']."</summary>"
    //     ."<br><label>ESTADO=> ".$value["status_cd"]." = ".$status_permitidos_nom[intval($value["status_cd"])] 
    //     ."</label><br> <label>CEDULA:".$value["driver"]["fiscal_number"]
    //     ."</label><br> <label>CELULAR:".$value["driver"]["name"]
    //     ."</label><br> <label>VEHICULO:".$value["served_vehicle"]["plates"]
    //     ."</label><br> <label>FECHA ACTUALZIACION: ".substr($value["updated_at"],0,10)
    //     ."</label><br> <label>CELULAR:".$value["driver"]["phone"]
    //     ."</label><br> <label>CANTIDAD:".count($value["stops"])
    //     ."</label><br> <label>PEDIDOS:<br>
    //     ";
        
    //     $cantidad_pedidos = count($value["stops"]);
        
    $contador_pib=1;
        foreach ($value["stops"] as $stop_key => $stop_value) {
            foreach ($stop_value["packages"] as $key => $value) {
                $contador_pib++;
                $paquetes_q .=strval($value["reference"].',') ;
                // echo '📦'.$value["reference"].'<br>';
            }
        }
        $paquetes_q   = substr( $paquetes_q,0,-1 );
        $contador_pib = intval($contador_pib);
    // echo"
    //     </details>
    //  ";    
         $consql =("insert into API_ASIGNACION (CEDULA,HORA_INGRESO,ESTADO,ID_PEDIDO_PROV,ID_PEDIDOS_AGRO,NOMBRE,PLACA,CELULAR,CANTIDAD_PED_AGRO,EMPRESA) values($cedula,'$fecha_ingreso','INGRESO','$id_pedido_prov','$paquetes_q','$nombre','$placa','$celular',$contador_pib,'PIBOX')");
         $con_sql->insertar($consql);
         echo"<br>";
    //  echo $consql;
   }
 }



 /* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
 /* ████████████████████████████████████████            RAPIBOY         ████████████████████████████████████████████████ */
 /* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */

/** ESPACIO PARA EL API DE RAPIBOY */

$end_point  = '/GetList';

$fechaactual = getdate();
$fecha       =  $fechaactual[year]."/".($fechaactual[mon])."/". ($fechaactual[mday]);
$data        = ["FechaDesde"=>"$fecha","FechaHasta"=>"$fecha"];
$rs 	     = API_REST::GET_BODY_HEADER($PROD_URL_RAPIBOY.$end_point, $PROD_TOKEN_RAPIBOY,$data );
$array       = API_REST::JSON_TO_ARRAY( $rs );


echo "<br> PEDIDOS RAPIBOY <br>" ;
$groupkey='IdMotoboy';
$n_array = groupArray($array,$groupkey);


foreach ( $n_array as $arr ) {
    $CONDUCTOR_DOCUMENTO = $arr[IdMotoboy ] ;
    if($CONDUCTOR_DOCUMENTO !=''){
    // echo "<details><summary>Repartidor : ".$arr[IdMotoboy ] ."</summary>";
         $CONDUCTOR_NOMBRE  ='';
         $id_reserva        ='';
         $paquetes          ='';
            foreach($arr[groupeddata] as $array_domi){
                
                if($array_domi[EstadoNombre]!='Entregado'){
                    
                    $CEDULA      = $array_domi[ DNI ]  ;   
    
                    $CONDUCTOR_NOMBRE = $array_domi[ Nombre ]  ;
                    $CONDUCTOR_NOMBRE = (eliminar_duplicados($CONDUCTOR_NOMBRE));
    
                    $telefono_rep     = $array_domi[ TelefonoRepartidor];
                    $telefono_rep     = eliminar_duplicados($telefono_rep);
                        
                    $fecha_act        = $array_domi[ UltimaActualizacion];
                    $fecha_act        = eliminar_duplicados($fecha_act);
                        
                    $PLACA            = $array_domi[Patente];
                    $PLACA            = eliminar_duplicados($PLACA );
                    $PLACA            = ($PLACA=='')?'SIN PLACA':str_replace(' ','',$PLACA) ;
                    $paquetes         .= $array_domi[ ReferenciaExterna ].',';
                    $id_reserva       .= $array_domi[ IdPedido ].',';
                   
                    // echo "📦".$array_domi[ ReferenciaExterna ]."<br>";    
                }
            }
            $paquetes = substr( $paquetes,0,-1 );
            // echo "Nombre  : $CONDUCTOR_NOMBRE       <br>
            //       Placa   : $PLACA                  <br>
            //       Telefono: $telefono_rep           <br>
            //       Fecha   : $fecha_act              <br>
            //      "; 
        // echo '
        // </details>
        // <br>';

        if($paquetes !=''){

                $cantidad_pedidos=count(explode(',',$paquetes));
                $consqlq =("insert into API_ASIGNACION (CEDULA,HORA_INGRESO,ESTADO,ID_PEDIDO_PROV,ID_PEDIDOS_AGRO,NOMBRE,PLACA,CELULAR,CANTIDAD_PED_AGRO,EMPRESA) values($CEDULA ,'$hora_actual ','INGRESO','$id_reserva','$paquetes','$CONDUCTOR_NOMBRE','$PLACA','$telefono_rep',$cantidad_pedidos,'RAPIBOY')");
                $con_sql->insertar($consqlq);
           }
    }

}



 /* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
 /* ████████████████████████████████████████            QUICK           ████████████████████████████████████████████████ */
 /* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
/** SECCION PARA INTEGRAR LOS REPARTIDORES DE QUICK
 *  select * from API_PAQUETES
 * 
 */

/**declaracion de variables */
$dias_resta = 1;
/**declaracion de variables */
echo " <br><span>QUICK</span><br> ";
$curl = curl_init();
curl_setopt_array( $curl, [
    CURLOPT_URL => "$PROD_URL_QUICK",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => [
        'Accept: */*',
        'ApiKey:'.$PROD_TOKEN_QUICK.'',
        'Content-Type: application/json',
        'event: vehicle.list'
    ],
] );
$response = $con->JSON_TO_ARRAY( curl_exec( $curl ) );
$err = curl_error( $curl );
curl_close( $curl );
if ( $err ) {
    echo 'cURL Error #:' . $err;
} else {
    /** SI LA RESPUESTA ES EXITOSA VEMOS EL RESULTADO Y LO TRATAMOS */
    foreach ( $response[ data ] as $k ) {
        // if ( strlen( $k[ plate ] ) <= 7 and $k[ plate ] == 'WLQ977' ) {
        if ( strlen( $k[ plate ] ) <= 7 ) {
            $placa = $k[ plate ];

            $consulta_sql       = ( "select * from API_PAQUETES where id NOT IN(1,2) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),7,2) ) = FORMAT(DATEADD(year, 0, GETDATE()), 'yy')and (substring(SUBSTRING(FECHA_REGISTRO,0,9),1,2) ) = month(GETDATE()) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),4,2) ) = (day(GETDATE())-$dias_resta) and PAQUETE like'%$placa%' order by FECHA_REGISTRO asc" );
            $consulta_sqls      = ( "select top 1 * from API_PAQUETES where id NOT IN(1,2) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),7,2) ) = FORMAT(DATEADD(year, 0, GETDATE()), 'yy')and (substring(SUBSTRING(FECHA_REGISTRO,0,9),1,2) ) = month(GETDATE()) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),4,2) ) = (day(GETDATE())-$dias_resta) and PAQUETE like'%$placa%' order by FECHA_REGISTRO asc" );

            $data_table_quick   = $con_sql->consultar( $consulta_sql );
            $data_table_quicks  = $con_sql->consultar( $consulta_sqls );
            
            $ORDEN_AGRO_F       = '';
            $PEDIDO_SERVICIO_F  = '';

            /** VALIDAMOS QUE LOS REGISTROS YA TIENEN ORDENES Y DESCARTAMOS TODO LO DIFERENTE A ASIGNADO */
            if ( intval( count( mssql_fetch_array( $data_table_quick ) ) )>1 ) {
                while ( $dt = mssql_fetch_array( $data_table_quick ) ) {
                    $data = json_decode( $dt[ 2 ], true );
                    $ORDEN_AGRO          = $data[ data ][ service_order ];
                    $PEDIDO_SERVICIO     = $data[ data ][ system_id ];
                    $ORDEN_AGRO_F       .= $ORDEN_AGRO.',';
                    $PEDIDO_SERVICIO_F  .= $PEDIDO_SERVICIO.',';
                }

                /** ESTE CICLO RECORRE LA INFORMACION ADICIONAL DEL LOS EMPLEADOS DE ESAS ORDENES */
                while ( $dts = mssql_fetch_array( $data_table_quicks ) ) {
                    $datas = json_decode( $dts[ 2 ], true );
                    $CONDUCTOR_NOMBRE    = $datas[ data ][ vehicle_user_name ];
                    $SERVICIO            = $data[ subscription_name ];
                    $EMPRESA             = $data[ company ];
                    $EMPRESA_ID          = $data[ company_id ];
                    $PEDIDO_ID           = $data[ transaction ];
                    $ORDEN_ESTADO        = $data[ data ][ current_status ];
                    $TAMAÑO_SERVCIO      = $data[ data ][ service_weight ];
                    $PLACA               = str_replace(' ','',$data[ data ][ vehicle_plate ]);
                    $CONDUCTOR_DOCUMENTO = $data[ data ][ vehicle_user_document ];
                    $CONDUCTOR_NOMBRE    = $data[ data ][ vehicle_user_name ];
                    $NRO_RUTA            = $data[ data ][ router_number ];
                    $FECHA_CREACION      = $data[ data ][ created_at ];
                }
           

                // echo "
                //         <details>
                //             <summary>PLACA     : $PLACA     </summary>
                //             EMPRESA_ID         : $EMPRESA_ID         <br>
                //             PEDIDO_ID          : $PEDIDO_ID          <br>
                //             PEDIDO_SERVICIO    : ".eliminar_duplicados( $PEDIDO_SERVICIO_F )."  <br>
                //             ORDEN_AGRO         : ".eliminar_duplicados( $ORDEN_AGRO_F )."       <br>
                //             ORDEN_ESTADO       : $ORDEN_ESTADO       <br>
                //             TAMAÑO_SERVCIO     : $TAMAÑO_SERVCIO     <br>
                //             CONDUCTOR_DOCUMENTO: $CONDUCTOR_DOCUMENTO<br>
                //             CONDUCTOR_NOMBRE   : $CONDUCTOR_NOMBRE   <br>
                //             NRO_RUTA           : $NRO_RUTA           <br>
                //             FECHA_CREACION     : $FECHA_CREACION     <br><br><br><br><br><HR>
                //         </details>
                //         <br>
                // ";
                $cantidad_pedidos = count(array_unique(explode(',',$ORDEN_AGRO_F)));
                $paquetes_qu      = eliminar_duplicados( $ORDEN_AGRO_F );
                $servicios        = eliminar_duplicados( $PEDIDO_SERVICIO_F );
                $celular='0000000000';

                $consql =("insert into API_ASIGNACION (CEDULA,HORA_INGRESO,ESTADO,ID_PEDIDO_PROV,ID_PEDIDOS_AGRO,NOMBRE,PLACA,CELULAR,CANTIDAD_PED_AGRO,EMPRESA) values($CONDUCTOR_DOCUMENTO,'$hora_actual ','INGRESO','$servicios','$paquetes_qu','$CONDUCTOR_NOMBRE','$PLACA','$celular',$cantidad_pedidos,'QUICK')");
                $con_sql->insertar($consql);
                echo"<br>";
            }
        }
    }
}






echo "Todo OK";
mssql_close();
?>

