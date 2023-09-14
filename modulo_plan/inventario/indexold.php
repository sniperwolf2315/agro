<html>
<head>
<title>Inventario</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
        .letra{
            font-family: sans-serif;
            font-size: 1.1em;
        }
        .titulo{
            font-family: sans-serif;
            font-size: 1.2em;
        }
        body {
            background-color: beige;
        }
        </style>
<script language="JavaScript">
            
            function enviarDato(grupo){
                document.getElementById('G1').value=grupo;
                document.getElementById('G2').value="";
                return true;
            }
            
            function consultarDatos() {
                var grupo = document.getElementById('G1').value;
                var estadochk=document.getElementById('venc').checked;
                var fvencimiento=0;
                var temp="";
                //evalua si habilita fecha vencimiento
                if(estadochk==true){
                    fvencimiento=1;
                }else{
                    fvencimiento=0;
                }
                var item="";
                var nombre="";
                var bodega="";
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'buscarenibs.php?grp=' + grupo + '&fv=' + fvencimiento, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            if (dato.length <= 0) {
                                alert("Datos no encontrados!");
                                return false;
                            } else {
                                var datos = dato.split('^');
                                item=datos[0];
                                nombre=datos[1];
                                bodega=datos[2];
                                temp=datos[3];
                                document.getElementById('tmp').innerHTML=item+nombre+bodega+temp;
                                return true;
                                
                            }
                        }
                    }
                }
            }
</script>

</head>
<body>
<label class="e1">Solicitar Vencimiento:</label>&nbsp;&nbsp;<input type="checkbox" class="check" name="venc" id="venc" /><br /><br />
    <label class="e1">Seleccione conteo</label>&nbsp;&nbsp;
    <select name="combo1" id="combo1">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select><br /><br />
    <label class="e1">Grupo:</label>&nbsp;&nbsp;
    <input type="text" class="texto1" id="G1" name="G1" maxlength="20" autocomplete="off" />
<?php
/*
            include('conexioninventario.php');
            $result = mssql_query("SELECT DISTINCT(pgpgrp) from invRegistro WHERE pgpgrp!='' and pgpgrp!='.' ORDER BY pgpgrp ASC ");
            ?>
            <br />
            <select name="G2" id="G2" onchange="enviarDato(this.value);">
            <option value=""></option>
            <?
            while ($fila = mssql_fetch_array($result)){
                $d1=$fila[0];
                echo "<option value='$d1'>$d1</option>";  
                $con++;
                Next($fila); 
            }
            ?>
            </select>&nbsp;&nbsp;
            <?    
    */        
?>
<input type="button" class="boton1" name="Iniciar" value="INICIAR" onclick="consultarDatos();" />
<?
session_start();
$d1=$_SESSION['Grupo'];
echo $d1;
?>
<div id="tmp">

</div>
</body>
</html>