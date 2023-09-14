
<script src="../../assets/js/funciones.js"></script>
<link href="../../assets/css/crud_temporales.css" rel="stylesheet" type="text/css">

<div class="container">

<?php
    include_once('../../conection/conexion_sql.php');
    $conn =new con_sql();

    $codigo_area = $_GET['area'];
    $usuario_log = $_GET['user_load'];

    if(!is_numeric($codigo_area)){
        echo "Codigo de area no tiene el formato valido valido";
        return;
    }

    $query ="select campo from API_CONFIGURACION where valor=$codigo_area";
    $nombre_area = mssql_fetch_array($conn->consultar($query));
    $nombre_area = $nombre_area[0];
    ?>

        <label for="num_doc">Crear ingreso tipo</label> <br>
        
        <select id="opt_ingr" name="opt_ingr" onchange="tipo_campo(this.value);" >
            <option value="AGROCAMPO">AGROCAMPO</option>
            <option value="EXTERNO">EXTERNO</option>
        </select><br>

        <input type="text" id="nom_act" name="nom_act" placeholder="Nombre visitante" ><br>
        <input type="number" id="doc_act" name="doc_act" placeholder="Num documento o nit" maxlength="10"><br>
        <span  id="sel_ect" name="sel_ect"></span><br>
    <?php
        $lista_area = ($conn->consultar("select CAMPO from API_CONFIGURACION where DESCRIPCION like'CODIGO%' order by CAMPO")); 

        echo "<select id='are_act' name='are_act' onchange='tipo_campo(this.value);'>";
        echo "<option value='' selected>SELECCIONAR UNA</option>";
        
        while( $lst_areas = mssql_fetch_array($lista_area)){
            echo "<option values='$lst_areas[0]'> $lst_areas[0] </option>";
        }
        echo "</select><br>";
     
     ?>   
        <input type="text" id="jef_act" name="jef_act" placeholder="Jefe Inmediato"><br>
        <input type="text" id="jor_act" name="jor_act" placeholder="Jornada"><br>
        <input type="text" id="acd_act" name="acd_act" placeholder="Actividad a desarrollar"><br>
        <select id="are_car" name="are_car" >
            <?php
            echo "<option value='$nombre_area' selected>$nombre_area</option>";
            ?>
        </select><br>
        <input type="text" id="user_carg" name="user_carg" placeholder="<?=$usuario_log?>" value="<?=$usuario_log?>" disabled><br>
        <input type="button" id="btn_act_datos" name="btn_act_datos" value="Crear" onclick="insert_datos()" >
    </table>
</form>
<span id="resultado" name="resultado"></span>
</div>

