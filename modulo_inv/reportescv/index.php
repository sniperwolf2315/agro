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
                //'localhost/' +
                //alert('localhost/' + valor);
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
                document.getElementById('linke').innerHTML = '<a href="informes/'+valor+'"><h4>Descargar Informe en Excel</h4></a>';
            }
               
        function buscarDatos1() {
                var ano=document.getElementById('Anio').value;
                var mes=document.getElementById('Mes').value;
                var periodo=ano + mes;
                
                //entra solo cuando busca la categoria
                /*if (seactualiza == 0) {
                    //limpia
                    var select = document.getElementById('subcategoria');
                    document.getElementById('refer').value = '';
                    while (select.length > 1) {
                        select.remove(1);
                    }
                }*/
                //busca el dato
                
                if (periodo != "") {
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'buscardatos1.php?periodo=' + periodo, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        //alert(dato1);
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert(dato);
                                //document.getElementById('refer').value = dato;
                            }
                        }
                    }
                }else{
                    alert('Digite año y mes');
                }
                
            }
    
        function Comp_Vent_Mes(){
            //document.getElementById('formu').innerHTML='hola';
            texto='';
            texto=texto + '<div class="flow-text" style="font-size:1.5vw;text-align:center;">COMPRAS-VENTAS MES</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" placeholder="Digite a&ntilde;o: 2020" maxlength="4" type="text" class="validate" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="Digite mes: 05" type="text" maxlength="2" class="validate" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="buscarDatos1();">Generar Informe</a><center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
        }
        
        function Comp_Vent_Acum(){
            //document.getElementById('formu').innerHTML='hola';
            texto='';
            //texto=texto + '<div class="col s6">';
            texto=texto + '<div class="flow-text" style="font-size:1.5vw;text-align:center;">COMPRAS-VENTAS ACUMULADAS A&Ntilde;O</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" placeholder="Digite a&ntilde;o: 2020" maxlength="4" type="text" class="validate" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="Digite mes: 05" type="text" maxlength="2" class="validate" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
             
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="GenerarPDF(2);">Generar Informe</a><center>';   
            
            
            //texto=texto + '<center><div class="input-field col s6"><a class="waves-efect waves-light btn">Generar Informe</a></div></center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
        }
        
        function Vent_vs_Ano_Ant_Mes(){
            //document.getElementById('formu').innerHTML='hola';
            texto='';
            //texto=texto + '<div class="col s6">';
            texto=texto + '<div class="flow-text" style="font-size:1.5vw;text-align:center;">VENTAS vs A&Ntilde;O ANTERIOR MES</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" placeholder="Digite a&ntilde;o: 2020" maxlength="4" type="text" class="validate" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="Digite mes: 05" type="text" maxlength="2" class="validate" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
             
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="GenerarPDF(3);">Generar Informe</a><center>';   
            
            
            //texto=texto + '<center><div class="input-field col s6"><a class="waves-efect waves-light btn">Generar Informe</a></div></center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
        }
        
        function Vent_vs_Ano_Ant_Acum(){
            //document.getElementById('formu').innerHTML='hola';
            texto='';
            //texto=texto + '<div class="col s6">';
            texto=texto + '<div class="flow-text" style="font-size:1.5vw;text-align:center;">VENTAS vs A&Ntilde;O ANTERIOR ACUMULADAS</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" placeholder="Digite a&ntilde;o: 2020" maxlength="4" type="text" class="validate" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="Digite mes: 05" type="text" maxlength="2" class="validate" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
             
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="GenerarPDF(4);">Generar Informe</a><center>';   
            
            
            //texto=texto + '<center><div class="input-field col s6"><a class="waves-efect waves-light btn">Generar Informe</a></div></center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
        }
    
    </script>
    
   
</head>
 
<body class="gray">
 
    <div class="container">
        <div class="row blue accent-2">
            <!--menu izq-->
             <div class="col s6 m6 l12 xl12 blue lighten-3">
                <div class="nav-wrapper red lighten-2 white-text bordes">
                &nbsp;
                </div>
             </div>
            
             <div class="col s7 m12 l12 xl12 blue accent-2">
                <div class="row blue accent-2 left">
                        <div class="col s6 m2 l2 xl8 blue accent-2">
                            <br /><img class="responsive-img center " src="img/reporte.png" width="160vw;" /><br />
                        </div>
                        <div class="col s6 m4 l10 xl8 blue accent-2 ">
                            <br /><div class="flow-text" style="font-size:3vw;text-align:right;">REPORTE COMPRAS Y VENTAS</div>
                        </div>
                </div>
                <div class="row blue accent-2">
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
                            <li><a href="javascript:Comp_Vent_Mes()">Comp_Vent_Mes</a></li>
                            <li><a href="javascript:Comp_Vent_Acum()">Comp_Vent_Acum</a></li>
                             <li><a href="javascript:Vent_vs_Ano_Ant_Mes()">Vent_vs_A&ntilde;o_Ant_Mes</a></li>
                            <li><a href="javascript:Vent_vs_Ano_Ant_Acum()">Vent_vs_A&ntilde;o_Ant_Acum</a></li>
                        </ul>
                        </div>
                    </div>
                </nav>
            </div>
                
           </div>  
               
               
                <div class="row">
                    
                    <div class="row white center">
                        <div class="col s6 m12 l12 xl12 offset-12 center">
                         
                        <div class="row center">
                            <div class="col s12 m3 l3 xl12 center ">
                            
                            </div>
                            <div class="col s12 m7 l6 xl12 blue lighten-2 white-text">
                             <div class="flow-text" style="font-size:1.5vw;text-align:center;">
                                 GENERACI&Oacute;N DE INFORMES
                             </div>
                            </div>
                        </div>
                        
                        
                         
                          
      
                        </div>
                    
                    </div>
                    
                                     
                   
                    
                </div>
 
          <!--formulario-->
     <div class="row">
         <div id="formv" class="col s3 m3 l3 xl3 hide-on-med-and-down" style="width: 200hw;">
         &nbsp;
         </div>
         <div id="formu" class="col s6 m6 l6 xl8" style="width: 200hw;">
         
         </div>
     </div>
        
      <!--fin container-->  
    </div>
    
    
    
</body>
</html>