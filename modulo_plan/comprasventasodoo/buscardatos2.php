<?php
//require_once('../user_con.php');
//require_once('user_con.php');
include_once 'usercon_odoo.php';
include('conectarbase.php');
$periodo=trim($_GET['periodo']);
$man=trim($_GET['man']);
$categ = new ArrayIterator(); 
$manejanom = new ArrayIterator(); 
$manejacat = new ArrayIterator(); 
//$periodo="202005";
$periodoi=substr($periodo,0,4);
$anio=$periodoi;
$periodoi=$periodoi."01";
$m=substr($periodo,4,2);

$inicial=$m-1;
$final=$m;
//mes anterior y actual
$mesant=$inicial;
$mesact=$final;
if (strlen($inicial)==1) {
    $inicial="0".$inicial;
}
if (strlen($final)==1) {
    $final="0".$final;
}
$inicial=$anio.$inicial;
$final=$anio.$final;
$mes=array('','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
$mm=intval($m);
$Ms=$mes[$mm]." ".$anio;
//evalua periodo anterior en caso de enero
if(intval($mesact)==1 || $mesact=="01"){
    $mesact=12;
    //año anterior y mes
    if(strlen($mesact)==1){
        $mesact="0".$mesact;
    }
    $anio=(intval($anio)-1);
    $peranterior=$anio.$mesact;
}else{
    $mesact=(intval($mesact)-1);
    if(strlen($mesact)==1){
        $mesact="0".$mesact;
    }
    $peranterior=$anio.$mesact;
}
//limpia array solo la primera vez no con los demas manejadores
$tamcg=count($categ);
for ($cg=0; $cg<=$tamcg; $cg++){
    $categ[$cg]="";
}

$tamcg=count($manejanom);
for ($cg=0; $cg<=$tamcg; $cg++){
    $manejanom[$cg]="";
}

$TotalCat=0;
$TotalMan=0;
//$mes=array('','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
//$mm=intval($m);
//$Ms=$mes[$mm]." ".$anio;

//echo $periodoi."  ".$periodo;
//exit();

//echo $tamcg."--";


                    /*
                    $sqlv = "TRUNCATE TABLE [InformesCompVentas].[dbo].[infVentasIbs]"; 
                    mssql_query($sqlv,$cLink);
                
                    $sql = "SELECT * FROM VISINFVENT WHERE PERIODO BETWEEN '$periodoi' AND '$periodo'";
                    $result = odbc_exec($db2con, $sql);
                    while($row = odbc_fetch_array($result)){
                        $dv1 = $row['IDPGRP'];
                        $dv2 = $row['PERIODO'];
                        $dv3 = $row['IDPLAN'];
                        $dv4 = $row['COSTO_TOTAL'];
                        //$dv4=number_format($dv4,0);
                        $dv5 = $row['VLR_EXC_IVA'];
                        //$dv5=number_format($dv5,0);
                        $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentasIbs](IDPGRP,PERIODO,IDPLAN,PBDESC,COSTO_TOTAL,VLR_EXC_IVA) 
                        VALUES('$dv1','$dv2','$dv3','','$dv4','$dv5')"; 
                        mssql_query($sqlv,$cLink);
                    }
                    */
                    
                    /*
                    //carga compras
                    $sqlc = "TRUNCATE TABLE [InformesCompVentas].[dbo].[infComprasIbs]"; 
                    mssql_query($sqlc,  $cLink);
       
                    $sql = "SELECT * FROM VISINFCOM WHERE PERIODO BETWEEN '$periodoi' AND '$periodo'";
                    $result = odbc_exec($db2con, $sql);
                    while($row = odbc_fetch_array($result)){
                        $dv1 = $row['PGPGRP'];
                        $dv2 = $row['PERIODO'];
                        $dv3 = '';//$row['IDPLAN'];
                        $dv4 = $row['VLR_EXC_IVA'];
                        //$dv5=number_format($dv4,0);
                        $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infComprasIbs](IDPGRP,PERIODO,IDPLAN,VLR_EXC_IVA) 
                        VALUES('$dv1','$dv2','$dv3','$dv4')"; 
                        mssql_query($sqlv,$cLink);
                    }
                    odbc_close($result);
                    //odbc_close($result2);
                    */
//echo "terminado";
//exit(); 
                                     

//nombre manejador   DISTINCT(RESPONSABLE), DESCRIPCION                 
$i=0;
//$j=0;
//$resultSQL = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] ORDER BY RESPONSABLE ASC");
if($man=="TODOS"){
    $resultSQL = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] ORDER BY RESPONSABLE ASC");
}
if($man=="MARTHA PINILLOS"){
    $resultSQL = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='MARTHA PINILLOS'");
}
if($man=="FELIPE BARON"){
    $resultSQL = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='FELIPE BARON'");
}
if($man=="FANNY RODRIGUEZ"){
    $resultSQL = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='FANNY RODRIGUEZ'");
}
if($man=="MARCELA SUAREZ"){
    $resultSQL = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='MARCELA SUAREZ'");
}
while($resultado = mssql_fetch_array($resultSQL)){
    $dato2=$resultado["RESPONSABLE"];
    $dato2=trim($dato2);    ///agregado
    $manejanom[$i]=trim($dato2);
    //categorias por manejador
    //$acumcat="";
    /*
    $j=0;
    $resultSQLCat = mssql_query("SELECT DISTINCT(DESCRIPCION) FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$dato2'");
    while($resultadocat = mssql_fetch_array($resultSQLCat)){
        $dato3=$dato3.$resultadocat["DESCRIPCION"]."__";
        $manejacat[$j]=$dato3;
        $j++;
    }*/
    //echo $manejacat[0].";";
    //exit();
    //$manejacat[$i]=($dato2).":".$acumcat;
    //echo $acumcat."_";
    $i++;
}   
//$c=count($manejacat);  
//$j=0;
//while($j<$c){
    
