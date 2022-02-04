<?php
include('conectarbasepruebas.php');
$miruta='Rutas/';
        $nombre_fichero = 'barriosbogota';
        $mipath=$miruta.$nombre_fichero.'.xls';
        if(file_exists($miruta)) {
            include('Classes/PHPExcel.php');
            include('Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            $archivo = $mipath;
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
                
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
                //$highestRow
            //echo "aqui";
            require('_lupap.php');
            for ($row = 2; $row <= $highestRow; $row++){
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                foreach($rowData as $dato){
                    $barrio=trim($dato[0]);
                    $barrioB=utf8_decode($barrio);
                    $codPostLupap=trim($dato[1]);
                    $localidad=trim($dato[2]);
                    //$CodPostal='';
                    //echo $barrio."---";
                    //exit();
                    setlocale(LC_MONETARY, 'en_US');
                    //lupap
                    if($codPostLupap==""){
                        $direccion = trim($barrio);
                        $DirLup=substr($direccion,0,30);
                        $ciudad ='bogota';
                        $Pueblo='Bogotá D.C.';
                        $resultLU = geocode($ciudad, $DirLup);
                        $codPostLupap='';
                        $localidad='';
                        //$Barrio = $_POST[barrio]; 
                        if($resultLU==null || strlen($resultLU) < 4){
                            $codPostLupap='';
                            $localidad='';
                        }else{
                            $codPostLupap=$_POST[post_code];
                            $localidad=$_POST[localidad];
                        }
                    }
                    //echo "aqui1";
                    $localidad=utf8_decode($localidad);
                    //AND codPostal='".$codPostLupap
                    //cuando base vacia***
                    $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[barriosBogota] WHERE Barrio='".$barrio."' AND codPostal='".$codPostLupap."' AND localidad='".$localidad."'");          
                    //cuando actualiza el cod postal****
                    //$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[barriosBogota] WHERE Barrio='".$barrio."' AND localidad=''");
                    if (!mssql_num_rows($query)) {
                        //echo $barrio."----";
                        $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[barriosBogota](Barrio,codPostal,codBarrio) 
                        VALUES('$barrioB','$codPostLupap','$localidad')"; 
                        mssql_query($sqlv,$cLink);
                        $codPostLupap='';
                        $localidad='';
                        //exit();
                    }else{
                        //echo $barrio."°°°°°";
                        //echo "aqui3";
                        //$barrbusc=substr($barrio,1,6);
                        //echo $barrbusc;
                        //exit();
                        //if(strlen($barrioB,6)=='Marant'){
                        //$sqlv = "UPDATE [InformesCompVentas].[dbo].[barriosBogota] SET codPostal='$codPostLupap', localidad='$localidad' WHERE Barrio='".$barrio."' AND codPostal=''";
                        //mssql_query($sqlv,$cLink);
                        //}
                        $codPostLupap='';
                        $localidad='';
                        //exit();
                    }   
                }
            }
          
    }
mssql_close();
echo "Proceso Terminado";
?>