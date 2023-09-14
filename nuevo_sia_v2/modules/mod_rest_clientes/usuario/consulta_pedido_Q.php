<br>
<?php
// echo "API consulta pedido quick";
include_once( '../../../services/rest_pibox_service.php' );
include( '../../../environments/production.php' );
include( '../../../funciones.php' );
require( '../../../conection/conexion_sql.php' );

echo '<br>PEDIDOS QUICK  :<br>';
$con  = new API_REST();
$conn = new con_sql( 'sqlFacturas' );


/**declaracion de variables */
$dias_resta = 1;
/**declaracion de variables */

$curl = curl_init();
curl_setopt_array( $curl, [
    CURLOPT_URL => "$PROD_URL_QUICK",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 5,
    CURLOPT_TIMEOUT => 40,
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

            $consulta_sql  = ( "select * from API_PAQUETES where id NOT IN(1,2) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),7,2) ) = FORMAT(DATEADD(year, 0, GETDATE()), 'yy')and (substring(SUBSTRING(FECHA_REGISTRO,0,9),1,2) ) = month(GETDATE()) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),4,2) ) = (day(GETDATE())-$dias_resta) and PAQUETE like'%$placa%' order by FECHA_REGISTRO asc" );
            $consulta_sqls = ( "select top 1 * from API_PAQUETES where id NOT IN(1,2) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),7,2) ) = FORMAT(DATEADD(year, 0, GETDATE()), 'yy')and (substring(SUBSTRING(FECHA_REGISTRO,0,9),1,2) ) = month(GETDATE()) and (substring(SUBSTRING(FECHA_REGISTRO,0,9),4,2) ) = (day(GETDATE())-$dias_resta) and PAQUETE like'%$placa%' order by FECHA_REGISTRO asc" );

            $data_table_quick = $conn->consultar( $consulta_sql );
            $data_table_quicks = $conn->consultar( $consulta_sqls );
            $ORDEN_AGRO_F = '';
            $PEDIDO_SERVICIO_F = '';

            /** VALIDAMOS QUE LOS REGISTROS YA TIENEN ORDENES Y DESCARTAMOS TODO LO DIFERENTE A ASIGNADO */
            if ( intval( count( mssql_fetch_array( $data_table_quick ) ) )>1 ) {

                while ( $dt = mssql_fetch_array( $data_table_quick ) ) {
                    $data = json_decode( $dt[ 2 ], true );
                    $ORDEN_AGRO         = $data[ data ][ service_order ];
                    $PEDIDO_SERVICIO    = $data[ data ][ system_id ];
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
                    $PLACA               = $data[ data ][ vehicle_plate ];
                    $CONDUCTOR_DOCUMENTO = $data[ data ][ vehicle_user_document ];
                    $CONDUCTOR_NOMBRE    = $data[ data ][ vehicle_user_name ];
                    $NRO_RUTA            = $data[ data ][ router_number ];
                    $FECHA_CREACION      = $data[ data ][ created_at ];
                }
           
                /* CUERPO DEL ESTOD DE LOS DOMICILIOS */
                echo "
                        <details>
                            <summary>PLACA     : $PLACA     </summary>
                            EMPRESA_ID         : $EMPRESA_ID         <br>
                            PEDIDO_ID          : $PEDIDO_ID          <br>
                        ";
                            // foreach ( explode(',',eliminar_duplicados( $PEDIDO_SERVICIO_F ))as $ped_agr) {
                            //     echo " $ped_agr <br>";
                            // }
                echo "      ORDEN_AGRO         : <br>";
                            foreach ( explode(',',eliminar_duplicados( $ORDEN_AGRO_F ))as $ord_agr) {
                                echo "📦 $ord_agr  <br>";
                            }

                echo "   <br>         
                            ORDEN_ESTADO       : $ORDEN_ESTADO       <br>
                            TAMAÑO_SERVCIO     : $TAMAÑO_SERVCIO     <br>
                            CONDUCTOR_DOCUMENTO: $CONDUCTOR_DOCUMENTO<br>
                            CONDUCTOR_NOMBRE   : $CONDUCTOR_NOMBRE   <br>
                            NRO_RUTA           : $NRO_RUTA           <br>
                            FECHA_CREACION     : $FECHA_CREACION     <br><br><br><br><br><HR>
                        </details>
                        <br>
                ";
            }
        }
    }
}
if (empty($response[ data ])){
    echo "
      <span>No tenemos pedidos por ahora.</span>
    ";
  }

echo '<br>';

?>