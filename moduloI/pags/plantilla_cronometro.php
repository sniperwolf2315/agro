<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <title>Simple Cronometro en javascript</title>
    <meta name="title" content="Cronometro en javascript">
    <meta name="description" content="Cronometro en javascript">
    <meta name="keywords" content="código,cronometro,javascript">
	<script src="../../nuevo_sia_v2/assets/js/cronometro.js"></script>
	<style>.crono_wrapper {text-align:center;width:200px;}</style>
</head>
<body onload="empezarDetener('Empezar');">
<h1>Simple Cronometro en javascript</h1>
<div class="crono_wrapper">
	<h2 id='crono'>00:00:00</h2>
	<input type="button" value="Empezar" onclick="empezarDetener(this);">
</div>
 
</body>
</html>
<!-- esto se puede borrar no afecta ningun modulo -->