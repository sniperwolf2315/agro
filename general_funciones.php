<?php
// echo'general funciones importado';

function remove_characters( $str_cadena )
 {
    // ARREGLO DE CARACTERES A BUSCAR
    $char_especial = array( '�','á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'À', 'Ã', 'Ì', 'Ò', 'Ù', 'Ã™', 'Ã ', 'Ã¨', 'Ã¬', 'Ã²', 'Ã¹', 'ç', 'Ç', 'Ã¢', 'ê', 'Ã®', 'Ã´', 'Ã»', 'Ã‚', 'ÃŠ', 'ÃŽ', 'Ã”', 'Ã›', 'ü', 'Ã¶', 'Ã–', 'Ã¯', 'Ã¤', '«', 'Ò', 'Ã', 'Ã„', 'Ã‹', '´', '>', '<', '-', '_', '�', '�', '/[^a-zA-Z0-9\_\-]+/', 'à' );
    /* ARREGLO DE PERMITIDAS PARAEL REEMPLAZO */
    $char_comun    = array( '-','a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'A', 'E', 'I', 'O', 'U', 'a' , 'e' , 'i' , 'o', 'u', 'c', 'C', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'u', 'o', 'O', 'i', 'a', 'e', 'U', 'I', 'A', 'E','-' );
    $str_cadena = str_replace( $char_especial, $char_comun, utf8_encode( $str_cadena ) );
    /*  REEMPLAZAMOS LOS CARACTERES DE LA CADENA ORIGINAL */
    // $str_cadena = strtolower( $str_cadena );
    /* CAMBIAMOS LAS MAYUSCULAS POR MINUSCULAS DE TODA LA CADENA*/
    /* RETORNAMOS LA LA CADENA MODIFICADA*/
    return utf8_encode( $str_cadena );
}

function fecha_actual()
 {
    $date = date( 'Y-m-d H:i:s' );
    $ini_carac = [ '-', ':', ' ' ];
    $fin_carac = [ '_', '_', '_' ];
    $date = str_replace( $ini_carac, $fin_carac, $date );
    return $date;
}


function periodos_comerciales($fechaActual){
	$lista_fechas_periodo = [];
	$ini_corte   = date( 'Ym', strtotime( $fechaActual.'- 1 month' ) ).'16';
	$fin_corte   = date( 'Ym', strtotime( $fechaActual ) ).'15';

	$mes_act= date( 'm' );
	$mes_act= ($mes_act<=9)?'0'.($mes_act-1):($mes_act-1);
	$mes_ant= ($mes_act<=9)?'0'.($mes_act-1):($mes_act-1);
	$dia 	 = 16; 

    while($ini_corte <=$fin_corte ){
		if( $dia > 31){$dia = 1;}
		$dia =($dia <= 9)?'0'.$dia:$dia;
		$ini_corte   = date( 'Ym', strtotime( $ini_corte ) ).$dia;
        array_push($lista_fechas_periodo,$ini_corte );
		$dia ++;
		
	}
	return $lista_fechas_periodo;
}



?>
