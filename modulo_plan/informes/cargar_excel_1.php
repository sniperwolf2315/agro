<?php
// unlink('Excel_ca/inf_comp_vent.xlsx');
session_start();
// $area_cargue = ($_GET['area'])?$_GET['area']:$_POST['area']; 
$area_cargue='';
$fecha_actual2  = date('Y-m-d H:i:s');

rename("./Excel_ca/inf_comp_vent.xlsx","./Excel_ca/inf_comp_vent"."_"."$fecha_actual2"."_old.xlsx");
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

    $newFileName = "inf_comp_vent.$fileExtension";

    // valida que tenga la extencion permitida
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'xlsx', 'docx' );

    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directorio en el cual creamos el archivo
      $uploadFileDir = './Excel_ca/';

      /* ELIMINA EL ARCHIVO EXISTENTE */
      // unlink('Excel_ca/inf_comp_vent.xlsx');
      /* RENOMBRA EL ARCHIVO Y CREA OTRO NEVO */
      rename("./Excel_ca/inf_comp_vent.xlsx","./Excel_ca/inf_comp_vent"."_"."$fecha_actual2"."_old.xlsx");
      // FIXME: YA NO DEBE BORRAR EL ARCHiVO, DEBE CAMBIAR EL NOMBRE DEL ANTIGUO Y CREAR EL NUEVO 

      $dest_path = $uploadFileDir . $newFileName;


      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        unset($_FILES['uploadedFile']);
        $_SESSION['message'] = $message;
        // header("Location: index.php");
        $message ='Cargado con exito ✔';
        // sleep(2);

        // echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
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
include('cargar_excel_2.php');