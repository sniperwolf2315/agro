
<div class="div_tbl_ord_desp">
<table class="tbl_informe_ord_desp" name="tbl_informe_ord_desp" id="tbl_informe_ord_desp">
<tr id="cabecera">
<?php
   $cabecera = ['Consecutivo Carga','Fecha Quemado','Cedula Cliente','Nombre Cliente','Numero Factura','Valor Factura','Problema','Numero Orden','Numero Embarque','Ruta','Conductor','Numero Placa','ID Destino',' Destino','Dirección Destino','Fecha Programada','Fecha Ingreso'];
    foreach($cabecera as $val){
        echo "<td>$val</td> ";
    }
?>
</tr>
<?php
    include_once( '../../../conection/conexion_sql.php' );
    include_once ('../../../../general_funciones.php');

    $consulta = ($_POST['consul_des']!='')?$_POST['consul_des']:$_GET['consul_des'];

    // echo "$consulta";
    $sql_con = new con_sql('SQLFACTURAS');    
    $data_informe = $sql_con->consultar($consulta);
    while($fac_despachadas = mssql_fetch_array($data_informe)){
        
        echo "<tr>"; 
        echo "<td>".$fac_despachadas[ConsecutivoCarga]."</td>" ;
        echo "<td>".date("Y-m-d",strtotime($fac_despachadas[FechaQuemado]))."</td>" ;
        echo "<td>".$fac_despachadas[CedulaCliente]."</td>" ;
        echo "<td>".remove_characters($fac_despachadas[NombreCliente])."</td>" ;
        echo "<td>".$fac_despachadas[NumeroFactura]."</td>" ;
        echo "<td>".$fac_despachadas[Valor]."</td>" ;
        echo "<td>".remove_characters($fac_despachadas[Problema])."</td>" ;
        echo "<td>".$fac_despachadas[NumeroOrden]."</td>" ;
        echo "<td>".$fac_despachadas[Embarque]."</td>" ;
        echo "<td>".$fac_despachadas[Ruta]."</td>" ;
        echo "<td>".$fac_despachadas[Conductor]."</td>" ;
        echo "<td>".$fac_despachadas[NumeroPlaca]."</td>" ;
        echo "<td>".$fac_despachadas[IdDestino]."</td>" ;
        echo "<td>".$fac_despachadas[Destino]."</td>" ;
        echo "<td>".remove_characters(str_replace (',','',$fac_despachadas[Direccion]))."</td>" ;
        echo "<td>".date("Y-m-d",strtotime($fac_despachadas[FechaProgramada]))."</td>" ;
        echo "<td>".date("Y-m-d",strtotime($fac_despachadas[FechaIngreso]))."</td>" ;
        echo "</tr>"; 
    }
    ?>
</table>
</div>

<span id="leyenda_fechas" name="leyenda_fechas" class="leyenda_fechas">
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-2-exclamation" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 9h8"></path>
   <path d="M8 13h6"></path>
   <path d="M15 18l-3 3l-3 -3h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5"></path>
   <path d="M19 16v3"></path>
   <path d="M19 22v.01"></path>
</svg>
¡Las fechas con valor "31/12/1969" son valores por defecto y que el sistema no tiene almacenados!
</span>