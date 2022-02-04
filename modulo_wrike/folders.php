<?php
$t=0;
$tarea = new ArrayIterator();
$fp = fopen("carpet.txt", "r");
$ff=0;
while (!feof($fp)){
    $tarea[$t] = fgets($fp);
    $t++;
}

echo $tarea[23]."<br><hr>";  //************************************

$t=count($tarea);
$i=0;
$descProyecto="";
$autor="";
$id_nombre="";
$compartidacon3="";
//while($i<$t){
    
    
    $aux=explode('body', $tarea[23] ); //**************************************
    $t2=count($aux);
    $j=0;
    while($j<$t2){
        //verifica si es proyecto
        if($j == 0){
            $proy=explode('isProject":', $aux[$j] );
            //echo "<b>dxxx:</b> ".$proy[1]."<br><hr>";
            $proy2=explode(',"', $proy[1] );
            echo "<b>estado proy:</b> ".$proy2[0]."<br><hr>";
            /*if($proy2[0]=='true'){
                $proy3=explode('description":"', $proy[1] );
                $proy4=explode('\u003cbr /\u003e\u003cbr', $proy3[1] );
                $descProyecto=$proy4[0];
                //echo "<b>desc proyecto:</b> ".$descProyecto."<br><hr>";
            }*/
        }
         
         if($j>0){
             //echo "<b>desc tot carpeta:</b> ".$aux[$j]."->".$j."<br><hr>";
             $nom1=explode('author', $aux[$j] );
             $num = strpos($nom1[0],'name\":\"');
             if($num>0){
                $nom2=explode('name\":\"', $nom1[0] ); 
                $nom3=explode('\",\"id\":', $nom2[1] ); 
                $numx = strpos($nom2[1],'\",\"id\":');
                if($numx>0){
                    $idnom=explode('\",\"id\":', $nom2[1] ); 
                
                    $num2 = strpos($idnom[1],'}]","');
                    if($num2>0){
                        $idnom2=explode('}]","', $idnom[1] );
                        $id_nombre=$idnom2[0];
                        //$idnom2=explode('}', $idnom[1] );
                        $autor1=explode('","', $nom1[1] );
                        //$autor1=explode(']","', $nom1[1] );
                        $autor2=explode(':"', $autor1[0] );
                        $autor=$autor2[1];
                        
                        $nom=str_replace('\"}]","','',$nom3[0]);
                        
                        $comparte=explode('"shared":[', $tarea[23] ); //ojo index***********************
                        $comparte2=explode('bot', $comparte[1] );
                        $compartidacon=$comparte2[0];
                        $compartidacon2=str_replace('","','^',$compartidacon);
                        $compartidacon3=str_replace('"','',$compartidacon2);
                        echo "<b>id nombre:</b> ".$id_nombre."<br><hr><hr>"; //$idnom2[0]
                        echo "<b>compartida con:</b> ".$compartidacon3."<br><hr><hr>";
                    }
                }
      
                //echo "<b>autor:</b> ".$autor."<br><hr>";
                echo "<b>nombre:</b> ".$nom."<br><hr>"; //$nom3[0]
                
                $descProyecto="";
                $autor="";
                $id_nombre="";
                $compartidacon3="";
                
                //buscar por tittle pendiente***
                
             }
             
         }
        $j++;
    }
    

//    $i++;
//}
/*
//carpetas principales
$t=count($tarea);
$i=0;
while($i<$t){
$filtro=strcmp($tarea[$i], 'In07vB0PaVNb');
if($filtro>0){
$aux=explode('name\":\"', $tarea[$i] );
$r1=explode('\"}]","author":"', $aux[1] );
$r2=explode('\",\"id\":', $r1[0] );
$cp=$r2[0];
if(strlen($cp) < 60){
    echo "<b>carpeta padre:</b> ".$i."--".$cp."<br><hr>";
    //subcarpetas
    $aux=explode('title":"', $tarea[$i] );
    $r1=explode('","', $aux[1] );
    $subc=$r1[0];
    //echo "<b>subcarpeta:</b> ".$subc."<br><hr>";
}
}
$i++;
}
*/
?>