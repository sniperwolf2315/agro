<?php
$cadena="Pépe es ñato pero físico último papÁ ÉSTE SÍTIO ÓRDENO";
echo $cadena;
//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);
 
		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );
 
		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );
 
		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );
 
		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );
        
        //Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena);
 
 echo "<br>".$cadena;
 exit;

require('../_lupap.php');
$cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);
    
      $direccion = 'Calle 79b nº 70f-30';
      $direCliente=utf8_decode($direccion); //agregado
      $direClientesql=substr($direCliente,0,20); //agregado
      $idclienteord = trim('51625332');    //agregado
      $ciudad ='Bogotá D.C.';
      
      /*prueba 1*/
      $direCliente=utf8_decode($direccion); //agregado
      $direClientesql=substr($direCliente,0,20); //agregado
      $ciudad ='bogota';
      //***AQUI CONSULTA TABLA agrCodigoPostal EN sqlSever para traer codigos postales o insertarlos***
      
      //***
      //$resultLU = geocode($ciudad, $direccion); 
      
      
      //***
      
      $direClientesql=utf8_decode(substr($direccion,0,20)); //agregado
      $direClientesqlb=substr($direccion,0,20); //agregado
      $direClientesqlN= strtoupper(substr($direccion,0,20));
      $barioLup="";
        $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, CodPostal as codPst, Barrio as Barriolup, Localidad As localidad, Dirnormalizada as dirnorm FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE (left(Direccion,20)='$direClientesql' OR left(Direccion,20)='$direClientesqlb' OR left(Dirnormalizada,20)='$direClientesqlN')",$cLink);
        if (!mssql_num_rows($SqlLupa)) {
            $resultLU = geocode($ciudad, $direccion); 
            //$codPostaLup = $_POST[post_code];
            $barioLup = $_POST[barrio]; 
            $entra="1";
        }else{
           if($rowPed = mssql_fetch_array($SqlLupa)){
                $entra="2";
                $barioLup = utf8_encode($rowPed[Barriolup]);
                $localidadLup = utf8_encode($rowPed[localidad]);
                $dirnormLup = utf8_encode($rowPed[dirnorm]);
                $codpostLup = utf8_encode($rowPed[codPst]);
                $_POST[barrio]=$barioLup;
                $_POST[localidad]=$localidadLup;
                $_POST[dir_norm]=$dirnormLup;
                $_POST[post_code]=$codpostLup;
            } 
        }  
      
      echo $entra."---: ".$_POST[barrio]."---".$_POST[localidad]."---".$_POST[dir_norm]."---".$_POST[post_code];
       exit();
      $copPostLupap="";
      //AND left(Direccion,20)='$direClientesql'
    /*  $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, Direccion as DirCliente, CodPostal as codPst  FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE IdUsuario='$idclienteord'");
    if (!mssql_num_rows($SqlLupa)) {
            //CODIGO POSTAL LUPAP
            $resultLU = geocode($ciudad, $direccion);
            $latitudLupa=$_POST[latitud];
            $longitudLupa=$_POST[longitud];
            $LocalidadLupa=$_POST[localidad];
            $dirNormalizadaLupa=$_POST[dir_norm];
            $codPostaLup = $_POST[post_code];
            $barioLup = $_POST[barrio];
            if($codPostaLup != ""){
                $copPostLupap=$codPostaLup;
                //echo "inserta: ".$copPostLupap;
                $sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,Dirnormalizada,Localidad,CodPostal,Barrio,Latitud,Longitud) 
                VALUES('$idclienteord','$direCliente','$dirNormalizadaLupa','$LocalidadLupa','$codPostaLup','$barioLup','$latitudLupa','$longitudLupa')"; 
                mssql_query($sqlord,$cLink);
            }else{
                $codPostaLup = '11001000';
                $copPostLupap = '11001000';
                $barioLup="Bogota D. C.";
                //echo "asigna: ".$copPostLupap;
            }
      }else{
           if($rowPed = mssql_fetch_array($SqlLupa)){
                //dir base
                $dirBuscarBd = $rowPed[DirCliente];
                $dirBuscarBd=trim($dirBuscarBd);
                //dir magento
                $direClienteMg=utf8_decode($direccion); //agregado
                $direClienteMg=trim($direClienteMg);
                
                $direClienteBad=substr($dirBuscarBd,0,10); //agregado
                $direClienteMag=substr($direClienteMg,0,10); //agregado
                if($direClienteBad == $direClienteMag){
                    //echo "lee: dirbase".$direClienteBad."----mag:".$direClienteMag;
                    $copPostLupap = $rowPed[codPst];
                }else{
                    //mira y actualiza codigo postal del cliente en base codigospostales por cambio de direccion
                    $resultLU = geocode($ciudad, $direccion);
                    $latitudLupa=$_POST[latitud];
                    $longitudLupa=$_POST[longitud];
                    $LocalidadLupa=$_POST[localidad];
                    $dirNormalizadaLupa=$_POST[dir_norm];
                    $codPostaLup = $_POST[post_code];
                    $barioLup = $_POST[barrio];
                    if($codPostaLup != ""){
                        //echo "Actualiza: dirbase".$direClienteBad."----mag:".$direClienteMag;
                        $sqlord = "UPDATE [sqlFacturas].[dbo].[agrCodigoPostal] SET Direccion='$direccion', Dirnormalizada='$dirNormalizadaLupa', Localidad='$LocalidadLupa', CodPostal='$codPostaLup', Barrio='$barioLup', Latitud='$latitudLupa', Longitud='$longitudLupa' WHERE IdUsuario='$idclienteord'"; 
                        mssql_query($sqlord,$cLink);
                    }
                }
           } 
      }
    */
    //FIN PRUEBA
    //echo $Pueblo."-----".$Barrio."-----".$codPostLupap;
    exit();
    //fin p1
      
      //AQUI CONSULTA TABLA agrCodigoPostal EN sqlSever
      $copPostLupap="";
      $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, CodPostal as codPst  FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE IdUsuario='$idclienteord' AND left(Direccion,20)='$direClientesql'");
      //$resultord = mssql_query($SqlLupa,$cLink);
      if (!mssql_num_rows($SqlLupa)) {
            //CODIGO POSTAL LUPAP
            $resultLU = geocode($ciudad, $direccion);
            $latitudLupa=$_POST[latitud];
            $longitudLupa=$_POST[longitud];
            $LocalidadLupa=$_POST[localidad];
            $dirNormalizadaLupa=$_POST[dir_norm];
            $codPostaLup = $_POST[post_code];
            $barioLup = $_POST[barrio];
            if($codPostaLup != ""){
                $copPostLupap=$codPostaLup;
                $sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,Dirnormalizada,Localidad,CodPostal,Barrio,Latitud,Longitud) 
                VALUES('$idclienteord','$direCliente','$dirNormalizadaLupa','$LocalidadLupa','$codPostaLup','$barioLup','$latitudLupa','$longitudLupa')"; 
                mssql_query($sqlord,$cLink);   
            }else{
                $codPostaLup = '11001000';
                $copPostLupap = '11001000';
                $barioLup="Bogota D. C.";
                /*$sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,CodPostal,Barrio) 
                VALUES('$idclienteord','$direCliente','$codPostaLup','$barioLup')"; 
                mssql_query($sqlord,$cLink);*/
            }
      }else{
           if($rowPed = mssql_fetch_array($SqlLupa)){
                $copPostLupap = $rowPed[codPst];
            } 
      }
      mssql_close();
      echo "Resultado=".$copPostLupap;
?>