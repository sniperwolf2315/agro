<!DOCTYPE html>
<html>
<head>
	<title>Cargue Ingresos</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src='../../assets/js/funciones.js'></script>

</head>
<body>


<br>

<div class="container col-10">
	<!-- <h2>Cargue del archivo .xlsx</h2>	 -->
	<h2>Cargue Colaboradores</h2>	

<?php
    session_start();
    $usuario_log = strtoupper($_SESSION[ 'usuARio' ]);


    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }

    $area=$_GET['area'];

  ?>
  <form method="POST" action="cargar_archivo.php?area=<?=$area?>&us=<?=$usuario_log?>" enctype="multipart/form-data">
  <div>
    <div class="mb-6" style="font-size:18px; ">
      <label for="formFileLg" class="form-label">Cargar Archivo xlsx</label>
      <input class="form-control form-control-sm" id="formFileLg" type="file" name="uploadedFile" style="font-size:18px; height:50px; " required>
      <input id="area" name="area" type="hidden" value="<?=$area?>">
      <div class="invalid-feedback">Favor elejir un archivo</div>
    </div>

  </div>
    <input type="submit" name="uploadBtn" value="Cargar" class="btn btn-outline-success" style="font-size:15px;"/>    

  </form>
  <hr>
  <?php
  
  echo "<a href="."javascript:popUp('insert_temporales_uno.php?area=$area&user_load=$usuario_log')"." class='nav-link link-dark' ><img src='../../assets/images/file-upload.png' style='height:30px;width:30px;'>Cargar 1<span title='Ojo se limpia toda la tabla'></span></a> ";
  
  ?>

	<h2>Listado Ingresos Masivo</h2>	
    <div class="panel panel-primary --bs-success-text">
      <div class="panel-heading ">
        <h3 class="panel-title">Resultados </h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
        <div class="table-responsive" style="height:400px">
<?php

        include  '../../clases/PHPExcel/Classes/PHPExcel.php';
        include  '../../conection/conexion_sql.php' ;
        include  '../../functions/general_functions.php' ;

        $con =new con_sql('sqlFacturas');
        $fecha_actual = date('d-m-Y H:i:s');

        $area_cargue=$_GET['area'];

        $area_consulta = mssql_fetch_array($con->consultar("select campo from API_CONFIGURACION where valor=$area_cargue"));
        // $con ->insertar('truncate table AGENDA_VISITANTES');

        $archivo        = "./excel_tem/lista_temp_$area_cargue.xlsx";
        $inputFileType  = PHPExcel_IOFactory::identify($archivo);
        $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel    = $objReader->load($archivo);
        $sheet          = $objPHPExcel->getSheet(0); 
        $highestRow     = $sheet->getHighestRow(); 
        $highestColumn  = $sheet->getHighestColumn();?>

<table class="table table-bordered table-light" style="font-size:1.5vh">
  <thead >
    <tr>
      <th scope="col">ID</th>
      <th scope="col">NOMBRE            (T)</th>
      <th scope="col">CEDULA            (I)</th>
      <th scope="col">AREA/EMP          (T)</th>
      <th scope="col">JEFE INMEDIATO    (T)</th>
      <th scope="col">JORNADA PROGRAMADA(T)</th>
      <th scope="col">ACTIVIDAD         (T)</th>
      <th scope="col">AREA_CARGUE       (T)</th>
    </tr>
  </thead>
  <tbody>


<?php
$num=0;
$sql_insert="INSERT INTO AGENDA_VISITANTES(Nombre,Cedula,Area,Jefe_inmedato,Jornada_programada,Actividad,AREA_CARGUE,USUARIO_CARGUE)";

$contenedor_consulta ='';
for ($row = 2; $row <= $highestRow; $row++){ 
if($row==2){

  $values_Sql =  "
  VALUES(
    '". strtoupper($sheet->getCell('A'.$row)->getValue())."', 
     ". strtoupper($sheet->getCell('B'.$row)->getValue()).", 
    '". strtoupper($sheet->getCell('C'.$row)->getValue())."', 
    '". strtoupper($sheet->getCell('D'.$row)->getValue())."', 
    '". strtoupper($sheet->getCell('E'.$row)->getValue())."',
    '". strtoupper($sheet->getCell('F'.$row)->getValue())."',
    '$area_consulta[0]',
    '$usuario_log'
    )
    ";
    
  }else{
  $values_Sql =  "
  ,(
    '". strtoupper($sheet->getCell('A'.$row)->getValue())."', 
     ". strtoupper($sheet->getCell('B'.$row)->getValue()).", 
    '". strtoupper($sheet->getCell('C'.$row)->getValue())."', 
    '". strtoupper($sheet->getCell('D'.$row)->getValue())."', 
    '". strtoupper($sheet->getCell('E'.$row)->getValue())."',
    '". strtoupper($sheet->getCell('F'.$row)->getValue())."',
    '$area_consulta[0]',
    '$usuario_log'
    )
    ";
  }
   $contenedor_consulta .= $values_Sql ;
   
   $num++;
    ?>
       <tr>
         <th scope='row'><?php echo $num;?></th>
         <td><?php echo $sheet->getCell("A".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("B".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("C".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("D".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("E".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("F".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("G".$row)->getValue();?></td>
        </tr>
        
        <?php	
}

$query_insert_completa = $sql_insert.$contenedor_consulta;
?>
          </tbody>
        </table>
        
        
      </div>	
    </div>	
  </div>	
</div>
<?php
    $nombre_area_cargue = mssql_fetch_array($con->consultar("SELECT campo from API_CONFIGURACION where VALOR = $area_cargue"));
    $nombre_area_cargue = $nombre_area_cargue[0];
    $personal_en_espera = ($con->consultar("SELECT * FROM AGENDA_VISITANTES where AREA_CARGUE='$nombre_area_cargue'"));
?>

<h3>Personal registrado</h3>
  <table class="table table-bordered table-light" style="font-size:1.5vh">
        <thead >
          <tr>
            <th scope="col">ID                </th>
            <th scope="col">NOMBRE            </th>
            <th scope="col">CEDULA            </th>
            <th scope="col">AREA/EMP          </th>
            <th scope="col">JEFE INMEDIATO    </th>
            <th scope="col">JORNADA PROGRAMADA</th>
            <th scope="col">ACTIVIDAD         </th>
            <th scope="col">AREA_RESPONSABLE  </th>
            <th scope="col">USUARIO_CARGUE    </th>      

          </tr>
        </thead>
        <tbody>
<?php
while($per_esp = mssql_fetch_array($personal_en_espera)){
    echo "<tr>
          <td>$per_esp[0]</td>
          <td>$per_esp[1]</td>
          <td>$per_esp[2]</td>
          <td>$per_esp[3]</td>
          <td>$per_esp[4]</td>
          <td>$per_esp[5]</td>
          <td>$per_esp[6]</td>
          <td>$per_esp[7]</td>
          <td>$per_esp[8]</td>
          </tr>";
}
?>
        </tbody>
    </table>


<a href="mod_carga.php?area=<?=$area_cargue?>">
  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="44" height="34" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
    <line x1="5" y1="12" x2="19" y2="12" />
    <line x1="5" y1="12" x2="9" y2="16" />
    <line x1="5" y1="12" x2="9" y2="8" />
  </svg>
</a>
</body>
</html>
