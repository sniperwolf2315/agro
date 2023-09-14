<!DOCTYPE html>
<html lang="en">
<head>
    <title>NUEVO SIA AGROCAMPO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta http-equiv="refresh" content="10;url=modulo_bodega.php">
    <link rel = 'stylesheet' href = '../../../assets/css/tablero_turno.css' />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<div class="container">
<?php
require( '../../../environments/production.php' );/* IMPORTAMOS LAS VARIABLES DE API_REST  */
require( '../../../services/rest_pibox_service.php' );/* IMPORTAMOS LA CLASE DE API_REST */
require( '../../../conection/conexion_sql.php' );/* IMPORTAR CONEXIONN DE SQL */

session_start();

$_SESSION['cantidad'];
$con_sql= new con_sql('sqlfacturas');
$lista_domi_new=[];
$data =  $con_sql->conectar( " SELECT placa,turno,ventanilla FROM API_REPARTIDORES where ESTADO ='ESPERA'");

while ($a  = mssql_fetch_array($data)) {
    array_push($lista_domi_new,$a[CEDULA]);
}

if(count($lista_domi_new)==0){
    echo"<h1 class="."sin_ped".">NO HAY REPARTIDORES EN COLA</h1> ";
    return;
}

$cantidad_old=$_SESSION['cantidad'];

echo"
<table id="."tablero1"." name="."tablero1"." class="."tablero1"." >
    <tr class="."tit_tab"." name="."tit_tab"." id="."tit_tab".">
        <th>PLACA</th>
        <th>TURNO</th>
        <th>VENTANILLA</th>
        <th>ESTADO</th>
        <th>EMPRESA</th>
        <th>PEDIDO</th>
    </tr>
";

if($cantidad_old == count($lista_domi_new) ){
    $data =  $con_sql->conectar( " SELECT top 20 PLACA,TURNO,VENTANILLA,ESTADO,EMPRESA,PEDIDO FROM API_REPARTIDORES where ESTADO ='ESPERA' order by TURNO,HORA_INGRESO");
    // $data =  $con_sql->conectar( " SELECT  PLACA,TURNO,VENTANILLA,ESTADO,EMPRESA,PEDIDO FROM API_REPARTIDORES ");
    while ($tablero  = mssql_fetch_array($data)) {
        echo "<tr>
                    <td>$tablero[0]</td>
                    <td>$tablero[1]</td>
                    <td>$tablero[2]</td>
                    <td>$tablero[3]</td>
                    <td>$tablero[4]</td>
                    <td>$tablero[5]</td>
              </tr>";
    }
}else{
    echo "
    <script>
        swal('HAY ROTACIÓN');
    </script>
    <meta http-equiv="."refresh"." content="."1;url=modulo_bodega.php".">
    ";
    $_SESSION['cantidad']= count($lista_domi_new);
}
echo"
</table>
";
?>

</div>
</body>
</html>