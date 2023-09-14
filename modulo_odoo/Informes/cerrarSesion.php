<?php
if(session_start()===FALSE){
        session_start();
    }
$_SESSION['usuARio']='';
$_SESSION['acc']='0';
$_SESSION['verbtnP']='';
$_SESSION['verbtnS']='';
session_destroy();
// header("location:user_conect_odoo.php");
//header("location:user_conect.php?a=0");
echo'
<script type="text/javascript">
setTimeout( function() {
    window.location.href = "user_conect_odoo.php";
    console.log("si espero");
    
        }, 5000 );
</script> ';

?>