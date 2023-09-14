<?php
    echo "Informe Diario Ingresos";
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
    require( '../../../conection/conexion_sql.php' );

    $sql_con = new con_sql('sqlFacturas');    

    $query_sql=("select 
	count(ar.CEDULA) as VISITAS,
	ar.EMPRESA,
	ar.CEDULA,
	UPPER(AR.NOMBRE) as NOMBRE,
	ar.PLACA,
	ar.ID_PEDIDOS_AGRO AS PEDIDO,
	ar.CANTIDAD_PED_AGRO AS CANTIDAD,
	ar.HORA_INGRESO
from
	API_ASIGNACION AR
	--API_REPARTIDORES ar
where 
	ESTADO in('ESPERA','INGRESO')
group by 
	ar.EMPRESA,
	ar.CEDULA,
	ar.PLACA,
	ar.ID_PEDIDOS_AGRO,
	ar.CANTIDAD_PED_AGRO,
	ar.HORA_INGRESO,
	AR.NOMBRE
UNION ALL
SELECT 
'' as VISITAS,
'APOYO AGROCAMPO' as EMPRESA,
Cedula,
UPPER(Nombre) NOMBRE,
'' AS PLACA,
'' AS PEDIDO,
'' AS CANTIDAD,
GETDATE() AS HORA_INGRESO
FROM AGENDA_VISITANTES");

    $data_informe = $sql_con->consultar($query_sql);

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



