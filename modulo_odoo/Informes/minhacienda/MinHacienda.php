<?php
include_once 'usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

//$anio=trim($_GET['a']);
//$mes=trim($_GET['m']);
$tipo=trim($_GET['t']);
echo "Esta visualizando el informe: ".$tipo;//."<br />"."Query: ".$query1."<br />"
//fecha inicio fecha din de la consulta x mes
$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31
$feini=$anio."-".$mes."-01";
$fefin=$anio."-".$mes."-".$dia;
//echo "dias: {$dia} <br>"."Fecha inicial: ".$feini."<br>"."fecha Fin: ".$fefin;
        $r=$r."<table style=\"border: 1px solid #000; width:100%; \">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\">ITEM</td>
        <td style=\"font-weight: bold;text-align: left;\">ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\">TIPO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\">ESTADO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\">FECHA ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\">PROVEEEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\">DESCR. PROVEEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\">ITEM</td>
        <td style=\"font-weight: bold;text-align: left;\">Codigo_Barras</td>
        <td style=\"font-weight: bold;text-align: left;\">DESCRICPION</td>
        <td style=\"font-weight: bold;text-align: left;\">CANTIDAD SOLICITADA</td>
        <td style=\"font-weight: bold;text-align: left;\">CANTIDAD RECIBIDA</td>
        <td style=\"font-weight: bold;text-align: left;\">CANTIDAD DEVUELTAS</td>
        <td style=\"font-weight: bold;text-align: left;\">ESTADO LINEA</td>
        <td style=\"font-weight: bold;text-align: left;\">OLITIT</td>
        <td style=\"font-weight: bold;text-align: left;\">VALOR X UND.</td>
        <td style=\"font-weight: bold;text-align: left;\">TOTAL</td><td><a href='Informexls/ORDENES_Pest_008.xlsx'>Descargar</a><Strong></td>";
        $r=$r."</tr>";
        //Informe_Ingreso008.xlsx'>Descargar</a><Strong></td>";

include('conectarbase.php');
$resultSQL = mssql_query("SELECT TOP 1000 [ITEM] ,[DESCRIPCION] FROM [InformesCompVentas].[dbo].[infVentasSinIva];",$cLink);
 

while($resultadocat = mssql_fetch_array($resultSQL)){
    $grupo=$resultadocat["ITEM"];
    //$descrip=$resultadocat["DESCRIPCION"];
    ///aqui las comparaciones.......
    echo "Esta visualizando el informe: ".$grupo."<br/>";

//echo "Esta visualizando el informe: ".$tipo." consulta realizada: ".$grupo;
//echo "valo_1: ".$anio." Valor_2: ".$mes;
//".$feini."' and '".$fefin."';"
//$query = "select * from stock_control_receipt where date between '".$anio."-".$mes."-01' and '".$anio."-".$mes."-20';";
$query1 = "SELECT p.id as ide, p.default_code as codigopag,
CASE WHEN (textregexeq(trim(t.description),'^[[:digit:]]+(\.[[:digit:]]+)?$')) = true THEN t.description else '' END as codibs,
p.name_template as nombre,
m.cost as costound,
CASE WHEN (m.cost*m.product_uom_qty) IS NULL THEN 0 ELSE (m.cost*m.product_uom_qty) END AS costototal,
m.product_uom_qty as cantidad,
w.code as bodega,
m.state,
u.login as manejador,
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
 where t.description='".$grupo."';";//sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and
//sw.code='008' and sp.name like '%IN%' and scrld.state in ('transferred','returned') and pp.default_code like
echo "Esta visualizando el informe: ".$query1."<br/>";
}

