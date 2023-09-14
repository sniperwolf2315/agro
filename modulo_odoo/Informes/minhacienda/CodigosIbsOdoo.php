<?php
include_once 'usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();
/*
$query="SELECT p.id as ide, p.default_code as codigopag,
CASE WHEN (textregexeq(trim(t.description),'^[[:digit:]]+(\.[[:digit:]]+)?$')) = true THEN t.description else '' END as codibs,
p.name_template as nombre,
m.cost as CostoUnd,
CASE WHEN (m.cost*m.product_uom_qty) IS NULL THEN 0 ELSE (m.cost*m.product_uom_qty) END AS CostoTotal,
m.product_uom_qty as Cantidad,
w.code as bodega,
m.state,
u.login as Manejador,
sq.location_id,
left(p.default_code,3) as grupo,
substring(c.name from 9 for 50) as nomgrupo,
c.parent_id,
t.category_1_id,
k.code as nombrecategoria
 FROM product_product p
 left join stock_move m ON p.id=m.product_id
 left join stock_location l ON l.id=m.location_dest_id
 left join stock_warehouse w ON l.warehouse_id=w.id
 left join product_template t ON t.id=p.product_tmpl_id
 left join res_users u ON t.product_manager=u.id
 left join product_category c ON t.categ_id=c.id
 left join product_category_level k ON t.category_1_id=k.id
left join stock_quant as sq on p.id=sq.product_id
 where p.active='true';";*/
 
$query="SELECT
p.default_code as codigopag,
CASE WHEN (textregexeq(trim(t.description),'^[[:digit:]]+(\.[[:digit:]]+)?$')) = true THEN t.description else '' END as codibs,
p.name_template as nombre,
left(p.default_code,3) as grupo,
substring(c.name from 9 for 50) as nomgrupo,
k.code as nombrecategoria
 FROM product_product p
 left join stock_move m ON p.id=m.product_id
 left join stock_location l ON l.id=m.location_dest_id
 left join stock_warehouse w ON l.warehouse_id=w.id
 left join product_template t ON t.id=p.product_tmpl_id
 left join res_users u ON t.product_manager=u.id
 left join product_category c ON t.categ_id=c.id
 left join product_category_level k ON t.category_1_id=k.id
 left join stock_quant as sq on p.id=sq.product_id
group by  p.default_code, t.description, p.name_template, left(p.default_code,3),substring(c.name from 9 for 50),k.code,p.active
having p.active='true';";
 
 //w.code IN('008') and m.state='done' and sq.location_id='221'
 
 $resultado= $Conn->prepare($query);
$resultado->execute();
$datos=$resultado->fetchAll();
include('conectarbase.php');
foreach($datos as $dato){
    $d1=$dato['codigopag'];
    $d2=$dato['codibs'];
    $d3=$dato['nombre'];
    $d4=$dato['grupo'];
    $d5=$dato['nomgrupo'];
    $d6=$dato['nombrecategoria'];
    
    $resultSQLTot = mssql_query("SELECT ItemIbs FROM [InformesCompVentas].[dbo].[InfItemsIbsOdoo] WHERE ItemIbs='$d2'");                
    $resultadoTot = mssql_fetch_array($resultSQLTot);
    $d1S=$resultadoTot["ItemIbs"];
    if($d1S=="" && $d2!=""){
            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[InfItemsIbsOdoo] (ItemIbs,ItemOdoo,Nombre,Grupo,NombreGrup,NombreCat) 
            VALUES('$d2','$d1','$d3','$d4','$d5','$d6')"; 
            mssql_query($sqlv,$cLink);
    }
    
}
echo "Proceso terminado";
mssql_close();
Conexion::cerrarConexion();

?>