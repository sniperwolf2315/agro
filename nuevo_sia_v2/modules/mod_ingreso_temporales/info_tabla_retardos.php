    <?php
    // ini_set('max_execution_time', '500');
    set_time_limit(8000);
    include  '../../clases/PHPExcel/Classes/PHPExcel.php';
    include_once  '../../conection/conexion_sql.php' ;

    $con =new con_sql('sqlFacturas');
    $fecha_actual = date('d-m-Y H:i:s');

    $anio_consulta              = $_GET['anio'];
    $mes_consulta               = $_GET['mes'];
    $dia_consulta               = $_GET['dia'];
    $dias_consulta_diferencia   = $_GET['difdias'];
    $fh                         = str_replace('/','-',$_GET['fh']);

    $f_desde_r=$_GET['anio'].'-'.$_GET['mes'].'-'.$_GET['dia'];
    // $f_desde_r ="2023-08-01";
    ?>
<h2>Listado Ingresos</h2>	
<div class="panel panel-primary --bs-success-text">
    <div  class="row">
        <div  class="col-6" style="padding:1.5%">
            <label>Filtrar por fechas</label><br>
            <form action="#" method="POST">
                <label>Desde:</label>
                <input type="date" id="f_desde" name="f_desde" value="<?=$f_desde_r?>"    >
                <label>Hasta:</label>
                <input type="date" id="f_hasta" name="f_hasta" value="<?=$fh?>">
                <input type="hidden" id="area_con" name="area_con" value="<?=$area_url_cod?>" placeholder="<?=$area_url_cod?>">
                <input type="hidden" id="area_cod" name="area_cod" value="<?=$area_url_nom?>" placeholder="<?=$area_url_nom?>">
                <input type="button" id="consultar" name="consultar"  class="consultar btn btn-outline-success "  value="Consultar" onclick="consultar_query_retardos()" >
            </form>
            <button id="export_data" name="export_data" class="btn btn-success export_data" onclick="exporttablecsv('Informe_Retardos.csv')">Descargar CSV</button>
            <!-- <button id="ver_tabla"   name="ver_tabla"   class="btn btn-success export_data" onclick="ver_lista_retardos()">Ver</button> -->
        </div>
    </div>

<div class="panel-heading "><h3 class="panel-title">Resultados </h3></div>
    <div class="panel-body"  >
        <div class="col-lg-12">
            <div class="table-responsive" id="tbl_retardos_mes" name="tbl_retardos_mes"  style="height:400px">
                <?php
                    $consulta_pre = "EXEC sqlFacturas.dbo.SP_004_INFORME_RETARDOS '$anio_consulta','$mes_consulta','$dia_consulta',$dias_consulta_diferencia";
                    $con->consultar($consulta_pre);
                    // echo "$consulta_pre <br>";
                    echo '<button id="ver_tabla"   name="ver_tabla"   class="btn btn-success export_data" onclick="ver_lista_retardos()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                            </svg>
                          </button>';
                    // include('./info_tabla_retardos_2.php');
                ?>
            </div>
        </div>
    </div>
</div>
<script src='../../assets/js/funciones.js'></script>
<script src='../../assets/js/renderizado.js'></script>
