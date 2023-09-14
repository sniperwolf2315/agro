<?php
session_start();
setlocale(LC_MONETARY, 'es_CO');
setlocale(LC_ALL, "es_ES");
$hora_actual = date('Y-m-d H:i:s');
/** SECCION DE PERFILERIA TEMPORAL  :: ESTO ESTA FUNCIONANDO SOLO FALTA DESARROLLO DE INTEGRA USAER IBS->SIA.NET*/
include('./mod_ventas_area/perfileria_temporal.php');
include_once ("./funciones.php");
fun_conectarBD('sqlFacturas');
/*1= general ; 2= individual ; 3=grupal*/
/*
http://192.168.6.55/moduloI/pags/controller/insert_data_fac_det_factura.php
http://192.168.1.115/moduloI/pags/controller/insert_data_fac_det_factura.php

*/


// $nombre_usuario = (isset($_SESSION["usuARioS"]))? strtoupper($_SESSION["usuARioS"]):strtoupper($_SESSION["usuARioS"]);
$nombre_usuario = strtoupper($_SESSION["usuARioS"]);
 
// if(in_array($_SESSION["usuARioS"],$perfil_lista_vendedores)){ // lista de vendedores
if(in_array($nombre_usuario ,$perfil_lista_vendedores)){ // lista de vendedores
	echo 'Vendedor(a)';
	$nivel_usuario = 3;
	// $nombre_usuario ='VEND250';/* SOLO HABILITAR SI DESARROLLO NECESITA HACER PRB CON UN USUARIO */
	$lista_areas = mssql_query("select SECTORLAB from FACINFCUOTAVENTA where CODVENDEDOR ='". $nombre_usuario ."' and SECTORLAB not in ( 'TOTAL','Z-TOTAL','zTOTAL','zzTOTAL','zzzTOTAl')group by CODVENDEDOR,SECTORLAB  ");
	$where_add = "and codigo ='".strtoupper( $nombre_usuario  )."'";

}else if(in_array($nombre_usuario ,$perfil_lista_lideres)){
	
	echo 'Lider de area';
	$nivel_usuario = 2;
	
	if( strtoupper($_SESSION["usuARioS"])=='VANANDELL'){
		$area_codigo ='VENTA EXTERNA';
	}else if (strtoupper($nombre_usuario )=='ADMINISTRA' || strtoupper($nombre_usuario )=='PARDOD' || strtoupper($nombre_usuario )=='CIFUENTESE'  ){
		$area_codigo ='ALMACEN';
	}else if (strtoupper($nombre_usuario )=='CALLCENTER'  ){
		$area_codigo ='TELEOPERADOR';
	}
	$lista_areas = mssql_query("select distinct SECTORLAB from FACINFCUOTAVENTA where SECTORLAB not in ( 'TOTAL','Z-TOTAL','zTOTAL','zzTOTAL','zzzTOTAl') and SECTORLAB ='$area_codigo'");
	$where_add ="";

}else if(in_array($nombre_usuario ,$perfil_lista_admin)){
	echo 'Admin';
	$nivel_usuario = 1;
	$lista_areas = mssql_query("select distinct SECTORLAB from FACINFCUOTAVENTA where SECTORLAB not in ( 'TOTAL','Z-TOTAL','zTOTAL','zzTOTAL','zzzTOTAl')");
	$where_add ="";

	
}else{
		echo"<br><br><br><br><br><br><center>$nombre_usuario</center>";
	echo "<center> EL codigo $nombre_usuario no esta asociado ningun grupo </center>" ;
	echo '<a href="./lib_ibs/salir.php" >_</a> ';
	return;
}



?>


<!DOCTYPE html>
<html lang="es">
<head>
	<title>Informe Ventas Areas Nuevo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="generator" content="Antenna 3.0">
	<meta http-equiv="imagetoolbar" content="no">
	<meta name="AGROCAMPO" content="AGROCAMPO" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="theme-color" content="#FFFFF ">
	<script type="text/javascript" src="../../antenna/auto.js"></script>
	<script src="../../aajquery.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="./js/ejecutar_informe.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="mod_ventas_area/estilos_ventas_area.css" media="all" />
</head>
<div class="container">
	<?php
/*
	INVOCO LA CONEXION A IBS
*/
	include("lib_ibs/user_conect_ibs.php");
	include("../../general_funciones.php");
	include_once ("ws_services_soap.php");
	include_once ("../../nuevo_sia_v2/conection/conexion_sql.php");
	

