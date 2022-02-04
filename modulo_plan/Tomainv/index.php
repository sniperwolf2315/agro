<?
if($_SESSION['usuARioI'] ==''){
//header("location:../index.php");
}
?>
<html>
<head>
<title>Inventario</title>
<!--<link href="css/estilos.css" rel="stylesheet" type="text/css" />-->
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
            //alert(screen.width);
            if (screen.width < 800)
            {
            //alert(screen.width);
            document.write('<link href="css/estilos.css" rel="stylesheet" type="text/css" />');
            }
            
            /*if (screen.width > 800 && screen.width <= 1024)
            {
            document.write('<link href="css/estilos1024.css" rel="stylesheet" type="text/css" />');
            }
            
            if (screen.width > 1024 && screen.width <= 1280)
            {
            document.write('<link href="css/estilos1280.css" rel="stylesheet" type="text/css" />');
            }*/
            
            if (screen.width >= 800)
            {
            document.write('<link href="css/estilos1800.css" rel="stylesheet" type="text/css" />');
            }
                        
            function enviarDato(grupo){
                document.getElementById('G1').value=grupo;
                document.getElementById('G2').value="";
                return true;
            }
            
            function Solo_Numerico(variable) {
                Numer = parseInt(variable);
                if (isNaN(Numer)) {
                    return "";
                }
                return Numer;
            }
            function ValNumero(Control) {
                Control.value = Solo_Numerico(Control.value);
            }
            
            function consultarDatos() {
                var item = document.getElementById('T1').value;
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
                peticion_http.open('POST', 'buscaitemibs.php?itm=' + item, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            //alert(dato);
                            if (dato=='^') {
                                alert("Item no encontrado");
                                document.getElementById('T1').value="";
                                return false;
                            } else {
                                var datos = dato.split('^');
                                nombre=datos[0];
                                //bodega=datos[1];
                                //alert(nombre);
                                document.getElementById('T2').value=nombre;
                                document.getElementById('T3').value="S";
                                document.getElementById('item').value=item;
                                //document.getElementById('bodega').value=bodega;
                                document.getElementById('T1').value="";
                                document.getElementById('T4').focus();
                                document.getElementById('T4').value="";
                                return true;
                                
                            }
                        }
                    }
                }
            }
            
            function verificaGrupo(Ip) {
                var grupo = document.getElementById('G1').value;
                var gconteo = document.getElementById('conteo').value;
                var sede='';
                var fvencimiento=0;
                if(Ip=='Portos'){
                    sede='Portos';
                    var estadochk=document.getElementById('venc').checked;
                    //evalua si habilita fecha vencimiento
                    if(estadochk==true){
                        fvencimiento=1;
                    }else{
                        fvencimiento=0;
                    }
                }else{
                    sede='Calle73';   
                }
                
                if (gconteo==''){
                    //alert('Seleccione un grupo de conteo');
                    document.getElementById('mensaje').innerHTML="Selecione conteo";
                    return false;
                }
                if (grupo.length<=0){
                    document.getElementById('mensaje').innerHTML="Escanee o digite Grupo (Ubicaci&oacute;n)";
                    document.getElementById('G1').focus();
                    return false;
                }
               
                //alert(fvencimiento);
                grupo = grupo.trim();
                
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'verificagrupoibs.php?grp=' + grupo + '&fv=' + fvencimiento + '&gc=' + gconteo + '&sd=' + sede, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            //alert(dato);
                            if (dato == '0') {
                                document.getElementById('mensaje').innerHTML='Grupo ' + grupo + ' no encontrado.';
                                document.getElementById('G1').value="";
                                alert('Grupo ' + grupo + ' no encontrado.');
                                document.getElementById('G1').focus();                        
                            } else {
                                document.getElementById('mensaje').innerHTML='';
                                setTimeout("location.reload(true);", 200); 
                            }
                        }
                    }
                }
            }
            
                                   
            function agregaLetra(Letra){
                document.getElementById('T4').focus();
                document.getElementById('T3').value=Letra;
                return true;
            }
            
            function cerrarSession(){
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'cerrarsession.php', true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            setTimeout("location.reload(true);", 200);
                        }
                    }
                }
            }
            
            function cambio(){
                alert('en proceso de desarrollo!');
            }
            
            function leerGrupo(){
                document.getElementById('G1').focus();
                return true;
            }
            
            function leerLote(){
                document.getElementById('lot').focus();
                return true;
            }
            
            function leernewItem(){
                document.getElementById('T4').value="";
                document.getElementById('T1').value="";
                document.getElementById('T1').focus();
                document.getElementById('T3').value="S";
                document.getElementById('T2').value="";
                document.getElementById('fva').value="";
                document.getElementById('fvm').value="";
                document.getElementById('lot').value="";
            }
                       
             /*TECLA ENTER DETECT*/
              function onKeyUp(event,nombre) {
                var keycode = event.keyCode;
                if(keycode == '13'){
                    if(nombre=='T1'){
                        consultarDatos(); 
                    }
                    if(nombre=='G1'){
                        document.getElementById('Iniciar').click();  
                    }
                    if(nombre=='T4'){
                        document.getElementById('T1').focus(); 
                    }
                }
              }
              
              function registrarDatos(){
                    var item = document.getElementById('item').value;
                    var nombre = document.getElementById('T2').value;
                    var movim = document.getElementById('T3').value;
                    var fvenca = document.getElementById('fva').value;
                    var fvencm = document.getElementById('fvm').value;
                    if(document.getElementById('fva').style.visibility=='visible'){
                        if (fvenca.length < 4) {
                            alert('Seleccione a\361o');
                            document.getElementById('fva').focus();
                            return false;
                        }
                    }
                    if(document.getElementById('fvm').style.visibility=='visible'){
                        if (fvencm.length < 1) {
                            alert('Seleccione mes');
                            document.getElementById('fvm').focus();
                            return false;
                        }
                    }
                    if (parseInt(fvencm) < 10){
                        fvencm='0'+fvencm;
                    }
                    var fvenc = fvenca+fvencm; 
                    var lote = document.getElementById('lot').value;
                    var conteo = document.getElementById('conteo').value;
                    var ubig = document.getElementById('ubicag').value;
                    var cant = document.getElementById('T4').value;
                    if(document.getElementById('lot').style.visibility=='visible'){
                        if (lote=='') {
                            alert('Digite el lote del producto');
                            document.getElementById('fvm').focus();
                            return false;
                        }
                    }
                    if (item.length <= 5) {
                        alert('Escanee o digite un codigo');
                        document.getElementById('T1').focus();
                        return false;
                    }
                    if(nombre.length < 5){
                        alert('Escanee o digite un codigo y haga clic en enter (flecha inferior verde)');
                        document.getElementById('T1').focus();
                        return false;
                    }
                    if (cant==''){
                        alert('Digite una cantidad de productos');
                        document.getElementById('T4').focus();
                        return false;
                    }
                    if (movim==''){
                        alert('Haga clic en el boton S o R (para Sumar o Restar la cantidad de productos)');
                        document.getElementById('T3').focus();
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
                    peticion_http.open('POST', 'insertardatos.php?itm=' + item + '&nom=' + nombre + '&fve=' + fvenc + '&lot=' + lote + '&con=' + conteo + '&ubi=' + ubig + '&cant=' + cant + '&movi=' + movim, true);
                    peticion_http.send(null);
    
                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            //alert('1');
                            if (peticion_http.status == 200) {
                                //alert('2');
                                var dato = peticion_http.responseText;
                                document.getElementById('mensaje').innerHTML=dato;
                                leernewItem();
                                alert(dato);
                                return true;
                            }
                        }
                    }  
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
                                setTimeout("location.reload(true);", 200);
                            }
                        }
                    }
              }
              
              /*function verificaSede(){
                    var misede = document.getElementById('sede').value;
                    if (misede=='Calle73'){
                        document.getElementById('venc').style.visibility='hidden';
                        document.getElementById('lblv').style.visibility='hidden';
                    }else if (misede=='Portos'){
                        document.getElementById('venc').style.visibility='visible';
                        document.getElementById('lblv').style.visibility='visible';
                    }
                    return false;   
              }*/
                     
            function muestraFormulario(){
                <?
                if (!isset($_SESSION)) { session_start(); }
                    $Pantalla=$_SESSION['Pantalla'];
                
                //$sede=$_SESSION['Sede'];
                
                $conteo=$_SESSION['gConteo'];
                $ubicag=$_SESSION['Ubicag']; //grupo buscado en pantalla 1
                //$sede=$_SESSION['Sede'];
                $anio=date('Y');
                $aniofin=$anio+5;
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
                if($sede=='Portos'){
                    $fv=$_SESSION['fVenc'];
                }else if($sede=='Calle73'){
                    $fv=0;
                }
                echo $Pantalla;
                if($Pantalla != '2'){
                    //if (!isset($_SESSION)) { session_start(); }
                    //$_SESSION['Pantalla']='1';
                    ?>
                    //pantalla inicial formulario 1  
                    var texto='<center><label class="e1">INVENTARIO<br /> Sede:<span style="color: #FE7203;"> <? echo $sede; ?></span></label><br /><br />';
                    texto=texto + '<table class="tabla" style="border:1px solid #000000;">';
                    <?
                    if ($sede=='Portos'){
                    ?>
                    texto=texto + '<tr style="height: 130px;"><td style="width: 60%; height: 80px; vertical-align: top"><br /><label class="e1" id="lblv">Solicitar Vencimiento:</label>&nbsp;&nbsp;</td><td style="vertical-align: top"><br /><input type="checkbox" class="check" name="venc" id="venc" /><br /><br /><br /></td></tr>';
                    <?
                    }
                    ?>
                    texto=texto + '<tr style="height: 130px;"><td style="height: 50px;"><label class="e1">Seleccione conteo:</label>&nbsp;&nbsp;</td><td>';
                    texto=texto + '<select name="conteo" id="conteo" class="lista" onchange="leerGrupo();">';
                        texto=texto + '<option value=""></option>';
                        texto=texto + '<option value="0">0</option>';
                        texto=texto + '<option value="1">1</option>';
                        texto=texto + '<option value="2">2</option>';
                        texto=texto + '<option value="3">3</option>';
                        texto=texto + '<option value="4">4</option>';
                        texto=texto + '<option value="5">5</option>';
                    texto=texto + '</select><br /><br /></td></tr>';
                    texto=texto + '<tr style="height: 130px;"><td style="height: 50px;"><label class="e1">Grupo:</label>&nbsp;&nbsp;</td><td>';
                    texto=texto + '<input onkeyup="onKeyUp(event,this.name)" type="text" class="texto2" id="G1" name="G1" maxlength="12" autofocus="true" autocomplete="off" /></td></tr>';
                    texto=texto + '<tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton1" name="Iniciar" id="Iniciar" value="INICIAR" onfocus="verificaGrupo(\'<? echo $sede; ?>\');" onclick="verificaGrupo(\'<? echo $sede; ?>\');" /></td></tr></table><center>';
                    texto=texto + '<tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton3" name="Abandonar" id="Abandonar" value="SALIR" onclick="cerrarAplicacion();" /></td></tr></table>';
                    document.getElementById('formulario').innerHTML=texto;
                    <?
                    } else if($Pantalla=='2' && $fv=='0'){
                    //if (!isset($_SESSION)) { session_start(); }
                    ?>
                    //onchange="return cambio();"
                    //var texto = '<center></center>';
                    var texto = '<center><label class="e1">INVENTARIO<br /> Sede:<span style="color: #FE7203;"> <? echo $sede; ?></span></label></center><br /><br /><input type="button" class="boton4" name="Cambiar" value="LEER CODIGO" onclick="leernewItem();" />&nbsp;&nbsp;&nbsp;&nbsp;<label class="e1">Conteo:<span style="color: red;"> <? echo $conteo; ?></span></label><br />';
                    texto=texto + '<input onkeyup="onKeyUp(event,this.name)" type="text" class="texto1" id="T1" name="T1" maxlength="30" autofocus="true" autocomplete="off" /><br /><br />';
                    texto=texto + '<label class="e1">Descripci&oacute;n:</label>&nbsp;&nbsp;&nbsp;';
                    texto=texto + '&nbsp;<textarea id="T2" name="T2" class="area" readonly="true"></textarea><br /><br />';
                    //texto=texto + '<input type="text" class="texto2" id="T2" name="T2" style="width: 200px;" readonly="true" /><br /><br />';
                    texto=texto + '&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="boton2" name="Suma" value="S" onclick="agregaLetra(this.value);" />&nbsp;';
                    texto=texto + '<input type="button" class="boton2" name="Resta" value="R" onclick="agregaLetra(this.value);" />&nbsp;&nbsp;';
                    texto=texto + '<input type="text" class="texto1" id="T3" name="T3" readonly="true" style="width: 60px;" />';
                    texto=texto + '<input onkeyup="onKeyUp(event,this.name)" type="number" class="texto1" id="T4" name="T4" onkeyUp="return ValNumero(this);" maxlength="4" style="width: 30%;" autocomplete="off" /><br /><br />';
                    
                    
                    //texto=texto + '<input type="text" class="texto1" id="bodega" name="bodega" readonly="true" style="width: 100px;" />';
                    
                    texto=texto + '<input type="text" class="texto2" value="0" id="lot" name="lot" maxlength="15" style="width: 300px;visibility: hidden;" />&nbsp;&nbsp;&nbsp;';
                    texto=texto + '<center><input type="button" class="boton4" name="Registrar" value="GUARDAR" onclick="registrarDatos();" /></center><br /><br /><br /><br />';
                    texto=texto + '<input type="button" class="boton4" name="Salir" value="<< VOLVER" onclick="cerrarSession();" />';
                    texto=texto + '<input type="text" class="texto1" id="conteo" name="conteo" value="<? echo $conteo; ?>" readonly="true" style="width: 30px;visibility: hidden;" />';
                    texto=texto + '<input type="text" class="texto1" id="ubicag" name="ubicag" value="<? echo $ubicag; ?>" readonly="true" style="width: 30px;visibility: hidden;" />';
                    texto=texto + '<input type="text" class="texto1" id="item" name="item" readonly="true" style="width: 30px;visibility: hidden;" /><br />';
                    
                    texto=texto + '<label class="e1" style="visibility: hidden;">Fecha Vencimiento</label><br /><br />';
                    texto=texto + '<label class="e1" style="visibility: hidden;">A&ntilde;o: </label>&nbsp;';
                    texto=texto + '<select name="fva" id="fva" style="visibility: hidden;" class="texto3"><option value=""></option><? $i=$anio;while($i<$aniofin){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select>&nbsp;&nbsp;';
                    texto=texto + '<label class="e1" style="visibility: hidden;">Mes: </label>&nbsp;';
                    texto=texto + '<select name="fvm" id="fvm" style="visibility: hidden;" class="texto4"><option value=""></option><? $i=1;while($i<13){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select><br /><br />';
                    //texto=texto + '<input type="number" class="texto1" value="0" id="fv" name="fv" style="width: 300px;visibility: hidden;" /><br /><br />';
                    texto=texto + '<label class="e1" style="visibility: hidden;">Lote: </label>&nbsp;';
                    texto=texto + '<br /><br /><br /><input type="button" class="boton3" name="Abandonar" id="Abandonar" value="SALIR" onclick="cerrarAplicacion();" />';
                    document.getElementById('formulario').innerHTML=texto;
                    <?
                    } else if($Pantalla=='2' && $fv=='1'){
                    ?>
                    //var texto = '<center><label class="e1">CONTEO: <? echo $conteo; ?><br /><br /></label></center>';
                    var texto = '<center><label class="e1">INVENTARIO Sede:<span style="color: #FE7203;"> <? echo $sede; ?></span></label></center><br /><input type="button" class="boton4" name="Cambiar" value="LEER CODIGO" onclick="leernewItem();" />&nbsp;&nbsp;&nbsp;&nbsp;<label class="e1">Conteo: <span style="color: red;"><? echo $conteo; ?></span></label><br />';
                    texto=texto + '<input onkeyup="onKeyUp(event,this.name)" type="text" class="texto1" id="T1" name="T1" maxlength="30" autofocus="true" autocomplete="off" /><br /><br />';
                    texto=texto + '<label class="e1">Descripci&oacute;n:</label>&nbsp;&nbsp;&nbsp;';
                    texto=texto + '&nbsp;<textarea id="T2" name="T2" class="area" readonly="true"></textarea><br /><br />';
                    //texto=texto + '<input type="text" class="texto2" id="T2" name="T2" style="width: 200px;" readonly="true" /><br /><br />';
                    texto=texto + '&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="boton2" name="Suma" value="S" onclick="agregaLetra(this.value);" />&nbsp;';
                    texto=texto + '<input type="button" class="boton2" name="Resta" value="R" onclick="agregaLetra(this.value);" />&nbsp;&nbsp;';
                    texto=texto + '<input type="text" class="texto1" id="T3" name="T3" readonly="true" style="width: 60px;" />';
                    texto=texto + '<input onkeyup="onKeyUp(event,this.name)" type="number" class="texto1" id="T4" name="T4" onkeyUp="return ValNumero(this);" maxlength="4" style="width: 20%;" autocomplete="off" /><br /><br />';
                    
                    
                    //texto=texto + '<input type="text" class="texto1" id="bodega" name="bodega" readonly="true" style="width: 100px;" />';
                    texto=texto + '<label class="e1" style="visibility: visible;">Fecha Vencimiento</label><br /><br />';
                    texto=texto + '<label class="e1" style="visibility: visible;">A&ntilde;o: </label>&nbsp;';
                    texto=texto + '<select name="fva" id="fva" style="visibility: visible;" class="texto3" onchange="leerLote();"><option value=""></option><? $i=$anio;while($i<$aniofin){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select>&nbsp;&nbsp;';
                    texto=texto + '<label class="e1" style="visibility: visible;">Mes: </label>&nbsp;';
                    texto=texto + '<select name="fvm" id="fvm" style="visibility: visible;" class="texto4" onchange="leerLote();"><option value=""></option><? $i=1;while($i<13){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select><br /><br /><br />';
                    //texto=texto + '<input type="number" class="texto1" id="fv" name="fv" style="width: 300px;visibility: visible;" /><br /><br />';
                    texto=texto + '<label class="e1" style="visibility: visible;">Lote: </label>&nbsp;';
                    texto=texto + '<input type="text" class="texto2" id="lot" name="lot" maxlength="15" style="width: 300px;visibility: visible;" />&nbsp;&nbsp;&nbsp;';
                    texto=texto + '<input type="button" class="boton4" name="Registrar" value="GUARDAR" onclick="registrarDatos();" /><br /><br /><br /><br /><br />';
                    texto=texto + '<input type="button" class="boton4" name="Salir" value="<< VOLVER" onclick="cerrarSession();" />';
                    texto=texto + '<input type="text" class="texto1" id="conteo" name="conteo" value="<? echo $conteo; ?>" readonly="true" style="width: 30px;visibility: hidden;" />';
                    texto=texto + '<input type="text" class="texto1" id="ubicag" name="ubicag" value="<? echo $ubicag; ?>" readonly="true" style="width: 30px;visibility: hidden;" />';
                    texto=texto + '<input type="text" class="texto1" id="item" name="item" readonly="true" style="width: 30px;visibility: hidden;" /><br />';
                    texto=texto + '<br /><br /><br /><input type="button" class="boton3" name="Abandonar" id="Abandonar" value="SALIR" onclick="cerrarAplicacion();" />';
                    document.getElementById('formulario').innerHTML=texto;
                    <?
                    }
                    ?>
             return true;   
            }
</script>

</head>
<body onload="muestraFormulario();">
<div id="marcov" class="marco">

<div id="formulario"></div>
<center><div id="mensaje" class="ventana"></div></center>
<br /><br />
</div>
</body>
</html>