<?php
                /*
                $localhostL 	= 	'3.233.60.4'	; 	
                $userA 		= 	'nzwcsjbshb'	;//agroeva
                $claveO		=	'k4SCnVuThJ'; 	
                $base_datosL	=	'nzwcsjbshb';
                
                $mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
                if (mysqli_connect_errno())
                  { 
                    echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error();
                  }else{
                    echo "conectado";
                }
                */
                //tablas
                /*$sql ="SELECT table_name AS nombre FROM information_schema.tables WHERE table_schema = 'nzwcsjbshb';";
                $result = mysqli_query($mysqliM, $sql) or die("sql1<br>".mysqli_error($mysqliM));
                
                while($row = mysqli_fetch_assoc($result)){
                    print_r($row)." ***  ";
                    //$tabla=explode("=>",$row);
                    //echo $tabla." * ";
                    //echo $row->table_name;
                }
                */
                //agro_sales_order_item
                //datos
                //$sql ="select * from agro_sales_order where entity_id='45683'";
                /*$sql ="select * from agro_customer_entity where 1";
                $result = mysqli_query($mysqliM, $sql) or die("sql1<br>".mysqli_error($mysqliM));
                $i=0;
                $cr=mysqli_num_rows($result);
                echo $cr."****";
                while($row = mysqli_fetch_array($result)){
                    //print_r($row[0].", ".$row[9]." , ".$row[98]." , ".$row[99]." , ".$row[100]." ---- ");
                    $i=0;
                    while($i<20){
                        print_r($row[$i])."----";
                        $i++;
                    }
                }
                exit();*/
               /* $sql ="select * from agro_sales_order_address where entity_id='45728'";
                $result = mysqli_query($mysqliM, $sql) or die("sql1<br>".mysqli_error($mysqliM));
                
                while($row = mysqli_fetch_array($result)){
                    print_r($row[0].", ".$row[9]." , ".$row[98]." , ".$row[99]." , ".$row[100]." ---- ");
                }*/
                //columnas
                /*$sql ="SHOW COLUMNS FROM agro_sales_order;";
                $result = mysqli_query($mysqliM, $sql) or die("sql1<br>".mysqli_error($mysqliM));
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {                
                        echo $row['Field'].'<br/>';
                    }
                }
                */
                //$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
                /*
                if (mysqli_connect_errno())
                  { 
                    echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error();
                  }else{
                    echo "conectado";
                  }
                 
                */
                //WHERE 
                /*$resulty =  mysqli_query($mysqliM, $sqly) or die(".................. NO conecto llame al ADMINISTRADOR DEL SISTEMA");
                if($rowy = mysqli_fetch_array($resulty)){ 
                    $ides=$rowy[0];
                    }
                 */   
                //increment_id IN('100094156','100094007','100093931')
                /*$comaID ='';
                $ides="";
                $resulty = mysqli_query($mysqliM, $sqly);
                if($rowy = mysqli_fetch_array($resulty)){
                  $ides .= $rowy[IDPedidoPagina];
                  
                  }*/
                //echo "Magento: ".$Aux."fin";
                //mysqli_close();
