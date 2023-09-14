<?php
    if(session_start()===FALSE){
        session_start();
    }
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
                var sequence=document.getElementById('sequence').value;
                if(sequence==""){
                    alert('Digite un Sequence de Pedido.');
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
                if(anio=="Año" || anio==""){
                    alert('Seleccione año');
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
            
            function VerificarOrdenIBSLista() {            
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
             
             <div class="col s6 m6 l12 xl3 gray lighten-2">
                <nav>
                    
                    <div class="nav-wrapper red lighten-2 white-text bordes">
                        <a href="#" class="brand-logo hide-on-med-and-down">
                            <div class="flow-text" style="font-size:3vw;">&nbsp;</div>
                        </a>
                        <div style="font-size:1vw;text-align:center;">
                        <ul id="nav-mobile" class="right">
                            
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
                                 <span style="color: #000000;">VERIFICAR SUBIDA DE ORDENES A IBS</span>
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
                                  
                                     <label style="color: White; font-size: 1.2em;">Sequence: </label><input type="text" id="sequence" style="font-weight: bold; width: 200px; color: #21EDDA; font-size: 1.2em;" autofocus="true" /> <br />                                
                                    <input type="submit" onclick="VerificarOrdenIBS();" class="waves-efect waves-light btn" name="Enviar" value="Verificar Orden" /><br /><br />
                                
                          </div><br />
                          <div style="width: 98%; background-color: #024C68;">
                          
                          <br />
                                                                                                       
                                    <input type="submit" onclick="VerificarOrdenIBSLista();" class="waves-efect waves-light btn" name="Enviar2" value="Lista Ordenes Pendientes" /><br /><br />
                                
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