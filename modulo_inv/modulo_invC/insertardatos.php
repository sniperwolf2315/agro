<?php
    $itm=$_GET['itm'];
    $nom=utf8_decode($_GET['nom']);
    $fve=$_GET['fve'];  //vence
    $lot=$_GET['lot'];  //lote
    $con=$_GET['con'];  //conteo
    $ubi=$_GET['ubi'];
    $tot=$_GET['cant'];
    $mov=$_GET['movi'];  //S o R
    $Usuario=$_SESSION['usuARioI'];
    if ($mov=="R"){
        $tot=$tot * (-1);
    }
    $sede=$_SESSION['Sede'];
    $fecha=date('Y-m-d H:i:s');
    $hora=date('H:i');
    if($sede=='Portos'){
        require_once('conexioninventario80.php');
        $result = mssql_query("SELECT * from invRegistroTmp WHERE pgprcd='$itm' and pgpgrp='$ubi' and FechaVencimiento='$fve' and Lote='$lot'");
        $fila = mssql_fetch_array($result);
        $numero2 = mssql_num_rows($result);
        $Usuarioant=$fila['Historia'];
        if($Usuarioant==""){
            $Usuariolog = "I".$hora." ".$Usuario;
        }else{
            $Usuariolog = $Usuarioant."~A".$hora." ".$Usuario;
        }
    }else if($sede=='Calle73'){
        require_once('conexioninventario73.php');
        //saca el grupo del grupo
        if(strlen($ubi)==1){
            $ubi='00'.$ubi;
        }
        if(strlen($ubi)==2){
            $ubi='0'.$ubi;
        } 
        $grp=substr($ubi, -3);
        $result = mssql_query("SELECT * from invRegistroTmp WHERE pgprcd='$itm' and pgpgrp='$grp'");
        $fila = mssql_fetch_array($result);
        $numero2 = mssql_num_rows($result);
    }
    
    
    //cantidad1,cantidad2,cantidad3,cantidad4,cantidad5,
    //'0','0','0','0','0',
    $resultado1=null;
    //sede portos
    if($sede=='Portos'){
    if($numero2 == 0 ){
        if($con=='0'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5,canfac,Orden,NotaRecepcion,cansol,Descripcion,Procesado,FechaVencimiento,Lote,Historia)";
            $consulta2=$consulta2." VALUES('$itm','$ubi','$tot','$fecha','0','0','0','0','0','0','','','0','$nom','','$fve','$lot','$Usuariolog')";
        }else if($con=='1'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5,canfac,Orden,NotaRecepcion,cansol,Descripcion,Procesado,FechaVencimiento,Lote,Historia)";
            $consulta2=$consulta2." VALUES('$itm','$ubi','0','$fecha','$tot','0','0','0','0','0','','','0','$nom','','$fve','$lot','$Usuariolog')";
        }else if($con=='2'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5,canfac,Orden,NotaRecepcion,cansol,Descripcion,Procesado,FechaVencimiento,Lote,Historia)";
            $consulta2=$consulta2." VALUES('$itm','$ubi','0','$fecha','0','$tot','0','0','0','0','','','0','$nom','','$fve','$lot','$Usuariolog')";
        }else if($con=='3'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5,canfac,Orden,NotaRecepcion,cansol,Descripcion,Procesado,FechaVencimiento,Lote,Historia)";
            $consulta2=$consulta2." VALUES('$itm','$ubi','0','$fecha','0','0','$tot','0','0','0','','','0','$nom','','$fve','$lot','$Usuariolog')";
        }else if($con=='4'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5,canfac,Orden,NotaRecepcion,cansol,Descripcion,Procesado,FechaVencimiento,Lote,Historia)";
            $consulta2=$consulta2." VALUES('$itm','$ubi','0','$fecha','0','0','0','$tot','0','0','','','0','$nom','','$fve','$lot','$Usuariolog')";
        }else if($con=='5'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5,canfac,Orden,NotaRecepcion,cansol,Descripcion,Procesado,FechaVencimiento,Lote,Historia)";
            $consulta2=$consulta2." VALUES('$itm','$ubi','0','$fecha','0','0','0','0','$tot','0','','','0','$nom','','$fve','$lot','$Usuariolog')";
        }
        $resultado1=mssql_query($consulta2);          
    }else{
        if($con=='0'){
            $consulta2="UPDATE invRegistroTmp SET srsthq='$tot', Historia='$Usuariolog' WHERE pgprcd='$itm' and pgpgrp='$ubi' and FechaVencimiento='$fve' and Lote='$lot'";
        }elseif($con=='1'){
            $consulta2="UPDATE invRegistroTmp SET cantidad1='$tot', Historia='$Usuariolog' WHERE pgprcd='$itm' and pgpgrp='$ubi' and FechaVencimiento='$fve' and Lote='$lot'";
        }elseif($con=='2'){
            $consulta2="UPDATE invRegistroTmp SET cantidad2='$tot', Historia='$Usuariolog' WHERE pgprcd='$itm' and pgpgrp='$ubi' and FechaVencimiento='$fve' and Lote='$lot'";
        }elseif($con=='3'){
            $consulta2="UPDATE invRegistroTmp SET cantidad3='$tot', Historia='$Usuariolog' WHERE pgprcd='$itm' and pgpgrp='$ubi' and FechaVencimiento='$fve' and Lote='$lot'";
        }elseif($con=='4'){
            $consulta2="UPDATE invRegistroTmp SET cantidad4='$tot', Historia='$Usuariolog' WHERE pgprcd='$itm' and pgpgrp='$ubi' and FechaVencimiento='$fve' and Lote='$lot'";
        }elseif($con=='5'){
            $consulta2="UPDATE invRegistroTmp SET cantidad5='$tot', Historia='$Usuariolog' WHERE pgprcd='$itm' and pgpgrp='$ubi' and FechaVencimiento='$fve' and Lote='$lot'";
        }
        $resultado1=mssql_query($consulta2);
    }
    }
    //sede calle 73
    if($sede=='Calle73'){
    if($numero2 == 0 ){
        if($con=='0'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5)";
            $consulta2=$consulta2." VALUES('$itm','$grp','$tot','$fecha','0','0','0','0','0')";
        }else if($con=='1'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5)";
            $consulta2=$consulta2." VALUES('$itm','$grp','0','$fecha','$tot','0','0','0','0')";
        }else if($con=='2'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5)";
            $consulta2=$consulta2." VALUES('$itm','$grp','0','$fecha','0','$tot','0','0','0')";
        }else if($con=='3'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5)";
            $consulta2=$consulta2." VALUES('$itm','$grp','0','$fecha','0','0','$tot','0','0')";
        }else if($con=='4'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5)";
            $consulta2=$consulta2." VALUES('$itm','$grp','0','$fecha','0','0','0','$tot','0')";
        }else if($con=='5'){
            $consulta2="INSERT INTO invRegistroTmp(pgprcd,pgpgrp,srsthq,fecha,cantidad1,cantidad2,cantidad3,cantidad4,cantidad5)";
            $consulta2=$consulta2." VALUES('$itm','$grp','0','$fecha','0','0','0','0','$tot')";
        }
        $resultado1=mssql_query($consulta2);          
    }else{
        if($con=='0'){
            $consulta2="UPDATE invRegistroTmp SET srsthq='$tot' WHERE pgprcd='$itm' and pgpgrp='$grp'";
        }elseif($con=='1'){
            $consulta2="UPDATE invRegistroTmp SET cantidad1='$tot' WHERE pgprcd='$itm' and pgpgrp='$grp'";
        }elseif($con=='2'){
            $consulta2="UPDATE invRegistroTmp SET cantidad2='$tot' WHERE pgprcd='$itm' and pgpgrp='$grp'";
        }elseif($con=='3'){
            $consulta2="UPDATE invRegistroTmp SET cantidad3='$tot' WHERE pgprcd='$itm' and pgpgrp='$grp'";
        }elseif($con=='4'){
            $consulta2="UPDATE invRegistroTmp SET cantidad4='$tot' WHERE pgprcd='$itm' and pgpgrp='$grp'";
        }elseif($con=='5'){
            $consulta2="UPDATE invRegistroTmp SET cantidad5='$tot' WHERE pgprcd='$itm' and pgpgrp='$grp'";
        }
        $resultado1=mssql_query($consulta2);
    }
    }
    if($resultado1){
        echo "Datos actualizados";
    }else{
        echo "Datos no actualizados";
    }
    mssql_close($result);
    
?>