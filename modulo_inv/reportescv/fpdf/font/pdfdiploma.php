<?php
//impresion al archivo que queda en la raiz del sitio
//ahora insertamos el texto del textarea dentro
//de una multicelda, si tienes problemas con la
//presentacion del contenido intenta utilizando
//el utf8_decode, las propiedades de Multicell
//es ancho, alto, contenido, bordo, alineacion, relleno
//$pdf->MultiCell(0,7,$_POST['contenido'],1,'J',0);

/*
FPDF([string orientación [, string unidad [, mixed formato]]);

orientación es la forma de colocación de la página, es decir, debemos indicar si es normal o apaisada. El valor por defecto P es normal. El valor para apaisada es L
unidad es la medida de usuario y sus posibles valores son: pt punto, mm milímetro, cm centímetro e in pulgada. El valor por defecto es el mm 
formato de la página. Puede tener los siguientes valores: A3, A4, A5, Letter y Legal. El valor por defecto es A4
*/
$session =&JFactory::getSession();
$codusuario=$session->get('elcodigo');
require('fpdf/fpdf.php');
$pdf = new FPDF('L','mm','Letter');
$pdf->AliasNbPages(); //como queremos que se muestre el paginado
$pdf->AddPage();//creamos una hoja nueva
//fuente
$pdf->AddFont('Old','','');
$pdf->SetFont('Old','', 10);//selecciones la fuente, estilo y tamaño
$pdf->SetFillColor(2,157,116);//Fondo verde de celda
$pdf->SetTextColor(240, 255, 240); //Letra color blanco
$w = 100;
$h = 30;
$txt="Diploma";
$border=1;
$ln=1; //donde se empezara a escribir después de llamar a esta función
$align="C";
$fill="1"; //dice si el fondo de la celda va a ir con color o no
$link="http://www.funddreams.co";
$pdf->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
$fitbox=1;
$html="<html><hr><br>hola como esta<hr></html>";
$x = 15;
$y = 35;
$w = 100;
$h = 30;
$pdf->Image('images/ahorro.jpg', $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
//$pdf->SetY(65);
//$pdf->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$y)*$k ));
//Salto de línea
$pdf->Ln(20);
$pdf->SetXY(80,17);
//Color de fondo
$pdf->SetFillColor(20,20,255);
$pdf->MultiCell(0,7,$html,1,'C',1);
$nombrearc="images/diplomas/diploma".$codusuario.".pdf";
$pdf->Output($nombrearc,"F"); //le indicamos la salida del documento "diploma.pdf"

//se puede utilizar javascript para abrir en una nueva ventana
//el documento pdf generado
echo "<script language='javascript'>
window.open('http://www.funddreams.co/$nombrearc','_blank','');
</script>";
?><p style="font-family:'Old English Text MT'">Hola amigos</p>