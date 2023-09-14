<?php
function service_soap_agro( $url, $end_point, $parametros, $response ) {
    try {
        $client = new SoapClient( $url );
        $result = $client->$end_point( $parametros );
        $result = json_decode( json_encode( $result ), true );
        return $result;
    } catch ( SoapFault $e ) {
        echo $e->getMessage();
    }
}

function php_function_ejecutar_service_inventario( $codigo_producto, $copias ) {
    $url_service = 'http://192.168.6.68/WSInventario/WSInventario.asmx?WSDL';
    $parametros = array( 'code' => "$codigo_producto", 'Copias' => "$copias", 'Terminal'=>'WEB' );
    // $parametros = array( 'code' => "$codigo_producto", 'Copias' => "$copias" );
    $consulta_todo_el_reporte = service_soap_agro( $url_service, 'ImprimirItem', $parametros, 'ImprimirItemResult' );
    return $consulta_todo_el_reporte;
}

$rta_print = php_function_ejecutar_service_inventario( $_POST[ 'ean' ], $_POST[ 'nro_copias' ] );
if ($_POST['ean']!=' ' && $_POST['nro_copias' ]!= '' ) {
    echo $rta_print[ 'ImprimirItemResult' ];
    return;
}
/*
INSERT INTO [SqlInventario].[dbo].[invImpresion] (PGPRDC,PGSTAT,PGDESC,PCXPRC,PGPGRP,PUBLICO,PN2,IMPRIMIR,CTPCT1,IMPRESORA,TERMINAL) 
VALUES (5050050025002000107,' ','KIT SULFAMETOXAZOL TRIMETOPRIM 120ML PAG 2 LLEVE 3',5050050025002000107,'CPH','$57.000','$57.000',1,' ','DataWifi2','Pistola2');
*/


?>
