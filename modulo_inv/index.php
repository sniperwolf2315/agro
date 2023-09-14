<? session_start();
if($_SESSION['usuARioI'] ==''){
header("location:user_conect.php");
}else{
header("location:modulo_inv/menu.php");
}

?>