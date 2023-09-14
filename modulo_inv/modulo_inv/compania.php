<?php
$compan=$_GET['c']; 
 if (!isset($_SESSION)) { session_start(); }
    $_SESSION['Compan']=$compan;
    echo "leergrupos";                        
?>