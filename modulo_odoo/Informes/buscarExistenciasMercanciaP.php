<?php
include_once 'usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();


//CAMBIAR QUERY*****OJO*************************OJO********************************PENDIENTE
//$query = "SELECT * FROM stock_control_receipt WHERE name='CP-000332';";
//$query="SELECT p.id AS ide FROM public.product_product p WHERE p.default_code='PPO004487';";

/*$query="SELECT p.id as ide, p.default_code as CodigoPag,
CASE WHEN (textregexeq(trim(t.description),'^[[:digit:]]+(\.[[:digit:]]+)?$')) = true THEN t.description else '' END as codIbs,
p.name_template as Nombre,
m.cost as CostoUnd,
CASE WHEN (m.cost*m.product_uom_qty) IS NULL THEN 0 ELSE (m.cost*m.product_uom_qty) END AS CostoTotal,
m.product_uom_qty as Cantidad,
w.code as bodega,
m.state,
u.login as Manejador,
sq.location_id,
left(p.default_code,3) as Grupo,
substring(c.name from 9 for 50) as NomGrupo,
c.parent_id,
t.category_1_id,
k.code as NombreCategoria
 FROM product_product p
 left join stock_move m ON p.id=m.product_id
 left join stock_location l ON l.id=m.location_dest_id
 left join stock_warehouse w ON l.warehouse_id=w.id
 left join product_template t ON t.id=p.product_tmpl_id
 left join res_users u ON t.product_manager=u.id
 left join product_category c ON t.categ_id=c.id
 left join product_category_level k ON t.category_1_id=k.id
left join stock_quant as sq on p.id=sq.product_id
 where w.code IN('008') and m.state='done' and p.active='true' and sq.location_id='221';";*/
 
 $query="select
    p.default_code as itemodoo,
    t.description as itemibs,
    p.name_template as nombre,
    left(c.name,3) as grupo,
    split_part(c.name, '-', 2) as descgrupo,
    '' as nombrecateg,
    --(select name from product_category_level where id=p.product_tmpl_id) as nombrecateg,
    u.login as manejador,
    --verificar el costo o consultarlo por php
    q.cost as costo,
    CASE WHEN (q.cost*sum(q.qty)) IS NULL THEN 0 ELSE (q.cost*sum(q.qty)) END AS CostoTotal,
    l.complete_name as locacion,
    case when trim(split_part(l.complete_name, '/', 1))='Agro' then trim(split_part(l.complete_name, '/', 2)) else trim(split_part(l.complete_name, '/', 1)) end AS bodega,
    sum(q.qty) as existen
    from stock_quant q
    right join product_product p ON q.product_id=p.id
    left join product_list_item i ON i.product_id=p.id
    left join product_category c ON c.id=i.categ_id
        left join product_template t ON p.product_tmpl_id=t.id
        --left outer join product_category_level n ON n.id=p.product_tmpl_id
        left join res_users u ON t.product_manager=u.id
    left join stock_location l ON l.id = q.location_id
    group by p.default_code,t.description,p.name_template,q.location_id,l.complete_name,left(c.name,3),c.name,t.category_2_name,p.product_tmpl_id,u.login,q.cost
    having q.location_id not in('9')
     order by left(c.name,3) asc
 ";
 
 /*
 $d1=$dato['ide'];
    $d2=$dato['codigopag'];
    $d3=$dato['itemIbs'];
    $d4=$dato['nombre'];
    $d5=$dato['costo'];
    $d6=$dato['costototal'];
    $d7=$dato['existen'];
    $d8=$dato['bodega'];
    $d9=$dato['manejador'];
    $d10=$dato['grupo'];
    $d11=$dato['descgrupo'];
    $d12=$dato['nombrecateg'];
 */
 
  // Busqueda por bodega (sq.location_id // 227=BODEGA-005-CALLE 73 // 221=BODEGA-008-CEDI PORTOS)
 //AND p.default_code='PPO004487'
