<?
if (!isset($_SESSION)) { session_start(); }
$compania=$_SESSION['Compan'];
if($_SESSION['usuARioI'] !='' && $compania != ''){
    header("location:../modulo_inv/index.php");
}
?>
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
    font-size: 2.8em;
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
    width: 90%;
    font-size: 4.2em;
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
        </style>
<script language="JavaScript">
        function leerCompan() {
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
                        }
                    }
                }
            }
            
            function iniciarAplicacion() {
                var compania=document.getElementById('compan').value;
                if (compania==''){
                    alert('SELECCIONE EMPRESA');
                    return false;
                }
                location.href='index.php';
                setTimeout("location.reload(true);", 200);
            }
            
            function iniciarInforme(){
                    location.href='informes.php';
              }
            
            function cerrarAplicacion(){
                    if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'cerraraplicacion.php', true);
                    peticion_http.send(null);
    
                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                location.href='index.php';
                                setTimeout("location.reload(true);", 200);
                            }
                        }
                    }
              }
              
           function iniciarAplicacion1(){
                    if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'iniciarFormulario1.php', true);
                    peticion_http.send(null);
    
                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                location.href='index.php';
                                setTimeout("location.reload(true);", 200);
                            }
                        }
                    }
              } 
            
</script>
<?php
                if (!isset($_SESSION)) { session_start(); }
                $Us=$_SESSION['usuARioI'];
                $Us=strtoupper($Us);
                $compania=$_SESSION['Compan'];
                //formulario
                //$_SESSION['Pantalla']='1';                
                //optiene sede
                $miip=$_SERVER['REMOTE_ADDR'];
                $arreglo = new ArrayObject();
                $segr=explode(".",$miip);
                $ipsede=$segr[2];
                if($ipsede=='6' || $ipsede=='9' || $ipsede=='10'){
                    $sede="Portos";
                }else{
                    $sede="Calle73";
                }
                //mira permisos
                require_once('conexioninventario80.php');
                $resultusu2 = mssql_query("SELECT acceso2 FROM [sqlInventario008].[dbo].[invAcceso] WHERE acceso1='$Us'", $cLink);
                if($fila2 = mssql_fetch_array($resultusu2)){
                    $Activado=$fila2['acceso2'];
                }
                mssql_close($resultusu2);
?>
                    <div style="padding: 50px;">
                    <img src="img/logoAG.png" width="50px" height="60px" />&nbsp;
                    <label class="e1">INVENTARIO Sede:<span style="color: #1636EE;"> <? echo $sede; ?></span></label><br /><? echo "<span style=\"color: #0C22D8; font-size: 2em; \"> Usuario: <b>".$Us;?></span></b><br />
                    <table class="tabla" style="border:1px solid #000000;width: 96%;">
                    <?
                    if ($sede=='Portos'){
                    ?>
                    <tr><td style="height: 50px; width: 30%;"><label class="e1">Seleccione Empresa:</label>&nbsp;&nbsp;</td><td>
                    <select name="compan" id="compan" class="lista" onchange="leerCompan();">
                        <option value=""></option>
                        <option value="Agrocampo">Agrocampo</option>
                        <option value="Comervet">Comervet</option>
                    </select><br /><br /></td></tr>
                    <!--<tr style="height: 130px;"><td style="width: 60%; height: 80px; vertical-align: top"><br /><label class="e1" id="lblv">Solicitar Vencimiento:</label>&nbsp;&nbsp;</td><td style="vertical-align: top"><br /><input type="checkbox" class="check" name="venc" id="venc" /><br /><br /><br /></td></tr>-->
                    <?
                    }
                    ?>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton1" name="Iniciar" id="Iniciar" value="INICIAR" onclick="iniciarAplicacion1();" /></td></tr>
                    <?php
                    if($Activado=="U1"){
                    ?>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton1" name="Informe" id="Informe" value="INFORMES" onclick="iniciarInforme();" /></td></tr>
                    <?php
                    }
                    ?>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton1" name="Abandonar" id="Abandonar" value="CERRAR" onclick="cerrarAplicacion();" />&nbsp;&nbsp;&nbsp;
                    </td></tr></table>
                    </div>