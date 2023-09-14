<?php
//Cra 2 No 16 a 38 Torre 3 Apto 1604

$numCll="16";
$strCll=ord("A");
$numCra="2";
$strCra="";

//A=65,B=66, C=67, D=68, E=69, F=70, G=71
$nomlocalidad=new ArrayIterator();

$nomlocalidad[17]="Candelaria";
/*
1. si (calle >= 6B && < =12C) && (cra >=9 && <=10)  then Candelaria
2. si (calle >= 6A && < =13) && (cra >=4 && <=9)  then Candelaria
3. si (calle >= 6A && < =12F) && (cra >=3 && <=4)  then Candelaria
4. si (calle >=4A && < =19A) && (cra >=1 && <=3)  then Candelaria

5. si (calle >=3C && < =22) && (cra >=3E && <=1)  then Candelaria
6.  si (calle >=7 Este && < =1E) && (cra >=5A Este && < =3Este)  then Candelaria		7Este es -7
*/

$limE=-5;
$limW=10;
$limN=22;
$limS=3;

$Paso=0;

if(($numCra>=$limE && $numCra <= $limW) && ($numCll>=$limS && $numCll<=$limN)){
    $numLetraCll=ord($strCll);
    $numLetraCra=ord($strCra);
    //opcion 1
    if((($numCll>=6 && $strCll>=66)&&($numCll<=12 && $strCll<=67))&& (($numCra>=9)&&($numCra<=10)) ){
        $localidad=17;
        $Paso=1;
    }
    if((($numCll>=6 && $strCll>=65)&&($numCll<=13))&& (($numCra>=4)&&($numCra<=9)) ){
        $localidad=17;
        $Paso=2;
    }
    if((($numCll>=6 && $strCll>=65)&&($numCll<=12 && $strCll<=70))&& (($numCra>=3)&&($numCra<=4)) ){
        $localidad=17;
        $Paso=3;
    }
    if((($numCll>=4 && $strCll>=65)&&($numCll<=19 && $strCll<=65))&& (($numCra>=1)&&($numCra<=3)) ){
        $localidad=17;
        $Paso=4;
    }
    
}

echo $nomlocalidad[$localidad]."--".$Paso;

?>