$resultado= $Conn->prepare($query);
$resultado->execute();
$datos=$resultado->fetchAll();
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Existencias Bodega Portos.</p>";
//var_dump($datos); 
//echo "<span style='color: black; font-weight: bold;' >INVENTARIO BODEGA</span>";
    $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
    $r=$r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ID</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CodProdOdoo</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CodProdIBS</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">NomProd</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CostUnd</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CostTot</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cant</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bod</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Locacion</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Man</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Grupo</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">NomGrup</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">NomCateg</td>";
    $r=$r . "<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\"><Strong>
    <a href='Informexls/Informe_Inventario008.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
    $r=$r . "</tr>";
    $i=1;
        //excel
        $fd=3;
       // $r="Informexls/Informe_Inventario008.xlsx"
        $miruta='Informexls/';
        $nombre_fichero = 'Informe_Inventario008';
        $mipath=$miruta.$nombre_fichero.'.xlsx';
        if(file_exists($miruta)) {
            include('Classes/PHPExcel.php');
            include('Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            $mipath2=$miruta.$nombre_fichero.'.xlsx';
            if(file_exists($mipath2)) {
                $archivo = $mipath2;
                $inputFileType = PHPExcel_IOFactory::identify($archivo);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($archivo);                
            } else {              
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                    
                    $objWorkSheet->setCellValue('A2', '#')
                        ->setCellValue('B2', 'ID')
                        ->setCellValue('C2', 'CodProdOdoo')
                        ->setCellValue('D2', 'CodProdIBS')
                        ->setCellValue('E2', 'NomProd')
                        ->setCellValue('F2', 'CostUnd')
                        ->setCellValue('G2', 'CostTot')
                        ->setCellValue('H2', 'Cant')
                        ->setCellValue('I2', 'Bod')
                        ->setCellValue('J2', 'Locacion')
                        ->setCellValue('K2', 'Man')
                        ->setCellValue('L2', 'Grupo')
                        ->setCellValue('M2', 'NomGrup')
                        ->setCellValue('N2', 'NomCateg');
                     
                    
                    $objWorkSheet->setTitle("Inventario Bod 008");
                }
            
        } 
        //BORRAR DTOS
        $fil=3;
        $objPHPExcel->setActiveSheetIndex(0);
        $totalreg = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $totalreg=$totalreg+1;
        while ($fil <= $totalreg) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$fil, '');
            $fil++;
        }
        //ANCHOS
        $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', "INVENTARIO BOD 008");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //DATOS
foreach($datos as $dato){
    if(($i%2)==0){
        $color="#AED6F1";
    }else{
        $color="#E8F6F3";
    }
    $d1='';//$dato['ide'];
    $d2=$dato['itemodoo'];
    $d3=$dato['itemibs'];
    $d4=$dato['nombre'];
    $d5=$dato['costo'];
    $d6=$dato['costototal'];
    $d7=$dato['existen'];
    $d8=$dato['bodega'];
    $d8u=$dato['locacion'];
    $d9=$dato['manejador'];
    $d10=$dato['grupo'];
    $d11=$dato['descgrupo'];
    $d12=$dato['nombrecateg'];
    //filas
    if($d8=='008'){
    $r=$r . "<tr style='background-color: $color; font-size: 0.5em;'>";
    $r =$r. "<td style='padding: 5px;'>".$i."</td><td>".$d1."</td><td style='padding: 5px;'>".$d2."</td><td style='padding: 5px;'>".$d3."</td><td style='padding: 5px;'>".$d4."</td><td style='padding: 5px;'>".$d5."</td><td style='padding: 5px;'>".$d6."</td><td style='padding: 5px;'>".$d7."</td><td style='padding: 5px;'>".$d8."</td><td style='padding: 5px;'>".$d8u."</td><td style='padding: 5px;'>".$d9."</td><td style='padding: 5px;'>".$d10."</td><td style='padding: 5px;'>".$d11."</td><td style='padding: 5px;'>".$d12."</td><td>&nbsp;</td>";
    $r=$r . "</tr>";
    $i++;
    //EXCEL
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$fd, $i)            
        ->setCellValue('B'.$fd, $d1)
        ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicitByColumnAndRow(3, $fd, "'".$d3, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValue('E'.$fd, $d4)
        ->setCellValue('F'.$fd, $d5)
        ->setCellValue('G'.$fd, $d6)
        ->setCellValue('H'.$fd, $d7)
        ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValue('J'.$fd, $d8u)
        ->setCellValue('K'.$fd, $d9)
        ->setCellValue('L'.$fd, $d10)
        ->setCellValue('M'.$fd, $d11)
        ->setCellValue('N'.$fd, $d12);
    
        $fd++;
        }
}
$r=$r . "</table>";
//CERRRAR CONEXION BASE
Conexion::cerrarConexion();
    //CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);

echo $r;
?>