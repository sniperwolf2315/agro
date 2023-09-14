<?PHP
/*
http://192.168.6.55/nuevo_sia_v2/services/svc_repogramar_visitantes.php
*/
include('../conection/conexion_sql.php');
$conn = new con_sql();
$consultar_agendas_pendientes =("SELECT DISTINCT
Nombre
,Cedula
,Area
,Jefe_inmedato
,Jornada_programada
,ACTIVIDAD
,AREA_CARGUE
,USUARIO_CARGUE
,CANTIDAD_REINGRESOS
,MIN(ID) AS ID
from AGENDA_VISITANTES_REPRO
GROUP BY 
Nombre
,Cedula
,Area
,Jefe_inmedato
,Jornada_programada
,ACTIVIDAD
,AREA_CARGUE
,USUARIO_CARGUE
,CANTIDAD_REINGRESOS
");
$rta_pendientes_agenda = $conn->consultar($consultar_agendas_pendientes);
while($datos_agenda = mssql_fetch_array($rta_pendientes_agenda)){
    $nombre=                $datos_agenda[0];
    $cedula=                $datos_agenda[1];
    $area=                  $datos_agenda[2];
    $jefe_inmedato=         $datos_agenda[3];
    $jornada_programada=    $datos_agenda[4];
    $actividad=             $datos_agenda[5];
    $area_cargue=           $datos_agenda[6];
    $usuario_cargue=        $datos_agenda[7];
    $cantidad_reingresos=   $datos_agenda[8];
    $id_insert=             $datos_agenda[9];

    /*  1. PREPARAMOS LA CONSULTA PARA INSERTAR EN LA TABLA AGENDA DE VISITANTES */
    $sql_insert_visita = "INSERT INTO AGENDA_VISITANTES(Nombre,Cedula,Area,Jefe_inmedato,Jornada_programada,ACTIVIDAD,AREA_CARGUE,USUARIO_CARGUE,CANTIDAD_REINGRESOS)VALUES('$nombre',$cedula,'$area','$jefe_inmedato','$jornada_programada','$actividad','$area_cargue','INTEGRACION',$cantidad_reingresos)";
    // echo "$sql_insert_visita <br> <br> <br>";
    $conn->insertar($sql_insert_visita);
    
    
    /*  2. PREPARAMOS LA CONSULTA PARA BORRAR DE LA TABLA AGENDA DE VISITANTES REPROGRAMADOS */
    $sql_delete_repro  = "DELETE FROM dbo.AGENDA_VISITANTES_REPRO where id = $id_insert and CEDULA= $cedula";
    // echo "$sql_delete_repro <br> <br> <br>";
    $conn->consultar($sql_delete_repro );
}
/* *OJO ESTA CONSULTA A LA MEDIA NOCHE VA A CAMBIA EL ESTADO A SALIDA DE LA TABLA REGISTRO_VISITANTES */
// $sql_update_visita =("UPDATE REGISTRO_VISITANTES SET ACTIVO=0 where cedula='1018486920'");
$sql_update_visita =("UPDATE REGISTRO_VISITANTES SET ACTIVO=0");
$conn->consultar($sql_update_visita );


/* SI LLEGAN A EXISITIR REGISTROS DUPLICADOS EN LA TABLA DE AGENDA_VISITANTES SE ELIMINAN A LA MEDIA NOCHE  */
$sql_delete_duplicados ="
WITH C AS
 (
  SELECT 
   NOMBRE
  ,AREA
  ,Jefe_inmedato
  ,JORNADA_PROGRAMADA
  ,ACTIVIDAD
  ,AREA_CARGUE
  ,USUARIO_CARGUE
  ,CANTIDAD_REINGRESOS
  ,ROW_NUMBER() OVER (PARTITION BY CEDULA ORDER BY CEDULA) AS DUPLICADO
  FROM AGENDA_VISITANTES 
 )
 DELETE FROM C WHERE DUPLICADO > 1;
";
$conn->consultar($sql_delete_duplicados );

$conn->cerrar($conn);
mssql_close();
echo "<center>Todo OK </center>";
?>