<?php
$Seq=trim($_GET['sq']);
$Dia=$_GET['di'];
$Mes=$_GET['me'];
$Anio=$_GET['an'];
$Estad=$_GET['estd'];
$Estad2=$_GET['estd2'];
if(($Seq == "") && ($Dia != "Dia" && $Mes != "Mes")){
    $ConFecha="SI";
    //fecha final
    $fechaF=$Anio."-".$Mes."-".$Dia;
    //magento 2020-10-13
    //retrocede 3 dias***
    $cd=(int)$Dia;
    $contador=0;
    while($cd > 1){
        $contador++;
        if($contador < 2){
            $Dia=(int)$Dia-3;   
        }
        $cd--;
    }
    if((int)$Dia <= 0 ){
        $Dia="01";
    }
    if(strlen($Dia) < 2){
        $Dia="0".$Dia;
    }
    //fecha inicial
    $fechaI=$Anio."-".$Mes."-".$Dia;
}else{
    $ConFecha="NO";
    if(strlen($Seq) < 9){
        $Sequence=str_pad($Seq, 9, "0", STR_PAD_LEFT);
    }else{
        $Sequence=$Seq;
    }
}
//, B.region as Ciudad
require_once('user_con_magen.php');
require_once('user_con.php');
$cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
mssql_select_db('SqlFacturas',$cLink);
$hoy = date("Y-m-d");
$hoy2 = date("Y-m-d_Hi");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));
if($ConFecha == "NO"){
    $sql ="SELECT 
      A.entity_id AS IDPedidoPagina
    , if(customer_taxvat IS NULL,vat_id,customer_taxvat) AS IDCliente
    , CONCAT(customer_firstname,' ',customer_lastname) AS NombreCliente
    , '0' AS Estado
    , A.shipping_description as tipoenvio
    , street AS Direccion
    , fax AS Telefono
    , telephone AS Celular
    , IF(postcode ='011001000','11001000',postcode) AS CodigoMunicipalidad
    , customer_email AS Email
    , '' AS IDordenAgro
    , '' AS IDestadoAgro
    , '' AS IDDescEstado
    , '' AS IDFacturaAgro
    , grand_total AS ValorOrden
    , shipping_amount AS valorflete
    , IF(shipping_method = 'amtable_amtable13','G03',IF(shipping_method = 'amstrates_amstrates14','G04','')) AS vBarrio
    , increment_id AS Sequence
    , A.created_at AS Fecha
    , '0000-00-00' AS FechaIngreso 
    , '0000-00-00' AS FechaFacturacion
    , if(A.status = 'ondelivery','contra',substr(C.comment,1,8)) AS Pago
    , base_discount_amount*-1 AS Descuento
    , coupon_code AS TipoDesc
    , substr(C.comment,1,8) AS Comentario
    , A.status as EstadoO
    , CONCAT(if(coupon_code IS NULL,'',CONCAT('Dto ',coupon_code,': $',CAST(base_discount_amount AS SIGNED),'\r')),IFNULL((SELECT concat('Cliente escribe: ',comment) FROM agro_sales_order_status_history WHERE parent_id = A.entity_id AND status IS NULL AND is_customer_notified = 1 AND is_visible_on_front = 1),'' )) AS Notas
    , B.city as Ciudad
    , B.region as Departamento
    FROM agro_sales_order A 
    inner join
    agro_sales_order_address B  on A.shipping_address_id = B.entity_id
    LEFT JOIN 
    agro_sales_order_status_history C ON C.parent_id = A.entity_id AND C.status='processing'
    WHERE increment_id='$Sequence'  
    "; 
}else if($Estad == 'todas' && $ConFecha == "SI"){
    $sql ="SELECT 
      A.entity_id AS IDPedidoPagina
    , if(customer_taxvat IS NULL,vat_id,customer_taxvat) AS IDCliente
    , CONCAT(customer_firstname,' ',customer_lastname) AS NombreCliente
    , '0' AS Estado
    , A.shipping_description as tipoenvio
    , street AS Direccion
    , fax AS Telefono
    , telephone AS Celular
    , IF(postcode ='011001000','11001000',postcode) AS CodigoMunicipalidad
    , customer_email AS Email
    , '' AS IDordenAgro
    , '' AS IDestadoAgro
    , '' AS IDDescEstado
    , '' AS IDFacturaAgro
    , grand_total AS ValorOrden
    , shipping_amount AS valorflete
    , IF(shipping_method = 'amtable_amtable13','G03',IF(shipping_method = 'amstrates_amstrates14','G04','')) AS vBarrio
    , increment_id AS Sequence
    , A.created_at AS Fecha
    , '0000-00-00' AS FechaIngreso 
    , '0000-00-00' AS FechaFacturacion
    , if(A.status = 'ondelivery','contra',substr(C.comment,1,8)) AS Pago
    , base_discount_amount*-1 AS Descuento
    , coupon_code AS TipoDesc
    , substr(C.comment,1,8) AS Comentario
    , A.status as EstadoO
    , CONCAT(if(coupon_code IS NULL,'',CONCAT('Dto ',coupon_code,': $',CAST(base_discount_amount AS SIGNED),'\r')),IFNULL((SELECT concat('Cliente escribe: ',comment) FROM agro_sales_order_status_history WHERE parent_id = A.entity_id AND status IS NULL AND is_customer_notified = 1 AND is_visible_on_front = 1),'' )) AS Notas
    , B.city as Ciudad
    , B.region as Departamento
    FROM agro_sales_order A 
    inner join
    agro_sales_order_address B  on A.shipping_address_id = B.entity_id
    LEFT JOIN 
    agro_sales_order_status_history C ON C.parent_id = A.entity_id AND C.status='processing'
    WHERE left(A.created_at,10) BETWEEN '$fechaI' AND '$fechaF' ORDER BY increment_id DESC
    ";
}else if($Estad != 'todas' && $ConFecha == "SI") {
    $sql ="SELECT 
      A.entity_id AS IDPedidoPagina
    , if(customer_taxvat IS NULL,vat_id,customer_taxvat) AS IDCliente
    , CONCAT(customer_firstname,' ',customer_lastname) AS NombreCliente
    , '0' AS Estado
    , A.shipping_description as tipoenvio
    , street AS Direccion
    , fax AS Telefono
    , telephone AS Celular
    , IF(postcode ='011001000','11001000',postcode) AS CodigoMunicipalidad
    , customer_email AS Email
    , '' AS IDordenAgro
    , '' AS IDestadoAgro
    , '' AS IDDescEstado
    , '' AS IDFacturaAgro
    , grand_total AS ValorOrden
    , shipping_amount AS valorflete
    , IF(shipping_method = 'amtable_amtable13','G03',IF(shipping_method = 'amstrates_amstrates14','G04','')) AS vBarrio
    , increment_id AS Sequence
    , A.created_at AS Fecha
    , '0000-00-00' AS FechaIngreso 
    , '0000-00-00' AS FechaFacturacion
    , if(A.status = 'ondelivery','contra',substr(C.comment,1,8)) AS Pago
    , base_discount_amount*-1 AS Descuento
    , coupon_code AS TipoDesc
    , substr(C.comment,1,8) AS Comentario
    , A.status as EstadoO
    , CONCAT(if(coupon_code IS NULL,'',CONCAT('Dto ',coupon_code,': $',CAST(base_discount_amount AS SIGNED),'\r')),IFNULL((SELECT concat('Cliente escribe: ',comment) FROM agro_sales_order_status_history WHERE parent_id = A.entity_id AND status IS NULL AND is_customer_notified = 1 AND is_visible_on_front = 1),'' )) AS Notas
    , B.city as Ciudad
    , B.region as Departamento
    FROM agro_sales_order A 
    inner join
    agro_sales_order_address B  on A.shipping_address_id = B.entity_id
    LEFT JOIN 
    agro_sales_order_status_history C ON C.parent_id = A.entity_id AND C.status='processing'
    WHERE (left(A.created_at,10) BETWEEN '$fechaI' AND '$fechaF') AND (A.status='$Estad' OR A.status='$Estad2') ORDER BY increment_id DESC
    ";
}
//2020-10-13 18:12:05
/*
( (A.status = 'processing' AND substr(C.comment,1,8)= 'APPROVED' )
      OR
      A.status = 'ondelivery' 
    )
     AND
*/
/*
A.created_at >='$hoy_1sem'
    AND
*/
$C1="#000000";
$T1="height: 10px; color: $C1; font-size: 0.8em; font-weight: bold; padding=0; width: 5%; text-align: left;";
$T2="height: 10px; color: $C1; font-size: 0.8em; font-weight: bold; padding=0; width: 12%; text-align: left;";
echo "<span style='color: black; font-weight: bold;' >ORDENES EN MAGENTO PAGINA WEB</span>";
    $idPP="<table style=\"border: 1px solid #000; width:100%;\">";
    $idPP = $idPP . "<tr style='$T1'>";
    $idPP = $idPP . "<td style='$T2'>#</td>";
    $idPP = $idPP . "<td style='$T2'>NumPedido</td>";
    $idPP = $idPP . "<td style='$T2'>OrdenIbs</td>";
    $idPP = $idPP . "<td style='$T2'>EstadoOrden</td>";
    $idPP = $idPP . "<td style='$T2'>Items</td>";
    $idPP = $idPP . "<td style='$T2'>Cliente</td>";
    $idPP = $idPP . "<td style='$T2'>Nom Cliente</td>";
    $idPP = $idPP . "<td style='$T2'>Email</td>";
    $idPP = $idPP . "<td style='$T2'>Valor Orden Mag $</td>";
    $idPP = $idPP . "<td style='$T2'>Flete Orden Mag $</td>";
    $idPP = $idPP . "<td style='$T2'>Valor Orden Ibs $</td>";
    $idPP = $idPP . "<td style='$T2'>Flete Ibs $</td>";
    $idPP = $idPP . "<td style='$T2'>Diferencia $</td>";
    $idPP = $idPP . "<td style='$T2'>Codigo Postal</td>";
    $idPP = $idPP . "<td style='$T2'>Direccion</td>";
    $idPP = $idPP . "<td style='$T2'>Ciudad</td>";
    $idPP = $idPP . "<td style='$T2'>Barrio</td>";
    $idPP = $idPP . "<td style='$T2'>CodPostLupap</td>";
    $idPP = $idPP . "<td style='$T2'>Telefono</td>";
    $idPP = $idPP . "<td style='$T2'>Celular</td>";
    $idPP = $idPP . "<td style='$T2'>Fecha Creacion</td>";
    $idPP = $idPP . "<td style='$T2'>Estado</td>";
    $idPP = $idPP . "<td style='$T2'>Comentario</td>";
    $idPP = $idPP . "<td style='$T2'>Envio</td>";
    $idPP = $idPP . "</tr>";
    