//}   
//exit();    
//if (in_array("Irix", $os)) {
//reporte del pdf
require('fpdf/fpdf.php');
            //P? es normal. El valor para apaisada es ?L
            
            class PDF extends FPDF
            {
                function Header(){
                    $x = 20; //pos x
                    $y = 10;  //pos y
                    $w = 10;  //ancho
                    $h = 10;  //alto
                    $fitbox=1;
                    $this->SetXY(8, 10);
                    //$this->Image('imagenesemp/logo-cym-plano.jpg', $x, $y, $w, $h, 'JPG', '', '', false, 80, '', false, false, 0, $fitbox, false, false);
                    //cabecera de la tabla
                        $fecha=date("d/m/Y");
                        $this->SetFont('Arial','B',12);
                        $this->SetFillColor(2,157,116);//Fondo verde de celda
                        $ejeX = 10;
                        $PosY=30;
                        
                        
                        $this->SetTextColor(0, 0, 0); //Letra color blanco
                        $this->SetXY(100, 20);
                        $this->Cell(10,7, 'INFORME DE COMPRAS Y VENTAS ACUMULADOS ODOO', 0, 'C', 'C','0','');
                        //$this->SetXY(95, 30);
                        //$this->Cell(10,7, utf8_decode('Fecha Informe: ').$fecha, 0, 'C', 'C','0','');
                        $this->SetFont('Arial','B',8);
                
                        $this->SetFillColor(2,157,116);//Fondo verde de celda
                        $this->SetTextColor(240, 255, 240); //Letra color blanco
                        //$pdf->SetXY(10, 12);
                        $this->SetXY(10, 30);
                        $ejeX = 10;
                        $PosY=30;
                                               
                    //$this->Ln(20);
                }
                function Footer()
                {
                    $this->SetY(-15);
                    $this->SetFont('Arial','I',8);
                    $this->Cell(0,10,'P. '.$this->PageNo().' / {nb}',0,0,'C');

                }
            }

            //datos CONTENIDO
            $pdf = new PDF('P','mm','Letter');
            $pdf->AliasNbPages(); //como queremos que se muestre el paginado
            $pdf->AddPage();    
            
            //$y2=$this->GetY();
            $ancho=7;
            $ejeY = 20;
            $Vacio="";
            $pdf->SetFont('Helvetica','',7);
            $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
            
            //**********************PINILLOSM*************************************************
            $dato2="";
            //ciclo de manejador
            if($man=="TODOS"){
                $tm = count($manejanom);         
            }else{
                $tm = 1;
            }
            //$tm = count($manejanom);
            $cm=0;
            $cambiodemaneja=0;    
            $TotVenCostoTT=0;
            $TotVenIvaTT=0;
            $TotComIvaTT=0;
            $TotMesIniTT=0;
            $TotMesFinTT=0;
            $TotVenAcuIvaTT=0;
            $TotComAcumIvaTT=0;
            $TotVenCostoTT=0;
            //$cambiodecatego=0;
            while($cm < $tm){
                
                $datob="";
                $man="";
                
                if (trim($manejanom[$cm])=="MARTHA PINILLOS")
                    $manejador="PINILLOSM";
                if (trim($manejanom[$cm])=="FELIPE BARON")
                    $manejador="BARONF";
                if (trim($manejanom[$cm])=="FANNY RODRIGUEZ")
                    $manejador="RODRIGUEZF";
                if (trim($manejanom[$cm])=="MARCELA SUAREZ")
                    $manejador="SUAREZM"; 
                
                $ejeY=$ejeY+7;
                $pdf->SetXY (70,$ejeY);
                $pdf->SetFont('Arial','B',12);
                //$pdf->SetFillColor(2,157,116);
                //$pdf->Cell(50,$ancho, $Ms,0, 'C' , 'C' );
                if(strlen($Ms)>=12){
                    $pdf->Cell(70,$ancho, $Ms,0, 'C' , 'C' );
                }else{
                    $pdf->Cell(80,$ancho, $Ms,0, 'C' , 'C' );
                }
                $pdf->SetFont('Arial','',7);
                $ejeY=$ejeY+7; 
                               
                //titulos
                $nom_maneja=trim($manejanom[$cm]);
                //nombre manejador 
                $pdf->SetXY (10,$ejeY);
                $pdf->SetFont('Arial','B',12);
                //$pdf->SetFillColor(2,157,116);
                $pdf->Cell(30,$ancho, $manejanom[$cm],0, 'C' , 'L' );
                $pdf->SetFont('Arial','',7);
                $ejeY=$ejeY+7; 
                
                //verifica CATEGORIAS***
                $TotVenCosto=0;
                $TotVenIva=0;
                $TotComIva=0;
                $TotMesIni=0;
                $TotMesFin=0;
                $filsql=0;
                
                $TotVenCostoT=0;
                $TotVenIvaT=0;
                $TotComIvaT=0;
                $TotMesIniT=0;
                $TotMesFinT=0;
                
                
                
                
                
                $resultSQLCat = mssql_query("SELECT DISTINCT(DESCRIPCION) FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='$nom_maneja'");
            while($resultadocat = mssql_fetch_array($resultSQLCat)){
                    //CATEGORIA
                    //$d1=$resultadoTot["CTPPGN"]; //no estaba
                    $descri=$resultadocat["DESCRIPCION"];
                    
                    //ESTABA $resultSQLTot = mssql_query("SELECT CTPPGN, CTPPGD, DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$nom_maneja' ORDER BY DESCRIPCION ASC");
                    $resultSQLTot = mssql_query("SELECT CTPPGN, CTPPGD, DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='$nom_maneja' AND DESCRIPCION='$descri' ORDER BY CTPPGN ASC");
                    //ciclo ITEMS
                    
                    
                        if($ejeY+14 >= 210){
                            $ejeY=20;
                            $pdf->AddPage();
                            //ojis
                            $ejeY=$ejeY+7;
                            $pdf->SetXY (70,$ejeY);
                            $pdf->SetFont('Arial','B',12);
                            //$pdf->Cell(50,$ancho, $Ms,0, 'C' , 'C' );
                            if(strlen($Ms)>=12){
                                $pdf->Cell(70,$ancho, $Ms,0, 'C' , 'C' );
                            }else{
                                $pdf->Cell(80,$ancho, $Ms,0, 'C' , 'C' );
                            }
                            $pdf->SetFont('Arial','',7);
                            $ejeY=$ejeY+7;
                            //manejador
                            $pdf->SetXY (10,$ejeY);
                            $pdf->SetFont('Arial','B',12); 
                            $pdf->Cell(20,$ancho, $manejanom[$cm],0, 'C' , 'L' );
                            $pdf->SetFont('Arial','',7);
                            $ejeY=$ejeY+7;
                        }
                
                        $ejeY=$ejeY+7; 
                        //$pdf->SetXY (20,$ejeY);
                        //$pdf->SetFont('Arial','B',10);
                        //$pdf->SetFillColor(2,157,116);
                        //$pdf->Cell(30,$ancho, $descri,0, 'C' , 'L' );
            
                        //$ejeY=$ejeY+7; 
                                //titulos atras  ARREGLADO
                        $pdf->SetXY (10,$ejeY);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->SetFillColor(2,157,116);
                        $pdf->Cell(30,$ancho, $descri,0, 'C' , 'L' );
                        $ejeY=$ejeY+7;
                        
                        $pdf->SetFillColor(231,229,228); //gris
                        $pdf->SetFont('Arial','B',9);
                        $pdf->SetXY (10,$ejeY);
                        $pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
                                //DESCRIPCION
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(40,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                                //INV INICIAL
                        $pdf->SetXY (60,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.INICIAL'),1, 'C' , 'C', 1 );
                                //VENAS
                        $pdf->SetXY (80,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('VENTAS'),1, 'C' , 'C', 1 );
                                //VENTAS ACUMULADAS
                        $pdf->SetXY (100,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('VEN ACU'),1, 'C' , 'C', 1 );
                                //MARGEN
                        $pdf->SetXY (120,$ejeY);
                        $pdf->Cell(10,$ancho-2, utf8_decode('MARG'),1, 'C' , 'C', 1 );
                                //COSTO
                        $pdf->SetXY (130,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COST ACU'),1, 'C' , 'C', 1 );
                                //COMPRAS
                        $pdf->SetXY (150,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COMPRAS'),1, 'C' , 'C', 1 );
                                //COMPRAS ACUMULADAS
                        $pdf->SetXY (170,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COM ACU'),1, 'C' , 'C', 1 );
                                //INV FINAL
                        $pdf->SetXY (190,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.FINAL'),1, 'C' , 'C', 1 );
                        $pdf->SetFont('Arial','',7);  
                                //$ejeY=$ejeY+7; 
                
                while($resultadoTot = mssql_fetch_array($resultSQLTot)){
                    $d1=$resultadoTot["CTPPGN"];
                    $descgrp=$resultadoTot["CTPPGD"];
                    
                    $acumi=0;
                    $acumf=0;
                    $vcomp=0;
                    
                    //ventas AND IDPLAN='$manejador'
                    //$resultSQL = mssql_query("SELECT COSTO_TOTAL, VLR_EXC_IVA FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='$periodo' AND IDPGRP='$d1'");
                    $resultSQL = mssql_query("SELECT SUM(COSTO_TOTAL) AS COSTO_TOTAL, SUM(VLR_EXC_IVA) AS VLR_EXC_IVA FROM [InformesCompVentas].[dbo].[infVentasIbsOdoo] WHERE PERIODO='$periodo' AND IDPGRP='$d1'");
                    $resultadoSql = mssql_fetch_array($resultSQL);
                    //$d3=$resultadoSql["COSTO_TOTAL"];
                    $d4=$resultadoSql["VLR_EXC_IVA"];
                    //$TotVenCosto=$TotVenCosto + $d3;
                    $TotVenIva=$TotVenIva + $d4;
                   
                    //***
                    $TotVenCostoT=$TotVenCostoT+$d3;
                    $TotVenIvaT=$TotVenIvaT + $d4;
                    //IDPLAN='$manejador' AND
                    //ventas acumuladas
                    $resultSQL = mssql_query("SELECT SUM(COSTO_TOTAL) AS CT, SUM(VLR_EXC_IVA)AS VT FROM [InformesCompVentas].[dbo].[infVentasIbsOdoo] WHERE PERIODO BETWEEN '$periodoi' AND '$periodo' AND IDPGRP='$d1'");
                    $resultadoSql = mssql_fetch_array($resultSQL);
                    //costo acumulado
                    //$d3acu=$resultadoSql["COSTO_TOTAL"];
                    $d3acu=$resultadoSql["CT"];
                    //ventas acumuladas
                    //$d4acu=$resultadoSql["VLR_EXC_IVA"];
                    $d4acu=$resultadoSql["VT"];
                    //sumatoria costo
                    $TotVenAcuCosto=$TotVenAcuCosto + $d3acu;
                    //sumatoria ventas
                    $TotVenAcuIva=$TotVenAcuIva + $d4acu;
                    //sumatoria totales costo x cat
                    $TotVenAcuCostoT=$TotVenAcuCostoT + $d3acu;//**/
                    //sumatoria totales ventas x cate
                    $TotVenAcuIvaT=$TotVenAcuIvaT + $d4acu;
                    
                    //compras
                    $resultSQL = mssql_query("SELECT VLR_EXC_IVA FROM [InformesCompVentas].[dbo].[infComprasIbsOdoo] WHERE PERIODO='$periodo' AND IDPGRP='$d1'");
                    $resultadoSql = mssql_fetch_array($resultSQL);
                    $vcomp=$resultadoSql["VLR_EXC_IVA"];
                    $TotComIva=$TotComIva + $vcomp;
                    $TotComIvaT=$TotComIvaT + $vcomp;
                    
                    //compras acumuladas
                    $resultSQL = mssql_query("SELECT SUM(VLR_EXC_IVA) AS CA FROM [InformesCompVentas].[dbo].[infComprasIbsOdoo] WHERE PERIODO BETWEEN '$periodoi' AND '$periodo' AND IDPGRP='$d1'");
                    $resultadoSql = mssql_fetch_array($resultSQL);
                    //compras acumuladas
                    //$vcomp=$resultadoSql["VLR_EXC_IVA"];
                    $vcompAcum=$resultadoSql["CA"];
                    //sumatoria subtotales compras
                    $TotComAcumIva=$TotComAcumIva + $vcompAcum;
                    //sumatoria totales compras x cat 
                    $TotComAcumIvaT=$TotComAcumIvaT + $vcompAcum;
                    
                    
                    
                    //nuevas hojas
                    if($ejeY>210){
                        
                        $ejeY=20;
                        $pdf->AddPage();
                        
                        //ojis
                        $ejeY=$ejeY+7;
                        $pdf->SetXY (70,$ejeY);
                        $pdf->SetFont('Arial','B',12);
                        //$pdf->Cell(50,$ancho, $Ms,0, 'C' , 'C' );
                        if(strlen($Ms)>=12){
                            $pdf->Cell(70,$ancho, $Ms,0, 'C' , 'C' );
                        }else{
                            $pdf->Cell(80,$ancho, $Ms,0, 'C' , 'C' );
                        }
                        $pdf->SetFont('Arial','',7);
                        $ejeY=$ejeY+7;
                        
                        //nombre manejador 
                        $ejeY=$ejeY+7;
                        $pdf->SetXY (10,$ejeY);
                        $pdf->SetFont('Arial','B',12);
                        //$pdf->SetFillColor(2,157,116);
                        $pdf->Cell(30,$ancho, $manejanom[$cm],0, 'C' , 'L' );
                        $pdf->SetFont('Arial','',7);
                        $ejeY=$ejeY+7;
                        //TITULOS  
                        $pdf->SetXY (10,$ejeY);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->SetFillColor(2,157,116);
                        $pdf->Cell(30,$ancho, $descri,0, 'C' , 'L' );
                        $ejeY=$ejeY+7;
                        //titulos atras  ARREGLADO
                        $pdf->SetFillColor(231,229,228); //gris
                        $pdf->SetFont('Arial','B',9);
                        $pdf->SetXY (10,$ejeY);
                        $pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
                                //DESCRIPCION
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(40,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                                //INV INICIAL
                        $pdf->SetXY (60,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.INICIAL'),1, 'C' , 'C', 1 );
                                //VENAS
                        $pdf->SetXY (80,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('VENTAS'),1, 'C' , 'C', 1 );
                                //VENTAS ACUMULADAS
                        $pdf->SetXY (100,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('VEN ACU'),1, 'C' , 'C', 1 );
                                //MARGEN
                        $pdf->SetXY (120,$ejeY);
                        $pdf->Cell(10,$ancho-2, utf8_decode('MARG'),1, 'C' , 'C', 1 );
                                //COSTO
                        $pdf->SetXY (130,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COST ACU'),1, 'C' , 'C', 1 );
                                //COMPRAS
                        $pdf->SetXY (150,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COMPRAS'),1, 'C' , 'C', 1 );
                                //COMPRAS ACUMULADAS
                        $pdf->SetXY (170,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COM ACU'),1, 'C' , 'C', 1 );
                                //INV FINAL
                        $pdf->SetXY (190,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.FINAL'),1, 'C' , 'C', 1 );
                        $pdf->SetFont('Arial','',7);  
                        
                    }
                   
                    
                     //sql server
                    //$resultSQL1 = mssql_query("SELECT * FROM infConsolidadoInvAnt WHERE GRUPO='$d1' AND PERIODO='$inicial'");
                    $resultSQL1 = mssql_query("SELECT * FROM infConsolidadoInvSigOdoo WHERE GRUPO='$d1' AND PERIODO='$peranterior'");
                    $resultado1 = mssql_fetch_array($resultSQL1);            
                    //$numero = $resultado->num_rows;
                    if($resultado1){
                         $acumi=$resultado1["COSTO_TOTAL"];
                         $TotMesIni=$TotMesIni + $acumi;
                         $TotMesIniT=$TotMesIniT + $acumi;
                    }
                    
                    
                     //sql server
                    $resultSQL2 = mssql_query("SELECT * FROM infConsolidadoInvSigOdoo WHERE GRUPO='$d1' AND PERIODO='$final'");
                    $resultado2 = mssql_fetch_array($resultSQL2);            
                    //$numero = $resultado->num_rows;
                    if($resultado2){
                         $acumf=$resultado2["COSTO_TOTAL"];
                         $TotMesFin=$TotMesFin + $acumf;
                         $TotMesFinT=$TotMesFinT + $acumf;
                    }
                    
                    //TABLA DE DATOS
                    
                    //GRP
                    $ejeY = $ejeY+7;
                    $pdf->SetXY (10,$ejeY);
                    $pdf->Cell(10,$ancho, $d1,1, 'C' , 'C' );
                    
                    $pdf->SetXY (20,$ejeY);
                    $pdf->SetFont('Arial','',6);
                    $pdf->Cell(40,$ancho, $descgrp,1, 'C' , 'C' );
                    $pdf->SetFont('Arial','',7);
                    //INV INICIAL
                    $pdf->SetXY (60,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($acumi),1, 'C' , 'R' );
                    //VENTAS
                    $pdf->SetXY (80,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($d4),1, 'C' , 'R' );
                    //VENTAS ACUM
                    $pdf->SetXY (100,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($d4acu),1, 'C' , 'R' );
                    //MARGEN
                    $pdf->SetXY (120,$ejeY);
                    //(ventas-costo)/ventas
                    if($d4>0){
                        $margen=($d4acu-$d3acu)/$d4acu;
                        $margen=round($margen,4);
                        $margen=($margen*100)."%"; 
                    }else{
                        $margen="0";
                    }
                    $pdf->Cell(10,$ancho, $margen,1, 'C' , 'C' );
                    //COSTO
                    $pdf->SetXY (130,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($d3acu),1, 'C' , 'R' );
                    //COMPRAS
                    $pdf->SetXY (150,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($vcomp),1, 'C' , 'R' );
                    //COMPRAS ACUM
                    $pdf->SetXY (170,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($vcompAcum),1, 'C' , 'R' );
                    //INV FINAL
                    $pdf->SetXY (190,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($acumf),1, 'C' , 'R' );
                 
                               
                } 
                
                //SUBTOTALES
                              
                $ejeY = $ejeY+7;
                
                $pdf->SetXY (20,$ejeY);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(40,$ancho, 'SUBTOTAL $',1, 'C' , 'C' );
                $pdf->SetFont('Arial','',7);
                
                $pdf->SetXY (60,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesIni),1, 'C' , 'R' );
                $TotMesIni=0;
                //VENTAS MES
                $pdf->SetXY (80,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenIva),1, 'C' , 'R' );
                
                if($TotVenIva>0){
                        $margenS=($TotVenAcuIva-$TotVenAcuCosto)/$TotVenAcuIva;
                        $margenS=round($margenS,4);
                        $margenS=($margenS*100)."%"; 
                    }else{
                        $margenS="0";
                    }
                    
                $TotVenIva=0;
                
                //VENTAS ACUM
                $pdf->SetXY (100,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenAcuIva),1, 'C' , 'R' );
                $TotVenAcuIva=0;
                
                $pdf->SetXY (120,$ejeY);
                $pdf->Cell(10,$ancho, $margenS,1, 'C' , 'C' );
                
                //COSTO
                $pdf->SetXY (130,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenAcuCosto),1, 'C' , 'R' );
                $TotVenAcuCosto=0;
                    
                //COMPRAS
                $pdf->SetXY (150,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotComIva),1, 'C' , 'R' );
                $TotComIva=0;
                
                //COMPRAS ACUM
                $pdf->SetXY (170,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotComAcumIva),1, 'C' , 'R' );
                $TotComAcumIva=0;
                
                //INV FINAL
                $pdf->SetXY (190,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesFin),1, 'C' , 'R' );
                $TotMesFin=0;
                
                
                //$cambiodecatego=0;
                //LLAVE AGREGADA CATEGORIAS
                }
                
                //TOTALES***
                
                $ejeY = $ejeY+7;
                
                $pdf->SetXY (20,$ejeY);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(40,$ancho, 'TOTAL $',1, 'C' , 'C' );
                $pdf->SetFont('Arial','',7);
                
                //SUBTOTAL1
                $pdf->SetXY (60,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesIniT),1, 'C' , 'R' );
                $TotMesIniTT=$TotMesIniTT+$TotMesIniT;
                $TotMesIniT=0;
                
                $pdf->SetXY (80,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenIvaT),1, 'C' , 'R' );
                $TotVenIvaTT=$TotVenIvaTT+$TotVenIvaT;
                
                if($TotVenIvaT>0){
                        $margenT=($TotVenAcuIvaT-$TotVenAcuCostoT)/$TotVenAcuIvaT;
                        $margenT=round($margenT,4);
                        $margenT=($margenT*100)."%"; 
                    }else{
                        $margenT="0";
                    }
                
                $TotVenIvaT=0;
                
                //VENTAS ACUM
                $pdf->SetXY (100,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenAcuIvaT),1, 'C' , 'R' );
                $TotVenAcuIvaTT=$TotVenAcuIvaTT + $TotVenAcuIvaT;
                $TotVenAcuIvaT=0;
                
                $pdf->SetXY (120,$ejeY);
                $pdf->Cell(10,$ancho, $margenT,1, 'C' , 'C' );
                
                
                //COSTO
                $pdf->SetXY (130,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenAcuCostoT),1, 'C' , 'R' );
                $TotVenCostoTT=$TotVenCostoTT+$TotVenAcuCostoT;
                $TotVenAcuCostoT=0;
                    
                //COMPRAS
                $pdf->SetXY (150,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotComIvaT),1, 'C' , 'R' );
                $TotComIvaTT=$TotComIvaTT+$TotComIvaT;
                $TotComIvaT=0;
                
                //COMPRAS ACUM
                $pdf->SetXY (170,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotComAcumIvaT),1, 'C' , 'R' );
                $TotComAcumIvaTT=$TotComAcumIvaTT + $TotComAcumIvaT;
                $TotComAcumIvaT=0;
                
                //INV FINAL
                $pdf->SetXY (190,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesFinT),1, 'C' , 'R' );
                $TotMesFinTT=$TotMesFinTT+$TotMesFinT;
                $TotMesFinT=0;
                       
                        
                $ejeY=20;
                $pdf->AddPage();
                      
                        
            
            $cm++;
            $cambiodemaneja=1;
            //PIN
            //$cambiodecatego=1;
           
           $ejeY=$ejeY+7;
           $pdf->SetXY (20,$ejeY);
           $pdf->SetFont('Arial','B',12);
                        
             if ($cm == $tm){
                $ejeY=$ejeY+7;
                $pdf->SetXY (70,$ejeY);
                $pdf->SetFont('Arial','B',12);
                if(strlen($Ms)>=12){
                    $pdf->Cell(70,$ancho, $Ms,0, 'C' , 'C' );
                }else{
                    $pdf->Cell(80,$ancho, $Ms,0, 'C' , 'C' );
                }
                $pdf->SetFont('Arial','',7);
                        
                $ejeY = $ejeY+12;
                $pdf->SetFont('Arial','B',10);
                        //DESCRIPCION
                        //titulos atras  ARREGLADO
                $pdf->SetFillColor(231,229,228); //gris
                $pdf->SetFont('Arial','B',9);
                //$pdf->SetXY (10,$ejeY);
                //$pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
                                //DESCRIPCION
                $pdf->SetXY (20,$ejeY);
                $pdf->Cell(40,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                                //INV INICIAL
                $pdf->SetXY (60,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('INV.INICIAL'),1, 'C' , 'C', 1 );
                                //VENAS
                $pdf->SetXY (80,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('VENTAS'),1, 'C' , 'C', 1 );
                                //VENTAS ACUMULADAS
                $pdf->SetXY (100,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('VEN ACU'),1, 'C' , 'C', 1 );
                                //MARGEN
                $pdf->SetXY (120,$ejeY);
                $pdf->Cell(10,$ancho-2, utf8_decode('MARG'),1, 'C' , 'C', 1 );
                                //COSTO
                $pdf->SetXY (130,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('COST ACU'),1, 'C' , 'C', 1 );
                                //COMPRAS
                $pdf->SetXY (150,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('COMPRAS'),1, 'C' , 'C', 1 );
                                //COMPRAS ACUMULADAS
                $pdf->SetXY (170,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('COM ACU'),1, 'C' , 'C', 1 );
                                //INV FINAL
                $pdf->SetXY (190,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('INV.FINAL'),1, 'C' , 'C', 1 );
                $pdf->SetFont('Arial','',7);  
                    
                $ejeY = $ejeY+7;
                    
                $pdf->SetXY (20,$ejeY);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(40,$ancho, 'TOTAL EMP $',1, 'C' , 'C' );
                $pdf->SetFont('Arial','',7);
                    
                    //TOTAL
                $pdf->SetXY (60,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesIniTT),1, 'C' , 'R' );
                $TotMesIniTT=0;
                    
                $pdf->SetXY (80,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenIvaTT),1, 'C' , 'R' );
                    //$TotVenIvaTT=0;
                if($TotVenIvaTT>0){
                    $margenTT=($TotVenAcuIvaTT-$TotVenCostoTT)/$TotVenAcuIvaTT;
                    $margenTT=round($margenTT,4);
                    $margenTT=($margenTT*100)."%"; 
                }else{
                    $margenTT="0";
                }
                $TotVenIvaTT=0;
                    
                    //ventas acumuladas
                $pdf->SetXY (100,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenAcuIvaTT),1, 'C' , 'R' );
                $TotVenAcuIvaTT=0;    
                    
                $pdf->SetXY (120,$ejeY);
                $pdf->Cell(10,$ancho, $margenTT,1, 'C' , 'C' );
                    
                    //COSTO
                $pdf->SetXY (130,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenCostoTT),1, 'C' , 'R' );
                $TotVenCostoTT=0;
                        
                    //COMPRAS
                $pdf->SetXY (150,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotComIvaTT),1, 'C' , 'R' );
                $TotComIvaTT=0;
                    
                    //compras acumuladas
                $pdf->SetXY (170,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotComAcumIvaTT),1, 'C' , 'R' );
                $TotComAcumIvaTT=0;
                    
                    //INV FINAL
                $pdf->SetXY (190,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesFinTT),1, 'C' , 'R' );
                $TotMesFinTT=0;
             }           
                        
    }
            
                
            
            $ejeY=$ejeY+20;
            $pdf->SetXY (95,$ejeY);
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(30,$ancho, '***FIN INFORME***',0, 'C' , 'C' );
            
            $cod=time()+1;
            $nombrearc="pdf/INFORME_COMPRAS_VENTAS_MES_ACUMULADO_ODOO.pdf";
            $pdf->Output($nombrearc,"F"); 
            /*FIN PDF*/
            
            
            
            //odbc_close($result);
            //odbc_close($result2);
            mssql_close();
           
?>