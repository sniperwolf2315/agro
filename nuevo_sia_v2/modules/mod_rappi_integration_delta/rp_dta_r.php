<!-- <meta http-equiv="refresh" content="30"> -->
<?php
/*
http://192.168.6.55/nuevo_sia_v2/modules/mod_rappi_integration_delta/rp_dta_r.php
*/
// echo 'RAPPI DELTA <br>';
require( '../../conection/conexion_ibs.php' );
require( '../../conection/conexion_sql.php' );
include( '../../../general_funciones.php');
include( './api_rappi.php');
include('class.log.php');

/**creamos le objeto que tiene la clase de coneción y consulta la vista de IBS */
$time_pre = microtime( true );
$con_ibs = new con_ibs( '', 'CONSULTA', 'CONSULTA' );
$con_sql = new con_sql( 'sqlFacturas' );

$fecha = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
$fecha->setTimezone(new DateTimeZone('Pacific/Chatham'));
$ip_consulta = getRealIP();
$hora_actual    =  $fecha->format('Y-m-d H:i:sP');
$ahora          = date( 'Y-m-d' );
$anio           = date( 'Y' );
$mes            = date( 'm' );
$dia            = date( 'd' );
$hora           = date( 'H' );
$min            = date( 'i' );
$rot_inventario = [];


$sql_ibs    = ( 'SELECT * FROM VISRAPPI02  order  by "Sku*" ');
$sql_ibs_1  = ( 'SELECT distinct * FROM VISRAPPI02  ');
/* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/
/* LA TABLA API_RAPPI_DELTA ES LA TABLA PRINCIPAL */
/* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/

/* API_RAPPI_DELTA_NEW TABLA DE COMPARACIÓN CONTRA LA ORIGINAL */
$con_sql->insertar("TRUNCATE TABLE API_RAPPI_DELTA_NEW" );
/* SI EL HORARIO ES ANTES DE LA MEDIA NOCHE EL CRON ACTUALIZA LA TABLA PRINCIPAL */
if($hora=='23' && $min>='58'){
// if($hora=='8'){
    $data_vis   = $con_ibs->conectar( $sql_ibs_1 );
    $con_sql->insertar( "TRUNCATE TABLE API_RAPPI_DELTA" );

    /* SECCION PARA LLENAR LA TABLA API_RAPPI_DELTA TABLA PRINCIPAL Y PODER IDENTIFICAR CAMBIOS EN EL INVENTARIO a las  */
    while( $as_1 = odbc_fetch_array( $data_vis ) ) {
        $sku    = str_replace( '"', '', $as_1[ 'Sku*' ] );
        $ref    = str_replace( '"', '', $as_1[ 'Referencia Aliado' ] );
        $desc   = str_replace( '"', '', $as_1[ 'NOMBRE' ] );
        $stock  = str_replace( '"', '', $as_1[ 'Stock*' ] );
        $con_sql->insertar( "INSERT INTO API_RAPPI_DELTA (SKU,REFERENCIA,DESCRIPCION,CANTIDAD,FECHA_INGRESO) VALUES ( $sku,'$ref','$desc',$stock,getdate()) " );
    }
}

$data_vis   = $con_ibs->conectar( $sql_ibs );
    /* SECCION PARA LLENAR LA TABLA API_RAPPI_DELTA_NEW TABLA DE COMPARACIÓN Y PODER IDENTIFICAR CAMBIOS EN EL INVENTARIO */
    while( $as = odbc_fetch_array( $data_vis ) ) {
        $sku    = str_replace( '"', '', $as[ 'Sku*' ] );
        $ref    = str_replace( '"', '', $as[ 'Referencia Aliado' ] );
        $desc   = str_replace( '"', '', $as[ 'NOMBRE' ] );
        $stock  = str_replace( '"', '', $as[ 'Stock*' ] );
        // echo "$sku,'$ref','$desc',$stock <br><br>";
        $con_sql->insertar( "INSERT INTO API_RAPPI_DELTA_NEW (SKU,REFERENCIA,DESCRIPCION,CANTIDAD,FECHA_INGRESO) VALUES ( $sku,'$ref','$desc',$stock,getdate()) " );
    }

/* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/
                                /* SECCION PARA LLENAR LA TABLA API_RAPPI_DELTA Y PODER IDENTIFICAR CAMBIOS EN EL INVENTARIO */
/* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/
/* Vamos a recorrer LA TABLA HISTORIA PARA VER SI HAN CAMBIADO LOS PRODCUTOS CONTRA LA CONSULTA DE IBS */
$sql_inv_old = ( 'SELECT SKU,REFERENCIA,DESCRIPCION,CANTIDAD,FECHA_INGRESO FROM API_RAPPI_DELTA' );
$con_item = $con_sql->consultar( $sql_inv_old );

while( $d_rp_d = mssql_fetch_array( $con_item ) ) {
    $sku_sql   = str_replace( '"', '', $d_rp_d[ 'SKU' ] );
    $ref_sql   = str_replace( '"', '', $d_rp_d[ 'REFERENCIA' ] );
    $desc_sql  = str_replace( '"', '', $d_rp_d[ 'DESCRIPCION' ] );
    $stock_sql = str_replace( '"', '', $d_rp_d[ 'CANTIDAD' ] );
    $date_sql  = str_replace( '"', '', $d_rp_d[ 'FECHA_INGRESO' ] );
    
    /** CONSULTAMOS LOS PRODUCTOS DE LA TABLA HISTORICA Y CONSULTAMOS LA VISTA DE IBS */
    $data_vist_2   = $con_sql->consultar( 'SELECT * FROM API_RAPPI_DELTA_NEW WHERE SKU = '."'".$sku_sql."'".'' );
    
    while( $comparar = mssql_fetch_array( $data_vist_2 ) ) { /* RECORRER SQLSRV */
        $sku_ibs    = $comparar[ 'SKU' ];
        $ref_ibs    = $comparar[ 'REFERENCIA' ] ;
        $desc_ibs   = $comparar[ 'DESCRIPCION' ];
        $stock_ibs  = $comparar[ 'CANTIDAD' ];

        /** SI CUMPLE LA CONDICION QUE EL CODIGO, NOMBRE, LA DESCRIPCION Y LA CANTIDAD SEA DIFERENTE SE INSERTA EN UN ARREGLO */
        if($sku_sql   ==  $sku_ibs && $ref_sql   ==  $ref_ibs && $desc_sql  ==  $desc_ibs && $stock_sql !== $stock_ibs   ){
        // echo "<br> ESTE ES EL SKU SQL-> ".$sku_ibs.' | '.$ref_ibs.' | '.$desc_ibs.' | '. $stock_ibs   .'<br>';
            array_push($rot_inventario,array("sku"=>$sku_ibs,"ref"=>$ref_ibs,"desc"=>$desc_ibs,"stock"=>$stock_ibs));
        }
    }
}
        if(count($rot_inventario)==0){
            $insertar_es= "no hay datos para insertar";
        }else{
            $insertar_es= json_encode($rot_inventario);
        }

        $log = new Log("log_$ahora", "../../log/");
        $log->insert($insertar_es.' Time:'.$hora.':'.$min);

/* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/
/* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/

foreach($rot_inventario as $data){
    if(count($rot_inventario)<=1){
        $sk="'\"".$data[sku]."\"'";
        $re="'\"".$data[ref]."\"'";
        $de="'\"".$data[desc]."\"'";
        $st="'\"".$data[stock]."\"'";
    }else{
        $sk.=",'\"".$data[sku]."\"'";
        $re.=",'\"".$data[ref]."\"'";
        $de.=",'\"".$data[desc]."\"'";
        $st.=",'\"".$data[stock]."\"'";
    }
    // echo "vlr ==S> $sk $re $de $st ";
    $sk = substr($sk,1);
    $re = substr($re,1);
    $de = substr($de,1);
    $st = substr($st,1);
}
/* ███████████████████████████████████████████████████████████ RONDAS A ITERAR ██████████████████████████████████████████████████████████████████████████████████████████████*/