setlocale(LC_MONETARY, 'en_US');
//require('_lupap.php');
$C1="#000000";
$C2="#08156F";
$C3B="#C6DCEF";
$C3C="#579CBB";
$S2a="height: 10px; color: $C2; font-size: 0.6em; font-weight: bold; padding=0;";
$S1b="width: 60px; height: 10px; color: $C2; font-size: 0.6em; padding=0; background-color: $C3B;";
$S1c="width: 60px; height: 10px; color: $C2; font-size: 0.6em; padding=0;background-color: $C3C;";

        $miruta='Informe/';
        $tipo="OrdenesMagento";
        $nombre_fichero = 'Informe_'.$tipo."_".$hoy2;
        $mipath=$miruta.$nombre_fichero.'.xlsx';
        if(file_exists($miruta)) {
            include('Classes/PHPExcel.php');
            include('Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            $mipath2=$miruta.$nombre_fichero.'.xlsx';
            //echo $mipath2;
            echo "<a style='color: blue; background-color: white;' href='$mipath'>***Descargar Informe***</a>";
            //echo "<a style='color: blue; background-color: white;' href='Informe/Informe_OrdenesMagento.xlsx'>***Descargar Informe***</a>";
            if(file_exists($mipath2)) {
                $archivo = $mipath2;
                $inputFileType = PHPExcel_IOFactory::identify($archivo);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($archivo);
            } else {            
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                    
                    $objWorkSheet->setCellValue('A2', 'NumPedido')
                        ->setCellValue('B2', 'OrdenIbs')
                        ->setCellValue('C2', 'EstadoOrden')
                        ->setCellValue('D2', 'Items')
                        ->setCellValue('E2', 'Cliente')
                        ->setCellValue('F2', 'Nom Cliente')
                        ->setCellValue('G2', 'Email')
                        ->setCellValue('H2', 'Valor Ord Mag')
                        ->setCellValue('I2', 'Flete Mag')
                        ->setCellValue('J2', 'Valor Ord Ibs')
                        ->setCellValue('K2', 'Flete Ibs')
                        ->setCellValue('L2', 'Diferencia')
                        ->setCellValue('M2', 'Codigo Postal')
                        ->setCellValue('N2', 'Direccion')
                        ->setCellValue('O2', 'Ciudad')
                        ->setCellValue('P2', 'Barrio')
                        ->setCellValue('Q2', 'CodPostLupap')
                        ->setCellValue('R2', 'Telefono')
                        ->setCellValue('S2', 'Celular')
                        ->setCellValue('T2', 'Fecha Creacion')
                        ->setCellValue('U2', 'Estado')
                        ->setCellValue('V2', 'Comentario')
                        ->setCellValue('W2', 'Envio');
                        //->setCellValue('P2', 'Obs');
                 
                    $objWorkSheet->setTitle("Pedidos Pagina Web");
                }
            //borra datos hoja
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
                $objPHPExcel->getActiveSheet()->SetCellValue('R'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('S'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('T'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('U'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('V'.$fil, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('W'.$fil, '');
                //$objPHPExcel->getActiveSheet()->SetCellValue('P'.$fil, '');
                $fil++;
            }
            //ANCHOS
            $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
                //$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', "Ordenes Pagina Web");
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        }
$fila=0;
$fd=3;
$Sequence = new ArrayIterator();
$ListaOrden = new ArrayIterator();
$EstadoOrden = new ArrayIterator();
$ValorOrden = new ArrayIterator();
$ValorFleteMg = new ArrayIterator();
$ValorFleteIbs = new ArrayIterator();
$ItemsOrden = new ArrayIterator();
$IdClientemg = new ArrayIterator();
$NomClientemg = new ArrayIterator();
$EmailClientemg = new ArrayIterator();
$valOrdenMag = new ArrayIterator();
$codPostalMag = new ArrayIterator();
$barrioPueblo = new ArrayIterator();
$dirMag = new ArrayIterator();
$ciudMag = new ArrayIterator();
$departMag = new ArrayIterator();
$ubicacionCli= new ArrayIterator();
$envioCli= new ArrayIterator();
$result = mysqli_query($mysqliM, $sql);
while($row = mysqli_fetch_assoc($result)){
    $Ped=$row[IDPedidoPagina];
    $IdCli=$row[IDCliente];
    $nomClien=$row[NombreCliente];
    $emailClien=$row[Email];
    $ValorOrdMag=$row[ValorOrden];
    $ValorFleteMag=$row[valorflete];
    $codPostal=trim($row[CodigoMunicipalidad]);
    $Qth=utf8_encode($row[Direccion]);
    $city=$row[Ciudad];
    $Depart=$row[Departamento];
    $phone=$row[Telefono];
    $celu=$row[Celular];
    $fechacrea=$row[Fecha];
    $estOrd=$row[EstadoO];
    $comenta=$row[Comentario];
    $tipoenvio=$row[tipoenvio];
    //ORDEN IBS
    $sequIbs=substr($row[Sequence], -5, 5); 
    //AND (OHODAT BETWEEN '$FechaSQL' AND '$FechaSys'
    //$sqlIbs = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT IN('S1','S5') AND (OHOREF='$sequIbs')";
    //$sqlIbs = "SELECT O.OHORNO AS ORDEN, S.OLFOST AS ESTADO, SUM(S.OLITIT) AS VALORDIBS, SUM(S.OLITT) AS VALORFLETE FROM AGR620CFAG.SRBSOH O LEFT JOIN AGR620CFAG.SROORSPL S ON O.OHORNO=S.OLORNO GROUP BY O.OHORNO, S.OLFOST, O.OHOREF, O.OHORDT HAVING O.OHORDT IN('S1','S5') AND O.OHOREF='$sequIbs'";
    //$sqlIbs = "SELECT O.OHORNO AS ORDEN, S.OLFOST AS ESTADO, MAX(O.OHITIT) AS VALORDIBS, MAX(O.OHITT) AS VALORFLETE FROM AGR620CFAG.SRBSOH O LEFT JOIN AGR620CFAG.SROORSPL S ON O.OHORNO=S.OLORNO GROUP BY O.OHORNO, S.OLFOST, O.OHOREF, O.OHORDT HAVING O.OHORDT IN('S1','S5') AND O.OHOREF='$sequIbs'";
    $sqlIbs = "SELECT O.OHORNO AS ORDEN, O.OHITIT AS VALORDIBS, O.OHFREF AS VALORFLETE, O.OHORDS AS ESTADO
    FROM AGR620CFAG.SRBSOH O 
     WHERE O.OHORDT IN('S1','S5') AND O.OHOREF='$sequIbs'";
    $resultIbs = odbc_exec($db2con, $sqlIbs);
    $rc=odbc_num_rows($resultIbs);
    $OrdenIbs='-';
    $EstadoOrdenIBs='0';
    $ValorOIbs='0';
    $ValorOIbsExcFlet='0';
    $ValorFletOIbs='0';
    if($rc > 0){
        if($rowIbs = odbc_fetch_array($resultIbs)){
            $OrdenIbs=$rowIbs["ORDEN"];
            $EstadoOrdenIBs=$rowIbs["ESTADO"];
            $ValorOIbsExcFlet=$rowIbs["VALORDIBS"];  
            $ValorFletOIbs=$rowIbs["VALORFLETE"];
            //$EstadoOrdenIBs=$EstadoOrdenIBs-$ValorFletOIbs;
            $ValorOIbs=$ValorOIbsExcFlet;// + $ValorFletOIbs;                          
        }
    }
    
    //cod postal ibs
    //$sqlIBS = "SELECT DTDESC FROM AGR620CFAG.SRBDST WHERE DTDEST='$codPostal'";
    $Pueblo="";
    $Barrio="";
    $sqlIBS = "SELECT DTDESC FROM AGR620CFAG.SRBDST WHERE DTDEST='$codPostal'";
    $resultIBS = odbc_exec($db2con, $sqlIBS);
    if($rowIBS = odbc_fetch_array($resultIBS)){
        $BarrioIbs=$rowIBS["DTDESC"];
        $PuebloIbs=$city;
    }
    $barrioPueblo[$fila]=trim($BarrioIbs)."^".trim($PuebloIbs);
    //arreglos
    $ListaOrden[$fila]=trim($OrdenIbs);
    $EstadoOrden[$fila]=trim($EstadoOrdenIBs);
    $ValorOrden[$fila]=trim($ValorOIbs);
    $ValorFleteIbs[$fila]=trim($ValorFletOIbs);
    $Sequence[$fila]=trim($sequIbs);
    //items magento
    $sqlI ="SELECT I.sku as Item, I.qty_ordered as Cant FROM agro_sales_order_item I WHERE I.order_id='$Ped'";
    $resultI = mysqli_query($mysqliM, $sqlI);
    $Itm="";
    $ItmXls="";
    while($rowI = mysqli_fetch_assoc($resultI)){
        $ItemM=$rowI[Item];
        $CantM=intval($rowI[Cant]);
        $Itm = $Itm . $ItemM." (".$CantM.")<br>";
        $ItmXls = $ItmXls . ";" . $ItemM." [".$CantM."]";
    }
    $ItemsOrden[$fila]=trim($ItmXls);
    $IdClientemg[$fila]=trim($IdCli);
    $NomClientemg[$fila]=trim($nomClien);
    $EmailClientemg[$fila]=trim($emailClien);
    $valOrdenMag[$fila]=trim($ValorOrdMag);
    $ValorFleteMg[$fila]=trim($ValorFleteMag);
    $codPostalMag[$fila]=trim($codPostal);
    $dirMag[$fila]=trim($Qth);
    $ciudMag[$fila]=trim($city);
    $departMag[$fila]=trim($Depart);
    $ubicacionCli[$fila]=$phone.'^'.$celu.'^'.$fechacrea.'^'.$estOrd.'^'.$comenta;
    $envioCli[$fila]=trim($tipoenvio);
  $fila++;  
} //fin while


//echo "Disculpenos, estamos en revisión...".$fila;
//mysqli_close($mysqliM);
//odbc_close($resultIBS);
//exit();
//segunda secuencia
$q=0;
$fila=$fila-1;
while($q < $fila){  
    //colores
    if(($q % 2)==0){
        $S2=$S1b;
    }else{
        $S2=$S1c; 
    }
    $idPP = $idPP. "<tr><td style='$S2'>$q</td>";
    //$q++;
    
    //$idPP = $idPP. "<td style='$S2'>$row[Sequence]</td>";
    $idPP = $idPP. "<td style='$S2'>$Sequence[$q]</td>";
    
    //$idPP = $idPP. "<td style='$S2'>$OrdenIbs</td>";
    $idPP = $idPP. "<td style='$S2'>$ListaOrden[$q]</td>";
    
    //$idPP = $idPP. "<td style='$S2'>$EstadoOrden</td>";
    $idPP = $idPP. "<td style='$S2'>$EstadoOrden[$q]</td>";
    /*
    $sqlI ="SELECT I.sku as Item, I.qty_ordered as Cant FROM agro_sales_order_item I WHERE I.order_id='$Ped'";
    $resultI = mysqli_query($mysqliM, $sqlI);
    $Itm="";
    $ItmXls="";
    while($rowI = mysqli_fetch_assoc($resultI)){
      $ItemM=$rowI[Item];
      $CantM=intval($rowI[Cant]);
      $Itm = $Itm . $ItemM." (".$CantM.")<br>";
      $ItmXls = $ItmXls . ";" . $ItemM." (".$CantM.")";
      }
    */
    //$idPP = $idPP. "<td style='$S2'>$Itm</td>";
    $idPP = $idPP. "<td style='$S2'>$ItemsOrden[$q]</td>";
    //$idPP = $idPP."<tr><td style='$S1'>Cedula/Nit</td>";
    //$idPP = $idPP. "<td style='$S2'>$row[IDCliente]</td>";
    $idPP = $idPP. "<td style='$S2'>$IdClientemg[$q]</td>";
    
    //$idPP = $idPP."<tr><td style='$S1'>Nombre</td>";
    //$idPP = $idPP. "<td style='$S2'>$row[NombreCliente]</td>";
    $NomC=utf8_encode($NomClientemg[$q]);
    $idPP = $idPP. "<td style='$S2'>$NomC</td>";
    //correo
    $idPP = $idPP. "<td style='$S2'>$EmailClientemg[$q]</td>";
    //$ValorOrdMag=$row[ValorOrden];
    
    //$ValorO=money_format('%(#10n', $valOrdenMag[$q]);
    $ValorO=$valOrdenMag[$q];
    //$ValorO=number_format($valOrdenMag[$q], 2, '.', '');
    //$ValorFlet=money_format('%(#10n', $ValorFleteMg[$q]);
    $ValorFlet=$ValorFleteMg[$q];
    //ORDEN MAGENTO
    $ValorO=$ValorO-$ValorFlet;
    $ValorO=number_format($ValorO, 0, '.', '');
    
    //$ValorOrdIbs=money_format('%(#10n', $ValorOrden[$q]);
    //$ValorOrdIbs=$ValorOrden[$q];
    $ValorOrdIbs=number_format($ValorOrden[$q], 0, '.', '');
    $ValorFletIbs=$ValorFleteIbs[$q];
    
    //$Diferencia=$ValorOIbs-$ValorOrdMag;
    $Diferencia=($ValorOrdIbs+$ValorFletIbs)-$valOrdenMag[$q];
    
    //$DiferenciaOrd=money_format('%(#10n', $Diferencia);
    
    /*$ValorO=money_format('%(#10n', $ValorOrdMag);
    $ValorOrdIbs=money_format('%(#10n', $ValorOIbs);
    $DiferenciaOrd=money_format('%(#10n', $Diferencia);
    */
    //VALOR ORDEN MAGENTO 
    //$idPP = $idPP. "<td style='$S2'>$ValorO</td>";
    $idPP = $idPP. "<td style='$S2'>$ValorO</td>";
    //flete mag
    $idPP = $idPP. "<td style='$S2'>$ValorFlet</td>";
    //VALOR ORDEN IBS   $ValorOrden[$fila]
    $idPP = $idPP. "<td style='$S2'>$ValorOrdIbs</td>";
    //VALOR FLETE IBS
    $idPP = $idPP. "<td style='$S2'>$ValorFletIbs</td>";
    //DIFERENCIA
    $idPP = $idPP. "<td style='$S2'>$Diferencia</td>";
    
    //$codPostal=trim($row[CodigoMunicipalidad]);
    //$idPP = $idPP."<tr><td style='$S1'>CodigoPostal</td>";
    //$idPP = $idPP. "<td style='$S2'>$codPostal</td>";          
    $idPP = $idPP. "<td style='$S2'>$codPostalMag[$q]</td>";
    
    //$Qth=utf8_encode($row[Direccion]);
    //$idPP = $idPP."<tr><td style='$S1'>Direccion</td>";
    //$idPP = $idPP. "<td style='$S2'>$row[Direccion]</td>";
    $idPP = $idPP. "<td style='$S2'>$dirMag[$q]</td>";
    
    //$city=$row[Ciudad];
    $city=trim($ciudMag[$q]);
    $Barrio="-";
    $Pueblo="";
    $codPostLupap="";
    $codPost=$codPostalMag[$q];
    //consulta a base codigos postales
    $direCliente=utf8_decode($dirMag[$q]); //agregado
    $direClientesql20=substr($direCliente,0,20); //agregado
    //AND left(Direccion,20)='$direClientesql'
    //if($city == 'Bogotá D.C.'){
        $direClientesql=utf8_decode(substr($direClientesql20,0,20)); //agregado
        $direClientesqlb=substr($direClientesql20,0,20); //agregado
        $direClientesqlN= strtoupper(substr($direClientesql20,0,20));
        //$SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, CodPostal as codPst, Barrio as Barriolup  FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE IdUsuario='$IdClientemg[$q]'",$cLink);
        $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, CodPostal as codPst, Barrio as Barriolup, Ciudad as CiudadP  FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE IdUsuario='$IdClientemg[$q]' OR ((left(Direccion,20)='$direClientesql' OR left(Direccion,20)='$direClientesqlb' OR left(Dirnormalizada,20)='$direClientesqlN') AND Departamento='$departMag[$q]')",$cLink);
        if (!mssql_num_rows($SqlLupa)) {
            $datbarr=explode("^",$barrioPueblo[$q]);
            $Barrio=utf8_encode($datbarr[0]);
            $Pueblo=utf8_encode($datbarr[1]);
            $codPostLupap = $codPost;
        }else{
           if($rowPed = mssql_fetch_array($SqlLupa)){
                $codPostLupap = $rowPed[codPst];
                $Barrio = utf8_encode($rowPed[Barriolup]);
                $Pueblo=utf8_encode($rowPed[CiudadP]);
           } 
        }  
    /*} else {
        $datbarr=explode("^",$barrioPueblo[$q]);
        $Barrio=utf8_encode($datbarr[0]);
        $Pueblo=utf8_encode($datbarr[1]);
        $codPostLupap = $codPost;
    }*/
    /*if($city == 'Bogotá D.C.'){
        //$direccion = trim($row[Direccion]);
        $direccion = trim($dirMag[$q]);
        $DirLup=substr($direccion,0,30);
        $ciudad ='bogota';
        $Pueblo='Bogotá D.C.';
        $resultLU = geocode($ciudad, $DirLup);
        $Barrio = $_POST[barrio]; 
        $codPostLupap=$_POST[post_code];
    }else{
        //$barrioPueblo[$fila]=trim($BarrioIbs)."^".trim($PuebloIbs);
        $datbarr=explode("^",$barrioPueblo[$q]);
        $Barrio=$datbarr[0];
        $Pueblo=$datbarr[1];
    }*/
    /*else{
        //$sqlIBS = "SELECT DTDESC FROM AGR620CFAG.SRBDST WHERE DTDEST='$codPostal'";
        $sqlIBS = "SELECT DTDESC FROM AGR620CFAG.SRBDST WHERE DTDEST='$codPost'";
        $resultIBS = odbc_exec($db2con, $sqlIBS);
        if($rowIBS = odbc_fetch_array($resultIBS)){
            $Barrio=$rowIBS["DTDESC"];
            $Pueblo=$city;
        }
    }*/
    $Poblacion=utf8_encode($city);
    //echo "ciduda: ".utf8_encode($Pueblo)."---".$city;
    //$idPP = $idPP."<tr><td style='$S1'>Ciudad</td>";
    $idPP = $idPP. "<td style='$S2'>$Pueblo</td>";
      
    //$idPP = $idPP."<tr><td style='$S1'>Barrio</td>";
    $idPP = $idPP. "<td style='$S2'>$Barrio</td>";
    
    //$idPP = $idPP."<tr><td style='$S1'>CodPostalLupap</td>";
    $idPP = $idPP. "<td style='$S2'>$codPostLupap</td>";
    
    //ubicaciones
    $ubic=explode("^",$ubicacionCli[$q]);
    //$ubicacionCli[$fila]=$phone.'^'.$celu.'^'.$fechacrea.'^'.$estOrd.'^'.$comenta;
    //$idPP = $idPP."<tr><td style='$S1'>Telefono</td>";
    $idPP = $idPP. "<td style='$S2'>$ubic[0]</td>";
    
    //$idPP = $idPP."<tr><td style='$S1'>Celular</td>";
    $idPP = $idPP. "<td style='$S2'>$ubic[1]</td>";
    
    //$idPP = $idPP."<tr><td style='$S1'>Fecha Creacion</td>";
    $idPP = $idPP. "<td style='$S2'>$ubic[2]</td>";
    
    //$idPP = $idPP."<tr><td style='$S1'>Estado</td>";
    $idPP = $idPP. "<td style='$S2'>$ubic[3]</td>";
    
    //$idPP = $idPP."<tr><td style='$S1'>Comentario</td>";
    $idPP = $idPP. "<td style='$S2'>$ubic[4]</td>";
    
    $tipenviocl=utf8_encode($envioCli[$q]);
    $idPP = $idPP. "<td style='$S2'>$tipenviocl</td>
    
    
    </tr>";
    
    
    
    //$idPP = $idPP."<tr><td style='$S1'>Obs</td>";
    //$idPP = $idPP. "<td style='$S2'>$row[Notas]</td></tr>";
   /* if($Pueblo=='' || $Pueblo==null){
        $Pueblo='Bogotá D.C.';
    }*/
    
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$fd, $Sequence[$q])  
                    ->setCellValue('B'.$fd, $ListaOrden[$q])
                    ->setCellValue('C'.$fd, $EstadoOrden[$q])
                    ->setCellValue('D'.$fd, $ItemsOrden[$q])          
                    ->setCellValue('E'.$fd, $IdClientemg[$q])
                    ->setCellValue('F'.$fd, $NomC)
                    ->setCellValue('G'.$fd, $EmailClientemg[$q])
                    ->setCellValue('H'.$fd, $ValorO)
                    ->setCellValue('I'.$fd, $ValorFlet)
                    ->setCellValue('J'.$fd, $ValorOrdIbs)
                    ->setCellValue('K'.$fd, $ValorFletIbs)
                    ->setCellValue('L'.$fd, $Diferencia)
                    ->setCellValue('M'.$fd, $codPost)
                    ->setCellValue('N'.$fd, $dirMag[$q])
                    ->setCellValue('O'.$fd, $Poblacion)
                    ->setCellValue('P'.$fd, $Barrio)
                    ->setCellValue('Q'.$fd, $codPostLupap)
                    ->setCellValue('R'.$fd, $ubic[0])
                    ->setCellValue('S'.$fd, $ubic[1])
                    ->setCellValue('T'.$fd, $ubic[2])
                    ->setCellValue('U'.$fd, $ubic[3])
                    ->setCellValue('V'.$fd, $ubic[4])
                    ->setCellValue('W'.$fd, $tipenviocl);
                    //->setCellValue('P'.$fd, $row[Notas]);
                $fd++;
  $q++;  
  }
$idPP = $idPP. "</table>";

//if(file_exists($mipath2)) {
    //CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
       //Guardar el achivo: 
    $objWriter->save($mipath2);
//}

//items
/*$sqlI ="SELECT I.sku as Item, I.name as Nombre, I.qty_ordered as Cant FROM agro_sales_order_item I WHERE I.order_id='$Ped'";
*/
//$idPP=$idPP."<hr>Productos:<br>";
/*$idPP = $idPP. "<hr><b>Productos:</b><br><table>";
$idPP = $idPP."<tr><td style='$S1'>Item</td><td style='$S1'>Descripcion</td><td style='$S1'>Cantidad</td></tr>";
$resultI = mysqli_query($mysqliM, $sqlI);
while($row = mysqli_fetch_assoc($resultI)){
  $Canty=intval($row[Cant]);
  
    $idPP = $idPP. "<tr><td style='$S2'>$row[Item]</td><td style='$S2'>$row[Nombre]</td><td style='$S2'>$Canty</td></tr>";
  
  }
 $idPP = $idPP. "</table>"; */
mysqli_close($mysqliM);
odbc_close($resultIBS);
//echo utf8_encode($idPP);
echo $idPP;
?>

