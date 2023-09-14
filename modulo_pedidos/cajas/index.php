<?php
    if(session_start()===FALSE){
        session_start();
    }
    //echo $_SESSION['usuARio'];
    if($_SESSION['usuARio'] == '' OR $_SESSION['clAVe'] == '')
    {
        header("location:user_conect.php"); die;
    }
      /*
  //VER USU
    $lOGin= sha1(date("Y-m-d:H"));  
    $loginBO = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
    
    $pASs=  sha1(date("H:Y-m-d"));
    $passBO = trim(mb_strtoupper($_POST["$pASs"]));
  
  $emP = "";
  //ODBC
  $handle = odbc_connect('IBM-AGROCAMPO-P',$loginBO,$passBO);
  //CONSULTA
  $result = odbc_exec($handle, "select UPUSER from SRBUSP where UPUSER = '$loginBO'");
  while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='AG- AGROCAMPO'; $emP = "DeNtR";
        }
  */
  /*$sql ="select UPHAND from SROUSP WHERE UPUSER = '$_SESSION[usuARio]'";
  $result = odbc_exec($db2conp, $sql);
  if($row = odbc_fetch_array($result)){
  	 
      }
      */
?>
<!DOCTYPE html>
<html>
 
<head>
<style>
th, td {
   border: 1px solid #000;
   border-spacing: 0;
}
</style>    
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
 
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
 
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 
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

            
            function Popup(valor) {
                var windowName = 'userConsole';
                var popUp = window.open(valor, '_blank', '');
                if (popUp == null || typeof (popUp) == 'undefined') {
                    alert('Por favor deshabilita el bloqueador de ventanas emergentes.');
                }
                else {
                    popUp.focus();
                }
            }
                        
            function verLink(valor) {
                document.getElementById('estado').innerHTML = '<a href="pdf/'+valor+'" target="_new"><h4>Descargar Informe</h4></a>';
            }
                  
      
            
            function buscarFactura() {
                    var factura=document.getElementById('sequence').value;
                    var company=document.getElementById('company').value;
                    if(company !='AG' && company !='X1' && company !='ZZ'){
                        alert("Seleccione Compañia");
                        return false;
                    }
                    if(factura == ''){
                        alert("Digite Factura");
                        return false;
                    }
                    document.getElementById('resultado').innerHTML='';
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/radar.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    document.getElementById('respuesta').innerHTML='';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'consultarFacturas.php?fac=' + factura + '&emp=' + company, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                var datos=dato.split('^');
                                var Cajas=0;
                                if(datos[0] == 'true' || datos[0]==true){
                                    Cajas='Numero Cajas Actual: ' + datos[1]; 
                                } else {
                                    Cajas='FACTURA NO ENCONTRADA EN LA COMPA&Ntilde;IA SELECCIONADA!'; 
                                }
                                document.getElementById('resultado').innerHTML = Cajas;
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                                if(datos[0] == 'true' || datos[0]==true){
                                    document.getElementById('t1').style.visibility='visible';
                                    document.getElementById('newcajas').style.visibility='visible';
                                    document.getElementById('Guardar').style.visibility='visible';
                                }else{
                                    document.getElementById('t1').style.visibility='hidden';
                                    document.getElementById('newcajas').style.visibility='hidden';
                                    document.getElementById('Guardar').style.visibility='hidden';
                                }
                                document.getElementById('newcajas').focus();
                            }
                        }
                    }    
            }
            
            
            function guardarCajas() {
                    var factura=document.getElementById('sequence').value;
                    var company=document.getElementById('company').value;
                    var cajas=document.getElementById('newcajas').value;
                    if(company !='AG' && company !='X1' && company !='ZZ'){
                        alert("Seleccione Compañia");
                        return false;
                    }
                    if(factura == ''){
                        alert("Digite Factura");
                        return false;
                    }
                    if(parseInt(cajas) <= 0 || cajas==''){
                        alert("Digite numero de cajas Cajas");
                        return false;
                    }
                    document.getElementById('resultado').innerHTML='';
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/radar.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    document.getElementById('respuesta').innerHTML='';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'guardarCajas.php?fac=' + factura + '&emp=' + company + '&caj=' + cajas, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert(dato);
                                //document.getElementById('resultado').innerHTML=dato;
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                                                             
                                setTimeout("location.reload(true);", 500);
                            }
                        }
                    }    
            }
            
            
        
        
            function ocultarBoton(secuencia){
                document.getElementById('ActivarOd'+secuencia).style.visibility='hidden';
                return true;
            }
            
            
            
            function Salir(){
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'cerrarSesion.php' , true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert("Usted a salido.");
                                setTimeout("location.reload(true);", 500);
                                location.href="user_conect.php";
                            }
                        }
                    }    
            }
        
        
    
    </script>
    
   
</head>
 <!--style="background-image: url(img/matrix.gif);"-->
