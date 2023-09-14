<?php
    echo "Informe Mensual Salidas";
    require( '../../../conection/conexion_sql.php' );
    ?>
<table class="tbl_informe_mes_com" name="tbl_informe_mes_com" id="tbl_informe_mes_com">
<tr>
<?php
    $cabecera =['VISITAS','EMPRESA','CEDULA','NOMBRE','PLACA','PEDIDO','CANTIDAD','FECHA'];
    foreach($cabecera as $val){
        echo "<th>$val</th> ";
    }
?>
</tr>
<?php

    $sql_con = new con_sql('SQLFACTURAS');    
    $query_sql=("select 
	count(CEDULA) as VISITAS,
	EMPRESA,
	CEDULA,
	NOMBRE_1+''+NOMBRE_2+''+APELLIDO_1+''+APELLIDO_2 as NOMBRE,
	PLACA,
	PEDIDO,
	CANTIDAD,
	HORA_INGRESO
from
	API_REPARTIDORES 
where 
	ESTADO in('SALIDA')
group by 
	EMPRESA,
	CEDULA,
	NOMBRE_1,
	NOMBRE_2,
	APELLIDO_1,
	APELLIDO_2,
	PLACA,
	PEDIDO,
	CANTIDAD,
	HORA_INGRESO
order by HORA_INGRESO DESC");
    $data_informe = $sql_con->consultar($query_sql);
    $libros = mssql_fetch_array($data_informe);
    while($d = mssql_fetch_array($data_informe)){
        echo "<tr>"; 
        echo "<td>".$d[VISITAS]."</td>" ;
        echo "<td>".$d[EMPRESA]."</td>" ;
        echo "<td>".$d[CEDULA]."</td>" ;
        echo "<td>".$d[NOMBRE]."</td>" ;
        echo "<td>".$d[PLACA]."</td>" ;
        echo "<td>".$d[PEDIDO]."</td>" ;
        echo "<td>".$d[CANTIDAD]."</td>" ;
        echo "<td>". date("Y-m-d",strtotime($d[HORA_INGRESO]))."</td>" ;
        echo "</tr>"; 
    }
    ?>
</table>
<br>
<!-- <button id="export_data" name="export_data" class="export_data" onclick="exportar_excel('tbl_informe_mes_com')">Descargar Reporte</button> -->



