<?php
//$salida = shell_exec('lpr -P \\\192.168.6.68\Kyocera3Piso test.txt');
//$salida = shell_exec('smbclient --list 192.168.6.68');
//$salida = shell_exec('smbclient -L 192.168.6.104 -U CARDOZOJ ');
//$salida = shell_exec('ls -l /bin/bash');
$salida = shell_exec('lpstat -t');
//$salida = shell_exec('ls -lart');
echo "<pre>$salida</pre>";
//lpr -P nomimpresora nomarchivo.txt

?>