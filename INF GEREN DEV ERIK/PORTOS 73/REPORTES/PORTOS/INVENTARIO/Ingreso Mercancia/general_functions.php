<?php


/* VARAIBLES GLOALES */




function copy_file($anio, $mes)
{
    $nombre_arch = 'INFORME_COMPRAS_VENTAS_MES';
    $ext_arch = 'pdf';
    $ruta = '/var/www/html/modulo_plan/informes/pdf/';
    $destino = '/var/www/html/modulo_odoo/Informes/pdf/';
    $archivos = glob($ruta . $nombre_arch . '.*');
    // $archivos= glob($ruta.$nombre_arch.'_'. $anio.'_'.$mes. '.*');
    // $archivos= glob($ruta.'.'.$nombre_arch.'_'.$anio.'_'.$mes.'.'. $ext_archa);
    foreach ($archivos as $archivo) {
        $archivo_copiar = str_replace($ruta, $destino, $archivo . '_' . $anio . '_' . $mes);
        $archivo_copiar = str_replace('.pdf', '', $archivo_copiar);
        copy($archivo, $archivo_copiar . '.' . $ext_arch);
    }
}
function fun_conectar_sqlserv($name_db)
{
    $server_name = '192.168.6.15';
    $user_name = 'sa';
    $user_pass = '%19Sis60Tem@s17';
    $cLink = mssql_connect($server_name, $user_name, $user_pass) or die(mssql_get_last_message());
    mssql_select_db($name_db, $cLink);
    if (!$cLink) {
        echo "sin conectar a l server";
    } else {
        echo 'Conectado';
    }
}


function id_periodo($view_option)
{

    $mes_actual = date("m");
    $sql_periodo = mssql_query("
            select 
                distinct top 10 codigo
                ,nombre
                ,fechaini
                ,fechafin
                ,substring(Codigo,5,2) mes 
            from 
                sqlFacturas.dbo.agrPeriodo 
            order by 
                codigo desc
                ");


    echo '
    <div class="tooltip">
        <span class="tooltip-content">!Ejecutar un periodo fijo!</span>
        Ejecutar por:
    </div>

    <select name="Por_Fechas" id="Por_Fechas" style="width:100%;" onchange="validar_rango(this.value);" >
        <option value="">Seleccione</option> ';

    if ($view_option === 0) {
        echo '<option value="Por_Fechas" >Por_Fechas</option>';
    }

    while ($period = mssql_fetch_array($sql_periodo)) {
        if ($period['mes'] === $mes_actual) {
            echo '<option value="' . $period['codigo'] . '"  >' . $period['nombre'] . '</option>';
        } else {
            echo '<option value="' . $period['codigo'] . '" >' . $period['nombre'] . '</option>';
        }
    }
    echo '
    </select>
    ';
}


function rangos_fechas($status)
{
    if ($status === 0) {
        echo '
				
                    <td id="td_desde" name="td_desde">
                        Desde:<br> <input id="desde" name="desde"  class="frm campo Aabs" value="' . obtener_fechas_desde(2) . '" type="date"><br>
                    </td>
                    <td id="td_hasta" name="td_hasta">
                        Hasta:<br> <input id="hasta" name="hasta" class="frm campo Aabs" value="' . obtener_fechas_desde(1) . '" type="date"><br>
                    </td>
			
				';
    } else {
        echo '
			
                    <td id="td_desde" name="td_desde">
                        Desde:<br> <input id="desde" name="desde"  class="frm campo Aabs" value="' . obtener_fechas_desde(2) . '" type="date"><br>
                    </td>    
                    <td id="td_hasta" name="td_hasta">
                        Hasta:<br> <input id="hasta" name="hasta" class="frm campo Aabs" value="' . obtener_fechas_desde(1) . '" type="date"><br>
                    </td>    
			
				';
    }
}

function obtener_fechas_desde($dato)
{
    $anio_actual     = date("Y");
    $mes_actual      = date("m");
    $hoy_ibs         = date("Ymd");
    $hoy             = date("Y-m-d");
    $hoy_2_sem       = date("Y-m-d", strtotime("$hoy + 2 week"));
    $hoy_menos_mes   = date("Y-m-d", strtotime("$hoy - 1 month"));
    $manana          = date("Y-m-d", strtotime("$hoy + 1 day"));

    if ($dato == 1) {
        $date = $hoy;
    } else if ($dato == 2) {
        $date = $hoy_menos_mes;
    } else {
        $date = $hoy;
    }

    return $date;
}

function anio_mes(){

    echo '
    <div id="anio_mes" name="anio_mes">
        <div class="input-field col s3" style="width:200px;">                                                                                                                                              
            <input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />   
            <label for="Anio"></label>                                                                                                                                                                         
        </div>                                                                                                                                                                                             
        <div class="input-field col s3" style="width:200px;">                                                                                                                                              
            <input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />                                             
            <label for="Mes"></label>                                                                                                                                                                          
        </div>                                                                                                                                                                                             
    </div>
    
    <br>

    
    ';



}