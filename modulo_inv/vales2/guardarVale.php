<?php
//emp=' + emp + '&col=' + cola + '&per=' + per + '&anio=' + peranio + '&tip=' + tipo + '&des=' + descv + '&val=' + valorv + '&cuo=' + cuotas + '&obs=' + obs + '&numv=' + numv
$usuario=$_SESSION[usuARio];
$emp=$_GET['emp'];
//$_SESSION[emp]=$emp;
$colU=$_GET['col'];
//$_SESSION[col]=$colU;
//$colP = $colU.split("-");
$colP = explode("-",$colU);
$tip=$_GET['tip'];
$des=$_GET['des']; //descripcion del descuento
$valN=trim($_GET['val']);//valor en negaivo
$valC=$_GET['val'];//valor cuota
$cuo=$_GET['cuo'];
$obss=$_GET['obs'];
if(empty($_GET['numv'])){
    $numv='-';
}else{
    $numv=$_GET['numv'];
}
//echo " periodo enviado: (1)";


$Precuo=0;
$Numcuo=0;
//-10000
if(is_numeric($valN) && $valN < 0){
    $valN=$valN * -1;
}

if(is_numeric($valN)){
    $valN = $valN * -1 ;
}elseif(!is_numeric($valN)){
     $valN='0';
}
//cuando llega negativo lo pasa a psoitivo
if(is_numeric($valC) && $valC < 0){
    $valC=$valC * -1;
}

if($cuo=='' || $cuo=='Seleccione'){
    $cuo='1';
}

if($cuo=='PRE-FIRMADO'){
    $Precuo=$cuo; //numero vale
    $cuo=0;
}else{
    $Precuo='-'; //numero vale
    if(is_numeric($valN) && is_numeric($cuo) && $cuo>0){
        $valC = $valC / $cuo;
    }else{
        $valC='0';
    }
}

$aniox=trim($_GET['anio']);
//$_SESSION[anio]=$aniox;
$a=date("Y");

$periodo=trim($_GET['per']);
//$_SESSION[periodo]=$periodo;
//echo " periodo enviado: (1)".$periodo;
$CorV = explode("-",$periodo);
//valida periodo actual
    $meses = array('0','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
    $diacorte = 16;
    $dia=date("d");
    $mes = date("m")+0 ;
    $anio = date("Y") +0 ;
    //periodo actual e depues de corte
    if($dia >= $diacorte ){
         $mes += 1 ;
         if($mes == 13){
             $mes = 1;
             $anio +=1;
         }  
    }
    $a=$anio;
        
      $mes_i = $mes - 1;
      $mes_f=$mes;
      if( $mes_i == 0){
        $mes_i = 12; 
      }
      $periodoACTUAL =  $meses[$mes_i]."-".$meses[$mes_f];    //ene-feb 2021
      //$periodoACTUALa = $periodoACTUAL.explode("-");
      $fecha =date("Y-m-d");
//echo " periodo enviado: "."emp ".$emp."col ".$col."tip ".$tip."des ".$des."val ".$val."cuo ".$cuo."obss ".$obss."numv ".$numv;

//echo " periodo enviado: (1)".$usuario;
//exit();
$msg="Valide datos";
//echo "aqui".$a." = ".$aniox." o ". $periodoACTUAL." = ". $periodo;
if($a==$aniox && $periodoACTUAL==$periodo){
    require_once("user_con.php");
    $sqlaux="SELECT * FROM rh_vale_vales";
         //$resultado2 = mssql_fetch_array($sqlaux);
         $result = mysqli_query($mysqli, $sqlaux);
         if($row = mysqli_fetch_array($result)){              
                //INSERTA
                $sql = "INSERT INTO rh_vale_vales (codigo,corte,periodo,ano,colaborador,empresa,area,vale,prefirmado,cuotas,cuota,concepto,valor,fecha,usuario,obs,tipo) 
                VALUES('$colP[0]','$CorV[1]','$periodoACTUAL','$anio','$colP[1]','$emp','-','$numv','$Precuo' ,'$cuo','$valC','$des','$valN','$fecha','$usuario','$obss','$tip')";

                if($result2=mysqli_query($mysqli,$sql )){
                    $msg="Datos del vale guardados con exito.";  
                }         
        }
       
    }else{
        $msg="Periodo es Anterior al actual. No se guardara el registro!";
    }
    $msg=$msg."^".$emp."^".$aniox."^".$periodo."^".$colU;
    echo $msg;
?>

