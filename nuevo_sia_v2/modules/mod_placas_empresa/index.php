<!DOCTYPE html>
<html lang="en">
<head>
    <title>NUEVO SIA AGROCAMPO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!-- <meta http-equiv="refresh" content="10;url=index.php"> -->
    <link rel = 'stylesheet' href = '../../assets/css/mod_placas.css' />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<div class="container">
<form name="frm_placa" id="frm_placa" class="frm_placa" action="#" method="POST">
    <input type="text" placeholder="BUSCAR PLACA" id="placab" name="placab" required>
    <br>
    <input type="submit" placeholder="BUSCAR PLACA" VALUE="BUSCAR">
</form>
<?php

  /*SI SE HA ENVIADO EL FORMILARIO PROCEDELLOS A REALIZAR EL LLAMADO */
  require( '../../conection/conexion_sql.php' );/* IMPORTAR CONEXIONN DE SQL */
  $con_sql= new con_sql('sqlfacturas');

    echo '
    <br>
    <br>
    <br>
    <br>
    ';
    echo '<div class="tbl_placas" id="tbl_placas"> ';
    echo"
    <table id="."tablero1"." name="."tablero1"." class="."tablero1"." >
    <tr class="."tit_tab"." name="."tit_tab"." id="."tit_tab".">
        <th>ID </th>
        <th>CEDULA </th>
        <th>NOMBRE_DOMICILIARIO </th>
        <th>NUMERO_PLACA </th>
        <th>EMPRESA_PERTENECE </th>
        <th>ACTIVO </th>
    </tr>
       
    ";


    $buscar_placa=$_POST['placab']; 
    $lista_domi_new=[];

    
    if( $buscar_placa==='TODO'){
        $data =  $con_sql->conectar( "SELECT * FROM PLACAS_DOMICILIOS_AGRO order by cedula,id");
    }else{
        $data =  $con_sql->conectar( "SELECT * FROM PLACAS_DOMICILIOS_AGRO where NUMERO_PLACA='$buscar_placa' order by cedula,id");
    }
    
    
    while ($a  = mssql_fetch_array($data)) {
        array_push($lista_domi_new,$a[CEDULA]);
    }



    if(count($lista_domi_new)==0){
        $placa=$_POST['placab']; 

        echo "<tr>
                <td>
                    $id
                </td>
                <td>
                    <input type='number' minlength='5' min ='0' placeholder='$cedula' value='$cedula' id='cedula'  >
                </td>
                <td>                    
                    <input type='text'   placeholder='$nombre' value='$nombre' id='nombre' >
                </td>
                <td>
                    <input type='text'   placeholder='$placa' value='$placa' id='placa' >
                </td>
                <td>
                    <input type='text'   placeholder='$empresa'  value='$empresa' id='empresa'  >
                </td>
                <td>
                    <input type='text'   placeholder='$activo'  value='$activo' id='activo'  >
                </td>
            ";


            if( $buscar_placa!=='TODO'){
                echo "
                <td>
                <button onclick=\"inserta_datos('$id','$cedula','$nombre','$placa','$empresa','$activo');\">
                <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-upload\" width=\"24\" height=\"24\" viewBox\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
                <path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"></path>
                <path d=\"M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2\"></path>
                <path d=\"M7 9l5 -5l5 5\"></path>
                <path d=\"M12 4l0 12\"></path>
                </svg> 
                Registrar
                </button>
                </td>
                ";
            }

        echo "</tr>";
       
        
        // echo"<h1 class="."sin_ped".">NO HAY PLACAS CON CAMPOS PENDIENTES EN COLA</h1> ";
        // return;

    }else{


    $cantidad_old=$_SESSION['cantidad'];


// if($cantidad_old == count($lista_domi_new) ){
    if( $buscar_placa==='TODO'){
        $data =  $con_sql->conectar( "SELECT * FROM PLACAS_DOMICILIOS_AGRO order by cedula,id");
    }else{
        $data =  $con_sql->conectar( "SELECT * FROM PLACAS_DOMICILIOS_AGRO  WHERE NUMERO_PLACA='$buscar_placa'order by cedula");
    }


    while ($tablero  = mssql_fetch_array($data)) {
        $id      = !empty($tablero[0])?$tablero[0]:'SIN_DATO';
        $cedula  = !empty($tablero[1])?$tablero[1]:'0000000000';
        $nombre  = !empty($tablero[2])?$tablero[2]:'SIN_DATO';
        $placa   = !empty($tablero[3])?$tablero[3]:'SIN_DATO';
        $empresa = !empty($tablero[4])?$tablero[4]:'SIN_DATO';
        $activo  = !empty($tablero[5])?$tablero[5]:'0';
        echo "
        
         <tr>
                    <td>$id
                    </td>
                    <td>
                    <input type='number' minlength='5' min ='0' placeholder='$cedula' value='$cedula' id='cedula' >
                    </td>
                    <td>                    
                    <input type='text'   placeholder='$nombre' value='$nombre' id='nombre'>
                    </td>
                    <td>
                    <input type='text'   placeholder='$placa' value='$placa' id='placa' >
                    </td>
                    <td>
                    <input type='text'   placeholder='$empresa'  value='$empresa' id='empresa' >
                    </td>
                    <td>
                    <input type='text'   placeholder='$activo'  value='$activo' id='activo' readonly >
                    </td>
            ";


            if( $buscar_placa!=='TODO'){
                echo "
                <td>
                <button onclick=\"actualiza_datos('$id','$cedula','$nombre','$placa','$empresa','$activo');\">
                <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-tabler icon-tabler-upload\" width=\"24\" height=\"24\" viewBox\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
                <path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"></path>
                <path d=\"M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2\"></path>
                <path d=\"M7 9l5 -5l5 5\"></path>
                <path d=\"M12 4l0 12\"></path>
                </svg> 
                Actualizar
                </button>
                </td>
                ";
            }

            echo "</tr>";
    
    }
}

echo"
</table>
<label id='resultado'></label>
</div>
";

// unset($_POST['placab']);
?>

</div> 
<script src="../../assets/js/funciones_placas.js" ></script>
</body>
</html>