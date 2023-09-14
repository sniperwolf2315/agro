<?php
//require_once('../user_con.php');
require_once('user_con.php');
$periodo=trim($_GET['periodo']);

//if (!isset($_SESSION)) { session_start(); }
//$_SESSION['Grupo']=trim($d1);
//$_SESSION['fVenc']=$fv;
//$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');
//$reg1="";
$datob="";
/*
$sql = "SELECT * FROM VISINFVENT3 WHERE PERIODO='$periodo'";
$result = odbc_exec($db2con, $sql);
$row = odbc_fetch_array($result);
$d1 = utf8_encode($row['IDPGRP']);
$d2 = utf8_encode($row['IDPLAN']);
*/
//$reg3 = $row['SRSROM'];
            
       /*PDF*/
            
        //require ('conexion.php');
        //consulta el usuario
        
        //$resultado = $mysqli->query("SELECT * FROM inventario_proceso WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') || num_orden='$d5' || zona='$d5' ORDER BY zona ASC");
        //$numero = $resultado->num_rows;
        //if($resultado && $numero > 0){
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
                        $this->SetFont('Arial','B',10);
                        $this->SetFillColor(2,157,116);//Fondo verde de celda
                        $ejeX = 10;
                        $PosY=30;
                
                        $this->SetTextColor(0, 0, 0); //Letra color blanco
                        $this->SetXY(95, 12);
                        $this->Cell(10,7, utf8_decode('COMPRAS - VENTAS MES'), 0, 'C', 'C','0','');
                        $this->SetXY(95, 16);
                        $this->Cell(10,7, utf8_decode('Fecha Informe: ').$fecha, 0, 'C', 'C','0','');
                        $this->SetFont('Arial','B',8);
                
                        $this->SetFillColor(2,157,116);//Fondo verde de celda
                        $this->SetTextColor(240, 255, 240); //Letra color blanco
                        //$pdf->SetXY(10, 12);
                        $this->SetXY(10, 30);
                        $ejeX = 10;
                        $PosY=30;
                        //ANCHO Y ALTO CELDA
                        /*$this->MultiCell(20,7, utf8_decode('FECHA'),1, 'C', 'C');
                        $this-> SetXY (30,$PosY);
                        $this->MultiCell(35,7, utf8_decode('REFER'),1, 'C' , 'C');
                        $this-> SetXY (65,$PosY);
                        $this->MultiCell(35,7, utf8_decode('CATEGORIA'),1, 'C' , 'C');
                        $this-> SetXY (100,$PosY);
                        $this->MultiCell(35,7, utf8_decode('SUBCATEGORIA'),1, 'C' , 'C');
                        $this-> SetXY (135,$PosY);
                        $this->MultiCell(20,7, utf8_decode('T. UNDS.'),1, 'C' , 'C');
                        $this-> SetXY (155,$PosY);
                        $this->MultiCell(30,7, utf8_decode('U.PEND.'),1, 'C' , 'C');*/
                        //$this->MultiCell(25,7, utf8_decode('# EMPAQUES'),1, 'C' , 'C');
                        //$this->MultiCell(20,7, utf8_decode('T.UNIDS'),1, 'C' , 'C');
                        //$this-> SetXY (190,$PosY);
                        //$this->MultiCell(20,7, utf8_decode('VALOR U.'),1, 'C' , 'C');                       
                    //$this->Ln(20);
                }
                function Footer()
                {
                    $this->SetY(-15);
                    $this->SetFont('Arial','I',8);
                    $this->Cell(0,10,'P. '.$this->PageNo().' / {nb}',0,0,'C');

                }
            }

            //datos
            $pdf = new PDF('P','mm','Letter');
            $pdf->AliasNbPages(); //como queremos que se muestre el paginado
            //$pdf = new FPDF('P','mm','Letter');
            $pdf->AddPage();    
            
            //$y2=$this->GetY();
            $ancho=7;
            $ejeY = 30;
            $pdf->SetFont('Helvetica','',7);
            $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
            $pdf->SetFillColor(240, 255, 240); //fondo blanco
            /*while($row = $resultado->fetch_array(MYSQLI_NUM))
                {
                    if($ejeY>220){
                            $ejeY=30;
                            $pdf->AddPage();
                        }
                    $cod=$row[1];  //de inventario_proceso
                    $resultado2 = $mysqli->query("SELECT * FROM orden_producciong WHERE num_ord='$cod'");
                    $numero2 = $resultado2->num_rows;
                    if($resultado2 && $numero2 > 0){
                        $row2 = $resultado2->fetch_array(MYSQLI_NUM);
                        if(empty($row[10]) || $row[10]<=0){
                            $nxe=1;
                        }else{
                            $nxe=$row[10];
                        }
                        $totp=$row[6]*$nxe;
                        $ejeY = $ejeY+7;
                        $pdf->SetXY (10,$ejeY);
                            $pdf->Cell(20,$ancho, utf8_decode($row[2]),1, 'C' , 'C' );
                        $pdf->SetXY (30,$ejeY);
                            $pdf->Cell(35,$ancho, utf8_decode($row2[3]),1, 'C' , 'C' );
                        $pdf->SetXY (65,$ejeY);
                            $pdf->Cell(35,$ancho, utf8_decode($row2[17]),1, 'C' , 'C' );
                        $pdf->SetXY (100,$ejeY);
                            $pdf->Cell(35,$ancho, utf8_decode($row2[18]),1, 'C' , 'C' );
                        $pdf->SetXY (135,$ejeY);
                            $pdf->Cell(20,$ancho, $row[9],1, 'C' , 'C' );
                        $pdf->SetXY (155,$ejeY);
                            $pdf->Cell(30,$ancho, $row[6],1, 'C' , 'C');
                        //$pdf->SetXY (170,$ejeY);
                          //  $pdf->Cell(20,$ancho, utf8_decode($row[11]),1, 'C' , 'C' );
                            //$pdf->Cell(25,$ancho, $totp,1, 'C' , 'C');
                        //$pdf->SetXY (190,$ejeY);
                            //$pdf->Cell(20,$ancho, utf8_decode($row[11]),1, 'C' , 'C' );
                    }
                }*/
            //$cod=time()+1;
            $nombrearc="../ventasmes.PDF";
            $pdf->Output($nombrearc,"F"); //le indicamos la salida del documento "diploma.pdf
                
        //}//fin si
            
            
            /*FIN PDF*/
            
            odbc_close($result);
            //$_SESSION['Bodsede']=trim($reg3);
            //item descripcion bodega
            //$datob=$reg2.'^'.$reg3;
            //adiciona el grupo si no esta en la base 
            //include('conexioninventario.php');
            
            /*
            $result = mssql_query("SELECT DISTINCT(pgpgrp) from invGrupo WHERE pgpgrp='$d1'", $cLink008);
            $fila = mssql_fetch_array($result);
            $numero = mssql_num_rows($result);
            mssql_close($result);
            */
            
            //$d1=$fila[0];
            /*while($row = odbc_fetch_array($result)){ 
               $regs = $row['PGDESC'];
               
            }*/
            //echo $datob.'^'.'---'.$numero.'---'.$_SERVER['PATH_INFO'];
            //echo $datob;
?>