//exit();
require_once('conectarbase.php');
require_once('user_con.php');
//require_once('user_con_maglocal.php');
require_once('user_con_magen.php');
//$dia=trim($_GET['d']);
//$mes=trim($_GET['m']);
//$anio=trim($_GET['a']);
//$Sequence=trim($_GET['sq']);
$Orden="-";
$PeriodoIbs=$anio.$mes.$dia;
$accion="";
$conteo1=0;
$conteo2=0;
$texto1="";
$texto2="";
$HayItems="NO";
$mes=date("m");
$anio=date("Y");
if(strlen($mes)<2){
    $mes="0".$mes;
}
$FechaHoy=date("Ymd");
//ojo leer la sequence por pagina
$estado="OrdenNoExiste";
$tmpSql="";
$tmpIbs="";
$i=0;
$C1="#000000";
$C2="#08156F";
$C3B="#C6DCEF";
$C3C="#579CBB";
$S1b="width: 60px; height: 10px; color: $C2; font-size: 0.8em; padding=0; background-color: $C3B; text-align: center";
$S1c="width: 60px; height: 10px; color: $C2; font-size: 0.8em; padding=0;background-color: $C3C; text-align: center";
$arrarSequence=new ArrayIterator();
//AND datepart(Month,FechaIngreso)='03'
    $resultSQLP = mssql_query("SELECT Sequence FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] WHERE (IDordenAgro='' OR Estado='0') AND datepart(Year,FechaIngreso)='$anio' AND datepart(Month,FechaIngreso)='$mes'");
    while($resultadoP = mssql_fetch_array($resultSQLP)){
        $Sequence=$resultadoP["Sequence"];
        $arrarSequence[$i++]=$Sequence;
        }
    //$resultSQL = mssql_query("SELECT Sequence, IDPedidoPagina, IDCliente FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] where IDordenAgro='' AND Estado='1' AND datepart(year,FechaIngreso)='$anio' and datepart(month,FechaIngreso)='$mes' and datepart(day,FechaIngreso)='$dia'");
    $conSeq=count($arrarSequence);
    $q=0;
    $q2=1;
    echo "<span style='color: black; font-weight: bold;' >ORDENES FALTANTES EN IBS</span>";
    $r="<table style=\"border: 1px solid #000; width:100%;\">";
    $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
    $r=$r . "<td style=\"font-weight: bold;width: 5%;text-align: left;font-size: 0.8em;text-align: center;\">#</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Fecha Ingreso</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Sequence/Orden Pag:</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Items</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">ID Cliente</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Bloqueos</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Nombre Cliente</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">ID Destino</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Ciudad</td>";
    //$r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Orden:</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Estado Pedido</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em;text-align: center;\">Analisis</td>";
    $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;font-size: 0.8em; text-align: left; padding: 0;\"><a href='Informe/Informe_OrdenesPendIBS.xlsx'>Descargar</a></td>";
    $r=$r . "</tr>";
    
    
    //pdf******************************************************************************************
        //$fecha=date("d_m_Y");
        $fd=3;
        $miruta='Informe/';
        $tipo="OrdenesPendIBS";
        $nombre_fichero = 'Informe_'.$tipo;
        $mipath=$miruta.$nombre_fichero.'.xlsx';
        //echo $mipath;
        if(file_exists($miruta)) {
            include('Classes/PHPExcel.php');
            include('Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            //crea hojas
            //$i=1;
            $mipath2=$miruta.$nombre_fichero.'.xlsx';
            //echo $mipath2;
            if(file_exists($mipath2)) {
                $archivo = $mipath2;
                $inputFileType = PHPExcel_IOFactory::identify($archivo);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($archivo);
                /*$objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
                */
                
            } else {
                                
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe de Ordenes");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                    
                    $objWorkSheet->setCellValue('A2', '#')
                        ->setCellValue('B2', 'Fecha Ingreso')
                        ->setCellValue('C2', 'Sequence')
                        ->setCellValue('D2', 'Items')
                        ->setCellValue('E2', 'ID Cliente')
                        ->setCellValue('F2', 'Bloqueos')
                        ->setCellValue('G2', 'Nom Cliente')
                        ->setCellValue('H2', 'ID Destino')
                        ->setCellValue('I2', 'Ciudad')
                        ->setCellValue('J2', 'Estado Ped')
                        ->setCellValue('K2', 'Analisis');
                     
                    
                    $objWorkSheet->setTitle("Pedidos faltantes en IBS");
            }
            
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
            $fil++;
        }
        //ANCHOS
        $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', "Ordenes Pendientes");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    
    while($q<$conSeq){
     $resultSQL = mssql_query("SELECT Sequence, Estado, IDPedidoPagina, IDCliente, NombreCliente, IDordenAgro, Celular, CodigoMunicipalidad, vBarrio, FechaIngreso FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] WHERE Sequence='$arrarSequence[$q]'");
     if($resultado = mssql_fetch_array($resultSQL)){
        $Sequence=$resultado["Sequence"];
        $IDPedidoP=$resultado["IDPedidoPagina"];
        $IDCliente=$resultado["IDCliente"];
        $NombreClienteSQL=$resultado["NombreCliente"];
        $IDOrden=$resultado["IDordenAgro"];
        $Celular=$resultado["Celular"];
        $IDestino=$resultado["CodigoMunicipalidad"];
        $FechaIngreso=$resultado["FechaIngreso"];
        //codigo destino lupap
        $vBarrioDest=$resultado["vBarrio"];
        $Estado=$resultado["Estado"];
        
        $tmpSql="";
        $ciudad="";
        //codigo destino magento local
        //if($IDestino=="" ){
        //$sqlP = "SELECT CodigoMunicipalidad, ciudad FROM magento_orden WHERE Sequence='$Sequence'";
        if(strlen($arrarSequence[$q]) < 9){
            $SequenceMg=str_pad($arrarSequence[$q], 9, "0", STR_PAD_LEFT);
        }else{
            $SequenceMg=$arrarSequence[$q];
        }
        $dptoMg="";
        $ciudadMg="";
        $IDestinoMg="";
        //echo $SequenceMg.":::::";
        $sqlP="SELECT 
        B.region as Departamento
        ,B.city as Ciudad
        ,B.postcode as Codpostalmg
        FROM agro_sales_order A 
        inner join agro_sales_order_address B on A.shipping_address_id = B.entity_id
        WHERE increment_id='$SequenceMg'";
        $resultP = mysqli_query($mysqliM, $sqlP);
        if($rowP = mysqli_fetch_assoc($resultP)){
            $dptoMg=$rowP[Departamento];
            $ciudadMg=$rowP[Ciudad];
            $IDestinoMg=$rowP[Codpostalmg];
            }
                
        //CONSULTA DESTINO EN IBS ************************************************************
                $hayDestIbs=1;
                if($vBarrioDest != ""){
                $ibsDestino = "SELECT *FROM AGR620CFAG.SRODST WHERE DTDEST='$vBarrioDest'";
                $resultDestino = odbc_exec($db2con, $ibsDestino);
                $rcD=odbc_num_rows($resultDestino);
                //echo $vBarrioDest."-----".$ciudadMg."---------".$dptoMg."-----TOT REG:".$rcD."-----<br>";
                if($rcD <= 0){
                    //actualiza nuevo codigo lupap como destino en ibs
                    $hayDestIbs=0;
                    if($vBarrioDest != "" && $ciudadMg != ""){
                        $Dpto=$ciudadMg."-".$dptoMg;
                        $sql2A = "INSERT INTO AGR620CFAG.SRODST (DTDEST,DTDESC) VALUES('$vBarrioDest','$Dpto')";
                        $result2A = odbc_exec($db2con, $sql2A);
                    }
                }
                //TABLA DOS DESTINOS CLIENTES NUEVOS
                $hayDestIbs2=1;
                $ibsDestino2 = "SELECT * FROM AGR620CFAG.COBCTLDN WHERE DNMCOD='$vBarrioDest'";
                $resultDestino2 = odbc_exec($db2con, $ibsDestino2);
                $rcD2=odbc_num_rows($resultDestino2);
                if($rcD2 <= 0){
                    //actualiza nuevo codigo lupap como destino en ibs cliente nuevos
                    $hayDestIbs2=0;
                    if($vBarrioDest != "" && $ciudadMg != ""){
                        $Dpto=$ciudadMg."-".$dptoMg;
                        $CodCity=substr($vBarrioDest,0,2);
                        $sql2B = "INSERT INTO AGR620CFAG.COBCTLDN (DNDCOD, DNDNAM, DNMCOD, DNMNAM) VALUES ('$CodCity','$dptoMg','$vBarrioDest','$ciudadMg')";
                        $result2B = odbc_exec($db2con, $sql2B);
                    }
                }
                }
                //*****************************************************************************************
        
        if($IDestino=="" ){
            $IDestino=$IDestinoMg;        
        }
        $ciudadest=utf8_encode($ciudadMg);
        
        //VERIFICA LISTA NEGRA EN IBS**********************************************************
        $sqlLista = "SELECT SRBNAM.NANCA5 AS LISTA FROM AGR620CFAG.SRONAM SRBNAM WHERE SRBNAM.NATREG='$IDCliente'";
        $resultLista = odbc_exec($db2con, $sqlLista);
        //comprueba si hay datos
        $estadoLista="";
        $rcL=odbc_num_rows($resultLista);
        if($rcL>0){
            if($rowLista = odbc_fetch_array($resultLista)){
                $Lista=$rowLista["LISTA"];
                if(trim($Lista)=='C013'){
                    $estadoLista="LISTA NEGRA";    
                }
            }
        }
        
        $fechaComoEntero = strtotime($FechaIngreso);
        $anio = date("Y", $fechaComoEntero);
        $mes = date("m", $fechaComoEntero);
        $dia = date("d", $fechaComoEntero);
        $hora = date("h", $fechaComoEntero);
        $minu = date("m", $fechaComoEntero);
        $segu = date("i", $fechaComoEntero);
        $merid = date("a", $fechaComoEntero);
        $FechaSQL=$anio.$mes.$dia;
        $FechaSQLB=$anio."-".$mes."-".$dia." : ".$hora."-".$minu."-".$segu." ".$merid;
        //$FechaSQLB=$FechaIngreso;
        //$FechaP=date_format($FechaSQLB, 'Y-m-d H:i:s');
        //FECHA SISTEMA
        $anioSys = date("Y");
        $mesSys = date("m");
        $diaSys = date("d");
        $FechaSys=$anioSys.$mesSys.$diaSys;
             
        $CeluCliente = ereg_replace("+", "", $Celular);
        $CeluCliente = ereg_replace("+57 ", "", $Celular);
        $CeluCliente=trim($CeluCliente);
       
        //$IDClienteNum = ereg_replace("#", "", $IDCliente);
        //$IDClienteNum=trim($IDClienteNum);
        $IDClientex=$IDCliente;
        $IDClienteNum=str_replace(".","",$IDCliente);
        $IDClienteNum=str_replace(",","",$IDClienteNum);
        $IDClienteNum=str_replace("#","",$IDClienteNum);
        $IDClienteNum=str_replace("-","",$IDClienteNum);
        $IDClienteNum=trim($IDClienteNum);
        $HayOrdenIBS=false;
        
        //ENCABEZADO ORDENES IBS
      
        $itemsArraySQL=new ArrayIterator();
        $CantItemArraySQL=new ArrayIterator();
        //***
        $itemsArrayIBS=new ArrayIterator();
        $CantItemArrayIBS=new ArrayIterator();
        $conItemsSQL=0;
        
        $resultSQLLine = mssql_query("SELECT IDProducto ,Cantidad ,Estado FROM [sqlFacturas].[dbo].[CreacionItemsVenta] WHERE IDPedidoPagina='$IDPedidoP'");
        while($resultadoLine = mssql_fetch_array($resultSQLLine)){
            //quita puntos y letras
            $itemSql=$resultadoLine["IDProducto"];
            $itemSql=trim($itemSql);
            $tmpSql.=$itemSql."<br />";
            $cantItems=$resultadoLine["Cantidad"];
            $itemsArraySQL[$conItemsSQL]=$itemSql;
            $CantItemArraySQL[$conItemsSQL]=$cantItems;
            $conItemsSQL++;
        }
        
        $cantItemsSQL=count($itemsArraySQL);
        $IDClienteIBSAux="";
        $NombreClienteIBSAux="";
        
        //opcional cuando no tiene cedula busca por celular el cliente y trae la cedula y nombre
        /*$sqlop = "SELECT NANUM, NANSNA FROM AGR620CFAG.SRONAM WHERE NANSNO='$CeluCliente' AND NANSNO != ''"; 
        $resultop = odbc_exec($db2con, $sqlop);
        if($rowop = odbc_fetch_array($resultop)){
            $IDClienteIBSAux=$rowop["NANUM"];
            $NombreClienteIBSAux=$rowop["NANSNA"];
        }*/
        
        //***VERIFICA SI HAY UNA ORDEN CREADA EN EL ENCABEZADO CON ESA SEQUENCE EN IBS
        //if($IDClienteNum=="0" || $IDClienteNum=="" || strlen($IDClienteNum)<6 || $IDClienteNum=="#"){
        //if($IDClienteNum=="0" || $IDClienteNum=="" || strlen($IDClienteNum)<6 || $IDClienteNum=="#"){
            //OR (OHCUNO='$IDClienteIBSAux' AND OHODAT BETWEEN '$FechaSQL' AND '$FechaSys')
             //$sql = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT IN('S1','S5') AND (OHOREF='$Sequence') AND (OHODAT BETWEEN '$FechaSQL' AND '$FechaSys')";  
        $sql = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT IN('S1','S5') AND (OHOREF='$Sequence') AND (OHODAT BETWEEN '$FechaSQL' AND '$FechaSys')";
        //}else{
            //$sql = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT IN('S1','S5') AND ((OHCUNO='$IDClienteNum' OR OHCUNO='$IDClienteIBSAux') AND (OHODAT BETWEEN '$FechaSQL' AND '$FechaSys')) AND (OHOREF='$Sequence')";
        //}
        
        $result = odbc_exec($db2con, $sql);
        
        //comprueba si hay una orden con lineas
        $rc=odbc_num_rows($result);
        //echo "___;sq:".$Sequence." ID:".$IDClienteNum." Fi:".$FechaSQL." Ff:".$FechaSys."rc=".$rc;        
        if($rc > 0){ 
            //verifica todas las ordenes del cliente y compara ventores
            //$aux="";
            while($row = odbc_fetch_array($result)){
                $Orden=$row["OHORNO"];
                $IDClienteIBS=$row["OHCUNO"];
                $NombreClienteIBS=$row["OHNAME"];
                if($Orden != ""){
                    //SI ORDEN ESTA EN EL ENCABEZADO
                                //lineas DEL PEDIDO
                                $sql2 = "SELECT * FROM AGR620CFAG.SRBSOL WHERE OLORNO='$Orden' AND OLCUNO='$IDClienteIBS'";
                                $result2 = odbc_exec($db2con, $sql2);
                                $rcLines=odbc_num_rows($result2);
                                $cantItemsIBS=0;
                                $conItemsIBS=0;
                                if($rcLines > 0){
                                    $tieneLineas="Con Items";
                                    //verifica item por item de ibs con respecto a sql OLOQTY='$CantItemArraySQL[$i]'
                                    while($row2 = odbc_fetch_array($result2)){
                                        $ItemIBS=$row2["OLPRDC"];
                                        $ItemIBS=trim($ItemIBS);
                                        //$CantItemIBS=$row2["OLOQTY"];
                                        //SI ESTAN LAS LINEAS POOR ORDEN Y CEDULA
                                        if($ItemIBS != ""){
                                            $i=0;
                                            //&& ($CantItemIBS==$CantItemArraySQL[$i])
                                            while($i<$cantItemsSQL){
                                                if(($ItemIBS == $itemsArraySQL[$i])){
                                                    $itemsArrayIBS[$i]=$ItemIBS;
                                                    //$CantItemArrayIBS[$i]=$CantItemIBS;
                                                    $tmpIbs.=$ItemIBS.",";
                                                }
                                                $i++;
                                            }
                                        }
                                    }
                                    
                                    $cantItemsIBS=count($itemsArrayIBS);
                                    //compara ventores de items
                                    $i=0;
                                    $iguales=false;
                                    $conItemsIBS=0;
                                    while($i<$cantItemsSQL){
                                        $j=0;
                                        while($j<$cantItemsIBS){
                                            if(trim($itemsArraySQL[$i])==trim($itemsArrayIBS[$j])){
                                                $conItemsIBS++;
                                            }
                                            $j++;        
                                        }
                                        $i++;
                                    }
                            }else{
                                if(($fd % 2)==0){
                                    $S2=$S1b;
                                }else{
                                    $S2=$S1c; 
                                }   
                                $tieneLineas="Sin Items";
                                $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                                $r=$r . "<td style='$S2'>".$q2."</td>";
                                $r=$r . "<td style='$S2'>".$FechaSQLB."</td>";
                                $r=$r . "<td style='$S2'>".$Sequence."</td>";
                                $r=$r . "<td style='$S2'>".$tmpSql."</td>";
                                if($IDClienteIBS==""){
                                    $r=$r . "<td style='$S2'>".$IDClientex."</td>";
                                }else{
                                    $r=$r . "<td style='$S2'>".$IDClienteIBS."</td>";
                                }
                                $r=$r . "<td style='$S2'>".$estadoLista."</td>";
                                if($NombreClienteIBS==""){
                                    $r=$r . "<td style='$S2'>".utf8_decode($NombreClienteSQL)."</td>";
                                }else{
                                    $r=$r . "<td style='$S2'>".utf8_decode($NombreClienteIBS)."</td>";
                                }
                                //$r=$r . "<td style=\"color: red;font-weight: bold;font-size: 1em;\">".$IDOrden."</td>";
                                $r=$r . "<td style='$S2'>".$IDestino."</td>";
                                $r=$r . "<td style='$S2'>".$ciudadest."</td>";
                                $r=$r . "<td style='$S2'>".$Estado."</td>";
                                $r=$r . "<td style='$S2'>Subido a IBS ".$tieneLineas."</td>";
                                $r=$r . "<td style='$S2'>-</td>";
                                $r=$r . "</tr>";  
                                $Orden="";
                                $q2++;
                            }
          
                    //FIN SI ORDEN        
                    }
                
                }   //fin while xx
                //fin si result
            }else{
                //MySQL Magento
                if(($fd % 2)==0){
                    $S2=$S1b;
                }else{
                    $S2=$S1c; 
                }
                                
                //buscar la ced y nombre
                //style=\"color: red;font-weight: bold;font-size: 0.8em;\"
                $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                $r=$r . "<td style='$S2'>".$q2."</td>";
                $r=$r . "<td style='$S2'>".$FechaSQLB."</td>";
                $r=$r . "<td style='$S2'>".$Sequence."</td>";
                $r=$r . "<td style='$S2'>".$tmpSql."</td>";
                $r=$r . "<td style='$S2'>".$IDClientex."</td>";
                $r=$r . "<td style='$S2'>".$estadoLista."</td>";
                $r=$r . "<td style='$S2'>".utf8_decode($NombreClienteSQL)."</td>";
                $r=$r . "<td style='$S2'>".$IDestino."</td>";
                $r=$r . "<td style='$S2'>".$ciudadest."</td>";
                $r=$r . "<td style='$S2'>".$Estado."</td>";
                $r=$r . "<td style='$S2'>Falta en IBS</td>";
                //if($IDClienteNum != "#" && $IDClienteNum != "0" && $IDClienteNum != "" && strlen($IDClienteNum) > 5 && $estadoLista!="LISTA NEGRA" && $FechaSQL!=$FechaHoy){
                //$r=$r . "<td style='$S2'><input type='button' id='ActivarOd$Sequence' name='".$Sequence."' onClick='activarOrden(this.name);' onmouseup='ocultarBoton(this.name);' value='Activar Orden'></td>";
                $msgOrden="";
                if($IDClienteNum != "#" && $IDClienteNum != "0" && $IDClienteNum != "" && strlen($IDClienteNum) > 5 && $estadoLista!="LISTA NEGRA" && $Estado==1){
                    $r=$r . "<td style='$S2'><input type='button' id='ActivarOd$Sequence' name='".$Sequence."' onClick='activarOrden(this.name);' onmouseup='ocultarBoton(this.name);' value='Activar Orden'></td>";
                }else{
                    if($FechaSQL!=$FechaHoy){
                        if($hayDestIbs==0){
                            $msgOrden="Falta destino en IBS,<br>";
                            //$r=$r . "<td style='$S2'>Falta ID y/o Nit Cliente y/o LISTA NEGRA</td>";
                        }
                        if($estadoLista == "LISTA NEGRA"){
                            $msgOrden=$msgOrden."Cliente en lista negra,<br>";
                        }
                        if(strlen($IDClienteNum) < 5){
                            $msgOrden=$msgOrden."Falta Nit o ID Cliente,<br>";   
                        }
                        $r=$r . "<td style='$S2'>$msgOrden</td>";
                    }else{
                        $r=$r . "<td style='$S2'>Orden de Hoy</td>";
                    }
                }
                $r=$r . "</tr>";
                //excel
                $tmpSql=str_replace("<br />",";",$tmpSql);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$fd, $q2)            
                    ->setCellValue('B'.$fd, $FechaSQLB)
                    ->setCellValue('C'.$fd, $Sequence)
                    ->setCellValue('D'.$fd, $tmpSql)
                    ->setCellValue('E'.$fd, $IDClientex)
                    ->setCellValue('F'.$fd, $estadoLista)
                    ->setCellValue('G'.$fd, utf8_decode($NombreClienteSQL))
                    ->setCellValue('H'.$fd, $IDestino)
                    ->setCellValue('I'.$fd, $ciudadest)
                    ->setCellValue('J'.$fd, $Estado)
                    ->setCellValue('K'.$fd, "Falta en IBS");
                
                $fd++;
                $Orden="";
                $q2++;
            } 
        }
        $q++;
    }   //fin while encabezado
    
    $r=$r . "</table>";
    //CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);
    //date_default_timezone_set('UTC');
    //$fecha=date("Y-m-d H:i:s");
    mysqli_close($mysqliM);
    odbc_close($result2);
    odbc_close($result);
    mssql_close();
    echo $r;

?>