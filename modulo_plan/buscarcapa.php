<?php
            include('conectarcronoseg.php');
            $id=$_GET['id'];
            
            $result = mssql_query("SELECT DISTINCT Nombres,Apellidos FROM audEmpleado WHERE RIGHT(CodTarjeta,8)='$id' GROUP BY CodTarjeta");//WHERE CodTarjeta like '%$id'
            $resultado = mssql_fetch_array($result);
            if ($resultado){
                $d1=$resultado["Nombres"];
                $d2=$resultado["Apellidos"];
                //$d1=$resultado[0];
                echo $d1." ".$d2;
               //echo $id;
            }
            mssql_close();
            

?>