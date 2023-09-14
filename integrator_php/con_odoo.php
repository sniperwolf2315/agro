<?php 

// $conn_string = "host=178.128.153.74 port=5432 dbname=agrocampo user=agrocampo password=Agrocampo2022! options='--client_encoding=UTF8'";
// $conn_string = "host=200.7.102.222 port=5432 dbname=agrocampo user=agrocampo password=Agro2023!. options='--client_encoding=UTF8'";
$conn_string = "host=200.7.102.222 port=5499 dbname=agrocampo user=agrocampo password=Agro2023!. options='--client_encoding=UTF8'";

$dbconn = pg_connect($conn_string);
if(!$dbconn) {
    echo "Error: No se ha podido conectar a la base de datos\n";
} else {
    echo "Conexión exitosa\n";
}
// agregamos los encabezados correspondientes a la respuesta
//  un paso muy improtante que todos se saltean
http_response_code(200);
header("Content-type:application/json");

// codificar la respuesta en formato JSON
// echo json_encode($resutado);
pg_close($dbconn);
?>