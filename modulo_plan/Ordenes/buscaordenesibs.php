<?php
require_once('conectarbase.php');
require_once('user_con.php');
//$dia=trim($_GET['d']);
//$mes=trim($_GET['m']);
//$anio=trim($_GET['a']);
$Sequence=trim($_GET['sq']);
$Orden="-";
$PeriodoIbs=$anio.$mes.$dia;
$accion="";
$conteo1=0;
$conteo2=0;
$texto1="";
$texto2="";
$HayItems="NO";

//ojo leer la sequence por pagina

$tmpSql="";
$tmpIbs="";
    //IDordenAgro=''
    //$resultSQL = mssql_query("SELECT Sequence, IDPedidoPagina, IDCliente FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] where IDordenAgro='' AND Estado='1' AND datepart(year,FechaIngreso)='$anio' and datepart(month,FechaIngreso)='$mes' and datepart(day,FechaIngreso)='$dia'");
    $resultSQL = mssql_query("SELECT Sequence, IDPedidoPagina, IDCliente, IDordenAgro, Celular, FechaIngreso FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] WHERE Estado='1' AND Sequence='$Sequence'");
    if($resultado = mssql_fetch_array($resultSQL)){
        //$sequencia=$resultado["Sequence"];
        $IDPedidoP=$resultado["IDPedidoPagina"];
        $IDCliente=$resultado["IDCliente"];
        $IDOrden=$resultado["IDordenAgro"];
        $Celular=$resultado["Celular"];
        $FechaIngreso=$resultado["FechaIngreso"];
        //$Fecha=substr((String)$FechaIngreso,0,10);
        $fechaComoEntero = strtotime($FechaIngreso);
        $anio = date("Y", $fechaComoEntero);
        $mes = date("m", $fechaComoEntero);
        $dia = date("d", $fechaComoEntero);
        $FechaSQL=$anio.$mes.$dia;
        //FECHA SISTEMA
        $anioSys = date("Y");
        $mesSys = date("m");
        $diaSys = date("d");
        $FechaSys=$anioSys.$mesSys.$diaSys;
        //echo "Año:".$anioSys." Mes:".$mesSys." Dia:".$diaSys;
        //exit();
        
        $CeluCliente = ereg_replace("[^0-9]", "", $Celular);
        $CeluCliente=trim($CeluCliente);
        //if($IDOrden==""){
        //$IDordenAgr=$resultado["IDordenAgro"];
        $IDClienteNum = ereg_replace("[^0-9]", "", $IDCliente);
        $IDClienteNum=trim($IDClienteNum);
        $HayOrdenIBS=false;
        //ENCABEZADO ORDENES IBS
        //$sql = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHOREF='$sequencia' AND OHCUNO='$IDClienteNum' AND OHODAT='$PeriodoIbs'";
        //SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT='S1' AND OHCUNO='40991453' 
                //$tmp="";
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
                    $tmpSql.=$itemSql.",";
                    $cantItems=$resultadoLine["Cantidad"];
                    $itemsArraySQL[$conItemsSQL]=$itemSql;
                    $CantItemArraySQL[$conItemsSQL]=$cantItems;
                    $conItemsSQL++;
                }
        $cantItemsSQL=count($itemsArraySQL);
        //opcional cuando no tiene cedula busca por celular el cliente y trae la cedula y nombre
        $sqlop = "SELECT NANUM, NANSNA FROM AGR620CFAG.SRONAM WHERE NANSNO='$CeluCliente' AND NANSNO != ''"; 
        $resultop = odbc_exec($db2con, $sqlop);
        if($rowop = odbc_fetch_array($resultop)){
            $IDClienteIBSAux=$rowop["NANUM"];
            $NombreClienteIBSAux=$rowop["NANSNA"];
        }
        
        //***VERIFICA SI HAY UNA ORDEN CREADA EN EL ENCABEZADO CON ESA SEQUENCE EN IBS
        if($IDClienteNum=="0" || $IDClienteNum=="" || strlen($IDClienteNum)<6){
             $sql = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT IN('S1','S5') AND (OHOREF='$Sequence' AND OHODAT BETWEEN '$FechaSQL' AND '$FechaSys') OR (OHCUNO='$IDClienteIBSAux' AND OHODAT BETWEEN '$FechaSQL' AND '$FechaSys')";  
        }else{
            $sql = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT IN('S1','S5') AND ((OHCUNO='$IDClienteNum' OR OHCUNO='$IDClienteIBSAux') AND OHODAT BETWEEN '$FechaSQL' AND '$FechaSys') OR (OHOREF='$Sequence' AND OHODAT BETWEEN '$FechaSQL' AND '$FechaSys')";
        }
        $result = odbc_exec($db2con, $sql);
        //verifica todas las ordenes del cliente y compara ventores
        //$itemsArrayIBS=new ArrayIterator();
        $aux="";
        while($row = odbc_fetch_array($result)){
            $Orden=$row["OHORNO"];
            $IDClienteIBS=$row["OHCUNO"];
            $NombreClienteIBS=$row["OHNAME"];
            $aux.=$Orden;
            if($Orden != ""){
                //$HayOrdenIBS=true;
                //$accion=$accion."Hay orden en IBS";
                $HayItemsIBS=false;
                
                $conItemsIBS=0;
                //lineas DEL PEDIDO
                         $conItemsIBS=0;
                        //while($i<$cantItemsSQL){
                            $sql2 = "SELECT * FROM AGR620CFAG.SRBSOL WHERE OLORNO='$Orden' AND OLCUNO='$IDClienteIBS'";
                            $result2 = odbc_exec($db2con, $sql2);
                            //verifica item por item de ibs con respecto a sql OLOQTY='$CantItemArraySQL[$i]'
                            while($row2 = odbc_fetch_array($result2)){
                                $ItemIBS=$row2["OLPRDC"];
                                $ItemIBS=trim($ItemIBS);
                                $CantItemIBS=$row2["OLOQTY"];
                                $i=0;
                                while($i<$cantItemsSQL){
                                    //&& ($CantItemIBS==$CantItemArraySQL[$i])
                                    if(($ItemIBS == $itemsArraySQL[$i]) && ($CantItemIBS==$CantItemArraySQL[$i]) ){
                                        //$conItemsIBS++;
                                        $itemsArrayIBS[$i]=$ItemIBS;
                                        $CantItemArrayIBS[$i]=$CantItemIBS;
                                        $tmpIbs.=$ItemIBS.",";
                                    }
                                    $i++;
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
                        
                        if($conItemsIBS==$cantItemsSQL){
                            $r="<table style=\"border: 1px solid #000; width:100%;\">";
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td style=\"width: 25%;\">&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Sequence Pedido:</td>";
                            $r=$r . "<td style=\"color: red;font-weight: bold;font-size: 1.2em;\">".$Sequence."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">Orden:</td>";
                            if($Orden != ""){
                                $r=$r . "<td>".$Orden."   Cargada en IBS: Si</td>";
                            }else{
                                $r=$r . "<td>".$Orden."   Cargada en IBS: No, Revisar Orden.</td>";
                            }
                            $r=$r . "</tr>";
                                                      
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">Items Pagina:</td>";
                            $r=$r . "<td>".$tmpSql."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">Items IBS:</td>";
                            $r=$r . "<td>".$tmpIbs."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">ID Cliente1:</td>";
                            $r=$r . "<td>".$IDClienteIBSAux."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">Nombre Cliente1:</td>";
                            $r=$r . "<td>".utf8_decode($NombreClienteIBSAux)."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">ID Cliente2:</td>";
                            $r=$r . "<td>".$IDClienteIBS."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">Nombre Cliente2:</td>";
                            $r=$r . "<td>".utf8_decode($NombreClienteIBS)."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td>&nbsp;</td>";
                            $r=$r . "<td style=\"font-weight: bold;\">Fechas Orden:</td>";
                            $r=$r . "<td>Rango: ".$FechaSQL." - ".$FechaSys."</td>";
                            $r=$r . "</tr>";
                            
                            $r=$r . "</table>";
                            $accion=$accion."Orden IBS: ".$Orden." Items;";
                            odbc_close($result2);
                            odbc_close($result);
                            mssql_close();
                            echo $r;
                            //echo $accion.$tmpSql." ; ".$tmpIbs." Cliente1: ".$IDClienteIBSAux." Cliente2: ".$IDClienteIBS." Nombre1:".$NombreClienteIBSAux." Nombre2:".$NombreClienteIBS." fechas:".$FechaSQL."-".$FechaSys;
                            exit();
                            
                        }
                        //actualiza la orden de ibs en sql
                        ///if ($Orden!="" && $IDPedidoP!=""){
                            /*$consultaupd=mssql_query("UPDATE [sqlFacturas].[dbo].[CreacionItemsVenta] SET IDordenAgro='$Orden' WHERE IDPedidoPagina='$IDPedidoP'");
                            if($consultaupd){
                                $consultaupd2= mssql_query("UPDATE [sqlFacturas].[dbo].[CreacionEncabezadoVenta] SET IDordenAgro='$Orden', IDCliente='$IDClienteNum' WHERE Sequence='$sequencia' AND IDPedidoPagina='$IDPedidoP'");
                                $accion="Actualizo Orden en SqlServer";    
                            }*/
                        ///    $conteo1++;
                        ///    $Orden="";
                        ///    $texto1=$texto1.$sequencia."->ItemsIbs: ".$HayItems."--";
                        ///}
                    //}//else{
                        //cambia estado en sql a 0 y borra telefono, limpia las letras de la cedula
                        /*$consultaupd= mssql_query("UPDATE [sqlFacturas].[dbo].[CreacionItemsVenta] SET Estado='0' WHERE IDPedidoPagina='$IDPedidoP'");
                        if($consultaupd){
                            $consultaupd2=mssql_query("UPDATE [sqlFacturas].[dbo].[CreacionEncabezadoVenta] SET Estado='0', Telefono='', IDCliente='$IDClienteNum' WHERE Sequence='$sequencia' AND IDPedidoPagina='$IDPedidoP'");
                            $accion="Actualizo ESTADO de orden en 0 en SqlServer";    
                        }*/
                        //$conteo2++;
                        //$texto2=$texto2.$sequencia."--";
                    //}
                    //$HayItems="NO";
                   // }
                //}//este items
            }//
        
        }
       /*}else{
        $accion=$accion."Ya esta la Orden: ".$$IDOrden." en IBS"." Relacionada al sequence: ".$Sequence;
       } */
       //aqui 
    }
    date_default_timezone_set('UTC');
    $fecha=date("Y-m-d H:i:s");
    //$accion=$accion." Ordenes actualizadas en sqlServer=".$conteo1." , Estados Actualizados=".$conteo2;
    odbc_close($result);
    mssql_close();
                //$texto="\nSubida:".$fecha.", Ingreso: ".$PeriodoIbs.": NumOrdenes actualizadas faltantes en SqlServer: ".$texto1." , Sequences estados cambiados a 0 en SqlServer: ".$texto2;
                //function write_visita ($idc){
                    //Indicar ruta de archivo válida
                    //$archivo="informe.txt";
                    //$myfile = file_put_contents($archivo, $texto.PHP_EOL , FILE_APPEND);
                    //$accion="hola";
                //}
                //write_visita ($texto);
    if($accion==""){
        $accion="Orden no encontrada en IBS";
    }
    echo $accion;
?>