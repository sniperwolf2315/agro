<?php
$Factura=trim($_GET['fac']);
$Empresa=trim($_GET['emp']);
include('conectarbase.php');
//seleccionar base Agrocampo
if($Empresa == 'AG'){
    $Emp='';
    mssql_select_db('sqlFacturas',$cLink);
}else if($Empresa == 'ZZ'){
    $Emp='Comervet';
    mssql_select_db('sqlFacturasComervet',$cLink);
}else if($Empresa == 'X1'){
    $Emp='Pestar';
    mssql_select_db('sqlFacturasPestar',$cLink);
}   
        $Existe=false;
        $Unidades=0;
        $Cajas=0;
        $resultSQLE = mssql_query("Select unidades from [sqlFacturas$Emp].[dbo].[facRegistroEtiqueta] Where Factura='$Factura'",$cLink);
        //consulta la factura en etiqueta
        if (mssql_num_rows($resultSQLE)) {
            $rowe = mssql_fetch_array($resultSQLE);
            $Unidades = $rowe['unidades'];  
            $Existe=true;              
        }
        
        
        $resultSQLV = mssql_query("select NumeroCajas from [sqlFacturas$Emp].[dbo].[facRegistroValidacion] where NumeroFactura='$Factura'",$cLink);
        //consulta la factura en validacion pedidos
        if (mssql_num_rows($resultSQLV)) {
            $rowv = mssql_fetch_array($resultSQLV);
            $Cajas = $rowv['NumeroCajas'];   
            $Existe=true;             
        }
        
      /*
      $sqlv2= "UPDATE [sqlFacturas$empresa].[dbo].[agrTarifa] SET IdTransportador='$idTransp', Unidad='$Valor', FechaModificacion='$FechaMod' WHERE IdDestino='$idDestino' AND (UsuarioModificacion='FACTURAS' OR UsuarioModificacion='0')";
      mssql_query($sqlv2,$cLink);
      */
     mssql_close(); 
     
        echo $Existe.'^'.$Cajas;
     
        //echo $Existe.'^'."FACTURA ".$Factura." NO ENCONTRADA EN LA COMPAÑIA SELECCIONADA!";
         
?>