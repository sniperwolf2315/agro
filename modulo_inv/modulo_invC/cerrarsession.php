<?php

if (!isset($_SESSION)) { session_start(); }
$_SESSION['Pantalla']='1';
$_SESSION['fVenc']='0';
echo "Session cerrada";

?>