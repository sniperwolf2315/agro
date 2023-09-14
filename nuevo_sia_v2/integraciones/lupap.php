<?
/*
DEBE TENER CUIDADO AL EJECUTAR ESTE SERVICIO SI NO SE PARAMETRIZA BIEN VA TOMAR TODOS LOS REGISROS DE LA 
TABLA AGRCODIGOPOSTAL Y VA A ACUTLIZAR TODOS LOS REGISTROS

http://192.168.1.115/nuevo_sia_v2/integraciones/lupap.php
*/


include "../conection/conexion_sql.php";
include "../../_lupap.php";
include "../functions/general_functions.php";


$consql = new con_sql();
$ip_consulta = getRealIP() ;
$cuerpo_consulta = array();
$fecha_hora_hoy = date('Y-m-d H:i:s');

$consulta_actualizar ="
select
IdCP,
IdUsuario,
Direccion,
Ciudad
from agrCodigoPostal
where IdUsuario in (
select distinct IdUsuario FROM agrCodigoPostal
WHERE IdUsuario NOT IN ('-','#','0','0000','000000','1','10')
and ISNUMERIC(IdUsuario)=1
and actualizado = 0
GROUP BY IdUsuario
HAVING COUNT(IdUsuario)>1
)
and actualizado = 0
ORDER BY IdUsuario
";


$info =  $consql->consultar($consulta_actualizar);

$IdCP="";
$IdUsuario="";
$Direccion="";
$Dirnormalizada="";
$Localidad="";
$CodPostal="";
$Barrio="";
$Latitud="";
$Longitud="";
$Ciudad="";
$Departamento="";
$FechaRegistro="";

echo " El total es ".mssql_num_rows($info).'<br>';

while($info_actualizar = mssql_fetch_array($info)){

    $IdCP           =$info_actualizar[IdCP];
    $IdUsuario      =$info_actualizar[IdUsuario];
    $Direccion      =strtolower($info_actualizar[Direccion]);
    $Ciudad         =strtolower(remove_characters($info_actualizar[Ciudad]));

    echo "$IdCP | $IdUsuario | $Direccion | $Ciudad   <br>";

    // $response_lupap = geocodes($consql->consultar("select * from API_LOGS where DESC_LOG='API_LUPAP'"));
    // $response_lupaps = json_encode($response_lupap , true);
    $response_lupap =  geocode($Ciudad , $Direccion);
    $response_lupaps = json_decode(json_encode($response_lupap) , true);


        /*█ PASO 1 ████████████████████████████████████████████████████*/
    /* Crear las variables para facil manipulacion */
        $dirnormalizada  = $response_lupaps[0]["properties"]["address"];
        $localidad       = remove_characters($response_lupaps[0]["properties"]["admin4"]);
        $codPostal       = $response_lupaps[0]["properties"]["postcode"];
        $barrio          = remove_characters($response_lupaps[0]["properties"]["admin5"]);
        $latitud         = $response_lupaps[0]["geometry"]["coordinates"][1];
        $longitud        = $response_lupaps[0]["geometry"]["coordinates"][0];
        $ciudad          = remove_characters($response_lupaps[0]["properties"]["admin3"]);
        $departamento    = remove_characters($response_lupaps[0]["properties"]["admin2"]);

        $json          = json_encode($response_lupap, true);
        $insert_json     = "'$json'";

        /*█ PASO 2 ████████████████████████████████████████████████████*/
        if(count($response_lupap)>0){
            // echo "<br>$update_dire<br>";
            $update_dire = "UPDATE  agrCodigoPostal set Dirnormalizada ='$dirnormalizada',Localidad='$localidad ',CodPostal='$codPostal',Barrio='$barrio',Latitud =$latitud,Longitud=$longitud,Ciudad='$ciudad',Departamento='$departamento',JsonLupap='$json $fecha_hora_hoy',actualizado = 1 where idCP='$IdCP ' and IdUsuario ='$IdUsuario'";
            $consql->insertar($update_dire );
            
            // echo "<br>$insert_log<br>";
            $insert_log = "INSERT INTO API_LOGS (DESC_LOG,VALOR_LOG,HORA_REGISTRO,SERVICIO_ORIGEN,IP_ORIGEN)VALUES('API_LUPAP',$insert_json,getdate(),'CONSULTA_SERVICIO_LUPAP','$ip_consulta')";
            $consql->insertar($insert_log);
        }else{
            $update_dire = "UPDATE  agrCodigoPostal set actualizado = 1  where idCP='$IdCP ' and IdUsuario ='$IdUsuario'";
            $consql->insertar($update_dire );
        }
    }

    // $consql->insertar("update agrCodigoPostal set Ciudad= replace(replace(replace(replace(Ciudad,'BogotÃ¡ D.C.', 'Bogota D.C.'),'BogotEÃ?Â¡ D.C.','Bogota D.C.'),'Bogotá','Bogota'),'Bogota D.C.','Bogota'),Departamento= replace(replace(replace(replace(Departamento,'BogotÃ¡ D.C.', 'Bogota D.C.'),'BogotEÃ?Â¡ D.C.','Bogota D.C.'),'BogotÃ¡ D.C','Bogota D.C.'),'Bogotá D.C.','Bogota D.C.')");
    echo"OK";

function geocodes($lupap){
    while($info_lupa = mssql_fetch_array($lupap )){
        $json = $info_lupa[2];
        $rta = json_decode($json, true);
        return $rta;
}

}

/*
El total es 1
143954 | 080241946 | avenida calle 68 #57-39 apartamento 301 barrio modelo norte | bogota
El total es 1
143954 | 080241946 | avenida calle 68 #57-39 apartamento 301 barrio modelo norte | bogota
[
    {
        "type":"Feature",
        "geometry":
        {
            "type":"Point",
            "coordinates":[-74.080071101,4.6687340750001]},
            "properties":
            {
                "commonName":"AVENIDA GABRIEL ANDRADE",
                "country":"co",
                "address":"AC 68 # 57 - 39",
                "city":"bogota",
                "postcode":"111221",
                "accuracy":"rooftop",
                "admin1":"Colombia",
                "attribution":"lupap",
                "admin2":"Bogot\u00e1 D.C",
                "id":null,
                "admin5":"Popular Modelo",
                "admin3":"Bogot\u00e1 D.C.",
                "admin4":"Barrios Unidos"
            }
        }
    ]
*/


?>