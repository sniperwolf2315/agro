
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Informe Ventas Areas</title>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta name="generator" content="Antenna 3.0">
    <meta http-equiv="imagetoolbar" content="no">
    <script type="text/javascript" src="../../../antenna/auto.js"></script>
    <script src="../../../aajquery.js"></script>
	<link rel="stylesheet" type="text/css" href="estilos_ventas_area.css" media="all" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>


<?php
	@session_start();
	setlocale(LC_MONETARY,'es_CO');
	// session_destroy();
	// echo $_SERVER["REMOTE_ADDR"];s
	fun_conectarBD('sqlFacturas');
	include("../../user_con.php");
	include("../../user_user.php");
	include("../../Ventas_area.php");
	// include("ventas_area_".substr($_POST['empresa'],0,2).".php"); 
	// include("ventas_area_".substr($_POST['empresa'],0,2)."_des.php"); 





	$query_per  = mssql_query("select TOP (10) Codigo,Nombre,FechaIni,FechaFin FROM agrPeriodo ORDER BY FECHAINI DESC;");
	$vendedores = mssql_query("select codigo,Nombres,Apellidos as nombre from CLIVENDEDOR WHERE SECTORLAB IS NOT NULL AND Activo=1;");
	$lista_areas= mssql_query("select distinct SECTORLAB from FACINFCUOTAVENTA;");
	// definicion de accesos de usuarios y equivalencia usuario -> VENDXXXX

	if($_POST['empresa'] == ''){
		$_POST['empresa'] = $_SESSION['emp'];
	}
	if($_SESSION['emp'] != $_POST['empresa']){
		$_SESSION['emp'] = $_POST['empresa'];
		$_POST['empresa'] = $_SESSION['emp'];
		$_POST = array();
	}
	if($_POST['area'] != $_POST['areaH']){
		$_POST['cliente'] ='';
		$_POST['vendedor'] ='';
	}

	if($_SESSION["usuARio"] == 'OYUELAL' 
		OR $_SESSION["usuARio"] == 'BARONF' 
		OR $_SESSION["usuARio"] == 'CASTILLOW' 
		OR $_SESSION["usuARio"] == 'SIERRAJ'  
		OR SUBSTR($_POST['empresa'],0,2) != 'AG'){
	}else{
	if(date("H") >= 9 AND date("H") < 18 ){
		//ECHO "<br><br>EL SERVICIO DE CONSULTAS SE HABILITARA DE NUEVO A LAS 6.00 PM, GRACIAS POR SU COMPRENSIÓN "; DIE;
		}
	}
	//ECHO "<br><br>EL SERVICIO DE CONSULTAS ESTA EN MANTENIMIENTO AGRADECEMOS SU COMPRESION "; DIE;
	if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>"; DIE;}
//<!-- ================================================================CABECERA PHP======================================================================== -->
//<!-- ===========================================================DECALRACION DE VARIABLE======================================================================== -->

// query empresa dependiente:
    $ancho = '780px';
    $hoy = date("Y-m-d");
    $hoy_ibs = date("Ymd"); 
	$hoy = date("Y-m-d");
	$manana = date("Y-m-d", strtotime("$hoy + 1 day"));
	$hoy_2sem = date("Y-m-d", strtotime("$hoy - 2 week"));
	if($_POST['desde']==''){$_POST['desde'] = $hoy_2sem ; }
	if($_POST['hasta']==''){$_POST['hasta'] = $hoy_2sem ; }
?>
<body bgcolor="white" >
<!-- <body class="global" bgcolor="white" <?//=$autoprint?>> -->
<div class="loader" ></div>

<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<h6>usuario <?php echo$_SESSION["usuARio"].'<br>';?></h6>
<!-- <div class="containerDiv"> -->
<div class="table-responsive-sm">
	<!-- <table class="tbl_principal"> -->
	<table class="table">
		<tr>
			<th class="th_head" colspan="2">INFORME AGROCAMPO </th>
		</tr>
		<tr>
		<td class="td_izq">
<?php 
			valida_campos();
			// fun_validarPeriodo();
?>
		</td>	
		
		<td class="td_der">
			<form id="formularioUno" 
				  name="formularioUno" 
				  method="POST" 
				  action="ventas_area_des_v2.php" 
				  class="formularioUno" >
				  <br>
			Empresa:
					<br>
			<select id="empresa" name="empresa" class="frm campo" tabindex="2" onclick="mostrarConsola(this.value)" required>
					<option value="AG-AGROCAMPO" selected>AGROCAMPO</option>
			</select>
			<br>
			Periodo:
			<br>
			<select name="lsPeriodo" id="lsPeriodo" class="frm campo" onchange="validar_rango(this.value);" onclick="mostrarConsola(this.value)" required>
				<option value =<?=$_POST['lsPeriodo']?> selected><?=$_POST['lsPeriodo']?></option>
				<option value="Por Fechas">Por Fechas</option>
