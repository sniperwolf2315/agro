<?php
    if(session_start()===FALSE){
        session_start();
    }
    //echo $_SESSION['usuARio'];
    //if($_SESSION['usuARio'] == '' OR $_SESSION['clAVe'] == '')
    //{
        //header("location:user_conect.php"); die;
    //}
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
                  
      
            
            function VerificarOrdenIBS() {
                //var dia=document.getElementById('d').value;
                //var mes=document.getElementById('m').value;
                //var anio=document.getElementById('a').value;
                document.getElementById('resultado1').style.visibility='hidden';
                document.getElementById('resultado').innerHTML='';
                var sequence=document.getElementById('sequence').value;
                if(sequence==""){
                    alert('Digite un Sequence Orden Pagina o numero de Orden.');
                    return false;
                }
                /*if(dia=="Dia" || dia==""){
                    alert('Seleccione dia');
                    return false;
                }
                if(mes=="Mes" || mes==""){
                    alert('Seleccione mes');
                    return false;
                }
                if(anio=="A�o" || anio==""){
                    alert('Seleccione a�o');
                    return false;
                }*/
                //var fecha = anio+mes+dia;
                //var sequ='100068945'
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
                    peticion_http.open('POST', 'buscarOrdenIBS.php?sq=' + sequence, true);
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
                document.getElementById('resultado').innerHTML='';
                var dia=document.getElementById('dd').value;
                var mes=document.getElementById('mm').value;
                var anio=document.getElementById('yy').value;
                if(sequence=="" && (dia=="Dia" || mes == "Mes")){
                    alert('Seleccione una fecha');
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
                    peticion_http.open('POST', 'verifica_orden_magento.php?sq=' + sequence + '&di=' + dia + '&me=' + mes + '&an=' + anio, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                //alert(dato);
                                document.getElementById('resultado1').style.visibility='hidden';
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
            
            function VerificarOrdenIBSLista() {
                    document.getElementById('resultado1').style.visibility='hidden';
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
                    peticion_http.open('POST', 'buscaordenesibslista.php', true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                document.getElementById('resultado').innerHTML=dato;
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
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
             <div class="col s12 m6 l12 xl12 blue lighten-3">
                <div class="nav-wrapper red lighten-2 white-text bordes">
                &nbsp;
                </div>
             </div>
            
             <div class="col s12 m12 l12 xl12 blue lighten-2">
                <div class="row blue lighten-2 left">
                        <div class="col s6 m2 l2 xl8 blue lighten-2">
                            <br /><img class="responsive-img center " src="img/reporte.png" width="160vw;" /><br />
                        </div>
                        <div class="col s6 m4 l10 xl8 blue lighten-2 ">
                            <br /><div class="flow-text" style="font-size:3vw;text-align:right;">GESTI&Oacute;N DE ORDENES</div>
                        </div>
                </div>
                <div class="row blue lighten-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
             </div>
             
             <div class="col s12 m6 l12 xl3 gray lighten-2">
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
                        <div class="col s12 m12 l12 xl12 offset-12 center">
                         
                        <div class="row center blue lighten-3">
                            <div class="col s12 m3 l3 xl12 center ">
                            
                            </div>
                            <div class="col s12 m7 l6 xl12 blue lighten-2 white-text">
                             <div class="flow-text" style="font-size:1.5vw;text-align:center;">
                                 <span style="color: #000000;">VERIFICAR CARGUE DE ORDENES A IBS</span>
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
                          <div style="width: 98%; background-color: #09677F;">
                          
                          <br />
                                  
                                     <label style="color: White; font-size: 1.2em;">Buscar x Num-Magento u Orden IBS: </label><input type="text" id="sequence"  style="font-weight: bold; width: 130px; color: #21EDDA; font-size: 1.2em;" autofocus="true" /> <br />                                
                          </div><br />
                          <div style="width: 98%; background-color: #024C68;"><br />  
                                    <input type="submit" onclick="VerificarOrdenIBS();" class="waves-efect waves-light btn" name="Enviar" value="Verificar Orden en IBS" /><br /><br />
                                    
                                    
                          </div><br />
                          
                          <div style="width: 100%; background-color: #024C68;">
                                    <label style="color: White; font-size: 1em;">Fecha Final </label>
                                    <label style="color: White; font-size: 0.6em;">(Lista &uacute;ltimos 2 dias) </label>
                                    <center><table style="width: 50%;">
                                    <tr>
                                    <td style="text-align: center;">
                                    D<select id="dd" class="browser-default light-blue-text" style="width: 60px; height: 25px; font-size: 0.8em;">
                                        <option value="" disabled selected>D&iacute;a </option>
                                        <?php
                                        $dia=1;
                                        while($dia<=31){
                                            if ($dia<10){
                                                $dia='0'.$dia;
                                            }
                                            echo "<option value=\"$dia\">$dia</option>";
                                            $dia++;
                                        }
                                        ?>
                                  </select>
                                  </td>
                                  <td style="text-align: center;">
                                  M<select id="mm" class="browser-default light-blue-text" style="width: 60px; height: 25px; font-size: 0.8em;">
                                        <option value="" disabled selected>Mes </option>
                                        <?php
                                        $mes=1;
                                        while($mes<=12){
                                            if ($mes<10){
                                                $mes='0'.$mes;
                                            }
                                            echo "<option value=\"$mes\">$mes</option>";
                                            $mes++;
                                        }
                                        ?>
                                  </select>
                                  </td>
                                  <td>
                                  A<select id="yy" class="browser-default light-blue-text" style="width: 80px; height: 25px; font-size: 0.8em;">
                                        <?php
                                        $anio=date("Y");
                                        echo "<option value=\"$anio\">$anio</option>";
                                        ?>
                                  </select>
                                  </td>
                                </tr>
                                </table></center>
                                <input type="submit" onclick="VerificarOrdenMagento();" class="waves-efect waves-light btn" name="Enviar" value="Verificar Ordenes Pag Web" /><br /><br />
                          </div><br />
                          <div style="width: 98%; background-color: #024C68;">
                          
                          <br />
                                                                                                       
                                    <input type="submit" id="OrdFal" onclick="VerificarOrdenIBSLista();" class="waves-efect waves-light btn" name="Enviar2" value="Ordenes Pendientes de Procesar" /><br /><br />
                                
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
                   <!--class="col s12 m3 l4 xl4"-->
                   <div id="formu" style="width: 200hw;">
         
                    </div>
                   <div id="respuesta" style="width: 100%; text-align: center; background-color: #90CAF9; color: red; font-weight: bold;">
                            
                   </div><hr />
                   <div id="resultado1" style="width: 100%; text-align: center; background-color: #90CAF9; color: red; font-weight: bold; visibility: hidden;">
                   <?php
                   /*echo "<a style='color: blue; background-color: white;' href='Informe/Informe_OrdenesMagento.xlsx'>***Descargar Informe***</a>";
                   $C1="#000000";
                    $T1="height: 10px; color: $C1; font-size: 0.6em; font-weight: bold; padding=0; width: 5%; text-align: left;";
                    $T2="height: 10px; color: $C1; font-size: 0.6em; font-weight: bold; padding=0; width: 60px; text-align: center;";
                    //$T3="height: 10px; color: $C1; font-size: 0.6em; font-weight: bold; padding=0; width: 20px; text-align: center;";
                    //echo "<span style='color: black; font-weight: bold;' >ORDENES EN MAGENTO PAGINA WEB</span>";
                        $idPP="<table style=\"border: 1px solid #000; width:100%;\">";
                        $idPP = $idPP . "<tr>";
                        $idPP = $idPP . "<td style='$T2'>#</td>";
                        $idPP = $idPP . "<td style='$T2'>NumPedido</td>";
                        $idPP = $idPP . "<td style='$T2'>Items</td>";
                        $idPP = $idPP . "<td style='$T2'>Cliente</td>";
                        $idPP = $idPP . "<td style='$T2'>Nom Cliente</td>";
                        $idPP = $idPP . "<td style='$T2'>Valor Orden $</td>";
                        $idPP = $idPP . "<td style='$T2'>Codigo Postal</td>";
                        $idPP = $idPP . "<td style='height: 10px; color: $C1; font-size: 0.6em; font-weight: bold; padding=0; width: 100px; text-align: center;'>Direccion</td>";
                        $idPP = $idPP . "<td style='$T2'>Ciudad</td>";
                        $idPP = $idPP . "<td style='$T2'>Barrio</td>";
                        $idPP = $idPP . "<td style='$T2'>CodPostLup</td>";
                        $idPP = $idPP . "<td style='$T2'>Telefono</td>";
                        $idPP = $idPP . "<td style='$T2'>Celular</td>";
                        $idPP = $idPP . "<td style='$T2'>Fecha Creacion</td>";
                        $idPP = $idPP . "<td style='$T2'>Estado</td>";
                        $idPP = $idPP . "<td style='$T2'>Obs</td>";
                        $idPP = $idPP . "</tr>";
                        $idPP = $idPP. "</table><br>";
                        echo $idPP;*/
                   ?>         
                   </div>
                                     
                   <div id="resultado" style="width: 100%; height:530px; overflow: scroll; text-align: center;">
                            
                   </div>
                    
                </div>
    <!--subir vistas ventas y compras-->
    <div class="flow-text" style="font-size:1.5vw;text-align:center;">
        <div class="col s12 m3 l2 xl2 hide-on-med-and-down" style="width: 200hw;">
        
      </div>
    </div>
          <!--formulario-->
     <div class="row">
         <div id="formv" class="col s12 m3 l3 xl3 hide-on-med-and-down" style="width: 200hw;">
            &nbsp;
         </div>
         
         <div id="estado" class="col s12 m3 l2 xl3" style="width: 200hw;">
         
         </div>
     </div>
     
        
      <!--fin container-->  
    </div>
    
    
    
</body>
</html>