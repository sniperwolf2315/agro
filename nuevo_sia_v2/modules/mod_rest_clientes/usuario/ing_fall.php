<!DOCTYPE html>
<html lang="en">
<head>
    <title>NUEVO SIA AGROCAMPO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!-- <meta http-equiv="refresh" content="10;url=#"> -->
    <!-- <meta http-equiv="refresh" content="10;url=ing_fall.php"> -->
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
$_SESSION["usr_act"] =$_GET['perf'] ;
$_SESSION['cantidad'];
$usr=$_SESSION["usr_act"];

echo $usr.''.$_SESSION["usr_act"];

$con_sql= new con_sql('sqlfacturas');
$lista_domi_new=[];

$data =  $con_sql->conectar( "
select 
    CEDULA,
    NOMBRE,
    FECHA_INGRESO,
    DEPENDENCIA 
from 
    API_INGRESOS_FALLIDOS
where 
    YEAR(FECHA_INGRESO)=YEAR(GETDATE())
    and MONTH(FECHA_INGRESO)=MONTH(GETDATE())
    and DAY(FECHA_INGRESO)=DAY(GETDATE())
    AND CEDULA NOT LIKE '%1018486920%'
    order by FECHA_INGRESO DESC
");


while ($a  = mssql_fetch_array($data)) {
    array_push($lista_domi_new,$a[CEDULA]);
}
echo"<a href="."usuario_admin.php?perf=sec"."> <h1 class="."sin_ped".">INGRESOS FALLIDOS ".count($lista_domi_new)." </a></h1> ";

if(count($lista_domi_new)==0){
    // echo"<h1 class="."sin_ped".">INGRESOS FALLIDOS</h1> ";
    return;
}

$cantidad_old=$_SESSION['cantidad'];

echo"
<table id="."tablero1"." name="."tablero1"." class="."tablero1"." >
    <tr class="."tit_tab"." name="."tit_tab"." id="."tit_tab".">
        <th>CEDULA</th>
        <th>NOMBRE</th>
        <th>FECHA ING</th>
        <th>DEPENDENCIA</th>
    </tr>
";

if($cantidad_old == count($lista_domi_new) ){
    $data =  $con_sql->conectar( "
    SELECT 
        CEDULA,
        NOMBRE,
        FECHA_INGRESO ,
        DEPENDENCIA
    from 
        API_INGRESOS_FALLIDOS
    where 
        YEAR(FECHA_INGRESO)=YEAR(GETDATE())
        and MONTH(FECHA_INGRESO)=MONTH(GETDATE())
        and DAY(FECHA_INGRESO)=DAY(GETDATE())
        AND CEDULA NOT LIKE '%1018486920%'
    order by 
        FECHA_INGRESO DESC
    ");

    while ($tablero  = mssql_fetch_array($data)) {
        echo "<tr>
                    <td>$tablero[0]</td>
                    <td>$tablero[1]</td>
                    <td>$tablero[2]</td>
                    <td>$tablero[3]</td>
              </tr>";
    }
}else{
    echo "
    <script>
        swal('HAY UN NUEVO REGISTRO DE ACCESO NO PERMITIDO');
    </script>
    <meta http-equiv="."refresh"." content="."1;url=ing_fall.php".">
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