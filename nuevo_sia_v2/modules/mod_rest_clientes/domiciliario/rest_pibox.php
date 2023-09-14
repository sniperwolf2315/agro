<!DOCTYPE html>
<html lang="en">
<head>
    <title>NUEVO SIA AGROCAMPO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<?php
include_once('../../../services/rest_pibox_service.php');/* IMPORTAMOS LA CLASE DE API_REST */
include('../../../environments/production.php');/* IMPORTAMOS LAS VARIABLES DE API_REST  */
include('../../../funciones.php');
require('../../../conection/conexion_sql.php');
require('funciones_dom.php');/* IMPORTAR FUNCIONES PARA ESTE MODULO */
// include_once( '../../services/json_formater_php.php' );/* IMPORTAMOS LA FUNCION JSON FORMATER */
session_start();


$con_sql = new con_sql( 'SQLFACTURAS' );
/** 1 =API , 0 SQL */
$modo_rapido = 0;

$ip_real       = $_POST['ip_real'];
$apellido1     = $_POST['Apellido1'];
$apellido2     = $_POST['Apellido2'];
$nombre1       = $_POST['Nombre1'];
$nombre2       = $_POST['Nombre2'];
$Genero        = $_POST['Genero'];
$Fecha         = $_POST['Fecha'];
$Sanguineo     = $_POST['Sanguineo'];
$empresa       = $_POST['empresa'];
$nacionalidad  = $_GET['nacion'];
$fecha_actual  = date('Y-m-d');
$fecha_actual2  = date('Y-m-d H:i:s');

echo "Hola Mensajero $empresa <br>";
/* VALIDAMOS LA NACIONALIDAD PARA EL TIPO DE DOCUMENTO DE IDENTIDAD */
if ($nacionalidad=='col'){
   $cedula        = $_POST['ced_domi'];
   if(!is_numeric(trim($_POST['ced_domi']))){
      /* REGISTRAMOS LOS DATOS INGRESADOS SI NO LOS ENCUENTRA PARA QUE SEGURIDAD REVISE QUE SUCEDE */
      $insert_ing_fall = ("INSERT INTO  API_INGRESOS_FALLIDOS (CEDULA,NOMBRE,FECHA_INGRESO,IPORIGEN)VALUES($cedula,'Intento fallido para: $nombre1 $nombre2 $apellido1 $apellido2','$fecha_actual2','$ip_real')");
      $con_sql->consultar($insert_ing_fall);

      msj_informacion('No ha escrito unsa cedula valida ingrese de nuevo','#E72020','error');
      echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";
      echo "<a href="."../domiciliario/ingreso_domiciliario.php".">Inicio</a> <br>";
      exit();
   }
}else{
   if(!is_numeric(trim($_POST['ced_domi']))){
      /* REGISTRAMOS LOS DATOS INGRESADOS SI NO LOS ENCUENTRA PARA QUE SEGURIDAD REVISE QUE SUCEDE */
      $insert_ing_fall = ("INSERT INTO  API_INGRESOS_FALLIDOS (CEDULA,NOMBRE,FECHA_INGRESO,IPORIGEN)VALUES($cedula,'Intento fallido para: $nombre1 $nombre2 $apellido1 $apellido2','$fecha_actual2','$ip_real')");
      $con_sql->consultar($insert_ing_fall);
      msj_informacion('No ha escrito unsa cedula valida ingrese de nuevo','#E72020','error');
      echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";
      echo "<a href="."../domiciliario/ingreso_domiciliario.php".">Inicio</a> <br>";
      exit();
   }
   $cedula       = ced_vene($_POST['ced_domi_1']);
}


if(strlen($cedula)<=4 ){
   echo"
   <script>swal('Este numero de identificacion no es valido'); </script>
   <meta http-equiv="."refresh"." content="."2;url=../domiciliario/ingreso_domiciliario.php".">
   ";
   return;
}



$JSON_DATA     = ["fiscal_number"=>"$cedula"];
$end_point     = 'driver_info?t=';

/** VALIDAMOS SI CONSULTAMOS EL ENDPOINT DEL PROVEEDOR O LA TABLA SQL QUE SE LLENA  */
if($modo_rapido==1){
   $rs 	         = API_REST::GET_BODY( $PROD_URL_PIBOX_DRIVER_INFO.$end_point ,$PROD_TOKEN_PIBOX, $JSON_DATA);
   $data_driver   = API_REST::JSON_TO_ARRAY($rs);
}else{
   // $consulta_driver=("SELECT * FROM API_ASIGNACION where CEDULA ='$cedula' and HORA_INGRESO like'$fecha_actual%'");
   $consulta_driver=("SELECT * FROM API_ASIGNACION where CEDULA ='$cedula'");
   $data_driver= mssql_fetch_array($con_sql->consultar($consulta_driver));
}


