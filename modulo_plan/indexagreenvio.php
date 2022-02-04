<?php
    if(session_start()===FALSE){
        session_start();
    }
//lee las fotos de las carpetas del 1 al 13 (Categorias))
/*$numCat=1;
$tmp="";
$FotosCat=new ArrayIterator();
while($numCat<=13){
    $folder_path = 'FOTOSPLAN/'.$numCat.'/'; 
    $num_files = glob($folder_path . "*.{JPG,jpeg,gif,png,bmp}", GLOB_BRACE);
    $folder = opendir($folder_path); 
    //$tmp=$numCat."^";
    if($num_files > 0){
     while(false !== ($file = readdir($folder)))  {
      //$file_path = $folder_path.$file;
      $extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
      if($extension=='jpg' || $extension =='png' || $extension == 'gif' || $extension == 'bmp') {
         $tmp.=$file."^"; 
      }
      }
      }
      $FotosCat[$numCat]=$tmp;
      $numCat++;
  }
  $fotosxCat=explode("^",$FotosCat[2]);
  $elementos=count($fotosAparte)-2;
  //echo $elementos-2;
  
  echo $fotosxCat[0];
  echo $fotosxCat[1];
  echo $fotosxCat[2];
  echo $fotosxCat[3];
  */
//closedir($folder);
//&eacute;
//$var="<img src=\'FOTOSPLAN/1/Celular.png\'>";
//preg_match("/([^\/\']+)(\.\w+)/",$var, $image);
//echo $image[0]; 
//echo "<br /><br /><p><center><STRONG>El Plan año 2020 se encuentra cerrado, Gracias por su visita! los esperamos su visita en <a href='https://www.agrocampo.com.co/'>Agrocampo - Todo en veterinaria</a></STRONG></p></center>";
//echo "<br /><br /><center><img src='images/logoAG.png'></center>";
//exit();
    //include('conexionodbc.php');
    //$consulta = "select * from zAgroPremios2019 WHERE Nombre like '%luis%'";
    //$resultado = odbc_exec($connection,$consulta);
    /*while (odbc_fetch_row($resultado))
         {
         $result = odbc_result($resultado,"Nombre");
         echo $result." <br />  ";
        }
    odbc_close($connection);*/
//exit();

//CONECCION DB2
//include("../user_con.php");
//include("conexion.php");

