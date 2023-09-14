<!DOCTYPE html>
<html>
<head>
	<title>Cargue Recaudos</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
  
<br>
<div class="container">
	<!-- <h2>Cargue del archivo .xlsx</h2>	 -->
	<h2>Cargue archivo planilla recaudos</h2>	

<?php
session_start();

?>
<?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
  <form method="POST" action="cargar_archivo.php" enctype="multipart/form-data">
    <div>
    <span>Cargar Archivo:</span>
    <input type="file" name="uploadedFile" class="btn btn-dark"/>
  </div>
    <!-- <input type="submit" name="uploadBtn" value="Upload" class="btn btn-success"/> -->
    <input type="submit" name="uploadBtn" value="Cargar" class="btn btn-primary"/>
  </form>

<hr>
	<h2>Listado repartidores recaudo</h2>	
    <div class="panel panel-primary ">
      <div class="panel-heading ">
        <h3 class="panel-title text-success">Resultados </h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
            
<?php
include_once  '../../../clases/PHPExcel/Classes/PHPExcel.php';
include       '../../../conection/conexion_sql.php' ;

$con =new con_sql('sqlFacturas');
$fecha_actual = date('d-m-Y H:i:s');


$con ->insertar('truncate table API_RECAUDOS');
$archivo        = "excel/lista_recaudo.xlsx";
$inputFileType  = PHPExcel_IOFactory::identify($archivo);
$objReader      = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel    = $objReader->load($archivo);
$sheet          = $objPHPExcel->getSheet(0); 
$highestRow     = $sheet->getHighestRow(); 
$highestColumn  = $sheet->getHighestColumn();?>

<table class="table table-bordered table-dark">
      <thead >
        <tr>
          <th scope="col">ID</th>
          <th scope="col">FECHA         (T)</th>
          <th scope="col">CEDULA        (I)</th>
          <th scope="col">DOMICILIARIO  (T)</th>
          <th scope="col">PLACA         (T)</th>
          <th scope="col">RUTA          (T)</th>
          <th scope="col">EMPRESA       (T)</th>
          <th scope="col">HORA_CARGUE   (T)</th>
        </tr>
      </thead>
      <tbody>


<?php
$num=0;
for ($row = 2; $row <= $highestRow; $row++){ 
    $sq_insert="
    INSERT INTO API_RECAUDOS(
     FECHA
    ,CEDULA
    ,DOMICILIARIO
    ,PLACA
    ,RUTA
    ,EMPRESA
    ,HORA_CARGUE
    ,HORA_REGISTRO
    )VALUES(
     '". $sheet->getCell('A'.$row)->getValue()."', 
      ". $sheet->getCell('B'.$row)->getValue().", 
     '". $sheet->getCell('C'.$row)->getValue()."', 
     '". $sheet->getCell('D'.$row)->getValue()."', 
     '". $sheet->getCell('E'.$row)->getValue()."', 
     '". $sheet->getCell('F'.$row)->getValue()."', 
     '". $sheet->getCell('G'.$row)->getValue()."',
     '$fecha_actual'
    )
    ";
    $con->insertar($sq_insert);
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
?>
          </tbody>
    </table>
  </div>	
 </div>	
</div>
<a href="usuario_admin.php?perf=sadm">
        <span class="btn btn-primary">⏪</span>
    </a>
</body>
</html>
