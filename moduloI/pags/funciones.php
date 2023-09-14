<?php

function minutos_diferencia ($hora_ultimo_registro,$hora_actual){

    $fecha_inicial 	= date_create($hora_ultimo_registro); 
	$fecha_final 	= date_create($hora_actual); 
	$difference 	= date_diff($fecha_inicial, $fecha_final); 
	// echo ("The difference in days is:");
	// echo $difference->format('%R%a days');
	// echo "\n";
	$minutes = $difference->days * 24 * 60;
	$minutes += $difference->h * 60;
	$minutes += $difference->i;
	// echo("The difference in minutes is:");
	// echo $minutes.' minutes';
    return  $minutes;


}






?>