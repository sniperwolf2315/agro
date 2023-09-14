<?php


/* VARAIBLES GLOALES */

fun_conectar_sqlserv('sqlFacturas');



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
function php_function_cerrar_con()
{
    mssql_close();
}
;
function fun_conectar_sqlserv($name_db)
{
    $server_name = '192.168.6.15';
    $user_name = 'sa';
    $user_pass = '%19Sis60Tem@s17';
    $cLink = mssql_connect($server_name, $user_name, $user_pass) or die(mssql_get_last_message());
    mssql_select_db($name_db, $cLink);
    if (!$cLink) {
        echo "sin conectar a l server";
    }
    else {
    // echo 'Conectado';
    }
}


function id_periodo($view_option)
{
    $mes_actual = date("m");
    $sql_periodo = mssql_query("
            select 
                distinct top 12 codigo
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
        <span class="tooltip-content">!En esta sección podrás consultar por rango de fechas o un periodo!</span>
        Consultar por:
    </div>

    <select name="Por_Fechas" id="Por_Fechas" style="width:100%;" onchange="validar_rango(this.value);" >
        <option value="">Seleccione</option> ';

    if ($view_option === 0) {
        echo '<option value="Por_Fechas" >Por_Fechas</option>';
    }

    while ($period = mssql_fetch_array($sql_periodo)) {
        if ($period['mes'] === $mes_actual) {
            echo '<option value="' . $period['codigo'] . '"  >' . $period['nombre'] . '</option>';
        }
        else {
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
    }
    else {
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
    $anio_actual = date("Y");
    $mes_actual = date("m");
    $hoy_ibs = date("Ymd");
    $hoy = date("Y-m-d");
    $hoy_2_sem = date("Y-m-d", strtotime("$hoy + 2 week"));
    $hoy_menos_mes = date("Y-m-d", strtotime("$hoy - 1 month"));
    $manana = date("Y-m-d", strtotime("$hoy + 1 day"));

    if ($dato == 1) {
        $date = $hoy;
    }
    else if ($dato == 2) {
        $date = $hoy_menos_mes;
    }
    else {
        $date = $hoy;
    }

    return $date;
}

function anio_mes()
{

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


function php_function_get_url()
{
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $link;
}
;

function php_function_boton_login()
{

    echo '
       
    <br>
    <h4>
    <a href="user_conect_odoo.php" >
        <div class="login" id="login" name="login"
        style="
        width: 25%;
        height: 10%;
        background-color: c0c0c0 ;
        border-radius: 20px;
        text-align:center;
        justify-content:center;
        object-fit: cover;
        color:white;
        cursor:pointer;
        padding-top:5%;
        "
        >
             <label style="color:black">Click aca para iniciar sesion.</label>
        </div>
    </a>
    </h4>


';
}
;




function generar_calendario($month, $year, $lang, $holidays = null)
{

    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

    if ($lang == 'en') {
        $headings = array('M', 'T', 'W', 'T', 'F', 'S', 'S');
    }
    if ($lang == 'es') {
        $headings = array('L', 'M', 'M', 'J', 'V', 'S', 'D');
    }
    if ($lang == 'ca') {
        $headings = array('DI', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds', 'Dg');
    }

    $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

    $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
    $running_day = ($running_day > 0) ? $running_day - 1 : $running_day;
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();

    $calendar .= '<tr class="calendar-row">';

    for ($x = 0; $x < $running_day; $x++):
        $calendar .= '<td class="calendar-day-np"> </td>';
        $days_in_this_week++;
    endfor;

    for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
        $calendar .= '<td class="calendar-day">';

        $class = "day-number ";
        if ($running_day == 0 || $running_day == 6) {
            $class .= " not-work ";
        }

        $key_month_day = "month_{$month}_day_{$list_day}";

        if ($holidays != null && is_array($holidays)) {
            $month_key = array_search($key_month_day, $holidays);

            if (is_numeric($month_key)) {
                $class .= " not-work-holiday ";
            }
        }

        $calendar .= "<div class='{$class}'>" . $list_day . "</div>";

        $calendar .= '</td>';
        if ($running_day == 6):
            $calendar .= '</tr>';
            if (($day_counter + 1) != $days_in_month):
                $calendar .= '<tr class="calendar-row">';
            endif;
            $running_day = -1;
            $days_in_this_week = 0;
        endif;
        $days_in_this_week++;
        $running_day++;
        $day_counter++;
    endfor;

    if ($days_in_this_week < 8):
        for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar .= '<td class="calendar-day-np"> </td>';
        endfor;
    endif;

    $calendar .= '</tr>';

    $calendar .= '</table>';

    return $calendar;
}
function ultimo_dia($date){
    // $date = "2022-07-01";
    return date("Y-m-t", strtotime($date));
}
?>