<?php
				$ls_empresa = $_POST['empresa'];
				$ls_periodo = $_POST['lsPeriodo'];
				$Periodo = "";
				while($rowPeriodo = mssql_fetch_array($query_per)){
					$Periodo 		  = trim($rowPeriodo['Codigo']);
					$Periodo_nom  	  = trim($rowPeriodo['Nombre']);
					$Periodo_FecIni  	  = trim($rowPeriodo['FechaIni']);
					$Periodo_FecFin  	  = trim($rowPeriodo['FechaFin']);
						echo'
						<option value="'.$Periodo.'">'.$Periodo_nom.'</option>
						';
					}
?>
			</select>
			<br>		
		<div id="ocultarPeriodo" name="ocultarPeriodo" style="display: none" class="div_rangos">
		<!-- <div id="ocultarPeriodo" name="ocultarPeriodo"class="div_rangos"> -->
			Desde:<br> <input id='desde' name='desde' class='frm campo Aabs' value='<?=$_POST['desde']?>' type='date'><br>
			Hasta:<br> <input id='hasta' name='hasta' class='frm campo Aabs' value='<?=$_POST['hasta']?>' type='date'><br>
		</div>
			<br>
		Area:<br>
		 <select  id="area" name="area" class="frm campo" onclick="mostrarConsola(this.value)" required >
			<option value=<?= $_POST['area']?>><?= $_POST['area']?></option>
			<option value="Todos" >Todos</option>
<?php	
			// foreach($areas as $keyarea ){// 	echo'<option value="'.$keyarea.'" >'.$keyarea.'</option> ';// }
		while($ls_areas = mssql_fetch_array($lista_areas )){
			echo ' <option value="'.$ls_areas['SECTORLAB'].'" >'.$ls_areas['SECTORLAB'].'</option> ';
		};
?>
		</select>
		<br>
		Cliente:<br>   
		<select  id="cliente" name="cliente" class="frm campo" onclick="mostrarConsola(this.value)" required>
				<option value=<?=$_POST['cliente']?> ><?= $_POST['cliente']?></option>
				<option value="Todos" selected>Todos</option>
<?php
					foreach($tiCLI as $keycli => $valcli){
						// echo $keycli.$valcli;
						echo '<option value="'.$keycli.'"> '.$valcli.'</option> ';
					};
?>
		</select>
		<br>
<?php
			if(substr($_POST['empresa'],0,2) == 'ZZ'  ){
				fun_producto();
			}elseif(substr($_POST['empresa'],0,2) == 'AG' AND ($_POST['queVer'] == 'PRODUCTO' OR $_POST['queVer'] == 'GRUPO') ){
				fun_grupo();
			}
?>
		Vendedor:<br>
		<select  id="vendedores" name="vendedores" class="frm campo" onclick="mostrarConsola(this.value)" required>
				<option value=<?= $_POST['vendedores']?>><?= $_POST['vendedores']?></option>
				<option value="Todos">Todos</option>
<?php
		while($vend = mssql_fetch_array($vendedores)){
				echo '<option  value="'.$vend[0].'">'.$vend[0].' '.$vend[1].' '.$vend[2].'</option>';
			}
?>
		</select>
		<br>
<?php 
			if($_SESSION['emp'] == 'AG- AGROCAMPO' || $_SESSION['emp'] == 'AG- AGROCAMPO' ){ 
?>
		Informe de: 
		<br>
		<select id="info" name="info" class="frm campo" onclick="mostrarConsola(this.value)" required >
				<option value=<?=$_POST['info']?> selected><?= $_POST['info']?></option>
<?php
					if($_POST['info'] != 'Facturado' ){echo '<option value="facturado" >Facturado</option>';}
					if($_POST['info'] != 'Ord Venta' ){echo '<option value="orven">Ord Venta</option>';}
					if($_POST['info'] != 'Fac y Ord venta' ){echo '<option value="facorven">Fac y Ord venta</option>';}
?>
		</select>
		<br>
<?php 
				} // ENDIF LINE:1209
?>
		Ver Reporte:<br>
		<input <? if($_POST['queVer']=='VENTAS'  ){echo "checked";}?>onclick="mostrarConsola(this.value)" class="radios" type="radio" id="queVer" name="queVer" value="VENTAS"   onclick="mostrarConsola(this.value)" >Ver Ventas / Cuotas<br>
		<input <? if($_POST['queVer']=='CARTERA' ){echo "checked";}?>onclick="mostrarConsola(this.value)" class="radios" type="radio" id="queVer" name="queVer" value="CARTERA"  onclick="mostrarConsola(this.value)" >Ver Cartera / Vta por cliente<br>		
		<input <? if($_POST['queVer']=='PRODUCTO'){echo "checked";}?>onclick="mostrarConsola(this.value)" class="radios" type="radio" id="queVer" name="queVer" value="PRODUCTO" onclick="mostrarConsola(this.value)" >Ver Vta por Producto<br>
		<input <? if($_POST['queVer']=='GRUPO'   ){echo "checked";}?>onclick="mostrarConsola(this.value)" class="radios" type="radio" id="queVer" name="queVer" value="GRUPO"    onclick="mostrarConsola(this.value)" >Ver Vta por Grupo<br>
		<input <? if($_POST['queVer']=='EST10'   ){echo "checked";}?>onclick="mostrarConsola(this.value)" class="radios" type="radio" id="queVer" name="queVer" value="EST10" 	 onclick="mostrarConsola(this.value)" >Ver Ordenes estado 10
