<br>
<br>
<?php
    echo "Informe ordenes despachadas";
    
?>
<br>

<form id="frm_tipo_busqueda" name="frm_tipo_busqueda_1" class="frm_tipo_busqueda_1" method=="POST" action ="">
    <label>Seleccione el tipo de filtro:</label>
    <br>
    <select id="sl_tipo_filtro" name="sl_tipo_filtro" class="sl_tipo_filtro" onchange="tipo_filtro_despachadas(this.value);">
        <option value="" selected></option>
        <option value="embarque" >Embarque</option>
        <option value="fechas">Fechas</option>
    </select>
</form>
<br>

<div class="container">
    <form id="frm_ord_despachadas" name="frm_ord_despachadas" class="frm_ord_despachadas" method=="POST" action ="facturas_despachadas_descarga.php">
        <label id="lbl_fec_desde" for="fec_desde">Fecha desde:</label>
        <input type="date" id="fec_desde" name="fec_desde" class="fec_desde" value="<?=$fecha_defecto_d?>">
    <br>
        <label id="lbl_fec_desde" for="fec_hasta">Fecha hasta:</label>
        <input type="date" id="fec_hasta" name="fec_hasta" class="fec_hasta" value="<?=$fecha_defecto_h?>">
    <br>
        <label id="lbl_nume_embarque" for="num_embarque">Numero Embarque</label>
        <input type="text" id="num_embarque" name="num_embarque" class="num_embarque" placeholder="Numero de embarque">
        <br>
        <input type="button" id="btn_ord_desp" name="btn_ord_desp" class="btn_ord_desp" value="Consultar" onclick="consultar_despachadas();">
    </form>
</div>






<?php
$fecha_actual = date('Y-m-d');

$fecha_defecto_d =($_POST['fec_desde']=='')?$fecha_actual :$_POST['fec_desde'];
$fecha_defecto_h =($_POST['fec_hasta']=='')?$fecha_actual :$_POST['fec_hasta'];

?>


<hr>
<br>
<button id="export_data" name="export_data" class="export_data" onclick="exporttablecsv('tbl_informe_ord_desp')">Descargar Reporte</button>
<br>
<br>
<div id="resultado" class="resultado" name="resultado" ></div>