if(sizeof($data_driver) <=2){
   /** NO SE ENCONTRO EN PIBOX */
   
   
   $si_Existe_turno           = valida_registro_turno($con_sql,$cedula);
   if(valida_registro_turno($con_sql,$cedula)>0){
      msj_informacion('YA SE HA REGISTRADO SU TURNO ES:'.$si_Existe_turno,'#fd7f06','error');
      echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";
   }else{
      $ip_real_if       = $_POST['ip_real'];
      $empresa = 0;
      $insert_ing_fall = ("INSERT INTO  API_INGRESOS_FALLIDOS (CEDULA,NOMBRE,FECHA_INGRESO,IPORIGENM,DEPENDENCIA)VALUES($cedula,'Intento fallido para: $nombre1 $nombre2 $apellido1 $apellido2','$fecha_actual2','$ip_real_if','DOMICILIARIOS')");
      $con_sql->consultar($insert_ing_fall);
      msj_informacion('NO TIENE PEDIDOS ','#E72020','error');
      echo "<h1 style="."color:red;font-style:bold".">NO TIENE PEDIDOS</h1>"; 
      echo "<meta http-equiv="."refresh"." content="."3;url=../domiciliario/ingreso_domiciliario.php".">";
   }


}else{
   // $contador        = mssql_num_rows($con_sql->conectar("select id as cnt from API_REPARTIDORES where ESTADO in ('ESPERA','CARGA')"));
   $contador        = mssql_fetch_array($con_sql->conectar("select max(TURNO) as cnt from API_REPARTIDORES where ESTADO in ('ESPERA','CARGA','SALIDA') and year(HORA_INGRESO)=year(GETDATE()) and month(HORA_INGRESO)=month(GETDATE()) and day(HORA_INGRESO) = day(GETDATE())"));
   $contador        = $contador[0];
   $esta_en_lista   = ($con_sql->consultar("select TURNO from API_REPARTIDORES where ESTADO in ('ESPERA','CARGA','SALIDA') and year(HORA_INGRESO)=year(GETDATE()) and month(HORA_INGRESO)=month(GETDATE()) and day(HORA_INGRESO) = day(GETDATE()) order by TURNO,HORA_INGRESO"));
   
   $contador= (in_array(strval($contador),$esta_en_lista ) )?$contador+2:$contador+1;
   /* 1= ENDPOINT , 0 = SQLSERVER */


   if($modo_rapido==1){
      $driver_placas   = $data_driver[vehicle_plate];
      $driver_paquete  = count($data_driver[bookings]);
      $cedular='';
      foreach($data_driver['bookings'] as $pedido ){
         $driver_pedido= count($data_driver[bookings]);
        }
      $cantidad_paquetes = 0;


   }else{
      /**llamamos de la tbla API_ASIGNACION */
      list( $driver_nom,  $nombre2 , $apellido1 , $apellido2 )  = explode(" ",$data_driver[NOMBRE]);
      $driver_placas       = $data_driver[PLACA];
      $driver_paquete      = count($data_driver[ID_PEDIDO_PROV]);
      $cedular             = $data_driver[CELULAR];
      $driver_pedido       = $data_driver[ID_PEDIDOS_AGRO];
      $cantidad_paquetes   = $data_driver[CANTIDAD_PED_AGRO];
      $empresa             = $data_driver[EMPRESA]; 
      $id_pedido_prov      = $data_driver[ID_PEDIDO_PROV]; 
   }
   $ip_real_t       = $_POST['ip_real'];

   $driver_cedula             = $cedula;
   $capacidad_por_ventanilla  = mssql_fetch_array($con_sql->consultar("SELECT valor FROM API_CONFIGURACION where campo='CUPOS BAHIA' and id =2"));
   $capacidad_por_ventanilla  = $capacidad_por_ventanilla[0];
   $ventanilla                = consultar_turno($con_sql,$capacidad_por_ventanilla);/** ESTA FUNCION VALIDA LA CAPACIDAD POR VENTANILLA */
   $si_Existe_turno           = valida_registro_turno($con_sql,$driver_cedula);

   echo "<br> El domiciliario $driver_nom con identificación $cedula en el vehiculo de placas: $driver_placas si tiene $driver_paquete  pedidos. $driver_pedido ";
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
      CELULAR      ,
      CANTIDAD     ,
      TIPO_DOMICILIO,
      IPORIGEN      ,
      ID_CODIGO_CREACION
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
          '$empresa',
          '',
          ' ',
          '$cedular',
           $cantidad_paquetes
           ,'PREPAGADO'
           ,'$ip_real_t'
           ,'$id_pedido_prov '
      )";
      if(valida_registro_turno($con_sql,$driver_cedula)>0){
         msj_informacion('YA SE HA REGISTRADO SU TURNO ES:'.$si_Existe_turno,'#fd7f06','error');
         $con_sql->insertar("delete from API_ASIGNACION where cedula='$driver_cedula' and empresa='$empresa'");
      }else{
         $con_sql->insertar($consulta);
         msj_informacion('BIENVENIDO SE HA REGISTRADO SU TURNO ES:'.$contador,'#349D0A','success');
         $con_sql->insertar("delete from API_ASIGNACION where cedula='$driver_cedula' and empresa='$empresa'");
      }
      echo "<meta http-equiv="."refresh"." content="."15;url=../domiciliario/ingreso_domiciliario.php".">";
      echo "<hr><br><a href="."../domiciliario/ingreso_domiciliario.php".">Inicio</a> <br>";
        return;
      }
      require('rest_recaudo.php');
      //   require('rest_rapiboy.php');
      
      /* SOLO HABILITAR SI SE VA A CONSULTAR POR API - RECUERDE QUE EL MODULO ADMIN PUEDE RECARGAR TODA LA INFOMRACION  DESDE LA OPCION "NO LO ENCUENTRO" */
      /*   //  require('rest_quick.php');  */
      // echo "<hr><br><a href="."../domiciliario/ingreso_domiciliario.php".">Inicio</a> <br>";

?>