<body class="gray">
 
    <div class="container">
        <div class="row blue lighten-2">
            <!--menu izq-->
             <div class="col s6 m6 l12 xl12 blue lighten-3">
                <div class="nav-wrapper red lighten-2 white-text bordes">
                &nbsp;
                </div>
             </div>
            
             <div class="col s7 m12 l12 xl12 blue lighten-2">
                <div class="row blue lighten-2 left">
                        <div class="col s6 m2 l2 xl8 blue lighten-2">
                            <br /><img class="responsive-img center " src="img/logoAG.png" width="100vw;" /><br />
                        </div>
                        <div class="col s6 m4 l10 xl8 blue lighten-2 ">
                            <br /><div class="flow-text" style="font-size:3vw;text-align:right;">CAMBIO DE CAJAS</div>
                        </div>
                </div>
                <!--<div class="row blue lighten-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>-->
             </div>
             
             <div class="col s6 m6 l12 xl3 gray lighten-2">
                <nav>
                    <div class="nav-wrapper red lighten-2 white-text bordes">
                        <a href="#" class="brand-logo hide-on-med-and-down">
                            <div class="flow-text" style="font-size:3vw;">&nbsp;</div>
                        </a>
                        <div style="font-size:1vw;text-align:center;">
                        <ul id="nav-mobile" class="right">
                            <li><a href="javascript:Salir()">Salir</a></li>
                        </ul>
                        </div>
                    </div>
                </nav>
            </div>
                
           </div>  
               
               
                <div class="row">
                    
                    <div class="row white center">
                        <div class="col s6 m12 l12 xl12 offset-12 center">
                         
                        <div class="row center blue lighten-3">
                            <div class="col s12 m3 l3 xl12 center ">
                            
                            </div>
                            <div class="col s12 m7 l6 xl12 blue lighten-2 white-text">
                             <div class="flow-text" style="font-size:1.5vw;text-align:center;">
                                 <span style="color: #000000;">ACTUALIZAR CAJAS</span>
                             </div>
                            
                                                     
                                                    
                          <!--inicio-->
                          <div style="width: 98%; background-color: #09677F;">
                          
                          <br />
                                  
                          <label style="color: White; font-size: 1.2em;">Buscar Factura: </label><input type="text" id="sequence" onkeyUp="return ValNumero(this);"  style="font-weight: bold; width: 130px; color: #21EDDA; font-size: 1.2em;" autofocus="true" /> <br />                                
                          </div><br />
                          <div style="width: 98%; background-color: #024C68;"><br />  
                                    
                                    <center><select id="company" class="browser-default light-blue-text" style="width: 250px;">
                                    <option value="Seleccione" disabled selected >Seleccione Compa&ntilde;ia</option>
                                    <option value="AG">AGROCAMPO</option>
                                   <option value="X1">PESTAR</option>
                                    <option value="ZZ">COMERVET</option>
                                    </select></center>
                                    <br /><br />
                                    
                                    <input type="submit" onclick="buscarFactura();" class="waves-efect waves-light btn" name="Enviar" value="Buscar" /><br /><br />
                                    
                                    
                          </div><br />
                          
                          <br />
                                  
                          <label id="t1" style="color: White; font-size: 1.2em; visibility: hidden;">Digite nueva cantidad de cajas: </label><input type="text" maxlength="2" id="newcajas" onkeyUp="return ValNumero(this);" style="font-weight: bold; text-align: center; background-color: white; width: 50px; color: #21EDDA; font-size: 1.2em; visibility: hidden;" /> <br />
                          <br /><br />
                                    
                                    <input type="submit" onclick="guardarCajas();" class="waves-efect waves-light btn" id="Guardar" name="Guardar" style="visibility: hidden;" value="Actualizar" /><br /><br />                      
                          <!--final-->
                          </div>
                          
                        </div>
                        
                        <!--class="row blue lighten-3"-->
                        <div>
                            <div class="col center">
                            <center>
                            
                            </center>
                            </div>
                        </div> 
                          
      
                        </div>
                    
                    </div>
                   <div id="number"></div> 
                   <!--class="col s3 m3 l4 xl4"-->
                   <div id="formu" style="width: 200hw;">
         
                    </div>
                   <div id="respuesta" style="width: 100%; text-align: center; background-color: #90CAF9; color: red; font-weight: bold;">
                            
                   </div>
                   <div id="resultado" style="width: 100%; text-align: center; font-size: 1.5em; font-weight: bold; color: blue;">
                            
                   </div>
                   <hr />
                   <div id="resultado1" style="width: 100%; text-align: center; background-color: #90CAF9; color: red; font-weight: bold; visibility: hidden;">
                       
                   </div>
                                     
                   
                    
                </div>
    <!--subir vistas ventas y compras-->
    <div class="flow-text" style="font-size:1.5vw;text-align:center;">
        <div class="col s3 m3 l2 xl2 hide-on-med-and-down" style="width: 200hw;">
        
      </div>
    </div>
          <!--formulario-->
     <div class="row">
         <div id="formv" class="col s3 m3 l3 xl3 hide-on-med-and-down" style="width: 200hw;">
            &nbsp;
         </div>
         
         <div id="estado" class="col s3 m3 l2 xl3" style="width: 200hw;">
         
         </div>
     </div>
     
        
      <!--fin container-->  
    </div>
    
    
    
</body>
</html>