//echo $localhostL." --- ".$claveO;
 //$cierre=date("dmY");
 //echo $cierre;
  /*if ($cierre=="18042019" || $cierre=='18042019'){
    echo "PLAN PREMIOS AÑO 2019 SE ENCUENTRA CERRADO. GRACIAS POR SU VISITA.!";
   exit();
 } */
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
        <link href="css/estilos.css" rel="stylesheet" type="text/css" />
        <!--<link href="css/fuentes.css" rel="stylesheet" type="text/css" />-->
        <title>FORMULARIO PLAN A&Ntilde;O 2022</title>
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
            
            function confirmaFirma(){
                alert('hola');
                document.getElementById('dibujo').value='1'
            }
            /*public boolean onTouchEvent(MotionEvent event) 
             {
                    int accion = event.getAction();  
                    int X = (int)event.getX();
                    int Y = (int)event.getY();
                    switch (accion)
            	       {
                		//case MotionEvent.ACTION_DOWN:   // Pulsar pantalla          
                		//document.getElementById('coord').value=X;  
                		//break;
                		
                		case MotionEvent.ACTION_MOVE:   // Arrastrar dedo
                		document.getElementById('coord').value=X;
                		break;
                
                		//case MotionEvent.ACTION_UP:     // Levantar el dedo de la pantalla
          	            //document.getElementById('coord').value=X;
                		//break; 
                    }
                    return true;
            } */       
            
            //capturar eventos del canvas
            window.onload = function(){
            	var rect = document.getElementById('canvas');
            	// Agregar evento al canvas touchmove
            	rect.addEventListener('mousedown',onDown,false);
               	function onDown(event){
            		cx = event.pageX;
                    document.getElementById('coord').value=cx;
            	}
                rect.addEventListener('touchstart',onDown2,false);
                function onDown2(event){
            		//cx = event.valueOf();
                    document.getElementById('coord').value=1;
            	}
                rect.addEventListener('touchmove',onDown3,false);
                function onDown3(event){
            		//cx = event.valueOf();
                    document.getElementById('coord').value=1;
            	}
                rect.addEventListener('touchend',onDown4,false);
                function onDown4(event){
            		//cx = event.valueOf();
                    document.getElementById('coord').value=1;
            	}
                rect.addEventListener('touchleave',onDown5,false);
                function onDown5(event){
            		//cx = event.valueOf();
                    document.getElementById('coord').value=1;
            	}
            }
            
            
            
            
            /*var xIni;
            var yIni;
            var canvas = document.getElementById('canvas');
                  canvas.addEventListener('touchstart', function(e){
                  if (e.targetTouches.length == 1) { 
                    var touch = e.targetTouches[0]; 
                    xIni = touch.pageX;
                    yIni = touch.pageY;
                    document.getElementById('coord').value=xIni;
            }
            }, false);*/
            
            function verificaFirma(){
                var canvas = document.getElementById("myCanvas");
                var ctx = canvas.getContext("2d");
                var tamanio=ctx.Size;
                alert(tamanio);
            }
            
            function manejoDatospersonales(estado){
                if (estado==true){
                    document.getElementById('manejodatos').value='1';
                    //GuardarTrazado();
                }else if(estado==false){
                    document.getElementById('manejodatos').value='0';
                    //GuardarTrazado();
                }
                var texto='<div class="descricondiciones"><br />';
                    texto=texto + '<label class="titulodatos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONSENTIMIENTO PARA TRATAMIENTO DE DATOS PERSONALES</label> <BR /><BR /> ';
                    texto=texto + '<label class="parrafofin">De acuerdo con la Ley Estatutaria 1581 de 2012 de Protección de Datos y normas concordantes, ';
                    texto=texto + 'autorizo como Titular de los datos, para que éstos sean incorporados en una base de datos ';
                    texto=texto + 'responsabilidad de AGROCAMPO S.A.S, para que sean tratados con la finalidad de realizar gestión ';
                    texto=texto + 'administrativa, gestión de estadísticas internas, gestión de cobros y pagos, gestión de facturación,  ';
                    texto=texto + 'gestión económica y contable,  gestión fiscal, histórico de relaciones comerciales, verificación ';
                    texto=texto + 'de datos, marketing, publicidad propia, prospección comercial, segmentación de mercados, envío de ';
                    texto=texto + 'comunicaciones a través de los medios registrados y transmisión y transferencia de datos personales a terceros autorizados.';
                    texto=texto + '<BR /><BR /> Es de carácter facultativo suministrar información que verse sobre Datos Sensibles, entendidos como aquellos ';
                    texto=texto + 'que afectan la intimidad o generen algún tipo de discriminación, o sobre menores de edad.<BR />';
                    texto=texto + '<BR />El titular de los datos podrá ejercitar los derechos de acceso, corrección, supresión, revocación o reclamo por';
                    texto=texto + ' infracción sobre mis datos, mediante un escrito dirigido a AGROCAMPO S.A.S., a la dirección de correo electrónico protección.';
                    texto=texto + 'datos@agrocampo.com.co indicando en el asunto el derecho que desea ejercitar, o mediante correo ordinario remitido ';
                    texto=texto + 'a la Calle 73 # 20-62</label><BR /></div>'
                    document.getElementById('autorizacion').innerHTML=texto;
                    document.getElementById('datosper').style.visibility='visible';
                    document.getElementById('dper').style.visibility='visible';
            }
            
            function consultarDatos(empresa) {
                var d1 = document.getElementById('T1').value;
                var tmp='';
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                //peticion_http.open('POST', 'buscarplanpes.php?emp=' + empresa + '&d1=' + d1, true);
                peticion_http.open('POST', 'buscarplanreenvio.php?emp=' + empresa + '&d1=' + d1, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        //alert("Usted ya entro en el plan año 20201.");
                        if (peticion_http.status == 200) {
                            //alert("Usted ya entro en el plan año 20202.");
                            var dato = peticion_http.responseText;
                            if (dato.length <= 23) {
                                alert("Datos no encontrados!");
                                LimpiarFormulario();
                                return false;
                            } else {
                                var datos = dato.split('^');
                                //alert(datos[13]+'  '+datos[14]+'  '+datos[15]);
                                //ya eligio premio bloquea nuevas elecciones
                               /*if(datos[12].length > 3){
                                    alert("Usted ya registro el plan año 2021.");
                                    setTimeout("location.reload(true);", 200);
                                    return false;
                                }else{*/
                                    //document.getElementById('nplan').innerHTML = 'REGISTRO PLAN A&Ntilde;O 2020 #:' + datos[10];
                                    document.getElementById('T2').value = datos[0];
                                    document.getElementById('T3').value = datos[1];
                                    document.getElementById('F').value = datos[2];
                                    document.getElementById('T4').value = datos[2];
                                    document.getElementById('T5').value = datos[3];
                                    document.getElementById('T6').value = datos[4];
                                    document.getElementById('T7').value = datos[5];
                                    document.getElementById('T8').value = datos[6];
                                    document.getElementById('T9').value = datos[7];
                                    document.getElementById('T10').value = datos[8];
                                    var monto = datos[9].replace('$', '');
                                    monto = monto.replace('.', '');
                                    monto = monto.replace(',', '');
                                    if (isNaN(monto)){
                                        monto='0';
                                    }
                                    //monto adicional
                                    var monto2 = datos[18];//.replace('$', '');
                                    //monto2 = monto2.replace('.', '');
                                    //monto2 = monto2.replace(',', '');
                                    /*if (isNaN(monto2)){
                                        monto2='0';
                                    }*/
                                    document.getElementById('monto2').value=monto2;
                                    document.getElementById('T11').value = '$ ' + datos[9];
                                    document.getElementById("Categoria").value = datos[11];
                                    //verCategorias(parseInt(datos[11]));
                                    if(empresa=='AG'){
                                        consultarPremios();
                                    }else if(empresa=='X1'){
                                        //consultarPremiosx1();
                                        var p1=datos[13];
                                        var p2=datos[14];
                                        var p3=datos[15];
                                        //porcentajes adicionales
                                        var p4=datos[16];
                                        var p5=datos[17];
                                        consultarPorcentajes(p1,p2,p3);
                                        descripcionPremios(p1,p2,p3);
                                    }
                                    manejoDatospersonales();
                                //}
                            }
                        }
                    }
                }
            }
            
            function descripcionPremios(p1,p2,p3){
                var descripcion='';
                var x='';
                descripcion='<ol>';
                x=p1.indexOf("0%");
                if(x==-1){
                descripcion=descripcion + '<li><label class="parrafo">Premio a&ntilde;o para la empresa en mercanc&iacute;a al final del a&ntilde;o comercial del ' + p1 + ' del total de las compras despu&eacute;s de descuentos.</label></li>';
                }
                x=p2.indexOf("0%");
                if(x==-1){
                descripcion=descripcion + '<li><label class="parrafo">Premio a&ntilde;o para la empresa en Nota Cr&eacute;dito al final de a&ntilde;o comercial del ' + p2 + ' del total de las compras despu&eacute;s de descuentos.</label></li>';
                }
                x=p3.indexOf("0%");
                if(x==-1){
                descripcion=descripcion + '<li><label class="parrafo">Incentivos vendedores: Bonos o mercanc&iacute;a ' + p3 + ' sobre las compras despu&eacute;s de descuentos, que se liquidar&aacute;n semestralmente y proporcional al cumplimiento del negocio a&ntilde;o para que se entregue a los vendedores de mostrador y externos por cumplimiento de ventas, para esto se debe entregar relaci&oacute;n firmada con valor por vendedor que recibi&oacute; el incentivo.<br /> Esta nota podr&aacute; ser cambiada por bonos Sodexo Pass, previa autorizaci&oacute;n del representante legal.</label></li>';
                }
                descripcion=descripcion + '</ol>';
                document.getElementById('descripremios').innerHTML=descripcion;
            }
            
            function consultarPorcentajes(p1,p2,p3){
                //var d1 = document.getElementById('Categoria').value;
                var imagen='';
                var parar=0;
                var mas='';
                var premio1='';
                var premio2='';
                var premio3='';
                var premio='';
                var x=0;
                //if(d1=='1' && parar=='0'){
                    parar=1;
                    mas="<label id=\"mas\" style=\"width: 50%;background-color: #F1F3F4; text-align: center; font-size: 2.2em;\">+</label>";
                    x=p1.indexOf("0%");
                    if(x==-1){
                    //if(p1!='0%'){
                        imagen="<div class=\"fondopre\"><table style=\"border: 0;width: 98%;\"><tr><td style=\"width: 50%;\">Premio a&ntilde;o para la empresa en mercancía al final del año comercial del "+p1+" del total de las compras después de descuentos.</td>";
                        //imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Celular.png\" alt=\"premio\" style=\"width: 98%;\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Sistema operativo: android 9.0, memoria interna 64 GB, memoria Ram 4G, dual sim, procesador octa Core 2.0 Ghz, camara posterior dual 13 Mpx,  2 Mpx, camara frontal   8 Mpx.</label> </td></tr></table>";
                        //imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><input type=\"radio\" name=\"2\" value=\"Premio año para la empresa en mercancía\" id=\"PremioMercancia\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id);\">SELECCIONAR<br /><br /></td></tr></table>";
                        imagen=imagen + "</tr></table></div>";
                        imagen=imagen + "<table><tr><td>"+mas+"</td></tr></table>";
                        //imagen=imagen + "<table><tr><td>"+mas+"</td></tr></table>";
                        document.getElementById('fotosp1').innerHTML = imagen;
                        premio1="Premio año para la empresa en mercancía del " + p1;
                    }
                    //imagen2
                    x=p2.indexOf("0%");
                    if(x==-1){
                    //if(p2!='0%'){
                        //imagen="<table><tr><td>"+mas+"</td></tr></table>";
                        imagen=imagen + "<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 50%;\">Premio a&ntilde;o para la empresa en Nota Cr&eacute;dito al final de año comercial del "+p2+" del total de las compras despu&eacute;s de descuentos.</td>";
                        //imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Esquiladora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\"> 3 velocidades: 3.100/3.600/4.100 rpm, peso: 350 g, medidas: 17,5 x 4,5 x 4,1 cm, longitud del cable: 3,66 m.</label></td></tr></table>";
                        //imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><input type=\"radio\" name=\"2\" value=\"Premio año para la empresa en Nota Creditodito\" id=\"PremioNotaCredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id);\">SELECCIONAR<br /><br /></td></tr></table>";
                        imagen=imagen + "</tr></table></div>";
                        imagen=imagen + "<table><tr><td>"+mas+"</td></tr></table>";
                        
                        document.getElementById('fotosp2').innerHTML = imagen;
                        //alert(imagen);
                        premio2=premio+"Premio año para la empresa en Nota Crédito del " + p2;
                    }
                    //imagen 3
                    x=p3.indexOf("0%");
                    //alert(x);
                    //if(p3!='0%'){
                    if(x==-1){
                        //imagen="<table><tr><td>"+mas+"</td></tr></table>";
                        imagen=imagen+"<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 50%;\">Incentivos vendedores: Bonos o mercanc&iacute;a "+p3+" sobre las compras después de descuentos.</td>";
                        //imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Multifuncional.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\"> Scanea, imprime y copia, velocidad de Impresión: 20 ppm, resolución impresión: 1200 x 1200 dpi, resolución escaner: 4800 x 4800, conectividad: wifi.</label></td></tr></table>";
                        //imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><input type=\"radio\" name=\"2\" value=\"Incentivos vendedores: Bonos o mercancía sobre compras\" id=\"PremioIncentivosBonosMercancia\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id);\">SELECCIONAR<br /><br /></td></tr></table>";
                        imagen=imagen+"</tr></table></div>";
                        
                        document.getElementById('fotosp3').innerHTML = imagen;
                        //premio=premio+" + Incentivos vendedores: Bonos o mercancía sobre compras del " + p1;
                        premio3=premio+"Incentivos vendedores: Bonos o mercancía sobre compras del " + p3;
                    }
                    //document.getElementById('fotosp5').innerHTML = "<BR /><center><HR /><B><input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" style=\"width: 20px;\" id=\"NOTA CREDITO 3\" onclick=\"seleccionarFoto(this.value,this.id);\">NOTA CR&Eacute;DITO 3%</B></center>";
                //}
                //document.getElementById('p1').textContent=p1;
                //document.getElementById('p2').textContent=p2;
                //document.getElementById('p3').textContent=p3;
                
                //descripcion del premio
                if(premio1!='' && premio2!='' && premio3!=''){
                    premio=premio1 + '; ' + premio2 + '; ' + premio3;
                } else if(premio1!='' && premio2!=''){
                    premio=premio1 + '; ' + premio2;
                }else if(premio2!='' && premio3!=''){
                    premio=premio2 + '; ' + premio3;
                }else if(premio1!='' && premio3!=''){
                    premio=premio1 + '; ' + premio3;
                }else if(premio1!='' && premio2=='' && premio3==''){
                    premio=premio1;
                }else if(premio1=='' && premio2!='' && premio3==''){
                    premio=premio2;
                }else if(premio1=='' && premio2=='' && premio3!=''){
                    premio=premio3;
                }
                
                //premio=premio1 + ' + ' + premio2 + ' + ' + premio3;
                document.getElementById('Premio').value=premio;
                document.getElementById('premioelegido').value=premio;
            }
            
            function seleccionarFoto(premio,premioelegido,tpp,nombreFoto,pos){
                //var subCadena = premio.substring(0, premio.length-4);
                //document.getElementById('Premio').value=subCadena;
                var condicion=document.getElementById('condiciones'+pos).value;  
                document.getElementById('Premio').value=premio;
                document.getElementById('premioelegido').value=premioelegido;
                document.getElementById('Tpp').value=tpp;
                document.getElementById('Textoimagen').value=nombreFoto;
                document.getElementById('condicion').value=condicion;
            }
            
            function verCategorias(valor) {
                if (parseFloat(valor) >= 13000000 && parseFloat(valor) <= 19999999) {
                    document.getElementById("Categoria").value = '1';
                } else if (parseFloat(valor) >= 20000000 && parseFloat(valor) <= 29999999) {
                    document.getElementById('Categoria').value = '2';
                } else if (parseFloat(valor) >= 30000000 && parseFloat(valor) <= 37999999) {
                    document.getElementById('Categoria').value = '3';
                } else if (parseInt(valor) >= 37000000 && parseInt(valor) <= 48999999) {
                    document.getElementById('Categoria').value = '4';
                } else if (parseFloat(valor) >= 42000000 && parseFloat(valor) <= 58999999) {
                    document.getElementById('Categoria').value = '5';
                } else if (parseFloat(valor) >= 53000000 && parseFloat(valor) <= 67999999) {
                    document.getElementById('Categoria').value = '6';
                } else if (parseFloat(valor) >= 63000000 && parseFloat(valor) <= 78999999) {
                    document.getElementById('Categoria').value = '7';
                } else if (parseFloat(valor) >= 78000000 && parseFloat(valor) <= 88999999) {
                    document.getElementById('Categoria').value = '8';
                } else if (parseFloat(valor) >= 95000000 && parseFloat(valor) <= 101999999) {
                    document.getElementById('Categoria').value = '9';
                } else if (parseFloat(valor) >= 100000000 && parseFloat(valor) <= 135999999) {
                    document.getElementById('Categoria').value = '10';
                } else if (parseFloat(valor) >= 125000000 && parseFloat(valor) <= 174999999) {
                    document.getElementById('Categoria').value = '11';
                } else if (parseFloat(valor) >= 164000000 && parseFloat(valor) <= 199999999) {
                    document.getElementById('Categoria').value = '12';
                } else if (parseFloat(valor) >= 200000000 && parseFloat(valor) <= 279999999) {
                    document.getElementById('Categoria').value = '13';
                } else {
                    document.getElementById('Categoria').value = 'N';
                }
                return true;
            }
            
            function utf8_encode (argString) { // eslint-disable-line camelcase
              if (argString === null || typeof argString === 'undefined') {
                return ''
              }
              // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
              const string = (argString + '')
              let utftext = ''
              let start
              let end
              let stringl = 0
              start = end = 0
              stringl = string.length
              for (let n = 0; n < stringl; n++) {
                let c1 = string.charCodeAt(n)
                let enc = null
                if (c1 < 128) {
                  end++
                } else if (c1 > 127 && c1 < 2048) {
                  enc = String.fromCharCode(
                    (c1 >> 6) | 192, (c1 & 63) | 128
                  )
                } else if ((c1 & 0xF800) !== 0xD800) {
                  enc = String.fromCharCode(
                    (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
                  )
                } else {
                  // surrogate pairs
                  if ((c1 & 0xFC00) !== 0xD800) {
                    throw new RangeError('Unmatched trail surrogate at ' + n)
                  }
                  const c2 = string.charCodeAt(++n)
                  if ((c2 & 0xFC00) !== 0xDC00) {
                    throw new RangeError('Unmatched lead surrogate at ' + (n - 1))
                  }
                  c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000
                  enc = String.fromCharCode(
                    (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
                  )
                }
                if (enc !== null) {
                  if (end > start) {
                    utftext += string.slice(start, end)
                  }
                  utftext += enc
                  start = end = n + 1
                }
              }
              if (end > start) {
                utftext += string.slice(start, stringl)
              }
              return utftext
            }
            
            function utf8_decode ( str_data ) {  
                var tmp_arr = [], i = ac = c1 = c2 = c3 = 0;  
              
                str_data += '';  
              
                while ( i < str_data.length ) {  
                    c1 = str_data.charCodeAt(i);  
                    if (c1 < 128) {  
                        tmp_arr[ac++] = String.fromCharCode(c1);  
                        i++;  
                    } else if ((c1 > 191) && (c1 < 224)) {  
                        c2 = str_data.charCodeAt(i+1);  
                        tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));  
                        i += 2;  
                    } else {  
                        c2 = str_data.charCodeAt(i+1);  
                        c3 = str_data.charCodeAt(i+2);  
                        tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));  
                        i += 3;  
                    }  
                }  
              
                return tmp_arr.join('');  
            }  
            
            function cambiarTildes() {
                  // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'cambiartildes.php', true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert(dato);
                        }
                    }
                }
            }
            
            function verPremios(cate) {
                  // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'verPremios.php?cate=' + cate , true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            var datos = dato.split('_');
                            var c=datos.length;
                            var f=0;
                            var datostxt='';
                            var imagen='';
                            var ruta='';
                            var texto1='';
                            var texto2='';
                            var nombrefoto='';
                            while(f<c-1){
                                datostxt = datos[f].split('^');
                                texto1=datostxt[0];
                                texto2=datostxt[1];
                                ruta='FOTOSPLAN/'+cate+'/'+datostxt[2];
                                nombrefoto=datostxt[2];
                                //V o P
                                texto3=datostxt[3];
                                imagen=imagen+"<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\"><label class=\"parrafo1\">"+texto1+"</label></td>";
                                imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\""+ruta+"\" alt=\"premio\" style=\"width: 98%;\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">"+texto2+"</label><input type=\"text\" id='condiciones"+f+"' value='"+texto2+"' style=\"visibility: hidden;\"> </td></tr></table>";
                                //imagen=imagen+"<input type=\"radio\" name=\"2\" value=\""+nombrefoto+"\" id=\""+nombrefoto+"\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'"+texto3+"','"+texto1+"','"+f+"');\">SELECCIONAR<br />";
                                imagen=imagen+"</div><hr />";
                            f++;
                            }
                            document.getElementById('fotosp5').innerHTML = imagen;
                        }
                    }
                }
            }
            
            
            //CONSULTA DE PREMIOS AGROCAMPO
            function consultarPremios(){
                var d1 = document.getElementById('Categoria').value;
                var imagen='';
                var parar=0;
                
                //CATEGORIA 1
                if(d1=='1' && parar=='0'){
                    //imagen="";
                    parar=1;
                    verPremios('1');   
                    //alert(x);            
                    //imagen2
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">ESQUILADORA MASCOTA 3 VEL</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Esquiladora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\"> 3 velocidades: 3.100/3.600/4.100 rpm, peso: 350 g, medidas: 17,5 x 4,5 x 4,1 cm, longitud del cable: 3,66 m.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Esquiladora mascotas 3 velocidades\" id=\"Esquiladora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen;
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Multifuncional Laser</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Multifuncional.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\"> Scanea, imprime y copia, velocidad de Impresión: 20 ppm, resolución impresión: 1200 x 1200 dpi, resolución escaner: 4800 x 4800, conectividad: wifi.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Multifuncional Laser\" id=\"Multifuncional\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen;
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea.<BR />NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE 2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    */
                    //document.getElementById('fotosp5').innerHTML = imagen;
                    //document.getElementById('fotosp5').innerHTML = "<BR /><center><HR /><B><input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" style=\"width: 20px;\" id=\"NOTA CREDITO 3\" onclick=\"seleccionarFoto(this.value,this.id);\">NOTA CR&Eacute;DITO 3%</B></center>";
                }else if(d1=='2' && parar==0){
                    parar=1;
                    //imagen="";
                    verPremios('2');                    
                    
                    /*
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Celular 128GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Celular.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Pantalla: 6.59&#34;,  procesador: Kirin 710 2.2GHz, RAM: 4GB, almacenamiento: 128GB, camara frontal: 16 MP, cámara posterior triple: 16MP+8MP+2MP, batería: 4000 mAh, android 9.0.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Celular 128GB\" id=\"Celular\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen;  
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">GENERADOR ECOMAX GASOLINA GE3300 3.3KVA</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Generador.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Voltaje:120/240, fases:1, rpm: 3600, potencia: 3.1 kVA, arranque: manual.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"GENERADOR ECOMAX GASOLINA GE3300 3.3KVA\" id=\"Generador\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen;//ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CERCA SOLAR EL CEBU 50 KM</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Cercasolar.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Alcance efectivo 50 kms. de alambre, energía de Salida: 4 Julios, máxima energía almacenada: 6 Julios, consumo de energía: 100 miliamperios, panel solar: 12 V 5 W, acumulador Interno: 12 V 7 AMP.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"CERCA SOLAR EL CEBU 50 KM\" id=\"Cercasolar\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">QUINDÍO, DECAMERON PANACA  2 NOCHES 3 DÍAS PARA 2 PERSONAS SIN TIQUETES</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Quindio.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 noches 3 días de alojamiento, para 2 adultos en la misma habitación en temporada baja, todas las comidas, desayunos y almuerzos tipo buffet, cenas a la carta en restaurantes especializados, snacks, bar abierto con bebidas y licores nacionales ilimitados, ingreso a PANACA,  impuestos hoteleros.<BR />NO INCLUYE: Tiquetes aéreos, Traslados terrestres, Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE QUINDÍO, DECAMERON PANACA  2 NOCHES 3 DÍAS PARA 2 PERSONAS SIN TIQUETES\" id=\"Quindio\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    */
                   // document.getElementById('fotosp5').innerHTML = imagen; //OK
                }else if(d1=='3' && parar==0){
                    parar=1;
                    verPremios('3');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Portátil 14 pulgadas;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Portatil.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Procesador: Intel Pentium Gold 5405U 2.3 Ghz, sistema Operativo: Windows 10 Home, memoria RAM: 4GB, disco Duro: 500GB, pantalla: 14 pulgadas.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Portátil 14\" id=\"Portatil 14\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">FUMIGADORA EST FORTE 6.5HP 28LT TF28 GM200 CERRADO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Fumigadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor: forte gm200 6.5hp, presión:0-500psi, caudal: 28 l/mln, pistones: acero 3*28mm diámetro, velocidades: 300-800 rpm.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"FUMIGADORA EST FORTE 6.5HP 28LT TF28 GM200 CERRADO\" id=\"Fumigadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Patineta Eléctrica-Scooter.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Patineta.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Material: aluminio, tamaño de la llanta o rin: 8, peso máximo del usuario 90 kg, velocidad máxima 10 km/hr, tipo de frenos: trasero de pie, potencia del motor:150 w, batería litio 22 v, tiempo de carga de la batería: 2 a 5 horas, no posee luces.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Patineta Eléctrica-Scooter.\" id=\"Patineta\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CALI 3 NOCHES 4 DÍAS EN FIN DE SEMANA HOTEL 4 ESTRELLAS.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Cali.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 3 noches 4 días de alojamiento en hotel 4 estrellas, para 2 adultos en la misma habitación en temporada baja para fin de semana, desayuno diario. NO INCLUYE: Tiquetes aéreos, Traslados terrestres, Tours , impuestos hoteleros y gastos no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE CALI 3 NOCHES 4 DÍAS EN FIN DE SEMANA HOTEL 4 ESTRELLAS\" id=\"Cali\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //ok
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;
                    */
                }else if(d1=='4' && parar==0){
                    parar=1;
                    verPremios('4');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">C&aacute;mara de Acción GOPRO HERO 8 BLACK</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Camara.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Megapixeles: 12 mp, zoom óptico: de 10x a 32x, zoom digital: de 10x a 32x, formato de video: hd 4k, tamaño de pantalla: 2 pulgadas, formato de grabación: sd.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Camara de Accion GOPRO HERO 8 BLACK\" id=\"Camara\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">PICAPASTO PP7MB2C CON BASE 2 CUCHILLAS</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Picapasto.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Producción Kg/h: 600 – 900, Boca de alimentación: 8&#34; Longitud de corte mm. 7 – 9 Velocidad del volante RPM: 200 – 220, Potencia necesaria en H.P. con dos cuchillas: 1.5, Diámetro del volante: 24&#34;, Diámetro polea motor a 1.750 RPM. Pulgadas: 3.0 TIPO A, Peso de la máquina 60 kg.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"PICAPASTO PP7MB2C CON BASE 2 CUCHILLAS\" id=\"Picapasto\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TELEVISOR 49&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Televisor.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Smart tv, resolución full hd, entradas HDMI y USB.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TELEVISOR 49\" id=\"Televisor\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen;  //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">PALOMINO 4 NOCHES 5 DÍAS.<BR />Ref: Agencia de Viajes Turismo Al Vuelo.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Palomino.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 4 noches 5 días de alojamiento para 2 adultos en la misma habitación en temporada baja en el Hotel Hukumeizi o similar , Traslados desde y hacia el  aeropuerto de Riohacha, Tour Parque de Los Flamencos, desayuno diario.<BR />NO INCLUYE: Tiquetes aéreos a Riohacha, alimentación no descrita en el programa, gastos no especificados en el programa  y/o de índole personal.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE PALOMINO 4 NOCHES 5 DÍAS\" id=\"Palomino\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO <BR />NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;*/
                }else if(d1=='5' && parar==0){
                    parar=1;
                    verPremios('5');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Consola Nintendo Switch Neon Blue- Red Joy-Con</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Consolanintendo.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Capacidad: 32 GB, Conexiones: Alambrica e Inalambrica, Color: Neon Blue- Red, Resolución: Accesorios 2 Joy Con.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Consola Nintendo Switch Neon Blue- Red Joy-Con\" id=\"Consolanintendo\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">MOTOBOMBA ECOMAX DIESEL 2X2 10 HP TBDY1862HYR</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Motobombaecomax.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor 4T, inyeccion directa,bomba de alta presion en hierro de 2&#34; de succion por descarga, refrigerado por aire forzado, caudal hasta 500 lpm, arranque manual.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"MOTOBOMBA ECOMAX DIESEL 2X2 10 HP TBDY1862HYR\" id=\"Motobombaecomax\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Nevera 375 Lt</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Nevera.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Tecnología de frío: no frost, tipo de refrigeración dual (congela y/o refrigera) capacidad en litros brutos: 375, capacidad en litros netos: 361, fabricador de hielo manual, eficiencia energética: A</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Nevera 375 Lt\" id=\"Nevera\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen;  //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SANTA MARTA 2 NOCHES 3 DÍAS CON TIQUETES DESDE BOGOTÁ<BR />Ref: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Santamarta.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá - Santa Marta- Bogotá, 2 noches 3 días de alojamiento para 2 adultos en la misma habitación en temporada baja, traslados aeropuerto hotel aeropuerto, todas las comidas, desayunos y almuerzos tipo buffet, bebidas y licores nacionales ilimitados,  impuestos hoteleros del tiquete e impuestos hoteleros. NO INCLUYE: Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SANTA MARTA 2 NOCHES 3 DÍAS CON TIQUETES DESDE BOGOTÁ\" id=\"Santamarta\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //ok
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;*/
                }else if(d1=='6' && parar==0){
                    parar=1;
                    verPremios('6');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">iPad Air 10.5&#34; Pulgadas Silver 64 GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/iPadAir.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Procesador: Chip A12 Bionic, Sistema Operativo: iOS, Memoria Interna: 64 GB, Pantalla: 10,5 Pulgadas.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"iPad Air 10.5&#34; Pulgadas Silver 64 GB\" id=\"iPadAir\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TRITURADOR DE FORRAJE JTRF70 MOTOR ELECTRICO + ESQUILADORA OSTER SHOWMASTER 078153-013-000</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Trituradorfollaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Triturador: Producción: hasta 900 kilos/hora Motor eléctrico 1.5 HP 3600 RPM - Incluido 4 Cribas. Esquiladora: Potencia130 W, Velocidad variable se ajusta de 700 a 3000 golpes por minuto.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TRITURADOR DE FORRAJE JTRF70 MOTOR ELECTRICO + ESQUILADORA OSTER SHOWMASTER 078153-013-000\" id=\"Trituradorfollaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">MOTOBOMBA AUTOCEBANTE GASOLINA DJ80C 3&#34; X 3&#34; + MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Motobombamotosierra.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motobomba:descarga: 3 x 3, Autocebante aluminio gasolina 5.5 hp , presión máxima: 30 metros, caudal máximo: 1000 litros/min. Motosierra: Cilindrada: 87 см³, Potencia: 4.5 kW, Longitud de espada recomendada mín-máx : 70 cm, Peso sin equipo de corte: 7.6 kg, Bomba de aceite regulable, Cárter de Magnesio, mango ergonómico.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"MOTOBOMBA AUTOCEBANTE GASOLINA DJ80C 3&#34; X 3&#34; + MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM\" id=\"Motobombamotosierra\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CARTAGENA 3 NOCHES 4 DÍAS CON TIQUETES. REF: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Cartagena.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE:  2 tiquetes aéreos Bogotá Cartagena Bogotá, traslados aeropuerto hotel aeropuerto,  3 noches 4 días de alojamiento para 2 adultos en la misma habitación en temporada baja en hotel Decameron Cartagena , desayunos, almuerzos y cenas diarios tipo buffet, bar abierto con bebidas y licores nacionales ilimitados,  impuestos del tiquete y del hotel.<BR /> NO INCLUYE:  Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE CARTAGENA 3 NOCHES 4 DÍAS CON TIQUETES. REF\" id=\"Cartagena\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;*/
                }else if(d1=='7' && parar==0){
                    parar=1;
                    verPremios('7');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Celular 128 GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Celular128.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Android 9.0, memoria interna: 128 gb, memoria ram 6 gb, dual sim, procesador exynos octa-core, cámara frontal: 10 mpx, cámara posterior dual: 12 mpx +16 mpx, batería (mah) 3100 mah, lector de huella,  reconocimiento facial.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Celular 128 GB\" id=\"Celular128GB\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CORTACESPED GASOLINA 3.5HP 5 POS JTRM80G + FUMIGADORA SEMIESTACIONARIA F268H 1.5 HP HONDA</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Cortacespedfumigadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Cortacesped: descarga : lateral, largo de corte: 48 cms, motor B&S : 3.75 hp, posiciones de altura: 3. Semiestacionaria: motor honda GX35, presión máxima de 500psi y un caudal de 7lpm.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"CORTACESPED GASOLINA 3.5HP 5 POS JTRM80G + FUMIGADORA SEMIESTACIONARIA F268H 1.5 HP HONDA\" id=\"Cortacespedfumigadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //OK
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CERCA SOLAR EL CEBU 100 KM + MOTOBOMBA FORTE 6 HP 2&#34; GM200-200H + SILLA RANCHERA CAFE MESACE 71088402</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Cercamotobombasilla.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Cerca: Alcance efectivo 100 kms. de alambre no. 12-14, capacidad máxima en hectáreas: 350, consumo de energía: 120 miliamperios, panel solar: 12 v 10 w, acumulador interno: 12 v 7 amp. Motomba: Descarga: 2x2, gasolina 6.5 hp, presión máxima 68 metros, caudal máximo: 615 litros/min.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"CERCA SOLAR EL CEBU 100 KM + MOTOBOMBA FORTE 6 HP 2&#34; GM200-200H + SILLA RANCHERA CAFE MESACE 71088402\" id=\"Cercamotobombasilla\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //OK
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">GUAJIRA 3 NOCHES 4 DÍAS PARA 2 PERSONAS<BR />REF: Agencia de viajes Turismo Al Vuelo</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Guajira.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: plan para 2 personas en la misma habitación en temporada baja que incluye traslado aeropuerto - hotel - aeropuerto en Riohacha, alojamiento 2 noches 3 días en Riohacha en el hotel Arimaca, Alojamiento 1 noche 2 días  en el Cabo de la Vela, desayuno en el hotel, almuerzo en los tours, tour Cabo de la Vela, tarde en ranchería Wayuu, Transporte en camioneta 4x4 y  Tarjeta de asistencia médica<BR />NO INCLUYE: Tiquetes aéreos y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE GUAJIRA 3 NOCHES 4 DÍAS PARA 2 PERSONAS\" id=\"Guajira\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //ok
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen; */                               
                }else if(d1=='8' && parar==0){
                    parar=1;
                    verPremios('8');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Trotadora</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Trotadora.png\" id=\"img1\" alt=\"P\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor DC de 1.75 Hp Velocidad: 1km-16 Km, Inclinación de 0 a 15 grados controlados digitalmente. Monitor: 25 programas predeterminados, Emparejamiento Bluetooth para reproducción de audio, Dos speakers de alta definición Indicador de distancia, tiempo, calorías, velocidad. Lectura de pulso con contacto manilar, Peso máximo de usuario: 110 kg.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Premio Trotadora\" id=\"Trotadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 GUADAÑADORA SHINDAIWA B 45 6 ACCESORIOS</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Guadanas.png\" id=\"img2\" alt=\"P\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor de 2 tiempos, cilindraje 41,5 cc, Longitud total 1,69 cm, capacidad de combustible 1000 ml, peso 8,6 kg.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Premio GUADAÑADORA SHINDAIWA B 45 6 ACCESORIOS\" id=\"Guadanas\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TV 55&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Tv55.png\" id=\"img3\" alt=\"P\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Internet tv, smart tv, tipo de pantalla qled, resolución 4k - ultra hd.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Premio TV 55&#34;\" id=\"Tv55\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SANTA MARTA HOTEL IROTAMA  3 NOCHES 4 DÍAS<BR /> Ref: Atrapalo.com.co</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Santamartairotama.png\" id=\"img4\" alt=\"V\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá Santa Marta Bogotá, traslados aeropuerto hotel aeropuerto  3 noches 4 días de alojamiento para 2 adultos  en la misma habitación en temporada baja en el hotel Irotama, todas las comidas, desayunos y almuerzos diarios,  e impuestos hoteleros. <BR />NO INCLUYE:  gastos no especificados en el plan.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SANTA MARTA HOTEL IROTAMA  3 NOCHES 4 DÍAS\" id=\"Santamartairotama\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Notacredito.png\" id=\"img5\" alt=\"P\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Premio NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;   */                             
                }else if(d1=='9' && parar==0){
                    parar=1;
                    verPremios('9');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Lavadora-Secadora</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Lavadorasecadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Carga frontal, libras lavado: 36, kilos lavado: 18, libras secado:20, kilos secado:10, panel de control: digital, programas de lavado: 12, programas de secado: 4, niveles de agua: 5, eficiencia energética: A.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Lavadora-Secadora\" id=\"Lavadorasecadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM + FUMIGADORA SHINDAIWA EST726</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Motosierrafumigadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motosierra: Cilindrada: 87 см³, Potencia: 4.5 kW, Longitud de espada recomendada mín-máx : 70 cm, Peso sin equipo de corte: 7.6 kg, Bomba de aceite regulable, Cárter de Magnesio, Three-piece crankshaft. Fumigadora:  26 litros de capacidad, Bomba de pistón dúplex de desplazamiento positivo que reduce la pulsación de la bomba, presión de fumigación regulable de 114 a 357 psi, boquilla de amplio alcance.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM + FUMIGADORA SHINDAIWA EST726\" id=\"Motosierrafumigadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Vehiculo Inteligente</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Vehiculointeligente.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Scooter eléctrico, material aluminio, material de las ruedas coraza en caucho, edad mínima recomendada 16 años.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Vehiculo Inteligente\" id=\"Vehiculointeligente\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">LETICIA, AMAZONAS 3 NOCHES 4 DÍAS <BR />REF: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Leticia.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá  - Leticia -  Bogotá, traslados aeropuerto hotel aeropuerto, alojamiento 3 noches 4 días para 2 adultos en la misma habitación en temporada baja, desayunos y cenas con impuestos incluidos. <BR />NO INCLUYE: tramite de visa americana, Alojamiento, alimentación Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE LETICIA, AMAZONAS 3 NOCHES 4 DÍAS\" id=\"Leticia\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;  */                               
                }else if(d1=='10' && parar==0){
                    parar=1;
                    verPremios('10');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">iPhone 11 128 GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/iPhone11.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Sistema operativo: ios 13, memoria interna 128 gb cámara frontal 12 mpx, cámara posterior dual, resolución cámara posterior 12 mpx ,no posee lector de huella, resistente al agua, sistema de reconocimiento facial.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"iPhone 11 128 GB\" id=\"iPhone11\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">GENERADOR ENERMAX GASOLINA G6500E DLXE 13 HP M-E</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Generador.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Potencia max. kw:5,5, voltaje ac:120-240-12v, sist. arranque: m-e, motor: gx390, hp:13, tanque lt:22, consumo l-h:3,6.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"GENERADOR ENERMAX GASOLINA G6500E DLXE 13 HP M-E\" id=\"Generador\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SAN ANDRES  3 NOCHES 4  DÍAS REF: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Sanandres.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá - San Andres- Bogotá, 3 noches 4 días de alojamiento para 2 adultos en la misma habitación en temporada baja , traslados aeropuerto hotel aeropuerto, todas las comidas, desayunos y almuerzos tipo bufet, cenas a la carta en restaurantes especializados, snacks, bar abierto con bebidas y licores nacionales ilimitados, Show y-o música en vivo todas las noches, recreación dirigida para adultos y niños, impuestos hoteleros.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SAN ANDRES  3 NOCHES 4  DÍAS\" id=\"Sanandres\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok*/
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    
                    
                    /*
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;    */                               
                }else if(d1=='11' && parar==0){
                    parar=1;
                    verPremios('11');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TV 65&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Tv65.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Internet tv, smart tv, tipo de pantalla led, resolución 4k - ultra hd.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TV 65&#34;\" id=\"Tv65\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Ipad pro 12.9&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/iPadpro12.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Pantalla Multi-Touch de 12,9 pulgadas (diagonal) retroiluminada por LED con tecnología IPS,256 GB, 2 camaras.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Ipad pro 12.9&#34;\" id=\"iPadpro12\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">LETICIA, AMAZONAS 4 NOCHES 5 DÍAS PARA 3 PERSONAS Ref: Decamerón.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Leticia.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 3 tiquetes aéreos Bogotá Leticia Bogotá, traslados aeropuerto hotel aeropuerto, 4 noches 5 días de alojamiento para 3 adultos en la misma habitación en temporada baja, desayunos y cenas diarios tipo menú del día,  impuestos del tiquete e impuestos hoteleros. <BR />NO INCLUYE: Tarjeta de turismo para ingreso a Leticia, servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE LETICIA, AMAZONAS 4 NOCHES 5 DÍAS PARA 3 PERSONAS\" id=\"Leticia\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok*/
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    
                    /*
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;  */                                
                }else if(d1=='12' && parar==0){
                    parar=1;
                    verPremios('12');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TV 70&#34; + Parlantes Bose</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Tv70.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Televisor: smart tv, procesador UHD, resolución 4k UHD,  AirPlay 2 integrado. <BR />Parlantes: Sistema de altavoces para cine en casa, instalación de 5.1 canales,experiencia de entretenimiento en casa envolvente.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TV 70&#34; + Parlantes Bose\" id=\"Tv70\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Portatil 15&#34; + Videoproyector Láser</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Portatilvideoproyector.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Portatil:  Sistema Operativo: Windows Home, memoria RAM: 8 G, disco Sólido 256 GB. <BR />Videoproyector: Resolución: Resolución WXGA (1280 x 800 pixeles) HD, Brillo/Lumens: 2000, duración de la Lampara: 20000, entradas: Puerto HDMI.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Portatil 15&#34; + Videoproyector Láser\" id=\"Portatilvideoproyector\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //OK
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SAN ANDRÉS 4 ADULTOS  3 NOCHES 4 DÍAS Ref: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Sanandres.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 4 tiquetes aéreos Bogotá - San  Andrés  - Bogotá, traslados aeropuerto hotel aeropuerto, 3 Noches 4 días de alojamiento para 4  adultos en 2 habitaciones  en temporada baja, todas las comidas, desayunos, almuerzos y cenas  tipo bufet, snacks, bar abierto con bebidas y licores nacionales ilimitados, impuestos del tiquete e  impuestos hoteleros. <BR />NO INCLUYE: Tarjeta de Turismo para ingreso a San Andrés, Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SAN ANDRÉS 4 ADULTOS  3 NOCHES 4 DÍAS\" id=\"Sanandres\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //OK*/
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    
                    /*
                    
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;      */                          
                }else if(d1=='13' && parar==0){
                    parar=1;
                    verPremios('13');
                    //imagen1
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Lavadora-Secadora + Bicicleta montaña.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Lavadoravicicleta.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Lavadora- secadora: Carga Frontal, Libras Lavado: 48, Libras Secado: 29, Panel de Control: digital.<BR />Bicicleta: Marco, biela y manubrio en aluminio, número de cambios: 27, tipo de freno: disco mecánico, rin27 pulgadas.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Lavadora-Secadora + Bicicleta montaña.\" id=\"Lavadoravicicleta\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Nevecon 781 Lt</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Nevecon.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Tecnología de frío: no Frost, tipo de Refrigeración: Dual (Congela y-o Refrigera)capacidad en litros brutos: 781 litros, capacidad en litros netos: 600 litros, dispensador de agua digital,panel digital, cantidad puertas: 2, eficiencia energética: A </label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Nevecon 781 Lt\" id=\"Nevecon\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">PUNTA CANA 2 ADULTOS 4 NOCHES 5 DÍAS Ref: despegar.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Puntacana.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE:  2 tiquetes aéreos Bogotá Punta Cana Bogotá,  traslados aeropuerto hotel aeropuerto, 4 Noches 5 días de alojamiento para 2 adultos en la misma habitación en temporada baja,  desayunos, almuerzos y cenas diarios tipo buffet, tarjeta de asistencia médica.<BR />NO INCLUYE:  Gastos no especificados en el plan.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE PUNTA CANA 2 ADULTOS 4 NOCHES 5 DÍAS\" id=\"Puntacana\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //OK*/
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/sss.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    
                    /* 
                    
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;  */                               
                }else{
                    document.getElementById('Premio').value='Sin Premio';
                    document.getElementById('fotosp1').innerHTML = '';
                    document.getElementById('fotosp2').innerHTML = '';
                    document.getElementById('fotosp3').innerHTML = '';
                    document.getElementById('fotosp4').innerHTML = '';
                    document.getElementById('fotosp5').innerHTML = '';
                }
                document.getElementById('Premio').value = '';
            }
            
            //premios pestar
            function consultarPremiosx1(){
                var d1 = document.getElementById('Categoria').value;
                var imagen='';
                var parar=0;
                if(d1=='1' && parar==0){
                    parar=1;
                    //imagen1 ok
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Celular 64GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Celular.png\" alt=\"premio\" style=\"width: 98%;\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Sistema operativo: android 9.0, memoria interna 64 GB, memoria Ram 4G, dual sim, procesador octa Core 2.0 Ghz, camara posterior dual 13 Mpx,  2 Mpx, camara frontal   8 Mpx.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Celular 64 GB\" id=\"Celular\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen;
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">ESQUILADORA MASCOTA 3 VEL</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Esquiladora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\"> 3 velocidades: 3.100/3.600/4.100 rpm, peso: 350 g, medidas: 17,5 x 4,5 x 4,1 cm, longitud del cable: 3,66 m.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Esquiladora mascotas 3 velocidades\" id=\"Esquiladora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen;
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Multifuncional Laser</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Multifuncional.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\"> Scanea, imprime y copia, velocidad de Impresión: 20 ppm, resolución impresión: 1200 x 1200 dpi, resolución escaner: 4800 x 4800, conectividad: wifi.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Multifuncional Laser\" id=\"Multifuncional\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen;
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea.<BR />NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE 2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/1/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;
                    //document.getElementById('fotosp5').innerHTML = "<BR /><center><HR /><B><input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" style=\"width: 20px;\" id=\"NOTA CREDITO 3\" onclick=\"seleccionarFoto(this.value,this.id);\">NOTA CR&Eacute;DITO 3%</B></center>";
                }else if(d1=='2' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Celular 128GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Celular.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Pantalla: 6.59&#34;,  procesador: Kirin 710 2.2GHz, RAM: 4GB, almacenamiento: 128GB, camara frontal: 16 MP, cámara posterior triple: 16MP+8MP+2MP, batería: 4000 mAh, android 9.0.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Celular 128GB\" id=\"Celular\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen;  
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">GENERADOR ECOMAX GASOLINA GE3300 3.3KVA</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Generador.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Voltaje:120/240, fases:1, rpm: 3600, potencia: 3.1 kVA, arranque: manual.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"GENERADOR ECOMAX GASOLINA GE3300 3.3KVA\" id=\"Generador\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen;//ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CERCA SOLAR EL CEBU 50 KM</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Cercasolar.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Alcance efectivo 50 kms. de alambre, energía de Salida: 4 Julios, máxima energía almacenada: 6 Julios, consumo de energía: 100 miliamperios, panel solar: 12 V 5 W, acumulador Interno: 12 V 7 AMP.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"CERCA SOLAR EL CEBU 50 KM\" id=\"Cercasolar\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">QUINDÍO, DECAMERON PANACA  2 NOCHES 3 DÍAS PARA 2 PERSONAS SIN TIQUETES</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Quindio.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 noches 3 días de alojamiento, para 2 adultos en la misma habitación en temporada baja, todas las comidas, desayunos y almuerzos tipo buffet, cenas a la carta en restaurantes especializados, snacks, bar abierto con bebidas y licores nacionales ilimitados, ingreso a PANACA,  impuestos hoteleros.<BR />NO INCLUYE: Tiquetes aéreos, Traslados terrestres, Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE QUINDÍO, DECAMERON PANACA  2 NOCHES 3 DÍAS PARA 2 PERSONAS SIN TIQUETES\" id=\"Quindio\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/2/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen; //OK
                }else if(d1=='3' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Portátil 14 pulgadas;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Portatil.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Procesador: Intel Pentium Gold 5405U 2.3 Ghz, sistema Operativo: Windows 10 Home, memoria RAM: 4GB, disco Duro: 500GB, pantalla: 14 pulgadas.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Portátil 14\" id=\"Portatil 14\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">FUMIGADORA EST FORTE 6.5HP 28LT TF28 GM200 CERRADO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Fumigadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor: forte gm200 6.5hp, presión:0-500psi, caudal: 28 l/mln, pistones: acero 3*28mm diámetro, velocidades: 300-800 rpm.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"FUMIGADORA EST FORTE 6.5HP 28LT TF28 GM200 CERRADO\" id=\"Fumigadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Patineta Eléctrica-Scooter.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Patineta.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Material: aluminio, tamaño de la llanta o rin: 8, peso máximo del usuario 90 kg, velocidad máxima 10 km/hr, tipo de frenos: trasero de pie, potencia del motor:150 w, batería litio 22 v, tiempo de carga de la batería: 2 a 5 horas, no posee luces.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Patineta Eléctrica-Scooter.\" id=\"Patineta\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CALI 3 NOCHES 4 DÍAS EN FIN DE SEMANA HOTEL 4 ESTRELLAS.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Cali.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 3 noches 4 días de alojamiento en hotel 4 estrellas, para 2 adultos en la misma habitación en temporada baja para fin de semana, desayuno diario. NO INCLUYE: Tiquetes aéreos, Traslados terrestres, Tours , impuestos hoteleros y gastos no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE CALI 3 NOCHES 4 DÍAS EN FIN DE SEMANA HOTEL 4 ESTRELLAS\" id=\"Cali\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //ok
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/3/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;
                }else if(d1=='4' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">C&aacute;mara de Acción GOPRO HERO 8 BLACK</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Camara.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Megapixeles: 12 mp, zoom óptico: de 10x a 32x, zoom digital: de 10x a 32x, formato de video: hd 4k, tamaño de pantalla: 2 pulgadas, formato de grabación: sd.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Camara de Accion GOPRO HERO 8 BLACK\" id=\"Camara\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">PICAPASTO PP7MB2C CON BASE 2 CUCHILLAS</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Picapasto.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Producción Kg/h: 600 – 900, Boca de alimentación: 8&#34; Longitud de corte mm. 7 – 9 Velocidad del volante RPM: 200 – 220, Potencia necesaria en H.P. con dos cuchillas: 1.5, Diámetro del volante: 24&#34;, Diámetro polea motor a 1.750 RPM. Pulgadas: 3.0 TIPO A, Peso de la máquina 60 kg.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"PICAPASTO PP7MB2C CON BASE 2 CUCHILLAS\" id=\"Picapasto\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TELEVISOR 49&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Televisor.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Smart tv, resolución full hd, entradas HDMI y USB.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TELEVISOR 49\" id=\"Televisor\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen;  //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">PALOMINO 4 NOCHES 5 DÍAS.<BR />Ref: Agencia de Viajes Turismo Al Vuelo.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Palomino.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 4 noches 5 días de alojamiento para 2 adultos en la misma habitación en temporada baja en el Hotel Hukumeizi o similar , Traslados desde y hacia el  aeropuerto de Riohacha, Tour Parque de Los Flamencos, desayuno diario.<BR />NO INCLUYE: Tiquetes aéreos a Riohacha, alimentación no descrita en el programa, gastos no especificados en el programa  y/o de índole personal.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE PALOMINO 4 NOCHES 5 DÍAS\" id=\"Palomino\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO <BR />NOTA CR&Eacute;DITO 3%</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/4/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO 3%\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;
                }else if(d1=='5' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Consola Nintendo Switch Neon Blue- Red Joy-Con</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Consolanintendo.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Capacidad: 32 GB, Conexiones: Alambrica e Inalambrica, Color: Neon Blue- Red, Resolución: Accesorios 2 Joy Con.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Consola Nintendo Switch Neon Blue- Red Joy-Con\" id=\"Consolanintendo\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">MOTOBOMBA ECOMAX DIESEL 2X2 10 HP TBDY1862HYR</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Motobombaecomax.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor 4T, inyeccion directa,bomba de alta presion en hierro de 2&#34; de succion por descarga, refrigerado por aire forzado, caudal hasta 500 lpm, arranque manual.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"MOTOBOMBA ECOMAX DIESEL 2X2 10 HP TBDY1862HYR\" id=\"Motobombaecomax\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Nevera 375 Lt</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Nevera.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Tecnología de frío: no frost, tipo de refrigeración dual (congela y/o refrigera) capacidad en litros brutos: 375, capacidad en litros netos: 361, fabricador de hielo manual, eficiencia energética: A</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Nevera 375 Lt\" id=\"Nevera\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen;  //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SANTA MARTA 2 NOCHES 3 DÍAS CON TIQUETES DESDE BOGOTÁ<BR />Ref: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Santamarta.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá - Santa Marta- Bogotá, 2 noches 3 días de alojamiento para 2 adultos en la misma habitación en temporada baja, traslados aeropuerto hotel aeropuerto, todas las comidas, desayunos y almuerzos tipo buffet, bebidas y licores nacionales ilimitados,  impuestos hoteleros del tiquete e impuestos hoteleros. NO INCLUYE: Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SANTA MARTA 2 NOCHES 3 DÍAS CON TIQUETES DESDE BOGOTÁ\" id=\"Santamarta\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //ok
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/5/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;
                }else if(d1=='6' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">iPad Air 10.5&#34; Pulgadas Silver 64 GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/iPadAir.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Procesador: Chip A12 Bionic, Sistema Operativo: iOS, Memoria Interna: 64 GB, Pantalla: 10,5 Pulgadas.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"iPad Air 10.5&#34; Pulgadas Silver 64 GB\" id=\"iPadAir\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TRITURADOR DE FORRAJE JTRF70 MOTOR ELECTRICO + ESQUILADORA OSTER SHOWMASTER 078153-013-000</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Trituradorfollaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Triturador: Producción: hasta 900 kilos/hora Motor eléctrico 1.5 HP 3600 RPM - Incluido 4 Cribas. Esquiladora: Potencia130 W, Velocidad variable se ajusta de 700 a 3000 golpes por minuto.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TRITURADOR DE FORRAJE JTRF70 MOTOR ELECTRICO + ESQUILADORA OSTER SHOWMASTER 078153-013-000\" id=\"Trituradorfollaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">MOTOBOMBA AUTOCEBANTE GASOLINA DJ80C 3&#34; X 3&#34; + MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Motobombamotosierra.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motobomba:descarga: 3 x 3, Autocebante aluminio gasolina 5.5 hp , presión máxima: 30 metros, caudal máximo: 1000 litros/min. Motosierra: Cilindrada: 87 см³, Potencia: 4.5 kW, Longitud de espada recomendada mín-máx : 70 cm, Peso sin equipo de corte: 7.6 kg, Bomba de aceite regulable, Cárter de Magnesio, mango ergonómico.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"MOTOBOMBA AUTOCEBANTE GASOLINA DJ80C 3&#34; X 3&#34; + MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM\" id=\"Motobombamotosierra\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CARTAGENA 3 NOCHES 4 DÍAS CON TIQUETES. REF: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Cartagena.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE:  2 tiquetes aéreos Bogotá Cartagena Bogotá, traslados aeropuerto hotel aeropuerto,  3 noches 4 días de alojamiento para 2 adultos en la misma habitación en temporada baja en hotel Decameron Cartagena , desayunos, almuerzos y cenas diarios tipo buffet, bar abierto con bebidas y licores nacionales ilimitados,  impuestos del tiquete y del hotel.<BR /> NO INCLUYE:  Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE CARTAGENA 3 NOCHES 4 DÍAS CON TIQUETES. REF\" id=\"Cartagena\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/6/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;
                }else if(d1=='7' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Celular 128 GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Celular128.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Android 9.0, memoria interna: 128 gb, memoria ram 6 gb, dual sim, procesador exynos octa-core, cámara frontal: 10 mpx, cámara posterior dual: 12 mpx +16 mpx, batería (mah) 3100 mah, lector de huella,  reconocimiento facial.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Celular 128 GB\" id=\"Celular128GB\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CORTACESPED GASOLINA 3.5HP 5 POS JTRM80G + FUMIGADORA SEMIESTACIONARIA F268H 1.5 HP HONDA</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Cortacespedfumigadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Cortacesped: descarga : lateral, largo de corte: 48 cms, motor B&S : 3.75 hp, posiciones de altura: 3. Semiestacionaria: motor honda GX35, presión máxima de 500psi y un caudal de 7lpm.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"CORTACESPED GASOLINA 3.5HP 5 POS JTRM80G + FUMIGADORA SEMIESTACIONARIA F268H 1.5 HP HONDA\" id=\"Cortacespedfumigadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //OK
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">CERCA SOLAR EL CEBU 100 KM + MOTOBOMBA FORTE 6 HP 2&#34; GM200-200H + SILLA RANCHERA CAFE MESACE 71088402</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Cercamotobombasilla.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Cerca: Alcance efectivo 100 kms. de alambre no. 12-14, capacidad máxima en hectáreas: 350, consumo de energía: 120 miliamperios, panel solar: 12 v 10 w, acumulador interno: 12 v 7 amp. Motomba: Descarga: 2x2, gasolina 6.5 hp, presión máxima 68 metros, caudal máximo: 615 litros/min.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"CERCA SOLAR EL CEBU 100 KM + MOTOBOMBA FORTE 6 HP 2&#34; GM200-200H + SILLA RANCHERA CAFE MESACE 71088402\" id=\"Cercamotobombasilla\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //OK
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">GUAJIRA 3 NOCHES 4 DÍAS PARA 2 PERSONAS<BR />REF: Agencia de viajes Turismo Al Vuelo</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Guajira.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: plan para 2 personas en la misma habitación en temporada baja que incluye traslado aeropuerto - hotel - aeropuerto en Riohacha, alojamiento 2 noches 3 días en Riohacha en el hotel Arimaca, Alojamiento 1 noche 2 días  en el Cabo de la Vela, desayuno en el hotel, almuerzo en los tours, tour Cabo de la Vela, tarde en ranchería Wayuu, Transporte en camioneta 4x4 y  Tarjeta de asistencia médica<BR />NO INCLUYE: Tiquetes aéreos y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE GUAJIRA 3 NOCHES 4 DÍAS PARA 2 PERSONAS\" id=\"Guajira\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //ok
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/7/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;                                
                }else if(d1=='8' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Trotadora</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Trotadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor DC de 1.75 Hp Velocidad: 1km-16 Km, Inclinación de 0 a 15 grados controlados digitalmente. Monitor: 25 programas predeterminados, Emparejamiento Bluetooth para reproducción de audio, Dos speakers de alta definición Indicador de distancia, tiempo, calorías, velocidad. Lectura de pulso con contacto manilar, Peso máximo de usuario: 110 kg.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Trotadora\" id=\"Trotadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 GUADAÑADORA SHINDAIWA B 45 6 ACCESORIOS</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Guadanas.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motor de 2 tiempos, cilindraje 41,5 cc, Longitud total 1,69 cm, capacidad de combustible 1000 ml, peso 8,6 kg.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 GUADAÑADORA SHINDAIWA B 45 6 ACCESORIOS\" id=\"Guadanas\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TV 55&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Tv55.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Internet tv, smart tv, tipo de pantalla qled, resolución 4k - ultra hd.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TV 55&#34;\" id=\"Tv55\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SANTA MARTA HOTEL IROTAMA  3 NOCHES 4 DÍAS<BR /> Ref: Atrapalo.com.co</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Santamartairotama.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá Santa Marta Bogotá, traslados aeropuerto hotel aeropuerto  3 noches 4 días de alojamiento para 2 adultos  en la misma habitación en temporada baja en el hotel Irotama, todas las comidas, desayunos y almuerzos diarios,  e impuestos hoteleros. <BR />NO INCLUYE:  gastos no especificados en el plan.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SANTA MARTA HOTEL IROTAMA  3 NOCHES 4 DÍAS\" id=\"Santamartairotama\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/8/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;                                
                }else if(d1=='9' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Lavadora-Secadora</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Lavadorasecadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Carga frontal, libras lavado: 36, kilos lavado: 18, libras secado:20, kilos secado:10, panel de control: digital, programas de lavado: 12, programas de secado: 4, niveles de agua: 5, eficiencia energética: A.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Lavadora-Secadora\" id=\"Lavadorasecadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM + FUMIGADORA SHINDAIWA EST726</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Motosierrafumigadora.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Motosierra: Cilindrada: 87 см³, Potencia: 4.5 kW, Longitud de espada recomendada mín-máx : 70 cm, Peso sin equipo de corte: 7.6 kg, Bomba de aceite regulable, Cárter de Magnesio, Three-piece crankshaft. Fumigadora:  26 litros de capacidad, Bomba de pistón dúplex de desplazamiento positivo que reduce la pulsación de la bomba, presión de fumigación regulable de 114 a 357 psi, boquilla de amplio alcance.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"MOTOSIERRA HUSQVARNA 288XP 36&#34; - 90 CM + FUMIGADORA SHINDAIWA EST726\" id=\"Motosierrafumigadora\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Vehiculo Inteligente</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Vehiculointeligente.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Scooter eléctrico, material aluminio, material de las ruedas coraza en caucho, edad mínima recomendada 16 años.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Vehiculo Inteligente\" id=\"Vehiculointeligente\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">LETICIA, AMAZONAS 3 NOCHES 4 DÍAS <BR />REF: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Leticia.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá  - Leticia -  Bogotá, traslados aeropuerto hotel aeropuerto, alojamiento 3 noches 4 días para 2 adultos en la misma habitación en temporada baja, desayunos y cenas con impuestos incluidos. <BR />NO INCLUYE: tramite de visa americana, Alojamiento, alimentación Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE LETICIA, AMAZONAS 3 NOCHES 4 DÍAS\" id=\"Leticia\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen; //OK
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/9/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;                                 
                }else if(d1=='10' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">iPhone 11 128 GB</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/iPhone11.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Sistema operativo: ios 13, memoria interna 128 gb cámara frontal 12 mpx, cámara posterior dual, resolución cámara posterior 12 mpx ,no posee lector de huella, resistente al agua, sistema de reconocimiento facial.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"iPhone 11 128 GB\" id=\"iPhone11\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">GENERADOR ENERMAX GASOLINA G6500E DLXE 13 HP M-E</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Generador.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Potencia max. kw:5,5, voltaje ac:120-240-12v, sist. arranque: m-e, motor: gx390, hp:13, tanque lt:22, consumo l-h:3,6.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"GENERADOR ENERMAX GASOLINA G6500E DLXE 13 HP M-E\" id=\"Generador\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SAN ANDRES  3 NOCHES 4  DÍAS REF: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Sanandres.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 2 tiquetes aéreos Bogotá - San Andres- Bogotá, 3 noches 4 días de alojamiento para 2 adultos en la misma habitación en temporada baja , traslados aeropuerto hotel aeropuerto, todas las comidas, desayunos y almuerzos tipo bufet, cenas a la carta en restaurantes especializados, snacks, bar abierto con bebidas y licores nacionales ilimitados, Show y-o música en vivo todas las noches, recreación dirigida para adultos y niños, impuestos hoteleros.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SAN ANDRES  3 NOCHES 4  DÍAS\" id=\"Sanandres\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/10/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;                                   
                }else if(d1=='11' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TV 65&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Tv65.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Internet tv, smart tv, tipo de pantalla led, resolución 4k - ultra hd.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TV 65&#34;\" id=\"Tv65\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //ok
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Ipad pro 12.9&#34;</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/iPadpro12.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Pantalla Multi-Touch de 12,9 pulgadas (diagonal) retroiluminada por LED con tecnología IPS,256 GB, 2 camaras.</label> </td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Ipad pro 12.9&#34;\" id=\"iPadpro12\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">LETICIA, AMAZONAS 4 NOCHES 5 DÍAS PARA 3 PERSONAS Ref: Decamerón.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Leticia.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 3 tiquetes aéreos Bogotá Leticia Bogotá, traslados aeropuerto hotel aeropuerto, 4 noches 5 días de alojamiento para 3 adultos en la misma habitación en temporada baja, desayunos y cenas diarios tipo menú del día,  impuestos del tiquete e impuestos hoteleros. <BR />NO INCLUYE: Tarjeta de turismo para ingreso a Leticia, servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE LETICIA, AMAZONAS 4 NOCHES 5 DÍAS PARA 3 PERSONAS\" id=\"Leticia\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //ok
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/11/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;                                  
                }else if(d1=='12' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">TV 70&#34; + Parlantes Bose</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Tv70.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Televisor: smart tv, procesador UHD, resolución 4k UHD,  AirPlay 2 integrado. <BR />Parlantes: Sistema de altavoces para cine en casa, instalación de 5.1 canales,experiencia de entretenimiento en casa envolvente.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"TV 70&#34; + Parlantes Bose\" id=\"Tv70\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Portatil 15&#34; + Videoproyector Láser</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Portatilvideoproyector.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Portatil:  Sistema Operativo: Windows Home, memoria RAM: 8 G, disco Sólido 256 GB. <BR />Videoproyector: Resolución: Resolución WXGA (1280 x 800 pixeles) HD, Brillo/Lumens: 2000, duración de la Lampara: 20000, entradas: Puerto HDMI.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Portatil 15&#34; + Videoproyector Láser\" id=\"Portatilvideoproyector\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //OK
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">SAN ANDRÉS 4 ADULTOS  3 NOCHES 4 DÍAS Ref: Decameron.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Sanandres.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE: 4 tiquetes aéreos Bogotá - San  Andrés  - Bogotá, traslados aeropuerto hotel aeropuerto, 3 Noches 4 días de alojamiento para 4  adultos en 2 habitaciones  en temporada baja, todas las comidas, desayunos, almuerzos y cenas  tipo bufet, snacks, bar abierto con bebidas y licores nacionales ilimitados, impuestos del tiquete e  impuestos hoteleros. <BR />NO INCLUYE: Tarjeta de Turismo para ingreso a San Andrés, Tours y servicios no especificados.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE SAN ANDRÉS 4 ADULTOS  3 NOCHES 4 DÍAS\" id=\"Sanandres\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //OK
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Viaje.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/12/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;                                
                }else if(d1=='13' && parar==0){
                    parar=1;
                    //imagen1
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Lavadora-Secadora + Bicicleta montaña.</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Lavadoravicicleta.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Lavadora- secadora: Carga Frontal, Libras Lavado: 48, Libras Secado: 29, Panel de Control: digital.<BR />Bicicleta: Marco, biela y manubrio en aluminio, número de cambios: 27, tipo de freno: disco mecánico, rin27 pulgadas.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Lavadora-Secadora + Bicicleta montaña.\" id=\"Lavadoravicicleta\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<input type=\"text\" id=\"Tpp\" style=\"width: 20px; visibility: hidden;\"><br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp1').innerHTML = imagen; //OK
                    //imagen2
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">Nevecon 781 Lt</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Nevecon.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">Tecnología de frío: no Frost, tipo de Refrigeración: Dual (Congela y-o Refrigera)capacidad en litros brutos: 781 litros, capacidad en litros netos: 600 litros, dispensador de agua digital,panel digital, cantidad puertas: 2, eficiencia energética: A </label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"Nevecon 781 Lt\" id=\"Nevecon\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp2').innerHTML = imagen; //ok
                    //imagen 3
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">PUNTA CANA 2 ADULTOS 4 NOCHES 5 DÍAS Ref: despegar.com</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Puntacana.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"><label class=\"parrafo\">INCLUYE:  2 tiquetes aéreos Bogotá Punta Cana Bogotá,  traslados aeropuerto hotel aeropuerto, 4 Noches 5 días de alojamiento para 2 adultos en la misma habitación en temporada baja,  desayunos, almuerzos y cenas diarios tipo buffet, tarjeta de asistencia médica.<BR />NO INCLUYE:  Gastos no especificados en el plan.</label></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"VIAJE PUNTA CANA 2 ADULTOS 4 NOCHES 5 DÍAS\" id=\"Puntacana\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp3').innerHTML = imagen; //OK*/
                    //imagen 4
                    /*imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/sss.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\">INCLUYE: 2 tiquetes aéreos ida y regreso Bogotá Cartagena Bogotá en temproada baja con impuestos incluidos y equipaje en bodega permitido por la aerolinea                                NO INCLUYE: Penalidades por cambio de fecha, ruta o nombre, alojamiento, gastos no especificados      CONDICIONES: La reserva y emisión los  tiquetes debe realizarse máximo 2 meses antes de la fecha de viaje.</td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"2 TIQUETE AÉREO BOGOTÁ CARTAGENA BOGOTÁ\" id=\"Viaje\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'V');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp4').innerHTML = imagen;*/
                    //nota credito
                    imagen="<div class=\"fondopre\"><table style=\"border: 1;width: 98%;\"><tr><td style=\"width: 20%;\">NOTA CR&Eacute;DITO</td>";
                    imagen=imagen+"<td style=\"width: 50%;background-color: #FFFFFF; text-align: center;\"><BR /><img src=\"FOTOSPLAN/13/Notacredito.png\" alt=\"premio\" /><BR /></td><td style=\"padding: 5px;\"></td></tr></table>";
                    imagen=imagen+"<input type=\"radio\" name=\"2\" value=\"NOTA CREDITO\" id=\"Notacredito\" style=\"width: 20px;\" onclick=\"seleccionarFoto(this.value,this.id,'P');\">SELECCIONAR<br />";
                    imagen=imagen+"</div><hr />";
                    document.getElementById('fotosp5').innerHTML = imagen;                                 
                }else{
                    document.getElementById('Premio').value='Sin Premio';
                    document.getElementById('fotosp1').innerHTML = '';
                    document.getElementById('fotosp2').innerHTML = '';
                    document.getElementById('fotosp3').innerHTML = '';
                    document.getElementById('fotosp4').innerHTML = '';
                    document.getElementById('fotosp5').innerHTML = '';
                }
                document.getElementById('Premio').value = '';
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

            function guardarDatos(empr) {
                var d1 = document.getElementById('T1').value;
                var d2 = document.getElementById('T2').value;
                var d3 = document.getElementById('T3').value;
                var d4t = document.getElementById('T4').value;
                var d4=d4t.replace("#"," No. ");
                var d5 = document.getElementById('T5').value;
                var d6 = document.getElementById('T6').value;
                var d6b = document.getElementById('T6b').value;
                var d7 = document.getElementById('T7').value;
                var d8 = document.getElementById('T8').value;
                var d9 = document.getElementById('T9').value;
                var d10 = document.getElementById('T10').value;
                var d11 = document.getElementById('T11').value;
                var d12 = document.getElementById('Categoria').value;
                var dft = document.getElementById('F').value;
                var df=dft.replace("#"," No. ");
                var dp = '';//document.getElementById('Premio').value;
                //var premio = dp.split(';');
                var md = document.getElementById('manejodatos').value;
                var pe = '';//document.getElementById('premioelegido').value;
                //tipo de premios V o P
                var tpp = '';//document.getElementById('Tpp').value;
                //var txtImg = document.getElementById('Textoimagen').value;
                var cond = '';//document.getElementById('condicion').value;
                //var hash=//$_POST["imagen"];
                var x='';
                //verificar firma por evento de coordenada dentro de canvas
                /*if (d6b.length <= 0) {
                    alert("Digite el número de contacto actualizado");
                    window.scrollTo(10,40);
                    document.getElementById('T6b').focus();
                    return false;
                }*/
                //correo
                x=d8.indexOf("@");
                if (d8.length <= 10 || x==-1) {
                    alert("Por favor digite un correo válido.");
                    window.scrollTo(10,40);
                    document.getElementById('T8').focus();
                    return false;
                }
                if (d1.length <= 0) {
                    alert("Digite número de identificacion y haga clic en Validar.");
                    window.scrollTo(10,40);
                    document.getElementById('T1').focus();
                    return false;
                }
                if (d2.length <= 0) {
                    alert("Falta nombre, digite número de identificacion y haga clic en Validar.");
                    window.scrollTo(10,40);
                    document.getElementById('T1').focus();
                    return false;
                }
                /*if (dp.length <= 5) {
                    alert("Falta seleccionar un Premio.");
                    return false;
                }*/
                //obtiene el tipo de premio del nombre si es Viaje (V) o premio(P)
                //var tipo=document.getElementById('Premio').value;
                //tipo=tipo.substring(0,1);
                /*if(tpp!='V' && empr=='AG'){
                    tipo='P';
                }
                if(empr=='X1'){
                    tipo='P';
                }*/
                //firma
                //GuardarTrazado();
                //
                //alert('un momento por favor estamos acutualizando');
                /*return false;
                var firmado=document.getElementById('firm');
                    if (parseInt(firmado) < 3000) {
                        alert("Favor firmar el Plan año en el cuadro FIRMA CLIENTE. Antes de Generar Plan!");
                        window.scrollTo(10,1600);
                        return false;
                    }*/
                //var firmado=document.getElementById('coord').value;
                    //if (parseInt(firmado) < 3000) {
                    /*if(parseInt(firmado)<=0){
                        alert("Favor firmar el Plan año en el cuadro FIRMA CLIENTE. Antes de Generar Plan!");
                        window.scrollTo(10,1600);
                        return false;
                    }*/
                // Obtener la instancia del objeto XMLHttpRequest
                txtImg='';
                
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                //peticion_http.open('POST', 'guardadatpes.php?d1=' + d1 + '&d2=' + d2 + '&d3=' + d3 + '&d4=' + d4 + '&d5=' + d5 + '&d6=' + d6 + '&d6b=' + d6b + '&d7=' + d7 + '&d8=' + d8 + '&d9=' + d9 + '&d10=' + d10 + '&d11=' + d11 + '&d12=' + d12 + '&df=' + df + '&dp=' + dp + '&md=' + md + '&tp=' + tipo + '&pe=' + pe + '&emp=' + empr, true);
                //?d1=' + d1 + '&d2=' + d2 + '&d3=' + d3 + '&d4=' + d4 + '&d5=' + d5 + '&d6=' + d6 + '&d6b=' + d6b + '&d7=' + d7 + '&d8=' + d8 + '&d9=' + d9 + '&d10=' + d10 + '&d11=' + d11 + '&d12=' + d12 + '&df=' + df + '&dp=' + dp + '&md=' + md + '&tp=' + tpp + '&pe=' + pe + '&emp=' + empr + '&txtImg=' + txtImg + '&cond=' + cond
                peticion_http.open('POST', 'guardadatactualiza.php?d1=' + d1 + '&d2=' + d2 + '&d3=' + d3 + '&d4=' + d4 + '&d5=' + d5 + '&d6=' + d6 + '&d6b=' + d6b + '&d7=' + d7 + '&d8=' + d8 + '&d9=' + d9 + '&d10=' + d10 + '&d11=' + d11 + '&d12=' + d12 + '&df=' + df + '&dp=' + dp + '&md=' + md + '&tp=' + tpp + '&pe=' + pe + '&emp=' + empr + '&txtImg=' + txtImg + '&cond=' + cond, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                           // alert(dato);
                            //return false;
                            
                            //GuardarTrazado();
                            alert(dato);
                            document.getElementById('datosper').style.visibility='hidden';
                            document.getElementById('dper').style.visibility='hidden';
                            setTimeout("location.reload(true);", 500);
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
                document.getElementById('fotosp').innerHTML='';
                document.getElementById('autorizacion').innerHTML='';
                document.getElementById('datosper').style.visibility='hidden';
                document.getElementById('dper').style.visibility='hidden';
                document.getElementById('T1').focus();
            }

            function BloquearFormulario() {
                document.getElementById('T2').style.readOnly = 'true';
                document.getElementById('T3').style.readOnly = 'true';
                document.getElementById('T4').style.readOnly = 'true';
                document.getElementById('T5').style.readOnly = 'true';
                document.getElementById('T6').style.readOnly = 'true';
                document.getElementById('T6b').style.readOnly = 'true';
                document.getElementById('T7').style.readOnly = 'true';
                document.getElementById('T8').style.readOnly = 'false';
                document.getElementById('T9').style.readOnly = 'true';
                document.getElementById('T10').style.readOnly = 'true';
                document.getElementById('T11').style.readOnly = 'true';
                document.getElementById('T12').style.readOnly = 'true';
                document.getElementById('F').style.readOnly = 'true';
                document.getElementById('Premio').style.readOnly = 'true';
                document.getElementById('T1').focus();
            }
            
            function DesbloquearFormulario() {
                document.getElementById('T2').style.readOnly = 'false';
                document.getElementById('T3').style.readOnly = 'false';
                document.getElementById('T4').style.readOnly = 'false';
                document.getElementById('T5').style.readOnly = 'false';
                document.getElementById('T6').style.readOnly = 'false';
                document.getElementById('T6b').style.readOnly = 'false';
                document.getElementById('T7').style.readOnly = 'false';
                document.getElementById('T8').style.readOnly = 'false';
                document.getElementById('T9').style.readOnly = 'false';
                document.getElementById('T10').style.readOnly = 'false';
                document.getElementById('T11').style.readOnly = 'false';
                document.getElementById('T12').style.readOnly = 'false';
                document.getElementById('F').style.readOnly = 'true';
                document.getElementById('Premio').style.readOnly = 'true';
                document.getElementById('T1').focus();
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
                        alert('Por favor introduce un correo valido');
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
            <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    </head>
    <body style="background-color: #E4EAC0;">
       <?php
       echo "<br /><br /><p><center><STRONG>El Plan año 2022 se encuentra en revision temporalmente. Gracias por su visita!. Los esperamos pronto. </STRONG></p></center>";
       echo "<br /><br /><center><a href='https://www.agrocampo.com.co/'><img src='images/logoAG.png'></a></center>";  
       exit();
       //#A7D43D
       ?>
        <div class="centrarancho">
             <div id="wrapperHeader">
                 <div id="header">
                  <?
                  if (!empty($_GET['emp'])){
                        $emp=$_GET['emp'];
                    }else{
                        $emp='AG';
                    }
                  if($emp=='AG'){
                    ?>
                  <img src="images/head.png" alt="logo" />
                  <?
                  } else if($emp=='X1'){
                  ?>
                  <img src="images/logo_pestar.png" alt="logo_pestar" />
                  <?
                  }
                  ?>
                 </div>
                 <!--<div id="header2" style="text-align: center;">
                  <img src="images/Registro.png" alt="logo" width="8%;" />
                     <label id="nplan" style="font-size: 18pt; font-weight: bold; font-family: ITC Avant Garde Gothic;font-style: italic; color: #ffffff;">REGISTRO PLAN A&Ntilde;O 2020</label><div ></div><br />
                     <label style="font-size: 11pt; font-weight: bold;font-family: ITC Avant Garde Gothic;font-style: italic;color: #ffffff;">INGRESE N&Uacute;MERO DE C&Eacute;DULA o NIT REGISTRADO CON AGROCAMPO Y LUEGO CLIC EN VALIDAR</label>
                 </div>-->
            </div>
            &nbsp;
           
            <div class="centerTable">
            <!--tabla de datos-->
            <div class='centrador'>
            <?php
            //consulta de la URL de que empresa viene
            /*if (!empty($_GET['emp'])){
                $emp=$_GET['emp'];
            }else{
                $emp='AG';
            }*/
            ?>
            <table id="Table1" class="tabla">
               <tr><td colspan="3">&nbsp;</td></tr>
               <tr>
                   <td style="width: 2%">&nbsp;</td>
                   <td style="width: 40%"><label style="font-size: 14pt" class="etiqueta1">C&eacute;dula / Nit</label></td>
                   <td><input type="text" ID="T1" name="T1" onkeyUp="return ValNumero(this);" maxlength="11" class="texto1" onblur="copiaNum(this.value);" onkeypress="saltarObjeto(event);" autofocus="true" autocomplete="off" required /></td>
              </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
               <tr>
                   <td style="width: 5%">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td><input type="button" ID="B1" name="B1" class="botong" onclick="consultarDatos('<?php echo $emp; ?>');" value="VALIDAR">&nbsp;&nbsp;<input type="button" ID="B1" name="B1" onclick="LimpiarFormulario();" class="botong" value="REFRESCAR" /></td>  
               </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Nombre Cliente</label></td>
                   <td><input type="text" ID="T2" name="T2" maxlength="40" placeholder="campo obligatorio" class="texto2" autocomplete="off" readonly="true" /></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Nombre Establecimiento</label></td>
                   <td><input type="text" ID="T3" name="T3" maxlength="60" placeholder="campo obligatorio" class="texto2" autocomplete="off" readonly="true" /></td>  
               </tr>
                <tr><td colspan="3"></td></tr>
               <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Direcci&oacute;n</label></td>
                   <td><input type="text" ID="T4" name="T4" maxlength="60" class="texto2" autocomplete="off" readonly="true" /></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td><input type="text" ID="F" name="F" class="texto2" style="width: 30px; visibility: hidden;" autocomplete="off" /></td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Barrio</label></td>
                   <td><input type="text" ID="T5" name="T5" maxlength="20" class="texto2" autocomplete="off" readonly="true" /></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Tel&eacute;fono</label></td>
                   <td><input type="text" ID="T6" name="T6" maxlength="12" onkeyUp="return ValNumero(this);" class="texto2" autocomplete="off" readonly="true" /></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Actualizaci&oacute;n No. Contacto</label></td>
                   <td><input type="text" ID="T6b" name="T6b" maxlength="12" class="texto2" onkeyUp="return ValNumero(this);" autocomplete="Off" readonly="true" /></td>
                   <td></td>
               </tr>
                <tr><td colspan="3"></td></tr>
               <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Celular</label></td>
                   <td><input type="text" ID="T7" name="T7" maxlength="12" onkeyUp="return ValNumero(this);" class="texto2" autocomplete="off" readonly="true" /></td>
               </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Email</label></td>
                   <td><input type="text" ID="T8" name="T8" maxlength="60" placeholder="campo obligatorio" onblur="return checkEmailAddress(this);" class="texto2" autocomplete="off" readonly="true" /></td>
                </tr>
                <tr><td colspan="3"></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Departamento</label></td>
                   <td><input type="text" ID="T9" name="T9" maxlength="20" class="texto2" autocomplete="off" readonly="true" /></td>
                </tr>
                <tr><td colspan="3"></td></tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">Minicipio</label></td>
                   <td><input type="text" ID="T10" name="T10" maxlength="30" class="texto2" autocomplete="off" readonly="true" /></td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1">OBJETIVO DE COMPRAS 2022</label></td>
                   <td><input type="text" ID="T11" name="T11" maxlength="11" class="texto1" style="text-align: right;" readonly="true" /></td>
                </tr>
                
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td style="vertical-align: top;"><label style="font-size: 14pt" class="etiqueta1">Premios</label></td>
                   <td>
                   <!--<select id="Premio" name="Premio" class="combolargo"></select>-->
                   <!--<input type="text" id="Premio" name="Premio" placeholder="campo obligatorio" class="texto2" readonly="true"/>--> 
                   <textarea id="Premio" name="Premio" rows="1" placeholder="campo obligatorio" class="texto2" readonly="true" style="visibility: hidden;"></textarea>
                   </td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <td>&nbsp;</td>
                   <td colspan="2">
                   <!--<div id="fotosp1" style="text-align: center; float: left;"></div><br />
                   <div id="fotosp2" style="text-align: center; float: left;"></div><br />
                   <div id="fotosp3" style="text-align: center; float: left;"></div><br />
                   <div id="fotosp4" style="text-align: center; float: left;"></div><br />-->
                   <div id="fotosp5" style="text-align: center; float: left;"></div><br />
                   </td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td colspan="3">
                <label>Firmado...</label>
                <!--Firma manuscrita-->
            <!--<form id="formCanvas" name="formCanvas" method="POST" ENCTYPE="multipart/form-data" action="">
                <div class="centrador">
                    <label style="font-size: 11pt; font-weight: bold;font-family: MyriadProBold;">FIRMA CLIENTE</label><br />
                  <canvas id="canvas" width="500" height="120" style="border: 1px solid #CCC; box-shadow: inset 3px 3px 3px rgba(255,255,255,.7), inset 2px 2px 3px rgba(0,0,0,.1), 2px 2px 3px rgba(0,0,0,.1); background-color: #fff; color: #000;">
                    <p>Tu navegador no soporta canvas</p>
                  </canvas><br />

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' onclick='LimpiarTrazado()'>Borrar</button>
                    
                    <button type="button" style="visibility: hidden;" onclick="guardarDatos();">Guardar</button>
                    <input type="hidden" name="imagen" id="imagen" />
                    <input type="hidden" name="imagenom" id="imagenom" />
                </div>-->
                <?php
                
                    // comprovamos si se envió la imagen
                    /*if (isset($_POST['imagen'])) { 
                        
                        function uploadImgBase64 ($base64, $name){
                        // decodificamos el base64
                        $datosBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                        // definimos la ruta donde se guardara en el server
                        $path= $_SERVER['DOCUMENT_ROOT'].'/modulo_plan/FIRMAVENDEDOR/'.$name;
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
                        $nombre=$_POST["imagenom"];
                        $imag=$_POST["imagen"];
                        uploadImgBase64($imag, $nombre.".png" );
                        //tamaño imagen
                        $tamano = '0';//filesize("FIRMAVENDEDOR/".$nombre.".png"); 
                        //echo 'tamano:'.$tamano;
                        echo "<input type=\"text\" name=\"firm\" id=\"firm\" value=\"$tamano\" style=\"visibility: hidden;\">";
                    }else{
                        if(empty($tamano)){
                            $tamano=0;
                        }
                        //echo "<input type='text' name='firm' id='firm' value='$tamano' style='visibility: visible;'>";
                        echo "<input type=\"text\" name=\"firm\" id=\"firm\" value=\"$tamano\" style=\"visibility: hidden;\">";
                    }
                    */
                ?>
                    
                <!--</form>-->
                </td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td style="width: 10%">&nbsp;</td>
                    <td colspan="2" style="text-align: justify;">
                    <?
                    if($emp=='AG'){
                    ?>
                    <p style="width: 90%;">
                    <div class="descricondiciones">
                    <br />CONOCIENDO Y ACEPTANDO LAS SIGUIENTES CONDICIONES:<br />
                    <ol>
                    <li><label class="parrafo">Concurso valido por compras antes de IVA desde enero 1 hasta el 24 de diciembre 2022.</label></li> 
                    <li><label class="parrafo">V&aacute;lido &uacute;nicamente por compras de medicamentos y productos importados directamente por Agrocampo (Consulte a su asesor).</label></li> 
                    <li><label class="parrafo">S&oacute;lo se entregar&aacute; (1) un premio, de las alternativas en cada escala asignada.</label></li>  
                    <li><label class="parrafo">Los premios son &uacute;nicamente los relacionados en el Plan Año 2022.</label></li>  
                    <li><label class="parrafo">Plazo m&aacute;ximo para la firma del negocio es abril 15 de 2022.</label></li> 
                    <li><label class="parrafo">La entrega del premio se har&aacute; m&aacute;ximo el 30 de abril de 2023.</label></li>  
                    <li><label class="parrafo">Para la entrega del premio, el cliente debe tener un adecuado manejo del cr&eacute;dito y estar al d&iacute;a en cartera.</label></li> 
                    <li><label class="parrafo">Los fletes del premio deben ser asumidos por el ganador.</label>  
                    <li><label class="parrafo">Ning&uacute;n premio es transferible, ni canjeable por dinero o especie.</label></li>  
                    <li><label class="parrafo">Los premios pueden ser susceptibles a cambios seg&uacute;n<br /> la disponibilidad de referencias, pero siempre ser&aacute;n iguales o superiores<br /> a los especificados en este acuerdo y de marcas reconocidas.</label></li>
                    <!--<li><label class="parrafo">Las caracter&iacute;sticas y modelo de los productos son susceptibles a cambios seg&uacute;n <br />disponibilidad de referencia.</label></li>--> 
                    <li><label class="parrafo">La imagen no representa el producto final.</label></li> 
                    <li><label class="parrafo">No incluye tr&aacute;mite de visas en los destinos que lo requieran.</label></li>
                    <li><label class="parrafo">Los viajes son para el titular de la cuenta con Agrocampo y son intransferibles.</label></li> 
                    <li><label class="parrafo">Los viajes son redimibles &uacute;nicamente en temporada baja y durante el 2022. No incluye puentes ni festivos. La fecha debe ser acordada con m&iacute;nimo 3 meses de anticipaci&oacute;n, la cual no debe ser cambiada debido a los altos costos que implica.</label></li>
                    <li><label class="parrafo">Se le enviara por correo electr&oacute;nico copia de este acuerdo como soporte del PLAN AÑO 2022, por favor impr&iacute;mala y cons&eacute;rvela.</label></li>
                    <br />CONDICIONES NOTA CR&Eacute;DITO:<br />
                    </ol>
                    <ol>
                    <li><label class="parrafo">El premio que se genera a trav&eacute;s de la nota cr&eacute;dito tomar&aacute; como base para su liquidaci&oacute;n las compras realizadas del del 1 de enero al 24 de diciembre de 2022 antes de IVA. (V&aacute;lido &uacute;nicamente<br /> por compras de medicamentos y productos importados directamente por Agrocampo.)</label></li> 
                    <li><label class="parrafo">Para el descuento de la nota del 3% el cliente deber&aacute; tener en cuenta lo siguiente:</label></li> 
                        <ol type="a">
                        <li><label class="parrafo">Las compras deben ser de enero 1 hasta el 24 de diciembre 2022.</label></li>
                        <li><label class="parrafo">Las facturas emitidas en el periodo antes mencionado deben estar plenamente canceladas.</label></li>
                        <li><label class="parrafo">Una vez verificada la informaci&oacute;n de los puntos a. y b. se emitir&aacute; al cliente la nota correspondiente y se remitir&aacute; v&iacute;a correo electr&oacute;nico..</label></li> 
                        <li><label class="parrafo">Tras recibir la nota cr&eacute;dito, el cliente deber&aacute; manifestarnos por escrito a qu&eacute; facturas se aplicar&aacute;.</label></li>
                        </ol>
                    </ol></div>
                    <? 
                    setlocale(LC_ALL, 'spanish');
                    //strftime('%d de %B del %Y'); 
                    $dia=strftime('%d');
                    $mes=strftime('%B');
                    ?>
                    <center><label class="parrafo" style="text-align: center;">Se expide en BOGOTA D.C a los <? echo $dia; ?> d&iacute;as del mes de <? echo $mes; ?> de 2022.</label></center>
                    </p>
                    <?
                    } else if($emp=='X1'){
                    ?>
                    <p style="width: 90%;">
                    <label style="font-size: 14pt" class="etiqueta1">Descripci&oacute;n de premios</label>
                    <div id="descripremios">
                    
                    </div>
                    <br />CONOCIENDO Y ACEPTANDO LAS SIGUIENTES CONDICIONES:<br />
                    <ol>
                    <li><label class="parrafo">Concurso valido desde enero 1 de 2022 hasta el 21 de diciembre de 2022.</label></li> 
                    <li><label class="parrafo">V&aacute;lido &uacute;nicamente por compras de medicamentos de Pestar.</label></li> 
                    <li><label class="parrafo">La fecha l&iacute;mite para la entrega de premios ser&aacute; marzo de 2022.</label></li>
                    <li><label class="parrafo">Para la entrega del premio, el cliente debe tener un adecuado manejo del cr&eacute;dito y estar al d&iacute;a en cartera a enero de 2022.</label></li>
                    <li><label class="parrafo">Tan pronto sea diligenciado este formulario le llegar&aacute; una copia de este plan a&ntilde;o a su correo electr&oacute;nico, este documento ser&aacute; solicitado en el momento de la entrega del premio.</label></li>
                    </ol>
                    <? 
                    setlocale(LC_ALL, 'spanish');
                    //strftime('%d de %B del %Y'); 
                    $dia=strftime('%d');
                    $mes=strftime('%B');
                    ?>
                    <center><label class="parrafo" style="text-align: center;">Se expide en BOGOTA D.C a los <? echo $dia; ?> d&iacute;as del mes de <? echo $mes; ?> de 2022.</label></center>
                    <br /><br /><center><label class="parrafo" style="text-align: center;">De esta manera esperamos premiar su fidelidad.</label></center>
                    </p>
                    <?
                    }
                    ?>
                    </td>
                </tr>
                <tr>
                   <td style="width: 5%">&nbsp;</td>
                   <td colspan="2" style="text-align: justify;">                   
                   &nbsp;&nbsp;&nbsp;&nbsp;<div id="autorizacion" style="width: 98%; color: gray;">
                   
                   </div>
                   </td>
                </tr>
                <tr>
                    <td style="width: 5%">&nbsp;</td>
                   <td colspan="2" style="text-align: left;">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input type="checkbox" ID="datosper" id="datosper" onclick="manejoDatospersonales(this.checked);" style="text-align: center; width: 100px; visibility: hidden;" /><label style="visibility: hidden;" id="dper">Acepto el acuerdo anterior.</label>
                   </td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
               <tr>
                   <td colspan="3" style="text-align: center">
                   <?php $emp=$_GET['emp']; ?>
                   <input type="button" ID="Enviarf" name="Enviarf" onclick="guardarDatos('<? echo $emp; ?>');" class="botong" value="GENERAR PLAN" style="width: 200px;"></td>  
               </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><label style="font-size: 14pt" class="etiqueta1" style="visibility: hidden;">&nbsp;</label></td>
                   <td>
                   <input type="text" id="Categoria" name="Categoria" class="texto1" autocomplete="off" style="text-align: center; width: 100px; visibility: hidden;" readonly="true" /><br />
                   <input type="text" id="manejodatos" name="manejodatos" class="texto1" value="0" autocomplete="off" style="text-align: center; width: 50px; visibility: hidden;" readonly="true" />
                   <input type="text" id="premioelegido" name="premioelegido" class="texto1" value="0" autocomplete="off" style="text-align: center; width: 50px; visibility: hidden;" readonly="true" />
                   <input type="text" id="coord" value="0000" style="visibility: hidden; width: 50px;" />
                   <input type="text" id="monto2" style="visibility: hidden; width: 20px;" />
                   <input type="text" value="" id="Textoimagen" style="width: 100px; visibility: hidden;" />
                   <input type="text" id="Tpp" style="width: 10px; visibility: hidden;" />
                   <input type="text" value="" id="condicion" style="width: 100px; visibility: hidden;" />
                   <!--<input type="button" id="cambia" onclick="cambiarTildes();" />-->
                   </td>
                </tr>
               </table >  
                
        </div>             
            </div>
          
                    <script type="text/javascript">
                        /* Variables de Configuracion */
                        var idCanvas = "canvas";
                        var idForm = "formCanvas";
                        var inputImagen = "imagen";
                        var estiloDelCursor = "crosshair";
                        var colorDelTrazo = "#555";
                        var colorDeFondo = "#fff";
                        var grosorDelTrazo = 1;

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
                        window.addEventListener("load", IniciarDibujo, false);

                        function IniciarDibujo() {
                            // Creamos la pizarra 
                            pizarraCanvas.style.cursor = estiloDelCursor;
                            contexto = pizarraCanvas.getContext("2d");
                            contexto.fillStyle = colorDeFondo;
                            contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
                            contexto.strokeStyle = colorDelTrazo;
                            contexto.lineWidth = grosorDelTrazo;
                            contexto.lineJoin = "round";
                            contexto.lineCap = "round";
                            // Capturamos los diferentes eventos 
                            pizarraCanvas.addEventListener("mousedown", MouseDown, false);
                            pizarraCanvas.addEventListener("mouseup", MouseUp, false);
                            pizarraCanvas.addEventListener("mousemove", MouseMove, false);
                            pizarraCanvas.addEventListener("touchstart", TouchStart, false);
                            pizarraCanvas.addEventListener("touchmove", TouchMove, false);
                            pizarraCanvas.addEventListener("touchend", TouchEnd, false);
                            pizarraCanvas.addEventListener("touchleave", TouchEnd, false);
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
                            imagen.value = document.getElementById(idCanvas).toDataURL("image/png");
                            //var myCanvas = document.getElementById("canvas");
                            //var context = myCanvas.getContext("2d");
                            //context.beginPath();
                            //context.fillStyle = "rgb(0, 0, 0)";
                            document.forms[idForm].submit();
                        }
                    </script>
            <!--finfirma-->
  </div>      
    </body>
</html>
