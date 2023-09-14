<?php
include( '../../conection/conexion_sql.php' );

$conec = new con_sql( 'sqlfacturas' );
$query_sql = ( 'select * from VIS_PERFILERIA' );
$rta_data =  $conec->conectar( $query_sql );
while( $a = mssql_fetch_array($rta_data)){
    echo '<b>IDUSUARIO	ESTADO	USUARIO	PERFIL	PERMISOS	Nombre	Descripcion	Codigo </b><br> ' ;
    echo $a[0].'_|_'.$a[1].'_|_'.$a[2].'_|_'.$a[3].'_|_'.$a[4].'_|_'. $a[5].'_|_'.$a[6].'_|_'.$a[7].'_|_'.'<br>';
}
mssql_close($conect);

?>