<?php
    if(session_start()===FALSE){
        session_start();
    }
/*    echo "DISCULPENOS....PAGINA EN MANTENIMIENTO";
//conexion sqlserver

$serverName = "10.10.0.5\sqlexpress"; //serverName\instanceName
$connectionInfo = array( "Database"=>"dbName", "UID"=>"userName", "PWD"=>"password");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
 echo "Conexión establecida.<br />";
 }else{
 echo "Conexión no se pudo establecer.<br />";
 die( print_r( sqlsrv_errors(), true));
}*/
/*$serverName = "10.10.0.5"; //serverName\instanceName
$connectionInfo = array( "Database"=>"SqlIntegrator", "UID"=>"sa", "PWD"=>"%19Sis60Tem@s17");
$conn = sqlsrv_connect( $serverName, $connectionInfo);*/
/*$server="10.10.0.5";
$database="SqlIntegrator";
$user="sa";
$password="%19Sis60Tem@s17";
$connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$server;Database=$database;", $user, $password);

if ($connection){
    echo "conectado";
}else{
    echo "no conectado".odbc_errormsg();
}*/
/*$msconnect=mssql_connect("10.10.0.5","sa","%19Sis60Tem@s17");
$msdb=mssql_select_db("SqlIntegrator",$msconnect);
$msquery = "select * from zAgroPremios2018";
$msresults= mssql_query($msquery);
if($row = mssql_fetch_array($msresults)){
    echo "conectado";
}
*/
/*
$localhostL 	= 	'10.10.0.5'	; 	$userA 		= 	'sa'	;
$claveO		=	'%19Sis60Tem@s17'; 	$base_datosL	=	'SqlIntegrator'	;
//      $linklAo = mysql_connect($localhostL, $userA, $claveO);
//      mysql_select_db($base_datosL ,$linklAo);
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: ";
  //echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
*/

//exit();    
//CONECCION DB2
include("../user_con.php");


