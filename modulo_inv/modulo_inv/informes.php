<?php
if (!isset($_SESSION)) { session_start(); }
$Us=$_SESSION['usuARioI'];
$compania=$_SESSION['Compan'];
$Us=strtoupper($Us);
?>
<script language="JavaScript">
    function iniciarInforme(){
        var compania=document.getElementById('compan').value;
        var grupod=document.getElementById('grupod').value;
        var conteo=document.getElementById('conteo').value;
        var descp=document.getElementById('descp').value;
        var totbg=document.getElementById('tipo').checked;
        var fvenc=document.getElementById('fvenc').checked;
        var bubic=document.getElementById('gubic').checked;
        var dcero=document.getElementById('dcero').checked;
        var gconteo=document.getElementById('gconteo').value;
                if(totbg==true){
                    totbg=1;    
                }else{
                    totbg=0;
                }
                if(fvenc==true){
                    fvenc=1;
                }else{
                    fvenc=0;
                }
                if(bubic==true){
                    bubic=1;
                }else{
                    bubic=0;
                }
                if(dcero==true){
                    dcero=1;
                }else{
                    dcero=0;
                }
                if (compania==''){
                    return false;
                }
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                document.getElementById('contenido').innerHTML='<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
                document.body.style.cursor = 'wait';
                peticion_http.open('POST', 'consultainforme.php?c=' + compania + '&g=' + grupod + '&n=' + conteo + '&d=' + descp + '&op1=' + totbg + '&op2=' + fvenc + '&bu=' + bubic + '&dc=' + dcero + '&gc=' + gconteo, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            document.getElementById('contenido').innerHTML=dato;
                            document.body.style.cursor = 'auto';
                        }
                    }
                }
    }
    function leerCompan() {
                //alert('compania');
                //return false;
                var compania=document.getElementById('compan').value;
                if (compania==''){
                    return false;
                }
                
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'compania.php?c=' + compania, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            if(dato=='leergrupos'){
                                leerGrupos();
                            }
                        }
                    }
                }
            }
            
        function leerGrupos() {
                var compania=document.getElementById('compan').value;
                if (compania==''){
                    return false;
                }
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'gruposdesc.php?c=' + compania, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            document.getElementById('grupod').innerHTML=dato;
                        }
                    }
                }
            }
            
            function cerrarFormulario(){
                location.href='menu.php';
            }
