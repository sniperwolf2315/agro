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
echo "<b>num carpetas $i:</b> ".$t."<br><br>";
$i=0;
while($i < $t){
    $CarpetaP="";
    $proy=explode('isProject":', $tarea[$i] );
    $proy2=explode(',"', $proy[1] );
    $estado=$proy2[0];
    echo "<b>estados $i:</b> ".$estado."<br><br>";
    if($estado=='false'){
        //BODY
        $j=0;
        echo "<b>carpta $i:</b> ".$tarea[$i]."<br><br>";
           
        if (strpos($tarea[$i], '[{"body') !== false) {
            $body=explode('[{"body', $tarea[$i] );
            //echo "<b>bodies $i:</b> ".$body[1]."<br><br>";
            //\",\"id\":
            if (strpos($body[1], '\",\"id\":') !== false) {
                $body2=explode('\",\"id\":', $body[1] );
                //echo "<b>bodies2 $i:</b> ".$body2[0]."<br><br>";
                
                //}]
                $body2cod=explode('}]', $body2[1] );
                $IdP=trim($body2cod[0]);
                echo "<b>bodies2codP $i:</b> ".$body2cod[0]."<br>";
                
                //name\":\"
                if (strpos($body2[0], 'name\":\"') !== false) {
                    $body3=explode('name\":\"', $body2[0] );
                    $CarpetaP=trim($body3[1]);
                    echo "<b>bodies3P $i:</b> ".$body3[1]."<br>";
                    
                    //compartida con
                    $comparteP=explode('Forms",', $tarea[$i] ); //ojo index***********************
                    $comparteP2=explode('],"comments', $comparteP[1] );
                    //$SharedP=$comparteP2[0];
                    $SharedAuxP= str_replace('","',',',$comparteP2[0]);
                    $SharedP= str_replace('"','',$SharedAuxP);
                    echo "<b>SharedP $i:</b> ".$SharedP."<br><br>";
                }
            }
           
        }
        
        
         
        $aux0=explode('"owners":[],"', $tarea[$i] );
        $auxb=explode('":', $aux0[1] );
        $filtro=$auxb[0];
        if($filtro=='id'){
            
            //id
            $auxc=explode(',"title":"', $aux0[1] );
            $idS=str_replace('id":','',$auxc[0]);
            $idS=trim($idS);
            echo "<b>id sub:</b> ".$idS."<br>";
            
            //titilo
            $auxd=explode(',"title":"', $aux0[1] );
            $auxe=explode('","dateCreated', $auxd[1] );
            $SubCarpet=trim($auxe[0]);
            echo "<b>SUB carpeta:$i</b> ".$SubCarpet."<br>";
           
            $comparteS=explode('"shared":[', $tarea[$i] ); //ojo index***********************
            $comparteS2=explode(',"bot', $comparteS[1] );
            $SharedAuxS= str_replace('","',',',$comparteS2[0]);
            $SharedS= str_replace('"','',$SharedAuxS);
            echo "<b>SharedS $i:</b> ".$SharedS."<br><br><hr><hr><br>";
        }
    
    }
    
    //INSERTAR DATOS
   /*
    $resultSQL = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[foldersWrike] WHERE idP='".$IdP."' and idS='".$idS."' and nombrecarp='".$CarpetaP."' and nombresubcarp='".$SubCarpet."'");
        $canty= mssql_num_rows($resultSQL);
        //$result = mysqli_query($cLink,$resultSQL);
        //if($row = mysqli_fetch_array($result)){
        if($canty == 0){
           
                $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[foldersWrike](idP,nombrecarp,sharedP,idS,nombresubcarp,sharedS) 
                VALUES('$IdP','$CarpetaP','$SharedP','$idS','$SubCarpet','$SharedS')"; 
                mssql_query($sqlv,$cLink);

        } 
    
    */
    $i++;
}

//mssql_close();
    
?>