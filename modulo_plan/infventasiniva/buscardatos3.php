<?php
//require_once('../user_con.php');
require_once('user_con.php');
include('conectarbase.php');
$categ = new ArrayIterator(); 
$manejanom = new ArrayIterator(); 
$manejacat = new ArrayIterator(); 
//periodo año actual
$periodo=trim($_GET['periodo']);
//$periodo="202004";
$periodoi=substr($periodo,0,4);
$anio=$periodoi;
$periodoi=$periodoi."01";
$m=substr($periodo,4,2);

//periodos año anterior
$anioant=$anio-1;
$periodoiant=$anioant."01";
$m_ant=substr($periodo,4,2);
//periodo año anterior mismo mes actual
$periodoant=$anioant.$m_ant;

$inicial=$m-1;
$final=$m;
//mes anterior y actual
//$mesant=$inicial;
//$mesact=$final;
if (strlen($inicial)==1) {
    $inicial="0".$inicial;
}
if (strlen($final)==1) {
    $final="0".$final;
}
$inicial=$anio.$inicial;
$final=$anio.$final;
//evalua periodo anterior en caso de enero
/*if(intval($mesact)==1 || $mesact=="01"){
    $mesact=12;
    //año anterior y mes
    $anio=(intval($anio)-1);
    $peranterior=$anio.$mesact;
}else{
    $mesact=(intval($mesact)-1);
    if(strlen($mesact)==1){
        $mesact="0".$mesact;
    }
    $peranterior=$anio.$mesact;
}*/
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
$mes=array('','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
$mm=intval($m);
$Ms=$mes[$mm]." ".$anio;


                    
                    //$sqlv = "TRUNCATE TABLE [InformesCompVentas].[dbo].[infVentasIbs]"; 
                    //mssql_query($sqlv,$cLink);
                
                    //$sql = "SELECT * FROM VISINFVENT WHERE PERIODO BETWEEN '$periodoi' AND '$periodo'";
                    /*$sql = "SELECT * FROM VISINFVENT WHERE PERIODO BETWEEN '202001' AND '202005'";
                    $result = odbc_exec($db2con, $sql);
                    while($row = odbc_fetch_array($result)){
                        $dv1 = $row['IDPGRP'];
                        $dv2 = $row['PERIODO'];
                        $dv3 = ''; // $row['IDPLAN'];
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
$resultSQL = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] ORDER BY RESPONSABLE ASC");
while($resultado = mssql_fetch_array($resultSQL)){
    $dato2=$resultado["RESPONSABLE"];
    $dato2=trim($dato2);    ///agregado
    $manejanom[$i]=trim($dato2);
    $i++;
}   

 $TotVenIvaAntEmpresaTT=0;
 $TotVenIvaEmpresaTT=0;
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
                        $this->SetXY(105, 20);
                        $this->Cell(10,7, 'INFORME DE VENTAS AÑO ANTERIOR vs ACTUAL', 0, 'C', 'C','0','');
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
            
            $ancho=7;
            $ejeY = 20;
            $Vacio="";
            $pdf->SetFont('Helvetica','',7);
            $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
            
            //**********************PINILLOSM*************************************************
            $dato2="";
            //ciclo de manejador
            $tm = count($manejanom);
            
            //variables total empresa
            $cambiodemaneja=0; 
     //sumatoria de toda la empresa
    
     $cm=0;       
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
            
                //titulos
                $nom_maneja=trim($manejanom[$cm]);
               
                
            $resultSQLCat = mssql_query("SELECT DISTINCT(DESCRIPCION) FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$nom_maneja'");
            while($resultadocat = mssql_fetch_array($resultSQLCat)){
                    //CATEGORIAS

                    $descri=$resultadocat["DESCRIPCION"];
                    
                    //ESTABA $resultSQLTot = mssql_query("SELECT CTPPGN, CTPPGD, DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$nom_maneja' ORDER BY DESCRIPCION ASC");
                    $resultSQLTot = mssql_query("SELECT CTPPGN, CTPPGD, DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$nom_maneja' AND DESCRIPCION='$descri' ORDER BY DESCRIPCION ASC");
                    //ciclo ITEMS
                    
                    while($resultadoTot = mssql_fetch_array($resultSQLTot)){
                        $d1=$resultadoTot["CTPPGN"];
                        $descgrp=$resultadoTot["CTPPGD"];
                        
                        $d4=0;
                        $d4anterior=0;
                        
                        //$resultSQLA = mssql_query("SELECT * FROM infVentasIbs WHERE PERIODO='$periodoant' AND IDPGRP='$d1'");
                        $resultSQLA = mssql_query("SELECT SUM(VLR_EXC_IVA) AS T1 FROM infVentasIbs WHERE PERIODO='$periodoant' AND IDPGRP='$d1'");
                        $resultadoSqlA = mssql_fetch_array($resultSQLA);
                        //$d4anterior=$resultadoSqlA["VLR_EXC_IVA"];
                        $d4anterior=$resultadoSqlA["T1"];
                        //subtotal x categoria
                        $TotVenIvaAntEmpresa1=$TotVenIvaAntEmpresa1 + $d4anterior;
                       
                        //ventas año presente $periodo
                        $resultSQLB = mssql_query("SELECT SUM(VLR_EXC_IVA) AS T2 FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='$periodo' AND IDPGRP='$d1'");
                        $resultadoSqlB = mssql_fetch_array($resultSQLB);
                        //$d4=$resultadoSqlB["VLR_EXC_IVA"];
                        $d4=$resultadoSqlB["T2"];
                        //subtotal x categoria
                        $TotVenIvaEmpresa1=$TotVenIvaEmpresa1 + $d4;
                        
                        //***
                        
                    } 
                //fin while
                //total x categoria
                
                $TotVenIvaAntEmpresaT=$TotVenIvaAntEmpresaT + $TotVenIvaAntEmpresa1;
                $TotVenIvaAntEmpresa1=0;
                $TotVenIvaEmpresaT=$TotVenIvaEmpresaT + $TotVenIvaEmpresa1;
                $TotVenIvaEmpresa1=0;
                
               
                
                //LLAVE AGREGADA CATEGORIAS
        }
       
        
        $TotVenIvaAntEmpresaTT=$TotVenIvaAntEmpresaTT + $TotVenIvaAntEmpresaT;
        $TotVenIvaAntEmpresaT=0;
        $TotVenIvaEmpresaTT=$TotVenIvaEmpresaTT + $TotVenIvaEmpresaT;        
        $TotVenIvaEmpresaT=0;
                
        $cm++;
      
                        
    }
     
              
    //inicio**********************************************************************************
    $cm=0;       
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
                
                if ($pdf->PageNo()==1){
                    $ejeY=$ejeY+7;
                }
                $pdf->SetXY (70,$ejeY);
                $pdf->SetFont('Arial','B',12);
                //$pdf->SetFillColor(2,157,116);
                //$pdf->Cell(50,$ancho, $Ms,0, 'C' , 'C' );
                if(strlen($Ms)>=12){
                    $pdf->Cell(75,$ancho, $Ms,0, 'C' , 'C' );
                }else{
                    $pdf->Cell(85,$ancho, $Ms,0, 'C' , 'C' );
                }
                $pdf->SetFont('Arial','',7);
                $ejeY=$ejeY+7; 
                               
                //titulos
                $nom_maneja=trim($manejanom[$cm]);
                //nombre manejador 
                $pdf->SetXY (20,$ejeY);
                $pdf->SetFont('Arial','B',12);
                //$pdf->SetFillColor(2,157,116);
                $pdf->Cell(20,$ancho, $manejanom[$cm],0, 'C' , 'L' );
                $pdf->SetFont('Arial','',7);
                if ($pdf->PageNo()>1){
                    $ejeY=$ejeY+7; 
                }
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
                
            $resultSQLCat = mssql_query("SELECT DISTINCT(DESCRIPCION) FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$nom_maneja'");
            while($resultadocat = mssql_fetch_array($resultSQLCat)){
                    //CATEGORIA
                    //$d1=$resultadoTot["CTPPGN"]; //no estaba
                    $descri=$resultadocat["DESCRIPCION"];
                    
                    //ESTABA $resultSQLTot = mssql_query("SELECT CTPPGN, CTPPGD, DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$nom_maneja' ORDER BY DESCRIPCION ASC");
                    $resultSQLTot = mssql_query("SELECT CTPPGN, CTPPGD, DESCRIPCION FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE RESPONSABLE='$nom_maneja' AND DESCRIPCION='$descri' ORDER BY DESCRIPCION ASC");
                    //ciclo ITEMS
                    
                    if($ejeY+14 >= 210){
                        $ejeY=20;
                        $pdf->AddPage();
                        //aqui agruegue manejador faltante en hojas anteriores incompletas
                        $ejeY=$ejeY+7;
                        $pdf->SetXY (70,$ejeY);
                        $pdf->SetFont('Arial','B',12);
                        //$pdf->Cell(50,$ancho, $Ms,0, 'C' , 'C' );
                        if(strlen($Ms)>=12){
                            $pdf->Cell(75,$ancho, $Ms,0, 'C' , 'C' );
                        }else{
                            $pdf->Cell(85,$ancho, $Ms,0, 'C' , 'C' );
                        }
                        $pdf->SetFont('Arial','',7);
                        $ejeY=$ejeY+7;
                        //manejador
                        $pdf->SetXY (20,$ejeY);
                        $pdf->SetFont('Arial','B',12); 
                        $pdf->Cell(20,$ancho, $manejanom[$cm],0, 'C' , 'L' );
                        $pdf->SetFont('Arial','',7);
                        $ejeY=$ejeY+7;
                    }
                    
                    //menu
                    $ejeY=$ejeY+7; 
                        //$pdf->SetXY (20,$ejeY);
                        //$pdf->SetFont('Arial','B',10);
                        //$pdf->SetFillColor(2,157,116);
                        //$pdf->Cell(30,$ancho, $descri."xx",0, 'C' , 'L' );
            
                        //$ejeY=$ejeY+7; 
                        //titulos atras
                        //TITULOS  
                        $pdf->SetXY (20,$ejeY);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->SetFillColor(2,157,116);
                        $pdf->Cell(30,$ancho, $descri,0, 'C' , 'L' );
                        $ejeY=$ejeY+7;
                        //titulos ya
                        $pdf->SetFillColor(231,229,228); //gris
                        $pdf->SetFont('Arial','B',8);
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
                        //DESCRIPCION
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(60,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                        //INV INICIAL
                        $pdf->SetXY (80,$ejeY);
                        $pdf->Cell(25,$ancho-2, utf8_decode('VENT ').$anioant,1, 'C' , 'C', 1 );
                        //VENAS
                        $pdf->SetXY (105,$ejeY);
                        $pdf->Cell(18,$ancho-2, utf8_decode('% PARTIC'),1, 'C' , 'C', 1 );
                        //MARGEN
                        $pdf->SetXY (123,$ejeY);
                        $pdf->Cell(25,$ancho-2, utf8_decode('VENT ').$anio,1, 'C' , 'C', 1 );
                        //COSTO
                        $pdf->SetXY (148,$ejeY);
                        $pdf->Cell(18,$ancho-2, utf8_decode('%PARTIC'),1, 'C' , 'C', 1 );
                        //COMPRAS
                        $pdf->SetXY (166,$ejeY);
                        $pdf->Cell(25,$ancho-2, utf8_decode('DIFERENCIA'),1, 'C' , 'C', 1 );
                        //INV FINAL
                        $pdf->SetXY (191,$ejeY);
                        $pdf->Cell(15,$ancho-2, utf8_decode('CRECIM'),1, 'C' , 'C', 1 );   
                        $pdf->SetFont('Arial','',7);
                        //$ejeY=$ejeY+7; 
                
                while($resultadoTot = mssql_fetch_array($resultSQLTot)){
                    $d1=$resultadoTot["CTPPGN"];
                    $descgrp=$resultadoTot["CTPPGD"];
                    //$descri=$resultadoTot["DESCRIPCION"]; 
                    $acumi=0;
                    $acumf=0;
                    $vcomp=0;
                    $d4Ant=1;
                    $d4=0;
                    
                    //ventas año anterior periodoant
                    
                    $resultSQLA = mssql_query("SELECT SUM(VLR_EXC_IVA) AS T1 FROM infVentasIbs WHERE PERIODO='$periodoant' AND IDPGRP='$d1'");
                    $resultadoSqlA = mssql_fetch_array($resultSQLA);
                    //$d4anterior=$resultadoSqlA["VLR_EXC_IVA"];
                    $d4anterior=$resultadoSqlA["T1"];
                    
                                          
                    
                    //ventas año presente $periodo
                    $resultSQLB = mssql_query("SELECT SUM(VLR_EXC_IVA) AS T2 FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='$periodo' AND IDPGRP='$d1'");
                    $resultadoSqlB = mssql_fetch_array($resultSQLB);
                    //$d4=$resultadoSqlB["VLR_EXC_IVA"];
                    $d4=$resultadoSqlB["T2"];
                
               
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
                            $pdf->Cell(75,$ancho, $Ms,0, 'C' , 'C' );
                        }else{
                            $pdf->Cell(85,$ancho, $Ms,0, 'C' , 'C' );
                        }
                        $pdf->SetFont('Arial','',7);
                        $ejeY=$ejeY+7;
                        
                        //nombre manejador 
                        $ejeY=$ejeY+7;
                        $pdf->SetXY (20,$ejeY);
                        $pdf->SetFont('Arial','B',12);
                        //$pdf->SetFillColor(2,157,116);
                        $pdf->Cell(30,$ancho, $manejanom[$cm],0, 'C' , 'L' );
                        $pdf->SetFont('Arial','',7);
                        
                        $ejeY=$ejeY+7;
                        
                        //TITULOS  
                        $pdf->SetXY (20,$ejeY);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->SetFillColor(2,157,116);
                        $pdf->Cell(30,$ancho, $descri,0, 'C' , 'L' );
                        $ejeY=$ejeY+7;
                        //titulos
                        $pdf->SetFillColor(231,229,228); //gris
                        $pdf->SetFont('Arial','B',8);
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
                        //DESCRIPCION
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(60,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                        //INV INICIAL
                        $pdf->SetXY (80,$ejeY);
                        $pdf->Cell(25,$ancho-2, utf8_decode('VENT ').$anioant,1, 'C' , 'C', 1 );
                        //VENAS
                        $pdf->SetXY (105,$ejeY);
                        $pdf->Cell(18,$ancho-2, utf8_decode('% PARTIC'),1, 'C' , 'C', 1 );
                        //MARGEN
                        $pdf->SetXY (123,$ejeY);
                        $pdf->Cell(25,$ancho-2, utf8_decode('VENT ').$anio,1, 'C' , 'C', 1 );
                        //COSTO
                        $pdf->SetXY (148,$ejeY);
                        $pdf->Cell(18,$ancho-2, utf8_decode('%PARTIC'),1, 'C' , 'C', 1 );
                        //COMPRAS
                        $pdf->SetXY (166,$ejeY);
                        $pdf->Cell(25,$ancho-2, utf8_decode('DIFERENCIA'),1, 'C' , 'C', 1 );
                        //INV FINAL
                        $pdf->SetXY (191,$ejeY);
                        $pdf->Cell(15,$ancho-2, utf8_decode('CRECIM'),1, 'C' , 'C', 1 );    
                        $pdf->SetFont('Arial','',7);
                    }
                   
                    
                        //TABLA DE DATOS
                        $P1=0;
                        $P2=0;
                        $P1T=0;
                        $P2T=0;
                        $DIF=0;
                        $CREC=0;
                        $DIFT=0;
                        $CRECT=0;
                        
                        //GRP
                        $ejeY = $ejeY+7;
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(10,$ancho, $d1,1, 'C' , 'C' );
                        //DESCRIPCION
                        $pdf->SetXY (20,$ejeY);
                        $pdf->SetFont('Arial','',6);
                        $pdf->Cell(60,$ancho, $descgrp,1, 'C' , 'C' );
                        $pdf->SetFont('Arial','',7);
                        //VENTAS AÑO ANTERIOR
                        $pdf->SetXY (80,$ejeY);
                        $pdf->Cell(25,$ancho, number_format($d4anterior),1, 'C' , 'R' );
                        $TotVenIvaAntT=$TotVenIvaAntT + $d4anterior;
                        //ventas año anterior / total empresa
                        $Partic1=$d4anterior/$TotVenIvaAntEmpresaTT;
                        $Partic1=$Partic1*100;
                        //%PARTIC
                        
                        $P1=round($Partic1,2);
                        $pdf->SetXY (105,$ejeY);
                        $pdf->Cell(18,$ancho, $P1,1, 'C' , 'R' );
                        
                        //VENTAS AÑO ACTUAL
                        $pdf->SetXY (123,$ejeY);
                        $pdf->Cell(25,$ancho, number_format($d4),1, 'C' , 'C' );
                        $TotVenIvaT=$TotVenIvaT + $d4;
                        //ventas año actual / total empresa
                        $Partic2=$d4/$TotVenIvaEmpresaTT;
                        $Partic2=$Partic2*100;
                        //% PARTIC
                        
                        $P2=round($Partic2,2);
                        $pdf->SetXY (148,$ejeY);
                        $pdf->Cell(18,$ancho, $P2,1, 'C' , 'R' );
                        
                        //DIFERENCIA
                        $DIF=$d4-$d4anterior;
                        
                        $pdf->SetXY (166,$ejeY);
                        $pdf->Cell(25,$ancho, number_format($DIF),1, 'C' , 'R' );
                        //CRECIM
                        $CREC=($DIF/$d4anterior)*100;
                        $CREC=round($CREC,2);
                        $pdf->SetXY (191,$ejeY);
                        $pdf->Cell(15,$ancho, $CREC,1, 'C' , 'R' );
                        $d4anterior=0;
                        $d4=0;
                                
                } 
                
                    //SUBTOTALES
                    
                    $ejeY = $ejeY+7;
                    
                    $pdf->SetXY (20,$ejeY);
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(60,$ancho, 'SUBTOTAL $',1, 'C' , 'C' );
                    $pdf->SetFont('Arial','',7);
                    //ventas año anterior
                    $pdf->SetXY (80,$ejeY);
                    $pdf->Cell(25,$ancho, number_format($TotVenIvaAntT),1, 'C' , 'R' );
                    $TotVenIvaAntTT=$TotVenIvaAntTT+$TotVenIvaAntT;
                    //ventas año anterior / total empresa
                    $Partic1=$TotVenIvaAntT/$TotVenIvaAntEmpresaTT;
                    $Partic1=$Partic1*100;
                    //%partic
                    $P1T=round($Partic1,2);
                    $pdf->SetXY (105,$ejeY);
                    $pdf->Cell(18,$ancho, $P1T,1, 'C' , 'R' );
                    $P1T=0;
                    //ventas año actual}
                    $pdf->SetXY (123,$ejeY);
                    $pdf->Cell(25,$ancho, number_format($TotVenIvaT),1, 'C' , 'C' );
                    $TotVenIvaTT=$TotVenIvaTT+$TotVenIvaT;
                    //ventas año anterior / total empresa
                    $Partic2=$TotVenIvaT/$TotVenIvaEmpresaTT;   
                    $Partic2=$Partic2*100;
                    //% partic
                    $P2T=round($Partic2,2);
                    $pdf->SetXY (148,$ejeY);
                    $pdf->Cell(18,$ancho, $P2T,1, 'C' , 'R' );
                    $P2T=0;
                        
                    //DIFERENCIA
                    $DIFT=$TotVenIvaT-$TotVenIvaAntT;
                    $pdf->SetXY (166,$ejeY);
                    $pdf->Cell(25,$ancho, number_format($DIFT),1, 'C' , 'R' );
                    $DIFT=0;
                    
                    //CRECIMIENTO
                    //CRECIM
                    $CRECT=($DIFT/$TotVenIvaAntT)*100;
                    $CRECT=round($CRECT,2);
                    $pdf->SetXY (191,$ejeY);
                    $pdf->Cell(15,$ancho, $CRECT,1, 'C' , 'R' );
                    $CRECT=0;
                    $TotVenIvaAntT=0;
                    $TotVenIvaT=0;
            //LLAVE AGREGADA CATEGORIAS
            }
                
                
                //TOTALES
                $ejeY = $ejeY+7;
                
                $pdf->SetXY (20,$ejeY);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(60,$ancho, 'TOTAL $',1, 'C' , 'C' );
                $pdf->SetFont('Arial','',7);
                //ventas año anterior
                $pdf->SetXY (80,$ejeY);
                $pdf->Cell(25,$ancho, number_format($TotVenIvaAntTT),1, 'C' , 'R' );
                $TotVenIvaAntTE = $TotVenIvaAntTE + $TotVenIvaAntTT;
                //ventas año anterior / total empresa
                $Partic1=$TotVenIvaAntTT/$TotVenIvaAntEmpresaTT;
                $Partic1=$Partic1*100;    
                //%partic
                $P1TT=round($Partic1,2);
                
                $pdf->SetXY (105,$ejeY);
                $pdf->Cell(18,$ancho, $P1TT,1, 'C' , 'R' );
                $P1TT=0;
               
                //ventas año actual
                $pdf->SetXY (123,$ejeY);
                $pdf->Cell(25,$ancho, number_format($TotVenIvaTT),1, 'C' , 'C' );
                $TotVenIvaTE = $TotVenIvaTE + $TotVenIvaTT;
                //ventas año anterior / total empresa
                $Partic2=$TotVenIvaTT/$TotVenIvaEmpresaTT;
                $Partic2=$Partic2*100;
                //% partic
                $P2TT=round($Partic2,2);
                $pdf->SetXY (148,$ejeY);
                $pdf->Cell(18,$ancho, $P2TT,1, 'C' , 'R' );
                $P2TT=0;
                    
                //DIFERENCIA
                $DIFTT=$TotVenIvaTT-$TotVenIvaAntTT;
                $pdf->SetXY (166,$ejeY);
                $pdf->Cell(25,$ancho, number_format($DIFTT),1, 'C' , 'R' );
                $TotComIvaTT=$TotComIvaTT+$TotComIvaT;
                $TotComIvaT=0;
                
                //CRECIMIMIENTO
                $CRECTT=($DIFTT/$TotVenIvaAntTT)*100;
                $CRECTT=round($CRECTT,2);
                $pdf->SetXY (191,$ejeY);
                $pdf->Cell(15,$ancho, $CRECTT,1, 'C' , 'R' );
                $TotMesFinTT=$TotMesFinTT+$TotMesFinT;
                $TotMesFinT=0;
                
                $TotVenIvaAntTT = 0; 
                $TotVenIvaTT=0;      
                        
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
                        //$ejeY=$ejeY+7;
                $pdf->SetXY (70,$ejeY);
                $pdf->SetFont('Arial','B',12);
                if(strlen($Ms)>=12){
                    $pdf->Cell(75,$ancho, $Ms,0, 'C' , 'C' );
                }else{
                    $pdf->Cell(85,$ancho, $Ms,0, 'C' , 'C' );
                }
                $pdf->SetFont('Arial','',7);
                        
                $ejeY = $ejeY+12;
                
                $pdf->SetFillColor(231,229,228); //gris        
                $pdf->SetFont('Arial','B',8);
                        //DESCRIPCION
                $pdf->SetXY (20,$ejeY);
                $pdf->Cell(60,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                        //ventas año anterior
                $pdf->SetXY (80,$ejeY);
                $pdf->Cell(25,$ancho-2, utf8_decode('VENT ').$anioant,1, 'C' , 'C', 1 );
                        //%particip
                $pdf->SetXY (105,$ejeY);
                $pdf->Cell(18,$ancho-2, utf8_decode('% PARTIC'),1, 'C' , 'C', 1 );
                        //ventas año actual
                $pdf->SetXY (123,$ejeY);
                $pdf->Cell(25,$ancho-2, utf8_decode('VENT ').$anio,1, 'C' , 'C', 1 );
                        //%particip
                $pdf->SetXY (148,$ejeY);
                $pdf->Cell(18,$ancho-2, utf8_decode('%PARTIC'),1, 'C' , 'C', 1 );
                        //Diferencia
                $pdf->SetXY (166,$ejeY);
                $pdf->Cell(25,$ancho-2, utf8_decode('DIFERENCIA'),1, 'C' , 'C', 1 );
                        //crecimiento
                $pdf->SetXY (191,$ejeY);
                $pdf->Cell(15,$ancho-2, utf8_decode('CRECIM'),1, 'C' , 'C', 1 );    
                $pdf->SetFont('Arial','',7);
                $ejeY = $ejeY+7;
                    
                $pdf->SetXY (20,$ejeY);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(60,$ancho, 'TOTAL EMP $',1, 'C' , 'C' );
                $pdf->SetFont('Arial','',7);
                    
                    //TOTAL emp ventas año anterior
                $pdf->SetXY (80,$ejeY);
                $pdf->Cell(25,$ancho, number_format($TotVenIvaAntEmpresaTT),1, 'C' , 'R' );
                    
                    //ventas año anterior / total empresa
                $Partic1=$TotVenIvaAntEmpresaTT/$TotVenIvaAntEmpresaTT;
                $Partic1=$Partic1*100;    
                        //%PARTIC
                        
                $P1=round($Partic1,2);
                    //%total emp participacion
                $pdf->SetXY (105,$ejeY);
                $pdf->Cell(18,$ancho, $P1,1, 'C' , 'R' );
                    
                   
                    //tot emp ventas año actual
                $TotVenIvaTT=0;
                $pdf->SetXY (123,$ejeY);
                $pdf->Cell(25,$ancho, number_format($TotVenIvaEmpresaTT),1, 'C' , 'R' );
                    
                    //ventas año anterior / total empresa
                $Partic2=$TotVenIvaEmpresaTT/$TotVenIvaEmpresaTT;
                $Partic2=$Partic2*100;    
                        //%PARTIC
                        
                $P2=round($Partic2,2);
                    //tot emp % articip
                $pdf->SetXY (148,$ejeY);
                $pdf->Cell(18,$ancho, $P2,1, 'C' , 'R' );
                $TotVenCostoTT=0;
                        
                    //tot emp diferencia
                $DIFTT=$TotVenIvaEmpresaTT-$TotVenIvaAntEmpresaTT;
                $pdf->SetXY (166,$ejeY);
                $pdf->SetXY (166,$ejeY);
                $pdf->Cell(25,$ancho, number_format($DIFTT),1, 'C' , 'R' );
                $TotComIvaTT=0;
                    
                    //tot emp crecimim
                $CRECTT=($DIFTT/$TotVenIvaAntEmpresaTT)*100;
                $CRECTT=round($CRECTT,2);
                $pdf->SetXY (191,$ejeY);
                $pdf->Cell(15,$ancho, $CRECTT,1, 'C' , 'R' );
                $TotMesFinTT=0;
               }           
                        
            }
            //fin
            
                
            
            $ejeY=$ejeY+20;
            $pdf->SetXY (100,$ejeY);
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(30,$ancho, '***FIN INFORME***',0, 'C' , 'C' );
            
            $cod=time()+1;
            $nombrearc="pdf/INFORME_VENTAS_MES_ANIOACT_VS_ANIOANT.pdf";
            $pdf->Output($nombrearc,"F"); 
            /*FIN PDF*/
            
            
            
            //odbc_close($result);
            //odbc_close($result2);
            mssql_close();
           
?>