<script>
// document.oncontextmenu = function(){return false;}
// document.onkeydown = function(){return false;}
</script>


<?php


echo'<script src="../../assets/js/funciones.js"></script>  ';
echo'<link href="carga.css" rel="stylesheet" title="Basic">';
include_once '../../conection/conexion_sql.php' ;
include_once '../../conection/conexion_ibs.php' ;
include_once '../../funciones.php' ;
require_once '../../clases/PHPMail/funcion_mails.php';

/** CONECTOR CON EL MOTOR */
$conn       = new con_sql( );

/* DECLARACION DE VARIABLES */
$csv_output                 = '';
$anio                       = date( 'Y' );
$mes                        = date( 'm' );
$dia                        = date( 'd' );
$fecha_completa_ibs         = date( 'Ymd' );
$fecha_completa_meso_1_dia  = date("Ymd",strtotime($fecha_completa_ibs."- 1 day"));
$fecha_completa             = date( 'Y-m-d_Hi' );
$envio_mail                 = 'NO';
$cliente                    = 'COASPHARMA';
$lista2                     = [array('producto', 'cantidad', 'precio', 'precio_total')];
$conn_i                     = new con_ibs('','');
$and_not_in                 = '';
$cliente                    = 'COASPHARMA';

/*
CREAMOS ESTA TABLA PARA REGISTRAR LAS ORDENES DESDE IBS EN ESTADO 20 QUE MSUARESZ HA CREADO PARA ENVIAR A COAPHARMA
Y QUE NO SE DEBEN DE REPETIR EN LA BUSQUEDA, LA VARIABLE $no_incluir CONTIENE EL LISTADO DE LAS ORDNEES QUE NO DEBEN DE CONSIDERAR EN LOS PROXIMOS BARRIDOS
*/
$no_incluir = $conn->consultar("select Num_orden from  sqlfacturas.dbo.agro_integaraciones_prov");

/* VAMOS A VALIDAR SI SE LE DEBE AGREAR A LA CONSULTA UN AND NOT IN 
!OJO! LA UNICA CONDICION QUE SEA EN BLANCO ES PORQUE SE VACIO LA TABLA agro_integaraciones_prov
*/
if(mssql_num_rows($no_incluir)==0){
     $and_not_in='';
}else{
    
    while($no_incl = mssql_fetch_array($no_incluir)){
        $ls_no_inc .= $no_incl[0].',';
    }

    $ls_no_inc = substr($ls_no_inc,0,-1);    
    $and_not_in="and SRBORPPL.OLORNO NOT IN($ls_no_inc)";
}

/** CONSULTA DE OC COMPRAS EN ESTADO 20 */

