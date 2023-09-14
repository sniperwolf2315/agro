<?php
$fecha_ini = ( $_GET[ 'fi' ] );
$fecha_fin = ( $_GET[ 'ff' ] );

if ( strlen( $fecha_ini )<8 || strlen( $fecha_fin )<8 ) {
    echo 'las fechas no cumplen con las longitudes';
    return;
}
include_once( '../nuevo_sia_v2/conection/conexion_sql.php' );
$conn = new con_sql();

$fecha_ini = substr( $fecha_ini, 0, 4 ).'-'. substr( substr( $fecha_ini, -4, 4 ), 0, 2 ).'-'.substr( substr( $fecha_ini, -4, 4 ), 2, 2 ) ;
$fecha_fin = substr( $fecha_fin, 0, 4 ).'-'. substr( substr( $fecha_fin, -4, 4 ), 0, 2 ).'-'.substr( substr( $fecha_fin, -4, 4 ), 2, 2 ) ;
$fecha_ini = "$fecha_ini 00:00:00.000";
$fecha_fin = "$fecha_fin 23:59:00.000";

$json_export  = '';
$consulta_ind = '';

$consulta = ( "
SELECT
f.Cedula as Cedula, 
f.Nombres as Nombre,
f.Direccion as Direc,
f.Telefono as Tele, 
f.Fecha as Fecha, 
f.Valor as Valor, 
f.Factura as Fact, 
f.ConsecutivoCarga as Cnscrg, 
f.IdRuta as Ruta, 
f.IdDestino as IdDest,
f.Destino as Desti,
f.ShipmentNumber as Ship,
f.Orden as Orden,
c.Nombres as IdCond,
v2.placa as Placa,
f.Ingresa as Ingresa
FROM [sqlFacturas].[dbo].[facRegistroFactura] f
right join [sqlFacturas].[dbo].[facVehiculo] v2 ON f.IdVehiculo=v2.IdVehiculo
right join [sqlFacturas].[dbo].[facConductor] c ON f.IdConductor=c.IdConductor
WHERE 
Fecha >='$fecha_ini' and Fecha <='$fecha_fin'
order by f.Orden desc
" );

$consulta_ind = $consulta;
$consulta_ind = mssql_fetch_assoc( $conn->consultar( $consulta_ind ) );
foreach ( $consulta_ind as $k => $v ) {
    $json_export .= $k."*";
}
$json_export = substr($json_export,0,-1);
$json_export  .="\n";
$rta_consulta = ( $conn->consultar( $consulta ) );
while ( $data = mssql_fetch_array( $rta_consulta ) ) {
    $json_export .= $data[ 0 ] .'*'.$data[ 1 ] .'*'.$data[ 2 ] .'*'.$data[ 3 ] .'*'.$data[ 4 ] .'*'.$data[ 5 ] .'*'.$data[ 6 ] .'*'.$data[ 7 ] .'*'.$data[ 8 ] .'*'.$data[ 9 ] .'*'.$data[ 10 ].'*'.$data[ 11 ].'*'.$data[ 12 ].'*'.$data[ 13 ].'*'.$data[ 14 ].'*'.$data[ 15 ]."*".strval($data[ 16 ]).'*'."\n";
    $json_export = substr($json_export,0,-3);
    $json_export .="\n";
}
$conn->cerrar( $conn );
echo "";


$filename = "Facturas_Cargue_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header("Content-disposition: filename=".$filename.".csv");
print ($json_export);

?>