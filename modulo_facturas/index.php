<? session_start();
if($_SESSION['usuARioF'] == '' OR $_SESSION['clAVeF'] == '')
    {
    header("location:user_conect.php"); die;
    }
header("location:modulo_facturas/facturas.php");

require('user_con.php'); 

?>
