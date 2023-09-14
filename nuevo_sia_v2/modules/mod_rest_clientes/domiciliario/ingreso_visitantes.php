<!DOCTYPE html>
<html lang=”en”>
<head>
    <meta charset=”UTF-8″ />
    <title>INGRESO DOMICILIARIO</title>
    <link rel = 'stylesheet' href = '../../../assets/css/log_domiciliarios.css' />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>    
</head>
<div style="color:white;">
<?php
                include('funciones_dom.php');
                $ip_real=getRealIP();
                echo $ip_real;
                 ?>

</div>
<body>
        <div class="container_">
                <div id="nac" name ="nac" class="nac">
                        <div id="div_frm_1" name ="div_frm_1" class="div_frm_1">
                                <form action="rest_temporales.php" method="POST" autocomplete="off" >
                                        <label for="ced_domi">Escane su documento de identidad:</label><br>
                                        <?php
                                                $lista_visita =['turno','proveedor'];
                                                foreach($lista_visita as $ls){
                                                        echo '
                                                        <label for="'.$ls.'">'.strtoupper($ls).'</label>
                                                        <input type="radio" name="motivo_ingreso" id="motivo_ingreso" class="temp" value="'.$ls.'" onclick="dimePropiedades(this.value)">';
                                                }
                                                $registro_marca =['ingreso','salida_alm','entrada_alm','salida'];
                                                echo "<br>
                                                <select id='marcacion' name='marcacion' class='marcacion' style='width:50%;border-radius:20px';height:15px;>";
                                                foreach($registro_marca as $marca){
                                                        echo "
                                                        <option name='motivo_marca' id='motivo_marca' class='temp'>$marca</option>
                                                        ";
                                                }
                                                echo "</select>";




                                        ?>
                                        <br>       
                                        <input type="text" placeholder="Empresa" id="emp"  name ="emp"  class="ced_domi"  >
                                        <input type="text" placeholder="Identificacion" id="ced_domi"  name ="ced_domi"  class="ced_domi"  required>
                                        <input type="text" placeholder="Apellido 1"     id="Apellido2" name="Apellido2"  class="ced_domi"  >
                                        <input type="text" placeholder="Apellido 2"     id="Apellido1" name="Apellido1"  class="ced_domi"  >
                                        <input type="text" placeholder="Nombre 1"       id="Nombre1"   name="Nombre1"    class="ced_domi"  >
                                        <input type="text" placeholder="Nombre 2"       id="Nombre2"   name="Nombre2"    class="ced_domi"  >
                                        <input type="text" placeholder="Genero"         id="Genero"    name="Genero"     class="ced_domi"  >
                                        <input type="text" placeholder="Fecha"          id="Fecha"     name="Fecha"      class="ced_domi"  >
                                        <input type="text" placeholder="Sanguineo"      id="Sanguineo" name="Sanguineo"  class="ced_domi"  >        
                                        <input type="hidden" placeholder="ip_real"      id="ip_real"   name="ip_real"    class="ip_real" value="<?=$ip_real;?>"  >        
                                        <br>    
                                        <button type="submit" name="btn_ced_domi" id="btn_ced_domi" class="btn_ced_domi" >Enviar</button>
                                        <input type="reset" value="Borrar" class="btn_ced_domi" name="btn_ced_domi" id="btn_ced_domi" >
                                </form>
                </div>

        </div>
</body>
<script type = 'text/javascript' src = '../../../assets/js/valida_ingreso_temporales.js'></script>
</html>