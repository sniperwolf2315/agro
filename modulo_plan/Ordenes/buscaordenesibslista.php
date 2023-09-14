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
$estado="OrdenNoExiste";
$tmpSql="";
$tmpIbs="";
$r="<table style=\"border: 1px solid #000; width:100%;\">";
    //$resultSQL = mssql_query("SELECT Sequence, IDPedidoPagina, IDCliente FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] where IDordenAgro='' AND Estado='1' AND datepart(year,FechaIngreso)='$anio' and datepart(month,FechaIngreso)='$mes' and datepart(day,FechaIngreso)='$dia'");
    $resultSQL = mssql_query("SELECT Sequence, IDPedidoPagina, IDCliente, IDordenAgro, Celular, FechaIngreso FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] WHERE Estado='1' AND IDordenAgro='1'");
    if($resultado = mssql_fetch_array($resultSQL)){
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
                
                $HayItemsIBS=false;
                
                $conItemsIBS=0;
                //lineas DEL PEDIDO
                         $conItemsIBS=0;
                            $sql2 = "SELECT * FROM AGR620CFAG.SRBSOL WHERE OLORNO='$Orden' AND OLCUNO='$IDClienteIBS'";
                            $result2 = odbc_exec($db2con, $sql2);
                            //verifica item por item de ibs con respecto a sql OLOQTY='$CantItemArraySQL[$i]'
                            while($row2 = odbc_fetch_array($result2)){
                                $ItemIBS=$row2["OLPRDC"];
                                $ItemIBS=trim($ItemIBS);
                                $CantItemIBS=$row2["OLOQTY"];
                                $i=0;
                                while($i<$cantItemsSQL){
                                    if(($ItemIBS == $itemsArraySQL[$i]) && ($CantItemIBS==$CantItemArraySQL[$i]) ){
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
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Sequence:</td>";
                            $r=$r . "<td style=\"color: red;font-weight: bold;font-size: 1em;\">".$Sequence."</td>";
                            $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Orden:</td>";
                            $r=$r . "<td style=\"color: red;font-weight: bold;font-size: 1em;\">".$Orden."</td>";
                            $r=$r . "<td style=\"font-weight: bold;width: 15%;text-align: left;\">Cargada en IBS</td>";
                            $r=$r . "</tr>";      
                        }else{
                            
                            $r=$r . "<tr style=\"border-bottom: 1pt solid black;\">";
                            $r=$r . "<td style=\"font-weight: bold;width: 10%;text-align: left;\">Sequence:</td>";
                            $r=$r . "<td style=\"color: red;font-weight: bold;font-size: 1em;\">".$Sequence."</td>";
                            $r=$r . "<td style=\"font-weight: bold;width: 10%;text-align: left;\">Orden:</td>";
                            $r=$r . "<td style=\"color: red;font-weight: bold;font-size: 1em;\">".$Orden."</td>";
                            $r=$r . "<td style=\"font-weight: bold;width: 10%;text-align: left;\">Pendiente</td>";
                            $r=$r . "</tr>";
                        }
                        
            }
        
        }
    }
    $r=$r . "</table>";
    //date_default_timezone_set('UTC');
    //$fecha=date("Y-m-d H:i:s");
    odbc_close($result);
    mssql_close();
    echo $r;

?>