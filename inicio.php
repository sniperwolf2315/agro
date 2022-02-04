<? session_start(); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Untitled Web Page</title>

<meta name="generator" content="Antenna 3.0">

<meta http-equiv="imagetoolbar" content="no">

<link rel="stylesheet" type="text/css" href="antenna.css" id="css">

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

<div id="lays701jprcl">

</div>



<div id="lays450axwhi">

<div id="text450gwlro" class="fil abs" style="left:15%; top:37px; width:70%; height:90%;">

  <table class="frr" width="100%" height="100%" bordercolor="silver" border="5" cellspacing="0">

    <tr>

      <td  colspan="2" align="center" valign="middle" bgcolor="#FE7203" style="width: 347px; height: 77px">
       <input type="button" value="Fac Contingencia" style=" text-decoration:underline; background-color: #FE7203; 
       height:48%; width:95%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 
       onClick="window.location = '/modulo_conti/pags/contingencia.php'"  >
       <input type="button" value="Fac Bod-Rappi" style=" text-decoration:underline; background-color: #FE7203; 
       height:48%; width:95%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 
       onClick="window.location = '/modulo_conti/pags/cont_tira.php'"  >
       </td>

      <td  colspan="2" align="center" valign="middle" bgcolor="#FE7203" rowspan="2">
	  
	  <input type="button" value="Tickets" style=" float: left; text-decoration:underline; background-color: #FE7203; 
       height:95%; width:58%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 
       onClick="window.location = '/moduloP/vales/vales.php'"  >
      <input type="button" value="Cuenta Prov" style=" float: right; text-decoration:underline; background-color: #FE7203; 
       height:95%; width:38%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 
       onClick="window.location = '/modulo_prov/pags/prov_plan.php'"  >
	  </td>

      <td width="14%" rowspan="5" align="center" valign="top" bgcolor="#FFFFFF">
	  <?php    
	    $emp = explode("-",$_SESSION['emp']);
	  ?>
      <img src="images/logo<?= $emp[0]?>.jpg" width="132" >
      
      <br>
      <br>
      <br>
      <br>
      <br>
      <font size="+1"><b>ENCUESTAS<br><font color="red">OBLIGATORIAS</font><br>COVID-19</b></font>
      <br>
      <br>
      <input class="verloader" type="button" value=" 1ra vez " style=" text-decoration:underline; background-color: pink; height:10%; width:95%; background-image:url('file:///C:/Users/Lino%20A/Desktop/descarga.jpg'); background-position: 50% bottom; background-repeat:no-repeat;" 
		onClick="window.location = 'moduloRH/encuesta_cov/enc1.php'"  />
      <br>
      <br>
      <br>
      <input class="verloader" type="button" value=" Diaria " style=" text-decoration:underline; background-color: pink; height:10%; width:95%; background-image:url('file:///C:/Users/Lino%20A/Desktop/descarga.jpg'); background-position: 50% bottom; background-repeat:no-repeat;" 
		onClick="window.location = 'moduloRH/encuesta_cov/enc_dia.php'"  />
        <br>
        <br>
      <br>
      <input class="verloader" type="button" value=" Encuesta Vacuna " style=" text-decoration:underline; background-color: pink; height:10%; width:95%; background-image:url('file:///C:/Users/Lino%20A/Desktop/descarga.jpg'); background-position: 50% bottom; background-repeat:no-repeat;" 
		onClick="window.location = 'moduloRH/encuesta_vac/enc_vac.php'"  />
      </td>

      </tr>

    

    <tr>

      <td  colspan="2" align="center" valign="middle" bgcolor="#FE7203" style="width: 347px">
	  <input type="button" value="" style=" text-decoration:underline; background-color: #FE7203; 
       height:95%; width:95%; background-image:url(images/logoIBS.jpg); background-position: center; background-repeat:no-repeat;" 
       onClick="window.location = '/ibs'"  >

	  </td>

      </tr>

    

    <tr>

      <td colspan="4" align="center" valign="middle" bgcolor="white"><input type="button" value="INFORMES" style=" text-decoration:underline; background-color: #0E9548; height:95%; width:95%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 

OonClick="window.location = ''"  ></td>

      </tr>

    <tr>

      <td align="center" valign="middle" bgcolor="white" style="width: 18%" rowspan="1"> 
          <input type="button" value=" Descuentos " style=" text-decoration:blink; text-decoration:underline; background-color: #0E9548; height:95%; width:95%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 
           onClick="window.location = 'moduloI/pags/descuentos.php'"  >
      </td>
      


      <td align="center" valign="middle" bgcolor="white" style="width: 18%" colspan="2">
      <?php
      //SUAREZM
      $UsuarioActivado=$_SESSION["usuARio"];
      if($UsuarioActivado!='CASTILLOW' && $UsuarioActivado!='MONTNEGROJ' && $UsuarioActivado!='VILLAJ'){
      ?>
      <input class="verloader" type="button" value=" Ventas / Cuota " style=" text-decoration:underline; background-color: #0E9548; height:95%; width:95%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 

onClick="window.location = 'moduloI/pags/ventas_area.php'"  />
        <?
        }
        ?>
        </td>

      <td align="center" valign="middle" bgcolor="white" colspan="1" rowspan="2"><input type="button" value="Tableros" style=" text-decoration:underline; background-color: #0E9548; height:95%; width:95%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 

onClick="window.location = 'inicio_tableros.php'"  ></td>
<? //moduloI/pags/refplanoI.php ?>
      </tr>

    <tr>
      <td align="center" valign="middle" bgcolor="white" style="width: 18%" rowspan="1"> 
          <input class="verloader" type="button" value=" Fact. Pendientes " style=" text-decoration:blink; text-decoration:underline; background-color: #0E9548; height:95%; width:95%; background-image:url(descarga.jpg); background-position: bottom; background-repeat:no-repeat;" 
           onClick="window.location = 'modulo_conti/pags/cont_recibo.php'"  >
      </td>  
      <td align="center" valign="middle" bgcolor="white" style="width: 18%" colspan="2">
      <input class="verloader" type="button" value=" Inventarios " style=" text-decoration:underline; background-color: #0E9548; height:95%; width:95%; background-image:url('file:///C:/Users/Lino%20A/Desktop/descarga.jpg'); background-position: 50% bottom; background-repeat:no-repeat;" 
		onClick="window.location = 'moduloI/pags/inv.php'"  >
	  </td>

      </tr>

    </table>

  <p align="center">&nbsp;</p>

</div>

</div>

</body></html>

