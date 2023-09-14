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
                document.getElementById('estado').innerHTML = '<a href="/'+valor+'" target="_new"><h4>Descargar Informe</h4></a>';
            }
                  
      
            
            function VerificarOrdenIBS() {
                //var dia=document.getElementById('d').value;
                //var mes=document.getElementById('m').value;
                //var anio=document.getElementById('a').value;
                var sequence=document.getElementById('sequence').value;
                if(sequence==""){
                    alert('Digite un Sequence de Pedido.');
                    return false;
                }
              
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/radar.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
                    peticion_http.open('POST', 'buscaordenesibs.php?sq=' + sequence, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                //alert(dato);
                                document.getElementById('resultado').innerHTML=dato;
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                                document.getElementById('sequence').value='';
                                document.getElementById('sequence').focus();
                                //setTimeout("location.reload(true);", 500);
                            }
                        }
                    }    
            }
            
            function VerificarOrdenMagento() {
                var sequence=document.getElementById('sequence').value;
                if(sequence==""){
                    alert('Digite un Sequence de Pedido.');
                    return false;
                }
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/radar.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
                    peticion_http.open('POST', 'verifica_orden_magento.php?sq=' + sequence, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                //alert(dato);
                                document.getElementById('resultado').innerHTML=dato;
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                                document.getElementById('sequence').value='';
                                document.getElementById('sequence').focus();
                                //setTimeout("location.reload(true);", 500);
                            }
                        }
                    }    
            }
            
            function ConsultarListaIngresos() {            
                    var sede=document.getElementById('sede').value;
                    var fi=document.getElementById('fi').value;
                    var ff=document.getElementById('ff').value;
                    
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/radar.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'buscaingresoslista.php?sede=' + sede + '&fi=' + fi + '&ff=' + ff, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                document.getElementById('resultado').innerHTML='Archivo Generado';
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                                verLink(dato);
                                //setTimeout("location.reload(true);", 500);
                            }
                        }
                    }    
            }
            
            function contador(){
                var n = 180000;
                var x = 0;
                var r = 0;
                var l = document.getElementById("number");
                x=(n/60000);
                //r=Math.round(x);
                l.innerHTML = 'Tiempo: ' + x + ' min';
                window.setInterval(function(){
                  x=n/60000;
                  //x2=parseFloat(x).toFixed(1); 
                  //r=Math.roun d(x);  
                  l.innerHTML = 'Tiempo: ' + x + ' min';
                  n--;
                  if(n<=0){
                      document.getElementById('OrdFal').style.visibility='visible';
                      n=0;
                      window.setInterval(function(){
                            l.innerHTML = 'Tiempo: ' + (n/60000);
                            n=0;
                       },0);
                  }
                },60000);
            }
            
            function activarOrden(secuencia) { 
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/radar.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'activarOrden.php?s=' + secuencia , true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                //alert(dato);
                                document.getElementById('respuesta').innerHTML=dato;
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                                //document.getElementById('OrdFal').style.visibility='hidden';
                                //contador();
                                //setTimeout("location.reload(true);", 500);
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
                            <br /><img class="responsive-img center " src="img/logoAG.png" width="160vw;" /><br />
                        </div>
                        <div class="col s6 m4 l10 xl8 blue lighten-2 ">
                            <br /><div class="flow-text" style="font-size:3vw;text-align:right;">REPORTE DE INGRESO</div>
                        </div>
                </div>
                <div class="row blue lighten-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
             </div>
             
             <div class="col s6 m6 l12 xl3 gray lighten-2">
                <!--<nav>
                    
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
                </nav>-->
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
                                 <span style="color: #000000;">TOMA DE TEMPERATURAS</span>
                             </div>
                            
                            <table style="width: 98%; background-color: #FFFFFF;">
                            
                            <tr>
                            <td style="width: 30%;">
                            <!--CDCDCD
                            <span style="color: #000000;"><b>Seleccione Fecha</b></span><br />
                            <select id="d" class="browser-default light-blue-text" style="width: 200hw;">
                                <option value="" disabled selected>D&iacute;a </option>
                                <?php
                                /*$dia=1;
                                while($dia<=31){
                                    if ($dia<10){
                                        $dia='0'.$dia;
                                    }
                                    echo "<option value=\"$dia\">$dia</option>";
                                    $dia++;
                                }*/
                                ?>
                          </select>
                          -->
                          </td>
                            
                          </tr>
                          </table>
                          
                          
                          
                          <!--inicio-->
                          <div style="width: 98%; background-color: #024C68;">
                            <br />
                                    <label style="font-size: 1.2em; font-weight: bold;">SEDE:</label>
                                    <center><select id="sede" class="browser-default light-blue-text" style="width: 30%;">
                                        <option value="CALLE 73">CALLE 73</option>
                                        <option value="PORTOS">PORTOS</option>
                                    </select></center>
                                    <label style="color: White; font-size: 1.2em;">Fecha Inicial (AAAA-mm-dd): </label><input type="text" id="fi" style="font-weight: bold; width: 150px; color: #21EDDA; font-size: 1.2em;" autofocus="true" /><br /> 
                                    <label style="color: White; font-size: 1.2em;">Fecha Final (AAAA-mm-dd): </label><input type="text" id="ff" style="font-weight: bold; width: 150px; color: #21EDDA; font-size: 1.2em;" />
                                    <br />                                
                                    <input type="submit" onclick="ConsultarListaIngresos();" class="waves-efect waves-light btn" name="Enviar" value="Consultar Ingresos" /><br /><br />
                            </div><br />
                          <div style="width: 98%; background-color: #024C68;">
                          
                          
                          </div><br />
                              
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
                   <div id="respuesta" style="width: 99%; text-align: center; background-color: #90CAF9; color: green; font-weight: bold;">
                            
                   </div><hr />                  
                   <div id="resultado" style="width: 99%; text-align: center; background-color: #90CAF9;">
                            
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
         <div id="formu" class="col s3 m3 l4 xl4" style="width: 200hw;">
         
         </div>
         <div id="estado" class="col s3 m3 l2 xl3" style="width: 200hw;">
         
         </div>
     </div>
     
        
      <!--fin container-->  
    </div>
    
    
    
</body>
</html>