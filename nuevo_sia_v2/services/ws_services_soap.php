<?php
// echo 'estamos en el sw soap';
session_start(); // INICIAMOS LA SESION
$user_log = strtolower( $_GET[ 'user_log' ] );
$pass_log = strtolower( $_GET[ 'pass_log' ] );
$validar  = $_GET[ 'ef' ];
/* REVISAR
$_SESSION['usuARio'] = $user_log;
$_SESSION['clAVe']   = $user_log;
*/

if ( $validar =='1' ) {
    echo php_function_ejecutar_login( $user_log, $pass_log );
    if ( php_function_ejecutar_login( $user_log, $pass_log ) === 'SI' ) {
        console.log('si tiene permiso');
        
        // $_SESSION["usuARio"] = $user_log;
        // $_SESSION["clAVe"]   = $pass_log;
        
    }
}

$url = 'http://192.168.6.68:8080/WSFacturas/WSFacturas.asmx?WSDL';

function service_soap_agro( $url, $end_point, $parametros, $response ) {
    try {
        $client = new SoapClient( $url );
        $result = $client->$end_point( $parametros );
        $result = json_decode( json_encode( $result ), true );
        $result = ( $result[ $response ] ) ? 'SI' : 'NO';
        if($result.trim()==='SI'){
          $_SESSION["usuARioS"] = $parametros['Login'];
          $_SESSION["clAVeS"]   = $parametros['Password'];
        }
        return $result;
    } catch ( SoapFault $e ) {
        echo $e->getMessage();
    }
}

function php_function_perfileria( $user, $url ) {
    for ( $i = 1; $i <= 4 ; $i++ ) {

        if ( $i == 1 ) {
            $parametros = array( 'Login' => "$user", 'Funcion' => 'O.REPG.SEL' );
            $consulta_todo_el_reporte = service_soap_agro( $url, 'AutorizarUsuario', $parametros, 'AutorizarUsuarioResult' );
            $nivel =   ( $consulta_todo_el_reporte === 'SI' )? 1:'';
        } else if ( $i == 2 ) {
            $parametros = array( 'Login' => "$user", 'Funcion' => 'O.REPI.SEL' );
            $consulta_todo_el_reporte = service_soap_agro( $url, 'AutorizarUsuario', $parametros, 'AutorizarUsuarioResult' );
            $nivel =   ( $consulta_todo_el_reporte === 'SI' )? 2:'';
        } else if ( $i == 3 ) {
            $parametros = array( 'Login' => "$user", 'Funcion' => 'O.REPGG.SEL' );
            $consulta_todo_el_reporte = service_soap_agro( $url, 'AutorizarUsuario', $parametros, 'AutorizarUsuarioResult' );
            $nivel =  ( $consulta_todo_el_reporte === 'SI' )? 3:'';
        } else {
            $nivel = 0;
        }
        if ( $consulta_todo_el_reporte == 'SI' ) {
            break;
        }
    }
    return $nivel;
}

function php_function_ejecutar_service( $user ) {
    $url_service = 'http://192.168.6.68:8080/WSFacturas/WSFacturas.asmx?WSDL';
    $nivel_permiso =  php_function_perfileria( $user, $url_service );
    $palabra_permiso = array( 0=>'no tiene permisos', 1=>'General', 2=>'Individual', 3=>'Grupal' );
    return $nivel_permiso;
}

function php_function_ejecutar_login( $user_id, $pass_id ) {
    $url_service = 'http://192.168.6.68:8080/WSFacturas/WSFacturas.asmx?WSDL';
    $parametros = array( 'Login' => $user_id, 'Password' => $pass_id, 'Nivel' => 0 );
    $auth_permiso = service_soap_agro( $url_service, 'AutenticarUsuario', $parametros, 'AutenticarUsuarioResult' );
    return $auth_permiso;
}

/**
 * ESTA FUNCION ESTA PENSADA PARA SOLO PASAR USUARIO Y VALIDAR SERVICIO 1 TRUE , '' FALSE
 * 
 */
function php_function_consulta_permiso($parametros){
    $url = 'http://192.168.6.68:8080/WSFacturas/WSFacturas.asmx?WSDL';
    $parametros = array( 
            'Login'   => strval($parametros['usuario']) ,
            'Funcion' => strval($parametros['servicio']) 
         );
    $consulta_todo_el_reporte = service_soap_agro( $url, 'AutorizarUsuario', $parametros, 'AutorizarUsuarioResult' );
    $permiso_carga =   ( $consulta_todo_el_reporte === 'SI' )? 1:'';
    return $permiso_carga;
}


?>

