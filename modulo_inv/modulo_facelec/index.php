<html>
<head>
<title>Facturaci&aacute;n electr&oacute;nica</title>

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
        .celdaa {
            background-color: aqua;
        }
        .celdab {
            background-color: beige;
        }
        .celdac {
            background-color: white;
        }
        </style>
<script language="JavaScript">
            //alert(screen.width);
            if (screen.width <= 800)
            {
            //alert(screen.width);
            document.write('<link href="css/estilos.css" rel="stylesheet" type="text/css" />');
            }
            
            if (screen.width > 800 && screen.width <= 1024)
            {
            document.write('<link href="css/estilos1024.css" rel="stylesheet" type="text/css" />');
            }
            
            if (screen.width > 1024 && screen.width <= 1280)
            {
            document.write('<link href="css/estilos1280.css" rel="stylesheet" type="text/css" />');
            }
            
            if (screen.width >= 1280)
            {
            document.write('<link href="css/estilos1800.css" rel="stylesheet" type="text/css" />');
            }
             
            function verLink(valor) {
                document.getElementById('mensaje').innerHTML = '<a href="'+valor+'" target="_new"><h4>Descargar</h4></a>';
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
            
            function habilitafacturaibs(){
                var factura = document.getElementById('F2').value;
                var emp = document.getElementById('emp').value;
                
                if (factura==''){
                    alert('Busque la factura');
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
                peticion_http.open('POST', 'habilitarfacturaibs.php?f=' + factura + '&emp=' + emp, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert(dato);
                            document.getElementById('Habilita').focus();
                        }
                    }
                }
            }
            
            function habilitafacturaibs2(){
                var facturai = document.getElementById('F1I').value;
                var emp = document.getElementById('emp').value;
                if (facturai==''){
                    alert('Digite factura inicial');
                    return false;
                }
                var facturaf = document.getElementById('F1F').value;
                if (facturaf==''){
                    alert('Digite factura final');
                    return false;
                }
                var fecha = document.getElementById('Fe').value;
                if (fecha==''){
                    alert('Digite fecha AñoMesDia');
                    return false;
                }
                if(fecha.length < 8 || fecha.length > 8){
                    alert('La fecha debe tener 8 digitos');
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
                peticion_http.open('POST', 'habilitafacturaibs2.php?fi=' + facturai + '&ff=' + facturaf + '&fe=' + fecha + '&emp=' + emp, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert(dato);
                            document.getElementById('mensaje').innerHTML=dato;
                            verLink('facturas.txt');
                            //alert('facturas.txt');
                        }
                    }
                }
            }
            
            //CONSULTA DE DATOS POR CODIGO
            function buscafacturaibs() {
                var factura = document.getElementById('F1').value;
                var emp = document.getElementById('emp').value;
                if (factura==''){
                    alert('Digite factura');
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
                peticion_http.open('POST', 'buscafacibs.php?f=' + factura + '&emp=' + emp, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            var datos = dato.split('^');
                            factura=datos[0];
                            orden=datos[1];
                            emision=datos[2];
                            cliente=datos[3];
                            novedad=datos[4];
                            facdian=datos[5];
                            estado=datos[6];
                            formu='<table>';
                            formu=formu + '<tr>';
                            formu=formu + '<td>Factura: <input type="text" class="texto2" id="F2" maxlength="18" autofocus="true" value="'+factura+'" readonly="true" /></td>';
                            //if(facdian.length < 5){
                                formu=formu + '<td>&nbsp;<input type="button" class="boton5" id="Habilitarfac" value="HABILITAR" onclick="habilitafacturaibs();" /></td>';
                            //}
                            formu=formu + '</tr>';
                            
                            formu=formu + '<tr>';
                            formu=formu + '<td>Orden: <input type="text" class="texto2" id="F3" maxlength="18" autofocus="true" value="'+orden+'" readonly="true" /></td>';
                            formu=formu + '</tr>';
                            
                            formu=formu + '<tr>';
                            formu=formu + '<td>&nbsp;</td>';
                            formu=formu + '</tr>';
                            
                            formu=formu + '<tr>';
                            formu=formu + '<td>Mensaje: <label>'+novedad+'</label></td>';
                            formu=formu + '</tr>';
                            
                            formu=formu + '<tr>';
                            formu=formu + '<td>&nbsp;</td>';
                            formu=formu + '</tr>';
                            
                            formu=formu + '<tr>';
                            formu=formu + '<td>Estado: <label>'+estado+'</label></td>';
                            formu=formu + '</tr>';
                            
                            formu=formu + '</table>';
                            document.getElementById('F1').value='';
                            document.getElementById('F1').focus();
                            document.getElementById('mensaje').innerHTML=formu;
                        }
                    }
                }
            }
            
            function buscafacturaibs2() {
                var facturai = document.getElementById('F1I').value;
                var emp = document.getElementById('emp').value;
                if (facturai==''){
                    alert('Digite factura inicial');
                    return false;
                }
                var facturaf = document.getElementById('F1F').value;
                if (facturaf==''){
                    alert('Digite factura final');
                    return false;
                }
                if(eval(facturai) > eval(facturaf)){
                    alert('La factura inicial no puede ser mayor a la factura final');
                    return false;
                }
                var fecha = document.getElementById('Fe').value;
                if (fecha==''){
                    alert('Digite fecha AñoMesDia');
                    return false;
                }
                if(fecha.length < 8 || fecha.length > 8){
                    alert('La fecha debe tener 8 digitos');
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
                peticion_http.open('POST', 'buscafacibs2.php?fi=' + facturai + '&ff=' + facturaf + '&fe=' + fecha + '&emp=' + emp, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            document.getElementById('mensaje').innerHTML=dato;
                        }
                    }
                }
            }
            
            
            
                                   
             /*TECLA ENTER DETECT*/
              function onKeyUp(event,nombre) {
                var keycode = event.keyCode;
                //if(keycode == '13'){
                    if(nombre=='T1'){
                        consultarDatos(); 
                    }
                    if(nombre=='G1'){
                        document.getElementById('Iniciar').click();  
                    }
                    if(nombre=='T4'){
                        document.getElementById('T1').focus(); 
                    }
                //}
              }
              
              function onKeyUp2(event,nombre) {
                var keycode = event.keyCode;
                //if(keycode == '13'){
                    if(nombre=='T1'){
                        consultarDatos2(); 
                    }
                    if(nombre=='G1'){
                        document.getElementById('Iniciar').click();  
                    }
                    if(nombre=='T4'){
                        document.getElementById('T1').focus(); 
                    }
                //}
              }
              
              
              
      
            
