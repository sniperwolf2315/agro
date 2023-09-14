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


echo "ESTAMOS EN QUICK <br>";
session_start();
$con_sql = new con_sql( 'SQLFACTURAS' );



$apellido1     = $_POST['Apellido1'];
$apellido2     = $_POST['Apellido2'];
$nombre1       = $_POST['Nombre1'];
$nombre2       = $_POST['Nombre2'];
$Genero        = $_POST['Genero'];
$Fecha         = $_POST['Fecha'];
$Sanguineo     = $_POST['Sanguineo'];
$empresa       = 'QUICK';
$nacionalidad  = $_GET['nacion'];

/* VALIDAMOS LA NACIONALIDAD PARA EL TIPO DE DOCUMENTO DE IDENTIDAD */
if ($nacionalidad=='col'){
   $cedula        = $_POST['ced_domi'];
   if(!is_numeric(trim($_POST['ced_domi']))){
      
      echo "No ha escrito unsa cedula valida ingrese de nuevo <br>";
      echo "<a href="."../domiciliario/ingreso_domiciliario.php".">Inicio</a> <br>";
      exit();
   }
}else{
   $cedula        = $_POST['ced_domi_1'];
   $cedula       = ced_vene($cedula);
}

/* driver info swolo para cuando pasa la cedula, si no tiene pedidos pedir info al vigilante
   ver info del vendedor y endpoint de pedido
*/
/** OBTENES DESDE EL NUMERO DE CEDULA DEL CLIENTE SI EL ENDPOINT TIENE RESPONSE TRUE */
//   echo "<br> /GET driver<br>";

if(strlen($cedula)<5 ){

   echo"<script>swal('Este numero de identificacion no es valido'); </script>";
   echo "<meta http-equiv="."refresh"." content="."2;url=../domiciliario/ingreso_domiciliario.php".">";
   return;
}





if($empresa=='QUICK'){
  $JSON_DATA     = json_encode(["fiscal_number"=>"$cedula"]);
  $end_point     = 'driver_info?t=';
  $rs 	        = API_REST::GET_BODY( $PROD_URL_PIBOX_DRIVER_INFO.$end_point ,$PROD_TOKEN_PIBOX, $JSON_DATA);
  $data_driver   = API_REST::JSON_TO_ARRAY($rs);
 
if(count($data_driver)==0 || sizeof($data_driver)== 1){
  echo '🎇';  
  $contador = mssql_num_rows($con_sql->conectar("select * from API_REPARTIDORES"));
  $contador = $contador+1;

  $driver_nom     = 'Pruebas'.$contador ;
  $driver_placas  = 'ABC12'.$contador;
  $driver_pedido  = '6307a84e0e0416001ed3bf5f';
  $driver_cedula  = $cedula;
  $_SESSION['id_domiciliario']= $cedula;
  
  
  echo "El domiciliario $driver_nom con identificación $driver_cedula en el vehiculo de placas: $driver_placas si tiene pedidos. ";

//   echo "<script> swal('Su turno es: ".$contador."')</script> ";
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
   EMPRESA
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
       $contador,
       1,
       'ESPERA',
       '$driver_pedido',
       '$empresa'
   )";
//   $con_sql->insertar($consulta);
//   echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";
     /*ESTE ELSE SE CUMPLE CUANDO NO ESTA HABILITADO EL SERVICIO DE PIBOX */
}else{
   $contador = mssql_num_rows($con_sql->conectar("select * from API_REPARTIDORES"));
   $contador = $contador+1;
   $driver_nom     = $data_driver[name];
   $driver_placas  = $data_driver[vehicle_plate];
   $driver_pedido  = $data_driver[booking];  
   $driver_paquete = $data_driver[packages];
   $driver_cedula  = $cedula;

   echo "El domiciliario $driver_nom con identificación $cedula en el vehiculo de placas: $driver_placas si tiene pedidos. ";
  
 
   echo "<script> swal('Su turno es: ".$contador."')</script> ";
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
          $contador,
          1,
          'ESPERA',
          '$driver_pedido',
          '$empresa'
          ,'PREPAGADO'
      )";
      $con_sql->insertar($consulta);
      echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";
   
}


}





?>

