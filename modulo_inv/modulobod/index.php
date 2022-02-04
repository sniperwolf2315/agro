<?php
    if(session_start()===FALSE){
        session_start();
    }
?>
<!DOCTYPE html>
<html>
 
<head>
    
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
 
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
 
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 
    <script language="JavaScript">
        var parar=false;
        function verLink(valor) {
                document.getElementById('url').innerHTML = '<a href="'+valor+'" target="_new" onclick="actualizar()"><h4>Descargar Informe</h4></a>';
                
        }
        
        function actualizar(){
            setTimeout("location.reload(true);", 500);
        }
           
        function buscarOrdenes() {
                   
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                   
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
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
                    peticion_http.open('POST', 'buscardatosOrdenes.php?a=' + anio + '&m=' + mes, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            //alert('hola');
                            //return false;
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert("Proceso terminado.");
                                //INFORME_COMPRAS_VENTAS_MES.pdf
                                document.getElementById('estado').innerHTML='';
                                document.body.style.cursor = 'auto';
                                verLink(dato);
                            }
                        }
                    }    
                    
            }
            
            function contarFuncionariosMes() {
                   
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
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
                    peticion_http.open('POST', 'contarFuncionarios.php?a=' + anio + '&m=' + mes, true);
                    peticion_http.send(null);                  
                    
                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                var tiempot=parseInt(dato)*30;
                                document.getElementById('url').style.visibility='visible';
                                
                                var l = document.getElementById("number");
                                var r = document.getElementById("url");
                                n=(parseInt(tiempot)/15)-3;
                                var ancho=1;
                                //var x=parseInt(dato);let intervalId = 
                                /*if(parar==false){
                                     var myTimer = window.setInterval(function(){
                                    //if(n>=0){
                                      barra='<div id="number2" style="width: ' + ancho + 'px; background-color: blue;">&nbsp;</div>';
                                      l.innerHTML = barra;
                                      ancho+=1;
                                      n++;
                                      r.innerHTML = ancho;  
                                    //}
                                    },1000);
                                }*/
                                 
                                buscarDashboard(tiempot);
                                
                                //if(parar==true){
                                 // window.clearInterval(myTimer);
                               // window.setInterval(function(){
                                //if(n<2){
                                    l.innerHTML = '';
                                    document.getElementById('estado').innerHTML='';
                                    l.innerHTML = ''; 
                                    document.getElementById('url').style.visibility='visible';
                                 // },0);
                                
                                //}
                          }
                       }    
                    
                }
           } 
                        
            function buscarDashboard() {
                    var tiempo=document.getElementById('tiempo').value;
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    var company=document.getElementById('company').value;
                    if(company!="AG" && company!="ZZ" && company!="X1"){
                        alert('Seleccione empresa');
                        return false;
                    }
                    
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                    
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
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
                    if(tiempo=='Salida'){
                        peticion_http.open('POST', 'buscardatosOrdenes.php?a=' + anio + '&m=' + mes, true);
                    }
                    if(tiempo=='Validados'){
                        peticion_http.open('POST', 'validacionpedidos.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    }
                    if(tiempo=='Facturados'){
                        peticion_http.open('POST', 'pedidosfacturados.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    }
                    if(tiempo=='Separados'){
                        peticion_http.open('POST', 'pedidoseparados.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    }
                    if(tiempo=='Ing_Mercancia'){
                        peticion_http.open('POST', 'ingresomercancia.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    }
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            //alert('hola');
                            //return false;
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                //alert(dato);
                                //INFORME_COMPRAS_VENTAS_MES.pdf
                                document.getElementById('estado').innerHTML='';
                                document.getElementById('number').innerHTML = "Terminado";
                                document.body.style.cursor = 'auto';
                                verLink(dato);
                                //sleep(1);
                                //setTimeout("location.reload(true);", 500);
                                parar=true;
                            }
                        }
                    }    
                    
            }
            
            
            
            function ValidacionPed(){
                    var tiempo=document.getElementById('tiempo').value;
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    var company=document.getElementById('company').value;
                    var control="";
                    if(company!="AG" && company!="ZZ" && company!="X1"){
                        alert('Seleccione empresa');
                        return false;
                    }
                    
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                                       
                                       
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido1;
                    
                    
                    peticion_http.open('POST', 'validacionpedidosdashboard.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    
                    peticion_http.send(null);

                    function muestraContenido1() {
                        if (peticion_http.readyState == 4) {
                            //alert('hola');
                            //return false;
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                              
                                document.getElementById('estado').innerHTML='';
                                //document.getElementById('number').innerHTML = "Terminado";
                                document.body.style.cursor = 'auto';
                                //verLink(dato);
                                document.getElementById('dashboardp2').innerHTML=dato;
                                FacturacionPed();
                                parar=true;
                            }
                        }
                    }
            }
            
            function SeparacionPed(){
                    var tiempo=document.getElementById('tiempo').value;
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    var company=document.getElementById('company').value;
                    var control="";
                    if(company!="AG" && company!="ZZ" && company!="X1"){
                        alert('Seleccione empresa');
                        return false;
                    }
                    
                    if(anio==""){
                        alert("Digite un year");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                                       
                                       
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido2;
                    
                    
                    peticion_http.open('POST', 'separacionpedidosdashboard.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    
                    peticion_http.send(null);

                    function muestraContenido2() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                              
                                document.getElementById('estado').innerHTML='';
                                //document.getElementById('number').innerHTML = "Terminado";
                                document.body.style.cursor = 'auto';
                                //verLink(dato);
                                document.getElementById('dashboardp1').innerHTML=dato;
                                ValidacionPed();
                                
                                parar=true;
                            }
                        }
                    }
            }
            
            function FacturacionPed(){
                    var tiempo=document.getElementById('tiempo').value;
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    var company=document.getElementById('company').value;
                    var control="";
                    if(company!="AG" && company!="ZZ" && company!="X1"){
                        alert('Seleccione empresa');
                        return false;
                    }
                    
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                                       
                                       
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido2;
                    
                    
                    peticion_http.open('POST', 'facturacionpedidosdashboard.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    
                    peticion_http.send(null);

                    function muestraContenido2() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                              
                                document.getElementById('estado').innerHTML='';
                                //document.getElementById('number').innerHTML = "Terminado";
                                document.body.style.cursor = 'auto';
                                //verLink(dato);
                                document.getElementById('dashboardp3').innerHTML=dato;
                                
                                pedidosHoy();
                                parar=true;
                            }
                        }
                    }
            }
            
            function pedidosHoy(){
                    var tiempo=document.getElementById('tiempo').value;
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    var company=document.getElementById('company').value;
                    var control="";
                    if(company!="AG" && company!="ZZ" && company!="X1"){
                        alert('Seleccione empresa');
                        return false;
                    }
                    
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                                       
                                       
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido2;
                    
                    
                    peticion_http.open('POST', 'pedidosdashboardhoy.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company, true);
                    
                    peticion_http.send(null);

                    function muestraContenido2() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                              
                                document.getElementById('estado').innerHTML='';
                                //document.getElementById('number').innerHTML = "Terminado";
                                document.body.style.cursor = 'auto';
                                //verLink(dato);
                                document.getElementById('dashboardp4').innerHTML=dato;
                                
                                ingmercancia();
                                parar=true;
                            }
                        }
                    }
            }
            ////////////////////////////////////////////////
            
            function ingmercancia(){
                    var tiempo=document.getElementById('tiempo').value;
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    var company=document.getElementById('company').value;
                    var transpo=document.getElementById('Transp').value;
                    var transportadora = transpo.substring(0,7);
                    var control="";
                    if(company!="AG" && company!="ZZ" && company!="X1"){
                        alert('Seleccione empresa');
                        return false;
                    }
                    
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                                       
                    document.getElementById('Carguesi').style.visibility='visible';                 
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido2;
                    
                    
                    peticion_http.open('POST', 'ingmercanciadashboard.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company + '&tran=' + transportadora, true);
                    
                    peticion_http.send(null);

                    function muestraContenido2() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                //alert(dato);
                                document.getElementById('estado').innerHTML='';
                                //document.getElementById('number').innerHTML = "Terminado";
                                document.body.style.cursor = 'auto';
                                //verLink(dato);
                                document.getElementById('dashboardpw5').innerHTML=dato;
                                document.getElementById('Carguesi').style.visibility='hidden';
                                pedidosSalidasT();
                                parar=true;
                            }
                        }
                    }
            }
            
            //////////////////////////////////////////////////
            
            function pedidosSalidasT(){
                    var tiempo=document.getElementById('tiempo').value;
                    var anio=document.getElementById('Anio').value;
                    var mes=document.getElementById('Mes').value;
                    var company=document.getElementById('company').value;
                    var transpo=document.getElementById('Transp').value;
                    var transportadora = transpo.substring(0,7);
                    var control="";
                    if(company!="AG" && company!="ZZ" && company!="X1"){
                        alert('Seleccione empresa');
                        return false;
                    }
                    
                    if(anio==""){
                        alert("Digite un año");
                        return false;
                    }
                    if(mes==""){
                        alert("Digite un mes");
                        return false;
                    }
                                       
                    document.getElementById('Cargues').style.visibility='visible';                   
                    document.getElementById('estado').innerHTML='<center><img src="img/radar.gif" width="150px" height="150px"></center>';
                    //document.getElementById('tabla').innerHTML='<table>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido2;
                    
                    
                    peticion_http.open('POST', 'salidaspeddashboard.php?a=' + anio + '&m=' + mes + '&tipo=' + tiempo + '&comp=' + company + '&tran=' + transportadora, true);
                    
                    peticion_http.send(null);

                    function muestraContenido2() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                              
                                document.getElementById('estado').innerHTML='';
                                //document.getElementById('number').innerHTML = "Terminado";
                                document.body.style.cursor = 'auto';
                                //verLink(dato);
                                document.getElementById('dashboardpw1').innerHTML=dato;
                                document.getElementById('Cargues').style.visibility='hidden';
                                parar=true;
                            }
                        }
                    }
            }
                        
            function buscarDashboardPantalla() {
                SeparacionPed(); 
                                
            }
            
            function formuOrdenesMes(){
            //document.getElementById('formu').innerHTML='hola';
            texto='';
            //texto=texto + '<div class="col s6">';
            texto=texto + '<div class="flow-text blue lighten-3" style="font-size:1.5vw;text-align:center;">ORDENES DESPACHADAS POR MES</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
             
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="buscarOrdenes();">Buscar</a><center>';   
            
            
            //texto=texto + '<center><div class="input-field col s6"><a class="waves-efect waves-light btn">Generar Informe</a></div></center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
            }
                     
            
            function dashBoard(){
                var tiempo=document.getElementById('tiempo').value;
                var vista=document.getElementById('garchivoxlsx').value;
                if(tiempo=='Seleccione'){
                    alert("Seleccione un Periodo para el informe.");
                    return false;
                }
                texto='';
            
                texto=texto + '<div class="flow-text #439049 green darken-1" style="font-size:1.5vw;text-align:center;color:white;">DASHBOARD</div>';
                
                texto=texto + '<div class="input-field col s6">';
                texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
                texto=texto + '<label for="Anio"></label>';
                texto=texto + '</div>';
                
                texto=texto + '<div class="input-field col s6">';
                texto=texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
                texto=texto + '<label for="Mes"></label>';
                texto=texto + '</div>';
                
                
                //texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="buscarDashboardPantalla();">Buscar</a><center>';   
               
               texto=texto + '<br /><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDashboard();">Buscar</a><center>';   
               
          
            document.getElementById('formu').innerHTML=texto;
            return true;
            }
        
            function dashBoardPantalla(){
                var tiempo=document.getElementById('tiempo').value;
                var vista=document.getElementById('garchivoxlsx').value;
                
                texto='';
            
                texto=texto + '<div class="flow-text #439049 green darken-1" style="font-size:1.5vw;text-align:center;color:white;">DASHBOARD PANTALLA</div>';
                
                texto=texto + '<div class="input-field col s3">';
                texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
                texto=texto + '<label for="Anio"></label>';
                texto=texto + '</div>';
                
                texto=texto + '<div class="input-field col s3">';
                texto=texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
                texto=texto + '<label for="Mes"></label>';
                texto=texto + '</div>';
                
                texto=texto + '<div class="input-field col s3">';
                //texto=texto + '<input id="Transp" placeholder="Transportadora" type="text" maxlength="20" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
                texto=texto + '<select id="Transp" class="browser-default light-blue-text" style="width: 60hw;font-size: 0.7em" >';
                texto=texto + '<option value="">Transportadora</option>';
                texto=texto + '<option value="AERO SUR"/>AERO SUR</option>';
                texto=texto + '<option value="AEROCARGA"/>AEROCARGA</option>';
                texto=texto + '<option value="AEROCHARTE"/>AEROCHARTE</option>';
                texto=texto + '<option value="AEROSUR"/>AEROSUR</option>';
                texto=texto + '<option value="COMOTOR"/>COMOTOR</option>';
                texto=texto + '<option value="CONTRAENTREGA"/>CONTRAENTREGA</option>';
                texto=texto + '<option value="CONTRASTAME"/>CONTRASTAME</option>';
                texto=texto + '<option value="DELFINES"/>DELFINES</option>';
                texto=texto + '<option value="DEPRISA"/>DEPRISA</option>';
                texto=texto + '<option value="DOMICILIO"/>DOMICILIO</option>';
                texto=texto + '<option value="ENCOEXPRESS"/>ENCOEXPRESS</option>';
                texto=texto + '<option value="ENERGY LOGISTICA"/>ENERGY LOGISTICA</option>';
                texto=texto + '<option value="FLOTA RIO NEGRO"/>FLOTA RIO NEGRO</option>';
                texto=texto + '<option value="INTERRAPIDISIMO"/>INTERRAPIDISIMO</option>';
                texto=texto + '<option value="METROENTREGAS"/>METROENTREGAS</option>';
                texto=texto + '<option value="OMEGA LTDA"/>OMEGA LTDA</option>';
                texto=texto + '<option value="PERSONAL"/>PERSONAL</option>';
                texto=texto + '<option value="PORTOS  "/>PORTOS</option>';
                texto=texto + '<option value="POS CARGO"/>POS CARGO</option>';
                texto=texto + '<option value="POSTCARGO"/>POSTCARGO</option>';
                texto=texto + '<option value="REDETRANS"/>REDETRANS</option>';
                texto=texto + '<option value="RUTA SABANA"/>RUTA SABANA</option>';
                texto=texto + '<option value="SERVIENTREGA"/>SERVIENTREGA</option>';
                texto=texto + '</select>';
                //texto=texto + '<label for="Transp"></label>';
                texto=texto + '</div>';
                
                texto=texto + '<div class="input-field col s3">';
                texto=texto + '<br /><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDashboardPantalla();">Buscar</a><center>';
                //texto=texto + '<br /><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDashboardPantalla();">Buscar</a><center>';   
                texto=texto + '</div>';
                    //texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="buscarDashboard();">Buscar</a><center>';   
                         
            document.getElementById('formu').innerHTML=texto;
            if(vista=='P'){
                document.getElementById('tiempo').style.visibility='hidden';
            }
            if(vista=='E'){
                if(tiempo=='Seleccione'){
                    alert("Seleccione una Consulta para el informe.");
                }
                document.getElementById('tiempo').style.visibility='visible';
            }
            return true;
            }
        
    
    </script>
    
   
