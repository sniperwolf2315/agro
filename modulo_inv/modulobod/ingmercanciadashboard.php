<?php
$anio=trim($_GET['a']);
$mes=trim($_GET['m']);
//$dia=trim($_GET['d']);
$tipo=trim($_GET['tipo']);
$company=trim($_GET['comp']);
$transp=trim($_GET['tran']);


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
    
/*    
$fecha=date("d_m_Y");
   
$Odenes=new ArrayIterator();
$m=intval($mes);
           
$totalreg=$totalreg+1;
$PedSale=new ArrayIterator();
$CPSalen=new ArrayIterator();

$hoy=date("d");
$mes=date("m");
$anio=date("Y");
if(strlen($hoy)==1){
    $hoy="0".$hoy;
}
if(strlen($mes)==1){
    $mes="0".$mes;
}

*/
        //agrupamiento por funcionario
            if($company=="AG"){
                //rf.Factura,rf.Fecha
               //$resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') group by rv.Funcionario",$cLink);
               $resultSQLItemsm = mssql_query("SELECT Consecutivo,Bodega,Fecha,CodItem,Descripcion,Estiba,CantidadRegistrada,CantidadFacturada,CantidadBonificada,FechaVencimiento,Lote,Proveedor,Procesado,Devolucion FROM [sqlRecepcion008].[dbo].[rcpRegistro]  where (YEAR(Fecha)='".$anio."' AND MONTH(Fecha)='".$mes."')",$cLink);
               //$i=0;
               /*while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                                $d1=utf8_encode($resultadoitems["Consecutivo"]);
                                $PedSale[$i]=utf8_encode($resultadoitems["Consecutivo"]);
                                                                                
                                $i++;    
                         
               }*/
               
            }
            
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
            //$i=0;
            $Usuarios=new ArrayIterator();
            /*$tabla="<hr><table style='width: 700px; border: 2px solid rgb(220,220,20); padding:5px;'>";
            $tabla=$tabla . "<tr>";
            $tabla=$tabla . "<td>";
            */
                    //pedidos validados
                    $tabla="<table name='v' style='width: 98%; background-color: azure; border: 1px solid rgb(220,220,220);'>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td colspan=9  style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Ingreso Mercancia</td>";
                    $tabla=$tabla . "</tr>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>CONSECUTIVO</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>BODEGA</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>FECHA</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>CODIGO</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>DESCRIPCION</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>GRUPO</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>RECIBIDOS</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>FACTURADOS</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>BONIFICADOS</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>VENCIMIENTO</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>LOTE</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>PROVEEDOR</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>PROCESADO</td>
                    <td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>DEVOLUCION</td>";
                    
                    
                    $tabla=$tabla . "</tr>";
                    //$i=0;
                    //$cantP=count($PedSale);
                    //while($i<$cantP){
                        //$c=mssql_num_rows($resultSQLItemsm);
                        //if($c > 0){
                            while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                                $d1=$resultadoitems["Consecutivo"];
                                $d2=$resultadoitems["Bodega"];
                                $d3=$resultadoitems["Fecha"];
                                $d4=$resultadoitems["CodItem"];
                                $d5=$resultadoitems["Descripcion"];
                                $d6=$resultadoitems["Estiba"];
                                $d7=$resultadoitems["CantidadRegistrada"];
                                $d8=$resultadoitems["CantidadFacturada"];
                                $d9=$resultadoitems["CantidadBonificada"];
                                $d10=$resultadoitems["FechaVencimiento"];
                                $d11=$resultadoitems["Lote"];
                                $d12=$resultadoitems["Proveedor"];
                                $d13=$resultadoitems["Procesado"];
                                $d14=$resultadoitems["Devolucion"];
                                    //pinta datos
                                    $tabla=$tabla . "<tr>";
                                        $tabla=$tabla . "<td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d1."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d2."</td>
                                        <td style='width: 4%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d3."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d4."</td>
                                        <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d5."</td>
                                        <td style='width: 4%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d6."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d7."</td>
                                        <td style='width: 19%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d8."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d9."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d10."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d11."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d12."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d13."</td>
                                        <td style='width: 10%; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$d14."</td>";
                                    $tabla=$tabla . "</tr>";
                  
                            //}    
                        //}
                                
                        //$i++;    
                         
                     }
                    $tabla=$tabla . "</table>";

mssql_close();
echo $tabla;

?>