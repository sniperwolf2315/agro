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
      
        $UFac=new ArrayIterator();
        $CFac=new ArrayIterator();
        //agrupamiento por funcionario
            if($company=="AG"){
              
               $i=0;
               $resultSQLItemsm = mssql_query("SELECT DISTINCT rv.Funcionario as Funcionario, count(rv.[Orden]) as PedidosEmpacadosMes, count(rf.[Factura]) as FacturasDespachadasMes FROM [sqlFacturas].[dbo].[facRegistroValidacion] as rv left join [sqlFacturas].[dbo].[facRegistroFactura] as rf ON rv.NumeroFactura=rf.Factura and rv.Orden=rf.Orden and (YEAR(rf.Fecha)='".$anio."' AND MONTH(rf.Fecha)='".$mes."') left join [sqlFacturas].[dbo].[facRegistroValidacion] as rv2 ON rf.Factura=rv2.NumeroFactura and rf.Orden=rv2.Orden and rv.IdRegistroValidacion=rv2.IdRegistroValidacion where (YEAR(rv.HoraFinal)='".$anio."' AND MONTH(rv.HoraFinal)='".$mes."') AND rv.TipoFactura IN ('07','S2','FD','F1','D4') group by rv.Funcionario",$cLink);
               while($resultadoitems = mssql_fetch_array($resultSQLItemsm)){
                                
                                
                                $UFac[$i]=utf8_encode($resultadoitems["Funcionario"]);
                       
                                $CFac[$i]=$resultadoitems["FacturasDespachadasMes"];
                                
                                $i++;    
                         
               }
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
            $i=0;
            $Usuarios=new ArrayIterator();
          
                    //pedidos facturados
                    $tabla="<table name='v' style='width: 200px; background-color: azure; border: 1px solid rgb(220,220,220);'>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td colspan=2  style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Pedidos Facturados y Cargados mes $mes</td>";
                    $tabla=$tabla . "</tr>";
                    $tabla=$tabla . "<tr>";
                    $tabla=$tabla . "<td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Usuario</td><td style='font-size: 0.8em; font-weight: bold; background-color: azure; border: 1px solid rgb(220,220,220);height: 20px;padding: 0px;'>Cant Facturas</td>";
                    $tabla=$tabla . "</tr>";
                    $i=0;
                    $cantF=count($UFac);
                    while($i<$cantF){
                                
                        $tabla=$tabla . "<tr>";
                            $tabla=$tabla . "<td style='width: 200px; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$UFac[$i]."</td><td style='width: 200px; font-size: 0.5em; background-color: azure; border: 1px solid rgb(220,220,220);height: 10px;padding: 0px;'>".$CFac[$i]."</td>";
                        $tabla=$tabla . "</tr>";
                        $i++;    
                         
                     }
                    $tabla=$tabla . "</table>";
          
                
           
    
mssql_close();
echo $tabla;

?>