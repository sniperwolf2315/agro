<?php
//include_once 'user_con_sql.php';
//Conexion::abrirConexion();
//$Conn = Conexion::obtenerConexion();
include('conectarbase.php');

/*
$query="";
$resultado= $Conn->prepare($query);
$resultado->execute();
$datos=$resultado->fetchAll();
foreach($datos as $dato){
    $d1=$dato['ide'];
}
Conexion::cerrarConexion();
*/
$t=0;
$usuariosnom=new ArrayIterator();
$usuarioscod=new ArrayIterator();
$tarea = new ArrayIterator();
$fp = fopen("users.txt", "r");
while (!feof($fp)){
    $tarea[$t] = fgets($fp);
    $t++;
}
$f=0;
$subt=explode('^', $tarea[0]);
$contacomp=count($subt);
$i=0;
    while($i<$contacomp){
        $n=explode('firstName":"', $subt[$i]);
        $n2=explode('","', $n[1]);
        $pnom=$n2[0];
        //echo "<b>nombres $i: </b>".$pnom."<br><hr>";
        
        $a=explode('lastName":"', $subt[$i]);
        $a2=explode('","', $a[1]);
        $ape=$a2[0];
                
        $c=explode('uid":"', $subt[$i]);
        $c2=explode('","', $c[1]);
        $cod=trim($c2[0]);
        
        $e=explode('email":"', $subt[$i]);
        $e2=explode('","', $e[1]);
        $email=$e2[0];
        $nombre=$pnom." ".$ape;
        
        $nombre2=utf8_decode($nombre);
        //$nombre2=str_replace("Ñ","&Ntilde;",$nombre);
        //$nombre3=str_replace("ñ","&ntilde;",$nombre2);      
        $i++;
        //ingresa datos a base
        
        $resultSQL = mssql_query("SELECT id FROM [InformesCompVentas].[dbo].[usuariosWrike] WHERE id='$cod'");
        $canty= mssql_num_rows();
        if($canty <= 0){
            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[usuariosWrike](id,nombre,email) 
            VALUES('$cod','$nombre2','$email')"; 
            mssql_query($sqlv,$cLink);
        }    
        
    }
    
    
    
    $resultSQL2 = mssql_query("SELECT id, nombre, email FROM [InformesCompVentas].[dbo].[usuariosWrike]");
    while($resultado = mssql_fetch_array($resultSQL2)){
        $id=$resultado["id"];
        $nm=$resultado["nombre"];
        $nombre=utf8_encode($nm);
        $em=$resultado["email"];
        echo "<b>usuario: </b>".$id." ".$nombre." ".$em."<br><hr>";
    }
    
    mssql_close();
        //echo "<b>tarea $i: </b>".$subt[$i]."<br><hr>";
        /*$r=explode(';', $subt[$i]);
        $contacomp2=count($r);
        $j=1;
        while($j<$contacomp2){
            $r1='\u003c/a\u003e';
            $r2=explode($r1, $r[$j]);
            $r3=$r2[0];
            echo "<b>componente $j: </b>".$r[$j]."<br><hr>";
            //echo "<b>nombre $j: </b>".$r3."<br><hr>";
            $u2='rel\u003d\"';
            $r4=explode($u2, $r2[1]);   //parte derecha del nombre
            $c4=count($r4);
            if($c4>1){
                $cod=$r4[1];
                $r5='\"\u003e\u';
                $r6=explode($r5, $cod);
                $codus=$r6[0];
            }else{
                $codus='-';
            }
            if($codus != '-'){
                $usuariosnom[$f]=$r3;
                $usuarioscod[$f]=$codus;
                $f++;
            }
            //echo "<b>Usuario $j: </b>".$r3."  ".$codus."<br><hr>";
            $j++;
        }
        $i++;
        */
   
    
    /*$fila=0;
    $contaus=count($usuariosnom);
    while($fila < $contaus){
        echo "<b>Usuario $j: </b>".$usuariosnom[$fila]."  ".$usuarioscod[$fila]."<br><hr>";
        $fila++;
    }*/
?>