<?php
$Factura=trim($_GET['fac']);
$Empresa=trim($_GET['emp']);
$Cajas=trim($_GET['caj']);
include('conectarbase.php');

    date_default_timezone_set('UTC');
    $fecha=date("F j, Y,");
    
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

//seleccionar base Agrocampo
if($Empresa == 'AG'){
    $Emp='';
    $NomEmp='AGROCAMPO';
    mssql_select_db('sqlFacturas',$cLink);
}else if($Empresa == 'ZZ'){
    $Emp='Comervet';
    $NomEmp='COMERVET';
    mssql_select_db('sqlFacturasComervet',$cLink);
}else if($Empresa == 'X1'){
    $Emp='Pestar';
    $NomEmp='PESTAR';
    mssql_select_db('sqlFacturasPestar',$cLink);
}
        $resultSQLE = mssql_query("Select unidades from [sqlFacturas$Emp].[dbo].[facRegistroEtiqueta] Where Factura='$Factura'",$cLink);
        //consulta la factura en etiqueta
        if (mssql_num_rows($resultSQLE)) {
            $sqlv2= "Update [sqlFacturas$Emp].[dbo].[facRegistroEtiqueta] SET unidades='$Cajas' where factura='$Factura'";
            mssql_query($sqlv2,$cLink);
            //            
        }
        
        
        $resultSQLV = mssql_query("select NumeroCajas from [sqlFacturas$Emp].[dbo].[facRegistroValidacion] where NumeroFactura='$Factura'",$cLink);
        //consulta la factura en validacion pedidos
        if (mssql_num_rows($resultSQLV)) {
            $sqlv3= "Update [sqlFacturas$Emp].[dbo].[facRegistroValidacion] SET NumeroCajas='$Cajas' where NumeroFactura='$Factura'";
            mssql_query($sqlv3,$cLink);
            //LOG
            //$EstaIBs = "Orden del Pedido fue ACTIVADA para ser Procesada por el Integrador de Ordenes de IBS";
            $ip=get_client_ip();
            $msgtxt="En la empresa ".$NomEmp.", con el numero de factura ".$Factura." fue CAMBIADA la cantidad de cajas por ".$Cajas.", por el Usuario: ".$_SESSION['usuARio']." desde la IP: ".$ip. ", en la fecha: ".$fecha;
            $archivo="informe.txt";
            $myfile = file_put_contents($archivo, $msgtxt.PHP_EOL , FILE_APPEND);              
        }
        
      
     mssql_close(); 
     echo "Cajas Cambiadas, verfique";
?>