$data_arr_i   = $conn_i->conectar("SELECT
SRBORPPL.OLPRDC AS ITEM,
SRBPRG.PGDESC AS DESCRIPCION, 
SRBPRG.PGPGRP AS GRUPO, 
SRBORPPL.OLORNO AS ORDEN,
SRBORPPL.OLORDT AS TIPO_ORDEN,
SRBORPPL.OLORDS AS ESTADO,
SRBPOH.OHODAT AS FECHA_ORDEN,
SRBORPPL.OLDELT AS FECHA_ORDEN_LINEA, 
SRBORPPL.OLRDAT AS FECHA_INGRESO,
SRBORPPL.OLOQTY AS CANT_ORDEN,
SRBORPPL.OLRQTY AS CANT_RECIBO,
SRBORPPL.OLPURP AS COSTO_PROM,
SRBORPPL.OLAMOU AS COSTO_TOTAL
FROM SRBORPPL
LEFT JOIN SRBPRG ON SRBORPPL.OLPRDC=SRBPRG.PGPRDC
LEFT JOIN SRBPOH ON OHORNO=OLORNO 
WHERE (SRBORPPL.OLORDS IN ('20'))
AND (SRBORPPL.OLSUNO IN ('9002971538'))
AND (SRBORPPL.OLRDAT>=$fecha_completa_meso_1_dia AnD SRBORPPL.OLRDAT<=$fecha_completa_ibs)
AND SRBPOH.OHHAND ='SUAREZM'
$and_not_in
ORDER BY 9 desc
");


echo"
<div class='container_orden' id='container_orden' name='container_orden'>";
// echo "
// <table name='tbl_oc' id='tbl_oc' class='tbl_oc'>
   
//     <tr>
//         <td>ORDEN</td>
//         <td>ITEM</td>
//         <td>CANTIDAD</td>
//         <td>PRECIO</td>
//         <td>PRECIO_TOTAL</td>
//     </tr>
    
//     ";
// while( $data = mssql_fetch_array( $data_arr ) ) {
while( $data = odbc_fetch_array( $data_arr_i ) ) {
    $num_orden_tbl .= $data['ORDEN'].',';
    $num_itm_tbl .= trim($data['ITEM']).',';
    $num_cnd_tbl .= trim($data['CANT_ORDEN']).',';
    $num_pco_tbl .= trim($data['COSTO_PROM']).',';

    // echo"
    // <tr>
    //     <td>".$data[ 'ORDEN' ] ."</td>
    //     <td>".$data[ 'ITEM' ] ."</td>
    //     <td>".$data[ 'CANT_ORDEN' ]."</td>
    //     <td>".$data[ 'COSTO_PROM' ]  ."</td>
    //     <td>".$data[ 'COSTO_TOTAL' ] ."</td>
    // </tr>
    // ";

   
    /* IBS  INSERTAMOS EN EL ARREGLO lista2 LAS LIENAS QUE TRAE LA ORDEN */
    $csv_output = trim($data[ 'ITEM' ]).','.trim($data[ 'CANT_ORDEN' ]).','.trim($data[ 'COSTO_PROM' ]).','.trim($data[ 'COSTO_TOTAL' ]);
    array_push($lista2,array($csv_output));
  
    if($data[ 'ORDEN' ]!==''){
        $conn->insertar("INSERT INTO sqlfacturas.dbo.agro_integaraciones_prov(Num_orden,Fecha_registro,Items_orden,Cantidades_orden,Precios_orden)VALUES(".$data[ 'ORDEN' ].",GETDATE(),'".$data[ 'ITEM' ]."','".$data[ 'CANT_ORDEN' ]."','".$data[ 'COSTO_TOTAL' ]."');");
    }
  
    $envio_mail = 'SI';
    
}



/** SI EN EL FUTURO SE REQUIERE BOTON DE CONFIRMAR  */
// echo "
// </table>
// <form action='#' class='frm_nom_arc' name='frm_nom_arc' id='frm_nom_arc' method='POST'>
//     <input type='date' id='date_arc' name='date_arc' >
//     <br>
//     <input type='submit' value='Confirmar'>
// </form>
// </div>
// ";

$fecha_archivo = ( $_POST[ 'date_arc' ] != '' )?$_POST[ 'date_arc' ]:' NO HA ELEJIDO UNA FECHA';


if(count($lista2 )>=2){
    // $fp = fopen('./envio_archivos/agrocampo-oc-cph-'.$fecha_completa.'.csv', 'w');
    // $fp = fopen('../../../../../../../home/magentodoo/magento_odoo/tel_ip_ger/agrocampo-oc-cph-'.$anio.$mes.$dia.'.csv', 'w');

    $fp = fopen('agrocampo-oc-cph.csv', 'w');
    foreach ($lista2 as $campos) {
        fputcsv($fp, $campos);
    }
    fclose($fp);

    $num_orden_tbl = eliminar_duplicados($num_orden_tbl );
    $num_orden_tbl = explode(',',$num_orden_tbl );
    foreach($num_orden_tbl as $ord){
        $cpo_ord .=$ord.'<br>';
    }

    
    $destinatario = [ 'desarrollador2@agrocampo.com.co' ];
    $copia_a      = [ 'desarrollador2@agrocampo.com.co' ];
    $cuerpo       = "
    <h3>Integracion Agrocampo - Coaspharma</h3>
    <span>
    Ha recibido este correo porque encontramos una OC para enviar al cliente $cliente<br>
    con la(s) siguiente(s) orden(es):<br>
    $cpo_ord
    </span>
    ";

    $asunto       = 'Integracion Agro-Coaspharma ';
    envio_mail( $destinatario, $copia_a, $cuerpo, $fecha_completa, $asunto );
}



?>