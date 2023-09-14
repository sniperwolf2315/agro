<!DOCTYPE html>
<?php
     if(! isset($_SESSION)){
         session_start();
         $usuariocon=$_SESSION['nombreusu'];
      }            
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <LINK href="estilos.css" rel="stylesheet" type="text/css">  
        <title>CyMDecoraciones</title>
        <script language="JavaScript">
            function checkKeyCode(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if (event.keyCode == 116) {
                    evt.keyCode = 0;
                    return false
                }
            }
            document.onkeydown = checkKeyCode;
            
            function buscarDatos(seactualiza) {
                //entra solo cuando busca la categoria
                if (seactualiza == 0) {
                    //limpia
                    var select = document.getElementById('subcategoria');
                    document.getElementById('refer').value = '';
                    while (select.length > 1) {
                        select.remove(1);
                    }
                }
                //busca el dato
                var dato1 = document.getElementById('categoria').value;
                var dato2 = document.getElementById('subcategoria').value;
                if (dato1 != "" && dato2 != "") {
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'buscareferencia.php?b1=' + dato1 + '&b2=' + dato2, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        //alert(dato1);
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                document.getElementById('refer').value = dato;
                            }
                        }
                    }
                }
                //entra a buscar la subcategoria solo cuando busca la categoria
                if (seactualiza == 0) {
                    buscarSubcategoria();
                }
            }
            function buscarSubcategoria() {
                var dato1 = document.getElementById('categoria').value;
                if (dato1 != "") {
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'buscasubcategoria.php?b1=' + dato1, true);
                    peticion_http.send(null);

                    function muestraContenido() {

                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {

                                var dato = peticion_http.responseText;
                                var datos = dato.split('^');
                                var tam = datos.length;
                                //carga options en un combo
                                var select = document.getElementById('subcategoria');
                                for (var i = 0; i <= tam - 1; i++) {
                                    var opt = document.createElement('option');
                                    opt.value = datos[i];
                                    opt.innerHTML = datos[i];
                                    select.appendChild(opt);
                                }
                            }
                        }
                    }
                }
            }
            
            //limpiar combo
            function limpiaCombo() {
                var select = document.getElementById('subcategoria');
                while (select.length > 1) {
                    select.remove(1);
                }
            }
            //demas funciones
            function cerrarventana() {
                window.close();
            }
            function Solo_Numerico(variable) {
                Numer = parseInt(variable);
                if (isNaN(Numer)) {
                    return "";
                }
                return Numer;
            }
            function ValNumero(Control) {
                Control.value = Solo_Numerico(Control.value);
            }

            
            function Popup(valor) {
                //'localhost/' +
                //alert('localhost/' + valor);
                var windowName = 'userConsole';
                var popUp = window.open(valor, '_blank', '');
                if (popUp == null || typeof (popUp) == 'undefined') {
                    alert('Por favor deshabilita el bloqueador de ventanas emergentes.');
                }
                else {
                    popUp.focus();
                }
            }
                        
            function verLink(valor) {
                document.getElementById('linke').innerHTML = '<a href="informes/'+valor+'"><h4>Descargar Informe en Excel</h4></a>';
            }
        </script>
    </head>
    <body>
        <?php
            $url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        ?>
        <div class="centrarancho">
            <div style=" width: 96%; float: left;">
                
                    <div style="float: left;">
                    <img alt="CyMDecoraciones" src="imagenesemp/logooficial2017.svg" style="width: 30%; float: left;">
                    </div>
                    <div style="float: right;">  
                        <input type="button" class="botoncortoazul" onclick="cerrarventana();" name="salir" value="Cerrar"><br />
                    </div><br /><br />
                <center><label class="titulogrande" style="float: left;">&nbsp;CONSULTA DE PRODUCTOS TERMINADOS Y EMPACADOS</label></center>
            </div>
            
             <?php $fecha=date("d/m/Y");
                if(empty($descarga)){
                    $descarga='';
                }
             ?>
            <center><div style="width: 98%; height: 30%">
            <form name="salir" method="post" action="<?php echo $url; ?>">
            <table class="tabla">
            <tbody>
                <tr><th class="cabecera1" colspan="7">FILTROS</th></tr>
                <tr><td style="width: 20%"><label class="titulo1">No. Orden/Zona:&nbsp;</label></td>
                    <td colspan="2" style="width: 30%;">
                        <input type="text" class="textolargo" id="refer" name="refer" autocomplete="off">
                    </td>
                    <td style="width:  20%;"><label class="titulo1">&nbsp;</label></td><td colspan="3" style="width: 30%;"></td></tr>
                <tr><td colspan="7" style="text-align: center;"><label class="titulo1">Buscar por rango de fechas&nbsp;</label></td></tr>
                <tr><td style="width: 20%"><label class="titulo1">Fecha Inicio:&nbsp;</label></td><td colspan="2" style="width: 30%;"><input type="date" class="textocorto" id="fechai" name="fechai" autocomplete="off"></td><td style="width:  20%;"><label class="titulo1">Fecha Fin:&nbsp;</label></td><td colspan="3" style="width: 30%;"><input type="date" class="textocorto" id="fechaf" name="fechaf" autocomplete="off"></td></tr>
                <tr><td colspan="7">&nbsp;</td></tr>
                <tr><td colspan="7" style="text-align: center;"><input type="submit" class="botoncortoverde" name="buscarProdTermpdf" id="buscarProdpdf" value="Informe PDF">&nbsp;<input type="submit" class="botoncortoverde" name="buscarProdtermxlsx" id="buscarProdtermxlsx" value="Informe EXCEL"></td></tr>
                <tr><td colspan="7"><div id="linke"></div></td></tr>
            </tbody>
            </table>
            </form>
        </div></center>
        </div>
     <?php
     //onclick="verPDFProd();"
     if(isset($_POST['buscarProdTermpdf'])){
        require ('conexion.php');
        //consulta el usuario
        $d5=$_POST['refer'];
        //$d2=$_POST['factura'];
        $d3=$_POST['fechai'];
        $d4=$_POST['fechaf'];
        if(!empty($d5) && !empty($d3) && !empty($d4)){
            $resultado = $mysqli->query("SELECT * FROM inventario_general WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') && (num_orden='$d5' || zona='$d5') ORDER BY num_orden ASC");    
        }else if(!empty($d5) && empty($d3) && empty($d4)){
            $resultado = $mysqli->query("SELECT * FROM inventario_general WHERE num_orden='$d5' || zona='$d5' ORDER BY num_orden ASC");
        }else{
            $resultado = $mysqli->query("SELECT * FROM inventario_general WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') || num_orden='$d5' || zona='$d5' ORDER BY num_orden ASC");    
        }
        $numero = $resultado->num_rows;
        if($resultado && $numero > 0){
            //reporte del pdf
            require('fpdf/fpdf.php');
            //P es normal. El valor para apaisada es L
            
            class PDF extends FPDF
            {
                function Header(){
                    $x = 20; //pos x
                    $y = 10;  //pos y
                    $w = 10;  //ancho
                    $h = 10;  //alto
                    $fitbox=1;
                    $this->SetXY(8, 10);
                    $this->Image('imagenesemp/logo-cym-plano.jpg', $x, $y, $w, $h, 'JPG', '', '', false, 80, '', false, false, 0, $fitbox, false, false);
                    //cabecera de la tabla
                        $fecha=date("d/m/Y");
                        $this->SetFont('Arial','B',10);
                        $this->SetFillColor(2,157,116);//Fondo verde de celda
                        $ejeX = 10;
                        $PosY=30;
                
                        $this->SetTextColor(0, 0, 0); //Letra color blanco
                        $this->SetXY(95, 12);
                        $this->Cell(10,7, utf8_decode('LISTADO DE PRODUCTOS TERMINADOS EMPACADOS'), 0, 'C', 'C','0','');
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
                        
                        $this->MultiCell(20,7, utf8_decode('FECHA'),1, 'C', 'C');
                        $this-> SetXY (30,$PosY);
                        $this->MultiCell(23,7, utf8_decode('CATEGORIA'),1, 'C' , 'C');
                        $this-> SetXY (53,$PosY);
                        $this->MultiCell(23,7, utf8_decode('SUB CAT'),1, 'C' , 'C');
                        $this-> SetXY (76,$PosY);
                        $this->MultiCell(25,7, utf8_decode('REFER'),1, 'C' , 'C');
                        $this-> SetXY (101,$PosY);
                        $this->MultiCell(20,7, utf8_decode('EMPAQUES'),1, 'C' , 'C');
                        $this-> SetXY (121,$PosY);
                        $this->MultiCell(20,7, utf8_decode('EMPAQUE'),1, 'C' , 'C');
                        $this-> SetXY (141,$PosY);
                        $this->MultiCell(25,7, utf8_decode('# X EMPAQUE'),1, 'C' , 'C');
                        $this-> SetXY (166,$PosY);
                        $this->MultiCell(26,7, utf8_decode('TOT UNDS'),1, 'C' , 'C');
                        //$this-> SetXY (187,$PosY);
                        //$this->MultiCell(15,7, utf8_decode('ZONA'),1, 'C' , 'C');                      
                    $this->Ln(20);
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
            while($row = $resultado->fetch_array(MYSQLI_NUM))
                {
                    $cod=$row[1];
                    $resultado2 = $mysqli->query("SELECT * FROM orden_producciong WHERE num_ord='$cod'");
                    $numero2 = $resultado2->num_rows;
                    if($resultado2 && $numero2 > 0){
                        $row2 = $resultado2->fetch_array(MYSQLI_NUM);
                        if(empty($row[14]) || $row[14]<=0){
                            $nxe=1;
                        }else{
                            $nxe=$row[14];
                        }
                        //$totp=$row[11]/$nxe;
                        $totp=$row[9]*$nxe;
                        $ejeY = $ejeY+7;
                        $pdf->SetXY (10,$ejeY);
                            $pdf->Cell(20,$ancho, utf8_decode($row[2]),1, 'C' , 'C' );
                        $pdf->SetXY (30,$ejeY);
                            $pdf->Cell(23,$ancho, utf8_decode($row2[17]),1, 'C' , 'C' );//3
                        $pdf->SetXY (53,$ejeY);
                            $pdf->Cell(23,$ancho, utf8_decode($row2[18]),1, 'C' , 'C' );//4
                        $pdf->SetXY (76,$ejeY);
                            $pdf->Cell(25,$ancho, utf8_decode($row2[3]),1, 'C' , 'C' );
                        $pdf->SetXY (101,$ejeY);
                            $pdf->Cell(20,$ancho, $row[9],1, 'C' , 'C');
                        $pdf->SetXY (121,$ejeY);
                            $pdf->Cell(20,$ancho, $row[13],1, 'C' , 'C');
                        $pdf->SetXY (141,$ejeY);
                            $pdf->Cell(25,$ancho, $row[14],1, 'C' , 'C' );
                        $pdf->SetXY (166,$ejeY);
                            $pdf->Cell(26,$ancho, $totp,1, 'C' , 'C' );
                    }
                }
            //$cod=time()+1;
            $nombrearc="informes/productosterminados.pdf";
            $pdf->Output($nombrearc,"F"); //le indicamos la salida del documento "diploma.pdf
            echo "<script language='javascript'>
                Popup('$nombrearc');
            </script>";    
        }//fin si  
       }//fin isset
       //************************************************************************************
       //PRODUCTOS EN EXCEL
       if(isset($_POST['buscarProdtermxlsx'])){
            require ('conexion.php');
            //consulta el usuario
            $d5=$_POST['refer'];
            $d3=$_POST['fechai'];
            $d4=$_POST['fechaf'];
            if(!empty($d5) && !empty($d3) && !empty($d4)){
                $resultado = $mysqli->query("SELECT * FROM inventario_general WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') && (num_orden='$d5' || zona='$d5') ORDER BY num_orden ASC");    
            }else if(!empty($d5) && empty($d3) && empty($d4)){
                $resultado = $mysqli->query("SELECT * FROM inventario_general WHERE num_orden='$d5' || zona='$d5' ORDER BY num_orden ASC");
            }else{
                $resultado = $mysqli->query("SELECT * FROM inventario_general WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') || num_orden='$d5' || zona='$d5' ORDER BY num_orden ASC");    
            }
            //$resultado = $mysqli->query("SELECT * FROM inventario_general WHERE (fecha_in >= '$d3' && fecha_in <= '$d4') || num_orden='$d5' ORDER BY num_orden ASC");
            $numero = $resultado->num_rows;
            if($resultado && $numero > 0){
                //path
                $fecha=date("d_m_Y");
                //$miruta='../public_html/Informes';
                $miruta='informes';
                $nombre_fichero = 'Informe_'.$fecha."_Cymdecoraciones";
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
                    $objPHPExcel->getProperties()->setCreator("Autor: CyMDecoraciones");
                    $objPHPExcel->getProperties()->setLastModifiedBy("CyMDecoraciones");
                    $objPHPExcel->getProperties()->setTitle("Informe de Productos");
                    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                    $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                    $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
                    //Seleccionamos la hoja sobre la que queremos escribir 
                    //combinar celdas
                    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
                    //titulos
                    $titulo='INFORME DE PRODUCTOS TERMINADOS EMPACADOS: CyMDECORACIONES '.date("d/m/Y");
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', $titulo);
                    //Alineacion
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
                    //$objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                    //negilla
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                    //titulos
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', 'No.')
                            ->setCellValue('B2', 'FECHA')
		                    ->setCellValue('C2', 'CATEGORIA')
                            ->setCellValue('D2', 'SUB-CATEGORIA')
                            ->setCellValue('E2', 'REFERENCIA')
		                    ->setCellValue('F2', 'EMPAQUES')
		                    ->setCellValue('G2', 'EMPAQUE')
                            ->setCellValue('H2', 'CANT X EMPAQUE')
                            ->setCellValue('I2', 'TOT UNIDADES');
                            
                    //negilla
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
                    //ANCHOR
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                    //$objPHPExcel->getActiveSheet()->getDimension('1')->setHeight(20);
                    //renombre de la hoja
                    $objPHPExcel->getActiveSheet()->setTitle("Informe Productos Terminados");
                    //datos
                    //$cantidadv=count($curs);
                    $j=0;
                    $f=3;
                    while($row = $resultado->fetch_array(MYSQLI_NUM)){
                            $num=$j+1;
                            $cod=$row[1];
                            $resultado2 = $mysqli->query("SELECT * FROM orden_producciong WHERE num_ord='$cod'");
                            $numero2 = $resultado2->num_rows;
                            if($resultado2 && $numero2 > 0){
                                $row2 = $resultado2->fetch_array(MYSQLI_NUM);
                                if(empty($row[14]) || $row[14]<=0){
                                    $nxe=1;
                                }else{
                                    $nxe=$row[14];
                                }
                                $totp=$row[9]*$nxe;
                                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$f, $num)
                                ->setCellValue('B'.$f, $row[2])
		                        ->setCellValue('C'.$f, $row2[17])
		                        ->setCellValue('D'.$f, utf8_decode($row2[18]))
                                ->setCellValue('E'.$f, $row2[3])
		                        ->setCellValue('f'.$f, $row[9])
		                        ->setCellValue('G'.$f, $row[13])
                                ->setCellValue('H'.$f, $row[14])
                                ->setCellValue('I'.$f, $totp);
                                
                        //Alineacion
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('D'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('F'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
                        }	
                    }   //fin while
                    
                    //***************guarda
                    //crear objeto writer
                    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
                    //Guardar el achivo: 
                    $objWriter->save($mipath);
                    echo "<br /><br />";
                    $descarga=$nombre_fichero.".xlsx";
                    //echo "<a href=\"http://www.funddreams.co/Informes/$descarga\"><h3>Descargar Informe</h3></a>";
                    //echo "<a href=\"informes/$descarga\"><h3>Descargar Informe</h3></a>";
                    echo("<script language='JavaScript'>verLink('$descarga');alert('Informe generado correctamente. Puede descargarlo mediante el link');</script>");
                }//fin si exists
                
        }//fin si
       }
     ?>
    </body>
</html>