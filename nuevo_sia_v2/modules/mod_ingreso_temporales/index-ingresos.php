<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name ="author" content ="Erik Cifuentes">
    <meta name ="copyright" content ="Erik Cifuentes - Agrocampo">
    <meta name="description" content="Este formulario es elavorado por Erik Cifuentes AGROCAMPO para dar ingresos a los usuarios de visita temporal cono lko son proveedores y colaboradores para los turnos de los dias festivos.">
    <meta name="keywords" content="Usuarios, Proveedores, terceros, Agrocampo">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/estilos-ingresos.css">
    <title>Ingresos Agrocampo 2.0</title>
</head>
<body>


<div data-bs-theme="dark" class="container" >
    <?php

        include('../mod_rest_clientes/domiciliario/funciones_dom.php');
        $ip_real=getRealIP();
         $ext = '.php';
    ?>
    <form class="row g-3" action="rest_temporales<?=$ext?>" method="POST" id="frm-ingreso" name="frm-ingreso">
    <div class="row">
        <div class="col-4 justify-content-right ">
            <img src="../../assets/images/logo_agro.png" width="80" height="80">
        </div>
        <br>
        <div class="col-4">
            <div class="alert alert-light justify-content-center align-item-center " id="encabezado" name="encabezado">
                <h3>
                    <span> Ingreso Agrocampo</span>
                </h3>
                </div>
            </div>
            <div class="col-4"></div>
        </div>

        <div style="text-align:center;font-size:11px;">
            <span>CLÁUSULA DE AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES</span>
            <br>
            <span >
            “Los datos personales aportados serán tratados conforme a nuestra política de datos (Ley 1581 de 2012 y el Decreto 1377 de 2013). Puede consultar en nuestra pagina <a href="https://www.agrocampo.com.co/politica-de-datos" target="_blank" rel="noopener noreferrer">www.agrocampo.com.co</a>”
            </span>
        </div>
    <?php
        // echo "<a href='tomar_foto.php' target='_blanck'>Foto</a>";
    ?>



        <span><label><strong>Motivo de visita</strong><span style="font-size:12px;"></span></label></span>
        <?php
            $check_ingreso =[
                    'Trabajo_Agrocampo',
                    'Visitante',
                    // 'Proveedor'
            ];


            foreach($check_ingreso as $item){
                if($item=='Proveedor'){
                    echo"          
                    <div class='form-check form-switch'>
                        <input id='$item' name='ingreso_agr' class='ingreso_agr form-check-input' type='checkbox' value='$item' onClick='validar_check(this.value);' disabled>
                        <label class='form-check-label' for='$item'>$item</label>
                    </div>
                    ";
                }else{
                    echo"          
                    <div class='form-check form-switch'>
                        <input id='$item' name='ingreso_agr' class='ingreso_agr form-check-input' type='checkbox' value='$item' onClick='validar_check(this.value);'>
                        <label class='form-check-label' for='$item'>$item</label>
                    </div>
                    ";
                }

            }
        
        ?>



                <hr>
        <?php
            $arra_campos_frm =[
                'turno'=>['Ingreso','Salida_alm','Entrada_alm','Salida'],    
                'identificacion'=>'Identificacion',
                'apellidou'=>'Primer apellido',
                'apellidod'=>'Seguno apellido',
                'nombreu'=>'Primer nombre',
                'nombred'=>'Segundo nombre',
                'genero'=>'Genero',
                'fechanc'=>'Fecha',
                'sanguineo'=>'Sanguineo'
            ];
            $fecha_hora = date("d-m-Y H:i:s");
            $fecha      = date("Y-m-d");
            $hora       = date("H:i");
    

            foreach ($arra_campos_frm as $clave => $valor) {
                $es_arreglo = is_array($valor)?'1':'0';
                if($es_arreglo=='1'){
                    echo '
                    <div class="mb-3 row">
                    <label for="'.$clave.'" class="col-sm-2 col-form-label"> '.strtoupper($clave).' </label>
                    <div class="col-sm-10">
                    <select class="form-control" id="'.$clave.'" name="'.$clave.'" style="color:black;font-style: bold;" onchange="focus_doc()">
                    <option></option>
                    ';
                    // RECORREMOS LOS ARREGLOS QUE CONTIENEN MULTIPLES ACCIONES
                    foreach ($valor as $key => $value) {
                        echo "<option>$value</option>";
                    /*    
                        if($hora >'05:00' && $hora <'10:00')
                        {  
                            echo"<option >Ingreso</option>";
                        }else if($hora >'12:00' && $hora <'14:30'){
                            echo"<option >Salida_alm</option>";
                            echo"<option >Entrada_alm</option>";
                        }else if($hora >'15:00'){
                            echo"<option >Salida</option>";
                        }
                        */
                    }
                      echo '          
                            </select>
                        </div>
                    </div>                
                    ';

                }else{

                   
                    echo '
                    <div class="form-floating mb-3">
                    <input type="text" class="form-control" id ="'.$clave.'" name="'.$clave.'" placeholder="'.strtoupper($valor).'" ">
                    <label for="'.$clave.'" class="col-sm-2 col-form-label" >'.strtoupper($valor).'</label>
                    </div>                
                    ';
                }
                
            }

        ?>
        <!-- ESPACIO PARA LABEL DESABILITADO DE LA IP -->
        <div class="mb-3 row">
            <label for="ip" class="col-sm-2 col-form-label">IP</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id ="ip" name="ip" value="<?=$ip_real?>"  disabled>
            </div>
        </div>
        <!-- ESPACIO DEL BOTON DE ENVIAR -->
        <div class="col-4"></div>
        <div class="col-4">
            <button type="submit"  class="btn btn-primary mb-3">Confirmar datos</button>
        </div>
        <div class="col-4"></div>
  
        </form>
</div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../../assets/js/valida_ingreso_temporales.js"></script>
</body>
</html>