//<!-- ===========================================================DECALRACION DE VARIABLE======================================================================== -->
	// query empresa dependiente:
	global $cumpl_general;
	$cumpl_general = 0;
	$ancho = '780px';
	$anio_actual = date("Y");
	$hoy = date("Y-m-d");
	$hoy_2sem = date("Y-m-d", strtotime("$hoy - 2 week"));
	$hoy_ibs = date("Ymd");
	$manana = date("Y-m-d", strtotime("$hoy + 1 day"));
	$mes_actual = date("m");
	$pag_ini = $_GET['pagina'];


	if ($_POST['desde'] == '') {
		$_POST['desde'] = $hoy_2sem;
	}
	if ($_POST['hasta'] == '') {
		$_POST['hasta'] = $hoy_2sem;
	}
	


	
	// $query_per  = mssql_query("select TOP (10) Codigo,Nombre,FechaIni,FechaFin FROM agrPeriodo ORDER BY FECHAINI DESC;");
	$query_per  = mssql_query('
	select  
		top (10)
		Codigo,
		Nombre,
		FechaIni,
		FechaFin,
		left(Codigo,4) anio,
		(case when len(month(convert(datetime,convert(varchar,FechaFin ),103)))= 1 then  CONCAT(' . '0' . ', convert(varchar(20),month(convert(datetime,convert(varchar,FechaFin ),103))))  else  convert(varchar(20),month(convert(datetime,convert(varchar,FechaFin ),103)))
		end ) mes
	FROM 
		sqlFacturas.dbo.agrPeriodo 
	ORDER BY 
		FECHAINI DESC;
	');

	/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX  LISTA DE AREAS  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
	/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
	/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

	$lista_area = $_POST['area'];

	switch ($lista_area) {
		case 'VENTA_EXTERNA':
			$lista_area ='VENTA EXTERNA';
			break;
	};

	if($_POST['area'] === 'selected' || $_POST['area'] ==='' || $_POST['area'] ==='Todos'){
		$vendedores = mssql_query("select codigo,Nombres,Apellidos as nombre from CLIVENDEDOR WHERE SECTORLAB IS NOT NULL AND Activo=1 ". $where_add." ;");
	}else if( $lista_area ==='VENTA EXTERNA' || $lista_area ==='TELEOPERADOR' ){
		$vendedores = mssql_query("
		select  
				codigo, 
				nombres +' '+Apellidos as nombre ,
				sectorlab 
				from 
				CLIVENDEDOR 
				where 
				Codigo  in  ( select  distinct (CODVENDEDOR) from [FACINFCUOTAVENTA] fcv2)
				and Activo =1
				and sectorlab = '$lista_area'
				".$where_add."
				order by 
				Codigo,SectorLab
				");
			}else if($lista_area ==='ALMACEN'){
		$vendedores = mssql_query("
			select  
				codigo, 
				nombres +' '+Apellidos as nombre ,
				sectorlab from CLIVENDEDOR 
			where 
				Codigo  in  ( select  distinct (CODVENDEDOR) from [FACINFCUOTAVENTA] fcv2)
			and Activo =1
			and sectorlab not in( 'TELEOPERADOR','VENTA EXTERNA')
			". $where_add."
			order by 
			Codigo,SectorLab
		");
	}

/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX  LISTA DE TODOS LOS VENDEDORES  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
	

	$Lista_reporte = array(
		'VENTAS'  => 'Ver Ventas / Cuotas',
		'CARTERA' => 'Ver Cartera / Vta por cliente',
		'PRODUCTO' => 'Ver Vta por Producto',
		'GRUPO'   => 'Ver Vta por Grupo',
		'EST10'   => 'Ver Ordenes estado 10'
	);
	$lista_informe = array(
		'Facturado' => 'Facturado',
		'Ord_Venta' => 'Ord_Venta',
		'Fac_Ord_Venta' => 'Fac_Ord_Venta'
	);
// <==============================================================================================================================>
// <==============================================================================================================================>
// <==============================================================================================================================>
// <==============================================================================================================================>
// <==============================================================================================================================>
	if ($_POST['empresa'] == '') {
		$_POST['empresa'] = $_SESSION['emp'];
	}
	if ($_SESSION['emp'] != $_POST['empresa']) {
		$_SESSION['emp'] = $_POST['empresa'];
		$_POST['empresa'] = $_SESSION['emp'];
		$_POST = array();
	}
	if ($_POST['area'] != $_POST['areaH']) {
		$_POST['cliente'] = '';
		$_POST['vendedor'] = '';
	}

	if (
		   $_SESSION["usuARioS"] == 'OYUELAL'
		or $_SESSION["usuARioS"] == 'BARONF'
		or $_SESSION["usuARioS"] == 'CASTILLOW'
		or $_SESSION["usuARioS"] == 'SIERRAJ'
		or SUBSTR($_POST['empresa'], 0, 2) != 'AG'
	) {
	
	} else {
		if (date("H") >= 9 and date("H") < 18) {
			//ECHO "<br><br>EL SERVICIO DE CONSULTAS SE HABILITARA DE NUEVO A LAS 6.00 PM, GRACIAS POR SU COMPRENSIÓN "; DIE;
		}
	}
	//ECHO "<br><br>EL SERVICIO DE CONSULTAS ESTA EN MANTENIMIENTO AGRADECEMOS SU COMPRESION "; DIE;
	if ($_SESSION["usuARioS"] == ''   ) {
	// if ($_SESSION["usuARioS"] == ''  ) {
		echo "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>";
		die;
	}
	$user= $_SESSION["usuARioS"];

?>
	<body bgcolor="white"  >
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<?php
		echo '
		<div class="">
		<h3>INFORME AGROCAMPO </h3>
		<table class="table table-responsive-sms">
		<tr>
		<th class="th_head" colspan="2"><span> </span></th>
		</tr>
		<tr>
		<td class="td_izq" id="td_izq" name ="td_izq">
		';

		if (empty($_POST['lsPeriodo']) && empty($_POST['area'])  && empty($_POST['info'])  && empty($_POST['vendedores'])     ) {
			// echo   "Primer Ingreso al formulario";
			echo   "1";
		}else{
			// echo   "1-1";
			// $sqlconect = new con_sql('sqlfacturas');
			$hora_ultimo_registro = mssql_fetch_array(mssql_query( "SELECT DESCRIPCION FROM API_CONFIGURACION  WHERE ID = 20 AND  CAMPO= 'HORA_CONSULTA_VENTAS_GEN'"));
			$hora_ultimo_registro = $hora_ultimo_registro[0];
			$min_diferencia = minutos_diferencia($hora_ultimo_registro,$hora_actual );
			
			/* TENER EN CUENTA QUE SOLO VA A REFRESCAR LA TABLA SI LA DIFERENCIA ENTRE LA ULTIMA CONSULTA ES DE > A la variable limit reload  que cambia dependiendo el perfil */
			$limit_reaload = 60;
			
			if($nivel_usuario==3){
				$limit_reaload = 10;
			}else if($nivel_usuario==2){
				$limit_reaload = 20;
			}else if($nivel_usuario==1){
				$limit_reaload = 30;
			}else{
				$limit_reaload = 60;
			}
			
			if($min_diferencia>=$limit_reaload){
				// echo"<br>Si debe actualizar, hay $min_diferencia minutos desde la ultima consulta <br>";
				mssql_query("UPDATE API_CONFIGURACION SET DESCRIPCION ='$hora_actual' WHERE id = 20 AND  CAMPO= 'HORA_CONSULTA_VENTAS_GEN' ");
				if($_POST['info']=='Facturado'){
					include('./controller/insert_data_fac_det_factura_prod.php');
				}else if($_POST['info']=='Ord_Venta'){
					include('./controller/insert_data_no_fac_mes.php');
				}else{
					include('./controller/insert_data_fac_det_factura_prod.php');
					include('./controller/insert_data_no_fac_mes.php');
				}
			}else{
				echo"<br><h6>  Han pasado $min_diferencia minutos desde la ultima consulta</h6> <br>";
			}

		}
		valida_campos();
		


		
		// <form id="formularioUno" name="formularioUno" method="POST" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" class="formularioUno" >
		echo '
		</td>
		<td class="td_der">
		
		<form id="formularioUno" name="formularioUno" method="POST" action="#" class="formularioUno" >
			<center>
			'.strtoupper($_SESSION["usuARioS"]).'
			</center>		
			<br>
			Empresa:
			<br>
			<select id="empresa" name="empresa" class="frm campo" tabindex="0" onclick="mostrarConsola(this.value)" required>
			<option value="AG-AGROCAMPO" selected>AGROCAMPO</option>
			</select>
			<br>
			';
		
		echo ' 
		Ver Reporte: 
		<br>
			<select id="queVer" name="queVer" class="frm campo" onchange="validar_rango(this.value);"  disabled>
				<option value="' . $_POST['queVer'] . '">' . $_POST['queVer'] . '</option>
		';
		foreach ($Lista_reporte as $k => $v) {
			if ($k == 'VENTAS') {
				echo '<option value="' . $k . '" selected >' . $v . '</option>';
			} else {
				echo '<option value="' . $k . '">' . $v . '</option>';
			}
		};

		$_POST['queVer'] = 'VENTAS';
		echo '</select>';

		
		
		?>
<!-- ███████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ -->
		Periodo:
		<?
		$periodo_completo = explode("*", $_POST['lsPeriodo']);
		$_POST['lsPeriodo'] = $periodo_completo[0];
		$per_nom =  $periodo_completo[1];

		?>
		<br>
		<select name="lsPeriodo" id="lsPeriodo" class="frm campo" onchange="validar_rango(this.value);"  required>
			<option value=<?= $_POST['lsPeriodo'] ?> selected><?=$_POST['lsPeriodo']?>✔</option>
			<option value="Por_Fechas">Por_Fechas</option>
			<?php

			$ls_empresa = $_POST['empresa'];
			$ls_periodo = $_POST['lsPeriodo'];
			while ($rowPeriodo = mssql_fetch_array($query_per)) {
				$Periodo 				= ($rowPeriodo['Codigo']);
				$Periodo_nom  			= ($rowPeriodo['Nombre']);
				$Periodo_FecIni 		= trim($rowPeriodo['FechaIni']);
				$Periodo_FecFin 		= trim($rowPeriodo['FechaFin']);
				$mes_a 					= trim($rowPeriodo['mes']);
				$anio_a 				= trim($rowPeriodo['anio']);
				
				if ($ls_periodo == '' || $ls_periodo == ' ' || $ls_perio == 'undefined' || strlen($ls_periodo) == 0) {
					if ($mes_a === $mes_actual && $anio_a === $anio_actual) {
						echo '<option value="' . $Periodo.'" selected >' . $Periodo_nom . '</option>';
					} else {
						echo '<option value="' . $Periodo.'"  >' . $Periodo_nom . '</option>';
					}
				} else {
					echo '<option value="' . $Periodo. '"  >' . $Periodo_nom . '</option>';
				}
			}
			
			?>
		</select>
		
		<?php


		if ($_POST['lsPeriodo'] == 'selected' || $_POST['lsPeriodo'] == 'Por_Fechas') {
			echo '
				<div id="ocultarPeriodo" name="ocultarPeriodo"  class="div_rangos">
					Desde:<br> <input id="desde" name="desde" class="frm campo Aabs" value="' . $_POST['desde'] . '" type="date"><br>
					Hasta:<br> <input id="hasta" name="hasta" class="frm campo Aabs" value="' . $_POST['hasta'] . '" type="date"><br>
				</div>
				';
		} else {
			echo '
				<div id="ocultarPeriodo" name="ocultarPeriodo" style="display: none" class="div_rangos">
					Desde:<br> <input id="desde" name="desde" class="frm campo Aabs" value="' . $_POST['desde'] . '" type="date"><br>
					Hasta:<br> <input id="hasta" name="hasta" class="frm campo Aabs" value="' . $_POST['hasta'] . '" type="date"><br>
				</div>
				';
		}




		?>
		Area:<br>
		<?
		if ($nivel_usuario === 3){
			echo '<select id="area" name="area" class="frm campo" onclick="consultar_vendedor(this.value ,'."'".$_SESSION['usuARioS']."','". strval($nivel_usuario)."'".') ; fechas_mdl(this.value);"  required>';
		}else{
			echo '<select id="area" name="area" class="frm campo" onchange="consultar_vendedor(this.value'.",'Todos','". strval($nivel_usuario) ."'".') ;  fechas_mdl(this.value);" " required>';
		}

		
		$val_area =  $_POST['area'];
		if ($nivel_usuario == 1 ) {
			
			if ($nivel_usuario == 1 ){
				if ($val_area == '' || $val_area == ' ' || $val_area == undefined || strlen($val_area) == 0 || $val_area == 'selected') {
					echo '<option value="Todos" selected>Todos</option>';
				} else {
					echo '<option value="'.$_POST['area'].'" selected>'.$_POST['area'].'✔</option>';
					echo '<option value="Todos" >Todos</option>';
				}
			}
		while ($ls_areas = mssql_fetch_array($lista_areas)) {
				echo ' <option value="' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '" >' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '</option> ';
			};
		}
		elseif ($nivel_usuario == 2 ) {
			while ($ls_areas = mssql_fetch_array($lista_areas)) {
				echo ' <option value="' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '" >' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '</option> ';
			};
		}
		elseif ($nivel_usuario == 3) {
			while ($ls_areas = mssql_fetch_array($lista_areas)) {
				echo ' <option value="' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '" selected>' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '</option> ';
			};
		}
		
		echo '
			</select>
			<br>
			';
					//TODO: OJO DESBLOQUEAR PARA UN FUTURO
		if($_SESSION['emp'] == 'AG-AGROCAMPO' || $_SESSION['emp'] == 'AG- AGROCAMPO'){
			// <select id="info" name="info" class="frm campo"  onclick="ejecutar_informe()" required>
			// <select id="info" name="info" class="frm campo" onclick="this.form.submit();" required>
			echo'
			Informe de: 
				<br>
				<select id="info" name="info" class="frm campo"   required>
				';
				if($_POST['info']==''){
					echo '<option value="Facturado">FACTURADO</option>';
				}else{
					echo '
					<option value="'.$_POST['info'].'">'.$_POST['info'].'✔</option>
					';
				}
				foreach($lista_informe as $k => $v ){
					echo'<option value="'.$k.'">'.strtoupper($v).'</option>';	
				}

				echo'
				</select>
				<br>
				';
		} // ENDIF LINE
		


			//TODO: OJO DESBLOQUEAR PARA UN FUTURO
			// echo'
			// Cliente:<br>   
			// <select  id="cliente" name="cliente" class="frm campo" onclick="mostrarConsola(this.value)" required>
			// 	<option value="'.$_POST['cliente'].'">'.$_POST['cliente'].'</option>
			// 	<option value="Todos" selected>Todos</option>
			// </select>
			// ';
	
			if (substr($_POST['empresa'], 0, 2) == 'ZZ') {
				fun_producto();
			} elseif (substr($_POST['empresa'], 0, 2) == 'AG' and ($_POST['queVer'] == 'PRODUCTO' or $_POST['queVer'] == 'GRUPO')) {
				fun_grupo();
			}


			$var_venr = $_POST['vendedores'];
			$nivel = $nivel_usuario;

			echo '
			Vendedor:<br>
			<select  id="vendedores" name="vendedores" class="frm campo" required>';
			// echo '
			// Vendedor:<br>

			// <input  list="ls_vendedores" id="vendedores" name="vendedores" class="frm campo" value="'.$var_venr.'" autocomplete="off" required > 
			// <datalist  id="ls_vendedores"    >';

			// $nivel = strval(php_function_ejecutar_service($_SESSION["usuARioS"]));
			if ( $nivel != 3 ) {
				if( $_POST['vendedores']==''){
					echo '<option></option>';
					echo '<option value="Todos" selected>Todos</option>';
				}else{
					echo '
					<option value="Todos">Todos</option>
					<option value="' . $_POST['vendedores'] . '" selected>' . $_POST['vendedores'] .'</option>';
				}
			} 
			else{
				echo '<option values="'.$nombre_usuario.'" >'.$nombre_usuario.' </option>';
			}
			while ($vend = mssql_fetch_array($vendedores)) {
				echo '<option  value="' . $vend[0] . '">✔' . $vend[0] .'  '. remove_characters($vend[1]) . ' ' . remove_characters($vend[2]) . '</option>';
			}
			// echo '</datalist><br>';
			echo '</select><br>';
		
			if (substr($_POST['empresa'], 0, 2) == 'X1') {
				if ($_POST['queVer'] == 'ESPECTROS') {
					$checked = "checked";
				} else {
					$checked = "";
				}
				echo "
			<input  $checked type='radio' id='queVer' name='queVer' value='ESPECTROS'> Ver Espectros
			";
			// <br>&nbsp;<br>
			} //END IF LINE 

			if($_POST['area']=='VENTA_EXTERNA' && $_POST['vendedores']<>'Todos' ){
				$valor_mdl_i=(isset($_POST['ini_mdl']))?$_POST['ini_mdl']:1;
				$valor_mdl_f=(isset($_POST['fin_mdl']))?$_POST['fin_mdl']:1;
			}

			echo "
			<label id=\"msj_mdl\"> Días Fechas MDL:</label><br>
			<input type='number' min=1 max=31 name='ini_mdl' id='ini_mdl' width="."1"." height="."1"." value='".$valor_mdl_i."' placeholder=\"Dia Ini MDL \"></input>	
			<br>
				<input type='number' min=1 max=31 name='fin_mdl' id='fin_mdl' value='".$valor_mdl_f."' placeholder=\"Dia Fin MDL \"></input>	
			";



			echo '
		<br>
		<div class="boton_form">
		   <!-- <input  id="Ver" name="botonref1" class="verloader  frm" value="Ver" type="submit"  onclick="cambioStatus();" onchange="cambioStatus();"  > -->
				<input  id="Ver" name="botonref1" class="frm" value="Ver" type="submit" onClick="carga();" >
				<input 	id="Imprimir" name="Imprimir" class="frm" value="Imprimir" type="button" onClick="javascript:window.print()" onchange= "verloader" />	
				
		</div>				
		<br>
		</form>	
		</td>
		</tr>
		</table>

				';
			
				?>
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX		 ESPACIO HTML FORM NUEVO	 	XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX SOLO CODIGO PHP XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->


<?php
			include("../../user_user.php");
			function fun_conectarBD($name_db) //CONEXION A LA BD SQL SERVER 2017
			{
				$server_name = '192.168.6.15';
				$user_name = 'sa';
				$user_pass = '%19Sis60Tem@s17';
				$cLink = mssql_connect($server_name, $user_name, $user_pass) or die(mssql_get_last_message());
				mssql_select_db($name_db, $cLink);
				if (!$cLink) {
					echo "sin conectar a l server";
				} 
			}
			// CREA EL CAMPO DE PRODUCTO
			function fun_producto()
			{
				echo '
						Producto: 
						<select  id="producto" name="producto"  >
								<option value="">Todos</option>
								<option>' . $_POST['producto'] . '</option>
								';
				global $tiPRO;
				foreach ($tiPRO as $titulo => $valor) {
					if ($_POST['producto'] != trim($titulo)) {
						echo "<option >$titulo</option>";
					}
				}
				echo '
							</select>
							';
			}
			// # CREA EL CAMPO DE FRUPO PARA FILTRO
			function fun_grupo()
			{
				echo '
						Grupo: <br>
						<select id="grupo" name="grupo" class="frm campo"  >
						<option value="">Todos</option>
						<option>' . $_POST['grupo'] . '</option>
						';
				global $grupos;
				foreach ($grupos as $titulo => $valor) {
					if ($_POST['grupo'] != trim($titulo)) {
						echo '<option >' . $titulo . '</option>';
					}
				}
			}

			
			function valida_campos(){
				$hoy_ibs_corto = date("Ym");

				$ls_area  	 = empty($ls_area)		? 'Todos'		: $ls_area ;
				$ls_area 	 = ($_POST['area'] == 'VENTA_EXTERNA') ? 'VENTA EXTERNA' : utf8_decode($_POST['area']);

				$ls_cliente  = utf8_decode($_POST['cliente']);
				
				$ls_Vendedor = utf8_decode($_POST["vendedores"]);
				$ls_Vendedor = empty($ls_Vendedor)	? 'Todos'		: $ls_Vendedor ;

				$ls_Informe  = utf8_decode($_POST['info']);

				$ls_Desde 	 = utf8_decode($_POST['desde']);
				$ls_Hasta 	 = utf8_decode($_POST['hasta']);
				$ls_Desde    = str_replace('-', '', $ls_Desde);
				$ls_Hasta  	 = str_replace('-', '', $ls_Hasta);
				
				$ls_periodo  = utf8_decode($_POST['lsPeriodo']);
				$ls_periodo  = !empty($ls_periodo)	? $ls_periodo:  $hoy_ibs_corto;
				
				/* SE LE ASIGNANA VALORES POR DEFECTO SI VIENE VACIO */	


				/* VALIDO QUE EL TIPO DE INFORME NO VEANGA VACIO (FACTURADO, ORD_VENTA, FAC_ORD_VENTA) */
				
				if(empty($ls_Informe) || $ls_Informe=='' ){
					$ls_Informe='Facturado';
				}else{
					$ls_Informe=$ls_Informe ;
				}
		
			/*
				echo "lOS CAMPOS VACIOS SON :<br>
				VENDEDOR: $ls_Vendedor<br> 
				INFORME	: $ls_Informe<br> 
				DESDE	: $ls_Desde  <br> 
				HASTA	: $ls_Hasta  <br> 
				PERIODO	: $ls_periodo <br>
				AREA	: $ls_area <br> 
				CLIENTE	: $ls_cliente<br> 
				";
					*/	


					
				// if($ls_cliente !== null ||$ls_Vendedor!== null ||$ls_Informe !== null ||$ls_Desde   !== null ||$ls_Hasta   !== null ){
				if($ls_Vendedor!== null ||$ls_Informe !== null ||$ls_Desde !== null ||$ls_Hasta   !== null || $ls_periodo !== null ){
					/* cuanto todos los campos son difernetes a null pasa a validar  */
					fun_validarPeriodo($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
				}else{
					echo "no cumple el campo vacio es:<br>
							VENDEDOR: $ls_Vendedor<br> 
							INFORME	: $ls_Informe<br> 
							DESDE	: $ls_Desde  <br> 
							HASTA	: $ls_Hasta  <br> 
							PERIODO	: $ls_periodo <br>
							AREA	: $ls_area <br> 
							CLIENTE	: $ls_cliente<br> 
					";
				}



					
			}
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
// ## VALIDA LA INFORMACION QUE VA EN LA COLUMNA DE LA DERACHA 
			function fun_validarPeriodo($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta){
				// echo  "Los parametros para fun_validar Periodo son: <br> $ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta";
		
				$_POST['queVer'] = 'VENTAS';
				$que_ver = $_POST['queVer'];

				 if ($ls_periodo !== 'Por_Fechas' &&  $que_ver== 'VENTAS') {
						// echo "IF ERIK 1";
						$ls_Desde = 'null';
						$ls_Hasta = 'null';
						// echo  "IF $ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta <br>";
						fun_ejecutar_sp_facinformes($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);

					} else if ($ls_periodo == 'Por_Fechas' && $que_ver == 'VENTAS') {
					// echo "ELSE IF ERIK 1";
						$ls_periodo = 'null';
						// echo  "ELSE IF $ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta";
						fun_ejecutar_sp_facinformes($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);

					}else if($ls_Vendedor === '' || $ls_Vendedor === ''){
						// echo "ELSE IF ERIK 2";
						echo 'Por favor seleccionar un area para cargar la lista de vendedores';
					}else {
						echo '<h5>no ha seleccionado nada valido...</h5><br>';
				}
			}
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
//  # FUNCION LA CUAL AGREGA COLOR A LOS CAMPOS QUE CUMPLEN LA REGLA
			function fun_color_porcen($valor_campo_1 = 0)
			{
				global $color;
				$color = '#FFFFF'; //BLANCO
				if (($valor_campo_1) >= 97) {
					$color = '#4A821D'; //verde
				} elseif (($valor_campo_1) >= 40 && ($valor_campo_1) <= 98) {
					$color = '#FFCC45'; //NARANJA
				} elseif (($valor_campo_1) >= 0  && ($valor_campo_1) <= 39) {
					$color = '#b80e0e'; //ROJO
				} else {
					$color = '#FFFFF'; //BLANCO
				}
				return $color;
			}
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
//### fUNCION QUE EJECUTA LOS SP PARA LA CONSULTA DEL INFORME
			function fun_ejecutar_sp_facinformes($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta){	
				$cord = 0;
				if ($str_valorPer === 'null'  || $str_valorPer == 'Por_Fechas') {
					if($cord!=0){
						echo  "IF";
					}

					echo '<div class="loader"></div> ';
					echo '<div class="verloader"></div> ';
					
					$str_valorPer = intval(substr($ls_Desde,0,6));

					if(($ls_Informe)=='Facturado'){
						if($cord!=0){
							echo "EL INFORME ES IF ELSE 1101 $informe ";
						}
						$sql_FACINFCUOTAVENTA = mssql_query("EXECUTE [dbo].[FACINFCUOVEN]  " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMELAB	  = mssql_query("EXECUTE [dbo].[FACINFORMELAB] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMECON    = mssql_query("EXECUTE [dbo].[FACINFORMECON] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));

					}else if(($ls_Informe)=='Ord_Venta'){
						if($cord!=0){
							echo "EL INFORME ES IF ELSE 1102 $informe ";
						}
						$sql_FACINFCUOTAVENTA = mssql_query("EXECUTE [dbo].[FACINFCUOVEN_NOFAC]  " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMELAB	  = mssql_query("EXECUTE [dbo].[FACINFORMELAB_NOFAC] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMECON    = mssql_query("EXECUTE [dbo].[FACINFORMECON_NOFAC] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						// $str_valorPer = intval(substr($ls_Desde,0,6));
					}else if($ls_Informe=='Fac_Ord_Venta'){
						if($cord!=0){
							echo "EL INFORME ES IF ELSE 1103  $informe ";
						}
						$sql_FACINFCUOTAVENTA = mssql_query("EXECUTE [dbo].[FACINFCUOVEN_NOFAC_FAC]  " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMELAB	  = mssql_query("EXECUTE [dbo].[FACINFORMELAB_NOFAC_FAC] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMECON    = mssql_query("EXECUTE [dbo].[FACINFORMECON_NOFAC_FAC] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
					}else{
						echo "Nada por ejecutar";
					}

					if ($ls_Vendedor !== 'Todos' &&  $ls_area !== 'TELEOPERADOR') {/*CAMBIO 31052022 #debe aparecen cuando area es diferente a call center y vendedor es unico */
						fun_resul_tbl_4($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
					}
					$str_valorPer = $ls_Desde;
			
				} else {/* CUANDO SE ELIJE POR PERIODO EJEMPLO AAAAMM */
					if($cord!=0){echo "ELSE";}
					echo '<div class="loader"></div>';
					echo '<div class="verloader"></div> ';
					if(($ls_Informe)=='Facturado'){
						if($cord!=0){echo 'IF 11';}
						$sql_FACINFCUOTAVENTA = mssql_query("EXECUTE [dbo].[FACINFCUOVEN] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMELAB	  = mssql_query("EXECUTE [dbo].[FACINFORMELAB]" . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMECON    = mssql_query("EXECUTE [dbo].[FACINFORMECON]" . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
					}else if(($ls_Informe)=='Ord_Venta'){
						if($cord!=0){echo 'ELSEIF 11 EN DESARROLLO ORD VENTA';}
						$sql_FACINFCUOTAVENTA = mssql_query("EXECUTE [dbo].[FACINFCUOVEN_NOFAC] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMELAB	  = mssql_query("EXECUTE [dbo].[FACINFORMELAB_NOFAC]" . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
						$sql_FACINFORMECON    = mssql_query("EXECUTE [dbo].[FACINFORMECON_NOFAC]" . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
					}else if($ls_Informe=="Fac_Ord_Venta"){
						if($cord!=0){echo 'ELSE 11 EN DESARROLLO ORD VENTA FA $str_valorPer ';}

						$str_valorPer = intval($str_valorPer);

						$sql_FACINFCUOTAVENTA = "EXECUTE [FACINFCUOVEN_NOFAC_FAC] $str_valorPer";
						mssql_query($sql_FACINFCUOTAVENTA);
						$sql_FACINFORMELAB = "EXECUTE [FACINFORMELAB_NOFAC_FAC] $str_valorPer";
						mssql_query($sql_FACINFORMELAB);
						
						$sql_FACINFORMECON  = "EXECUTE [FACINFORMECON_NOFAC_FAC] $str_valorPer";
						mssql_query($sql_FACINFORMECON );

					}else{
						echo"No hay nada por ejecutar";
						echo "<br>Es mejor reenviar<br>";
						
						
					}
					// if ($ls_Vendedor !== 'Todos' &&  $ls_area === 'TELEOPERADOR') {/*CAMBIO 31052022 #debe aparecen cuando area es diferente a call center y vendedor es unico */
					if ($ls_Vendedor !== 'Todos' &&  ($ls_area == 'VENTA_EXTERNA' || $ls_area == 'VENTA EXTERNA'  )) {/*CAMBIO 31052022 #debe aparecen cuando area es diferente a call center y vendedor es unico */
						fun_resul_tbl_4($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
					}
				
				}

				fun_resul_tbl_1($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe);
				fun_resul_tbl_2($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe);

				if ($ls_area == 'ALMACEN'|| ($ls_area == 'VENTA_EXTERNA' || $ls_area == 'VENTA EXTERNA'  )) {
					if(strlen($str_valorPer)>=8){ 
						$str_valorPer = intval(substr($str_valorPer,0,6));
					}else{ 
						$str_valorPer=$str_valorPer;
					}
					fun_resul_tbl_3($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe);
				}

			}
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
// <------------------------------------------------------------------------------------------------------------------------------>
			function fun_consulta_query($tabla, $str_valorPer, $var_area)
			{
				//VALORE SIN AREA
				$ver_cord    = 1;
				$ls_Vendedor = utf8_decode($_POST['vendedores']);
				$ls_Informe  = utf8_decode($_POST['info']);
				$ls_cliente  = utf8_decode($_POST['cliente']);
				$ls_Informe  = utf8_decode($_POST['info']);

				/* VARIABLES */
				$consulta_tabla ="";
				/*
				Facturado
				Ord_Venta
				Fac_Ord_Venta
				*/

				if($ls_Informe =="Facturado"){
					$consulta_tabla ="";
				}else if($ls_Informe =="Ord_Venta"){
					$consulta_tabla ="_NOFAC";
				}else if($ls_Informe =="Fac_Ord_Venta"){
					$consulta_tabla ="_NOFAC_FAC";
				}else{
				$consulta_tabla ="";
				}



				if ($_POST['area'] == 'VENTA_EXTERNA') {
					$ls_area = 'VENTA EXTERNA';
				} else {
					$ls_area = utf8_decode($_POST['area']);
				}

				
				if ($str_valorPer != "Todos" && $ls_area == "Todos"  &&  $ls_Vendedor == "Todos") {
					if ($tabla == 1) {
						if ($ver_cord == 0) {
							echo 'sector 1 tbl 1 ';
						} else {
							// echo '<br>';
							echo "";
						}
						$rta_query = mssql_query("
						select 
							* 
						from 
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA$consulta_tabla 
						where 
							PERIODO='" . $str_valorPer . "'
						order by
							SECTORlab,
							AREA,
							CODVENDEDOR 
						");
					} elseif ($tabla == 2) {
						if ($ver_cord == 0) {
							echo 'sector 1 tbl 2 ';
						} else {
							// echo '<br>';
							echo "";
						}
						$rta_query = mssql_query("
					select  
						Laboratorio,
						SUM(cuota)CUOTA,
						SUM(venta)VENTA,
						SUM(Cumplimiento) CUMPLIMIENTO,
						SectorLab,
						area
					from 
						sqlfacturas.dbo.facInfLaboratorio$consulta_tabla  
					where 
						IdPeriodo='" . $str_valorPer . "' 
						and sectorlab is null 
					GROUP BY 
						Laboratorio
						,area,SectorLab
						order by 
						area; 
						");
					} elseif ($tabla == 3) {
						if ($ver_cord == 0) {
							echo 'sector 1 tbl 3 ';
						} else {
							// echo '<br>';
							echo '';
						}
						$rta_query = mssql_query("
						select 
							* 
						from 
							sqlfacturas.dbo.VIS_facInfConcentrado_2$consulta_tabla
						where  
							IdPeriodo ='" . $str_valorPer . "' 
						AND sectorlab <> ' '
						AND NOT (AREA = 'ZZTOTAL' AND SECTORLAB <> 'TOTAL') 
						order by 
							area,Vendedor desc; 
						");
					} else {
						$rta_query = mssql_query("No hay nada");
					};
				} elseif ($str_valorPer != "Todos" &&  $ls_area == "Todos" &&  $ls_Vendedor != "Todos") {
					if ($tabla == 1) {
						if ($ver_cord == 0) {
							echo 'sector 2 tbl 1 ';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
						select 
							* 
						from 
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA$consulta_tabla
						where 
							PERIODO='" . $str_valorPer . "' 
							and CODVENDEDOR ='" . $ls_Vendedor . "' 
						order by 
							area ");
					} elseif ($tabla == 2) {
						if ($ver_cord == 0) {
							echo 'sector 2 tbl 2';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
					select 
						Laboratorio,
						SUM(cuota) CUOTA,
						SUM(venta)VENTA,
						SUM(Cumplimiento) CUMPLIMIENTO,
						sectorlab,
						Area,
						Vendedor
					from 
						sqlfacturas.dbo.facInfLaboratorio$consulta_tabla 
					where 
						IdPeriodo='" . $str_valorPer . "' 
						and Vendedor ='" . $ls_Vendedor . "'  
					GROUP BY 
						Laboratorio 
						,SectorLab,
						Vendedor,
						Area
					order by 
					(case 
						when area ='AGIL' then  1
						when area ='ESTRELLA' then  2
						when area ='BASICOS' then  3
						when area ='SUPLEMENTARIOS' then  5
						when area ='TOTAL LABORATORIOS' then  5
						else 6
						end)  
			");
					} elseif ($tabla == 3) {
						if ($ver_cord == 0) {
							echo 'sector 2 tabla 3';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
			select 
				* 
			from 
				sqlfacturas.dbo.VIS_facInfConcentrado_2$consulta_tabla
			where  
				IdPeriodo='" . $str_valorPer . "' 
				and Vendedor='" . $ls_Vendedor . "' 
			order by 
				SectorLab,Vendedor,NombreVendedor
			");
					} else {
						$rta_query = 'nada';
					};
			} else if ($str_valorPer != "Todos" && $ls_area != "Todos" &&  $ls_Vendedor == "Todos") {
					if ($tabla == 1) {
						if ($ver_cord == 0) {
							echo 'sector 3 tabla 1';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
						select 
							* 
						from   
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA$consulta_tabla 
						where 
							PERIODO='" . $str_valorPer . "' 
							AND SECTORLAB='" . $ls_area . "' 
						order by 
							area,
							(case when vendedor not like'%TOTAL%'  then 1 else 2 end )
						");
			} else if ($tabla == 2) {
						if ($ver_cord == 0) {
							echo 'sector 3 tabla 2';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
			select
				Laboratorio,
				SUM(cuota) CUOTA,
				SUM(venta)VENTA,
				SUM(Cumplimiento) CUMPLIMIENTO,  
				SectorLab,
				area
			from 
				sqlfacturas.dbo.facInfLaboratorio$consulta_tabla  
			where 
				IdPeriodo='" . $str_valorPer . "'  
				and SectorLab ='" . $ls_area . "'  
				and Vendedor is null
				and Venta is not null
			GROUP BY 
				Laboratorio
				,SectorLab
				,Vendedor
				,area
			order by 
			(case 
			when area ='AGIL' 				then  1
			when area ='ESTRELLA' 			then  2
			when area ='BASICOS' 			then  3
			when area ='SUPLEMENTARIOS' 	then  4
			when area ='TOTAL LABORATORIOS' then  5
			else 6
			end)
			");
					} elseif ($tabla == 3) {
						if ($ver_cord == 0) {
							echo 'sector 3 tabla 3';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
				select 
				* 
				from  
					sqlfacturas.dbo.VIS_facInfConcentrado_2$consulta_tabla  
				where 
					IdPeriodo ='" . $str_valorPer . "' 
					and SectorLab ='" . $ls_area . "' 
					order by 
					Area,Vendedor asc 
					");

					} else {
						$rta_query = mssql_query("select 'sin consulta valida ' as valor");
					}
				} elseif ($str_valorPer != "Todos" && $ls_area != "Todos" && $ls_Vendedor != "Todos") {
					if ($tabla == 1) {
						if ($ver_cord == 0) {
							echo 'sector 4 tbl 1';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
						select 
							* 
						from   
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA$consulta_tabla 
						where 
						PERIODO='" . $str_valorPer . "' 
							and sectorlab='" . $ls_area . "' 
							and CODVENDEDOR ='" . $ls_Vendedor . "'  
							and AREA <>''
						order by
						(case 
						when area ='AGIL' then  1
						when area ='ESTRELLA' then  2
						when area ='BASICOS' then  3
						when area ='SUPLEMENTARIOS' then  4
						when area ='TOTAL LABORATORIOS' then  5
						else 6
						end),vendedor 
						");
					} elseif ($tabla == 2) {
						if ($ver_cord == 0) {
							echo 'sector 4 tbl 2';
						} else {
							// echo '<br>';
							echo '';
						}
						
						$rta_query = mssql_query("
					select  
						Laboratorio,
						SUM(cuota) CUOTA,
						SUM(venta)VENTA,
						SUM(Cumplimiento) CUMPLIMIENTO
						,SectorLab 
						,area
						,Vendedor
					from 
						sqlfacturas.dbo.facInfLaboratorio$consulta_tabla  
					where 
						IdPeriodo='". $str_valorPer."'  
						and SectorLab ='".$ls_area."' 
						and Vendedor ='".$ls_Vendedor."'  
					GROUP BY 
						Laboratorio
						,SectorLab
						,Vendedor
						,area
					order by 
					(case 
					when area ='AGIL' then  1
					when area ='ESTRELLA' then  2
					when area ='BASICOS' then  3
					when area ='SUPLEMENTARIOS' then  4
					when area ='TOTAL LABORATORIOS' then  5
					else 6
					end),Laboratorio,vendedor
					");
					} elseif ($tabla == 3) {
						if ($ver_cord == 0) {
							echo 'sector 4 tbl 3';
						} else {
							// echo '<br>';
							echo '';
						}

						$rta_query = mssql_query("
					select 
						* 
					from  
						sqlfacturas.dbo.VIS_facInfConcentrado_2$consulta_tabla  
					where 
						IdPeriodo ='" . $str_valorPer . "' 
						and SectorLab ='" . $ls_area . "' 
						and Vendedor='" . $ls_Vendedor . "' 
					order by 
						NombreVendedor
					");
					}
				} else {
					$rta_query = mssql_query("nada");
				}
				return $rta_query;
			}
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>

// #  FUNCION PARA CALCULAR LOS TOTALES DE LA TABLA 1
			function fun_calcular_totales($array_data = array(), $rep, $fondo)
			{
				$color = '';
				foreach ($array_data as $key => $value) {
					global $sum_ven, $sum_cuo, $sum_cum, $rta_cum, $concepto,$colum;
					$concepto = $value['concepto'];
					if ($concepto != 'TOTAL') {
						$sum_ven = $sum_ven + $value['ven'];
						$sum_cuo = $sum_cuo + $value['cuo'];
						$sum_cum = $sum_cum + $value['cum'];
					}
				};
				/* # CAPTURAR EL VALOR PARA DEVOLVER UN COLOR*/
				
				$color = fun_color_porcen($sum_cum);

				if ($rep == 0) {
					return '
							<td class="tdata" ></td>
							<td class="tdata"  colspan="3"></td>
							<td name="tdata" id="tdata" class="tdata"  colspan="5"></td>
							';
					
				} else {

					return '
							<td class="tdata" ></td>
							<td class="tdata" colspan="1"></td>
							<td name="tdata" id="tdata" class="tdata" colspan="1"></td>
							';

	};
			};
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>
// # crea loS GRUPOS DE LA CABECERA DE LA TABLA
	function fun_grupos_cabecera($row_data, $color, $ancho, $grupo, $row_data1, $row_data2, $row_data3, $fondo)
	{

		
		if ($row_data == 'zzzTOTAL' and $grupo ==='GENERAL') {
			echo '
				<td id="tdata"   name ="tdata" class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data1), 2, ",", ".") . '</td><!--Venta-->
				<td id="tdata"   name ="tdata" class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data2), 2, ",", ".") . '</td><!--Cuota-->
				<td id="rta_cum" name="rta_cum" class="tdata" style="border:' . strval($color) . ' 3px solid ; background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . round(number_format(intval($row_data3), 2),1) . '%</td><!--Cumpli-->
				';
		} 
		else {
			echo '
			<td id="tdata"   name ="tdata" class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data1), 2, ",", ".") . '</td><!--Venta-->
				<td id="tdata"   name ="tdata" class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data2), 2, ",", ".") . '</td><!--Cuota-->
				<td id="tdata"   name ="tdata" class="tdata" style="border:' . strval($color) . ' 3px solid ; background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . round(number_format(intval($row_data3), 2),1) . '%</td><!--Cumpli-->
				';
		}
	};
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>

	function fun_etiqueta_tabla($campo, $cols = 3)
			{
				echo '
					<th headers="' . $campo . '" id="cuota"  colspan="' . $cols . '">Cuota</th>
					<th headers="' . $campo . '" id="venta"  colspan="' . $cols . '">Venta</th>
					<th headers="' . $campo . '" id="cumpli" colspan="' . $cols . '">%Cump</th>
					';
			};
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>
	function suma($valor){
				$suma_rta = 0;
				$suma_rta = $suma_rta + $valor;
				return $suma_rta;
			};

// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>

			// # TABLA PRINCIPAL 
	function fun_resul_tbl_1($valor_Per, $var_area, $ls_cliente, $ls_Vendedor, $ls_Informe)			{
		$hora_actual_informe = date('Y-m-d H:i:s');
				if($ls_Informe =='Facturado'){
					$infore_tbl_consulta = "";
				}else if($ls_Informe =='Ord_Venta'){
					$infore_tbl_consulta = "_NOFAC";
				}else if($ls_Informe =='Fac_Ord_Venta'){
					$infore_tbl_consulta = "_NOFAC_FAC";
				}else{
					$infore_tbl_consulta = "";
				}

				echo '<div class="verloader"></div> ';
				$cumpl_general = 0;
				$ancho = 3;
				$arr_resul_general[]      = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_importados[]   = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_laboratorios[] = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_objetivo[]     = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_cont[]         = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$fondo = 'white';
				if ($var_area == 'TELEOPERADOR') {
					$sql_cab = mssql_query("
		select 
			distinct (TIPOCUOTA),
			(
			case 
			when TIPOCUOTA ='GENERAL' 	   then 1 
			when TIPOCUOTA ='CONTADO' 	   then 2 
			when TIPOCUOTA ='OBJETIVO'     then 3
			when TIPOCUOTA ='IMPORTADOS'   then 4 
			when TIPOCUOTA ='LABORATORIOS' then 5 
			else 0 
			end
			) Position 
		from 
			sqlfacturas.dbo.FACINFCUOTAVENTA$infore_tbl_consulta
		order 
			by Position
		");
			} else {
					$sql_cab = mssql_query("
			select 
				distinct TIPOCUOTA 
			from 
				sqlfacturas.dbo.FACINFCUOTAVENTA$infore_tbl_consulta 
			where 
				TIPOCUOTA not in( 'OBJETIVO','CONTADO') ");
				}

				$sql_tbl1 = fun_consulta_query(1, $valor_Per, $var_area, $ls_cliente, $ls_Vendedor, $ls_Informe);

			
				echo '
	<h6> Hora consulta:  '.$hora_actual_informe .'</h6>
	<table  class="tbl_faclab_1  table table-bordered table-responsive-sms" name="tbl_faclab" border ="2">
	
	<tr>
		<th colspan="4">
		<label name="status_hour" id="status_hour" class="status_hour"></label>
		<br>
			INFORME DE VENTAS 
		</th>
	</tr>
	<tr>
		<br>
	</tr>
	<tr >
		<td id="tdata_cab" name="tdata_cab" class="tdata_cab">Periodo : ' . $valor_Per . '</td>
		<td id="tdata_cab" name="tdata_cab" class="tdata_cab">Reporte : ' . $_POST['queVer'] . '</td>
		<td id="tdata_cab" name="tdata_cab" class="tdata_cab">Informe de Ventas vs Cuota : ' . $_POST['info'] . '</td>
		<td id="tdata_cab" name="tdata_cab" class="tdata_cab"><label for="tot_cumpl">Cumplimiento Cta. General:</label><input type="text" name="tot_cumpl" id="tot_cumpl" value="" class="tot_cumpl" style=" width: 71px;border: 0px solid transparent;" disabled> </td>
	</tr>
	</table>
		<br>
';
	$alto = $ls_Vendedor !=='Todos'? '40%':'450px';
echo '
	<div  class="div_tbl_1" style=" overflow-y: auto;height: '.$alto.';  " >
	<table  class="tbl_faclab" name="tbl_faclab" border ="2">
		<colgroup >
			<col span="1" style="background-color: white">
			<col span="1" style="background-color: white">
			<col span="1" style="background-color: white">
			<col span="3"><col span="3"><col span="3">
			<col span="3"><col span="3"><col span="3">
			<col span="3"><col span="3"><col span="3">
		</colgroup>
	<tr>
	<th id ="area_th">Area</th>
	<th colspan="2" id="vendedor">Vendedor</th>
	<th id ="cod_vend">Cod_vend</th>
	';

				// # WHILE PARA LA CABECERA DE LA TABLA DINAMICA
				while ($col_name =  mssql_fetch_array($sql_cab)) {
					echo '<th colspan="' . ($ancho * 3) . '" id="' . trim($col_name[0]) . '">' . trim($col_name[0]) . '</th>';
				};
				echo '
	</tr>
	<tr>
		<th headers="area" colspan="4" ></th>
	';
				$dimension = 2;
				if ($var_area == 'TELEOPERADOR') {
					$dimension = 4;
				} else {
					$dimension = 2;
				}

				for ($i = 0; $i <= $dimension; $i++) {
					$head = '';
					if ($i == 0) {
						$head = 'GENERAL';
					} elseif ($i == 1) {
						$head = 'IMPORTADOS';
					} elseif ($i == 2) {
						$head = 'LABORATORIOS';
					} elseif ($i == 3) {
						$head = 'OBJETIVO';
					} elseif ($i == 4) {
						$head = 'CONTADO';
					} else {
						$head = 'SIN DATA';
					}

					fun_etiqueta_tabla($head, 3);
				};
				echo '
	</tr>
	';
				/* #  WHILE PARA LLAMADO DE LA DATA */
		while ($row_data = mssql_fetch_array($sql_tbl1)) {

					$color_marca   = fun_color_porcen($row_data[5]);
					$color_marca_1 = fun_color_porcen($row_data[8]);
					$color_marca_2 = fun_color_porcen($row_data[11]);
					$color_marca_3 = fun_color_porcen($row_data[14]);
					$color_marca_4 = fun_color_porcen($row_data[17]);
					// ## COLOR COLUMNAS 
					if ($row_data[2] === 'TOTAL' || $row_data[2] === 'zTOTAL' || $row_data[2] === 'zzTOTAL' || $row_data[2] === 'zzzTOTAL') {
						$fondo = ' lightgray';
					} else {
						$fondo = 'white';
					};
					$area =str_replace('z','',str_replace('zzzTOTAL','TOTAL',str_replace('zzTOTAL','TOTAL',str_replace('zTOTAL','TOTAL',$row_data[0] ))));
					$nombre =str_replace('zzzTOTAL','TOTAL',str_replace('zzTOTAL','TOTAL',str_replace('zTOTAL','TOTAL',$row_data[1] )));
					$vendedor =str_replace('zSUBTOTAL' ,'TOTAL',str_replace('zzSUBTOTAL','TOTAL', str_replace('zzzTOTAL','TOTAL',str_replace('zzTOTAL','TOTAL',str_replace('zTOTAL','SUBTOTAL',$row_data[2] )))));

			echo '
		<tr>
			<td class="tdata" headers="area"    			 style="background-color:' . $fondo . ';">' . $area . '</td>
			<td class="tdata" headers="vendedor" colspan="2" style="background-color:' . $fondo . ';">' . $nombre . '</td>
			<td class="tdata" headers="cod_vend"			 style="background-color:' . $fondo . ';">' . $vendedor . '</td>
		';
		/*
					CAMBIO 28062022 "REVISIÖN SECCION CUMPLIMIENTO SE DEBE VISUALIZAR EN BASE A GRUPO E INDIVIUALMENTE"
		 */		
	    if ($var_area ==='Todos' && $ls_Vendedor==='Todos') {
			$row_data[0] = ($row_data[0]==('zzz'.$row_data[0]   && $row_data[2]=='zzzTOTAL' )) ? 'zzzTOTAL'  :  $row_data[0]    ;
		}else if($var_area ==='ALMACEN' && $ls_Vendedor==='Todos') {
			$row_data[0] = ($row_data[0]==('zz'.$row_data[0] && $row_data[2]=='zzTOTAL' )) ? 'zzzTOTAL'  :  $row_data[0]    ;
		}else if($var_area ==='TELEOPERADOR' && $ls_Vendedor==='Todos') {
			$row_data[0] = ($row_data[2]==='zTOTAL' ) ? 'zzzTOTAL'  :  $row_data[0]    ;
		}else if(( $var_area ==='VENTA EXTERNA'  ) && $ls_Vendedor ==='Todos') {
			$row_data[0] = ($row_data[2]==='zTOTAL' ) ? 'zzzTOTAL'  :  $row_data[0]    ;
		}else if ($var_area !=='Todos' && $ls_Vendedor!=='Todos' ){
			$row_data[0] ='zzzTOTAL';
		}

		fun_grupos_cabecera($row_data[0], $color_marca, $ancho, 'GENERAL',  round($row_data[3], 0), round($row_data[4], 2), round($row_data[5], 0), $fondo);
		array_push($arr_resul_general, array('concepto' => $row_data[0], 'ven' => round($row_data[3], 0), 'cuo' => $row_data[4], 'cum' => $row_data[5], 'color' => $fondo ));

		/* se almacena el cumplimiento general pa almacen */
		if($row_data[0]=='zzzTOTAL' && $row_data[2]=='zzTOTAL'){
			$cum_gen = round($row_data[5],1);
			echo '<input id="cump_gen_alm" name="cump_gen_alm" type="hidden" value="'.$cum_gen.'%" >';
		}


		if ($var_area == 'TELEOPERADOR') {
			
			fun_grupos_cabecera($row_data[0], $color_marca_4, $ancho, 'CONTADO', $row_data[15], $row_data[16], $row_data[17], $fondo);
			array_push($arr_resul_cont, array('concepto' => $row_data[0], 'ven' => $row_data[15], 'cuo' => $row_data[16], 'cum' => $row_data[17], 'color' => $fondo));
			
			
			fun_grupos_cabecera($row_data[0], $color_marca_3, $ancho, 'OBJETIVO', $row_data[12], $row_data[13], $row_data[14], $fondo);
			array_push($arr_resul_objetivo, array('concepto' => $row_data[0], 'ven' => $row_data[12], 'cuo' => $row_data[13], 'cum' => $row_data[14], 'color' => $fondo));
			
		}

			fun_grupos_cabecera($row_data[0], $color_marca_1, $ancho, 'IMPORTADOS', $row_data[6], $row_data[7], $row_data[8], $fondo);
			array_push($arr_resul_importados, array('concepto' => $row_data[0], 'ven' => $row_data[6], 'cuo' => $row_data[7], 'cum' => $row_data[8], 'color' => $fondo));

			fun_grupos_cabecera($row_data[0], $color_marca_2, $ancho, 'LABORATORIOS', $row_data[9], $row_data[10], $row_data[11], $fondo);
			array_push($arr_resul_laboratorios, array('concepto' => $row_data[0], 'ven' => $row_data[9], 'cuo' => $row_data[10], 'cum' => $row_data[11], 'color' => $fondo));
			echo '
		</tr>
	';
				};



	if ($var_area == 'TELEOPERADOR') {
		echo '
		<tfooter>
		<tr>
		<td axis="categoria" colspan="4" id="subtotal"></td>
		' . fun_calcular_totales($arr_resul_general, 0, $fondo) . '
		' . fun_calcular_totales($arr_resul_importados, 0, $fondo) . '
		' . fun_calcular_totales($arr_resul_laboratorios, 0, $fondo) . '
		' . fun_calcular_totales($arr_resul_objetivo, 0, $fondo) . '
		' . fun_calcular_totales($arr_resul_cont, 0, $fondo) . '
		</tr>
		</tfooter>
		</table>
		';
	} else {

		echo '
		<tfooter>
		<tr>
		<td axis="categoria" colspan="4" id="subtotal"></td>
		' . fun_calcular_totales($arr_resul_general, 0, $fondo) . '
		' . fun_calcular_totales($arr_resul_importados, 0, $fondo) . '
		' . fun_calcular_totales($arr_resul_laboratorios, 0, $fondo) . '
		</tr>
		</tfooter>
		</table>
		</div>
		';
				}

			}
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>
// ESTA ES LA FUNCION QUE LLAMA Y CREA LA TABLA 2
function fun_resul_tbl_2($valor_Per, $almacen, $ls_cliente, $ls_Vendedor, $ls_Informe){

	if($ls_Informe =="Facturado"){
		$consulta_tabla ="";
	}else if($ls_Informe =="Ord_Venta"){
		$consulta_tabla ="_NOFAC";
	}else if($ls_Informe =="Fac_Ord_Venta"){
		$consulta_tabla ="_NOFAC_FAC";
	}else{
	$consulta_tabla ="";
	}


				$color_fondo = 'white';
				$sql_tbl2 = fun_consulta_query(2, $valor_Per, $almacen, $ls_cliente, $ls_Vendedor, $ls_Informe);
				$arr_resul_general_tbl2[] = array('ven' => 0, 'cuo' => 0, 'cum' => 0);
				$sql_cab  = mssql_query("select distinct area from sqlfacturas.dbo.facInfLaboratorio$consulta_tabla order by area");
				echo '
	<div class="table_2">
	<table class="frxs tbl2" border ="2" >
	<th colspan="5">
	<label name="status_hour" id="status_hour" class="status_hour"></label><br>
	<label> VENTAS LABORATORIOS</label>
	</th>
		<tr>
			<th>Area</th>
			<th>Laboratorio</th>
			<th>Cuota</th>
			<th>Venta</th>
			<th colspan="2"> % </th>
		</tr>
	<tbody>
	';
				while ($dataSr = mssql_fetch_array($sql_tbl2)) {
					$color = fun_color_porcen($dataSr[3]);
					if ($dataSr[0] == 'TOTAL') {
						$color_fondo = 'lightgray';
					} else {
						$color_fondo = 'white';
					}

					$dataSr[0]=(strlen($dataSr[0])==10 && $dataSr[0]=='LINEA AGIL' )?'LINEA AGIL MED':$dataSr[0];
					
					echo '
		<tr>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . $dataSr[5] . '</td>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . $dataSr[0] . '</td>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . number_format(intval($dataSr[1]), 2, ",", ".") . '</td>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . number_format(intval($dataSr[2]), 2, ",", ".") . '</td>
			<td class="tdata" style="border:' . strval($color) . ' 3px solid ;" background-color:' . $color_fondo . '; >' .round($dataSr[3],1). '%</td>
			</tr>';
			// <td class="tdata" style="border:' . strval($color) . ' 3px solid ;" background-color:' . $color_fondo . '; >' .round( number_format(intval($dataSr[3]), 2, ",", "."),1) . '%</td>
				};
				echo '
	</tbody>
	</table>
	</div>
	';
			}
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>
// <============================================================================================================================>
// # GENERA EL CONTENIDO DE LA TABLA 3 VENTAS EN KILOS Y UNIDADES LINEAS PROPIAS
			function fun_resul_tbl_3($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe)
			{
				if($ls_Informe =="Facturado"){
					$consulta_tabla ="";
				}else if($ls_Informe =="Ord_Venta"){
					$consulta_tabla ="_NOFAC";
				}else if($ls_Informe =="Fac_Ord_Venta"){
					$consulta_tabla ="_NOFAC_FAC";
				}else{
				$consulta_tabla ="";
				}


				$sql_data = fun_consulta_query(3, $ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe);
				$conta = 0;
				$valor_null = 0;
				$tol_porcen_cab = 0;
				$ancho = 3;
				$Area = $valor_null;
				$IdPeriodo = $valor_null;
				$Cuota = $valor_null;
				$Cumplimiento = $valor_null;
				$Vendedor = $valor_null;
				$NombreVendedor = $valor_null;
				$SectorLab = $valor_null;
				$fondo = 'white';

				$EVANGERS = 0;
				$PROPAC = 0;
				$SOMEX = 0;
				$A_FACTOR = 0;
				$ODOURLOOK = 0;
				$QUALIVET = 0;
				$F_CHOICE = 0;
				$sql_cabcera = mssql_query(" select distinct Laboratorio from sqlfacturas.dbo.FACINFCONCENTRADO$consulta_tabla ");
				
				
				// <div  class="div_tbl_1" style=" overflow-y: auto;height: '.$alto.';  " >
				$alto = $ls_Vendedor !=='Todos'? '40%':'450px';
				echo '
	<div id="tbl_3" style=" overflow-y: auto;height: '.$alto.';  ">
		<table border="1" class="tbl_3" style="width:100%;">
		<thead>
		<tr>
			<label name="status_hour" id="status_hour" class="status_hour"></label><br>
			<th width="100" colspan="24" class="lineas_prop"> VENTA EN LINEAS DELTA</th>
		</tr>
		<tr> 
			<th class="td_tbl_3" id="area_t3">AREA</th>
			<th class="td_tbl_3" id="vendedor_t3" colspan="2">VENDEDOR</th>
		';
				while ($col = mssql_fetch_array($sql_cabcera)) {
					echo '<th id="' . $col[0] . '_tbl_1" class="td_tbl_3" colspan="3" >' . $col[0] . '</th>';
				};

				echo '
		</tr>
		<tr>
		<td colspan ="3"></td>
		';
				for ($i = 0; $i <= 6; $i++) {
					fun_etiqueta_tabla('', 1);
				};
				echo '
	</tr>
	</thead>
	<tbody>
	';
				while ($rows  = mssql_fetch_array($sql_data)) {
					$conta++;
					if ($rows['Area'] === 'ZZTOTAL' || $rows['Vendedor'] === 'TOTAL') {
						$rows['Area'] = 'TOTAL';
						$fondo = 'lightgray';
					} else {
						$rows['Area'] = $rows['Area'];
						$fondo = 'white';
					}

			echo '
			<tr style="background-color="red"; ">
				<td class="tdata" style="background-color:' . $fondo . ';" headers="area_t3" >' . $rows['Area'] . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';" headers="vendedor_t3" colspan="2">' . $rows[2] . ' - ' . $rows['NombreVendedor'] . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[5], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[6], 2, ",", ".")  . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[7]))) . '  3px solid; background-color:' . $fondo . ';">' . number_format($rows[7], 2, ",", ".") .  '%</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[8], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[9], 2, ",", ".")  . '</td><td class="tdata" style=" border:' .  strval(fun_color_porcen(suma($rows[10]))) . ' 3px solid; background-color:' . $fondo . ';">' . number_format($rows[10], 2, ",", ".") .  '%</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[11], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[12], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[13]))) . ' 3px solid; background-color:' . $fondo . ';">' . number_format($rows[13], 2, ",", ".") . '%</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[14], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[15], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[16]))) . ' 3px solid; background-color:' . $fondo . ';">' . number_format($rows[16], 2, ",", ".") . '%</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[17], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[18], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[19]))) . ' 3px solid; background-color:' . $fondo . ';">' . number_format($rows[19], 2, ",", ".") . '%</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[20], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[21], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[22]))) . ' 3px solid; background-color:' . $fondo . ';">' . number_format($rows[22], 2, ",", ".") . '%</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[23], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[24], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[25]))) . ' 3px solid; background-color:' . $fondo . ';">' . number_format($rows[25], 2, ",", ".") . '%</td>
			</tr>
				';
			};
			echo '
			</tbody>
			</table>
			</div>
			';
			};

			function fun_resul_tbl_4($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_desde, $ls_hasta)
			{
					
				if($ls_Informe == 'Facturado'){
					$nivel_usuario = 1;
				}
				elseif($ls_Informe == 'Ord_Venta'){
					$nivel_usuario = 2;
				}
				elseif($ls_Informe == 'Fac_Ord_Venta'){
					$nivel_usuario = 3;
				}

				
				//  ### EJECUTAR CONSULTA DE DATOS DESDE IBS
				$campo_conta_ibs = conectar_ibs_consulta_vendedor($ls_Vendedor);
				// echo "el nuevo campo es ".count(explode(';',$campo_conta_ibs)).'<br>';


				$fondo = 'white';
				if ($ls_periodo == 'null' || $ls_periodo == null) {
					$sql_totales_clientes = mssql_query("EXECUTE FACINFCLIENTES '" . strval($campo_conta_ibs) . "','" . $ls_Vendedor . "',null,'" . intval($ls_desde) . "','" . intval($ls_hasta) . "',".intval($nivel_usuario));
					// echo "1 EXECUTE FACINFCLIENTES '" . strval($campo_conta_ibs) . "','" . $ls_Vendedor . "',null,'" . intval($ls_desde) . "','" . intval($ls_hasta) . "',".intval($nivel_usuario);
				} else {
					$sql_totales_clientes = mssql_query("EXECUTE FACINFCLIENTES '" . strval($campo_conta_ibs) . "','" . $ls_Vendedor . "'," . intval($ls_periodo). ",null,null,". intval( $nivel_usuario) ) ;
					// echo "2 EXECUTE FACINFCLIENTES '" . strval($campo_conta_ibs) . "','" . $ls_Vendedor . "'," . intval($ls_periodo). ",null,null,". intval( $nivel_usuario);
				}
				echo '
		<div class="table_3" name="div_tbl_4" id="div_tbl_4" #div_tbl_4   >
			<table class="frxs tbl2" border ="2" >
				<th>
				<tr>
					<td>VENDEDOR</td>
					<td>CLIENTES</td>
					<td>CLIENTES_VENTAS</td>
					<td>CUMPLIMIENTO</td>
				</tr>
				</th>
				<tr>		
				';

				$mdl_ini = $_POST['ini_mdl'];
				$mdl_fin = $_POST['fin_mdl'];
				/** */
				$_periodo= substr($ls_periodo,0,10);
				$ventas_2_d = mssql_query("
				SELECT 
					vendedor,
					SUM(ValorSinIVA),
					((select VENTA from FACINFCUOTAVENTA where CODVENDEDOR ='$ls_Vendedor' and TIPOCUOTA='GENERAL' and PERIODO=$_periodo) - SUM(ValorSinIVA) )vta_mdl,
						(round( 
							100
							*
							SUM(ValorSinIVA) 
							/
							((select VENTA from FACINFCUOTAVENTA where CODVENDEDOR ='$ls_Vendedor' and TIPOCUOTA='GENERAL' and PERIODO=$_periodo)  )
						,2)
					)  as porcen
				FROM 
					FACDETALLEFACTURANEW 
				WHERE  
					Vendedor in('$ls_Vendedor')
					and DAY(FechaOrden) in($mdl_ini,$mdl_fin)
					and FORMAT(FechaOrden,'yyyyMMdd') BETWEEN (select FechaIni from agrPeriodo where Codigo=$_periodo) 
					AND (select FechaFin from agrPeriodo where Codigo=$_periodo)
				GROUP BY 
					vendedor
				");
				
				while($valor = mssql_fetch_array($ventas_2_d)){
						$valor_vta 		 = $valor[1];
						$valor_total_mdl = $valor[2];
						$porcen_mdl 	 = $valor[3];
				}
				/** */

				while ($tbl_4 = mssql_fetch_array($sql_totales_clientes)) {
					echo
					'<td>' . $tbl_4['VENDEDOR'] .'</td>
					 <td>' . $tbl_4['CLIENTES_TOTALES'] . '</td>
					 <td>' . $tbl_4['CLIENTES_VENTAS'] . '</td>
					 <td class="tdata" style=" border:' . strval(fun_color_porcen($tbl_4['CUMPLIMIENTO'])) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($tbl_4['CUMPLIMIENTO'], 2, ",", ".") . '</td>
					 ';
				}
				echo '	
					</tr>

				</table>



				<table class="frxs tbl2" border ="2">
					<tr>
						<td>INI MDL				</td>
						<td>FIN MDL				</td>
						<td>VENDEDOR			</td>
						<td>$ VENTAS MDL		</td>
						<td>$ TOTAL VENTAS FUERA DE MDL	</td>
						<td>% VENTAS MDL		</td>
						</tr>
						<tr>
						<td>'.$_POST['ini_mdl'].'</td>
						<td>'.$_POST['fin_mdl'].'</td>
						<td>'.$ls_Vendedor.'</td>
						<td> $'.number_format(intval($valor_vta), 2, ",", ".") .'</td>
						<td> $'.number_format(intval($valor_total_mdl), 2, ",", ".") .'</td>
						<td style="border:' . strval(fun_color_porcen($porcen_mdl)) . ' 2px solid; background-color:' . $fondo . ';">'. number_format($porcen_mdl, 2, ",", ".") .'%</td>
					</tr>

				</table>
			</div>	
			
			
			
			';
			}
			
			?>

<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX SOLO CODIGO JAVASCRIPT XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
			<script type="text/javascript">
				// CARGA LA PANTALLA DE LOADING
				var init 		= 0;
				var conta 		= isNaN(parseInt(window.name)) ? 1 : parseInt(window.name);;
				var periodo 	= document.getElementById("lsPeriodo");
				var fecha 		= document.getElementById("ocultarPeriodo");
				var vendedor 	= document.getElementById("vendedores");
				var div_tbl_4 	= document.getElementById("div_tbl_4");
				var tot_cumpl	= document.getElementById("tot_cumpl");
				// var cum_gen_alm	= document.getElementById("cump_gen_alm");
				var rta_cum ;

				

				if (existe_elemento(document.getElementById("cump_gen_alm")) ){
					cum_gen_alm = document.getElementById("cump_gen_alm");
				}else{
					cum_gen_alm = document.createElement("cump_gen_alm");
				}
				
				
				if (existe_elemento(document.getElementById("rta_cum")) ){
					 rta_cum = document.getElementById("rta_cum");
				}else{
					// console.log('no existe el %');
					 rta_cum = document.createElement("rta_cum");
				}

				conta = 0;
				
				// fechas_mdl(informe)
				// # captutar el valor de inicio de la pantalla
				if (rta_cum.textContent == undefined || rta_cum.textContent == null) {
					rta_cum.value = 0.0;
					tot_cumpl.value = rta_cum.value;

				} else {
					tot_cumpl.value = (rta_cum.textContent=='0%')?cum_gen_alm.value: rta_cum.textContent;
				}

				alerta_update();
					

				function existe_elemento(elem_dom) {
					return (elem_dom === document.body) ? 'No existe' : document.body.contains(elem_dom);
       			}

				function carga(){

				var sel_area, sel_ven;
				// sel_per 	= document.getElementById('lsPeriodo').value;
				sel_area 	= document.getElementById('area').value;
				// sel_informe = document.getElementById('info').value;
				sel_ven 	= document.getElementById('vendedores').value;
				
				// console.log(`ERIK MIRE ${sel_per} ${sel_area} ${sel_informe} ${sel_ven}`);

				if 	(sel_area!=='' && sel_ven!=='') {
					$(".loader").show();
					$(".verloader").show();
					}
					fechas_mdl(sel_area)

				document.getElementById("Ver").addEventListener("click", function( event ) {
					// reenvio_form();
				});	
					
				}


				window.onload = function() {
					a_sel_per 		= document.getElementById('lsPeriodo').value;
					a_sel_area 		= document.getElementById('area').value;
					a_sel_informe 	= document.getElementById('info').value;
					a_sel_ven 		= document.getElementById('vendedores').value;

					// console.log(`${a_sel_per} 		${a_sel_area} 		${a_sel_informe}  ${a_sel_ven} 	`);

					$(".loader").show();
					$(".verloader").show();
					// carga();
					
					if (rta_cum.value == undefined || rta_cum.value == null) {
						rta_cum.value = 0;
					} 

					/* # no mostrar la tabla si su valor es != Totos */
					if (vendedor.value == 'Todos' || vendedor.value == undefined || vendedor.value == null) {
						var existe_dom = existe_elemento(document.getElementById("Pqr"));
							if (existe_dom) {
								setTimeout(div_tbl_4.style.display = "none",5000)
							}
					} 

					if (periodo == "Por_Fechas" || periodo == '' || periodo == ' ' || periodo == 'selected' || periodo == undefined) {
						fecha.style.display = "block";
					}
					if (window.name = 14) {
						this.conta = 0;
					} else {
						validar_rango("");
					}


					

					
				}



				$(document).ready(function() {
					$(".verloader").click(function() {
						$(".loader").show();
					});
					$(".verloaderB").change(function() {
						$(".loader").show();
					});
					$("select").select2;
					
				});
				
				$(window).load(function() {
					$(".loader").fadeOut("slow");
					$(".verloader").fadeOut("slow");
					carga();
				});

				function alerta_update(){
/*

<label name="status_hour" id="status_hour" class="status_hour"></label>*/
					valor_stado = document.getElementById("status_hour");

					const today = new Date();
					const hours = today.getHours();
					const min = today.getMinutes();
						if( (hours == 7 || hours == 11 || hours == 15 || hours == 19 || hours == 23) && ( min<=30)  ){
							swal('Recuerde que esta consultando en una franja de actualización, y sus datos podran variar');
							valor_stado.innerHTML = "Recuerde que esta consultando en una franja de actualización, y sus datos podran variar";
						}
				}

				/* TODO REVISAR ESTA FUNCION  */
				function cambioStatus() {
					this.conta++;
					window.name = this.conta;
					console.log(window.name);
					$(".loader").show();
					window.location.href = window.location.href + "?p1=" + this.init;
				}


				function mostrarConsola(valor) {
					console.log(valor);
				}

				function sin_ingreso(msj){
					swal(msj);
				}
				// # MOSTRAR EMERGENTE CON LA INFORMACION 
				function mostrarPopUp() {
					swal("PARAMETROS A EJECUTAR:<? echo "Empresa_" . $ls_empresa . " Periodo_" . $ls_periodo . " Area_ " . $ls_area . " Cliente_" . $ls_cliente . " Vendedor_" . $ls_ventas . " Informe_" . $ls_informe . " Menu_" . $chk_menu ?>");
				}

				// # CONTAR LOS CLICKS PARA VALIDACIONES DE CAMPOS
				function conteo() {
					document.getElementById("Ver2").addEventListener("click", function(event) {
						event.target.innerHTML = "Conteo de Clicks: " + event.detail;
						console.log("EVENTO" + event.returnValue);
					}, false);
				}



				// # VALIDA LA OPCION DE PERIODO PARA OCULATAR O MOSTRAR LOS CAMPOS DE LAS FECHAS
				function validar_rango(valor) {
					var periodo = document.getElementById("lsPeriodo");
					var fecha = document.getElementById("ocultarPeriodo");
					var check = document.getElementById("queVer");

					if (valor == 'CARTERA' || valor == 'PRODUCTO' || valor == 'GRUPO' || valor == 'EST10') {
						fecha.style.display = "none";
						periodo.style.display = "none";
						valor = "Por_Fechas";
						periodo.value = "Por_Fechas";
						$("#lsPeriodo").val("Por_Fechas");
					} else if (valor == 'VENTAS') {
						fecha.style.display = "block";
					} else {
						fecha.style.display = "block";
					}

					if (valor == "Por_Fechas" || periodo == "Por_Fechas") {
						fecha.style.display = "block";
						// $("#queVer").attr('disabled','disabled');
						// $("#queVer").attr('checked', false);
					} else if (periodo == "Por_Fechas" || periodo == '' || periodo == ' ' || periodo == 'selected') {
						fecha.style.display = "block";
					} else {
						fecha.style.display = "none";
						// $("#queVer").removeAttr('disabled');
					}

				}


				// # OCULTA EL RANGO POR INDEPENDIENTE 
				function ocultarRango() {
					var x = document.getElementById("queVer");
					if (x.style.display === "none") {
						x.style.display = "block";

					} else {
						x.style.display = "none";
					}
				}

				// CONSUTLAR PARAMETROS MARTES DE LOCURA
				function fechas_mdl(informe){
					// console.log(`${informe}`);
					lbl_msj_mdl = document.getElementById("msj_mdl");
					ini_mdl = document.getElementById("ini_mdl");
					fin_mdl = document.getElementById("fin_mdl");


					if(informe=='ALMACEN'){
						ini_mdl.style.display	 = "none";
						fin_mdl.style.display	 = "none";
						lbl_msj_mdl.style.display= "none";
						
					}else if(informe=='VENTA_EXTERNA'){
						ini_mdl.style.display	 = "block";
						fin_mdl.style.display	 = "block";
						lbl_msj_mdl.style.display= "block";
						
					}else{
						ini_mdl.style.display	 = "none";
						fin_mdl.style.display	 = "none";
						lbl_msj_mdl.style.display= "none";
					}

				}


/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX  LISTA DE TODOS LOS VENDEDORES  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

		
		
		
		function consultar_vendedor(area,vendedores,nivel) {
			// console.log (area+''+vendedores+''+nivel);
			if (window.XMLHttpRequest) {
				peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
				peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'sql_server_consultas.php?area=' + area+'&vendedores='+ vendedores +'&nivel='+ nivel, true);
            peticion_http.send(null);

            function muestraContenido() {
                //popup_swal(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('vendedores').innerHTML = dato;
                    }
                }
            }
	}

	function imprim1(imp1){
		var printContents = document.getElementById(imp1).innerHTML;
        w = window.open();
        w.document.write(printContents);
        w.document.close(); 
        w.focus(); 
		w.print();
		w.close();
        return true;
	}


function reenvio_form(){
		formulario = document.getElementById('formularioUno');
		formulario.submit();
	}

/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX  LISTA DE TODOS LOS VENDEDORES  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
</script>
</div>
<?php
if (empty($_POST['lsPeriodo']) && empty($_POST['area'])  && empty($_POST['info'])  && empty($_POST['vendedores'])     ) {
	echo"
	<script>
		formulario = document.getElementById('formularioUno');
		formulario.submit();
	</script>";
}
mssql_close();
echo '<a href="./lib_ibs/salir.php" >_</a> ';
?>
	</body>
	<footer>
			<label><a href="/nuevo_sia_v2/index.php">salir</a></label>
	</footer>
</html>