<?php
// echo '<meta http-equiv="refresh" content="5;url=inicio.php".">';

// include_once '../../conection/conexion_sql.php' ;
// $conn       = new con_sql( '' );
// $data_arr   = $conn->consultar( "select top 5 * from API_REPARTIDORES where ESTADO in ('ESPERA','CARGA','SALIDA')" );



include_once '../../conection/conexion_ibs.php' ;




$csv_output = '';

$anio           = date( 'Y' );
$mes            = date( 'm' );
$dia            = date( 'd' );
$fecha_completa = date( 'Y-m-d_Hi' );
$envio_mail     = 'NO';
$cliente        = 'COASPHARMA';
/* ESTA SECCION VA A GENERAR EL CUERPO DEL CSSV CUANDO ENCUENTRA INFORMACION*/
// echo $_SERVER[ 'SERVER_NAME' ];

$host = $_SERVER[ 'HTTP_HOST' ];
$url = $_SERVER[ 'REQUEST_URI' ];
$url_actual = 'http://' . $host . $url;

while( $data = mssql_fetch_array( $data_arr ) ) {
    // echo $data[ 'CEDULA' ].','.$data[ 'NOMBRE_1' ].','.$data[ 'PLACA' ].','.$data[ 'PEDIDO' ]. '<br>';
    $csv_output .= $data[ 'CEDULA' ].','.$data[ 'NOMBRE_1' ].','.$data[ 'PLACA' ].','.$data[ 'PEDIDO' ]."\n";
    $envio_mail = 'SI';
}

if ( $envio_mail == 'SI' ) {
    require_once( '../../clases/PHPMail/funcion_mails.php' );
    /*HACEMOS USO DE LA FUNCION PARA CREAR UN CORREO CON EL LINK A VALIDAR LA ORDEN*/
    $destinatario = [ 'desarrollador2@agrocampo.com.co' ];
    $copia_a      = [ 'desarrollador2@agrocampo.com.co' ];
    $cuerpo       = "
    <h3>Integración Agrocampo - Coaspharma</h3>
    <span>
        Ha recibido este correo porque encontramos una OC para enviar al cliente $cliente<br>
        Favor dar click en el siguiente enlace para validar si es la correcta  y enviar.<br>
    </span>
    <a href=".'sia.agrocampo.vip/nuevo_sia_v2/modules/mod_integration_cph/cargar_info_cph.php'.">(CLICK AQUI)</a> 
    ";

    $asunto       = 'Integracion Agro-Coaspharma ';
    // envio_mail( $destinatario, $copia_a, $cuerpo, $fecha_completa, $asunto );

    // odbc_close();
    // $filename = 'ORDEN DE COMPRA'.$fecha_completa ;
    // header( 'Content-Type: application/force-download' );
    // header( 'Content-disposition: csv' .$filename. '.csv' );
    // header( 'Content-disposition: filename='.$filename.'.csv' );
    print $csv_output;
    // exit;
}
mssql_close();

?>