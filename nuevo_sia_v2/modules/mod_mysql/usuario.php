<?php
// phpinfo();
include( '../../conection/conexion_mysql.php' );

$conec = new con_mysql( 'agrobase' );
$query_sql =  'select * from TABLE60';
$rta_data =  $conec->conectar( $query_sql );
while( $a = mysqli_fetch_array($rta_data)){
    // echo $a[0].'_|_'.$a[1].'_|_'.$a[2].'_|_'.$a[3].'_|_'.$a[4].'_|_'. $a[5].'_|_'.$a[6].'_|_'.$a[7].'_|_'.'<br>';
    echo $a[0].'<br>';
}

?>