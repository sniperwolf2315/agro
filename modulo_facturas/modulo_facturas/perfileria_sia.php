<?php
 include('../../nuevo_sia_v2/services/ws_services_soap.php');
/**
 * 06-10-2022
 * se establece este arreglo de perfiles temporales permitidos para el check de registro de carga
 */
$parametros=[
"usuario"=>$_SESSION['usuARioF'],
"servicio"=>"R.FACT.REGC"
];
$permiso = php_function_consulta_permiso($parametros);

/** LISTA DE USUARIOS 
*/
$usuarios_permitidos_seg=[
    'CHACONY',
    'IBARGUENE',
    'MOLINAH',
    'MONTANAL',
    'PINEROSM',
    'RAMIREZB',
    'RAMOSL',
    'VALENCIAY',
    'MUNOZJ',
    'PEREZA',
    'JIMENEZJ',
    'SALGADOR30',
    'AGUIRRED',
    'VILLALBAA',
    'PACHECOI',
    'SALGADOR',
    'MELENDEZJ',
    'BERRIOM'
];

$usuarios_permitidos_aud=[
 'RODRIGUEZJ',
 'FRANCOC',
 'CAROJ',
 'MEDINAB',
 'BORDAL',
 'SUAREZR',
 'SUAREZA',
 'FACTURAS',
 'TERMINAL',
 'RONDONM'
];

?>