<?php
$meses = array('0','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
    $diacorte = 16;
    $dia=date("d");
    $mes = date("m") +0 ;
    $anio = date("Y") +0 ;
    //periodo actual e depues de corte
    if($dia >= $diacorte ){
         $mes += 1 ;
         if($mes == 13){
             $mes = 1;
             $anio +=1;
         }  
        }
        
      $mes_i = $mes - 1;
      $mes_f=$mes;
      if( $mes_i == 0){
        $mes_i = 12; 
      }
      //if(strlen($mes_i)==1){$mes_i="0".$mes_i;}
      //if(strlen($mes_f)==1){$mes_f="0".$mes_f;}
      //$periodoACTUAL =  $meses[$mes_i]."-".$meses[$mes_f]." ".$anio;    //ene-feb 2021
      $periodoACTUAL =  $mes_i."-".$mes_f." ".$anio;    //ene-feb 2021
      //ene-feb 2021 
      echo $periodoACTUAL;//$periodoACTUAL
?>