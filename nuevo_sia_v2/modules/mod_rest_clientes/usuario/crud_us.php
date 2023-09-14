<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="container-fluid">


<div class="text-center">
<h3>Actualización de datos conductor</h3>

</div>
<br>

<?php
    require('../../../conection/conexion_sql.php');
    // echo "si funciono la bahia $bahia";
    
    $id     ='';
    $cedula ='';
    $placa  ='';
    $empresa='';
    $con_sql            =new con_sql('SQLFACTURAS');
    $conta = 0;
    // $consulta_sin_placa =("select * from API_REPARTIDORES where estado in ('ESPERA','CARGA') and placa='SIN PLA' ");
    $consulta_sin_placa =("select * from API_REPARTIDORES where estado in ('ESPERA','CARGA') and placa='SIN PLA' 
    or (LEN(placa)>6 and estado in ('ESPERA','CARGA') )");
    $sin_placas         = $con_sql->consultar($consulta_sin_placa);
    echo ($sin_placas)?'':"<br> <br> <br> NO TENEMOS NADA PARA ACTUALIZAR <br>";

    echo '<div id="act_datos" name="act_datos" class="act_datos">';
    echo "<form action='#' method='POST' id='frm_act_datos' name='frm_act_datos' class='frm_act_datos'>
            <table>
              
    ";

        while($sin_pl = mssql_fetch_array($sin_placas) ){
             $id      = $sin_pl['ID']     ;
             $cedula  = $sin_pl['CEDULA'] ;
             $nombre  = $sin_pl['NOMBRE_1'] ;
             $placa   = $sin_pl['PLACA']  ;
             $empresa = $sin_pl['EMPRESA'];




            echo'
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="id_con">Id</label>
                        <input class="form-control form-control-sm" type="text" placeholder="'.$id.'" name="id_con" id="id_con" value="'.$id.'"readonly >
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="ce_con">Cedula</label>
                        <input class="ce_con form-control form-control-sm" type="text" placeholder="'.$cedula.'" name="ce_con" id="ce_con"   value="'.$cedula.'" readonly>
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="'.$nombre.'">Nombre</label>
                        <input class="no_con form-control form-control-sm" type="text" placeholder="'.$nombre.'" name="no_con" id="no_con" value="'.$nombre.'"  readonly>
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="pl_con">Placa</label>
                        <input class="pl_con form-control form-control-sm" type="text" placeholder="'.$placa.'" name="pl_con" id="pl_con" >
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="em_con">Id</label>
                        <input class="em_con form-control form-control-sm" type="text" placeholder="'.$empresa.'" name="em_con" id="em_con" value="'.$empresa.'" readonly >
                    </div>
                </div>
                        
                <div class="col-2">
                    <div class="form-group">
                    <br>
                        <button type="button" class="btn btn-outline-success" name="btn_placa_act" id="btn_placa_act"  onclick="actualizar_placas(\''.$conta.'\',\''.$id.'\',\''.$cedula.'\',\''.$nombre.'\',\''.$empresa.'\');" >Actualizar</button>
                    </div>
                </div>


            </div>
            <hr>
            ';

        $conta ++;
    }

        ?>
    </table>
</form>
</div>

<div id="respuesta_update" name="respuesta_update" class="respuesta_update"></div>
<?php
//  header("Location: crud_us.php");
?>
<script src="./js/crud_us.js"></script>
</div>