
<script src="../../../nuevo_sia_v2/assets/js/funciones.js"></script>
<link href="../../nuevo_sia_v2/assets/css/crud_temporales.css" rel="stylesheet" type="text/css"> 

<div class="container">

<form id="up_datos" name="up_datos" action="#" method="POST"  autocomplete="off">
    <label for="num_fac" style="font-size:5vw;">Consultar por número de factura:</label> <br>
    <input type="text" id="num_fac"    name="num_fac" style="width:100%;font-size:5vh;height:80px;">
    <br>
    <br>
    <br>
    <input type="submit" id="btn_enviar" name="btn_enviar" value="Consultar" style="width:100%; height:60px;font-size:50px;">
</form>
    <?php
    include_once('../../nuevo_sia_v2/conection/conexion_sql.php');
    $conn =new con_sql();

    $factura = $_POST['num_fac'];

    if($factura==''){
        echo "Numero de factural vacío";
        return;
    }

        /*
        // $query ="select * from facRegistroEtiquetaTmp where factura=$factura";
        // $query ="select * from facRegistroEtiqueta where factura=$factura and (guia in('TER','') or Guia is null)" ;
        // $query ="select * from facRegistroEtiquetaTmp where Facturas='$factura' and (guia in('TER','') or Guia is null)" ;
        */
        $query ="select * from facRegistroEtiqueta where (Facturas='$factura' or Factura='$factura') and (guia in('TER','') or Guia is null)" ;


    $data = $conn->consultar($query);

    if (mssql_num_rows($data)<=0){
        echo 'Esta factura no cumple con las caracteristicas de guia = TER o vacias y valor 0 ';
        // echo('<meta http-equiv="refresh" content="0;url=facturas_terminal.php">');
    }
    
    
    echo '<form id="up_datos_fil" name="up_datos_fil" action="#" method="GET" > <table>';
    while($sql_filas = mssql_fetch_array($data) ){
        echo "<label for='num_fact'>Numero Factura:</label><br>" ;   
        echo '<input type="text" id="num_fact" name="num_fact"   value="'.$sql_filas[Factura].'" style="width:100%; height:60px;font-size:50px;" disabled><br>';
        echo "<label for='tipo_fac'>Tipo Factura:</label><br>" ;   
        echo '<input type="text" id="tipo_fac" name="tipo_fac"   value="'.$sql_filas[Tipo].'" style="width:100%; height:60px;font-size:50px;" disabled><br>';
        echo "<label for='num_guia'>Número Guia:</label><br>" ;   
        echo '<input type="text" id="num_guia" name="num_guia"   placeholder="'.$sql_filas[Guia].'" style="width:100%; height:60px;font-size:50px;"><br>';
        echo "<label for='val_guia'>Valor Guia:</label><br>" ;   
        echo '<input type="number" id="val_guia" name="val_guia" placeholder="'.$sql_filas[ValorGuia].'" style="width:100%; height:60px;font-size:50px;"><br>';
        echo '<input type="button" id="btn_act_datos" name="btn_act_datos" value="Actualizar" onclick="actualiza_datos_fac()" >';
    }
    ?>
    </table>
</form>
<span id="resultado" name="resultado"></span>
</div>

