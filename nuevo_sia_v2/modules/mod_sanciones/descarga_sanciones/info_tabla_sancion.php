<?php
include  '../../../clases/PHPExcel/Classes/PHPExcel.php';
include  '../../../conection/conexion_sql.php' ;
include  '../funciones.php' ;

$con =new con_sql('sqlFacturas');
$fecha_actual = date('d-m-Y H:i:s');

$area_url_cod       = $_GET['area'];
$area_url_nom       = $_GET['area_cod'];


?>
<h2>Consulta Sanciones</h2>	
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
          <th scope="col">CONSECUTIVO               </th>
          <th scope="col">FECHA REGISTRO            </th>
          <th scope="col">FACTURA                   </th>
          <th scope="col">CODIGO SEGURIDAD          </th>
          <th scope="col">SANCION                   </th>
          <th scope="col">DESCRIPCION SEGRIDAD      </th>
          <th scope="col">CODIGO VENDEDOR           </th>
          <th scope="col">ACEPTA VENDEDOR           </th>
          <th scope="col">JUSTIFICACION VENDEDOR    </th>
          <th scope="col">FECHA JUSTIFICACION VENDEDOR    </th>
          <th scope="col">CODIGO ADMIN              </th>
          <th scope="col">ACEPTA ADMIN              </th>
          <th scope="col">JUSTIFICACION ADMIN       </th>
          <th scope="col">FECHA FIRMA ADMIN    </th>
          <th scope="col">SANCION ACTIVA            </th>
          <th scope="col">NUMERO NOTIFICADO         </th>
          <th scope="col">DATOS AUXILIAR            </th>
        </tr>
      
<?php

  $consulta = $_GET['v1'];
  
  $consulta_lista_visitantes=$con->consultar($consulta);
  $contador=1;
      while($data = mssql_fetch_array($consulta_lista_visitantes)){
         $acepta_vendedor = ($data[8]==0)?'NO':'SI';
         $acepta_admin    = ($data[10]==0)?'NO':'SI';


         $hora_novedad_fn = format_fecha_hora($data[1]);
         $hora_firma_vende= format_fecha_hora($data[14]);
         $hora_firma_admin= format_fecha_hora($data[15]);
        

          echo "<tr>";
          echo "<td>". $data[0]."</td>";
          echo "<td>". $hora_novedad_fn."</td>";
          echo "<td>". $data[2]."</td>";
          echo "<td>". $data[6]."</td>";
          echo "<td>". $data[7]."</td>";
          echo "<td>". $data[18]."</td>";
          echo "<td>". $data[4]."</td>";
          echo "<td>". $acepta_vendedor."</td>";
          echo "<td>". $data[16] ."</td>";
          echo "<td>". $hora_firma_vende."</td>";
          echo "<td>". $data[20] ."</td>";
          echo "<td>". $acepta_admin ."</td>";
          echo "<td>". $data[17]."</td>";
          echo "<td>". $hora_firma_admin."</td>";
          echo "<td>". $data[13]."</td>";
          echo "<td>". $data[19]."</td>";
          echo "<td>". $data[5]."</td>";
          echo "</tr>";
          $contador++;
      }
      echo "Total : ".($contador-1);
?>
</table>
</div>
</div>
</div>
</div>
<script src='../../assets/js/funciones.js'></script>

