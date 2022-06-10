<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Informe Ventas Areas</title>
	<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
	<meta name="generator" content="Antenna 3.0">
	<meta http-equiv="imagetoolbar" content="no">
	<script type="text/javascript" src="../../antenna/auto.js"></script>
	<script src="../../aajquery.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="mod_ventas_area/estilos_ventas_area.css" media="all" />
	<!-- <link rel="stylesheet" href="../../aajquery.css" > -->
</head>
<BR>
<BR>
<div class="container">


	<?php
	/*
			INVOCO LA CONEXION A IBS
*/
	include("lib_ibs/user_conect_ibs.php");

	// phpinfo();
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
	@session_start();
	setlocale(LC_MONETARY, 'es_CO');
	setlocale(LC_ALL, "es_ES");
	// session_destroy();
	// echo $_SERVER["REMOTE_ADDR"];s
	fun_conectarBD('sqlFacturas');

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
	$vendedores = mssql_query("select codigo,Nombres,Apellidos as nombre from CLIVENDEDOR WHERE SECTORLAB IS NOT NULL AND Activo=1;");
	$lista_areas = mssql_query("select distinct SECTORLAB from FACINFCUOTAVENTA where SECTORLAB not in ( 'TOTAL','Z-TOTAL','zTOTAL','zzTOTAL','zzzTOTAl')");
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
		$_SESSION["usuARio"] == 'OYUELAL'
		or $_SESSION["usuARio"] == 'BARONF'
		or $_SESSION["usuARio"] == 'CASTILLOW'
		or $_SESSION["usuARio"] == 'SIERRAJ'
		or SUBSTR($_POST['empresa'], 0, 2) != 'AG'
	) {
	} else {
		if (date("H") >= 9 and date("H") < 18) {
			//ECHO "<br><br>EL SERVICIO DE CONSULTAS SE HABILITARA DE NUEVO A LAS 6.00 PM, GRACIAS POR SU COMPRENSIÓN "; DIE;
		}
	}
	//ECHO "<br><br>EL SERVICIO DE CONSULTAS ESTA EN MANTENIMIENTO AGRADECEMOS SU COMPRESION "; DIE;
	if ($_SESSION["clAVe"] == '') {
		echo "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>";
		die;
	}
	?>

	<body bgcolor="white"  >
		<!-- <body class="global" bgcolor="white" <? //=$autoprint
													?> -->
		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<?php
		echo '
		<h6>
		' . $_SESSION["usuARio"] . '<br>
		</h6>
		';
		
		echo '
		<div class="">
		<table class="table table-responsive-sms">
		<tr>
		<th class="th_head" colspan="2">INFORME AGROCAMPO </th>
		</tr>
		<tr>
		<td class="td_izq">
		';

		valida_campos();
		// fun_validarPeriodo();
		echo '
		</td>
		<td class="td_der">';

		echo '<form id="formularioUno" name="formularioUno" method="POST" action="ventas_cuota_new.php" class="formularioUno" >';
		echo '
		<br>
			Empresa:
		<br>
			<select id="empresa" name="empresa" class="frm campo" tabindex="2" onclick="mostrarConsola(this.value)" required>
				<option value="AG-AGROCAMPO" selected>AGROCAMPO</option>
			</select>
		<br>
		';
		?>

		<?php
		echo ' 
		Ver Reporte: 
		<br>
			<select id="queVer" name="queVer" class="frm campo" onchange="validar_rango(this.value);" onclick="mostrarConsola(this.value)" disabled>
				<option value="' . $_POST['queVer'] . '">' . $_POST['queVer'] . '</option>
		';
		// <input class="radios" type="radio" id="queVer" name="queVer" value="'.$k.'" onclick="mostrarConsola(this.value)">'.$v.'<br>';
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
		Periodo:
		<br>
		<select name="lsPeriodo" id="lsPeriodo" class="frm campo" onchange="validar_rango(this.value);" onclick="mostrarConsola(this.value)" required>
			<option value=<?= $_POST['lsPeriodo'] ?> selected><?= $_POST['lsPeriodo'] ?></option>
			<option value="Por_Fechas">Por_Fechas</option>
			<?php

			$ls_empresa = $_POST['empresa'];
			$ls_periodo = $_POST['lsPeriodo'];
			$Periodo = "";
			while ($rowPeriodo = mssql_fetch_array($query_per)) {
				$Periodo 		  = ($rowPeriodo['Codigo']);
				$Periodo_nom  	  = ($rowPeriodo['Nombre']);
				$Periodo_FecIni  	  = trim($rowPeriodo['FechaIni']);
				$Periodo_FecFin  	  = trim($rowPeriodo['FechaFin']);
				$mes_a = trim($rowPeriodo['mes']);
				$anio_a = trim($rowPeriodo['anio']);

				if ($ls_periodo == '' || $ls_periodo == ' ' || $ls_perio == 'undefined' || strlen($ls_periodo) == 0) {
					if ($mes_a === $mes_actual && $anio_a === $anio_actual) {
						echo '<option value="' . $Periodo . '" selected >' . $Periodo_nom . '</option>';
					} else {
						echo '<option value="' . $Periodo . '"  >' . $Periodo_nom . '</option>';
					}
				} else {
					echo '<option value="' . $Periodo . '"  >' . $Periodo_nom . '</option>';
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
		<select id="area" name="area" class="frm campo" onclick="mostrarConsola(this.value)" required>
			<option value=<?= $_POST['area'] ?> selected><?= $_POST['area'] ?></option>

			<?php
			$val_area =  $_POST['area'];
			if ($val_area == '' || $val_area == ' ' || $val_area == undefined || strlen($val_area) == 0 || $val_area == 'selected') {
				echo '<option value="Todos" selected>Todos</option>';
			} else {
				echo '<option value="Todos" >Todos</option>';
			}
			while ($ls_areas = mssql_fetch_array($lista_areas)) {
				echo ' <option value="' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '" >' . str_replace(" ", "_", $ls_areas['SECTORLAB']) . '</option> ';
			};

			echo '
			</select>
			<br>
			
			';
			//TODO: OJO DESBLOQUEAR PARA UN FUTURO
			// echo'
			// Cliente:<br>   
			// <select  id="cliente" name="cliente" class="frm campo" onclick="mostrarConsola(this.value)" required>
			// 	<option value="'.$_POST['cliente'].'">'.$_POST['cliente'].'</option>
			// 	<option value="Todos" selected>Todos</option>
			// </select>
			// ';

			?>


			<?php
			if (substr($_POST['empresa'], 0, 2) == 'ZZ') {
				fun_producto();
			} elseif (substr($_POST['empresa'], 0, 2) == 'AG' and ($_POST['queVer'] == 'PRODUCTO' or $_POST['queVer'] == 'GRUPO')) {
				fun_grupo();
			}


			$var_venr = $_POST['vendedores'];

			echo '
			Vendedor:<br>
			<select  id="vendedores" name="vendedores" class="frm campo" onclick="mostrarConsola(this.value)" required>
			<option value="' . $_POST['vendedores'] . '" selected>' . $_POST['vendedores'] . '</option>
			';
			if ($var_venr == '' || $var_venr == ' ' || $var_venr == undefined || strlen($var_venr) == 0) {
				echo '<option value="Todos" selected>Todos</option>';
			} else {
				echo '<option value="Todos" >Todos</option>';
			}

			while ($vend = mssql_fetch_array($vendedores)) {
				echo '<option  value="' . $vend[0] . '">' . $vend[0] . ' ' . $vend[1] . ' ' . $vend[2] . '</option>';
			}
			echo '
		</select>
		<br>
		';
			//TODO: OJO DESBLOQUEAR PARA UN FUTURO
			// 	if($_SESSION['emp'] == 'AG-AGROCAMPO'){ 
			// 		echo'
			// 		Informe de: 
			// 			<br>
			// 			<select id="info" name="info" class="frm campo" onclick="mostrarConsola(this.value)" required>
			// 			<option value="'.$_POST['info'].'">'.$_POST['info'].'</option>
			// 			';
			// 			foreach($lista_informe as $k => $v ){
			// 				echo'<option value="'.$k.'">'.$v.'</option>';	
			// 			}
			// 			echo'
			// 			</select>
			// 			<br>
			// 	';
			// } // ENDIF LINE
			if (substr($_POST['empresa'], 0, 2) == 'X1') {
				if ($_POST['queVer'] == 'ESPECTROS') {
					$checked = "checked";
				} else {
					$checked = "";
				}
				echo "
			<input  $checked type='radio' id='queVer' name='queVer' value='ESPECTROS'> Ver Espectros
			<br>&nbsp;<br>
			";
			} //END IF LINE 

			echo '
		<br>
		<div class="boton_form">
						<!-- <input  id="Ver" name="botonref1" class="verloader  frm" value="Ver" type="submit"  onclick="cambioStatus();" onchange="cambioStatus();"  > -->
				<input  id="Ver" name="botonref1" class="frm" value="Ver" type="submit" onclick="cambioStatus()";>
				<input 	id="Imprimir" name="Imprimir" class="frm" value="Imprimir" type="button" onClick="javascript:window.print()" onchange= "verloader" />	
		</div>				
						</form>	
						</td>
						</tr>
						</table>
						';
			?>

			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX		 ESPACIO HTML FORM NUEVO	 	XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX SOLO CODIGO PHP XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->


			<?php
			include("../../user_user.php");
			// include("../../user_con.php");
			// include("ventas_area_".substr($_POST['empresa'],0,2).".php"); 
			// include("ventas_area_".substr($_POST['empresa'],0,2)."_des.php"); 

			//CONEXION A LA BD SQL SERVER 2017
			function fun_conectarBD($name_db)
			{
				$server_name = '192.168.6.15';
				$user_name = 'sa';
				$user_pass = '%19Sis60Tem@s17';
				$cLink = mssql_connect($server_name, $user_name, $user_pass) or die(mssql_get_last_message());
				mssql_select_db($name_db, $cLink);
				if (!$cLink) {
					echo "sin conectar a l server";
				} else {
					// echo 'Conectado';
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
			function valida_campos()
			{

				$ls_periodo  = utf8_decode($_POST['lsPeriodo']);
				if ($_POST['area'] == 'VENTA_EXTERNA') {
					$ls_area = 'VENTA EXTERNA';
				} else {
					$ls_area = utf8_decode($_POST['area']);
				}
				$ls_cliente  = utf8_decode($_POST['cliente']);
				$ls_Vendedor = utf8_decode($_POST["vendedores"]);
				$ls_Informe  = utf8_decode($_POST['info']);
				$ls_Desde 	 = utf8_decode($_POST['desde']);
				$ls_Hasta 	 = utf8_decode($_POST['hasta']);
				$ls_Desde    = str_replace('-', '', $ls_Desde);
				$ls_Hasta  	 = str_replace('-', '', $ls_Hasta);
				fun_validarPeriodo($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
			}


			// <------------------------------------------------------------------------------------------------------------------------------>
			// <------------------------------------------------------------------------------------------------------------------------------>
			// <------------------------------------------------------------------------------------------------------------------------------>
			// ## VALIDA LA INFORMACION QUE VA EN LA COLUMNA DE LA DERACHA 
			function fun_validarPeriodo($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta)
			{
				$_POST['queVer'] = 'VENTAS';
				if (($ls_periodo == "Por_Fechas" || $ls_periodo != "Por_Fechas") && ($_POST['queVer'] == 'CARTERA' or $_POST['queVer'] == 'PRODUCTO' or $_POST['queVer'] == 'GRUPO' or $_POST['queVer'] == 'EST10')) {
				} elseif ($ls_periodo != 'Por_Fechas' &&  $_POST['queVer'] == 'VENTAS') {
					$ls_Desde = 'null';
					$ls_Hasta = 'null';
					fun_ejecutar_sp_facinformes($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
				} elseif ($ls_periodo == 'Por_Fechas' && $_POST['queVer'] == 'VENTAS') {
					$ls_periodo = 'null';
					fun_ejecutar_sp_facinformes($ls_periodo, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
				} elseif ($_POST['queVer'] == 'dev' && ($ls_periodo != " " || $ls_periodo != "" || $ls_periodo != "Por_Fechas")) {
				} else {
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
				if (($valor_campo_1) >= 99) {
					$color = '#4A821D'; //verde
				} elseif (($valor_campo_1) >= 40 && ($valor_campo_1) <= 98) {
					$color = '#ad530a'; //NARANJA
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
			function fun_ejecutar_sp_facinformes($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta)
			{


				if ($str_valorPer === 'null') {
					echo '<div class="loader"></div> ';
					$sql_FACINFCUOTAVENTA = mssql_query("EXECUTE [FACINFCUOVEN] " . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
					$sql_FACINFORMELAB	 = mssql_query("EXECUTE [FACINFORMELAB]" . strval($str_valorPer) . ',' . strval($ls_Desde) . ',' . strval($ls_Hasta));
					$sql_FACINFORMECON   = mssql_query("EXECUTE [FACINFORMECON]" . strval($ls_Desde));

					// if ($ls_Vendedor !== 'Todos' &&  $ls_area == 'VENTA EXTERNA') {
					if ($ls_Vendedor !== 'Todos' &&  $ls_area !== 'TELEOPERADOR') {/*CAMBIO 31052022 #debe aparecen cuando area es diferente a call center y vendedor es unico */
						fun_resul_tbl_4($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
					}
					$str_valorPer = $ls_Desde;
				} else {
					echo '<div class="loader"></div>';
					$sql_FACINFCUOTAVENTA = mssql_query("EXECUTE [FACINFCUOVEN] " . strval($str_valorPer));
					$sql_FACINFORMELAB	 = mssql_query("EXECUTE [FACINFORMELAB]" . strval($str_valorPer));
					$sql_FACINFORMECON   = mssql_query("EXECUTE [FACINFORMECON]" . strval($str_valorPer));
					// if ($ls_Vendedor != 'Todos' &&  $ls_area == 'VENTA EXTERNA') {
					if ($ls_Vendedor !== 'Todos' &&  $ls_area !== 'TELEOPERADOR') {/*CAMBIO 31052022 #debe aparecen cuando area es diferente a call center y vendedor es unico */
						fun_resul_tbl_4($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe, $ls_Desde, $ls_Hasta);
					}
				}


				fun_resul_tbl_1($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe);
				fun_resul_tbl_2($str_valorPer, $ls_area, $ls_cliente, $ls_Vendedor, $ls_Informe);
				if ($ls_area == 'ALMACEN') {
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
							echo '<br>';
						}
						$rta_query = mssql_query("
						select 
							* 
						from 
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA 
						where 
							PERIODO='" . $str_valorPer . "'
						order by
							SECTORlab,
							AREA,
							CODVENDEDOR 
						");
					} elseif ($tabla == 2) {
						// $ver_cord == 0 ? '<td>sector 1 tbl 2</td> ' : '';
						if ($ver_cord == 0) {
							echo 'sector 1 tbl 2 ';
						} else {
							echo '<br>';
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
						sqlfacturas.dbo.facInfLaboratorio  
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
							echo '<br>';
						}
						$rta_query = mssql_query("
						select 
							* 
						from 
							sqlfacturas.dbo.VIS_facInfConcentrado_2
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
							echo '<br>';
						}

						$rta_query = mssql_query("
						select 
							* 
						from 
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA
						where 
							PERIODO='" . $str_valorPer . "' 
							and CODVENDEDOR ='" . $ls_Vendedor . "' 
						order by 
							area ");
					} elseif ($tabla == 2) {
						if ($ver_cord == 0) {
							echo 'sector 2 tbl 2';
						} else {
							echo '<br>';
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
						sqlfacturas.dbo.facInfLaboratorio 
					where 
						IdPeriodo='" . $str_valorPer . "' 
						and Vendedor ='" . $ls_Vendedor . "'  
					GROUP BY 
						Laboratorio 
						,SectorLab,
						Vendedor,
						Area
					order by 
						area 
			");
					} elseif ($tabla == 3) {
						if ($ver_cord == 0) {
							echo 'sector 2 tabla 3';
						} else {
							echo '<br>';
						}

						$rta_query = mssql_query("
			select 
				* 
			from 
				sqlfacturas.dbo.VIS_facInfConcentrado_2
			where  
				IdPeriodo='" . $str_valorPer . "' 
				and Vendedor='" . $ls_Vendedor . "' 
			order by 
				SectorLab,Vendedor,NombreVendedor
			");
					} else {
						$rta_query = 'nada';
					};
				} elseif ($str_valorPer != "Todos" && $ls_area != "Todos" &&  $ls_Vendedor == "Todos") {
					if ($tabla == 1) {
						if ($ver_cord == 0) {
							echo 'sector 3 tabla 1';
						} else {
							echo '<br>';
						}

						$rta_query = mssql_query("
						select 
							* 
						from   
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA 
						where 
							PERIODO='" . $str_valorPer . "' 
							AND SECTORLAB='" . $ls_area . "' 
						order by 
							area,vendedor desc 
						");
					} elseif ($tabla == 2) {
						if ($ver_cord == 0) {
							echo 'sector 3 tabla 2';
						} else {
							echo '<br>';
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
				sqlfacturas.dbo.facInfLaboratorio  
			where 
				IdPeriodo='" . $str_valorPer . "'  
				and SectorLab ='" . $ls_area . "'  
				and Vendedor is null
			GROUP BY 
				Laboratorio
				,SectorLab
				,Vendedor
				,area
			order by 
				area
			");
					} elseif ($tabla == 3) {
						if ($ver_cord == 0) {
							echo 'sector 3 tabla 3';
						} else {
							echo '<br>';
						}

						$rta_query = mssql_query("
				select 
				* 
				from  
					sqlfacturas.dbo.VIS_facInfConcentrado_2  
				where 
					IdPeriodo ='" . $str_valorPer . "' 
					and SectorLab ='" . $ls_area . "' 
					order by 
					Area,Vendedor desc 
					");
					} else {
						$rta_query = mssql_query("select 'sin consulta valida ' as valor");
					}
				} elseif ($str_valorPer != "Todos" && $ls_area != "Todos" && $ls_Vendedor != "Todos") {
					if ($tabla == 1) {
						if ($ver_cord == 0) {
							echo 'sector 4 tbl 1';
						} else {
							echo '<br>';
						}

						$rta_query = mssql_query("
						select 
							* 
						from   
							sqlfacturas.dbo.VIS_FACINFCUOTAVENTA 
						where 
						PERIODO='" . $str_valorPer . "' 
							and sectorlab='" . $ls_area . "' 
							and CODVENDEDOR ='" . $ls_Vendedor . "'  
						order by
							area,vendedor 
						");
					} elseif ($tabla == 2) {
						if ($ver_cord == 0) {
							echo 'sector 4 tbl 2';
						} else {
							echo '<br>';
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
						sqlfacturas.dbo.facInfLaboratorio  
					where 
						IdPeriodo='" . $str_valorPer . "'  
						and SectorLab ='" . $ls_area . "' 
						and Vendedor ='" . $ls_Vendedor . "'  
					GROUP BY 
						Laboratorio
						,SectorLab
						,Vendedor
						,area
					order by 
						area,Laboratorio,vendedor
					");
					} elseif ($tabla == 3) {
						if ($ver_cord == 0) {
							echo 'sector 4 tbl 3';
						} else {
							echo '<br>';
						}

						$rta_query = mssql_query("
					select 
						* 
					from  
						sqlfacturas.dbo.VIS_facInfConcentrado_2  
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
					global $sum_ven, $sum_cuo, $sum_cum, $rta_cum, $concepto;
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
		<td class="tdata" colspan="3"></td>
		<td name="rta_cum" id="rta_cum" class="tdata"  colspan="5"></td>
		';
					// return '
					// <td class="tdata" style="background-color:'.$fondo.';" >'.number_format(intval(round($sum_ven,0)),2,",",".").'</td>
					// <td class="tdata" style="background-color:'.$fondo.';" colspan="3">'.number_format(intval(round($sum_cuo,0)),2,",",".").'</td>
					// <td name="rta_cum" id="rta_cum" class="tdata" style="border:'.strval($color).' 2px solid; background-color:'.$fondo.';" colspan="5">'.number_format(intval(round($sum_cum,0)),2,",",".").'</td>
					// ';
				} else {

					return '
		<td class="tdata" ></td>
		<td class="tdata" colspan="1"></td>
		<td name="rta_cum" id="rta_cum" class="tdata" colspan="1"></td>
		';
					// return '
					// <td class="tdata" style="background-color:'.$fondo.';" >'.number_format(intval(round($sum_ven,0)),2).'</td>
					// <td class="tdata" style="background-color:'.$fondo.';" colspan="1">'.number_format(intval(round($sum_cuo,0)),2).'</td>
					// <td name="rta_cum" id="rta_cum" class="tdata" style="border:'.strval($color).' 2px solid; background-color:'.$fondo.'; " colspan="1">'.number_format(intval(round($sum_cum,0)),2,",",".").'</td>
					// ';

				};
			};
			// <============================================================================================================================>
			// <============================================================================================================================>
			// <============================================================================================================================>
			// # crea loS GRUPOS DE LA CABECERA DE LA TABLA
			function fun_grupos_cabecera($row_data, $color, $ancho, $grupo, $row_data1, $row_data2, $row_data3, $fondo)
			{
				if ($row_data == 'TOTAL') {
					echo '
		<td class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data1), 2, ",", ".") . '</td><!--Venta-->
		<td class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data2), 2, ",", ".") . '</td><!--Cuota-->
		<td name="rta_cum" id ="rta_cum" class="tdata" style="border:' . strval($color) . ' 2px solid ; background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data3), 2) . '</td><!--Cumpli-->
		';
				} else {
					echo '
		<td class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data1), 2, ",", ".") . '</td><!--Venta-->
		<td class="tdata" style="background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data2), 2, ",", ".") . '</td><!--Cuota-->
		<td class="tdata" style="border:' . strval($color) . ' 2px solid ; background-color:' . $fondo . ';" headers="' . $grupo . '" colspan="' . $ancho . '">' . number_format(intval($row_data3), 2) . '</td><!--Cumpli-->
		';
				}
			};
			// <============================================================================================================================>
			// <============================================================================================================================>
			// <============================================================================================================================>

			function fun_etiqueta_tabla($campo, $cols = 3)
			{
				echo '
	<th headers="' . $campo . '" id="venta"  colspan="' . $cols . '">Venta</th>
	<th headers="' . $campo . '" id="cuota"  colspan="' . $cols . '">Cuota</th>
	<th headers="' . $campo . '" id="cumpli" colspan="' . $cols . '">%Cump</th>
	';
			};
			// <============================================================================================================================>
			// <============================================================================================================================>
			// <============================================================================================================================>
			function suma($valor)
			{
				$suma_rta = 0;
				$suma_rta = $suma_rta + $valor;
				return $suma_rta;
			};

			// <============================================================================================================================>
			// <============================================================================================================================>
			// <============================================================================================================================>

			// # TABLA PRINCIPAL 
			function fun_resul_tbl_1($valor_Per, $var_area, $ls_cliente, $ls_Vendedor, $ls_Informe)
			{
				$cumpl_general = 0;
				$ancho = 3;
				$arr_resul_general[]      = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_importados[]   = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_laboratorios[] = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_objetivo[]     = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$arr_resul_cont[]         = array('concepto' => 'NA', 'ven' => 0, 'cuo' => 0, 'cum' => 0, 'color' => 'white');
				$fondo = 'white';
				if (
					$var_area == 'TELEOPERADOR'
				) {
					$sql_cab = mssql_query("
		select 
			distinct (TIPOCUOTA),
			(
			case when TIPOCUOTA ='GENERAL' then 1 
			when TIPOCUOTA ='CONTADO' then  2 
			when TIPOCUOTA ='OBJETIVO' then 3
			when TIPOCUOTA ='IMPORTADOS' then  4 
			when TIPOCUOTA ='LABORATORIOS' then 5 
			else 0 
			end
			) Position 
		from 
			sqlfacturas.dbo.FACINFCUOTAVENTA
		order 
			by Position
		");
				} else {
					$sql_cab = mssql_query("
			select distinct TIPOCUOTA from sqlfacturas.dbo.FACINFCUOTAVENTA where TIPOCUOTA not in( 'OBJETIVO','CONTADO') ");
				}

				$sql_tbl1 = fun_consulta_query(1, $valor_Per, $var_area, $ls_cliente, $ls_Vendedor, $ls_Informe);

				echo '
	
	<table  class="tbl_faclab_1  table table-bordered table-responsive-sms" name="tbl_faclab" border ="2">
	<br>
	<tr>
		<th colspan="4">
			TABLA FAC INF LABORATORIO
		</th>
	</tr>
	<tr>
		<td> </td>
	</tr>
	<tr >
		<td class="tdata_cab">Periodo : ' . $valor_Per . '</td>
		<td class="tdata_cab">Reporte : ' . $_POST['queVer'] . '</td>
		<td class="tdata_cab">Informe de Ventas vs Cuota : ' . $_POST['info'] . '</td>
		<td class="tdata_cab">Cumplimiento:<input type="text" name="tot_cumpl" id="tot_cumpl" value="" class="tot_cumpl" style=" width: 71px;border: 0px solid transparent;" disabled>   % </td>
	</tr>
	</table>

	<div  class="div_tbl_1">
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
	<th id ="area">Area</th>
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

					if ($row_data[2] === 'TOTAL' || $row_data[2] === 'zTOTAL' || $row_data[2] === 'zzTOTAL' || $row_data[2] === 'zzzTOTAL') {
						$fondo = ' lightgray';
					} else {
						$fondo = 'white';
					};


					if ($row_data[2] === 'TOTAL' || $row_data[2] === 'zTOTAL') {
						$row_data[2] = 'SUBTOTAL';
					} else if ($row_data[2] === 'zzTOTAL' ||  $row_data[0] === 'zzTOTAL') {
						$row_data[2] = 'TOTAL';
						$row_data[0] = substr($row_data[0], 2, 10);
					} else if ($row_data[2] === 'zzzTOTAL'  || $row_data[0] === 'zzzTOTAL') {
						$row_data[2] = 'TOTAL';
						$row_data[0] = substr($row_data[0], 3, 10);
					} else {
						$row_data[2] = $row_data[2];
						$row_data[0] = $row_data[0];
					};


					echo '
		<tr>
			<td class="tdata" headers="area"    			 style="background-color:' . $fondo . ';">' . $row_data[0] . '</td>
			<td class="tdata" headers="vendedor" colspan="2" style="background-color:' . $fondo . ';">' . $row_data[1] . '</td>
			<td class="tdata" headers="cod_vend"			 style="background-color:' . $fondo . ';">' . $row_data[2] . '</td>
		';
					fun_grupos_cabecera($row_data[0], $color_marca, $ancho, 'GENERAL',  round($row_data[3], 0), round($row_data[4], 2), round($row_data[5], 0), $fondo);
					array_push($arr_resul_general, array('concepto' => $row_data[0], 'ven' => round($row_data[3], 0), 'cuo' => $row_data[4], 'cum' => $row_data[5], 'color' => $fondo));

					if ($var_area == 'TELEOPERADOR') {
						fun_grupos_cabecera($row_data[0], $color_marca_3, $ancho, 'OBJETIVO', $row_data[12], $row_data[13], $row_data[14], $fondo);
						array_push($arr_resul_objetivo, array('concepto' => $row_data[0], 'ven' => $row_data[12], 'cuo' => $row_data[13], 'cum' => $row_data[14], 'color' => $fondo));

						fun_grupos_cabecera($row_data[0], $color_marca_4, $ancho, 'CONTADO', $row_data[15], $row_data[16], $row_data[17], $fondo);
						array_push($arr_resul_cont, array('concepto' => $row_data[0], 'ven' => $row_data[15], 'cuo' => $row_data[16], 'cum' => $row_data[17], 'color' => $fondo));
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
			function fun_resul_tbl_2($valor_Per, $almacen, $ls_cliente, $ls_Vendedor, $ls_Informe)
			{
				$color_fondo = 'white';
				$sql_tbl2 = fun_consulta_query(2, $valor_Per, $almacen, $ls_cliente, $ls_Vendedor, $ls_Informe);
				$arr_resul_general_tbl2[] = array('ven' => 0, 'cuo' => 0, 'cum' => 0);
				$sql_cab  = mssql_query("select distinct area from sqlfacturas.dbo.facInfLaboratorio order by area");
				echo '
	<br>
	<div class="table_2">
	<table class="frxs tbl2" border ="2" >
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
					echo '
		<tr>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . $dataSr[5] . '</td>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . $dataSr[0] . '</td>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . number_format(intval($dataSr[1]), 2, ",", ".") . '</td>
			<td class="tdata" style="background-color:' . $color_fondo . '" >' . number_format(intval($dataSr[2]), 2, ",", ".") . '</td>
			<td class="tdata" style="border:' . strval($color) . ' 2px solid ;" background-color:' . $color_fondo . '; >' . number_format(intval($dataSr[3]), 2, ",", ".") . '</td>
		</tr>';
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
				$sql_cabcera = mssql_query(" select distinct Laboratorio from sqlfacturas.dbo.FACINFCONCENTRADO ");
				echo '
	<div id="tbl_3">
		<table border="1" class="tbl_3" style="width:100%;">
		<thead>
		<tr>
			<th width="100" colspan="24" class="lineas_prop"> VENTA EN LINEAS PROPIAS</th>
		</tr>
		<tr> 
			<th class="td_tbl_3" id="area_t3">AREA</th>
			<th class="td_tbl_3" id="vendedor_t3" colspan="2">VENDEDOR</th>
		';
				while ($col = mssql_fetch_array($sql_cabcera)) {
					echo '<th id="' . $col[0] . '" class="td_tbl_3" colspan="3" >' . $col[0] . '</th>';
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
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[7], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[6], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[5]))) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($rows[5], 2, ",", ".") . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[10], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[9], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[8]))) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($rows[8], 2, ",", ".") . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[13], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[12], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[11]))) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($rows[11], 2, ",", ".") . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[16], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[15], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[14]))) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($rows[14], 2, ",", ".") . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[19], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[18], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[17]))) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($rows[17], 2, ",", ".") . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[22], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[21], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[20]))) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($rows[20], 2, ",", ".") . '</td>
				<td class="tdata" style="background-color:' . $fondo . ';">' . number_format($rows[25], 2, ",", ".") . '</td><td class="tdata" style="background-color:' . $fondo . ';" >' . number_format($rows[24], 2, ",", ".") . '</td><td class="tdata" style=" border:' . strval(fun_color_porcen(suma($rows[23]))) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($rows[23], 2, ",", ".") . '</td>
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

				//  ### EJECUTAR CONSULTA DE DATOS DESDE IBS
				$campo_conta_ibs = conectar_ibs_consulta_vendedor($ls_Vendedor);

				$fondo = 'white';
				if ($ls_periodo == 'null' || $ls_periodo == null) {
					$sql_totales_clientes = mssql_query("EXECUTE FACINFCLIENTES " . intval($campo_conta_ibs) . ",'" . $ls_Vendedor . "',null, '" . intval($ls_desde) . "','" . intval($ls_hasta) . "'");
				} else {
					$sql_totales_clientes = mssql_query("EXECUTE FACINFCLIENTES " . intval($campo_conta_ibs) . ",'" . $ls_Vendedor . "'," . intval($ls_periodo));
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
				while ($tbl_4 = mssql_fetch_array($sql_totales_clientes)) {
					echo
					'<td>' . $tbl_4['VENDEDOR'] . '</td>
					 <td>' . $tbl_4['CLIENTES_TOTALES'] . '</td>
					 <td>' . $tbl_4['CLIENTES_VENTAS'] . '</td>
					 <td class="tdata" style=" border:' . strval(fun_color_porcen($tbl_4['CUMPLIMIENTO'])) . ' 2px solid; background-color:' . $fondo . ';">' . number_format($tbl_4['CUMPLIMIENTO'], 2, ",", ".") . '</td>
					 ';
				}
				echo '	
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
				// alert("La resolución de tu pantalla es: " + screen.width + " x " + screen.height);
				var init = 0;
				var conta = isNaN(parseInt(window.name)) ? 1 : parseInt(window.name);;
				var periodo = document.getElementById("lsPeriodo");
				var fecha = document.getElementById("ocultarPeriodo");
				var vendedor = document.getElementById("vendedores");
				var div_tbl_4 = document.getElementById("div_tbl_4");
				let rta_cum = document.getElementById("rta_cum");
				let tot_cumpl = document.getElementById("tot_cumpl");
				conta = 0;
				// # captutar el valor de inicio de la pantalla

				if (rta_cum.value == undefined || rta_cum.value == null) {
					rta_cum.value = 0;
					tot_cumpl.value = rta_cum.innerText;

				} else {
					tot_cumpl.value = rta_cum.innerText.toFixed(1);
				}


				window.onload = function() {
					$(".loader").show();
					if (rta_cum.value == undefined || rta_cum.value == null) {
						rta_cum.value = 0;
						console.log(rta_cum.value);
						console.log(tot_cumpl.value);
					} else {

					}

					/* # no mostrar la tabla si su valor es != Totos */
					if (vendedor.value == 'Todos' || vendedor.value == undefined || vendedor.value == null) {
						setTimeout(
							div_tbl_4.style.display = "none",
							5000
						)

					} else {
						div_tbl_4.style.display = "block";
					}

					if (periodo == "Por_Fechas" || periodo == '' || periodo == ' ' || periodo == 'selected' || periodo == undefined) {
						fecha.style.display = "block";
					}
					if (window.name = 14) {
						this.conta = 0;
					} else {
						validar_rango("");
					}
					if (window.name == 2) {}
				}



				$(document).ready(function() {
					$(".verloader").click(function() {
						$(".loader").show();
					});
					$(".verloaderB").change(function() {
						$(".loader").show();
					});
					$("select").select2();
				});

				$(window).load(function() {
					$(".loader").fadeOut("slow");
				});



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


				// # MOSTRAR EMERGENTE CON LA INFORMACION 
				function mostrarPopUp() {
					alert("<? echo "Empresa_" . $ls_empresa . " Periodo_" . $ls_periodo . " Area_ " . $ls_area . " Cliente_" . $ls_cliente . " Vendedor_" . $ls_ventas . " Informe_" . $ls_informe . " Menu_" . $chk_menu ?>");
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
			</script>
</div>