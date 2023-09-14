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
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }

    $area=$_GET['area'];

  ?>
  <form method="POST" action="#" enctype="multipart/form-data">
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
//   unlink('Excel_ca/inf_comp_vent.xlsx');

//   echo "<a href="."javascript:popUp('insert_temporales_uno.php?area=$area')"." class='nav-link link-dark' ><img src='../../assets/images/file-upload.png' style='height:30px;width:30px;'>Cargar 1<span title='Ojo se limpia toda la tabla'></span></a> ";
  
  ?>

	<h2>Listado Ingresos</h2>	
    <div class="panel panel-primary --bs-success-text">
      <div class="panel-heading ">
        <h3 class="panel-title">Resultados </h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
        <div class="table-responsive" style="height:400px">
<?php

include  '../../nuevo_sia_v2/clases/PHPExcel/Classes/PHPExcel.php';
include  '../../nuevo_sia_v2/conection/conexion_sql.php' ;
include  '../../nuevo_sia_v2/functions/general_functions.php' ;

$con =new con_sql('sqlFacturas');
$fecha_actual = date('d-m-Y H:i:s');

$area_cargue=$_GET['area'];


$archivo        = "./Excel_ca/inf_comp_vent.xlsx";
$inputFileType  = PHPExcel_IOFactory::identify($archivo);
$objReader      = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel    = $objReader->load($archivo);
$sheet          = $objPHPExcel->getSheet(0); 
$highestRow     = $sheet->getHighestRow(); 
$highestColumn  = $sheet->getHighestColumn();
$con->insertar("TRUNCATE TABLE Informe_Compras_Ventas");

?>



<table class="table table-bordered table-light" style="font-size:1.5vh">
      <thead >
        <tr>
          <th scope="col">ID</th>
          <th scope="col">ITEM           (T)</th>
          <th scope="col">BODEGA         (I)</th>
          <th scope="col">EXISTEN       (T)</th>
          <th scope="col">RESPONSALBE (T)</th>
        </tr>
      </thead>
      <tbody>


<?php
$num=0;

$contenedor_consulta ='';
for ($row = 2; $row <= $highestRow; $row++){ 

$sql_insert="
INSERT INTO Informe_Compras_Ventas(
  Item
  ,Bodega
  ,Existen
  ,Responsable
  )
VALUES(
        '". strtoupper($sheet->getCell('A'.$row)->getValue())."', 
         ". strtoupper($sheet->getCell('B'.$row)->getValue()).", 
        '". strtoupper($sheet->getCell('C'.$row)->getValue())."', 
        '". strtoupper($sheet->getCell('D'.$row)->getValue())."'
        )
  ";
  $con->insertar($sql_insert);

   $contenedor_consulta .= $values_Sql ;
   
   $num++;
    ?>
       <tr>
         <th scope='row'><?php echo $num;?></th>
         <td><?php echo $sheet->getCell("A".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("B".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("C".$row)->getValue();?></td>
         <td><?php echo $sheet->getCell("D".$row)->getValue();?></td>
        </tr>
        
        <?php	
}
?>
          </tbody>
    </table>
  </div>	
  </div>	
 </div>	
</div>

<!-- <a href="mod_carga.php?area=<?=$area_cargue?>"><span class="btn btn-primary">⏪</span></a> -->

</body>
</html>