</script>
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
        .boton1 {
            -moz-border-radius: 15px 15px 15px 15px;
            -o-border-radius: 15px 15px 15px 15px;
            -webkit-border-radius: 15px 15px 15px 15px;
        }
        .boton2 {
            -moz-border-radius: 15px 15px 15px 15px;
            -o-border-radius: 15px 15px 15px 15px;
            -webkit-border-radius: 15px 15px 15px 15px;
        }
        .boton3 {
            -moz-border-radius: 15px 15px 15px 15px;
            -o-border-radius: 15px 15px 15px 15px;
            -webkit-border-radius: 15px 15px 15px 15px;
        }
        .boton4 {
            -moz-border-radius: 15px 15px 15px 15px;
            -o-border-radius: 15px 15px 15px 15px;
            -webkit-border-radius: 15px 15px 15px 15px;
        }
        .tabla {
            width: 90%;
            border: 2px;
            background-color: #AFBAA0;
        }
        .e2 {
    font-family: tahoma;
    vertical-align: top;
    width: 100%;
    font-size: 1em;
    color: #F5F5DC;
}
.e1 {
    font-family: tahoma;
    vertical-align: top;
    width: 100%;
    font-size: 2.6em;
    font-weight: bold;
}
.e1b {
    font-family: tahoma;
    vertical-align: top;
    width: 100%;
    font-size: 1.6em;
    font-weight: bold;
}
.texto1 {
    width: 80%;
    font-size: 3em;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    -o-border-radius:3px;
    -ms-border-radius:3px;
    border: 1.2px solid rgba(255,255,255,.1);
    background-color: #FBFBFB;
}
.texto2 {
    width: 90%;
    font-size: 4em;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    -o-border-radius:3px;
    -ms-border-radius:3px;
    border: 1.2px solid rgba(255,255,255,.1);
    background-color: #FBFBFB;
}
.lista {
    width: 98%;
    font-size: 4.2em;
}
.listab {
    width: 98%;
    font-size: 1.6em;
}
.boton1 {
    background-color: #0C22D8;
    color: white;
    font-family: Tahoma;
    font-weight: bold;
    width:  92%;
    height: 2em;
    font-size: 1.2em;
    -moz-border-radius: 15px 15px 15px 15px;
    -o-border-radius: 15px 15px 15px 15px;
    -webkit-border-radius: 15px 15px 15px 15px;
}
.boton2 {
    background-color: #0C22D8;
    color: white;
    font-family: Tahoma;
    font-weight: bold;
    width:  10%;
    height: 2em;
    font-size: 1.2em;
    -moz-border-radius: 15px 15px 15px 15px;
    -o-border-radius: 15px 15px 15px 15px;
    -webkit-border-radius: 15px 15px 15px 15px;
}
.boton3 {
    background-color: #0C22D8;
    color: white;
    font-family: Tahoma;
    font-weight: bold;
    width:  35%;
    height: 2em;
    font-size: 1.2em;
    -moz-border-radius: 15px 15px 15px 15px;
    -o-border-radius: 15px 15px 15px 15px;
    -webkit-border-radius: 15px 15px 15px 15px;
}
.boton4 {
    background-color: #0C22D8;
    color: white;
    font-family: Tahoma;
    font-weight: bold;
    width:  70%;
    height: 2em;
    font-size: 1.2em;
    -moz-border-radius: 15px 15px 15px 15px;
    -o-border-radius: 15px 15px 15px 15px;
    -webkit-border-radius: 15px 15px 15px 15px;
}
.celdaa {
    background-color: #E2E1E1;
    font-size: 0.6em;
}
.celdab {
    background-color: white;
    font-size: 0.6em;
}
.check {
    width:35px;
    height:35px;
}
</style>
                    <div style="padding: 50px;">
                    
                    <label class="e1">CONSULTAS INVENTARIO<span style="color: #1636EE;"> <? echo $sede; ?></span></label><br /><? echo "<span style=\"color: #0C22D8; font-size: 2em; \"> Usuario: <b>".$Us;?></span></b><br />
                    <table class="tabla" style="border:1px solid #000000;width: 96%;" >
                    <?
                    //if ($sede=='Portos'){
                    ?>
                    <tr><td style="height: 50px; width: 30%;"><label class="e1">Empresa:</label>&nbsp;&nbsp;</td>
                    <td colspan="4">
                    <select name="compan" id="compan" class="lista" onchange="leerCompan();">
                        <option value=""></option>
                        <option value="Agrocampo">Agrocampo</option>
                        <option value="Comervet">Comervet</option>
                    </select><br /><br />
                    </td>
                    </tr>
                    <tr>
                    <div>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="radio" id="tipo" name="tipo" value="tbod" class="check" />
                    <label for="tipo" class="e1b">Total Bodega:</label><br />&nbsp;
                    <input type="radio" id="fvenc" name="tipo" value="fvenc" class="check" />
                    <label for="fvenc" class="e1b">Fecha Vencimiento:</label><br /></td>
                    </div>
                    <td></td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" id="gubic" name="gubic" value="gubic" class="check" />
                    <label for="gubic" class="e1b">Mostrar Ubicaci&oacute;n:</label><br />&nbsp;
                    <input type="checkbox" id="dcero" name="dcero" value="dcero" class="check" />
                    <label for="dcero" class="e1b">Diferencias en Cero:</label><br /></td>
                    <td></td>
                    </tr>
                    <tr><td style="height: 50px; width: 30%;"><label class="e1">Filtros:</label>&nbsp;&nbsp;</td>
                    <td>
                    <label class="e1b">Grupo:</label>
                    </td>
                    <td>
                    <select id="grupod" class="listab">
                        <option value=""></option>
                                       
                    </select>
                    </td>
                    <td>
                    <label class="e1b">Conteo:</label>
                    </td>
                    <td>
                    <select id="conteo" class="listab">
                        <option value=""></option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>                   
                    </select>
                    </td>
                    <td></td>
                    </tr>
                    <tr>
                    <td>
                        <label class="e1">G. de Conteo:</label>
                    </td>
                    <td colspan="4"><input type="text" id="gconteo" class="listab" /></td>
                    </tr>
                    <tr>
                    <td>
                        <label class="e1">Descripcion:</label>
                    </td>
                    <td colspan="4"><input type="text" id="descp" class="listab" /></td>
                    </tr>
                    
                    <!--<tr style="height: 130px;"><td style="width: 60%; height: 80px; vertical-align: top"><br /><label class="e1" id="lblv">Solicitar Vencimiento:</label>&nbsp;&nbsp;</td><td style="vertical-align: top"><br /><input type="checkbox" class="check" name="venc" id="venc" /><br /><br /><br /></td></tr>-->
                    <?
                    //}
                    ?>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td colspan="2"><br /><input type="button" class="boton4" name="Iniciar" id="Iniciar" value="VISUALIZAR" onclick="iniciarInforme();" /></td></tr>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td colspan="2"><br /><input type="button" class="boton4" name="Abandonar" id="Abandonar" value="CERRAR" onclick="cerrarFormulario();" />&nbsp;&nbsp;&nbsp;
                    </table>
                    </div>
                    
                    <div id="contenido">
                    
                    </div>