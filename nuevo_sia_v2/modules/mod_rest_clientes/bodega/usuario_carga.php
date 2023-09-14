<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10;url=usuario_carga.php".">
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
        require( 'funciones_bod.php' );

/**#####################################################################################################################################**/
/**#####################################################################################################################################**/
/**#####################################################################################################################################**/

        echo 'El usuario de Carga<br>';
        $sql_con = new con_sql( 'sqlfacturas' );
        $bahia = 1;
        $btn_opciones = [ 'Guardar'=>'guardar()' ];

        $cedula_para_totam =  ($sql_con->consultar( "SELECT DISTINCT CEDULA, nombre,empresa FROm API_ASIGNACION" ));
        











        echo '<table>
                    <tr>
                        <th><span>VENTANILLA </span></th>
                        <th><span>TURNO </span></th>
                        <th><span>EMPRESA </span></th>
                        <th><span>PLACA </span></th>
                        <th><span>NOMBRE </span></th>
                        <th><span>ESTADO ACTUAL </span></th>
                        <th><span>NUEVO ESTADO </span></th>
                        <th><span>NUMERO PEDIDO </span></th>
                    </tr>
        ';
        if ( $bahia == 1 ) {
            $estado="CARGA";
            echo 'Bahia <span id="bahia" name="bahia" class="bahia" >'.$bahia.'<span><br>';
            $consulta = ( "SELECT
            VENTANILLA,TURNO,EMPRESA,PLACA,(APELLIDO_1+' '+NOMBRE_1) NOMBRE ,ESTADO,PEDIDO,ISNULL(CANTIDAD,0) CANTIDAD
            FROM API_REPARTIDORES 
            WHERE ESTADO in('CARGA','ESPERA')  
            group by TURNO,PLACA,ESTADO,PEDIDO,CANTIDAD,VENTANILLA,EMPRESA,APELLIDO_1,NOMBRE_1,HORA_INGRESO
            order by HORA_INGRESO,TURNO");
            $pedido_x_bahia =  $sql_con->consultar( $consulta );
            while( $data = mssql_fetch_array( $pedido_x_bahia ) ) {
                $contador =1;
                $pedido = explode(',',$data[PEDIDO]);     

                echo "
                <tr>
                    <td id="."VENTANILLA".">$data[VENTANILLA] </td>
                    <td id="."TURNO".">$data[TURNO] </td>
                            <td id="."EMPRESA".">$data[EMPRESA] </td>
                            <td id="."PLACA".">$data[PLACA] </td>
                            <td id="."NOMBRE".">$data[NOMBRE] </td>
                            <td id="."ESTATUS".">$data[ESTADO] </td>
                            <td >".estados($data[VENTANILLA],$data[TURNO],trim($data[PLACA]),$data[ESTADO])."</td>
                            <td id="."PEDIDO"." style="."text-align:right; font-size:15px; ".">";
                            foreach ($pedido as $key => $value) {
                                if($value!=''){
                                    echo " <strong>$contador</strong> - $value <input type='radio'>  <br>";
                                    $contador++;
                                }
                                    }
                            echo "</td>
                </tr>
                ";
            }
        } else{
            echo 'soy otro carguero';
        }
        echo '</table><hr>';

        if(mssql_num_rows($cedula_para_totam)>1){
            echo"
            <div class='tabla_cedulas'>
            <h3>
            Cédulas permitidas a pasar al totem:<br><br>
            <strong>
            <table>
            
            ";
            
            while($ced =  mssql_fetch_array($cedula_para_totam)){
                echo "<tr>";
                echo "  
                <td>".trim($ced[0])."</td>
                <td>".trim($ced[1])."</td>
                <td>".trim($ced[2])."</td>
                ";
                echo "</tr>";
            }
            echo "
            </table>
            </strong>
            </h3>
            </div>    
            ";
        }else{
            echo "Recargando totem - función no lo encuentro - !no hay agenda por ahora¡";
        }

       
        ?>
        </div>
    </div>
</body>
<script src="../../../assets/js/mod_carga.js"> </script>
</html>