<?php
		if($_SESSION["usuARio"]!="VILLALOBOS"){
			echo'<br>';
		}else{
			echo'
			<br>
				<input class="" type="radio" id="queVer"name="queVer" value="dev" checked>DEV
			<br>
		';
		}
			if(substr($_POST['empresa'],0,2) == 'X1' ) {
				if($_POST['queVer']=='ESPECTROS'){ 
					$checked = "checked";}
					else{$checked = "";
					}  
				echo "
					<input  $checked type='radio' id='queVer' name='queVer' value='ESPECTROS'> Ver Espectros
					<br>&nbsp;<br>
					";
		} //END IF LINE 
		if($_POST['est10'] == 'SI'){echo "checked";}
?>	
		<br>
		<div class="boton_form">
					<!-- <input  id="Ver" name="botonref1" class="verloader  frm" value="Ver" type="submit"  onclick="" > -->
					<input  id="Ver" name="botonref1" class="frm" value="Ver" type="submit"  onclick="" >
					<input 	id="Imprimir" name="Imprimir" type="button" class="frm" value="Imprimir" onClick="javascript:window.print()" />	
		</div>				
	</form>	
	</td>
	
</tr>
</table>
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXESPACIO HTML FORM NUEVOXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX SOLO CODIGO PHP XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<?php


//CONEXION A LA BD SQL SERVER 2017
function fun_conectarBD($name_db){
	$server_name = '192.168.6.15';
	$user_name ='sa';
	$user_pass ='%19Sis60Tem@s17';
	$cLink = mssql_connect($server_name, $user_name, $user_pass) or die(mssql_get_last_message()); 
	mssql_select_db($name_db,$cLink);
	if(!$cLink){
		echo "sin conectar a l server";
	}else{
		// echo 'Conectado';
	}
}
// CREA EL CAMPO DE PRODUCTO
function fun_producto(){
	echo '
	Producto: 
		<select  id="producto" name="producto"  >
			<option value="">Todos</option>
			<option>'.$_POST['producto'].'</option>
	';	
		global $tiPRO;
		foreach($tiPRO as $titulo => $valor){
			if($_POST['producto'] != trim($titulo) ){
			echo "<option >$titulo</option>";
			}
		}
	echo'
		</select>
	';	
}
// CREA EL CAMPO DE FRUPO PARA FILTRO
function fun_grupo(){
	echo '
	Grupo: <br>
	<select id="grupo" name="grupo" class="frm campo"  >
	<option value="">Todos</option>
	<option>'.$_POST['grupo'].'</option>
	';
		global $grupos;
		foreach($grupos as $titulo => $valor){
			if($_POST['grupo'] != trim($titulo) ){
				echo '<option >'.$titulo.'</option>';
			}
		}
}
function valida_campos(){
	$ls_periodo  = utf8_decode($_POST['lsPeriodo']);
	$ls_area     = utf8_decode($_POST['area']);
	$ls_cliente  = utf8_decode($_POST['cliente']);
	$ls_Vendedor = utf8_decode($_POST["vendedores"]);
	$ls_Informe  = utf8_decode($_POST['info']);
	$ls_Desde 	 = utf8_decode($_POST['desde']);
	$ls_Hasta 	 = utf8_decode($_POST['hasta']);
	$ls_Desde    = str_replace('-','',$ls_Desde);
	$ls_Hasta  	 = str_replace('-','',$ls_Hasta);

	if(empty($ls_periodo ) && empty($ls_area    ) && empty($ls_cliente ) && empty($ls_Vendedor) && empty($ls_Informe ) && empty($ls_Desde   ) && empty($ls_Hasta)){
		echo 'Por favor diligenciar todos los cambios.';
	}else{
		fun_validarPeriodo($ls_periodo,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe,$ls_Desde,$ls_Hasta);
	}
}
// VALIDA LA INFORMACION QUE VA EN LA COLUMNA DE LA DERACHA 
function fun_validarPeriodo($ls_periodo,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe,$ls_Desde,$ls_Hasta){
	// if($ls_periodo=="Todos" &&  ($_POST['queVer'] =='VENTAS' || $_POST['queVer'] =='CARTERA' || $_POST['queVer'] =='PRODUCTO' || $_POST['queVer'] =='GRUPO' || $_POST['queVer'] =='EST10')){
	if($ls_periodo=="Por Fechas" && ($_POST['queVer'] =='CARTERA' OR $_POST['queVer'] =='PRODUCTO' OR $_POST['queVer'] =='GRUPO' OR $_POST['queVer'] =='EST10')){
		//  echo' periodos if 1<br>';
		tabla_old();
	}
	elseif($ls_periodo!='Por Fechas' &&  $_POST['queVer'] =='VENTAS' ){
		// echo' periodos ifelse 1<br>';
		$ls_Desde='null';
		$ls_Hasta='null';
		fun_ejecutar_sp_facinformes($ls_periodo,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe,$ls_Desde,$ls_Hasta);
	}
	elseif($ls_periodo=='Por Fechas' && $_POST['queVer']=='VENTAS'){
		// echo' periodos ifelse 2 <br>';
		$ls_periodo = 'null';
		// echo $ls_periodo.$ls_Desde.$ls_Hasta;
		fun_ejecutar_sp_facinformes($ls_periodo,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe,$ls_Desde,$ls_Hasta);
	}
	elseif($_POST['queVer'] =='dev' && ($ls_periodo!=" " || $ls_periodo!="" || $ls_periodo!="Por Fechas" )){
	}
	else{
		echo'<h2>no ha seleccionado nada valido !</h2><br>';
	}
}