$r=$r."<p>Ordenes de Compra Pendientes.</p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

                $fd=3;
                // $r="Informexls/Informe_Inventario008.xlsx"
                $miruta='Informexls/';
                $nombre_fichero = 'ORDENES_Pest_008';
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
                        // Add new sheet
                        $objWorkSheet = $objPHPExcel->createSheet(0);
                            $objWorkSheet->setCellValue('A2', 'ITEM')
                                ->setCellValue('B2', 'ORDEN')
                                ->setCellValue('C2', 'TIPO ORDEN')
                                ->setCellValue('D2', 'ESTADO ORDEN')
                                ->setCellValue('E2', 'FECHA ORDEN')
                                ->setCellValue('F2', 'PROVEEEDOR')
                                ->setCellValue('G2', 'DESCR. PROVEEDOR')
                                ->setCellValue('H2', 'ITEM')
                                ->setCellValue('I2', 'CODIGO DE BARRAS')
                                ->setCellValue('J2', 'DESCRICPION')
                                ->setCellValue('K2', 'CANTIDAD SOLICITADA')
                                ->setCellValue('L2', 'CANTIDAD RECIBIDA')
                                ->setCellValue('M2', 'CANTIDAD DEVUELTAS')
                                ->setCellValue('N2', 'ESTADO LINEA')
                                ->setCellValue('O2', 'OLITIT')
                                ->setCellValue('P2', 'VALOR X UND.')
                                ->setCellValue('Q2', 'TOTAL');
                             //colocar titulos a las hojas de excel
                            //$objWorkSheet->setTitle("$i");
                                $objWorkSheet->setTitle('PETS');                    
                }
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                    ///////// revisar 
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
                        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$fil, '');
                        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$fil, '');
                        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$fil, '');
                        $fil++;
                }
                //ANCHOS
                $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', "ORDENES DE COMPRA PENDIENTES POR ENTREGAR 008");
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $resultado1= $Conn->prepare($resultSQL);
            $resultado1->execute();
            $datos1=$resultado1->fetchAll();
                $i=1;
                foreach($datos1 as $dato1){
                    if(($i%2)==0){
                            $color="#AED6F1";
                        }else{
                            $color="#E8F6F3";
                        }
                    $d1=$dato['ide'];
                    $d2=$dato['codigopag'];
                    $d3=$dato['codibs'];
                    $d4=$dato['nombre'];
                    $d5=$dato1['proveedor'];
                    $d6=$dato1['descr_proveedor'];
                    $d7=$dato1['item'];
                    $d8=$dato1['codigo_barras'];
                    $d9=$dato1['descripcion'];
                    $d10=$dato1['cant_solicitada'];
                    //$d11=$dato1['cant_recibida'];
                    
                    if ($dato1['validar']=='transferred'){
                        $d11r=$dato1['cant_recibida'];
                        //$d10=$dato1['cant_solicitada'];
                    }else if ($dato1['validar']=='returned'){
                        $d11d=$dato1['cant_recibida'];
                        //$d10=$dato1['cant_solicitada'];
                    }else{
                        $d11r=0;
                        $d11d=0;
                    }
                    $d12=$dato1['estado_linea'];
                    $d13=$dato1['olitit'];
                    $d14=$dato1['valor_und'];
                    $d15=$dato1['total'];
                    
                                    $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                                    $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$grupo."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d1."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d2."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d3."</td>
                                    <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d4."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d5."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d6."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d7."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d8."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d9."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d10."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11r."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d11d."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d12."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d13."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d14."</td>
                                    <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>".$d15."</td>";
                                    $r=$r."</tr>";
    
                    //EXCEL
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$fd, $i)            
                            ->setCellValue('B'.$fd, $d1)
                            ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('E'.$fd, $d4)
                            ->setCellValue('F'.$fd, $d5)
                            ->setCellValue('G'.$fd, $d6)
                            ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('H'.$fd, $d7)
                            ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('J'.$fd, $d9)
                            ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('K'.$fd, $d10)
                            ->setCellValue('L'.$fd, $d11r)
                            ->setCellValue('M'.$fd, $d11d)
                            ->setCellValue('N'.$fd, $d12)
                            ->setCellValue('O'.$fd, $d13)
                            ->setCellValue('P'.$fd, $d14)
                            ->setCellValue('Q'.$fd, $d15);
                    $i++;
                    $fd++;
        }
    //}
}
                    

$r=$r . "</table>";
Conexion::cerrarConexion();
//CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
echo $r;
//echo $fecha;
?>