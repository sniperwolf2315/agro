
<script src="../../assets/js/funciones.js"></script>
<link href="../../assets/css/crud_temporales.css" rel="stylesheet" type="text/css">

<div class="container">

<form id="up_datos" name="up_datos" action="#" method="POST" >
    <label for="num_doc">Consultar por número de documento:</label> <br>
    <input type="number" id="num_doc"    name="num_doc" min=0><br>
    <input type="submit" id="btn_enviar" name="btn_enviar"value="Enviar">
</form>
    <?php
    include_once('../../conection/conexion_sql.php');
    $conn =new con_sql();

    $documento = $_POST['num_doc'];

    if(!is_numeric($documento)){
        echo "Numero de documento no tiene el formato valido valido";
        return;
    }

    $query ="select * from agenda_VISITANTES where cedula=$documento";
    $data = $conn->consultar($query);
    echo '<form id="up_datos_fil" name="up_datos_fil" action="#" method="GET" > <table>';
    while($sql_filas = mssql_fetch_array($data) ){

        $nombre_act     =$sql_filas[1] ;
        $documento_act  =$sql_filas[2] ;
        $area_act       =$sql_filas[3] ;
        $jefe_act       =$sql_filas[4] ;
        $jornada_act    =$sql_filas[5] ;
        $actividad_act  =$sql_filas[6] ;
        echo "<label id='id_act' name='id_act'>$sql_filas[0]</label><br>";
        echo "<label for=''>Nombre </label><br>";
        echo '<input type="text" id="nom_act" name="nom_act" placeholder="'.$sql_filas[1].'" value="'.$sql_filas[1].'"><br>';
        echo "<label for=''>Documento </label><br>";
        echo '<input type="text" id="doc_act" name="doc_act" placeholder="'.$sql_filas[2].'" value="'.$sql_filas[2].'"><br>';
        echo "<label for=''>Area ó Empresa </label><br>";
        echo '<input type="text" id="are_act" name="are_act" placeholder="'.$sql_filas[3].'" value="'.$sql_filas[3].'"><br>';
        echo "<label for=''>Jefe </label><br>";
        echo '<input type="text" id="jef_act" name="jef_act" placeholder="'.$sql_filas[4].'" value="'.$sql_filas[4].'"><br>';
        echo "<label for=''>Jornada </label><br>";
        echo '<input type="text" id="jor_act" name="jor_act" placeholder="'.$sql_filas[5].'" value="'.$sql_filas[5].'"><br>';
        echo "<label for=''>Actividad </label><br>";
        echo '<input type="text" id="acd_act" name="acd_act" placeholder="'.$sql_filas[6].'" value="'.$sql_filas[6].'"><br>';
        echo "<label for=''>Area </label><br>";
        echo "<label id='are_car' name='are_car'>$sql_filas[7]</label><br>";
        echo '<input type="button" id="btn_act_datos" name="btn_act_datos" value="Actualizar" onclick="actualiza_datos()" >';
        // echo .' '.$sql_filas[1].' '.$sql_filas[2].' '.$sql_filas[3].' '.$sql_filas[4].' '.$sql_filas[5].' '.$sql_filas[6] .'<br>';
    }
    ?>
    </table>
</form>
<span id="resultado" name="resultado"></span>
</div>

