<?php
/* http://192.168.1.115/moduloI/pdf/rin.php */
echo "Hola";
?>

<!-- <form name ='frm_tipo_imp' id ='frm_tipo_imp' class='frm_tipo_imp' action='rotulo.php?ov=$ov&cajas=$cajas&emp=$emp&tte=$tte&guia=$guia&peso=$peso' method='POST' style='font-size:80px;'> -->
<form name ='frm_tipo_imp' id ='frm_tipo_imp' class='frm_tipo_imp' action='#' method='POST' style='font-size:80px;'>
        <input id ='emp'   name='emp'                           value="AG" type='text'        style='background-color:white; color:gray;border:2px solid darkgray'><br>
        <input id ='ov'    name='ov'    placeholder = "Orden de venta"                        type='text' style='background-color:white; color:gray;border:2px solid darkgray'><br>
        <input id ='cajas' name='cajas' placeholder = "Cantidad de cajas"         type='text' style='background-color:white; color:gray;border:2px solid darkgray'><br>
        <input id ='tte'   name='tte'   placeholder = "Transportadora"            type='text' style='background-color:white; color:gray;border:2px solid darkgray'><br>
        <input id ='guia'  name='guia'  placeholder = "Guia"                      type='text' style='background-color:white; color:gray;border:2px solid darkgray'><br>
        <input id ='peso'  name='peso'  placeholder = "Peso"                      type='text' style='background-color:white; color:gray;border:2px solid darkgray'><br>
        <input id ='reset' name='reset' placeholder = ""                          type='button' value='reset'   style='background-color:white; color:gray;border:2px solid darkgray' onclick='clear_form();'><br>
        <input type="submit" value="Enviar"> 
        <br>
        <input id='tipo' name='tipo' type='button' value='tirilla' onclick='abrir_ventana(this.value);' style='$stilos'>
        <input id='tipo' name='tipo' type='button' value='grande'  onclick='abrir_ventana(this.value);' style='$stilos'>
</form>

<?php

$emp 	  = $_POST['emp'];
$ov		  = $_POST['ov'];
$cajas 	  = $_POST['cajas'];
$tte 	  = $_POST['tte'];
$guia 	  = $_POST['guia'];
$peso 	  = $_POST['peso'];
$tipo_ov  = $_POST['tipo'];


echo "


mire
$emp 	 
$ov		 
$cajas 	 
$tte 	 
$guia 	 
$peso 	 
$tipo_ov 
";





?>
