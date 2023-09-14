<body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
echo  " <title> Validando Ingreso </title>";
error_reporting(0);
header("X-Powered-By: ASP.NET");
require('../../conection/conexion_sql.php');
include('../../funciones.php');
include('funciones.php');
// $activa_tmp='_TMP';


session_start();


$con_sql       = new con_sql( 'SQLFACTURAS' );
/** VARIABLES QUE CAPTURAMOS DEL FORMUALARIO */
$turno          = $_POST['turno'];
$jefe_inmediato = $_POST['jefe'];
$identifiacion  = $_POST['identificacion'];
$apellido1      = $_POST['apellidou'];
$apellido2      = $_POST['apellidod'];
$nombre1        = $_POST['nombreu'];
$nombre2        = $_POST['nombred'];
$Genero         = $_POST['genero'];
$Fecha          = $_POST['fechanc'];
$Sanguineo      = $_POST['sanguineo'];
$ip_real        = $_POST['ip'];
$ingreso_agr    = $_POST['ingreso_agr'];


$fecha_actual   = date('Y-m-d');
$fecha_actual2  = date('Y-m-d H:i:s');
$ipreal=getRealIP();



/* VALIDAMOS QUE LA CEDULA SOLO CONTENGA NUMEROS Y QUE NO SEA ALGANUMERICO*/
if(!is_numeric($identifiacion)){
   msj_informacion('DOCUMENTO NO VALIDO ','#E72020','error');
   echo "<meta http-equiv="."refresh"." content="."2;url=index-ingresos.php".">";
   return;
}

$cedula        = intval($identifiacion);

// VALIDAMOS QUE LA CEDULA NO SEA MENOS A 4 DIGITOS Y QUE SEA SOLO VALOR NUMERICO
if(strlen($cedula)<=4 || !is_numeric($identifiacion) ){
    echo '<div class="alert alert-primary" role="aler">No ha escrito una cedula valida ingrese de nuevo</div> ';
     echo "<meta http-equiv="."refresh"." content="."3;url=index-ingresos.php".">";
    echo "<a href="."index-ingresos.php".">Inicio</a> <br>";
    return;
 }

   
 /** CONSULTAMOS QUE ESTE EN LA TABLA DE AGENDA VISITANTES O EN DEFECTO QUE BUSQUE SI YA ESTA EL REGISTROS ACTIVO */
  $consulta_driver=("SELECT * FROM AGENDA_VISITANTES where CEDULA ='$cedula'");
//  $consulta_driver=("SELECT * FROM AGENDA_VISITANTE_TMP where CEDULA ='$cedula'");

$consulta_temporal= mssql_fetch_array($con_sql->consultar($consulta_driver));
 
 if(sizeof($consulta_temporal) <=2){
    // echo"va por esta";    
    $consulta_driver=("SELECT * FROM REGISTRO_VISITANTES where CEDULA ='$cedula' and Activo =1");
    $consulta_temporal= mssql_fetch_array($con_sql->consultar($consulta_driver));
   }
/* SI PASADO EL FILTRO NO RETORNA INORMACION SE REDIRIGE AUTOMATICAMENTE AL INICIO */

