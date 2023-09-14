<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Certificados-Agrocampo S.A.S</title>
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="contabilidad-cert.css">    
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="container-fluid">
        <img src="/nuevo_sia_v2/assets/images/logo_agro.png" alt="Logo agrocampo" id="logo_agro_pr" name="logo_agro_pr" class="logo_agro_pr">

        <div class="header-consulta col-12 col-6 col-3 text-center">
            <h6>
                <span>Bienvenido a nuestra plataforma de certificados, a continución podrá descargar por rango de fechas unos de los certificados disponibles en el listado.</span>
            </h6>
            <hr>
            <form name="frm_request_cert" id="frm_request_cert" class="frm_request_cert" action="#" mehtod="POST" >
                <label for="nit_empresa">&nbsp&nbsp&nbsp&nbsp;NIT :</label>
                    <?php

                        $_POST['nit_empresa'] =($_POST['nit_empresa']=='')?'':$_POST['nit_empresa']; 
                    
                    ?>
                <input type="number" name="nit_empresa" id="nit_empresa" class="nit_empresa" placeholder="NIT o CC sin digito de verificación" value="nit_empresa"required>    
                <br>

                <?php
                $_POST['fecha_desde'] =($_POST['fecha_desde']=='')?date('Y-m-d'):$_POST['fecha_desde']; 
                $_POST['fecha_hasta'] =($_POST['fecha_hasta']=='')?date('Y-m-d'):$_POST['fecha_hasta']; 
                ?>
                    <label for="cert-desde">Desde :</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="fecha_desde" value="<?=$_POST['fecha_desde']?>"  >    
                    <br>
                    <label for="fecha_hasta">Hasta :</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="fecha_hasta" value="<?=$_POST['fecha_hasta']?>" >   
                    <br>
                    <label for="">Tipo de Certificado: </label> <br>
                    <select name="type_form" id="type_form" class="type_form" >
                        <option selected></option>
                        <option value="ica_bta"     >Certificado de ica bogotá</option>
                        <option value="ica_cota"    >Certificado de ica cota </option>
                        <option value="rfte"        >Certificado de retención en la fuente</option>
                        <option value="iva"         >Certificado de iva </option>
                        <option value="prov" disabled>Certificado de proveedores</option>
                    </select>
                    <br>  
                    <br>  
                    <button type="button" class="btn btn-outline-success" onclick="consultar_cert()">Consultar</button>
                    <button type="button" class="btn btn-outline-warning" onclick="printDiv('seccion_response')">Imprimir</button>
            </form>
        </div>
      
        <br>
        <div id="seccion_response" name="seccion_response" class="seccion_response text-center">
            ...
        </div>
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="contabilidad-cert.js"></script>  
    </div>
    </body>
</html>

