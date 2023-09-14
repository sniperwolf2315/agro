<? session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>SIA DASHBOARD</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="antenna.css" id="css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="aajquery.js"></script>
<style type="text/css">.abs {position:absolute}</style>
<script type="text/javascript" src="../../antenna/auto.js"></script>
<script>
$(document).ready(function(){
    $(".verloader").click(function(){
        $(".loader").show("slow");
    });
});

$(window).load(function() {
    $(".loader").fadeOut();
});
</script>
</head>
<body class="global">
<div class="loader" ><br><br><br><br><br>Cargando.....</div>
<div id="lays701jprcl"></div>
<div id="lays450axwhi">
<div id="text450gwlro" class="fil abs table-responsive" style="left:15%; top:37px; width:70%; height:90%;">
  <div class="table-responsive">
      <?php
      include('user_user.php');
       
      $tiene_permiso = $_SESSION["dIr"];
    if($tiene_permiso=="SI"){
      ?>
  <table class="frr" width="100%" height="30%" bordercolor="silver" border="5" cellspacing="0" class="table table-sm table-hover table-light">
  <thead  height="10%" >
  <tr>
<?php
      /* esta opcion es solo para que estos usuarios cambien la firma a necesidad */
      if($_SESSION["usuARio"] =='GOMEZD'      ||$_SESSION["usuARio"] =='VILLALOBOSC' ||$_SESSION["usuARio"] =='TORRESC'     ||$_SESSION["usuARio"] =='DIAZD'       ||$_SESSION["usuARio"] =='CIFUENTESE' ||$_SESSION["usuARio"] =='RODRIGUEZJ'  ){
            $_SESSION["usuARioS"] =  $_SESSION["usuARio"];
            $user=  $_SESSION["usuARio"];
            $pass = $_SESSION["clAVe"];
            echo '<a href="./nuevo_sia_v2/modules/mod_firmas_portos/index.php?us='.$user.'&pa='.$pass.'" target="_blank" > Firmas</a>';
        }
      ?>
</tr>
    <tr>

        <!-- <td  colspan="5" align="center" valign="middle" bgcolor="#FE7203" style="width: 350px; height: 77px"> -->
        <td  colspan="8" rowspan="1" align="center" valign="top" bgcolor="#FE7203" style="width: 100%; height: 5px">

            <input type="button" value="Fac Contingencia" style=" text-decoration:underline; background-color: #FE7203; height:40%; width:20%;  background-position: bottom; background-repeat:no-repeat;" onClick="window.location = '/modulo_conti/pags/contingencia.php'"  >
           
           <input type="button" value="Fac Bod-Rappi" style=" text-decoration:underline; background-color: #FE7203; height:40%; width:20%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = '/modulo_conti/pags/cont_tira.php'"  >
           
           <input type="button" value="Fac Bod-RMX" style=" text-decoration:underline; background-color: #FE7203; height:40%; width:20%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = '/modulo_conti/pags/cont_tira_eventos.php'"  >
           
           <input type="button" value="Tickets" style=" text-decoration:underline; background-color: #FE7203; height:40%; width:20%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = '/moduloP/vales/vales.php'"  >
           
           <input type="button" value="Cuenta Prov" style="text-decoration:underline; background-color: #FE7203; height:40%; width:20%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = '/modulo_prov/pags/prov_plan.php'"  >
           
                <br>   
            <h5>INFORMES</h5>

        </td>

        <td width="14%" height="5" rowspan="1" align="center" valign="top" bgcolor="#FFFFFF">
          <?php    
              $emp = explode("-",$_SESSION['emp']);
            ?>
            <img src="images/logo<?= $emp[0]?>.jpg" style="height: 100px;"  >
           
        
          </td>
    </tr>

    <br>
  
</thead>

<tbody style="background-color: white; ">
  
<tr>
    <!-- <td colspan="8" align="center" valign="middle" bgcolor="white" style=" background-color: #0E9548;" > -->
    <!-- <input type="button" value="INFORMES" style=" text-decoration:underline; background-color: #0E9548; height:95%; width:95%; background-position: bottom; background-repeat:no-repeat;" OonClick="window.location = ''"  > -->
    <!-- <label  style=" text-decoration:underline; background-color: #0E9548; height:10%; width:100%; background-position: top; background-repeat:no-repeat;"  OonClick="window.location = ''"  >INFORMES</label> -->
    <!-- </td> -->
    <td align="center" valign="middle" bgcolor="white" style="width: 18%" rowspan="1" colspan="1" > 
      <input class="verloader" type="button" value=" Fact. Pendientes " style=" text-decoration:blink; text-decoration:underline; background-color: #0E9548; height:40%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'modulo_conti/pags/cont_recibo.php'"  >
    </td> 

    <td align="center" valign="middle" bgcolor="white" style="width: 18%" colspan="1">
      <input class="verloader" type="button" value=" Inventarios " style=" text-decoration:underline; background-color: #0E9548; height:40%; width:95%;  background-position: 50% bottom; background-repeat:no-repeat;" onClick="window.location = 'moduloI/pags/inv.php'"  >
    </td>

    <td align="center" valign="middle" bgcolor="white" colspan="1" rowspan="1">
      <input  ut type="button" value="Tableros" style=" text-decoration:underline; background-color: #0E9548; height:40%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'inicio_tableros.php'"  >
    </td>

    <td align="center" valign="middle" bgcolor="white" style="width: 18%" rowspan="1"> 
          <input type="button" value=" Descuentos " style=" text-decoration:blink; text-decoration:underline; background-color: #0E9548; height:40%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'moduloI/pags/descuentos.php'"  >
    </td>

    <td align="center" valign="middle" bgcolor="white" style="width: 18%" colspan="2">
    <?php
      //SUAREZM
      $UsuarioActivado=$_SESSION["usuARio"];
    if($UsuarioActivado!=='CASTILLOW' && $UsuarioActivado!=='MONTNEGROJ' && $UsuarioActivado!=='VILLAJ'){
      ?>
        <input class="verloader" type="button" value=" Ventas" style=" text-decoration:underline; background-color: #0E9548; height:40%; width:100%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location ='moduloI/pags/ventas_area.php'"  />
    <?php
      }
    ?>
    </td>
    <td>
     <?php
     
     if($_SESSION["usuARio"] == 'CIFUENTESE' || $_SESSION["usuARio"]=='VILLALOBOSC' || $_SESSION["usuARio"] =='VILLALOBOS' ||  $_SESSION["usuARio"] == 'JIMENEZR' ||$_SESSION["usuARio"] =='RODRIGUEZJ'){
      $_SESSION["usuARioS"] =  $_SESSION["usuARio"];
      ?> 
        <!-- <input class="verloader" type="button" value=" Ventas / Cuota Nuevo" style=" text-decoration:underline; background-color: #0E9548; height:40%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'moduloI/pags/ventas_cuota_new.php'"/> -->
       
      
        <input type="button" value=" Ventas / Cuota Nuevo" style=" text-decoration:underline; background-color: #0E9548; height:40%; width:95%; background-position: bottom; background-repeat:no-repeat;" class="verloader" onclick="location.href='moduloI/pags/ventas_cuota_new.php'"/>
        <?php
        }
        else{
          ?> 
        <input class="verloader" type="button" value=" Ventas / Cuota Nuevo" style=" text-decoration:underline; background-color: #0E9548; height:40%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'moduloI/pags/ventas_cuota_new.php'" disabled />
        <?php
        }
        ?> 
    </td>
    <td>
    </td>
    <td style="background-color: white; " ></td>

    <td style="text-align: center; heigth:10%; width:10%" >
    <div class="container">
      <span size="+1" align="center"><b>ENCUESTAS<br><font color="red">OBLIGATORIAS</font><br>COVID-19</b></span><br>
      <input class="verloader" type="button" value=" 1ra vez "         style=" text-decoration:underline; background-color: pink;   height:30%; width:100%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_cov/enc1.php'"  />
      <input class="verloader" type="button" value=" Diaria "          style=" text-decoration:underline; background-color: pink;   height:30%; width:100%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_cov/enc_dia.php'"  />
      <input class="verloader" type="button" value=" Encuesta Vacuna " style=" text-decoration:underline; background-color: pink;   height:30%; width:100%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_vac/enc_vac.php'"  /><br>
      <input class="verloader" type="button" value="IBS"               style=" text-decoration:underline; background-color: #FE7203;height:50%; width:100%; background-image:url(images/logoIBS.jpg); background-position: center;  background-position: 1%  top; background-repeat:no-repeat; color:white" onClick="window.location = '/ibs'"  >
    </div>
    </td>   
</tr>

</tr>
<tr>
  <td> 
    <!-- SANCIONES -->
  <input class="verloader" type="button" value=" Sanciones " style=" font-size:13px; text-decoration:underline; background-color: #0E9548; height:100%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'nuevo_sia_v2/modules/mod_sanciones/con_sanciones/index.php?usr_con_sancion='"/>
  <input class="verloader" type="button" value=" Tracking "  style=" font-size:13px; text-decoration:underline; background-color: #0E9548; height:100%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'nuevo_sia_v2/modules/mod_magento/consulta_ordenes/index.php?usr_con_sancion='"/>


  </td>
</tr>

            </tbody>
          </table>
          <?php 

}else if($tiene_permiso=='NO' && ($_SESSION["usuARio"]=='ANIMALF' || $_SESSION["usuARio"]=='RAPPIBOSQU' || $_SESSION["usuARio"]=='RAPPITOBER')){
?>


<table>
  <thead>
    <tr>
      <td width="14%" height="5" rowspan="1" align="center" valign="top" bgcolor="#FFFFFF">
          <?php    
              $emp = explode("-",$_SESSION['emp']);
            ?>
            <img src="images/logo<?= $emp[0]?>.jpg" style="height: 100px;"  >
          </td>
    </tr>

    <tr>
      <td colspan=""3"><h5>INFORMES</h5></td>
    </tr>

  <tr>
      <td colspan="2">
        <input type="button" value="Fac Bod-Rappi" style=" text-decoration:underline; background-color: #FE7203; height:40%; width:100%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = '/modulo_conti/pags/cont_tira.php'"  >
      </td>

  </tr>
  
  <tr>
    <td align="center" valign="middle" bgcolor="white" style="width: 40%" colspan="2">
    <?php
        $UsuarioActivado=$_SESSION["usuARio"];
        if($UsuarioActivado!=='CASTILLOW' && $UsuarioActivado!=='MONTNEGROJ' && $UsuarioActivado!=='VILLAJ'){
    ?>
        <input class="verloader" type="button" value=" Ventas" style=" text-decoration:underline; background-color: #0E9548; height:40%; width:100%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location ='moduloI/pags/ventas_area.php'"  />
        <input class="verloader" type="button" value=" Ventas / Cuota Nuevo" style=" text-decoration:underline; background-color: #0E9548; height:40%; width:100%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'moduloI/pags/ventas_cuota_new.php'" disabled />
    <?php
      }
    ?>
    </td>
  </thead>
</table>


<table class="frr" width="50%" height="30%" bordercolor="silver" border="5" cellspacing="0" class="table table-sm table-hover table-light">
<tbody style="background-color: white; ">
<tr>
  <div class="container">
    <span size="+1" align="center"><b>ENCUESTAS<br><font color="red">OBLIGATORIAS</font><br>COVID-19</b></span><br>
    <input class="verloader" type="button" value=" 1ra vez "         style=" text-decoration:underline; background-color: pink;   height:10%; width:10%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_cov/enc1.php'"  />
    <input class="verloader" type="button" value=" Diaria "          style=" text-decoration:underline; background-color: pink;   height:10%; width:10%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_cov/enc_dia.php'"  />
    <input class="verloader" type="button" value=" Encuesta Vacuna " style=" text-decoration:underline; background-color: pink;   height:10%; width:10%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_vac/enc_vac.php'"  /><br>
    
    <span size="+1" align="center">IBS WEB</span><br>
    <input class="verloader" type="button" value="IBS"               style=" text-decoration:underline; background-color: #FE7203;height:10%; width:10%; background-image:url(images/logoIBS.jpg); background-position: center;  background-position: 1%  top; background-repeat:no-repeat; color:white" onClick="window.location = '/ibs'"  >
  </div>
</tr>

</tbody>

</table>
<?php
/* SOLO VENDEDORES QUE NO DEBEN VER NADA MAS  */
}else{
 ?>

 
<table>
  <thead>
    <tr>
      <td width="14%" height="5" rowspan="1" align="center" valign="top" bgcolor="#FFFFFF">
          <?php    
              $emp = explode("-",$_SESSION['emp']);
            ?>
            <img src="images/logo<?= $emp[0]?>.jpg" style="height: 100px;"  >
          </td>
    </tr>

    <tr>
      <td colspan=""3"><h5>INFORMES</h5></td>
    </tr>


  
  <tr>
    <td align="center" valign="middle" bgcolor="white" style="width: 40%" colspan="2">
    <?php
    /* HACEMOS EL LLAMADO AL SERVICIO DE LOGUE CON EL SIA ANTIGUO  SECCION DE VENDEDORES*/
      
      $UsuarioActivado=$_SESSION["usuARio"];
        if($UsuarioActivado!=='CASTILLOW' && $UsuarioActivado!=='MONTNEGROJ' && $UsuarioActivado!=='VILLAJ' && $UsuarioActivado!=='FERIAS' && $UsuarioActivado!=='RODRIGUEZM' && $UsuarioActivado!=='SANGUINOK'){
          // $_SESSION["usuARioS"] =  $_SESSION["usuARio"];
      // echo substr($UsuarioActivado,0,8);
      // if(substr($UsuarioActivado,0,8)=='VENPEST'){
      //   echo '<input class="verloader" type="button" value=" Ventas"                     style=" text-decoration:underline; background-color: #0E9548; height:38px; width:100%; background-position: bottom; background-repeat:no-repeat;font-weight:bold; font-size:14px;" onClick="window.location =\'moduloI/pags/ventas_area.php\'"  />';
      // }else{
      //   echo '<input class="verloader" type="button" value=" Ventas / Cuota Nuevo"       style=" text-decoration:underline; background-color: #0E9548; height:38px; width:100%; background-position: bottom; background-repeat:no-repeat;font-weight:bold; font-size:14px;" onClick="window.location =\'moduloI/pags/login_sia_ventas_cuotas.php\'"  />';
      // }



    ?>
        <input class="verloader" type="button" value=" Ventas"                     style=" text-decoration:underline; background-color: #0E9548; height:38px; width:100%; background-position: bottom; background-repeat:no-repeat;font-weight:bold; font-size:14px;" onClick="window.location ='moduloI/pags/ventas_area.php'"  />
        <input class="verloader" type="button" value=" Ventas / Cuota Nuevo"       style=" text-decoration:underline; background-color: #0E9548; height:38px; width:100%; background-position: bottom; background-repeat:no-repeat;font-weight:bold; font-size:14px;" onClick="window.location ='moduloI/pags/login_sia_ventas_cuotas.php'"  />
        <input class="verloader" type="button" value=" Tablero Seguimiento Ventas" style=" text-decoration:underline; background-color: #0E9548; height:38px; width:100%; background-position: bottom; background-repeat:no-repeat;font-weight:bold; font-size:14px;" onClick="window.location ='moduloI/tableros/domi_dias/login_sia_tableros.php'" />
        <input class="verloader" type="button" value=" Fact. Pendientes"           style=" text-decoration:underline; background-color: #0E9548; height:38px; width:100%; background-position: bottom; background-repeat:no-repeat;font-weight:bold; font-size:14px;" onClick="window.location ='modulo_conti/pags/cont_recibo.php'" />
        <!-- <input class="verloader" type="button" value=" Sanciones " style=" font-size:13px; text-decoration:underline; background-color: #0E9548; height:100%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'nuevo_sia_v2/modules/mod_sanciones/con_sanciones/index.php?usr_con_sancion='"/> -->
        <input class="verloader" type="button" value=" Sanciones " style=" font-size:13px; text-decoration:underline; background-color: #0E9548; height:100%; width:95%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = 'nuevo_sia_v2/modules/mod_sanciones/con_sanciones/login.php'"/>
        
        
    <?php
      }
    ?>
    </td>
    </tr>
<tr>
<?php
      /* esta opcion es solo para que estos usuarios cambien la firma a necesidad */
      if(
        $_SESSION["usuARio"] =='ALVAREZR'   ||   $_SESSION["usuARio"] =='NARVAEZY'   ||  $_SESSION["usuARio"] =='FERIAS'     ||   $_SESSION["usuARio"] =='RODRIGUEZM' ||     $_SESSION["usuARio"] =='SANGUINOK' 
        ){
            $user=  $_SESSION["usuARio"];
            $pass = $_SESSION["clAVe"];
            // echo '<a href="./nuevo_sia_v2/modules/mod_firmas_portos/index.php?us='.$user.'&pa='.$pass.'" target="_blank" > Firmas</a>';
            echo '<input class="verloader" type="button" value=" Firmas " style="color:white; font-size:3vw; text-decoration:blink; text-decoration:underline; background-color: #0E9548; height:20%; width:100%; background-position: bottom; background-repeat:no-repeat;" onClick="window.location = \'./nuevo_sia_v2/modules/mod_firmas_portos/index.php?us='.$user.'&pa='.$pass.'\'">          ';
            ?>

          <?php
           
        }
      ?>
</tr>
 
  </thead>
</table>


<table class="frr" width="50%" height="30%" bordercolor="silver" border="5" cellspacing="0" class="table table-sm table-hover table-light">
<tbody style="background-color: white; ">
<tr>
  <div class="container">
    <span size="+1" align="center"><b>ENCUESTAS<br><font color="red">OBLIGATORIAS</font><br>COVID-19</b></span><br>
    <input class="verloader" type="button" value=" 1ra vez "         style=" text-decoration:underline; background-color: pink;   height:10%; width:10%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_cov/enc1.php'"  />
    <input class="verloader" type="button" value=" Diaria "          style=" text-decoration:underline; background-color: pink;   height:10%; width:10%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_cov/enc_dia.php'"  />
    <input class="verloader" type="button" value=" Encuesta Vacuna " style=" text-decoration:underline; background-color: pink;   height:10%; width:10%; background-image:url('/images/descarga.png'); background-position: 50% top; background-repeat:no-repeat;" onClick="window.location = 'moduloRH/encuesta_vac/enc_vac.php'"  /><br>
    
    <span size="+1" align="center">IBS WEB</span><br>
    <input class="verloader" type="button" value="IBS"               style=" text-decoration:underline; background-color: #FE7203;height:10%; width:10%; background-image:url(images/logoIBS.jpg); background-position: center;  background-position: 1%  top; background-repeat:no-repeat; color:white" onClick="window.location = '/ibs'"  >
  </div>
</tr>

</tbody>

</table>
<?php
}

?>

          </div>
      </div>
</div>
  </body>
</html>

