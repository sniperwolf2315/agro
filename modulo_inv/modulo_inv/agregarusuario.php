<?php
$usuario=trim($_GET['nu']);
$usuario=strtoupper($usuario);
$idusuario=trim($_GET['u']);
//$usuario=strtoupper($usuario);
$clave=trim($_GET['c']);
$clave=strtoupper($clave);
$tipo=trim($_GET['t']);

$v1=trim($_GET['v1']);

$v2=trim($_GET['v2']);

//$estado=$_GET['e'];
if($tipo=='A'){
    $pw=md5($clave);
}else{
    $pw='';
}
if($usuario=="BUSCARID"){
    require_once('conexionFacturas.php');
    $resultusuY = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[autFuncionario] WHERE Login ='$idusuario'", $cLinkf);
    $fila2 = mssql_fetch_array($resultusuY);
    $usuario=$idusuario;
    $idusuario=$fila2['IdFuncionario'];
}
$Acceso=0;
$estado="Usuario no agregado";
            /*require_once('conexionFacturas.php');
            $resultusuY = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[autFuncionario] WHERE Login ='$usuario'", $cLinkf);
            $fila2 = mssql_fetch_array($resultusuY);
            $IdFunc=$fila2['IdFuncionario'];*/
            //****
            require_once('conexioninventario80.php');
            $resultusu = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invAcceso] WHERE idUsu='$idusuario'", $cLink);
            $fila = mssql_fetch_array($resultusu);
            $numero = mssql_num_rows($resultusu);
            
            if($tipo=='A'){
                if ($numero<=0){
                    $consulta2="INSERT INTO [sqlInventario008].[dbo].invAcceso(idUsu,pasw,tipous,acceso1,acceso2,acceso)";
                    $consulta2=$consulta2." VALUES('$idusuario','$pw','$tipo','$usuario','$v2',1)";          
                    $resultado1=mssql_query($consulta2); 
                    $estado="Usuario agregado como administrador";
                }else{
                    $estado="Usuario ya existe";
                }
            }
            if($tipo=='U'){
                if ($numero<=0){
                    
                    $consulta2="INSERT INTO [sqlInventario008].[dbo].invAcceso(idUsu,pasw,tipous,acceso1,acceso2,acceso)";
                    $consulta2=$consulta2." VALUES('$idusuario','$pw','$tipo','$usuario','$v2',1)";          
                    $resultado1=mssql_query($consulta2,$cLink); 
                    if($resultado1){
                        $estado="Usuario actualizado";
                    }else{
                        $estado="Usuario no pudo ser actualizado";
                    }
                }else{
                    //actualizar
                    //estado habilita el boton
                    $consulta2="UPDATE [sqlInventario008].[dbo].invAcceso SET acceso2='$v2' WHERE idUsu='$idusuario' AND tipous='U'";
                    $resultado1=mssql_query($consulta2,$cLink); 
                    if($resultado1){
                        $estado="Usuario actualizado";
                    }else{
                        $estado="Usuario no pudo ser actualizado";
                    }
                }
            }
            mssql_close($resultusu);
            mssql_close($resultado1);
            mssql_close($resultusuY);
           echo $estado; 
?>