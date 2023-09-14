<?php
$t=0;
//include('conectarbase.php');
$tarea = new ArrayIterator();
$fp = fopen("carpet.txt", "r");
$ff=0;
while (!feof($fp)){
    $tarea[$t] = fgets($fp);
    $t++;
}


//$fila=30;
//echo $tarea[$fila]."<br><hr>";  
$i=0;
//echo "<b>num carpetas $i:</b> ".$t."<br><br>";

while($i < $t){
    $CarpetaP="";
    $proy=explode('isProject":', $tarea[$i] );
    $proy2=explode(',"', $proy[1] );
    $estado=$proy2[0];
    
    if($estado=='true'){
        echo "<b>estados $i:</b> ".$estado."<br><br>";
        //BODY
        $j=0;
        //echo "<b>carpeta $i:</b> ".$tarea[$i]."<br><br>";
        
        if (strpos($proy[1], ',"title":"') !== false) {
                $body2=explode(',"title":"', $proy[1] );
                echo "<b>id $i:</b> ".$body2[1]."<br><br>";
                
                //principal
                if (strpos($body2[1], '\"id\":') !== false) {
                    $body2=explode('\"id\":', $body2[1] );
                    //echo "<b>id $i:</b> ".$body2[1]."<br><br>";
                    if (strpos($body2[1], ',\"name\":\"') !== false) {
                        $body3=explode(',\"name\":\"', $body2[1] );
                        $IdCarpetaP=$body3[0];
                        echo "<b>IdCarpetaP $i:</b> ".$IdCarpetaP."<br><br>";
                        $body4=explode('\"}]","author', $body3[1] );
                        $CarpetaP=$body4[0];
                        echo "<b>CarpetaP $i:</b> ".$CarpetaP."<br><br>";
                        
                        
                        
                    }
                }
                
                //secundaria
                $body2=explode(',"title":"', $proy[1] );
                if (strpos($body2[1], '","author') !== false) {
                    $body3=explode('","author', $body2[1] );
                    $Carpeta2=$body3[0];
                    echo "<b>CarpetaS $i:</b> ".$Carpeta2."<br><br>";
                    
                    //shared 1
                        $Shared1="";
                        if (strpos($body3[1], 'Forms",') !== false) {
                            $bodyshx=explode('Forms",', $body3[1] );
                           //],"comments
                            if (strpos($bodyshx[1], '],"comments') !== false) {
                                $bodyshy=explode('],"comments', $bodyshx[1] );               
                                $Shared1a=$bodyshy[0];
                                $Shared1=str_replace('"','',$Shared1a);
                            } 
                            
                            echo "<b>shared 1 $i:</b> ".$Shared1."<br><br><br>";
                        }
                    //shared2
                    $Shared2="";
                    if (strpos($body3[1], 'shared":') !== false) {
                        $bodyshx=explode('","shared":', $body3[1] );
                       //],"comments
                        if (strpos($bodyshx[1], '],"comments":') !== false) {
                            $bodyshy=explode(',"comments":', $bodyshx[1] );
                            
                            if (strpos($bodyshy[0], 'bot-') !== false) {
                                $bodysh3=explode('bot-', $bodyshy[0] );
                                $Shared2x=$bodysh3[0];
                            }else{
                                $Shared2x=$bodyshy[0];
                            }
                        } 
                        $Shared2a=str_replace('["','',$Shared2x);
                        $Shared2b=str_replace('","',',',$Shared2a);
                        $Shared2c=str_replace('"]',',',$Shared2b);
                        $Shared2=substr($Shared2c,0,strlen($Shared2c)-1);
                        echo "<b>shared 2 $i:</b> ".$Shared2."<br><br><hr><hr><br>";
                    }
    
                }
                
                
        }
        /*
        //otra2
        $Carpeta2="-";
        if (strpos($tarea[$i], 'comments') !== false) {
            $body5=explode('comments', $tarea[$i] );
            //echo "<b>sub-carpeta1 $i:</b> ".$body5[1]."<br><br>";
                        
            if (strpos($body5[1], '\"name\\') !== false) {
                $body6=explode('\"name\\', $body5[1] );
                //echo "<b>sub-carpeta2 $i:</b> ".$body6[1]."<br><br>";
                
                if (strpos($body6[1], '\",\"settings') !== false) {
                    $body7=explode('\",\"settings', $body6[1] );
                    $Carpeta2=str_replace('":\"','',$body7[0]);
                    
                    echo "<b>sub-carpeta1 $i:</b> ".$Carpeta2."<br><br>";
                }
               
                
            }
        }
        $Carpeta3="-";
        //otra 3
        if (strpos($tarea[$i], 'title":"') !== false) {
            $body5=explode('title":"', $tarea[$i] );
            //echo "<b>sub-carpeta4 $i:</b> ".$body5[1]."<br><br>";
                        
            if (strpos($body5[1], '","author') !== false) {
                $body6=explode('","author', $body5[1] );
                $Carpeta3=$body6[0];
                echo "<b>sub-carpeta2 $i:</b> ".$Carpeta3."<br><br><br>";
                
            }
        }
        //shared 1
        $Shared1="";
        if (strpos($tarea[$i], 'Forms",') !== false) {
            $bodyshx=explode('Forms",', $tarea[$i] );
           //],"comments
            if (strpos($bodyshx[1], '],"comments') !== false) {
                $bodyshy=explode('],"comments', $bodyshx[1] );               
                $Shared1a=$bodyshy[0];
                $Shared1=str_replace('"','',$Shared1a);
            } 
            
            echo "<b>shared 1 $i:</b> ".$Shared1."<br><br><br>";
        }
        //shared2
        $Shared2="";
        if (strpos($tarea[$i], 'shared":') !== false) {
            $bodyshx=explode('","shared":', $tarea[$i] );
           //],"comments
            if (strpos($bodyshx[1], '],"comments":') !== false) {
                $bodyshy=explode(',"comments":', $bodyshx[1] );
                
                if (strpos($bodyshy[0], 'bot-') !== false) {
                    $bodysh3=explode('bot-', $bodyshy[0] );
                    $Shared2x=$bodysh3[0];
                }else{
                    $Shared2x=$bodyshy[0];
                }
            } 
            $Shared2a=str_replace('["','',$Shared2x);
            $Shared2b=str_replace('","',',',$Shared2a);
            $Shared2c=str_replace('"]',',',$Shared2b);
            $Shared2=substr($Shared2c,0,strlen($Shared2c)-1);
            echo "<b>shared 2 $i:</b> ".$Shared2."<br><br><hr><hr><br>";
        }
        */
 
    }
    
    $Carpeta3='';
    //echo $Carpeta2."<br>";
    //INSERTAR DATOS
    /*$resultSQL = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[foldersWrike] WHERE idP='".$IdCarpetaP."' and nombrecarp='".$CarpetaP."' and nombresubcarp='".$Carpeta2."'");
    
    //$resultSQL = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[foldersWrike] WHERE nombresubcarp='".$Carpeta2."'");
        $canty= mssql_num_rows($resultSQL);
        //$result = mysqli_query($cLink,$resultSQL);
        //if($row = mysqli_fetch_array($result)){
        if($canty == 0){
           
                $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[foldersWrike](idP,nombrecarp,sharedP,idS,nombresubcarp,sharedS,nombresubcarp2,shared3) 
                VALUES('$IdCarpetaP','$CarpetaP','$Shared1','','$Carpeta2','$Shared2','$Carpeta3','P2')"; 
                mssql_query($sqlv,$cLink);

        } 
    */
    
    $i++;
}

//mssql_close();
?>