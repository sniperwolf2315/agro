<html>
<head>
<title>Lista de capacitaciones</title>
<style type="text/css">
        .letra{
            font-family: sans-serif;
            font-size: 1.1em;
        }
        .titulo{
            font-family: sans-serif;
            font-size: 1.2em;
        }
        body {
            background-color: beige;
        }
        </style>
<script language="JavaScript">
            
            function verLink(valor) {
                document.getElementById('linke').innerHTML = '<a href="FIRMAVENDEDOR/'+valor+'"><h4>Descargar Informe en Excel</h4></a>';
            }
</script>

</head>
<body>
<label class="titulo">INFORME DE CAPACITACIONES AGROCAMPO</label><br /><br />
<form name="capa" method="post" action="Capacitaciones.php">
<select name="sala">
<option value="0">Seleccione sede</option>
<option value="1">Calle 73</option>
<option value="3">Portos 80</option>
</select><br /><br /><br />
<label class="letra">Digite dia:</label><input type="text" id="dia" name="dia" maxlength="2" style="width: 30px;" />
<label class="letra">mes:</label><input type="text" id="mes" name="mes" maxlength="2" style="width: 30px;" />
<label class="letra">a&ntilde;o:</label><input type="text" id="anio" name="anio" maxlength="4" style="width: 50px;" />
<input type="submit" id="enviar" name="enviar" value="Ver en Pantalla" />
<input type="submit" id="enviarxls" name="enviarxls" value="Generar en Excel" />

</form>
<div id="linke"></div>