</head>
 <!--style="background-image: url(img/matrix.gif);"-->
<body class="gray">
 
    <div class="container" style="width: 98%;">
        
        <div class="row #439049 green darken-1" style="padding: 5px;">
           <!--logo #439049 green darken-1, #1565c0 blue darken-2-->
           <div class="col">
            <img class="responsive-img center " src="img/logoAG.png" style="width: 2.5em;" />&nbsp;&nbsp;<label style="font-size: medium; color: whitesmoke; font-weight: bold;">Dashboard</label>
           </div>
           <!--menu blue #3980C3-->
           <div class="col right #439049 green darken-1"> 
                <nav class="right #E67402 orange darken-1" style="height: 50px;">
                        <ul id="nav-mobile" class="right #439049 green darken-1" style="height: 0.5em;">
                           <!-- <li><a href="javascript:Portos()"><b>PORTOS</b></a>&nbsp;</li>
                            <li class="col #439049 green darken-1" style="height: 60px;">&nbsp;</li>
                            <li><a href="javascript:Almacen()"><b>ALMACEN</b></a>&nbsp;</li>
                            -->
                        </ul>
                </nav>
         </div>
              
    </div>   
             
               
                <div class="row">
                    
                    <div class="row white center">
                        <div class="col s6 m12 l12 xl12 offset-12 center">
                         
                        <div class="row center #4EAE4D green darken-1">
                            <div class="col s12 m3 l3 xl12 center ">
                            
                            </div>
                            <div class="col s12 m7 l6 xl12 #F5B808 orange darken-1 white-text">
                             <div class="flow-text" style="font-size:1.5vw;text-align:center;">
                                 <span style="font-size:1.5vw;text-align:left; color: #439049;text-transform: capitalize;font-weight: bold;">Informes</span>
                             </div>
                             <hr />     
                          <!--final xxx F5B808-->
                          <table>
                          <tr>
                          <td>
                          <select id="garchivoxlsx" onchange="dashBoardPantalla();" class="browser-default light-blue-text" style="width: 60hw;">
                                    <!--<option value="Seleccione" disabled selected >Seleccione Compa&ntilde;ia</option>-->
                                    <option value="">Seleccione Vista</option>
                                    <option value="P">VER EN PANTALLA</option>
                                     <option value="E">EXPORTAR A EXCEL</option>
                                   <!-- <option value="X1">PESTAR</option>
                                    <option value="ZZ">COMERVET</option>-->
                          </select>
                          </td>
                          <td>
                          <select id="tiempo" onchange="dashBoard();" class="browser-default light-blue-text" style="width: 800hw;">
                                    <option value="Seleccione" disabled selected >Seleccione Consulta</option>
                                    <option value="Salida">Salida Mercancia</option>
                                    <option value="Validados">Pedidos Validados</option>
                                    <option value="Facturados">Pedidos Facturados</option>
                                    <option value="Separados">Pedidos Separados</option>
                                    <option value="Ing_Mercancia">Ingreso Mercancia</option>
                          </select>
                          </td>
                          <td>
                          <select id="company" class="browser-default light-blue-text" style="width: 60hw;">
                                    <!--<option value="Seleccione" disabled selected >Seleccione Compa&ntilde;ia</option>-->
                                    <option value="AG">AGROCAMPO</option>
                                   <!-- <option value="X1">PESTAR</option>
                                    <option value="ZZ">COMERVET</option>-->
                          </select>
                          </td>
                          
                          </tr>
                          </table>
                          </div>
                          
                        </div>
                        
                        
                        <div class="row center blue lighten-3">
                            <div class="col s12 m6 l10 xl110 center">
                            <!--aqui-->
                            </div>
                        </div> 
                          
      
                        </div>
                    
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
         <div id="tablas" class="col s3 m3 l2 xl3" style="width: 200hw;">
         
         </div>
         
         <div id="tablax" class="col s3 m3 l2 xl3" style="width: 200hw;">
             <table>
             <tr><td>
             <div id="number" style="width: 200hw;">
                
             </div>
             </td></tr>
             <tr><td>
             <div id="estado" style="width: 200hw;">
             
             </div>
             </td></tr>
             <tr><td>
             <div id="url" style="width: 200hw;">
             
             </div>
             </td>
             
             </tr>
             </table>
         </div>
         
     </div>
     <p>
     <table>
        <tr>
            <td style="vertical-align: top;">
                <div id="dashboardp1" style="float: left;">
                     
                </div>
            </td>
            <td style="vertical-align: top;">
                <div id="dashboardp2" >
                     
                </div>
            </td>
            <td style="vertical-align: top;">
             <div id="dashboardp3" style="float: right;">
                 
             </div>
            </td>
            <td style="vertical-align: top;">
                 <div id="dashboardp4" style="float: right;">
                     
                 </div>
            </td>
        </tr>
     </table>
     </p>
     <p>
     <label id="Carguesi" style="visibility: hidden;">Generando Ingreso de Mercancia. Espere por favor...</label><br />
     <div id="dashboardpw5" style="height: 300px;width: 98%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;">
                 
     </div>
     </p>
     <p>
     <label id="Cargues" style="visibility: hidden;">Generando Descripcion de Cargue por Transportadora. Espere por favor...</label><br />
     <div id="dashboardpw1" style="height: 300px;width: 98%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;">
             
     </div>
     </p>
      <!--fin container-->  
    </div>
   
    
    
</body>
</html>