<?php
    $Sequence=$_GET['s'];
    $cantItemsSQL=0;
    $HayOrdenItemsIBS=0;
    $hayCabeceraIBS=0;
    $EstaIBs="";
    require_once('conectarbase.php');
    require_once('user_con.php');
    require_once('user_con_maglocal.php');
      
      //pppruebas
    /*
      $sqlP = "SELECT CodigoMunicipalidad FROM magento_orden WHERE Sequence='$Sequence'";
      $resultP = mysqli_query($mysqliL, $sqlP);
      if($rowP = mysqli_fetch_row($resultP)){
        $idMunicip = trim($rowP[0]);   //agregado
        $vBarrioMun=substr($idMunicip,0,6);
      }
    echo $idMunicip."----".$vBarrioMun;
    exit();
    */
    $resultSQLP = mssql_query("SELECT IDPedidoPagina, IDCliente FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] WHERE Sequence='$Sequence'");
    if($resultadoP = mssql_fetch_array($resultSQLP)){
        $IDPedidoPagina=$resultadoP["IDPedidoPagina"];
        $IDClienteB=$resultadoP["IDCliente"];
        //verifica cantidad de items
        $resultSQLLineT = mssql_query("SELECT COUNT(*) AS Total FROM [sqlFacturas].[dbo].[CreacionItemsVenta] WHERE IDPedidoPagina='$IDPedidoPagina'");
        if($resultadoT=mssql_query($resultSQLLineT)){
            $cantItemsSQL=$resultadoT["Total"];      
        }
    }
    $IDClienteZ=str_replace(".","",$IDClienteB);
    $IDCliente = intval(preg_replace('/[^0-9]+/', '', $IDClienteZ), 10);
    //revisa que no este en IBS
    $sql = "SELECT * FROM AGR620CFAG.SRBSOH WHERE OHORDT IN('S1','S5') AND OHOREF='$Sequence'";
    $result = odbc_exec($db2con, $sql);
    $rc=odbc_num_rows($result);
    if($rc > 0){
        if($row = odbc_fetch_array($result)){
                $Orden=$row["OHORNO"];
                $IDClienteIBS=$row["OHCUNO"];
                $NombreClienteIBS=$row["OHNAME"];
                if($Orden != ""){
                    $hayCabeceraIBS=1;
                    //SI ORDEN ESTA EN EL ENCABEZADO
                                //lineas DEL PEDIDO IBS
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
                                $tieneLineas="Sin Items";
                                $Orden="";
                                $q2++;
                            }
                            if($conItemsIBS==$cantItemsSQL){
                                $HayOrdenItemsIBS=1; 
                            } else {
                                $HayOrdenItemsIBS=0;
                            }
                    //FIN SI ORDEN    
                    odbc_close($result2);    
                    }
                
                }
    }
    odbc_close($result);
    
    //Obtiene la IP del cliente
                function get_client_ip() {
                    $ipaddress = '';
                    if (getenv('HTTP_CLIENT_IP'))
                        $ipaddress = getenv('HTTP_CLIENT_IP');
                    else if(getenv('HTTP_X_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                    else if(getenv('HTTP_X_FORWARDED'))
                        $ipaddress = getenv('HTTP_X_FORWARDED');
                    else if(getenv('HTTP_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_FORWARDED_FOR');
                    else if(getenv('HTTP_FORWARDED'))
                       $ipaddress = getenv('HTTP_FORWARDED');
                    else if(getenv('REMOTE_ADDR'))
                        $ipaddress = getenv('REMOTE_ADDR');
                    else
                        $ipaddress = 'UNKNOWN';
                    return $ipaddress;
                }
                
                /*function write_visita ($idc){
                    //Indicar ruta de archivo válida
                    $archivo="informe.txt";
                    $new_ip=get_client_ip();
                    $now = new DateTime();
                    $txt =  str_pad($new_ip,25). " ".
                        str_pad($now->format('Y-m-d H:i:s'),25)."     Id:".$idc;
                    $myfile = file_put_contents($archivo, $txt.PHP_EOL , FILE_APPEND);
                }*/
    date_default_timezone_set('UTC');
    $fecha=date("F j, Y, g:i a");
    //$nompc=gethostbyaddr($_SERVER['REMOTE_ADDR']);//gethostname();
    //echo $hayCabeceraIBS."---".$HayOrdenItemsIBS;
    if($hayCabeceraIBS==0 && $HayOrdenItemsIBS==0){
            $i=0;
            $c=0;
            //echo "aquies";
            $IDPedidoPagina1="";
            $IDPedidoPagina2="";
            $resultSQLI = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[CreacionItemsVenta] WHERE IDPedidoPagina='$IDPedidoPagina'");
            if($resultadoP = mssql_fetch_array($resultSQLI)){
                $IDPedidoPagina1=$resultadoP["IDPedidoPagina"];
                if($IDPedidoPagina1 != ""){
                    $resultSQLItm = "UPDATE [sqlFacturas].[dbo].[CreacionItemsVenta] SET Estado='0' WHERE IDPedidoPagina='$IDPedidoPagina'";
                    if($resultado1=mssql_query($resultSQLItm)){
                        $i=1;    
                    }
                }
            }
            
            $resultSQLC = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[CreacionEncabezadoVenta] WHERE IDPedidoPagina='$IDPedidoPagina'");
            if($resultadoP2 = mssql_fetch_array($resultSQLC)){
                $IDPedidoPagina2=$resultadoP2["IDPedidoPagina"];
                $IDDestinoOrden=$resultadoP2["CodigoMunicipalidad"];
                //verifica si falta el codigo municipalidad o destino lo trae de magento
                if($IDPedidoPagina2 != ""){
                    if($IDDestinoOrden == ""){
                        $sqlP = "SELECT CodigoMunicipalidad FROM magento_orden WHERE IDPedidoPagina ='$IDPedidoPagina2'";
                        $resultP = mysqli_query($mysqliL, $sqlP);
                        if($rowP = mysqli_fetch_row($resultP)){
                              $idMunicip = trim($rowP[0]);   //agregado
                              $vBarrioMun=substr($idMunicip,0,6);
                              //edita 
                              //if($idMunicip != ""){
                                    $resultSQLCab = "UPDATE [sqlFacturas].[dbo].[CreacionEncabezadoVenta] SET IDCliente='$IDCliente', Estado='0', Telefono='', CodigoMunicipalidad='$idMunicip' WHERE IDPedidoPagina='$IDPedidoPagina2'";
                                    if($resultado2=mssql_query($resultSQLCab)){
                                        $c=1;
                                    }
                              //}
                        }
                    } else {
                        //if($IDPedidoPagina2 != ""){
                            $resultSQLCab = "UPDATE [sqlFacturas].[dbo].[CreacionEncabezadoVenta] SET IDCliente='$IDCliente', Estado='0', Telefono='' WHERE IDPedidoPagina='$IDPedidoPagina2'";
                            if($resultado2=mssql_query($resultSQLCab)){
                                $c=1;
                            }
                        //}
                    }
                }
            }
            
            if($i==1 && $c==1){
                $EstaIBs = "Orden del Pedido fue ACTIVADA para ser Procesada por el Integrador de Ordenes de IBS";
                $ip=get_client_ip();
                $msgtxt=$fecha." Orden del Pedido Web ".$Sequence." fue ACTIVADA por el Usuario: ".$_SESSION['usuARio']." desde la IP: ".$ip;
                $archivo="informe.txt";
                $myfile = file_put_contents($archivo, $msgtxt.PHP_EOL , FILE_APPEND);
                //$texto="\nSubida:".$fecha.", Ingreso: ".$PeriodoIbs.": NumOrdenes actualizadas faltantes en SqlServer: ".$texto1." , Sequences estados cambiados a 0 en SqlServer: ".$texto2;
                //write_visita ($msgtxt);
            }else{
                $EstaIBs = "Orden del Pedido ".$Sequence." NO fue Activada, Revise datos en la base SQLServer!";
            }
        } else {
            if($hayCabeceraIBS==1 && $HayOrdenItemsIBS==1){
                $EstaIBs="Orden del Pedido ".$Sequence." esta en IBS";
            } else  if($hayCabeceraIBS==1 && $HayOrdenItemsIBS==0){
                $EstaIBs="Orden del Pedido ".$Sequence." esta en IBS pero no tiene Items";
            } 
        }
        
        mssql_close();
        echo $EstaIBs;

?>