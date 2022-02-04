<?php
$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
//$dia=trim($_GET['d']);
$tipo=trim($_GET['tipo']);
$company=trim($_GET['comp']);
include('conectarbase.php');
$dato="";
if($company=="AG"){
    $cp="Agrocampo";
    }
if($company=="X1"){
    $cp="Pestar";
    }
if($company=="ZZ"){
    $cp="Comervet";
    }
    $fecha=date("d_m_Y");
    $miruta='informes/';
    $nombre_fichero = 'Informe_'.$tipo.'_'.$cp.'_';
    $mipath=$miruta.'.'.$nombre_fichero.'.xlsx';
    $Odenes=new ArrayIterator();
    if(file_exists($miruta)) {
        include('Classes/PHPExcel.php');
        include('Classes/PHPExcel/Reader/Excel2007.php');
        //Crear el objeto Excel: 
        $objPHPExcel = new PHPExcel();
        //crea hojas
        $i=1;
        $mipath2=$nombre_fichero.$anio.'.xlsx';
        if(file_exists($mipath2)) {
            $archivo = $mipath2;
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
            $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
            $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
            $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
            $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
            $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
            $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
        }else{
            while ($i <= 12) {
                // Add new sheet
                $objWorkSheet = $objPHPExcel->createSheet($i);
                
                $objWorkSheet->setCellValue('A2', 'Funcionario')
                   
                    ->setCellValue('B2', 'PedidosValidadosMes');
                 
                    //->setCellValue('C2', 'FacturasDespachadasMes');
                 
                
                $objWorkSheet->setTitle("$i");
    
                $i++;
                
            }
            $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
            $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
            $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
            $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
            $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
            $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
            $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
            while ($i <= 12) {
                // Add new sheet
                $objWorkSheet = $objPHPExcel->createSheet($i);
                
                $objWorkSheet->setCellValue('A2', 'Funcionario')
                   
                    ->setCellValue('B2', 'PedidosValidadosMes');
                 
                    //->setCellValue('B2', 'FacturasDespachadasMes');
                
                
                $objWorkSheet->setTitle("$i");
    
                $i++;
                
            }
        }
        
        $m=intval($mes);
        //borra datos hoja
        $fil=3;
        $objPHPExcel->setActiveSheetIndex($m);
        $totalreg = $objPHPExcel->setActiveSheetIndex($m)->getHighestRow();
        $totalreg=$totalreg+1;
        /*while ($fil <= $totalreg) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fil, '');
            $fil++;
        }*/
        
        //agrupamiento por funcionario
            if($company=="AG"){
               $resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') group by rv.Funcionario",$cLink);
               }
            if($company=="X1"){
               $resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasPestar].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02','04','ZB') group by rv.Funcionario",$cLink);
               }
            if($company=="ZZ"){
               $resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasComervet].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02') group by rv.Funcionario",$cLink);
               }
            $j=0;
            $cant=0;
                        
            $objPHPExcel->setActiveSheetIndex($m);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
         
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
            //consulta
            $j=0;
            $fd=3;
            $fn=3;
            $Mess=array('1' => "ENERO",'2' => "FEBRERO",'3' => "MARZO",'4' => "ABRIL",'5' => "MAYO",'6' => "JUNIO",'7' => "JULIO",'8' => "AGOSTO",'9' => "SEPTIEMBRE",'10' => "OCTUBRE",'11' => "NOVIEMBRE",'12' => "DICIEMBRE");
            $objPHPExcel->setActiveSheetIndex($m)
                        ->setCellValue('A1', $Mess[$m]." ".$anio);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            setlocale(LC_TIME,"es_ES");
          
            $datos=new ArrayIterator();
            $cd=0;
            $cn=0;
            $fd=3;
            $i=0;
            $Usuarios=new ArrayIterator();
            while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                        
                        $d1=utf8_encode($resultadoitems["Funcionario"]);
                        //$d3=$resultadoitems["LineasValidadasMes"];
                        $d4=$resultadoitems["PedidosEmpacadosMes"];
                        //$d5=$resultadoitems["CajasEmpacadasMes"];
                        //$d6=$resultadoitems["FacturasDespachadasMes"];
                        
                       
                            $objPHPExcel->setActiveSheetIndex($m)
                                ->setCellValue('A'.$fd, $d1) 
                               
                                ->setCellValue('B'.$fd, $d4);
                             
                                //->setCellValue('C'.$fd, $d6);
                                
                                $Usuarios[$i++]=$d1;
                            
                            $fd++;
                 
             }
             
             //MENUS
             $fd=3;
             $d=1;
             $a=70; //columna F
             $cx="";
             $number = cal_days_in_month(CAL_GREGORIAN, $m, $anio);   
             $c=1;
             $l="";
             $msg="";
             $cascii1=chr($a);
             $f=3;
             while($c<=$number){
                $msg="Dia ".$c;
                if($c<10){
                    $diax="0".$c;
                }else{
                    $diax=$c;
                }               
                $objPHPExcel->getActiveSheet()->getColumnDimension($cascii1)->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(15);
                $objPHPExcel->getActiveSheet()->getStyle($cascii1."1")->getFont()->setBold(true);
                $objPHPExcel->setActiveSheetIndex($m)->setCellValue($cascii1."1", $msg);
                //if($tipo=='Validados'){
                    $objPHPExcel->setActiveSheetIndex($m)->setCellValue("E"."1", "P.".$tipo);
                //}
                
                $c++;
                $a++;
                
                if($a == 91){
                    $l="A";
                    $a=65;
                }
                if($cascii1 == "AZ"){
                    $l="A";
                    $a=65;
                }
                $cascii1=chr($a);
                $cascii1=$l.$cascii1;
                //$p=$p.$cascii1."--";
             }
             //$resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') group by rv.Funcionario",$cLink);
                //validadas
              /*
                $f=3;
                $tam=count($Usuarios);
                $i=0;
                 while($i<$tam){
                //funcionarios
                //while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                    $funcionario=$Usuarios[$i++];//utf8_encode($resultadoitems["Funcionario"]);
                    
                     $a=70;
                     $l="";
                     $cascii1=chr($a);
                     $objPHPExcel->setActiveSheetIndex($m)
                                    ->setCellValue("E".$f, $funcionario);
                    $c=1;
                    while($c<=$number){
                            if($c<10){
                                $diax=''.$c;
                            }else{
                                $diax=$c;
                            } 
                        //count(rf.[Factura]) as FacturasDespachadasMes
                        //and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."' AND DAY(rf.Fecha)='".$diax."')
                        $resultSQLItemsm2 = mssql_query("SELECT DISTINCT count(rv.[Orden]) as PedidosEmpacadosMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where rv.Funcionario='".$funcionario."' AND (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."' AND DAY(rv.HoraFinal)='".$diax."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4')",$cLink);
                        if($resultadoitems2 = mssql_fetch_array($resultSQLItemsm2)){
                            $d4=$resultadoitems2["PedidosEmpacadosMes"];
                            
                            if($d4>0 || $d4!=null){
                                $objPHPExcel->setActiveSheetIndex($m)
                                    ->setCellValue($cascii1.$f, $d4); 
                            }else{
                                $objPHPExcel->setActiveSheetIndex($m)
                                    ->setCellValue($cascii1.$f, "0"); 
                            }
                        }
                        $a++;
                
                        if($a == 91){
                            $l="A";
                            $a=65;
                        }
                        if($cascii1 == "AZ"){
                            $l="A";
                            $a=65;
                        }
                        $cascii1=chr($a);
                        $cascii1=$l.$cascii1;
                        $c++;
                    }
                    $f++;
                                
             }
            */
                $f=3;
                $dias=new ArrayIterator();
                $tam=count($Usuarios);
                $i=0;
                //$tam
                 while($i<$tam){
                //funcionarios
                //while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                    $funcionario=$Usuarios[$i++];//utf8_encode($resultadoitems["Funcionario"]);
                    
                     $a=70;
                     $l="";
                     $cascii1=chr($a);
                     $objPHPExcel->setActiveSheetIndex($m)
                                    ->setCellValue("E".$f, $funcionario);
                    $c=1;
                    //while($c<=$number){
                      /*      if($c<10){
                                $diax=''.$c;
                            }else{
                                $diax=$c;
                            } */
                        
                        $f1=0;
                        while($f1<=$number){
                            $dias[$f1]='0';
                            $f1++;
                        }
                        //$tmp="";
                        //$contdiaf=1;
                        //count(rf.[Factura]) as FacturasDespachadasMes
                        //and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."' AND DAY(rf.Fecha)='".$diax."')
                        if($company=="AG"){
                        $resultSQLItemsm2 = mssql_query("SELECT DAY(rv.HoraFinal) as Dia, count(rv.[Orden]) as PedidosEmpacadosMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where rv.Funcionario='".$funcionario."' AND (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') GROUP BY DAY(rv.HoraFinal) ORDER BY DAY(rv.HoraFinal) ASC",$cLink);
                        }
                        if($company=="X1"){
                        $resultSQLItemsm2 = mssql_query("SELECT DAY(rv.HoraFinal) as Dia, count(rv.[Orden]) as PedidosEmpacadosMes FROM [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasPestar].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden left join [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where rv.Funcionario='".$funcionario."' AND (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02','04','ZB') GROUP BY DAY(rv.HoraFinal) ORDER BY DAY(rv.HoraFinal) ASC",$cLink);
                        }
                        if($company=="ZZ"){
                        $resultSQLItemsm2 = mssql_query("SELECT DAY(rv.HoraFinal) as Dia, count(rv.[Orden]) as PedidosEmpacadosMes FROM [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasComervet].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden left join [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where rv.Funcionario='".$funcionario."' AND (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02') GROUP BY DAY(rv.HoraFinal) ORDER BY DAY(rv.HoraFinal) ASC",$cLink);
                        }
                        //if($resultadoitems2 = mssql_fetch_array($resultSQLItemsm2)){
                        while($resultadoitems2 = mssql_fetch_array($resultSQLItemsm2)){
                            $d4=$resultadoitems2["PedidosEmpacadosMes"];
                            $diaf=$resultadoitems2["Dia"];
                            $df=(int)$diaf;
                            $dias[$df]=$d4;
                            //$tmp=$tmp.",".$dias[$df]."=".$diaf;
                            //$diaf++;
                            /*if($d4>0 || $d4!=null){
                                $objPHPExcel->setActiveSheetIndex($m)
                                    ->setCellValue($cascii1.$f, $d4); 
                            }else{
                                $objPHPExcel->setActiveSheetIndex($m)
                                    ->setCellValue($cascii1.$f, "0"); 
                            }
                            //}
                            $a++;
                    
                            if($a == 91){
                                $l="A";
                                $a=65;
                            }
                            if($cascii1 == "AZ"){
                                $l="A";
                                $a=65;
                            }
                            $cascii1=chr($a);
                            $cascii1=$l.$cascii1;
                            $c++;*/
                        }
                        //pinto datos ene excel
                        $f1=1;
                        while($f1<=$number){
                            $objPHPExcel->setActiveSheetIndex($m)
                                    ->setCellValue($cascii1.$f, $dias[$f1]);
                            $a++;
                    
                            if($a == 91){
                                $l="A";
                                $a=65;
                            }
                            if($cascii1 == "AZ"){
                                $l="A";
                                $a=65;
                            }
                            $cascii1=chr($a);
                            $cascii1=$l.$cascii1;
                            $c++;
                            
                            $f1++;
                        }
                        
                        
                   // }
                    $f++;
                                
             }
            
             
        //CREA ARCHIVO************************************************************
        //crear objeto writer
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        //Guardar el achivo: 
        $objWriter->save($mipath2);
        //$descarga=$nombre_fichero.$anio.".xlsx";
    }
    // items
    
    
mssql_close();
echo $mipath2;//$datos2diaus[1].",".$datos2diav1[1].",".$datos2diav2[1].",".$datosnohrd[1]." h=".$Hora;

?>