<?php
if (isset($_POST['enviar'])){
    include('conectarunis.php');
    $dia=$_POST['dia'];
    $mes=$_POST['mes'];
    $anio=$_POST['anio'];
    $sala=$_POST['sala']; 
            if($sala=='Seleccione sede'){
                echo("Seleccione una sede");
                exit();
            }
            if(empty($dia)){
                echo("Digite dia");
                exit();
            }
            if(empty($mes)){
                echo("Digite mes");
                exit();
            }
            if(empty($anio)){
                echo("Digite año");
                exit();
            }
            if (strlen($dia)==1){
                $dia='0'.$dia;
            }
            if (strlen($mes)==1){
                $mes='0'.$mes;
            }
            $fecha=$anio.$mes.$dia;
            
            $result = mssql_query("SELECT * from tEnter WHERE C_Date='$fecha' and L_IsPicture='0' and L_TID='$sala' ORDER BY C_Name, Auto ASC ");
            
            //$resultado = mssql_fetch_array($result);
            //$contar=count($resultado);
            $con=1;
            $f=$dia."/".$mes."/".$anio;
            ?>
            <label>Fecha: <? echo $f;  ?></label><br />
            <table id="lista" border="1" style="border-color: coral;">
            <tr>
            <?
                echo "<td><b>No.</b></td>";
                echo "<td><b>HORA</b></td>";
                echo "<td><b>CEDULA</b></td>";
                echo "<td><b>NOMBRE</b></td>";
                echo "<td><b>EVENTO</b></td>";
                echo "</tr>";
            
            while ($fila = mssql_fetch_array($result)){
                $d1=$fila[2];
                $hora=substr($d1,0,2).":".substr($d1,2,2).":".substr($d1,4,2);
                $d2=$fila[4];
                //nombre
                $d3=utf8_decode($fila[5]);
                //$ceula=$fila[6];
                $d4=$fila[11];
                if($d4==1){
                    $modo='Entrada';
                }else if($d4==2){
                    $modo='Break';
                }else if($d4==3){
                    $modo='Entrada Break';
                }else if($d4==5){
                    $modo='Salida';
                }
                //echo $d2.":";
                //if (strlen($d3)<10){
                    //$result2 = mssql_query("SELECT * from audEmpleado",$cLink2);    //WHERE CodTarjeta LIKE '%$d2'
                    //echo "<script>";
                    //echo $d3="consultarDatos($d2);";
                    //echo "</script>";
                    /*//while ($fila2 = mssql_fetch_array($result2,$cLink2)){
                        //$contar=count($result2);
                        if ($result2) {
                            $fila2 = mssql_fetch_array($result2);
                            $tarjeta=$fila2[2];
                            $tam=strlen($tarjeta);
                            $tamn=$tam-8;
                            $id=substr($tarjeta,$tamn,$tam);
                            echo $id."---";
                        }
                        //Next($fila2);
                    //}
                    */
               // }
                echo "<tr>";
                echo "<td>".$con."</td>";
                echo "<td>".$hora."</td>";
                echo "<td>".$d2."</td>";
                echo "<td>".$d3."</td>";
                echo "<td>".$modo."</td>";
                echo "</tr>";
                $con++;
                Next($fila);
                
            }
            ?>
            </table>
            <?
    
    }
    //excel
    if(isset($_POST['enviarxls'])){
            include('conectarunis.php');
            //consulta el usuario
            $dia=$_POST['dia'];
            $mes=$_POST['mes'];
            $anio=$_POST['anio'];
            $sala=$_POST['sala'];
            if($sala=='Seleccione sede'){
                echo("Seleccione una sede");
                exit();
            }
            if(empty($dia)){
                echo("Digite dia");
                exit();
            }
            if(empty($mes)){
                echo("Digite mes");
                exit();
            }
            if(empty($anio)){
                echo("Digite año");
                exit();
            }
            if (strlen($dia)==1){
                $dia='0'.$dia;
            }
            if (strlen($mes)==1){
                $mes='0'.$mes;
            }
            $fecha=$anio.$mes.$dia;
            $result = mssql_query("SELECT * from tEnter WHERE C_Date='$fecha' and L_IsPicture='0' and L_TID='$sala' ORDER BY C_Name, Auto ASC ");
            $con=1;
            $fechita=$dia."/".$mes."/".$anio;
            
            
            if($result){
                $miruta='FIRMAVENDEDOR';
                $nombre_fichero = 'Informe_Capacitaciones';
                $mipath=$miruta.'/'.$nombre_fichero.'.xlsx';
                if(file_exists($miruta)) {
                    //Obteniendo el dato desde la celda:
                    //Para conseguir resultado usar la función getCalculatedValue() en reemplazo de getValue(
                    //$dato=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(x,y)->getValue();

                    //*************************creando nuevo*****************************************
                    include('Classes/PHPExcel.php');
                    include('Classes/PHPExcel/Reader/Excel2007.php');
                    //Crear el objeto Excel: 
                    $objPHPExcel = new PHPExcel();
                    //Configurando el archivo: 
                    $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                    $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo SAS");
                    $objPHPExcel->getProperties()->setTitle("Informe de Capacitaciones");
                    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                    $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                    $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
                    //Seleccionamos la hoja sobre la que queremos escribir 
                    //combinar celdas
                    $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
                    //titulos
                    $titulo='INFORME DE CAPACITACIONES '.$fechita;
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', $titulo);
                    //Alineacion
                    /*$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    // Color rojo al texto
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
                    */
                    //$objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                    //negilla
                    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                    //titulos
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', 'No.')
                            ->setCellValue('B2', 'HORA')
		                    ->setCellValue('C2', 'CEDULA')
                            ->setCellValue('D2', 'NOMBRE')
                            ->setCellValue('E2', 'EVENTO');
		                    //->setCellValue('F2', 'CANTIDAD')
		                    //->setCellValue('G2', 'EMPAQUE')
                            //->setCellValue('H2', 'CANT X EMPAQUE')
                            //->setCellValue('I2', 'TOT UNIDADES')
                            //->setCellValue('J2', 'ZONA');
                            
                    //negilla  
                    /*$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
                    //ANCHOR
                    */
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
                    
                    //$objPHPExcel->getActiveSheet()->getDimension('1')->setHeight(20);
                    //renombre de la hoja
                    $objPHPExcel->getActiveSheet()->setTitle("Informe Capacitaciones");
                    //datos
                    //$cantidadv=count($curs);
                    $j=0;
                    $f=3;
                    //while($row = $resultado->fetch_array(MYSQLI_NUM)){
                    while ($fila = mssql_fetch_array($result,MYSQLI_NUM)){
                            $num=$j+1;
                            $d1=$fila[2];
                            $hora=substr($d1,0,2).":".substr($d1,2,2).":".substr($d1,4,2);
                            $d2=$fila[4];
                            //nombre
                            $d3=utf8_decode($fila[5]);
                            //$ceula=$fila[6];
                            $d4=$fila[11];
                            if($d4==1){
                                $modo='Entrada';
                            }else if($d4==2){
                                $modo='Break';
                            }else if($d4==3){
                                $modo='Entrada Break';
                            }else if($d4==5){
                                $modo='Salida';
                            }
                                //$totp=$row[9]*$nxe;
                                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$f, $num)
                                ->setCellValue('B'.$f, $hora)
		                        ->setCellValue('C'.$f, $d2)
                                ->setCellValue('D'.$f, $d3)
		                        ->setCellValue('E'.$f, $modo);
                                
                                
                        //Alineacion
                        /*$objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('D'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('F'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        */
                        //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
                        $f++;
                        
                        //Colocamos el dato en la celda:  
                        //$objPHPExcel->getActiveSheet->setCellValue('A1','texto');
                        
                        //nueva hoja
                        //$objWorkSheet2 = $objPHPExcel->createSheet().
                        //$objWorkSheet2->SetTitle("Nombre Nueva Hoja");
                        //$objWorkSheet2->SetCellValue('A1','Contenido Celda A1');

                        //insertar formula
                        //$fila+=2;
                        //$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
                        //$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');
                        //recorrer las columnas
                        //foreach (range('A', 'B') as $columnID) {
                          //autodimensionar las columnas
                          //$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
                        //}
	                    $j++;
                        Next($fila);
                        //}	
                    }   //fin while
                    
                    //echo $mipath;
                    //***************guarda
                    //crear objeto writer
                    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
                    //Guardar el achivo: 
                    $objWriter->save($mipath);
                    //echo "<br /><br />";
                    $descarga=$nombre_fichero.".xlsx";
                    echo("<script language='JavaScript'>verLink('$descarga');</script>");
                }//fin si exists
                
        }//fin si
       }   
?>

</body>
</html>