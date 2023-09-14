<?php
/* CONSULTAMOS LA ULTIMA ORDEN CREAADA EN LA TABLA CREACIONENCABEZADOVENTA */

$consulta_ultima_orden = "SELECT top 1 sequence,CodigoMunicipalidad,Direccion,IDPedidoPagina as codigo from CreacionEncabezadoVenta where CodigoPosLupap='' order by Fecha desc";
$numero_sequence = (mssql_query($consulta_ultima_orden));
while ($pedido_cod = mssql_fetch_array($numero_sequence)){
    $numero_sequence  = $pedido_cod[0];
    $numero_postcode  = $pedido_cod[1];
    $numero_direccion = $pedido_cod[2];
    $numero_dpedpag   = $pedido_cod[3];
}

/* consultar ciudad y direccion en base a la orden magento  */
$dir_ciudad_magento = "SELECT Direccion,Ciudad FROM magento_orden  where sequence ='$numero_sequence'";
$ciudad_dir_magento =  mysqli_fetch_array(mysqli_query($mysqliL,$dir_ciudad_magento));
if (count($ciudad_dir_magento)==0){
    // echo "No se encontro <br>";
    echo ".<br>";

    $agrocodpost = mssql_fetch_array((mssql_query("select top 1 Ciudad from agrCodigoPostal where CodPostal='$numero_postcode'")));
        /* VALIDAR SI ESTE CODIGO POSTAL YA TIENE UNA DIRECCION REGISTRADA */
    if( count($agrocodpost[0]) == 0 ){
        // echo "No se encuentra en lupap y en ibs";
        $CODPOSTALUP_V2  ="";
        echo "..";
    }else{
        $ciudad_mag= $agrocodpost[0] ;
        $direc_mag = $numero_direccion ;
    }

}else{
    // echo "Si se ecncontro ";
    $ciudad_mag = str_replace('?','a',utf8_decode($ciudad_dir_magento[0]));
    $direc_mag  = str_replace('?','a',utf8_decode($ciudad_dir_magento[1]));
}
/* DESPUES DE ASIGANAR UNA DIRECCION Y UN BARRIO SI SE ENCUANTRA SE PASA A CONSULTAR A LUPAP */
$RESULT_LUPAP_V2       = geocode($ciudad_mag, $direc_mag);
$LATITUDLUPA_V2        = $_POST[latitud];
$LONGITUDLUPA_V2       = $_POST[longitud];
$LOCALIDADLUPA_V2      = utf8_decode($_POST[localidad]);
$DIRNORMALIZADALUPA_V2 =$_POST[dir_norm];
$CODPOSTALUP_V2        = $_POST[post_code];
$BARIOLUP_V2           = utf8_decode($_POST[barrio]);
$COD_CITY_V2           = $_POST[city_code];
/*
echo "
<BR>PED_PAG:   $numero_dpedpag  
<BR>PADMAG:    $numero_sequence 
<BR>CODPOSTAL: $numero_postcode 
<BR>DIRECCION: $numero_direccion
<BR>CODPOSTAL: $CODPOSTALUP_V2 
<BR>DIRNORMA   $DIRNORMALIZADALUPA_V2 
<BR>LATITUD:   $LATITUDLUPA_V2       
<BR>LONGITUD:  $LONGITUDLUPA_V2      
<BR>LOCALIDAD: $LOCALIDADLUPA_V2     
<BR>BARRIO:    $BARIOLUP_V2          
<BR>CODCIUDAD: $COD_CITY_V2          
<br>";
*/
if($CODPOSTALUP_V2==''){
    $CODPOSTALUP_V2="SIN_RUTA";
}

/* CON LA RESPUESTA DE LUPAP SE ACTUALIZAN LOS DATOS  */
$consulta_magento_lupap ="UPDATE CreacionEncabezadoVenta SET CodigoPosLupap = '$CODPOSTALUP_V2' where IDPedidoPagina=$numero_dpedpag and sequence=$numero_sequence ";
// echo "<br>$consulta_magento_lupap <br>";
mssql_query($consulta_magento_lupap);

?>