if(sizeof($consulta_temporal) <=2){
   /** NO SE ENCONTRO EL VISITANTE */
   $sql_falling=("insert into API_INGRESOS_FALLIDOS (CEDULA,NOMBRE,FECHA_INGRESO,IPORIGEN,DEPENDENCIA)VALUES('$cedula','$apellido1 $apellido1 $nombre1   $nombre2','$fecha_actual2','$ipreal','INGRESOS SAB' ) ");
   $con_sql->insertar($sql_falling);
   msj_informacion('NO TIENE PERMISO ','#E72020','error');
   echo "<center><h1 style="."color:red;font-style:bold".">NO TIENE PERMISO DE INGRESAR</h1></center>"; 
   echo "<meta http-equiv="."refresh"." content="."2;url=index-ingresos.php".">";
   echo "<hr><br><a href="."index-ingresos.php".">Inicio</a> <br>";
   
}else{
   $id             = $consulta_temporal[0];
   $nombre         = $consulta_temporal[1];
   $area           = $consulta_temporal[3];
   $jefe_inmediato = $consulta_temporal[4];
   $jornada        = strval($consulta_temporal[5]);
   $actividad      = $consulta_temporal[6];
   $area_agenda    = $consulta_temporal[7];

   if (strlen($jornada)<='13'){
      $jornada = trim($jornada);
   }else{
      $fecha_zapier = str_replace('{','',str_replace('[','',str_replace(']','',str_replace('}','',$jornada))));
      $fecha_zapier = explode(",",$fecha_zapier);
      $fecha_zapier_d = explode(":",$fecha_zapier[2]);
      $fecha_zapier_h = explode(":",$fecha_zapier[3]);

      $jornada = ($fecha_zapier_d[1]).' -'. ($fecha_zapier_h[1]);
      $jornada  = trim(str_replace('"','',$jornada));
   }
 
   /** SE VALIDA LA FUNCION PARA CADA UNA DE LAS OPCIONES
      INGGRESO
      SALIDA ALMUERZO
      ENTRADA ALMUERZO
      SALIDA
   */
   if($turno=="Ingreso"){
      // echo"1<br>";

      $sql_reg_temprales = ("select Cedula from REGISTRO_VISITANTES where cedula='$cedula' and (Hora_ingreso) is not null and (Hora_salida) is null and Activo =1");
      $ya_existe = mssql_num_rows($con_sql->consultar($sql_reg_temprales));
      $existe = ($ya_existe=='0')?'FALSE':'TRUE';

      /* VALIDAMOS QUE YA NO ESTE REGISTRADO PARA NO DUPLICAR EL INGRESO POR DIA POR DIA  */
      if( $existe=='TRUE') {
        msj_informacion('YA TIENE REGISTRO DE INGRESO CONTACTE A: '.$jefe_inmediato .' AREA: '.$area,'#fd7f06','success');
      }else{
         $ipreal=getRealIP();
         $sql_reg_temprales = ("INSERT INTO REGISTRO_VISITANTES(Nombre,Cedula,Area,Jefe_inmedato,Jornada_programada,Hora_ingreso,Actividad,Motivo_visita,Area_agenda,IP_registra_sede)VALUES('$nombre',$cedula,'$area','$jefe_inmediato','$jornada',GETDATE(),'$actividad','$ingreso_agr','$area_agenda','$ipreal')");
         $con_sql->insertar($sql_reg_temprales);
         
         $sql_del_temprales = ("DELETE FROM AGENDA_VISITANTES$activa_tmp WHERE CEDULA=$cedula");
         $con_sql->insertar($sql_del_temprales);

         msj_informacion('INGRESO PERMITIDO DIRIJASE CON : '.$jefe_inmediato .' AREA: '.$area,'#378c3a','success');
      }

   }else if($turno=="Salida_alm"){
      /* LA FUNCION UPDATE_CAMPOS VALIDA LOS PAREMTROS PARA CADA FECHA Y REDICE EL CODIGO PARA ACTUALIZAR CADA UNOS DE LOS CAMPOS */
      update_campos($con_sql,'Hora_s_alm',$cedula,$id,'YA TIENE UN REGISTRO DE SALIDA DE ALMUERZO');
      
   }else if($turno=="Entrada_alm"){
      // echo"3<br>";
      update_campos($con_sql,'Hora_i_alm',$cedula,$id,'YA TIENE UN REGISTRO DE INGRESO DE ALMUERZO');
      
   }else if($turno=="Salida"){
      /* ESTA ES LA UNICA FUNCION QUE ACTUALIZA 2 CAMPOS (SALIDA,ESTADO) */
      // echo"4<br>";
      update_campos($con_sql,'Hora_salida',$cedula,$id,'YA TIENE UN REGISTRO DE SALIDA',',Activo=0');
   }else{
      // echo"5";
      echo "<meta http-equiv="."refresh"." content="."52;url=index-ingresos.php".">";
      return;
   }

   echo "<meta http-equiv="."refresh"." content="."2;url=index-ingresos.php".">";

}



function update_campos($con_sql,$Hora_acc_alm,$cedula,$id,$msj,$salida){
   
   $sql_reg_temprales = ("select Cedula from REGISTRO_VISITANTES where cedula='$cedula' and (Hora_ingreso) is not null and ($Hora_acc_alm) is not null and (Hora_salida) is null");
   $ya_existe = mssql_num_rows($con_sql->consultar($sql_reg_temprales));
   $existe = ($ya_existe=='0')?'FALSE':'TRUE';
   
   /* VALIDAMOS QUE YA NO ESTE REGISTRADO PARA NO DUPLICAR POR DIA  */
   if( $existe=='TRUE') {
      msj_informacion($msj,'#fd7f06','success');
   }else{
      msj_informacion('REGISTRO EXITOSO','#378c3a','success');
         $sql_reg_temprales = ("UPDATE REGISTRO_VISITANTES set $Hora_acc_alm=GETDATE() $salida  where Cedula='$cedula' and ($Hora_acc_alm) is null and  Activo =1");
         $con_sql->insertar($sql_reg_temprales);
      }
}
?>


</body>
