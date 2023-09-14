<?php
/* IMPORTA */
// $nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
// echo $nombre_host;

include ('../../conection/conexion_sql.php');
include ('../../conection/conexion_ibs.php');

/* INICIALIZA */
session_start();

/* AGINACION DE VARIABLES PATTERN*/
$numero_factura  = substr($_GET['num_factura'],2,12);
$tipo_factura    = substr($_GET['num_factura'],0,2);
$validador_orden = $_GET['validador'];
$numero_cajas    = ($_GET['cajas']=='')?0:$_GET['cajas'];

/* AGINACION DE VARIABLES PROPIAS*/
$ahora              = date('y-m-d- h:i:s');
$hoy                = date('ymd');
$hoy_2              = date( 'Ymd', strtotime( "$hoy - 2 day" ) );
$contador_linea     = 1;
$items_originales   = [];

$_SESSION['datos_validador'] = explode('|',$validador_orden);


/* OBJETO CONSULTAS */
$con_ibs = new con_ibs('','','');


$_SESSION['hora_inicio_validacion']= $ahora ;


/* LLAMAR EL NUMERO DE ORDEN DEPENDIENDO DEL NIERMO DE FACTURA */
$datos_factura_sql_1 ="SELECT
DISTINCT
    SRBISH.IHORNO AS ORDEN
FROM AGR620CFAG.SRBISH SRBISH
    LEFT JOIN AGR620CFAG.SRBSOH SRBSOH ON SRBSOH.OHORNO=SRBISH.IHORNO
    LEFT JOIN AGR620CFAG.SRBNAM SRBNAM ON SRBNAM.NANUM=SRBISH.IHCUNO 
    LEFT JOIN AGR620CFAG.SRBNAD SRBNAD ON SRBSOH.OHCUNO=SRBNAD.ADNUM AND (SRBNAD.ADDEST<>'00000000') AND (SRBNAD.ADDEST<>'')
    LEFT JOIN AGR620CFAG.SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO 
    LEFT JOIN AGR620CFAG.SROORSPL SRBSOL ON SRBISD.IDOLIN = SRBSOL.OLLINE AND SRBISD.IDORNO = SRBSOL.OLORNO
WHERE 
    SRBISH.IHINVN ='$numero_factura'
";

$orden_factura_q = $con_ibs->conectar($datos_factura_sql_1);

while($orden_num = odbc_fetch_array($orden_factura_q)){
        $orden_factura = $orden_num['ORDEN'];
}

echo
"<table id='tbl_info_fac_1' name='tbl_info_fac_1' clas='tbl_info_fac_1'>
    <tr>
        <th colspan='12'>Información de la factura </th>
    </tr>
    <tr>
        <td >Tipo</td>
        <td >Factura</td>
        <td >Orden</td>
        <td >validador</td>
        <td >Cajas</td>
    </tr>
    <tr>
            <td>$tipo_factura</td>
            <td>$numero_factura</td>
            <td>$orden_factura</td>
            <td>$validador_orden</td>
            <td>$numero_cajas</td>
    </tr>
</table>";


/* LLAMAR LOS ITEMS Y LAS CATNIDADES */
$datos_factura_sql_2 = "SELECT 
DISTINCT
    SRBISH.IHORNO AS ORDEN,
    SRBISH.IHCUNO AS IDENTIFICACION,
    SRBISH.IHIDAT AS FECHA,
    CONCAT(SRBSOH.OHORDT,SRBISH.IHINVN) AS FACTURA,
    SRBNAM.NANAME AS CLIENTE,
    SRBNAM.NANSNA AS RAZONSOCIAL,
    SRBNAM.NANSNO AS CELULAR,
    SRBNAM.NAADR2 AS DIRECCION,
    CONCAT(SRBNAD.ADDEST,SRBNAD.ADPOCD)  AS DESTINO,
    SRBSOL.OLPRDC AS ITEM,
    SRBSOL.OLDESC AS ITEM_DESCRIPCION,
    IDACQT as CANTIDAD