</script>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="marcov" class="marco">
                    <div style="padding: 50px;">
                    <label class="e1"><b>GESTI&Oacute;N DE FACTURACI&Oacute;N ELECTR&Oacute;NICA </b></label> <br />
                    <label class="e2"><b>SELECCIONE EMPRESA:</b></label>
                    <select id="emp" class="lista">
                    <option value="AG">Agrocampo</option>
                    <option value="X1">Pestar</option>
                    <option value="ZZ">Comervet</option>
                    </select><br />
                    <br />
                    <table class="tabla" style="border:1px solid #000000;">
                    <tr style="height: 80%;">
                    <td style="height: 50px; width: 20%;">
                        <label class="e2">FACTURA: </label> &nbsp;
                    </td>
                    <td style="height: 50px; width: 20%;">
                        <input type="text" class="texto2" id="F1" maxlength="18" autofocus="true" autocomplete="off" />
                    </td>
                    <td style="height: 50px; width: 20%;">
                        <input type="button" class="boton5" id="Habilita" value="BUSCAR FACTURA IBS" onclick="buscafacturaibs();" />
                    </td>
                    <td style="height: 50px; width: 20%;"></td>
                    <td style="height: 50px; width: 20%;"></td>
                    </tr>
                    </table>                  
                    <br />                    
                    </div>
                    <!--varais-->
                    <div style="padding: 50px;">
                    <label class="e1"><b>GESTI&Oacute;N DE MULTIPLES FACTURAS ELECTR&Oacute;NICAS </b></label> <br /><br />
                    <table class="tabla" style="border:1px solid #000000;">
                    <tr style="height: 90%;">
                    <td style="height: 50px; width: 10%;">
                        <label class="e2">FECHA (yyyyMMdd): </label> &nbsp;
                    </td>
                    <td style="height: 50px; width: 10%;">
                        <input type="text" class="texto2" id="Fe" maxlength="18" autofocus="true" autocomplete="off" />
                    </td>
                    <td style="height: 50px; width: 10%;">
                        <label class="e2">FACTURA INICIAL: </label> &nbsp;
                    </td>
                    <td style="height: 50px; width: 10%;">
                        <input type="text" class="texto2" id="F1I" maxlength="18" autofocus="true" autocomplete="off" />
                    </td>
                    <td style="height: 50px; width: 10%;">
                        <label class="e2">FACTURA FINAL: </label> &nbsp;
                    </td>
                    <td style="height: 50px; width: 10%;">
                        <input type="text" class="texto2" id="F1F" maxlength="18" autofocus="true" autocomplete="off" />
                    </td>
                    
                    </tr>
                    <tr>
                    <td colspan="6">
                        <input type="button" class="boton5" id="Habilita2" value="BUSCAR FACTURAS IBS" onclick="buscafacturaibs2();" />
                    </td>
                    </tr>
                    </table>                  
                    <br />                    
                    </div>
                    
                    <div id="mensaje">

                    </div>
                    <br />
                    <div id="formula">

                    </div>
                    
<br /><br />
</div>
</body>
</html>