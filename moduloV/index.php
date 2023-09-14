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
                document.getElementById('estado').innerHTML = '<a href="'+valor+'" target="_new"><h4>Descargar Informe</h4></a>';
            }
               
        function buscarDatos1() {
                var ano=document.getElementById('Anio').value;
                var mes=document.getElementById('Mes').value;
                var periodo=ano + mes;
                if(mes.length<2){
                    alert("El mes debe tener min 2 cifras");
                    return false;
                }
                if(ano.length<4){
                    alert("El a�o debe tener min 4 cifras");
                    return false;
                }
                if (periodo != "") {
                    document.getElementById('estado').innerHTML='<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
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
                    peticion_http.open('POST', 'buscardatos1.php?periodo=' + periodo, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        //alert(dato1);
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert('COMPLETADO..');
                                //INFORME_COMPRAS_VENTAS_MES.pdf
                                document.getElementById('estado').innerHTML='';
                                verLink('INFORME_COMPRAS_VENTAS_MES.pdf');
                                //document.getElementById('estado').innerHTML='LISTO';
                                document.body.style.cursor = 'auto';
                                //document.getElementById('refer').value = dato;
                            }
                        }
                    }
                }else{
                    alert('Digite a�o y mes');
                }
                
            }
            
        function buscarDatos2() {
                var ano=document.getElementById('Anio').value;
                var mes=document.getElementById('Mes').value;
                var periodo=ano + mes;
                if(mes.length<2){
                    alert("El mes debe tener min 2 cifras");
                    return false;
                }
                if(ano.length<4){
                    alert("El a�o debe tener min 4 cifras");
                    return false;
                }
                if (periodo != "") {
                    document.getElementById('estado').innerHTML='<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
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
                    peticion_http.open('POST', 'buscardatos2.php?periodo=' + periodo, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        //alert(dato1);
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert('COMPLETADO..');
                                //INFORME_COMPRAS_VENTAS_MES.pdf
                                document.getElementById('estado').innerHTML='';
                                verLink('INFORME_COMPRAS_VENTAS_MES_ACUMULADO.pdf');
                                //document.getElementById('estado').innerHTML='LISTO';
                                document.body.style.cursor = 'auto';
                                //document.getElementById('refer').value = dato;
                            }
                        }
                    }
                }else{
                    alert('Digite a�o y mes');
                }
                
            }
            
        function buscarDatos3() {
                var ano=document.getElementById('Anio').value;
                var mes=document.getElementById('Mes').value;
                var periodo=ano + mes;
                if(mes.length<2){
                    alert("El mes debe tener min 2 cifras");
                    return false;
                }
                if(ano.length<4){
                    alert("El a�o debe tener min 4 cifras");
                    return false;
                }
                if (periodo != "") {
                    document.getElementById('estado').innerHTML='<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
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
                    peticion_http.open('POST', 'buscardatos3.php?periodo=' + periodo, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        //alert(dato1);
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert('COMPLETADO..');
                                //INFORME_COMPRAS_VENTAS_MES.pdf
                                document.getElementById('estado').innerHTML='';
                                verLink('INFORME_VENTAS_MES_ANIOACT_VS_ANIOANT.pdf');
                                //document.getElementById('estado').innerHTML='LISTO';
                                document.body.style.cursor = 'auto';
                                //document.getElementById('refer').value = dato;
                            }
                        }
                    }
                }else{
                    alert('Digite a�o y mes');
                }
                
            }
            
        function buscarDatos4() {
                var ano=document.getElementById('Anio').value;
                var mes=document.getElementById('Mes').value;
                var periodo=ano + mes;
                if(mes.length<2){
                    alert("El mes debe tener min 2 cifras");
                    return false;
                }
                if(ano.length<4){
                    alert("El a�o debe tener min 4 cifras");
                    return false;
                }
                if (periodo != "") {
                    document.getElementById('estado').innerHTML='<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
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
                    peticion_http.open('POST', 'buscardatos4.php?periodo=' + periodo, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        //alert(dato1);
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert('COMPLETADO..');
                                //INFORME_COMPRAS_VENTAS_MES.pdf
                                document.getElementById('estado').innerHTML='';
                                verLink('INFORME_VENTAS_MES_ANIOACT_VS_ANIOANT_ACUMULADO.pdf');
                                //document.getElementById('estado').innerHTML='LISTO';
                                document.body.style.cursor = 'auto';
                                //document.getElementById('refer').value = dato;
                            }
                        }
                    }
                }else{
                    alert('Digite a�o y mes');
                }      
            }
        
        function subrirVendedores() {
                   
                    var area=document.getElementById('area').value;
                    //document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/escribe.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                   
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
                    peticion_http.open('POST', 'vendedores.php?area=' + area, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert(dato);
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                            }
                        }
                    }
                    
            }
            
            function subrirTipoCuotas() {
                   
                    var area=document.getElementById('area').value;
                    //document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/escribe.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                   
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
                    peticion_http.open('POST', 'tipocuotas.php', true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert(dato);
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                            }
                        }
                    }
                    
            }
            
            function GenerarReporteXLS() {
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/escribe.gif" width="180px" height="180px"></center>';
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
                    peticion_http.open('POST', 'generareportexcel.php', true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                document.body.style.cursor = 'auto';
                                verLink(dato);alert('Informe generado correctamente. Puede descargarlo mediante el link');
                                //alert(dato);
                                document.getElementById('formu').innerHTML='';
                            }
                        }
                    }
                   
            }
            
            function Guardar_Grupo() {
                var grupo=document.getElementById('grupo').value;
                var manejador=document.getElementById('maneja').value;
                var categoria=document.getElementById('Categoria').value;
                if(grupo==""){
                    alert('Digite el Grupo');
                    return false;
                }
                if(manejador==""){
                    alert('Seleccione un manejador');
                    return false;
                }
                if(categoria==""){
                    alert('Digite una categoria');
                    return false;
                }
                
                    document.getElementById('formu').innerHTML='<center><img class="responsive-img circle responsive-img center" src="img/escribe.gif" width="180px" height="180px"></center>';
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
                    peticion_http.open('POST', 'grupos.php?g=' + grupo + '&m=' + manejador + '&c=' + categoria, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert(dato);
                                document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                            }
                        }
                    }    
            }
    
        function Comp_Vent_Mes(){
            //document.getElementById('formu').innerHTML='hola';background-color: white;
            texto='';
            texto=texto + '<div class="flow-text blue lighten-3" style="font-size:1.5vw;text-align:center;">COMPRAS-VENTAS MES</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
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
            texto=texto + '<div class="flow-text blue lighten-3" style="font-size:1.5vw;text-align:center;">COMPRAS-VENTAS ACUMULADAS A&Ntilde;O</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
             
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="buscarDatos2();">Generar Informe</a><center>';   
            
            
            //texto=texto + '<center><div class="input-field col s6"><a class="waves-efect waves-light btn">Generar Informe</a></div></center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
        }
        
        function Vent_vs_Ano_Ant_Mes(){
            //document.getElementById('formu').innerHTML='hola';
            texto='';
            //texto=texto + '<div class="col s6">';
            texto=texto + '<div class="flow-text blue lighten-3" style="font-size:1.5vw;text-align:center;">VENTAS MES A&Ntilde;O ANT VS A&Ntilde;O ACT </div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
             
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="buscarDatos3();">Generar Informe</a><center>';   
            
            
            //texto=texto + '<center><div class="input-field col s6"><a class="waves-efect waves-light btn">Generar Informe</a></div></center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
        }
        
        function Vent_vs_Ano_Ant_Acum(){
            //document.getElementById('formu').innerHTML='hola';
            texto='';
            //texto=texto + '<div class="col s6">';
            texto=texto + '<div class="flow-text blue lighten-3" style="font-size:1.5vw;text-align:center;">VENTAS A&Ntilde;O ACTUAL vs ANTERIOR ACUMULADAS</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Mes"></label>';
            texto=texto + '</div>';
             
            texto=texto + '<br /><center><a class="waves-efect waves-light btn" onclick="buscarDatos4();">Generar Informe</a><center>';   
            
            
            //texto=texto + '<center><div class="input-field col s6"><a class="waves-efect waves-light btn">Generar Informe</a></div></center>';
            
            document.getElementById('formu').innerHTML=texto;
            return true;
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
                            <br /><div class="flow-text" style="font-size:3vw;text-align:right;">INFORME MES COMERCIAL AG</div>
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
                            <!--<li><a href="javascript:Comp_Vent_Mes()">Comp_Vent_Mes</a></li>
                            <li><a href="javascript:Comp_Vent_Acum()">Comp_Vent_Acum</a></li>
                             <li><a href="javascript:Vent_vs_Ano_Ant_Mes()">Ventas_Mes_A&ntilde;o_Ant_vs_A&ntilde;o_Act </a></li>
                            <li><a href="javascript:Vent_vs_Ano_Ant_Acum()">Vent_vs_A&ntilde;o_Ant_Acum</a></li>-->
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
                                 <span style="color: #000000;">GENERACI&Oacute;N DE INFORMES</span>
                             </div>
                            
                                                      
                          <!--subir grupos-->
                          <br /><hr />
                          <!--<form enctype="multipart/form-data" action="index.php" method="POST">
                          <table style="width: 98%; background-color: #CDCDCD;">
                            <tr><td colspan="2" style="text-align: center;"><label class="black-text"><b>A&Ntilde;ADIR GRUPO</b></label><hr /></td></tr>
                            <tr>
                               <td style="width: 40%;">
                                    <label class="black-text"><b>GRUPO:</b></label> 
                                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" class="black-text" id="grupo" maxlength="3" />
                                </td>
                                
                                <td>
                                    <label class="black-text"><b>MANEJADOR:</b></label> 
                                <select id="maneja" class="browser-default light-blue-text" style="width: 200hw;">
                                    <option value="" disabled selected>Seleccione Manejador </option>
                                    <?php
                                    /*require_once('conectarbase.php');
                                    $resultSQLG = mssql_query("SELECT DISTINCT(RESPONSABLE) FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] GROUP BY RESPONSABLE");
                                    while($resultadog = mssql_fetch_array($resultSQLG)){
                                        $responsable=$resultadog["RESPONSABLE"];
                                        $responsable=trim($responsable);
                                        echo "<option value=\"$responsable\">$responsable</option>";
                                    }*/
                                    ?>
                                </select>
                                </td>
                            </tr>
                            
                            <tr>
                            <td colspan="2">
                                <label class="black-text"><b>CATEGOR&Iacute;A:</b></label> 
                                <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" class="black-text" id="Categoria" maxlength="50" /><br />
                            </td>                            
                            </tr>
                            
                            <tr>
                                <td colspan="2">
                                    <a class="waves-efect waves-light btn" onclick="Guardar_Grupo();">Guardar Grupo</a> 
                                </td>
                              
                          </tr>
                          </table>
                          </form>-->
                          
                          <br /><hr />
                          
                          <!--inicio-->
                          <div style="width: 98%; background-color: #CDCDCD;">
                          <br /><label class="black-text"><b>SUBIR VENDEDORES</b></label>
                          <br /><label class="black-text"><b>Excel: AREA - VENDEDOR - ACTIVO</b></label>
                          <br />
                          <select id="area" class="browser-default light-blue-text" style="width: 200hw;">
                                <option value="" disabled selected>Area </option>
                                <option value="CALL">CALLCENTER</option>
                                <option value="VE">VENTA EXTRNA</option>
                                <option value="AL">ALMACEN</option>
                                <option value="RAPPI">RAPPI</option>
                                <option value="WEB">PAGINA WEB</option>
                          </select>
                          <br />
                          <a class="waves-efect waves-light btn" onclick="subrirVendedores();">Guardar Vendedores</a>
                          <br /><hr /><br />
                          <a class="waves-efect waves-light btn" onclick="subrirTipoCuotas();">Guardar Tipo Cuotas</a>
                                  <!--<form enctype="multipart/form-data" action="index.php" method="POST">-->
                                            <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
                                   <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" />-->
                                            <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
                                   <!-- <input name="fichero_usuario" type="file" class="waves-efect waves-light btn"  /><br /><br />-->
                                            <!--<input type="submit" class="waves-efect waves-light btn" name="Enviar" value="Enviar fichero" />-->
                                    
                                <!--    <br /><br />-->
                                <!--</form>-->
                          </div><br />
                                <?php
                                // En versiones de PHP anteriores a la 4.1.0, deber�a utilizarse $HTTP_POST_FILES en lugar
                                // de $_FILES.
                                if (isset($_POST['Enviar'])){
                                    $dir_subida = '/var/www/html/modulo_plan/infventasiniva/';
                                    $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);
                                    if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
                                        echo "El archivo se subio bien.\n";
                                    } else {
                                        echo "�Falla de subida de archivo!\n";
                                    }
                                    sleep(5);
                                    //ENVIA DATOS A LA BASE DEL MES
                                    //excel
                                    $archis=$_FILES['fichero_usuario']['name'];
                                    //$miruta='Meses';
                                    //$mipath=$miruta.'/'.$archis;
                                    $mipath=$archis;
                                    if(file_exists($mipath)) {
                                        include('conectarbase.php');
                                        //lee excel
                                        include('Classes/PHPExcel.php');
                                        $inputFileType = PHPExcel_IOFactory::identify($mipath);
                                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                        $objPHPExcel = $objReader->load($mipath);
                                        $sheet = $objPHPExcel->getSheet(0); 
                                        $highestRow = $sheet->getHighestRow(); 
                                        $highestColumn = $sheet->getHighestColumn();
                                        for ($row = 2; $row <= $highestRow; $row++){ 
                                            $grp=trim($sheet->getCell("A".$row)->getValue());
                                            //$vrl=trim($sheet->getCell("B".$row)->getValue());
                                            //$per=trim($sheet->getCell("C".$row)->getValue());
                                            //$vrl=str_replace("$","",$vrl);
                                            //copia el mes actual o ultimo ya registrado en la tabla actual a la anterior si es enero coge el mes anterior a�o anterior
                                            /*$mesi=substr($per,4,2);
                                            $anio=substr($per,0,4);
                                            if(intval($mesi)==1 || $mesi=="01"){
                                                $mesi=12;
                                                //a�o anterior y mes
                                                $anio=(intval($anio)-1);
                                                $per3=$anio.$mesi;
                                            }else{
                                                $mesi=(intval($mesi)-1);
                                                if(strlen($mesi)==1){
                                                    $mesi="0".$mesi;
                                                }
                                                $per3=$anio.$mesi;
                                            }*/
                                            $dato2='';
                                            $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasSinIva] WHERE ITEM='".$grp."'");
                                            if (!mssql_num_rows($query)) {
                                                $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentasSinIva](ITEM,DESCRIPCION)VALUES('$grp','')"; 
                                                mssql_query($sqlv,$cLink);
                                            }
                                        }
                                        echo "  Datos de items excentos de iva fueron actualizados correctamente. ";
                                        unset($objPHPExcel);
                                        unset($objReader);
                                        //copia el mes anterior al subido actual de tabla sig a la ant
                                            /*$dato2='';
                                            $query2 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infConsolidadoInvSig] WHERE PERIODO='".$per3."'");
                                            while($resultado2 = mssql_fetch_array($query2)){
                                                $grp=$resultado2["GRUPO"];
                                                $vrl=$resultado2["COSTO_TOTAL"];
                                                $per=$resultado2["PERIODO"];
                                                $query3 = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infConsolidadoInvAnt] WHERE GRUPO='".$grp."' AND PERIODO='".$per."'");
                                                if (!mssql_num_rows($query3)) {
                                                    $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infConsolidadoInvAnt](GRUPO,COSTO_TOTAL,PERIODO) VALUES('$grp','$vrl','$per')"; 
                                                    mssql_query($sqlv,$cLink);
                                                }
                                            }
                                            echo "  Datos de inventario periodo anterior ".$per." fueron actualizados correctamente. ";
                                            */
                                        mssql_close();
                                    }else{
                                        echo "Archivo no encontrado en el servidor. datos no fueron actualizados.";
                                    }
                                }
                                ?>
                          <!--final-->
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
         <div id="estado" class="col s3 m3 l2 xl3" style="width: 200hw;">
         
         </div>
     </div>
     
        
      <!--fin container-->  
    </div>
    
    
    
</body>
</html>