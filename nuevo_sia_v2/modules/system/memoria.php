<?php

$mostrar_mem = shell_exec( 'free -m -h' );
echo $mostrar_mem.'<br>' ;
$liberar_memoria = shell_exec( 'sync; echo 1 > /proc/sys/vm/drop_caches' );
$mostrar_mem2 = shell_exec( 'free -m -h' );
echo $mostrar_mem2.'<br>' ;
$liberar_memoria_swapp = shell_exec( 'swapoff -a && swapon -a' );
echo $liberar_memoria_swapp.'<br>' ;

?>
