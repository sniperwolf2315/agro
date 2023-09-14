<!DOCTYPE html>
<html lang="en">
<head>
    <title>NUEVO SIA AGROCAMPO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
<?php
include_once('../../../services/rest_pibox_service.php');/* IMPORTAMOS LA CLASE DE API_REST */
include('../../../environments/production.php');/* IMPORTAMOS LAS VARIABLES DE API_REST  */
include('../../../environments/develop.php');/* IMPORTAMOS LAS VARIABLES DE API_REST  */
// include('./funciones_dom.php');
// require('../../../conection/conexion_sql.php');
// include_once( '../../services/json_formater_php.php' );/* IMPORTAMOS LA FUNCION JSON FORMATER */
session_start();
$con_sql = new con_sql( 'SQLFACTURAS' );

$apellido1     = $_POST['Apellido1'];
$apellido2     = $_POST['Apellido2'];
$nombre1       = $_POST['Nombre1'];
$nombre2       = $_POST['Nombre2'];
$Genero        = $_POST['Genero'];
$Fecha         = $_POST['Fecha'];
$Sanguineo     = $_POST['Sanguineo'];
// $empresa       = $_POST['empresa'];
$empresa       = 'RAPIBOY';
$nacionalidad  = $_GET['nacion'];

/* SE LLAMA REST PIBOS SERVICE PERO ALOJA EL METODO GET POSTP PUT PATCH DELETE DE TODOS */
$end_point     = '/InfoRepa';
$JSON_DATA     = ["Documento"=>$cedula];
$rs 	         = API_REST::GET_BODY_HEADER( $PROD_URL_RAPIBOY .$end_point, $PROD_TOKEN_RAPIBOY, $JSON_DATA);
$data_driver   = API_REST::JSON_TO_ARRAY($rs);
$emp = (sizeof($data_driver )>2)? 'RAPIBOY':'';

if(sizeof($data_driver)<=2){
   $empresa = 0;
//   echo 'No se encontro en RAPIBOY<br>';  
 
}else{
   /*ESTE ELSE SE CUMPLE CUANDO NO ESTA HABILITADO EL SERVICIO DE PIBOX */
   echo 'Se encontro en RAPIBOY<br>'; 
   $contador = mssql_num_rows($con_sql->conectar("select id as cnt from API_REPARTIDORES where ESTADO='ESPERA'"));
   $contador = $contador + 1;
  
   $driver_nom     = $data_driver[Nombre];
   $driver_placas  = $data_driver[Patente];
   $driver_placas  = ($driver_placas=="")?'SIN PALCAS INTEG':$driver_placas; 
   $driver_pedido  = $data_driver[Viajes];
   $driver_cedula  = $cedula;
   $capacidad_por_ventanilla=15;
   $ventanilla      = consultar_turno($con_sql,$capacidad_por_ventanilla);/** ESTA FUNCION VALIDA LA CAPACIDAD POR VENTANILLA */
   $si_Existe_turno = valida_registro_turno($con_sql,$driver_cedula);
   $driver_pedidos='';
   foreach ($driver_pedido as $val_ped) {
      $driver_pedidos .= $val_ped[Referencia].',';
   }   
   $driver_pedidos = substr($driver_pedidos,0,-1);
   echo "El domiciliario $driver_nom con identificación $cedula en el vehiculo de placas: $driver_placas si tiene $driver_pedido pedidos. ";

   
   $consulta = "insert into dbo.API_REPARTIDORES(
      CEDULA		 ,
      APELLIDO_1   ,
      APELLIDO_2	 ,
      NOMBRE_1	    ,
      NOMBRE_2	    ,
      NACIONALIDAD ,
      PLACA        ,
      HORA_INGRESO ,
      HORA_SALIDA  ,
      TIEMPO_TOTAL ,
      TURNO        ,
      VENTANILLA   ,
      ESTADO       ,
      PEDIDO       ,
      EMPRESA      ,
      HORA_CARGA   ,
      DESCRIPCION  ,
      TIPO_DOMICILIO
      )values(
         $driver_cedula,
         '$apellido1',
         '$apellido2',
         '$driver_nom',
         '$nombre2',
         '$nacionalidad',
         '$driver_placas',
          GETDATE(),
          '',
          '0',
          '$contador',
          $ventanilla,
          'ESPERA',
          '$driver_pedidos',
          'RAPIBOY',
          '',
          'INGRESO DOMICILIARIO',
          'PREPAGADO'
      )";
      if(valida_registro_turno($con_sql,$driver_cedula)>0){
         msj_informacion('YA SE HA REGISTRADO SU TURNO ES:'.$si_Existe_turno,'#E72020','error');
         // echo$consulta;
      }else{
         // echo$consulta;
         $con_sql->insertar($consulta);
         msj_informacion('BIENVENIDO SE HA REGISTRADO SU TURNO ES:'.$contador,'#349D0A','success');
      }
   }
   // echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";
   // echo "<hr><br><a href="."../domiciliario/ingreso_domiciliario.php".">Inicio</a> <br>";


?>