//echo $localhostL." --- ".$claveO;
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style type="text/css">
        .centrador{
          box-sizing: border-box;
          border-color: #ffffff;
          display: block;
          width: 100%;
          margin: 0 0 auto;
          margin-top: 15px;
          text-align: center;
          border-radius: 5px 5px 5px 5px;
        }
        </style>
        <meta charset="utf-8" />
        <script src="js/jquery-1.9.1.min.js"></script>
        <LINK href="css/estilos.css" rel="stylesheet" type="text/css">
        <title>FORMULARIO PLAN A&Ntilde;O 2019</title>
        <script language="JavaScript">
            function checkKeyCode(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if (event.keyCode == 116) {
                    evt.keyCode = 0;
                    return false
                }
            }
            document.onkeydown = checkKeyCode;

            function saltarObjeto(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if (event.keyCode == 13) {
                    document.getElementById('B1').focus();
                    
                }
            }

            function consultarDatos() {
                var d1 = document.getElementById('T1').value;
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'buscarplan.php?d1=' + d1, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            if (dato.length <= 2 || dato.length == 20) {
                                alert("Datos no encontrados!");
                                LimpiarFormulario();
                                //document.getElementById('T1').value = '';
                                //document.getElementById('T1').focus();
                                return false;
                            } else {
                                var datos = dato.split('^');
                                document.getElementById('nplan').innerHTML = 'REGISTRO PLAN A&Ntilde;O 2019 #:' + datos[0];
                                document.getElementById('T2').value = datos[2];
                                document.getElementById('T3').value = datos[3];
                                document.getElementById('F').value = datos[4];
                                document.getElementById('T4').value = datos[13];
                                document.getElementById('T5').value = datos[14];
                                document.getElementById('T6').value = datos[15];
                                document.getElementById('T7').value = datos[16];
                                document.getElementById('T8').value = datos[10];
                                document.getElementById('T9').value = datos[12];
                                document.getElementById('T10').value = datos[11];
                                var monto = datos[8].replace('$', '');
                                monto = monto.replace('.', '');
                                monto = monto.replace('.', '');
                                if (isNaN(monto)){
                                    monto='0';
                                }
                                document.getElementById('T11').value = datos[8];
                                verCategorias(parseInt(monto));
                                consultarPremios();
                            }
                        }
                    }
                }
            }
            
            function seleccionarFoto(premio){
                var subCadena = premio.substring(0, premio.length-4);
                document.getElementById('Premio').value=subCadena;
            }
            
            function consultarPremios(){
                var d1 = document.getElementById('Categoria').value;
                var imagen='';
                if(d1=='A'){
                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/A/TV32.PNG" style="width: 98%;">';
                }else if(d1=='B'){
                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/B/TV40.PNG" style="width: 98%;">';
                }else if(d1=='C'){
                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/C/TV49.PNG" style="width: 98%;">';
                }else if(d1=='D'){
                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/D/LAVADORA18.PNG" style="width: 98%;">';
                }else if(d1=='E'){
                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/E/TV55.PNG" style="width: 98%;">';
                }else if(d1=='F'){
                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/F/IPAD.PNG" style="width: 98%">';
                }else if(d1=='G'){
                    parar=1;
                    imagen=imagen+'<div>';
                    imagen=imagen+'<img src="FOTOSPLAN/G/VIAJECANCUN.PNG" style="width: 98%;">&nbsp;&nbsp;';
                    imagen=imagen+'<input type="radio" name="G" value="VIAJECANCUN.PNG" style="width: 20px;" onclick="seleccionarFoto(this.value);">SELECCIONAR<br /><hr /><br />';
                    imagen=imagen+'<img src="FOTOSPLAN/G/TVCURVO65.PNG" style="width: 98%;">&nbsp;&nbsp;';
                    imagen=imagen+'<input type="radio" name="G" value="TVCURVO65.PNG" style="width: 20px;" onclick="seleccionarFoto(this.value);">SELECCIONAR<br /><hr /><br />';
                    imagen=imagen+'<img src="FOTOSPLAN/G/TRITURADOR.PNG" style="width: 98%;">';
                    imagen=imagen+'<input type="radio" name="G" value="TRITURADOR.PNG" style="width: 20px;" onclick="seleccionarFoto(this.value);">SELECCIONAR<br /><hr /><br />';
                    imagen=imagen+'</div>';
                    document.getElementById('fotosp').innerHTML = imagen;                                   
                }else{
                    document.getElementById('Premio').value='Sin Premio';
                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/sinpremio.png" style="width: 98%">';
                }
            }
            
            function consultarPremios2() {
                var d1 = document.getElementById('Categoria').value;
                var select = document.getElementById('Premio');
                var imagen='';
                var parar=0;
                while (select.length > 1) {
                    select.remove(1);
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
                peticion_http.open('POST', 'buscapremios.php?d1=' + d1, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            var datos = dato.split('^');
                            var tam = datos.length;
                            //carga options en un combo
                            select = document.getElementById('Premio');
                            for (var i = 0; i < tam - 1; i++) {
                                var opt = document.createElement('option');
                                opt.value = datos[i];
                                opt.innerHTML = datos[i];
                                select.appendChild(opt);
                                //carga imagenes premios
                                if(d1=='A'){
                                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/A/TV32.PNG" style="width: 98%;">';
                                }
                                if(d1=='B'){
                                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/B/TV40.PNG" style="width: 98%;">';
                                }
                                if(d1=='C'){
                                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/C/TV49.PNG" style="width: 98%;">';
                                }
                                if(d1=='D'){
                                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/D/LAVADORA18.PNG" style="width: 98%;">';
                                }
                                if(d1=='E'){
                                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/E/TV55.PNG" style="width: 98%;">';
                                }
                                if(d1=='F'){
                                    document.getElementById('fotosp').innerHTML = '<img src="FOTOSPLAN/F/IPAD.PNG" style="width: 98%">';
                                }
                                if(d1=='G' && parar==0){
                                    parar=1;
                                    imagen=imagen+'<div>';
                                    imagen=imagen+'<img src="FOTOSPLAN/G/VIAJECANCUN.PNG" style="width: 98%;">&nbsp;&nbsp;';
                                    imagen=imagen+'<input type="radio" name="G" value="VIAJECANCUN.PNG" style="width: 20px;" onclick="seleccionarFoto(this.value);">SELECCIONAR<br /><hr /><br />';
                                    imagen=imagen+'<img src="FOTOSPLAN/G/TVCURVO65.PNG" style="width: 98%;">&nbsp;&nbsp;';
                                    imagen=imagen+'<input type="radio" name="G" value="TVCURVO65.PNG" style="width: 20px;" onclick="seleccionarFoto(this.value);">SELECCIONAR<br /><hr /><br />';
                                    imagen=imagen+'<img src="FOTOSPLAN/G/TRITURADOR.PNG" style="width: 98%;">';
                                    imagen=imagen+'<input type="radio" name="G" value="TRITURADOR.PNG" style="width: 20px;" onclick="seleccionarFoto(this.value);">SELECCIONAR<br /><hr /><br />';
                                    imagen=imagen+'</div>';
                                    document.getElementById('fotosp').innerHTML = imagen;
                                    
                                }
                            }
                        }
                    }
                }
            }

            function guardarDatos() {
                var d1 = document.getElementById('T1').value;
                var d2 = document.getElementById('T2').value;
                var d3 = document.getElementById('T3').value;
                var d4 = document.getElementById('T4').value;
                var d5 = document.getElementById('T5').value;
                var d6 = document.getElementById('T6').value;
                var d6b = document.getElementById('T6b').value;
                var d7 = document.getElementById('T7').value;
                var d8 = document.getElementById('T8').value;
                var d9 = document.getElementById('T9').value;
                var d10 = document.getElementById('T10').value;
                var d11 = document.getElementById('T11').value;
                var d12 = document.getElementById('Categoria').value;
                var df = document.getElementById('F').value;
                var dp = document.getElementById('Premio').value;
                if (d6b.length <= 0) {
                    alert("Digite el número de telefono actualizado");
                    return false;
                }
                if (d1.length <= 0) {
                    alert("Digite número de identificacion y haga clic en Validar.");
                    return false;
                }
                if (d2.length <= 0) {
                    alert("Falta nombre, digite número de identificacion y haga clic en Validar.");
                    return false;
                }
                /*if (dp.length <= 0) {
                    alert("Seleccione un premio dando clic en el boton inferior de cada imágen.");
                    return false;
                }*/
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'guardadat.php?d1=' + d1 + '&d2=' + d2 + '&d3=' + d3 + '&d4=' + d4 + '&d5=' + d5 + '&d6=' + d6 + '&d6b=' + d6b + '&d7=' + d7 + '&d8=' + d8 + '&d9=' + d9 + '&d10=' + d10 + '&d11=' + d11 + '&d12=' + d12 + '&df=' + df + '&dp=' + dp, true);
                peticion_http.send(null);

                function muestraContenido() {
                    //alert(dato1);
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            GuardarTrazado();
                            alert(dato);
                            //setTimeout("location.reload(true);", 500);
                        }
                    }
                }
            }


            function LimpiarFormulario() {
                document.getElementById('T1').value = '';
                document.getElementById('T2').value = '';
                document.getElementById('T3').value = '';
                document.getElementById('T4').value = '';
                document.getElementById('T5').value = '';
                document.getElementById('T6').value = '';
                document.getElementById('T6b').value = '';
                document.getElementById('T7').value = '';
                document.getElementById('T8').value = '';
                document.getElementById('T9').value = '';
                document.getElementById('T10').value = '';
                document.getElementById('T11').value = '';
                document.getElementById('T12').value = '';
                document.getElementById('F').value = '';
                document.getElementById('Categoria').value = '';
                document.getElementById('Premio').value = '';
                document.getElementById('T1').focus();
            }

            function verCategorias(valor) {
                if (parseFloat(valor) > 12000000 && parseFloat(valor) < 20999999) {
                    document.getElementById("Categoria").value = 'A';
                } else if (parseFloat(valor) > 21000000 && parseFloat(valor) < 30999999) {
                    document.getElementById('Categoria').value = 'B';
                } else if (parseFloat(valor) > 31000000 && parseFloat(valor) < 40999999) {
                    document.getElementById('Categoria').value = 'C';
                } else if (parseInt(valor) > 41000000 && parseInt(valor) < 50999999) {
                    document.getElementById('Categoria').value = 'D';
                } else if (valor > 51000000 && valor < 70999999) {
                    document.getElementById('Categoria').value = 'E';
                } else if (parseFloat(valor) > 71000000 && parseFloat(valor) < 99999999) {
                    document.getElementById('Categoria').value = 'F';
                } else if (parseFloat(valor) > 100000000) {
                    document.getElementById('Categoria').value = 'G';
                } else {
                    document.getElementById('Categoria').value = 'N';
                }
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

            function checkmail(input) {
                if (input.value != document.getElementById('correo').value) {
                    alert('Los email estan diferentes, verifique.');
                    //document.getElementById('ema2').focus();
                } else {
                    input.setCustomValidity('');
                }
            }
            //comprueba un email valido
            var good;
            function checkEmailAddress(field) {
                if (field.value.length > 0) {
                    var goodEmail = field.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi);
                    if (goodEmail) {
                        good = true;
                    } else {
                        alert('Por favor introduce un e-mail valido');
                        field.value = '';
                        field.focus();
                        good = false;
                    }
                }
            }

            function copiaNum(id) {
                document.getElementById('imagenom').value = id;
            }

            </script>
    </head>
    <body>
       
        <div class="centrarancho">
             <div id="wrapperHeader">
                 <div id="header">
                  <img src="images/head.png" alt="logo" />
                 </div>
                 <div id="header2" style="text-align: center;">
                  <img src="images/Registro.png" alt="logo" width="8%;" />
                     <label id="nplan" style="font-size: 18pt; font-weight: bold; font-family: ITC Avant Garde Gothic;font-style: italic; color: #ffffff;">REGISTRO PLAN A&Ntilde;O 2019</label><div ></div><br />
                     <label style="font-size: 11pt; font-weight: bold;font-family: ITC Avant Garde Gothic;font-style: italic;color: #ffffff;">INGRESE N&Uacute;MERO DE C&Eacute;DULA o NIT REGISTRADO CON AGROCAMPO Y LUEGO CLIC EN VALIDAR</label>
                 </div> 
            </div>
            &nbsp;
           
            <div class="centerTable">
            <!--tabla de datos-->
            <div class='centrador'>
            
            <table id="Table1" class="tabla">
               <tr><td colspan="3">&nbsp;</td></tr>
               <tr>
                   <td style="width: 2%">&nbsp;</td>
                   <td style="width: 40%"><label style="font-size: 14pt" class="etiqueta1">C&eacute;dula / Nit</label></td>
                   <td><input type="text" ID="T1" name="T1" onkeyUp="return ValNumero(this);" maxlength="11" class="texto1" onblur="copiaNum(this.value);" onkeypress="saltarObjeto(event);" autofocus="true" autocomplete="off" required></td>
              </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
               <tr>
                   <td style="width: 5%">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td><input type="button" ID="B1" name="B1" class="botong" onclick="consultarDatos();" value="VALIDAR">&nbsp;&nbsp;<input type="button" ID="B1" name="B1" onclick="LimpiarFormulario();" class="botong" value="REFRESCAR"></td>  
               </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Nombre Cliente</label></td>
                   <td><input type="text" ID="T2" name="T2" maxlength="40" class="texto2" autocomplete="off" readonly="true"></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Nombre Establecimiento</label></td>
                   <td><input type="text" ID="T3" name="T3" maxlength="60" class="texto2" autocomplete="off" readonly="true"></td>  
               </tr>
                <tr><td colspan="3"></td></tr>
               <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Direcci&oacute;n</label></td>
                   <td><input type="text" ID="T4" name="T4" maxlength="60" class="texto2" autocomplete="off"></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td><input type="text" ID="F" name="F" class="texto2" style="width: 30px; visibility: hidden;" autocomplete="off"></td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Barrio</label></td>
                   <td><input type="text" ID="T5" name="T5" maxlength="20" class="texto2" autocomplete="off"></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Tel&eacute;fono</label></td>
                   <td><input type="text" ID="T6" name="T6" maxlength="12" onkeyUp="return ValNumero(this);" class="texto2" autocomplete="off" readonly="true"></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Actualice Tel&eacute;fono *</label></td>
                   <td><input type="text" ID="T6b" name="T6b" maxlength="12" onkeyUp="return ValNumero(this);" class="texto2" autocomplete="off"></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
               <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Celular</label></td>
                   <td><input type="text" ID="T7" name="T7" maxlength="12" onkeyUp="return ValNumero(this);" class="texto2" autocomplete="off"></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Email</label></td>
                   <td><input type="text" ID="T8" name="T8" maxlength="60" onblur="return checkEmailAddress(this);" class="texto2" autocomplete="off"></td>
                </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Departamento</label></td>
                   <td><input type="text" ID="T9" name="T9" maxlength="20" class="texto2" autocomplete="off" readonly="true"></td>
                </tr>
                <tr><td colspan="3"></td></tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Minicipio</label></td>
                   <td><input type="text" ID="T10" name="T10" maxlength="30" class="texto2" autocomplete="off" readonly="true"></td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">OBJETIVO DE COMPRAS 2019</label></td>
                   <td><input type="text" ID="T11" name="T11" maxlength="11" class="texto1" style="text-align: right;" readonly="true"></td>
                </tr>
                
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Premio</label></td>
                   <td>
                   <!--<select id="Premio" name="Premio" class="combolargo"></select>-->
                   <input type="text" id="Premio" name="Premio" class="texto2" readonly="true"/> 
                   </td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <td>&nbsp;</td>
                   <td colspan="2"><div id="fotosp" style="text-align: center; float: left;"></div></td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td colspan="3">
                <!--Firma manuscrita-->
            <form id='formCanvas' name="formCanvas" method='post' ENCTYPE='multipart/form-data' action="#">
                <div class='centrador'>
                    <label style="font-size: 11pt; font-weight: bold;font-family: ITC Avant Garde Gothic;font-style: italic;">FIRMA CLIENTE</label><br />
                  <canvas id='canvas' width="500" height="200" style='border: 1px solid #CCC; box-shadow: inset 3px 3px 3px rgba(255,255,255,.7), inset 2px 2px 3px rgba(0,0,0,.1), 2px 2px 3px rgba(0,0,0,.1); background-color: #fff; color: #000;'>
                    <p>Tu navegador no soporta canvas</p>
                  </canvas><br />

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' onclick='LimpiarTrazado()'>Borrar</button>
                    <!--<button type='button' onclick='GuardarTrazado()'>Guardar</button>-->
                    <button type='button' style="visibility: hidden;" onclick="guardarDatos();">Guardar</button>
                    <input type="hidden" name="imagen" id="imagen" />
                    <input type="hidden" name="imagenom" id="imagenom" />
                </div>
                <?php
                    // comprovamos si se envió la imagen
                    if (isset($_POST['imagen'])) { 
                        // mostrar la imagen
                        //echo '<img src="'.$_POST['imagen'].'" border="1">';
                        $nombre=$_POST['imagenom'];
                        // funcion para gusrfdar la imagen base64 en el servidor
                        // el nombre debe tener la extension
                        function uploadImgBase64 ($base64, $name){
                            // decodificamos el base64
                            $datosBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                            // definimos la ruta donde se guardara en el server
                            //$path= $_SERVER['DOCUMENT_ROOT'].'/firmas/'.$name;
                            $path='firmas/'.$name;
                            //echo $path;
                            // guardamos la imagen en el server
                            if(!file_put_contents($path, $datosBase64)){
                                // retorno si falla
                                return false;
                            }
                            else{
                                // retorno si todo fue bien
                                return true;
                            }
                        }
                        // llamamos a la funcion uploadImgBase64( img_base64, nombre_fina.png) 
                        //uploadImgBase64($_POST['imagen'], 'mi_imagen_'.date('d_m_Y_H_i_s').'.png' );
                        uploadImgBase64($_POST['imagen'], $nombre.'.png' );
                    }
                ?>
                    
                </form>
                </td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td style="width: 5%">&nbsp;</td>
                    <td colspan="2" style="text-align: center;"><div style="font-size: 10pt;font-family: ITC Avant Garde Gothic; text-align: justify; width: 90%;">
                &nbsp;&nbsp;&nbsp;&nbsp;<img src="images/textoplan.PNG" />
                </div>
                </td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
               <tr>
                   <td colspan="3" style="text-align: center"><input type="button" ID="Enviarf" name="Enviarf" onclick="guardarDatos();" class="botong" value="GENERAR PLAN" style="width: 200px;"></td>  
               </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1" style="visibility: hidden;">&nbsp;</label></td>
                   <td>
                   <input type="text" ID="Categoria" name="Categoria" class="texto1" autocomplete="off" style="text-align: center; width: 100px; visibility: hidden;" readonly="true">
                   </td>
                </tr>
               </table >  
                
        </div>             
            </div>
          
                    <script type="text/javascript">
                        /* Variables de Configuracion */
                        var idCanvas = 'canvas';
                        var idForm = 'formCanvas';
                        var inputImagen = 'imagen';
                        var estiloDelCursor = 'crosshair';
                        var colorDelTrazo = '#555';
                        var colorDeFondo = '#fff';
                        var grosorDelTrazo = 2;

                        /* Variables necesarias */
                        var contexto = null;
                        var valX = 0;
                        var valY = 0;
                        var flag = false;
                        var imagen = document.getElementById(inputImagen);
                        var anchoCanvas = document.getElementById(idCanvas).offsetWidth;
                        var altoCanvas = document.getElementById(idCanvas).offsetHeight;
                        var pizarraCanvas = document.getElementById(idCanvas);

                        /* Esperamos el evento load */
                        window.addEventListener('load', IniciarDibujo, false);

                        function IniciarDibujo() {
                            /* Creamos la pizarra */
                            pizarraCanvas.style.cursor = estiloDelCursor;
                            contexto = pizarraCanvas.getContext('2d');
                            contexto.fillStyle = colorDeFondo;
                            contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
                            contexto.strokeStyle = colorDelTrazo;
                            contexto.lineWidth = grosorDelTrazo;
                            contexto.lineJoin = 'round';
                            contexto.lineCap = 'round';
                            /* Capturamos los diferentes eventos */
                            pizarraCanvas.addEventListener('mousedown', MouseDown, false);
                            pizarraCanvas.addEventListener('mouseup', MouseUp, false);
                            pizarraCanvas.addEventListener('mousemove', MouseMove, false);
                            pizarraCanvas.addEventListener('touchstart', TouchStart, false);
                            pizarraCanvas.addEventListener('touchmove', TouchMove, false);
                            pizarraCanvas.addEventListener('touchend', TouchEnd, false);
                            pizarraCanvas.addEventListener('touchleave', TouchEnd, false);
                        }

                        function MouseDown(e) {
                            flag = true;
                            contexto.beginPath();
                            valX = e.pageX - posicionX(pizarraCanvas); valY = e.pageY - posicionY(pizarraCanvas);
                            contexto.moveTo(valX, valY);
                        }

                        function MouseUp(e) {
                            contexto.closePath();
                            flag = false;
                        }

                        function MouseMove(e) {
                            if (flag) {
                                contexto.beginPath();
                                contexto.moveTo(valX, valY);
                                valX = e.pageX - posicionX(pizarraCanvas); valY = e.pageY - posicionY(pizarraCanvas);
                                contexto.lineTo(valX, valY);
                                contexto.closePath();
                                contexto.stroke();
                            }
                        }

                        function TouchMove(e) {
                            e.preventDefault();
                            if (e.targetTouches.length == 1) {
                                var touch = e.targetTouches[0];
                                MouseMove(touch);
                            }
                        }

                        function TouchStart(e) {
                            if (e.targetTouches.length == 1) {
                                var touch = e.targetTouches[0];
                                MouseDown(touch);
                            }
                        }

                        function TouchEnd(e) {
                            if (e.targetTouches.length == 1) {
                                var touch = e.targetTouches[0];
                                MouseUp(touch);
                            }
                        }

                        function posicionY(obj) {
                            var valor = obj.offsetTop;
                            if (obj.offsetParent) valor += posicionY(obj.offsetParent);
                            return valor;
                        }

                        function posicionX(obj) {
                            var valor = obj.offsetLeft;
                            if (obj.offsetParent) valor += posicionX(obj.offsetParent);
                            return valor;
                        }

                        /* Limpiar pizarra */
                        function LimpiarTrazado() {
                            contexto = document.getElementById(idCanvas).getContext('2d');
                            contexto.fillStyle = colorDeFondo;
                            contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
                        }

                        /* Enviar el trazado */
                        function GuardarTrazado() {
                            imagen.value = document.getElementById(idCanvas).toDataURL('image/png');
                            document.forms[idForm].submit();
                        }
                    </script>
            <!--finfirma-->
  </div>      
    </body>
</html>
