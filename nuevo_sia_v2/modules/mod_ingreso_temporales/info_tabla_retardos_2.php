<table
    class="tbl_ing_mes table table-bordered table-striped " 
    style="font-size:11px; " 
    name="tbl_ing_mes" 
    id="tbl_ing_mes">
        <tr style="text-align:center;">
          <th scope="col">#               </th>
          <th scope="col">DEPENDENCIA     </th>
          <th scope="col">CARGO           </th>
          <th scope="col">IDENTIFICACIÓN  </th>
          <th scope="col">NOMBRE          </th>
          <th scope="col">FECHA MARCACIÓN </th>
          <th scope="col">REGISTRO        </th>
          <th scope="col">TURNO           </th>
        </tr>
<?php
/*
http://192.168.1.115/nuevo_sia_v2/modules/mod_ingreso_temporales/info_tabla_retardos_2.php
*/
include_once  '../../conection/conexion_sql.php' ;
include_once('../../functions/general_functions.php');

$cons =new con_sql('sqlFacturas');
$fec_desde = $_GET['fd'];
$fec_hasta = $_GET['fh'];

// $consulta ="SELECT * from sqlfacturas.dbo.TBL_REGISTRO_MARCA where format(fecha,'yyyy-MM-dd') between '$fec_desde' and '$fec_hasta ' order by convert(varchar, fecha,111) desc" ;
$consulta =  "SELECT 
	trm.DEPENDENCIA,
	trm.CARGO,
	trm.IDENTIFICACION,
	trm.EMPLEADO,
	trm.FECHA,
	trm.DESCRIPCION,
	crst.nombre as TURNO
FROM 
	sqlfacturas.dbo.TBL_REGISTRO_MARCA  trm 
	join sqlcronoseg.dbo.crsTurno crst  on crst.IDTURNO = trm.idturno
WHERE 
    format(trm.fecha,'yyyy-MM-dd') between '$fec_desde' and '$fec_hasta ' 
ORDER BY 
    convert(varchar, trm.fecha,111) desc
";

// ECHO "$consulta";
$consulta_lista_retardos=$cons->consultar($consulta);
echo "Total de registros <br>".mssql_num_rows($consulta_lista_retardos).'<br>';

$contador=1;
  while($data = mssql_fetch_array($consulta_lista_retardos)){
      echo "<tr>";
      echo "<td>". $contador                                        ."</td>";
      echo "<td>". $data['DEPENDENCIA']                             ."</td>";
      echo "<td>". remove_characters(utf8_decode($data['CARGO']))   ."</td>";
      echo "<td>". $data['IDENTIFICACION']                          ."</td>";
      echo "<td>". remove_characters(utf8_decode($data['EMPLEADO']))."</td>";
      echo "<td>". date("Y/m/d h:i:s ", strtotime($data['FECHA']))  ."</td>";
      echo "<td>". $data['DESCRIPCION']                             ."</td>";
      echo "<td>". $data['TURNO']                                   ."</td>";
      echo "</tr>";
    //   echo "<br>";
      $contador++;
  }
?>
</table>