// FUNCION LA CUAL AGREGA COLOR A LOS CAMPOS QUE CUMPLEN LA REGLA
function fun_color_porcen ($valor_campo_1 = 0){
	global $color ; 
	$color ='#FFFFF';//BLANCO
	if(($valor_campo_1 ) > 90){
		$color = '#4A821D'; //verde
	}elseif(($valor_campo_1 )> 40 && ($valor_campo_1 )<80){
		$color = '#ad530a';//NARANJA
	}elseif(($valor_campo_1 )>=0  && ($valor_campo_1 ) < 40){
		$color = '#b80e0e'; //ROJO
	}else{
		$color = '#FFFFF'; //BLANCO
	}
	return $color;
}

// fUNCION QUE EJECUTA LOS SP PARA LA CONSULTA DEL INFORME
function fun_ejecutar_sp_facinformes($str_valorPer,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe,$ls_Desde,$ls_Hasta) {
	// echo '<br>'.$str_valorPer,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe,$ls_Desde,$ls_Hasta.'<br>';
	if($str_valorPer==='null' ){
		// echo 'VALOR NULL = '.$str_valorPer.$ls_Desde.$ls_Hasta;
		$sql_FACINFCUOTAVENTA=mssql_query("EXECUTE [FACINFCUOVEN] ".strval($str_valorPer).','.strval($ls_Desde).','.strval($ls_Hasta)  );
		$sql_FACINFORMELAB	 =mssql_query("EXECUTE [FACINFORMELAB]".strval($str_valorPer).','.strval($ls_Desde).','.strval($ls_Hasta) );
		$sql_FACINFORMECON   =mssql_query("EXECUTE [FACINFORMECON]".strval($ls_Desde));
		$str_valorPer =$ls_Desde;
	}else{
		// echo 'VALOR NO NULL'.$str_valorPer.$ls_Desde.$ls_Hasta;
		$sql_FACINFCUOTAVENTA=mssql_query("EXECUTE [FACINFCUOVEN] ".strval($str_valorPer));
		$sql_FACINFORMELAB	 =mssql_query("EXECUTE [FACINFORMELAB]".strval($str_valorPer));
		$sql_FACINFORMECON   =mssql_query("EXECUTE [FACINFORMECON]".strval($str_valorPer));
	}
	fun_resul_tbl_1($str_valorPer,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe);
	fun_resul_tbl_2($str_valorPer,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe);
	fun_resul_tbl_3($str_valorPer,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe);
}

