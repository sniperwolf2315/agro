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
.center1 {
  margin: auto;
  
  width: 50%;
}

</style>    
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
 
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
 
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 
    <script language="JavaScript">
    
    function ConsultarListaIngresos() {
    var ini=document.getElementById('inicial').value;
    var fin=document.getElementById('fin').value;
    var sede=document.getElementById('sede').value;
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
    // Preparar la funcion de respuesta
    peticion_http.onreadystatechange = muestraContenido;
    //alert("aqui: ini: "+ini+" fin: "+fin+" sede: "+sede);
    // Realizar peticion HTTP
    //peticion_http.open('POST', 'buscaingresoslista.php', true);
    peticion_http.open('POST', 'buscaingresoslista.php?i=' + ini + '&f=' + fin + '&sede=' + sede, true);
    //peticion_http.open('POST', 'buscaingresoslista.php', true);
    
    peticion_http.send(null);
    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert('COMPLETADO..');
                                document.getElementById('respuesta').innerHTML=dato;
                                //document.getElementById('resultado').innerHTML='Archivo Generado';
                                //document.getElementById('formu').innerHTML='';
                                document.body.style.cursor = 'auto';
                                //verLink(dato);
                                //setTimeout("location.reload(true);", 500);
                            }
                        }
                    } 
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
   
    <div class="center">
        <div class="row white center">
            <div class="col s6 m12 l12 xl12 offset-12">    <!--class="col s6 m12 l12 xl12 offset-12"-->
                <div class="row blue lighten-3"><!--class="row blue lighten-3"-->
                    <div class="col s6 offset-s3 white-text" style="background-color: #024C68;"><!--class="col s12 m7 l6 xl12 white-text" style="background-color: #024C68;"-->
                        <div class="flow-text" style="font-size:1.5vw;text-align:center;">
                            <span style="color: #FFFFFF;">TOMA DE TEMPERATURAS</span>
                        </div>
                        <div ><!--style="width:470px; background-color: #024C68;"-->
                            <div ><!--class="input-field col s3" style="width:450px; float: left;"-->
                                <table>
                                    <center><select id="sede" onchange="(this.value);" class="browser-default black-text" style="width: 30%;">
                                        <option value="TODO">Todo</option>
                                        <option value="CALLE 73">CALLE 73</option>
                                        <option value="PORTOS">PORTOS</option>
                                    </select></center>
                                    <tr>
                                    <td>Fecha Inicio: <hr style="width: 90%;"><input type="date" maxlength="2" id="inicial" name="trip-start" value="inicial" min="2018-01-01" max="2022-12-31"></td>
                                    <td>Fecha Fin: <hr style="width: 90%;"><input type="date" maxlength="2" id="fin" name="trip-start" value="fin" min="2018-01-01" max="2030-12-31"></td>
                                    </tr>
                                    <tr><td colspan="12"><center><a class="waves-efect waves-light btn" onclick="ConsultarListaIngresos();">Consultar Ingreso</a><center></td></tr>
                                
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
        <div id="number"></div> 
        <div id="estado" style="width: 99%; text-align: center; background-color: #90CAF9;">
                            
            </div>   
            <div id="respuesta" style="width: 99%; text-align: center; background-color: #90CAF9;">
                            
            </div>  
            <!--<div id="formu" style="width: 99%; text-align: center; background-color: #90CAF9;">
                            
            </div>-->     
    </div>
   </div>
    
    
    
</body>
</html>