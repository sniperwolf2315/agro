<?php
if (!isset($_SESSION)) { session_start(); }
$Entra=$_SESSION['usuARioEntra'];
if($Entra==0){
    header("location:../index.php");
}
?>
<script language="JavaScript">
            //alert(screen.width);
            if (screen.width <= 800)
            {
            //alert(screen.width);
            document.write('<link href="css/estilos.css" rel="stylesheet" type="text/css" />');
            }
            
            if (screen.width > 800 && screen.width <= 1024)
            {
            document.write('<link href="css/estilos1024.css" rel="stylesheet" type="text/css" />');
            }
            
            if (screen.width > 1024 && screen.width <= 1280)
            {
            document.write('<link href="css/estilos1280.css" rel="stylesheet" type="text/css" />');
            }
            
            if (screen.width >= 1280)
            {
            document.write('<link href="css/estilos1800.css" rel="stylesheet" type="text/css" />');
            }
            
            function enviarse(valor){
                document.getElementById('elegido').value=valor;
                document.getElementById('codig').value='';
                document.getElementById('codig').focus();
                document.getElementById('datos').innerHTML='';
                tipo=valor.substring(1,10);
                if(valor=='XNombre')
                    document.getElementById('escanear').value='Digitar ' + tipo;
                else
                    document.getElementById('escanear').value='Escanear ' + tipo;
            }
            
            //busca ubicaciones
            function consultarDatosIbs() {
                //var busqueda = document.getElementById('elegido').value;
                var busqueda=document.ubk.rueda.value;
                
                var codigo = document.getElementById('codig').value;
                tipo=busqueda.substring(1,10);
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'buscarubicacionesibs.php?b=' + busqueda + '&c=' + codigo, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            document.getElementById('datos').innerHTML=dato;
                            document.getElementById('codig').value='';
                            document.getElementById('codig').focus();
                            document.getElementById('elegido').value='XProducto';
                            if(busqueda=='XNombre')
                                document.getElementById('escanear').value='Digitar ' + tipo;
                            else
                                document.getElementById('escanear').value='Escanear ' + tipo;
                            document.getElementById('escanear').value='Escanear ';
                        }else{
                            document.getElementById('datos').innerHTML='DATO NO ENCONTRADO...';
                        }
                    }
                }
            }
            
            function nuevoDato(){
                setTimeout("location.reload(true);", 500);
                document.getElementById('elegido').value='XProducto';
                document.getElementById('escanear').value='Escanear Producto';
            }
            
            function cerrarAplicacion(){
                    location.href='index.php';
              }
</script>
<style type="text/css">
        .redondeado {
              border: 1px;
              border-radius: 5px 10px 10px 20px;
              background-color: bisque;
              width: 80em;
        }
        .texto {
            font-size: 1.5em;
        }
        .celdat {
            background-color: #B3EB85;
        }
        .celdaa {
            background-color: #ECF7B6;
        }
        .celdab {
            background-color: #B6EDF7;
        }
        .check {
            width:60px;
            height:60px;
        }
        
        
        .texto1 {
            width: 8em;
            font-size: 4em;
            text-align: center;
            -moz-border-radius:3px;
            -webkit-border-radius:3px;
            -o-border-radius:3px;
            -ms-border-radius:3px;
            border: 1.2px solid rgba(255,255,255,.1);
            background-color: #FBFBFB;
        }
        .boton1 {
            background-color: #0C22D8;
            color: white;
            font-family: Tahoma;
            font-weight: bold;
            width:  6em;
            font-size: 3.0em;
            -moz-border-radius: 15px 15px 15px 15px;
            -o-border-radius: 15px 15px 15px 15px;
            -webkit-border-radius: 15px 15px 15px 15px;
        }
        .boton5 {
            background-color: #0C22D8;
            color: white;
            font-family: Tahoma;
            font-weight: bold;
            width:  11em;
            font-size: 1em;
            -moz-border-radius: 15px 15px 15px 15px;
            -o-border-radius: 15px 15px 15px 15px;
            -webkit-border-radius: 15px 15px 15px 15px;
        }
</style>

<div class="redondeado">

<br />
<label for="ubk" style="font-size: 3em;"><b>CONSULTAS BODEGA</b></label><hr />
<form name="ubk" method="post" action="">
    <div>
    <input type="radio" class="check" id="1" name="rueda" value="XUbicacion" onclick="enviarse(this.value);" /><span style="font-size: 3em;">Ubicacion</span>&nbsp;&nbsp;&nbsp;<input type="radio" class="check" onclick="enviarse(this.value);" id="2" name="rueda" value="XProducto" checked="true" /><span style="font-size: 3em;">Item</span>
    &nbsp;&nbsp;&nbsp;<input type="radio" class="check" onclick="enviarse(this.value);" id="3" name="rueda" value="XNombre" /><span style="font-size: 3em;">Nombre</span>
    </div>
    <br />
    <span style="font-size: 3em;"><input type="button" class="boton5" id="escanear" value="Escanear Producto" onclick="nuevoDato();" /></span>&nbsp;<input type="text" class="texto1" id="codig" onchange="consultarDatosIbs();" autofocus="true" /><br /><br /><input type="text" id="elegido" value="XProducto" style="visibility: hidden;" />
    <br />
    <input type="button" class="boton1" id="buscarub" value="BUSCAR" onclick="consultarDatosIbs();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="boton1" name="Abandonar" id="Abandonar" value="CERRAR" onclick="cerrarAplicacion();" /><br /><hr />
</form>
<div id="datos" class="texto">

</div>

</div>