FROM AGR620CFAG.SRBISH SRBISH
    LEFT JOIN AGR620CFAG.SRBSOH SRBSOH ON SRBSOH.OHORNO=SRBISH.IHORNO
    LEFT JOIN AGR620CFAG.SRBNAM SRBNAM ON SRBNAM.NANUM=SRBISH.IHCUNO 
    LEFT JOIN AGR620CFAG.SRBNAD SRBNAD ON SRBSOH.OHCUNO=SRBNAD.ADNUM AND (SRBNAD.ADDEST<>'00000000') AND (SRBNAD.ADDEST<>'')
    LEFT JOIN AGR620CFAG.SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO 
    LEFT JOIN AGR620CFAG.SROORSPL SRBSOL ON SRBISD.IDOLIN = SRBSOL.OLLINE AND SRBISD.IDORNO = SRBSOL.OLORNO
WHERE 
    SRBISH.IHINVN ='$numero_factura'
    and SRBISH.IHIDAT  >='$hoy_2'
";
echo"<br>";
// echo "$datos_factura_sql_2";

/* CONSULTA Y MUESTRA EN PANTALLA DEL LISTADOR ORIGINAL */
/* ITEMS ORIGINALES */
echo "
<table id='tbl_info_fac_2' name='tbl_info_fac_2' clas='tbl_info_fac_2'>
    <tr>
        <th colspan='12'>Descripción de la factura </th>
    </tr>
    <tr>
        <td >Items</td>
        <td >Descripción</td>
        <td >Cantidad</td>
    </tr>
";

// echo "ITEMS ORIGINALES DE LA ORDEN; <br>";
$datos_factura_rta = $con_ibs->conectar($datos_factura_sql_2);

if(count($datos_factura_rta)<=1){
    echo "
    <script>parar();</script>
    ";
    echo "No hay items por validar
    
    ";
    
    return;
}


while($item_validacion = odbc_fetch_array($datos_factura_rta)){
    $ITEM     =$item_validacion['ITEM']  ;
    $ITEMDESC =$item_validacion['ITEM_DESCRIPCION']  ;
    $ITEMCAN  =round($item_validacion['CANTIDAD'],1 ) ;
    $datos_ord_orig = ["item"=>$ITEM,"cantidad"=>$ITEMCAN,"desc"=>$ITEMDESC ];
    // $datos_ord_orig = [$ITEM,$ITEMCAN,$ITEMDESC ];

    array_push($items_originales,($datos_ord_orig ));
    echo"<tr>";
    echo "
     <td id='item_origin' name='item_origin' class='item_origin' > $ITEM </td>  
     <td> $ITEMDESC  </td> 
     <td> $ITEMCAN </td>";
    echo"</tr>";
    $contador_linea++;
}
echo"
</table>
";

$_SESSION['items_originales']= $items_originales;

/* FORMULARIO PARA INGRESAR ITEMS */

echo "
 <br> 
 <hr>
 <br> 
 Validar items: 
 <br>
 <hr>
<form>
    <input type='text'   id='num_item' name='num_item' class='num_item' placeholder='ITEM PRODUCTO'>
    <input type='number' id='cantidad_item' name='cantidad_item' class='cantidad_item' placeholder='CANTIDAD PRODUCTO' min='0'>
    <input type='button' id='validar_item' name='validar_item' class='validar_item' value='➕' onclick='insertar_items()' >
    <input type='button' id='borrar_item' name='borrar_item' class='borrar_item' value='➖' onclick='borrar_items()' >
    <input type='button' id='validar_items_orden' name='validar_items_orden' class='validar_items_orden' value='🆗' onclick='validar_orden();' >
</form>
<textarea id='ls_agregados' name='ls_agregados' class='ls_agregados' cols='80' rows='10' styule='font-size:12px;width:100%;' disabled></textarea>

";


?>