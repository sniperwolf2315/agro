<?php
session_start();

include( '../../conection/conexion_ibs.php' );
$usuario = $_SESSION[ 'clAVe' ];
$pass = $_SESSION[ 'clAVe' ];
$con_ibs = new con_ibs( $usuario, $pass );
$sql_ibs = ("SELECT UPUSER, UPDESC, UPHAND, UPEQGR, UPNEOP from AGR620CFAG.SRBUSP  AS TBL_1 INNER JOIN DIAZH.USR_LIST AS TBL_2 ON TBL_1.UPUSER = TBL_2.USER_NAME" );
$result = $con_ibs->conectar( $sql_ibs );

echo ( odbc_num_rows( $result ) == 0 )?'No hay datos para mostrar <br> ' :'<br>';
// echo odbc_result_all( $result );
while( $row = odbc_fetch_array( $result ) ) {
    echo $row[ 'UPUSER' ].' '.$row[ 'UPHAND' ].' '.$row[ 'UPDESC' ].''. '<br>' ;
}

?>