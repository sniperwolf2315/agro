<? session_start();

if($_SESSION['usuARioF'] ==''){
    header("location:../user_conect.php"); die;
  }else{
    header("location:../index.php"); die;
  }
