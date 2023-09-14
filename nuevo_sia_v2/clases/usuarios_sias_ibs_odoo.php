<?php
require( '../conection/conexion_sql.php' );
require( '../conection/conexion_ibs.php' );
require( '../conection/conexion_pssql.php' );


$us= $_GET['us'];
// if ( session_status() === 1 ) {session_start();}
$array_user_sia_old = [];
$array_user_ibs_old = [];
$array_user_sia_old_name = [];
$array_user_ibs_old_name = [];


/* usuario sql */
$con_sql = new con_sql( 'SQLFACTURAS' );
$data_tlb = $con_sql->conectar( "select distinct USUARIO,NOMBRES,APELLIDO from  VIS_PERFILERIA " );
echo ($data_tlb)?'✔<br>':'❌<br>';
while($data_rta = mssql_fetch_array($data_tlb)){
    array_push($array_user_sia_old,$data_rta[0]);
    array_push($array_user_sia_old_name,strtoupper($data_rta[1]).' '.strtoupper($data_rta[2]));
}
/* usuario IBS */
$con_ibs = new con_ibs( 'CIFUENTESE','CIFUENTESE' );
$data_tlb_ibs = $con_ibs->conectar( "SELECT UPUSER, UPDESC from AGR620CFAG.SRBUSP  AS TBL_1 INNER JOIN DIAZH.USR_LIST AS TBL_2 ON TBL_1.UPUSER = TBL_2.USER_NAME" );
echo ($data_tlb_ibs)?'✔<br>':'❌<br>';
// odbc_result_all($data_tlb_ibs);
while( $data_ibs = odbc_fetch_array($data_tlb_ibs)){
    array_push($array_user_ibs_old,$data_ibs['UPUSER']);
    array_push($array_user_ibs_old_name,$data_ibs['UPDESC']);
}




$similares = array_intersect($array_user_sia_old, $array_user_ibs_old);
$similares_name = array_intersect($array_user_sia_old_name, $array_user_ibs_old_name);
echo "<br>Coinciden por usuario ".count($similares).'<br>';
// var_dump( $similares);


echo "<br>Coinciden por nombre ".count($similares_name).'<br>';
// var_dump( $similares_name);

$no_similares = array_diff($array_user_sia_old, $array_user_ibs_old);
$no_similares_name = array_diff($array_user_sia_old_name, $array_user_ibs_old_name);
echo "<br>No coinciden por usuario ".count($no_similares).'<br>';
// var_dump( $no_similares);

echo "<br>No coinciden por nombre ".count($no_similares_name).'<br>';
// var_dump( $no_similares_name);


$dest=[$array_user_sia_old,$array_user_ibs_old];
unset($dest);
$con_sql->cerrar( $con_sql );
$con_sql->cerrar( $con_ibs );

?>