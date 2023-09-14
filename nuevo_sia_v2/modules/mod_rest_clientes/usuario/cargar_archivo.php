<?php
session_start();

$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Cargar')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath   = $_FILES['uploadedFile']['tmp_name'];
    $fileName      = $_FILES['uploadedFile']['name'];
    $fileSize      = $_FILES['uploadedFile']['size'];
    $fileType      = $_FILES['uploadedFile']['type'];
    $fileNameCmps  = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $newFileName = 'lista_recaudo.'. $fileExtension;

    // valida que tenga la extencion permitida
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'xlsx', 'docx' );

    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directorio en el cual creamos el archivo
      $uploadFileDir = './excel/';
      unlink('lista_recaudo.xlsx');
      $dest_path = $uploadFileDir . $newFileName;

      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
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
$_SESSION['message'] = $message;
header("Location: ingreso_domiciliario_rec.php");