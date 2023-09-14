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
include_once ('../../../services/rest_pibox_service.php');/* IMPORTAMOS LA CLASE DE API_REST */
include      ('../../../environments/production.php');/* IMPORTAMOS LAS VARIABLES DE API_REST  */
include      ('../../../environments/develop.php');/* IMPORTAMOS LAS VARIABLES DE API_REST  */

/**
 // include('./funciones_dom.php');
 // include_once( '../../services/json_formater_php.php' );/* IMPORTAMOS LA FUNCION JSON FORMATER 
 include      ('../../../conection/conexion_sql.php');
 **/


session_start();
$con_sql = new con_sql( 'sqlFacturas' );
$ip_real       = $_POST['ip_real'];
$apellido1     = $_POST['Apellido1'];
$apellido2     = $_POST['Apellido2'];
$nombre1       = $_POST['Nombre1'];
$nombre2       = $_POST['Nombre2'];
$Genero        = $_POST['Genero'];
$Fecha         = $_POST['Fecha'];
$Sanguineo     = $_POST['Sanguineo'];
$empresa       = 'RECAUDO';
$nacionalidad  = $_GET['nacion'];


/* SE LLAMA REST PIBOS SERVICE PERO ALOJA EL METODO GET POSTP PUT PATCH DELETE DE TODOS */
// $end_point     = '/InfoRepa';
// $JSON_DATA     = ["Documento"=>$cedula];
// $rs 	         = API_REST::GET_BODY_HEADER( $PROD_URL_RAPIBOY .$end_point, $PROD_TOKEN_RAPIBOY, $JSON_DATA);
// $data_driver   = API_REST::JSON_TO_ARRAY($rs);
// $emp = (sizeof($data_driver )>2)? 'RAPIBOY':'';
$consultas_rec   = ("select * from API_RECAUDOS where cedula='$cedula'");
$data_driver_rec = $con_sql->consultar($consultas_rec); 
$data_driver_rec =mssql_fetch_array($data_driver_rec);

if(sizeof($data_driver_rec)<=2){
   $empresa = 0;
//   echo 'No se encontro en MENSAJERO<br>';  
 
}else{
   //  echo 'Se encontro en MENSAJERO<br>'; 
   // $contador = mssql_num_rows($con_sql->conectar("select id as cnt from API_REPARTIDORES where ESTADO='ESPERA'"));
   // $contador = $contador + 1;
   $contador        = mssql_fetch_array($con_sql->conectar("select max(TURNO) as cnt from API_REPARTIDORES where ESTADO in ('ESPERA','CARGA','SALIDA') and year(HORA_INGRESO)=year(GETDATE()) and month(HORA_INGRESO)=month(GETDATE()) and day(HORA_INGRESO) = day(GETDATE())"));
   $contador        = $contador[0];
   $esta_en_lista   = ($con_sql->consultar("select TURNO from API_REPARTIDORES where ESTADO in ('ESPERA','CARGA','SALIDA') and year(HORA_INGRESO)=year(GETDATE()) and month(HORA_INGRESO)=month(GETDATE()) and day(HORA_INGRESO) = day(GETDATE()) order by TURNO,HORA_INGRESO"));
   
   $contador= (in_array(strval($contador),$esta_en_lista ) )?$contador+2:$contador+1;
   /* 1= ENDPOINT , 0 = SQLSERVER */



   $driver_emp     = $data_driver_rec[EMPRESA];
   $driver_nom     = $data_driver_rec[DOMICILIARIO];
   $driver_placas  = $data_driver_rec[PLACA];
   $driver_pedido  = $data_driver_rec[RUTA];
   $driver_cedula  = $cedula;
   // $capacidad_por_ventanilla=15;
   $capacidad_por_ventanilla  = mssql_fetch_array($con_sql->consultar("SELECT valor FROM API_CONFIGURACION where campo='CUPOS BAHIA' and id =2"));
   $capacidad_por_ventanilla  = $capacidad_por_ventanilla[0];
   $ventanilla      = consultar_turno($con_sql,$capacidad_por_ventanilla);/** ESTA FUNCION VALIDA LA CAPACIDAD POR VENTANILLA */
   $si_Existe_turno = valida_registro_turno($con_sql,$driver_cedula);
  
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
      TIPO_DOMICILIO,
      IPORIGEN
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
          '$driver_pedido',
          '$driver_emp',
          '',
          'INGRESO DOMICILIARIO',
          'RECAUDO'
          ,'$ip_real'
      )";
      if(valida_registro_turno($con_sql,$driver_cedula)>0){
         msj_informacion('YA SE HA REGISTRADO SU TURNO ES:'.$si_Existe_turno,'#E72020','error');
         $con_sql->insertar("delete from API_RECAUDOS where cedula='$driver_cedula' and empresa='$driver_emp'");
         $con_sql->insertar("delete from API_ASIGNACION where cedula='$driver_cedula' and empresa='$driver_emp'");
      }else{


         $con_sql->insertar($consulta);
         /* UNA VEZ SE ENCUENTRA EN LA TABLA Y SE INSERTA DE ELIMINA PAR QUE NO SE CRUCE CON OTRO HORARIO */
         msj_informacion('BIENVENIDO SE HA REGISTRADO SU TURNO ES:'.$contador,'#349D0A','success');
         $con_sql->insertar("delete from API_RECAUDOS where cedula='$driver_cedula' and empresa='$driver_emp'");
         $con_sql->insertar("delete from API_ASIGNACION where cedula='$driver_cedula' and empresa='$driver_emp'");
      }
      die();
   }
   // echo "<hr><br><a href="."../domiciliario/ingreso_domiciliario.php".">Inicio</a> <br>";
   // echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";


?>

