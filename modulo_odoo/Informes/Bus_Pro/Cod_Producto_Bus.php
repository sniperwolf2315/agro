<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();



$pro_cod = trim($_GET['pc']);
$bodega = trim($_GET['b']);


/* ## VARIABLES ## */
$Buscon = new ArrayIterator();
$Buscon1 = new ArrayIterator();
$Buscon2 = new ArrayIterator();
$co = 0;
$co1 = 0;
$consu1 = 0;
$consu2 = 0;
$i = 1;
/* ## VARIABLES ## */

if ($pro_cod === '' && $bodega === 'TODAS') {
    $where_and = "";
} else if ($pro_cod === '' && $bodega !== 'TODAS') {
    $where_and = "and cast(sw.code as int) = $bodega ";
} else if ($pro_cod !== '' && $bodega !== 'TODAS') {
    $where_and = "and (pp.default_code = '$pro_cod' or pp.name_template like '%$pro_cod%') and cast(sw.code as int) = $bodega  ";
} else if ($pro_cod !== '' && $bodega === 'TODAS') {
    $where_and = "and (pp.default_code = '$pro_cod' or pp.name_template like '%$pro_cod%')  ";
}else{
     echo '¡Ups algo salio mal!';    
    return;
}

$query1 = "
    SELECT 
        pp.id,
 		pp.default_code,
        pp.name_template as nom_produc,
        pp.default_code AS item,
        sw.name AS nom_bodega,
        sum(sq.qty) AS existencias_bodega,
        sw.code AS bodega
    FROM 
        stock_quant sq
        LEFT JOIN product_product pp ON sq.product_id = pp.id
        LEFT JOIN stock_location sl ON sq.location_id = sl.id
        LEFT JOIN stock_warehouse sw ON sl.warehouse_id = sw.id
    WHERE 
        sl.warehouse_id IS NOT NULL 
        $where_and
    GROUP BY 
        sw.code,
        sq.location_id,
        sw.name, 
        pp.default_code,
        pp.name_template,
        pp.id
        ;
";


$resultado1 = $Conn->prepare($query1);
$resultado1->execute();
$datos1 = $resultado1->fetchAll();
$existen_datos = count($datos1);

if ($existen_datos === 0) {
    echo '<h5><strong> No hay datos para mostrar</strong> </h5>';
    return;
}

$query2 = $query1;
$resultado2 = $Conn->prepare($query2);
$resultado2->execute();
$datos2 = $resultado2->fetchAll();
/*
color verde  #009688
TODO: REVISAR SI SE DEBE AGRAGAR EL BOTON DE DESCARGA EXCEL
*/
$r = $r . "
            <p style=\"text-align: center;\" class=\"z-depth-1\">Resultados del producto: " . $pro_cod . "</p>
                <table style=\"border: 1px solid #000; width:100%;\" class=\"  #43A047 teal\" >                                                    
                    <tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">                                                                 
                        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
                        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombre del Producto</td>
                        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item</td>
                        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bodega</td>
                        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
                        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Codigo de bodega</td>            
                    </tr>                                                                                                                            
        ";


$query3 = $query1;
$resultado3 = $Conn->prepare($query3);
$resultado3->execute();
$datos3 = $resultado3->fetchAll();
//DATOS        
foreach ($datos3 as $dato3) {
    if (($i % 2) == 0) {
        $color = "#AED6F1";
    } else {
        $color = "#E8F6F3";
    }
    $d2 = $dato3['nom_produc'];
    $d3 = $dato3['item'];
    $d4 = $dato3['nom_bodega'];
    $d5 = $dato3['existencias_bodega'];
    $d6 = $dato3['bodega'];
    $r = $r . "
    <tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>                                                       
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $i . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d2 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d3 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d4 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d5 . "</td>
            <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>" . $d6 . "</td>           
    </tr>
    ";

    $i++;
}
$r = $r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();
echo $r;