$rondas_x_tienda =('SELECT DISTINCT "Tienda" FROM VISRAPPI02 ORDER BY "Tienda" ');
$rondas_x_tienda = $con_ibs->conectar( $rondas_x_tienda );
while($rondas = odbc_fetch_array($rondas_x_tienda)){
    $tienda_round =  $rondas['Tienda'];
    $sql_ibs =('SELECT * FROM VISRAPPI02 WHERE "Sku*" in(\''.$sk.') AND "Referencia Aliado" IN (\''.$re.')  and "Tienda" = \''.$tienda_round.'\' order BY "Tienda"');
    /* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/
    // $sql_ibs =('SELECT * FROM VISRAPPI02 WHERE "Sku*" in(\''.$sk.') AND "Referencia Aliado" IN (\''.$re.')  order BY "Tienda"');
    $data_vis_1 = $con_ibs->conectar( $sql_ibs );


    /* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/
                                        // CREAMOS EL CUERPO DEL JSON QUE VAMOS A NEVIAR A RAPPI DELTA
    /* █████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████*/

    $json_export = ["empresa"=>"agrocampo","servicio"=>"agro_rappi_delta","hora"=>$ahora.' '.$hora.':'.$min,"type"=>"delta","records"=>array()];
    while($as_x = odbc_fetch_array($data_vis_1)){
        
        array_push( $json_export['records'],array(
            "id"                    => str_replace('"',"",$as_x['Sku*']),
            "name"                  => remove_characters(str_replace('"',"",$as_x['NOMBRE'])),
            "trademark"             => str_replace('"',"",$as_x['Marca']) ,
            "stock"                 => intval(str_replace('"',"",$as_x['Stock*'])),
            "store_id"              => str_replace('"',"",$as_x['Tienda']),
            "price"                 => intval(str_replace('"',"",$as_x['Precio Por Tienda'])),
            "discount_price"        => intval(str_replace('"',"",$as_x['Precio Por Tienda'])),
            "sale_type"             => "U",
            "is_available"          => null,
            "image_URL"             => "web-page",
            "description"           => "XXXXXXX"
        
    ));
    }
    
    /**  ACTUALIZAMOS LA TABLA EN BASE AL ULTIMO AJUSTE EN LA ROTACION DEL INVENTARIO */
    foreach($rot_inventario as $data_sql){
        $sk_s=$data_sql[sku];
        $re_s=$data_sql[ref];
        $de_s=remove_characters($data_sql[desc]);
        $st_s=$data_sql[stock];
        // echo "<br> update API_RAPPI_DELTA set cantidad =$st_s where SKU='$sk_s' and REFERENCIA='$re_s' and descripcion ='$de_s' ".'<br>';
        $con_sql->insertar("update API_RAPPI_DELTA set cantidad =$st_s where SKU='$sk_s' and REFERENCIA='$re_s' and descripcion ='$de_s'" );
        
    }
    /** SI LA CONTADOR DEL ARRAY ES > 1 MOSTRAMOS Y ENVIAMOS LA INFORMACIÓN A LA API DE RAPPI DELTA */
    if(count($json_export['records'])>=1){
        include_once("api_rappi.php");
        $RAPPI_DELTA_ARRAY = json_encode($json_export, true);
        $envio_inventario = post_rappi($RAPPI_DELTA_ARRAY);
        // echo "$envio_inventario <br><br>";
         $con_sql->insertar("INSERT INTO API_LOGS(DESC_LOG,VALOR_LOG,HORA_REGISTRO,SERVICIO_ORIGEN,IP_ORIGEN)VALUES('API_RAPI_DELTA','".json_encode($json_export)."',GETDATE(),'INSERT_STOCK_RAPPI_DELTA','$ip_consulta')");
         $con_sql->insertar("INSERT INTO API_LOGS(DESC_LOG,VALOR_LOG,HORA_REGISTRO,SERVICIO_ORIGEN,IP_ORIGEN)VALUES('API_RAPI_DELTA_RESPONSE','$envio_inventario',GETDATE(),'INSERT_STOCK_RAPPI_DELTA_RESPONSE','$ip_consulta')");
        //  echo"✔";
        }else{
            echo "✔ No hay rotación";
        }
}

mssql_close();
?>