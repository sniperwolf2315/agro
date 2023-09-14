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
        <div>
                <h1>Bienvenido a agrocampo</h1>
                
                <label>Nacionalidad:</label><br>
                <label for="Nac">Nacional  : </label> <input type="radio" name="Nacionalidad" id="Nacionalidad" class="Nac" value="Nacional"   onchange="dimePropiedades(this.value);">
                <label for="Ext">Extranjero: </label> <input type="radio" name="Nacionalidad" id="Nacionalidad" class="Ext" value="Extranjero" onchange="dimePropiedades(this.value);">
        </div>
        <div id="nac" name ="nac" class="nac">
                <div id="div_frm_1" name ="div_frm_1" class="div_frm_1">
                        <form action="rest_pibox.php?nacion=col" method="POST" autocomplete="off" >
                                <label for="ced_domi">Escane su documento de identidad:</label><br>
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

<div id="ext" name ="ext" class="ext">  
        <form action="rest_pibox.php?nacion=ext" method="POST" autocomplete="off" >
                <label for="ced_domi_1">Escane su documento de identidad:</label><br>
                <input type="text" placeholder="Identificacion" id="ced_domi_1"  name ="ced_domi_1"  class="ced_domi"  required>
                <input type="hidden" placeholder="ip_real"             id="ip_real" name="ip_real"  class="ip_real" value="<?=$ip_real;?>"  >        
                <br>    
                <button type="submit" name="btn_ced_domi" id="btn_ced_domi" class="btn_ced_domi" >Enviar</button>
                <input type="reset" value="Borrar" class="btn_ced_domi" name="btn_ced_domi" id="btn_ced_domi" >
        </form>
</div>

<div class="menu_teclado" name="menu_teclado" id="menu_teclado">
<div id="teclado">
        <div id="letras"></div>
</div>
<div style="margin-top:5%;text-align:center;font-size:11px;font-size:15px;">
            <span>CLÁUSULA DE AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES</span>
            <br>
            <span >
            “Los datos personales aportados serán tratados conforme a nuestra política de datos (Ley 1581 de 2012 y el Decreto 1377 de 2013). Puede consultar en nuestra pagina <a href="https://www.agrocampo.com.co/politica-de-datos" target="_blank" rel="noopener noreferrer">www.agrocampo.com.co</a>”
            </span>
</div>
<script type = 'text/javascript' src = '../../../assets/js/valida_ingreso_domicilio.js'></script>
</div>

</body>
</html>


