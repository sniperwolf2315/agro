<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$pro_cod=trim($_GET['pc']);
$bodega=trim($_GET['b']);

if($bodega=='TODAS'){
    $bodega="";
}else{
     $bodega=" and sw.code='$bodega'";
}

//busqueda por codigo del producto
$query1="select * from product_product where default_code like '%$pro_cod%';";
$consu1=0;
$Buscon = new ArrayIterator();
$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
foreach($datos1 as $dato1){
    $cod_pro1=$dato1['default_code'];        
    if($cod_pro != ""){
        $id_pro1=$dato1['id'];
        $Buscon1[$consu1]=$id_pro1;
    }else{
        $id_pro1="";
    }
    $consu1++;
}
//busqueda por nombre de producto
$query2="select * from product_product where name_template like '%$pro_cod%';";
$consu2=0;
$Buscon1 = new ArrayIterator();
$Buscon2 = new ArrayIterator();
$resultado2= $Conn->prepare($query2);
$resultado2->execute();
$datos2=$resultado2->fetchAll();

foreach($datos2 as $dato2){
    $cod_pro2=$dato2['default_code'];        
    if($cod_pro2 != ""){
        $id_pro2=$dato2['id'];
        $Buscon2[$consu2]=$id_pro2;
    }else{
        $id_pro2="";
    }
    $consu2++;
}

$co=0;
$co1=0;
if($consu1!=0){
    $consult1=" and pp.id in (";
    for ($acon=0; $acon<$consu1; $acon++){
        $consult1=$consult1."'".$Buscon1[$co]."'";
        if($acon<$consu1-1){
            $consult1=$consult1.",";
        }else{
            $consult2=$consult2."";
        }
        $co++;
    }
    $consult1=$consult1.") ";
}else if($consu2!=0){
    $consult2=" and pp.id in (";
    for ($acon=0; $acon<$consu2; $acon++){
        $consult2=$consult2."'".$Buscon2[$co1]."'";
        if($acon<$consu2-1){
            $consult2=$consult2.",";
        }else{
            $consult2=$consult2."";
        }
        $co1++;
    }
    $consult2=$consult2.") ";
}

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">El Producto Buscado Fue: ".$pro_cod."</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombre del Producto</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Item</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bodega</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cantidad</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Codigo de bodega</td>";
        $r=$r . "</tr>";
        
$query3="SELECT pp.name_template as nom_produc,pp.default_code AS item,sw.name AS nom_bodega,sum(sq.qty) AS existencias_bodega,sw.code AS bodega
FROM stock_quant sq
LEFT JOIN product_product pp ON sq.product_id = pp.id
LEFT JOIN stock_location sl ON sq.location_id = sl.id
LEFT JOIN stock_warehouse sw ON sl.warehouse_id = sw.id
WHERE sl.warehouse_id IS NOT NULL $bodega $consult2
GROUP BY sw.code, sq.location_id, sw.name, pp.default_code,pp.name_template;";

$resultado3= $Conn->prepare($query3);
$resultado3->execute();
$datos3=$resultado3->fetchAll();  
//DATOS        
foreach($datos3 as $dato3){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato3['nom_produc'];
        $d3=$dato3['item'];
        $d4=$dato3['nom_bodega'];
        $d5=$dato3['existencias_bodega'];
        $d6=$dato3['bodega'];

                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d2."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d3."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d4."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d5."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d6."</td>";
                            $r=$r."</tr>";
                            $i++;
}
$r=$r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();
echo $r;
?>
