<?php
include  '../../clases/PHPExcel/Classes/PHPExcel.php';
include  '../../conection/conexion_sql.php' ;

$con =new con_sql('sqlFacturas');
$fecha_actual = date('d-m-Y H:i:s');

$area_url_cod       = $_GET['area'];
$area_url_nom       = $_GET['area_cod'];

echo "
$area_url_cod
$area_url_nom
";
retur;


?>
<h2>Listado Ingresos</h2>	
    <div class="panel panel-primary --bs-success-text">
    <div  class="row">
        <div  class="col-6" style="padding:1.5%">
            <label>Filtrar por fechas</label><br>
            <form action="#" method="POST">
                <label>Desde:</label>
                <input type="date" id="f_desde" name="f_desde">
                <label>Hasta</label>
                <input type="date" id="f_hasta" name="f_hasta">
                <input type="hidden" id="area_con" name="area_con" value="<?=$area_url_cod?>" placeholder="<?=$area_url_cod?>">
                <input type="hidden" id="area_cod" name="area_cod" value="<?=$area_url_nom?>" placeholder="<?=$area_url_nom?>">
                <input type="button" id="consultar" name="consultar"  class="consultar"  value="Consultar" onclick="consultar_query()" >
            </form>
            <button id="export_data" name="export_data" class="btn btn-success export_data" onclick="exportar_excel('tbl_ing_mes','Informe_colaboradores')">Descargar XLS</button>
            <button id="export_data" name="export_data" class="btn btn-success export_data" onclick="exporttablecsv('Informe_colaboradores.csv')">Descargar CSV</button>
        </div>
    </div>
    


<div class="panel-heading "><h3 class="panel-title">Resultados </h3></div>
    <div class="panel-body"  >
        <div class="col-lg-12">
    <div class="table-responsive" style="height:400px">
<table
    class="tbl_ing_mes table table-bordered table-striped " 
    style="font-size:11px; " 
    name="tbl_ing_mes" 
    id="tbl_ing_mes">
        <tr style="text-align:center;">
          <th scope="col">ID                </th>
          <th scope="col">NOMBRE            </th>
          <th scope="col">CEDULA            </th>
          <th scope="col">AREA/EMP          </th>
          <th scope="col">JEFE INMEDIATO    </th>
          <th scope="col">JORNADA PROGRAMADA</th>
          <th scope="col">HORA INGRESO      </th>
          <th scope="col">SALIDA ALMUERZO   </th>
          <th scope="col">INGRESO ALMUERZO  </th>
          <th scope="col">HORA SALIDA       </th>
          <th scope="col">ESTADO            </th>
          <th scope="col">ACTIVIDAD         </th>
        </tr>
      
<?php

  $consulta = $_GET['v1'];
  
  $consulta_lista_visitantes=$con->consultar($consulta);
  $contador=1;
      while($data = mssql_fetch_array($consulta_lista_visitantes)){
          echo "<tr>";
          echo "<td>". $contador."</td>";
          echo "<td>". $data[1]."</td>";
          echo "<td>". $data[2]."</td>";
          echo "<td>". $data[3]."</td>";
          echo "<td>". $data[4]."</td>";
          echo "<td>". $data[5]."</td>";
          echo "<td>". date("Y-m-d H:i:s",strtotime($data[6]))."</td>";
          echo "<td>". date("Y-m-d H:i:s",strtotime($data[7]))."</td>";
          echo "<td>". date("Y-m-d H:i:s",strtotime($data[8]))."</td>";
          echo "<td>". date("Y-m-d H:i:s",strtotime($data[9]))."</td>";
          echo "<td>". $data[10]."</td>";
          echo "<td>". $data[11]."</td>";
          echo "</tr>";
          $contador++;
      }
?>
</table>
</div>
</div>
</div>
</div>
<!-- <a href="mod_carga.php"><span class="btn btn-primary">⏪</span></a> -->
<script src='../../assets/js/funciones.js'></script>

