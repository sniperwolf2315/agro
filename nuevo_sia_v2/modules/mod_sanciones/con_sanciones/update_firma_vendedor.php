<?php
include('../../../conection/conexion_sql.php');


$id_registro    = $_GET['id_reg'];
$cod_usuario    = $_GET['cod_usuario'];
$fech_registro  = $_GET['fec_firma'];
$acepta         = $_GET['acepta'];
$comentario_obs = strtoupper($_GET['comentarios']);

$acepta= ($acepta=='SI')?'1':'0';


$con = new con_sql();
/*
if($cod_usuario =='CASTILLOW' || $cod_usuario =='MARTINEZF' ){
    */
if($cod_usuario =='RODRIGUEZJ' || $cod_usuario =='MARTINEZF' || $cod_usuario =='CIFUENTESE' ){
    $update_data_vendedor = ("UPDATE API_SANCIONES_AGRO SET si_no_administra='$acepta',firma_administra='$cod_usuario ADM',fecha_firma_admin='$fech_registro',san_activa=0,COMENTARIO_ADMIN='$comentario_obs',DATOS_ADMINISTRA='$cod_usuario' where id_san=$id_registro ");
}else{
    $update_data_vendedor = ("UPDATE API_SANCIONES_AGRO SET si_no_vendedor='$acepta',firma_vendedor='$cod_usuario',fecha_firma_vende='$fech_registro',COMENTARIO_VENDEDOR='$comentario_obs' where id_san=$id_registro  and DATOS_VENDE like'$cod_usuario%'");
}

/* SELECCIONAMOS EL UPDATE DE LAS FIRMAS EN BASE A  */
$con->insertar($update_data_vendedor);

echo "Procesado";
echo '<META HTTP-EQUIV="refresh" CONTENT="2; URL=index.php">';
?>