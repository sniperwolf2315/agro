<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USUARIO CARGUE BAHIA</title>
    <link rel="stylesheet" href="../../../assets/css/mod_carga.css"> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="row">
        <div class="menu col-12 col-5 ">
<?php
        include_once( '../../../services/rest_pibox_service.php' );/* IMPORTAMOS LA CLASE DE API_REST */
        include( '../../../environments/production.php' );/* IMPORTAMOS LAS VARIABLES DE API_REST  */
        include( '../../../funciones.php' );
        require( '../../../conection/conexion_sql.php' );
        require( '../bodega/funciones_bod.php' );

/**#####################################################################################################################################**/
/**#####################################################################################################################################**/
/**#####################################################################################################################################**/

        echo 'El usuario de Carga<br>';
        $sql_con = new con_sql( 'sqlfacturas' );
        $bahia = 1;
        $btn_opciones = [ 'Guardar'=>'guardar()' ];
        echo '<table>
                    <tr>
                        <th><span>TURNO </span></th>
                        <th><span>PLACA </span></th>
                        <th><span>ESTADO ACTUAL </span></th>
                        <th><span>NUMERO PEDIDO </span></th>
                        <th><span>CANTIDAD PEDIDO </span></th>
                        <th><span>CAMBIAR ESTADO </span></th>
                    </tr>
        ';
        if ( $bahia == 1 ) {
            $estado="CARGA";
            echo 'Bahia <span id="bahia" name="bahia" class="bahia" >'.$bahia.'<span><br>';
            $consulta = ( "SELECT TURNO,PLACA,ESTADO,PEDIDO,CANTIDAD  FROM API_REPARTIDORES WHERE VENTANILLA=$bahia AND ESTADO in('SALIDA')  group by TURNO,PLACA,ESTADO,PEDIDO,CANTIDAD");
            $pedido_x_bahia =  $sql_con->consultar( $consulta );
            while( $data = mssql_fetch_array( $pedido_x_bahia ) ) {
                echo "
                <tr>
                        <td id="."TURNO".">$data[TURNO] </td>
                        <td id="."PLACA".">$data[PLACA] </td>
                        <td id="."ESTATUS".">$data[ESTADO] </td>
                        <td id="."PEDIDO".">$data[PEDIDO] </td>
                        <td id="."CANTIDAD_PED".">$data[CANTIDAD] </td>
                        <td id="."btn_ok"."><img src=".'../../../assets/images/guardar.png'." id="."btn_ok"." name="."btn_ok"." class="."btn_ok"."  ></td>
                </tr>
                ";
            }
        } else{
            echo 'soy otro carguero';
        }
        echo '</table>';
        ?>
        </div>
    </div>
</body>
<script src="../../../assets/js/mod_carga.js"> </script>
</html>