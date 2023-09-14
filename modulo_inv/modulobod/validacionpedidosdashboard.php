<?php

$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
//$dia=trim($_GET['d']);
$tipo=trim($_GET['tipo']);
$company=trim($_GET['comp']);



include('conectarbase.php');
$dato="";
if($company=="AG"){
    $cp="Agrocampo";
    }
if($company=="X1"){
    $cp="Pestar";
    }
if($company=="ZZ"){
    $cp="Comervet";
    }
$fecha=date("d_m_Y");
   
$Odenes=new ArrayIterator();
$m=intval($mes);
           
$totalreg=$totalreg+1;
$UVal=new ArrayIterator();
$CVal=new ArrayIterator();

        //$USep=new ArrayIterator();
        //$CSep=new ArrayIterator();
        //agrupamiento por funcionario
            if($company=="AG"){
               $resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') group by rv.Funcionario",$cLink);
               $i=0;
               while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                                
                                $UVal[$i]=utf8_encode($resultadoitems["Funcionario"]);
                                
                                $CVal[$i]=$resultadoitems["PedidosEmpacadosMes"];
                                                         
                                $i++;    
                         
               }
               /*$i=0;
               $resultSQLItemsm2 = mssql_query("SELECT s.Responsable as Funcionario, sum(v.LineasProcesadas) AS LineasSeparadas FROM [sqlFacturas].[dbo].[facRegistroSeparacion] s left join [sqlFacturas].[dbo].[facRegistroValidacion] v ON s.Orden=v.Orden WHERE (YEAR(v.HoraFinal)='".$anio."' AND MONTH(v.HoraFinal)='".$mes."') AND v.TipoFactura IN ('07','S2','FD','F1','D4') GROUP BY s.Responsable",$cLink);
               while($resultadoitems2 = mssql_fetch_array($resultSQLItemsm2)){
                                
                                $USep[$i]=utf8_encode($resultadoitems2["Funcionario"]);
                                
                                $CSep[$i]=$resultadoitems2["LineasSeparadas"];
                                                         
                                $i++;    
                         
               }*/
            }
            /*if($company=="X1"){
               $resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasPestar].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02','04','ZB') group by rv.Funcionario",$cLink);
               }
            if($company=="ZZ"){
               $resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasComervet].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02') group by rv.Funcionario",$cLink);
               }*/
            $j=0;
            $cant=0;
            
            //consulta
            $j=0;
            $fd=3;
            $fn=3;
            $Mess=array('1' => "ENERO",'2' => "FEBRERO",'3' => "MARZO",'4' => "ABRIL",'5' => "MAYO",'6' => "JUNIO",'7' => "JULIO",'8' => "AGOSTO",'9' => "SEPTIEMBRE",'10' => "OCTUBRE",'11' => "NOVIEMBRE",'12' => "DICIEMBRE");
            
            //setlocale(LC_TIME,"es_ES");
          
            $datos=new ArrayIterator();
            $cd=0;
            $cn=0;
            //$fd=3;
            $i=0;
            $Usuarios=new ArrayIterator();
            /*$tabla="<hr><table style='width: 700px; border: 2px solid rgb(220,220,20); padding:5px;'>";
            $tabla=$tabla . "<tr>";
            $tabla=$tabla . "<td>";
            */
                    //pedidos validados
                    $tabla="<table name='v' style='width: 200px; background-color: azure; border: 1px solid rgb(220,220,220);'>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td colspan=2  style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Validaci&oacute;n de Pedidos mes $mes</td>";
                    $tabla=$tabla . "</tr>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Usuario</td><td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Cant Ordenes</td>";
                    $tabla=$tabla . "</tr>";
                    $i=0;
                    $cantV=count($UVal);
                    while($i<$cantV){
                                
                        $tabla=$tabla . "<tr>";
                            $tabla=$tabla . "<td style='width: 200px; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$UVal[$i]."</td><td style='width: 200px; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$CVal[$i]."</td>";
                        $tabla=$tabla . "</tr>";
                        $i++;    
                         
                     }
                    $tabla=$tabla . "</table>";
           // $tabla=$tabla . "</td>";
            
            //pedidos separados    
            /*$tabla=$tabla . "<td>";
                    $tabla="<table name='s'>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td colspan=2  style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Validaci&oacute;n de Pedidos mes $mes</td>";
                    $tabla=$tabla . "</tr>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Usuario</td><td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Cantidad</td>";
                    $tabla=$tabla . "</tr>";
                    $i=0;
                    $cantS=count($USep);
                    while($i<$cantS){
                                
                        $tabla=$tabla . "<tr>";
                            $tabla=$tabla . "<td style='width: 200px; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$USep[$i]."</td><td style='width: 200px; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$CSep[$i]."</td>";
                        $tabla=$tabla . "</tr>";
                        $i++;    
                         
                     }
                    $tabla=$tabla . "</table>";
            $tabla=$tabla . "</td>";
                
            $tabla=$tabla . "<td>";
            $tabla=$tabla . "</td>";
            */    
                
            //$tabla=$tabla . "</tr>";
            //$tabla=$tabla . "</table><hr>"; 
                /*
                $f=3;
                $dias=new ArrayIterator();
                $tam=count($Usuarios);
                $i=0;
                //$tam
                 while($i<$tam){
                //funcionarios
                //while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                    $funcionario=$Usuarios[$i++];//utf8_encode($resultadoitems["Funcionario"]);
                    
                     $a=70;
                     $l="";
                     $cascii1=chr($a);
                   
                    $c=1;
                    
                        
                        $f1=0;
                        while($f1<=$number){
                            $dias[$f1]='0';
                            $f1++;
                        }
                        //$tmp="";
                        //$contdiaf=1;
                        //count(rf.[Factura]) as FacturasDespachadasMes
                        //and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."' AND DAY(rf.Fecha)='".$diax."')
                        if($company=="AG"){
                        $resultSQLItemsm2 = mssql_query("SELECT DAY(rv.HoraFinal) as Dia, count(rv.[Orden]) as PedidosEmpacadosMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where rv.Funcionario='".$funcionario."' AND (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') GROUP BY DAY(rv.HoraFinal) ORDER BY DAY(rv.HoraFinal) ASC",$cLink);
                        }
                        if($company=="X1"){
                        $resultSQLItemsm2 = mssql_query("SELECT DAY(rv.HoraFinal) as Dia, count(rv.[Orden]) as PedidosEmpacadosMes FROM [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasPestar].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden left join [sqlFacturasPestar].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where rv.Funcionario='".$funcionario."' AND (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02','04','ZB') GROUP BY DAY(rv.HoraFinal) ORDER BY DAY(rv.HoraFinal) ASC",$cLink);
                        }
                        if($company=="ZZ"){
                        $resultSQLItemsm2 = mssql_query("SELECT DAY(rv.HoraFinal) as Dia, count(rv.[Orden]) as PedidosEmpacadosMes FROM [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv left join [sqlFacturasComervet].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden left join [sqlFacturasComervet].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where rv.Funcionario='".$funcionario."' AND (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('01','02') GROUP BY DAY(rv.HoraFinal) ORDER BY DAY(rv.HoraFinal) ASC",$cLink);
                        }
                        //if($resultadoitems2 = mssql_fetch_array($resultSQLItemsm2)){
                        while($resultadoitems2 = mssql_fetch_array($resultSQLItemsm2)){
                            $d4=$resultadoitems2["PedidosEmpacadosMes"];
                            $diaf=$resultadoitems2["Dia"];
                            $df=(int)$diaf;
                            $dias[$df]=$d4;
                           
                        }
                        //pinto datos ene excel
                        $f1=1;
                        while($f1<=$number){
                           
                            $a++;
                    
                            if($a == 91){
                                $l="A";
                                $a=65;
                            }
                            if($cascii1 == "AZ"){
                                $l="A";
                                $a=65;
                            }
                            $cascii1=chr($a);
                            $cascii1=$l.$cascii1;
                            $c++;
                            
                            $f1++;
                        }
                        
                        
                   // }
                    $f++;
                                
             }
            */  
    
mssql_close();
echo $tabla;//$datos2diaus[1].",".$datos2diav1[1].",".$datos2diav2[1].",".$datosnohrd[1]." h=".$Hora;

?>