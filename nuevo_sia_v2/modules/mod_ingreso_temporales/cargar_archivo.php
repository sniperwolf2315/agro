<?php



session_start();
$area_cargue = ($_GET['area'])?$_GET['area']:$_POST['area']; 

$fecha_actual2  = date('Y-m-d H:i:s');
$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Cargar')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    // get details of the uploaded file
    $fileTmpPath   = $_FILES['uploadedFile']['tmp_name'];
    $fileName      = $_FILES['uploadedFile']['name'];
    $fileSize      = $_FILES['uploadedFile']['size'];
    $fileType      = $_FILES['uploadedFile']['type'];
    $fileNameCmps  = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    


    $newFileName = "lista_temp_$area_cargue.$fileExtension";

    // valida que tenga la extencion permitida
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'xlsx', 'docx' );

    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directorio en el cual creamos el archivo
      $uploadFileDir = './excel_tem/';
      // unlink('lista_temp.xlsx');
      rename("./excel_tem/lista_temp_$area_cargue.xlsx","./excel_tem/lista_temp_$area_cargue"."_"."$fecha_actual2"."_old.xlsx");
      // FIXME: YA NO DEBE BORRAR EL ARCHiVO, DEBE CAMBIAR EL NOMBRE DEL ANTIGUO Y CREAR EL NUEVO 

      $dest_path = $uploadFileDir . $newFileName;


      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        include_once('ingreso_temporales.php');
        // SOLO SE BORRA CUANDO SE HACE EL CARGUE EXITOSO DEL EXCEL
        // $con ->insertar("delete from AGENDA_VISITANTES where AREA_CARGUE='$area_consulta[0]'");
        $con ->insertar("delete from AGENDA_VISITANTE_TMP where AREA_CARGUE='$area_consulta[0]'");
        // SOLO SE INSERTA CUANDO SE HACE EL CARGUE EXITOSO DEL EXCEL
        $con->insertar($query_insert_completa);

        $message ='Cargado con exito.';
      }
      else 
      {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
    }
    else
    {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }
}
unset($_FILES['uploadedFile']);
$_SESSION['message'] = $message;
// header("Location: ingreso_temporales.php?c=1&area=GH");
header("Location: ingreso_temporales.php?c=1&area=$area_cargue");