// function fun_consulta_query($tabla,$str_valorPer,$var_area,$ls_cliente,$ls_Vendedor,$ls_Informe){
function fun_consulta_query($tabla,$str_valorPer,$var_area){
	//VALORE SIN AREA
	$ver_cord = 1;
	$ls_Vendedor = utf8_decode($_POST['vendedores']);
	$ls_Informe  = utf8_decode($_POST['info']);
	$ls_cliente  = utf8_decode($_POST['cliente']);
	$ls_Informe  = utf8_decode($_POST['info']);
	$ls_area     = utf8_decode($_POST['area']);

	// echo $tabla.' periodo:'.$str_valorPer.' Area:'.$var_area.' Cliente:'.$ls_cliente.' Vendedor: '.$ls_Vendedor.' Informe:'.$ls_Informe.'<br>';

	if( $str_valorPer !="Todos" && $ls_area == "Todos"  &&  $ls_Vendedor =="Todos" ){
		if($tabla ==1){
			if($ver_cord == 0){ echo 'sector 1 tbl 1 ';}else{echo'<br>';} 
					$rta_query = mssql_query("
					select 
						* 
					from 
						sqlfacturas.dbo.VIS_FACINFCUOTAVENTA 
					where 
						PERIODO='".$str_valorPer."'
					order by
						AREA,
						CODVENDEDOR desc
					; 
					");
			}
			elseif($tabla ==2 ){
			// $ver_cord == 0 ? '<td>sector 1 tbl 2</td> ' : '';
			if($ver_cord == 0){ echo 'sector 1 tbl 2 ';}else{echo'<br>';} 
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
						IdPeriodo='".$str_valorPer."' 
						and sectorlab is null 
					GROUP BY 
						Laboratorio
						,area,SectorLab
					order by 
						area; 
					");
			}
			elseif($tabla ==3){
			if($ver_cord == 0){ echo 'sector 1 tbl 3 ';}else{echo'<br>';} 
				$rta_query = mssql_query("
				select 
					* 
				from 
					sqlfacturas.dbo.VIS_facInfConcentrado_2
				where  
					IdPeriodo ='".$str_valorPer."' 
					AND sectorlab <> ' '
					AND NOT (AREA = 'ZZTOTAL' AND SECTORLAB <> 'TOTAL') 
				order by 
					area,Vendedor desc; 
				");
			}
			else{
				$rta_query =mssql_query("No hay nada");
			};
	}




	elseif( $str_valorPer !="Todos" &&  $ls_area =="Todos" &&  $ls_Vendedor !="Todos" ){
		if($tabla ==1){
			if($ver_cord == 0){ echo 'sector 2 tbl 1 ';}else{echo'<br>';} 

				$rta_query = mssql_query("
				select 
					* 
				from 
					sqlfacturas.dbo.VIS_FACINFCUOTAVENTA
				where 
					PERIODO='".$str_valorPer."' 
					and CODVENDEDOR ='". $ls_Vendedor ."' 
				order by 
					area ");
		}
		elseif($tabla ==2){
			if($ver_cord == 0){ echo 'sector 2 tbl 2';}else{echo'<br>';} 

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
				IdPeriodo='".$str_valorPer."' 
				and Vendedor ='".$ls_Vendedor ."'  
			GROUP BY 
				Laboratorio 
				,SectorLab,
				Vendedor,
				Area
			order by 
				area 
			");
		}
		elseif($tabla ==3){
			if($ver_cord == 0){ echo 'sector 2 tabla 3';}else{echo'<br>';} 

			$rta_query = mssql_query("
			select 
				* 
			from 
				sqlfacturas.dbo.VIS_facInfConcentrado_2
			where  
				IdPeriodo='".$str_valorPer."' 
				and Vendedor='".$ls_Vendedor."' 
			order by 
				SectorLab,Vendedor,NombreVendedor
			");
		}
		else{
			$rta_query ='nada';
		};

	}






	elseif($str_valorPer !="Todos" && $ls_area!="Todos" &&  $ls_Vendedor =="Todos" ){
			if($tabla==1 ){
				if($ver_cord == 0){ echo 'sector 3 tabla 1';}else{echo'<br>';} 

				$rta_query = mssql_query("
				select 
					* 
				from   
					sqlfacturas.dbo.VIS_FACINFCUOTAVENTA 
				where 
					PERIODO='".$str_valorPer."' 
					AND SECTORLAB='".$ls_area."' 
				order by 
					area,vendedor desc 
				");
			}
			elseif($tabla ==2 ){
				if($ver_cord == 0){ echo 'sector 3 tabla 2';}else{echo'<br>';} 

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
					IdPeriodo='".$str_valorPer."'  
					and SectorLab ='".$ls_area."'  
					and Vendedor is null
				GROUP BY 
					Laboratorio
					,SectorLab
					,Vendedor
					,area
				order by 
					area
				");
			}
			elseif($tabla ==3){
				if($ver_cord == 0){ echo 'sector 3 tabla 3';}else{echo'<br>';} 

				$rta_query = mssql_query("
				select 
					* 
				from  
					sqlfacturas.dbo.VIS_facInfConcentrado_2  
				where 
					IdPeriodo ='".$str_valorPer."' 
					and SectorLab ='".$ls_area."' 
				order by 
					Area,Vendedor desc 
				");
			}
			else{
				$rta_query =mssql_query("select 'sin consulta valida ' as valor");
			}
		
	}



	elseif($str_valorPer !="Todos" && $ls_area !="Todos" && $ls_Vendedor !="Todos" ){
		if($tabla==1 ){
			if($ver_cord == 0){ echo 'sector 4 tbl 1';}else{echo'<br>';} 

			$rta_query = mssql_query("
				select 
					* 
				from   
					sqlfacturas.dbo.VIS_FACINFCUOTAVENTA 
				where 
					PERIODO='".$str_valorPer."' 
					and sectorlab='".$ls_area."' 
					and CODVENDEDOR ='". $ls_Vendedor ."'  
				order by
					area,vendedor 
				");
		}
		elseif($tabla ==2 ){
			if($ver_cord == 0){ echo 'sector 4 tbl 2';}else{echo'<br>';} 

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
				IdPeriodo='".$str_valorPer."'  
				and SectorLab ='".$ls_area."' 
				and Vendedor ='".$ls_Vendedor."'  
			GROUP BY 
				Laboratorio
				,SectorLab
				,Vendedor
				,area
			order by 
				area,Laboratorio,vendedor
			");
		}
		elseif($tabla ==3){
			if($ver_cord == 0){ echo 'sector 4 tbl 3';}else{echo'<br>';} 

			$rta_query = mssql_query("
			select 
				* 
			from  
			sqlfacturas.dbo.VIS_facInfConcentrado_2  
			where 
				IdPeriodo ='".$str_valorPer."' 
				and SectorLab ='".$ls_area."' 
				and Vendedor='".$ls_Vendedor."' 
			order by 
				NombreVendedor
			");
		}
	}
	else{
		$rta_query =mssql_query("nada");
	}
	return $rta_query;
}





// FUNCION PARA CALCULAR LOS TOTALES DE LA TABLA 1
function fun_calcular_totales($array_data =array(),$rep,$fondo) {
	$color='';
	foreach ($array_data as $key => $value) {
		global $sum_ven,$sum_cuo,$sum_cum;
		$sum_ven = $sum_ven +$value['ven'];
		$sum_cuo = $sum_cuo +$value['cuo'];
		$sum_cum = $sum_cum +$value['cum'];
		// $fondo =$value['color'];
	}
	$color = fun_color_porcen($sum_cum);
	if ($rep==0){
		return '
		<td class="tdata" style="background-color:'.$fondo.';" >'.number_format(intval(round($sum_ven,0)),2,",",".").'</td>
		<td class="tdata" style="background-color:'.$fondo.';" colspan="3">'.number_format(intval(round($sum_cuo,0)),2,",",".").'</td>
		<td class="tdata" style="border:'.strval($color).' 2px solid; background-color:'.$fondo.';" colspan="6"  ">'.number_format(intval(round($sum_cum,0)),2,",",".").'</td>
	';
	}
	else{
		return '
		<td class="tdata" style="background-color:'.$fondo.';" >'.number_format(intval(round($sum_ven,0)),2).'</td>
		<td class="tdata" style="background-color:'.$fondo.';" colspan="1">'.number_format(intval(round($sum_cuo,0)),2).'</td>
		<td class="tdata" style="border:'.strval($color).' 2px solid; background-color:'.$fondo.'; " colspan="1"  ">'.number_format(intval(round($sum_cum,0)),2,",",".").'</td>
	';
	};
};


// crea loS GRUPOS DE LA CABECERA DE LA TABLA
function fun_grupos_cabecera($color,$ancho,$grupo,$row_data1,$row_data2,$row_data3,$fondo){
	echo '
		<td class="tdata" style="background-color:'.$fondo.';" headers="'.$grupo.'" colspan="'.$ancho.'">'.number_format(intval($row_data1),2,",",".").'</td><!--Venta-->
		<td class="tdata" style="background-color:'.$fondo.';" headers="'.$grupo.'" colspan="'.$ancho.'">'.number_format(intval($row_data2),2,",",".").'</td><!--Cuota-->
		<td class="tdata" style="border:'.strval($color).' 2px solid ; background-color:'.$fondo.';" headers="'.$grupo.'" colspan="'.$ancho.'">'.number_format(intval($row_data3),2).'</td><!--Cumpli-->
	';
};

function fun_etiqueta_tabla($campo,$cols=3){
	echo '
		<th headers="'.$campo.'" id="venta"  colspan="'.$cols.'">Venta</th>
		<th headers="'.$campo.'" id="cuota"  colspan="'.$cols.'">Cuota</th>
		<th headers="'.$campo.'" id="cumpli" colspan="'.$cols.'">%Cump</th>
	';
};

function suma($valor){
	$suma_rta=0;
	$suma_rta = $suma_rta + $valor;
	return $suma_rta;
};

// TABLA PRINCIPAL 
function fun_resul_tbl_1($valor_Per,$var_area,$ls_cliente,$ls_Vendedor,$ls_Informe){
	$cumpl_general = 0; 
	$ancho = 3;
	$arr_resul_general[] = array('ven'=>0,'cuo'=>0,'cum'=>0,'color'=>'white');
	$arr_resul_importados[] = array('ven'=>0,'cuo'=>0,'cum'=>0,'color'=>'white');
	$arr_resul_laboratorios[] = array('ven'=>0,'cuo'=>0,'cum'=>0,'color'=>'white');
	$fondo ='white';
	$sql_cab = mssql_query("select distinct TIPOCUOTA from sqlfacturas.dbo.FACINFCUOTAVENTA");
	$sql_tbl1=fun_consulta_query(1,$valor_Per,$var_area,$ls_cliente,$ls_Vendedor,$ls_Informe);

	echo '
	<table  class="tbl_faclab_1  table table-bordered" name="tbl_faclab" border ="2">
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
				<td class="tdata_cab">Periodo : '.$valor_Per.'</td>
				<td class="tdata_cab">Reporte : '.$_POST['queVer'].'</td>
				<td class="tdata_cab">Informe de Ventas vs Cuota : '.$_POST['info'].'</td>
				<td class="tdata_cab">Cumplimiento:'.$cumpl_general.' % </td>
			</tr>
	</table>
	
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
	// WHILE PARA LA CABECERA DE LA TABLA DINAMICA
	while($col_name =  mssql_fetch_array($sql_cab)){
		echo '<th colspan="'.($ancho*3).'" id="'.trim($col_name[0]).'">'. trim($col_name[0]).'</th>';
	};
	echo '
	</tr>
	<tr>
		 <th headers="area" colspan="4" ></th>
	';
	for($i=0;$i <=2;$i++){
		$head='';
		if($i==0){$head='GENERAL';
		}elseif($i==1){$head='IMPORTADOS';
		}elseif($i==2){$head='LABORATORIOS';
		}else{$head='SIN DATA';
		}

		fun_etiqueta_tabla($head);
	};
echo'
	</tr>
	';
	/* WHILE PARA LLAMADO DE LA DATA */
	while($row_data = mssql_fetch_array($sql_tbl1)){
		$color_marca   = fun_color_porcen($row_data[5]);
		$color_marca_1 = fun_color_porcen($row_data[8]);
		$color_marca_2 = fun_color_porcen($row_data[11]);
		if($row_data[2]==='TOTAL'){ $fondo =' lightgray' ;}else{ $fondo ='white';}; 
		echo'
		<tr>
			<td class="tdata" headers="area"    			 style="background-color:'.$fondo.';">'.$row_data[0].'</td>
			<td class="tdata" headers="vendedor" colspan="2" style="background-color:'.$fondo.';">'.$row_data[1].'</td>
			<td class="tdata" headers="cod_vend"			 style="background-color:'.$fondo.';">'.$row_data[2].'</td>
		'; 
			fun_grupos_cabecera($color_marca,$ancho,'GENERAL',  round($row_data[3],0),round($row_data[4],2),round($row_data[5],0),$fondo);
			array_push($arr_resul_general,array( 'ven'=> round($row_data[3],0),'cuo'=>$row_data[4],'cum'=>$row_data[5],'color'=>$fondo));
			
			fun_grupos_cabecera($color_marca_1,$ancho,'IMPORTADOS',$row_data[6],$row_data[7],$row_data[8],$fondo);
			array_push($arr_resul_importados,array( 'ven'=> $row_data[6],'cuo'=>$row_data[7],'cum'=>$row_data[8],'color'=>$fondo));
			
			fun_grupos_cabecera($color_marca_2,$ancho,'LABORATORIOS',$row_data[9],$row_data[10],$row_data[11],$fondo);
			array_push($arr_resul_laboratorios,array( 'ven'=> $row_data[9],'cuo'=>$row_data[10],'cum'=>$row_data[11],'color'=>$fondo));
		
		echo'
		</tr>
			';
		};
		echo '
		<tfooter>
		<tr>
			<td class="" axis="categoria" colspan="4" id="subtotal" bgcolor="lightgray" >Subtotal</td>
			'.fun_calcular_totales($arr_resul_general,0,$fondo) .'
			'.fun_calcular_totales($arr_resul_importados,0,$fondo) .'
			'.fun_calcular_totales($arr_resul_laboratorios,0,$fondo) .'
		</tr>
		</tfooter>
</table>
	';
			$cumpl_general=suma($arr_resul_general[0]['cum']);
}



// ESTA ES LA FUNCION QUE LLAMA Y CREA LA TABLA 2
function fun_resul_tbl_2($valor_Per,$almacen,$ls_cliente,$ls_Vendedor,$ls_Informe){
	$sql_tbl2 = fun_consulta_query(2,$valor_Per,$almacen,$ls_cliente,$ls_Vendedor,$ls_Informe);
	$arr_resul_general_tbl2[] = array('ven'=>0,'cuo'=>0,'cum'=>0);
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
			echo '
			<tr>
				<td class="tdata">'.$dataSr[5].'</td>
				<td class="tdata">'.$dataSr[0].'</td>
				<td class="tdata">'.number_format(intval($dataSr[1]),2,",",".").'</td>
				<td class="tdata">'.number_format(intval($dataSr[2]),2,",",".").'</td>
				<td class="tdata" style="border:'.strval($color).' 2px solid ;" >'.number_format(intval($dataSr[3]),2,",",".").'</td>
			</tr>';
	};	
	echo'
		</tbody>
		</table>
	</div>
	';
}



// GENERA EL CONTENIDO DE LA TABLA 3 VENTAS EN KILOS Y UNIDADES LINEAS PROPIAS
function fun_resul_tbl_3($ls_periodo,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe){
	$sql_data = fun_consulta_query(3,$ls_periodo,$ls_area,$ls_cliente,$ls_Vendedor,$ls_Informe);
	$conta=0;
	$valor_null = 0;
	$tol_porcen_cab=0; 
	$ancho=3;
	$Area=$valor_null;$IdPeriodo=$valor_null
	;$Cuota=$valor_null;$Cumplimiento=$valor_null;
	$Vendedor=$valor_null;$NombreVendedor=$valor_null;
	$SectorLab=$valor_null;
	$fondo ='white';

	$EVANGERS=0;$PROPAC=0;$SOMEX=0;$A_FACTOR=0;$ODOURLOOK=0;$QUALIVET=0;$F_CHOICE=0;
	$sql_cabcera =mssql_query(" select distinct Laboratorio from sqlfacturas.dbo.FACINFCONCENTRADO ");
	echo '
	<div id="tbl_3">
		<table border="1" class="tbl_3" style="width:100%;">
		<thead>
		<tr>
		 <th width="100" colspan="24" align="center"> VENTA EN LINEAS PROPIAS</th>
		</tr>
			<tr> 
				<th class="td_tbl_3" id="area_t3">AREA</th>
				<th class="td_tbl_3" id="vendedor_t3" colspan="2">VENDEDOR</th>
	';
		while ($col = mssql_fetch_array($sql_cabcera)){
			echo '<th id="'.$col[0].'" class="td_tbl_3" colspan="3" >'.$col[0].'</th>';
		};

	echo'
			</tr>
		<tr>
	<td colspan ="3"></td>
	';
	 for ($i=0; $i <=6; $i++) {
		  fun_etiqueta_tabla('',1);
		};
	echo'
	</tr>
	</thead>
		<tbody>
		';
		while ($rows  = mssql_fetch_array($sql_data)){
			$conta ++;
			if ($rows['Area']==='ZZTOTAL' || $rows['Vendedor']==='TOTAL' ){ 
				$rows['Area']='TOTAL'; 
				$fondo ='lightgray';
			}else{ 
				$rows['Area']=$rows['Area'];
				$fondo ='white';
			}		
			
			echo '
		<tr style="background-color="red"; ">
				
				<td class="tdata" style="background-color:'.$fondo.';" headers="area_t3" >'.$rows['Area'].'</td>
				<td class="tdata" style="background-color:'.$fondo.';" headers="vendedor_t3" colspan="2">'.$rows[2] .' - '.$rows['NombreVendedor'].'</td>
				<td class="tdata" style="background-color:'.$fondo.';">'.number_format($rows[7] ,2,",",".").'</td><td class="tdata" style="background-color:'.$fondo.';" >' .number_format($rows[6] ,2,",",".").'</td><td class="tdata" style=" border:'.strval(fun_color_porcen(suma($rows[5] ))).' 2px solid; background-color:'.$fondo.';">'. number_format( $rows[5],2,",",".") .'</td>
				<td class="tdata" style="background-color:'.$fondo.';">'.number_format($rows[10],2,",",".").'</td><td class="tdata" style="background-color:'.$fondo.';" >' .number_format($rows[9] ,2,",",".").'</td><td class="tdata" style=" border:'.strval(fun_color_porcen(suma($rows[8] ))).' 2px solid; background-color:'.$fondo.';">'. number_format( $rows[8],2,",",".") .'</td>
				<td class="tdata" style="background-color:'.$fondo.';">'.number_format($rows[13],2,",",".").'</td><td class="tdata" style="background-color:'.$fondo.';" >' .number_format($rows[12],2,",",".").'</td><td class="tdata" style=" border:'.strval(fun_color_porcen(suma($rows[11]))).' 2px solid; background-color:'.$fondo.';">'. number_format($rows[11],2,",",".") .'</td>
				<td class="tdata" style="background-color:'.$fondo.';">'.number_format($rows[16],2,",",".").'</td><td class="tdata" style="background-color:'.$fondo.';" >' .number_format($rows[15],2,",",".").'</td><td class="tdata" style=" border:'.strval(fun_color_porcen(suma($rows[14]))).' 2px solid; background-color:'.$fondo.';">'. number_format($rows[14],2,",",".") .'</td>
				<td class="tdata" style="background-color:'.$fondo.';">'.number_format($rows[19],2,",",".").'</td><td class="tdata" style="background-color:'.$fondo.';" >' .number_format($rows[18],2,",",".").'</td><td class="tdata" style=" border:'.strval(fun_color_porcen(suma($rows[17]))).' 2px solid; background-color:'.$fondo.';">'. number_format($rows[17],2,",",".") .'</td>
				<td class="tdata" style="background-color:'.$fondo.';">'.number_format($rows[22],2,",",".").'</td><td class="tdata" style="background-color:'.$fondo.';" >' .number_format($rows[21],2,",",".").'</td><td class="tdata" style=" border:'.strval(fun_color_porcen(suma($rows[20]))).' 2px solid; background-color:'.$fondo.';">'. number_format($rows[20],2,",",".") .'</td>
				<td class="tdata" style="background-color:'.$fondo.';">'.number_format($rows[25],2,",",".").'</td><td class="tdata" style="background-color:'.$fondo.';" >' .number_format($rows[24],2,",",".").'</td><td class="tdata" style=" border:'.strval(fun_color_porcen(suma($rows[23]))).' 2px solid; background-color:'.$fondo.';">'. number_format($rows[23],2,",",".") .'</td>
		</tr>
	';
	};
	echo'
		</tbody>
	</table>
	</div>
	';
};
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
	
	function mostrarConsola(valor){
		console.log(valor);
	}
	// MOSTRAR EMERGENTE CON LA INFORMACION 
	function mostrarPopUp() {
		alert("<?echo "Empresa_".$ls_empresa." Periodo_".$ls_periodo." Area_ ".$ls_area." Cliente_". $ls_cliente." Vendedor_".$ls_ventas." Informe_".$ls_informe." Menu_".$chk_menu?>");
	}
	//CONTAR LOS CLICKS PARA VALIDACIONES DE CAMPOS
	function conteo() {
		document.getElementById("btn2").addEventListener("click", function(event) {
			event.target.innerHTML = "Conteo de Clicks: " + event.detail;
			console.log("EVENTO" + event.returnValue);
		}, false);
	}

	//VALIDA LA OPCION DE PERIODO PARA OCULATAR O MOSTRAR LOS CAMPOS DE LAS FECHAS
	function validar_rango(valor){
		var fecha = document.getElementById("ocultarPeriodo");
		var check = document.getElementById("queVer");
		if(valor === "Por Fechas" || valor ==="selected") {
			fecha.style.display = "block";
			// $("#queVer").attr('disabled','disabled');
			// $("#queVer").attr('checked', false);
		}
		else{
			fecha.style.display = "none";
			// $("#queVer").removeAttr('disabled');
		}
		
	}
	//OCULTA EL RANGO POR INDEPENDIENTE 
	function ocultarRango(valor_param) {
		var x = document.getElementById("queVer");
		if (x.style.display === "none") {
				x.style.display = "block";

			}else{
				x.style.display = "none";
			}
		
		
}
</script>

<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
<!-- ==================================================================================       OLD       =====================================================-->
