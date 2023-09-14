<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- STILOS -->
<link rel="stylesheet" type="text/css" href="./con_sancion.css" media="screen" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


<title>Consulta de sanciones</title>
</head>
<body>
    
<div class="container-fluid text-center">
    <img src="../../../assets/images/logo_agro.png" alt="logo agrocampo" id="log_agro" name="log_agro" class="log_agro">
    <?php
    session_start();
    /*LIBRERIAS */
        include('../../../conection/conexion_sql.php');
    /*LIBRERIAS */


    /*VARIABLES */
    $con = new con_sql();

    $fechaActualcom = date( 'Y-m-d h:i:s' );
    /*VARIABLES */

    echo "<h1>Consulta de sanciones </h1>";
    $usaurio_consulta =strtoupper($_SESSION['usuARioS']) ;
    echo "<h5> Hola $usaurio_consulta </h5>";

    ?>

<hr>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Factura</th>
      <th scope="col">Hora_novedad</th>
      <th scope="col">Novedad</th>
      <th scope="col">Desc novedad</th>
      <th scope="col">Vendedor aprueba?</th>
      <th scope="col">Justificacion vendedor</th>
      <th scope="col">Admin aprueba?</th>
      <th scope="col">Comentarios Admin</th>
      <th scope="col">Confirmar</th>
      <th scope="col">Estado</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $consulta_sanciones_vendedor = $con->consultar("select TOP 1 * from API_SANCIONES_AGRO where SAN_ACTIVA=1 ");


  

      while($datos = mssql_fetch_array($consulta_sanciones_vendedor)){
        $id_registro  = $datos[0];
        $num_factura  = $datos[3];


        $hora_novedad = idate("Y/m/d h:i:s", strtotime($datos[2]));
        $date = new DateTime($hora_novedad);
        $hora_novedad_fn = $date->format('Y-m-d H:i:s');


        $novedad      = $datos[7];
        $desc_novedad = $datos[18];
        $desc_aprobo  = $datos[16];


        $aprobo       = ($datos[8]==0)?'NO':'SI';
        $status       = ($datos[13]==0)?'Procesado':'Activa';

        echo "
        <tr>
        <td>$id_registro</td>
        <td>$num_factura</td>
        <td>$hora_novedad_fn</td>
        <td>$novedad</td>
        <td>$desc_novedad</td>
        <td>$aprobo</td>
        <td>$desc_aprobo</td>
        <td>
            <select id=\"valor_decision\" name=\"valor_decision\" class=\"form-select form-select-lg mb-3\">
                <option>SI</option>
                <option>NO</option>
            </select>
        </td>
        <td>
            <div class=\"form-group\">
              <textarea class=\"form-control\" id=\"comentario\" name=\"comentario\" rows=\"3\" required></textarea>
            </div>
        </td>
        <td>
        ";
        echo "<button type=\"button\" class=\"btn btn-outline-success\" onclick=\"actualiza_datos('$id_registro','$usaurio_consulta',' $fechaActualcom')\" >Confirmar</button>";
        
        echo "</td>";

        echo "
        <td>
            <label id=\"status_resul\">$status</label>
        </td>
        </tr>
        ";

    };    
    
    ?>
  </tbody>
</table>

</div>
</body>
<script src="con_sanciones.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</html>

