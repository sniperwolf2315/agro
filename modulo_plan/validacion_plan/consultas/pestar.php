<?php
include("../config/conexion.php");



function mostrar_tablap(){
    $sql_planag = "select * from consultaplanpe";
    global $consultapag;
    $consultapag=mssql_query($sql_planag);

    $columns = "select * from INFORMATION_SCHEMA.COLUMNS where  TABLE_NAME = 'consultaplanpe'";
    global $columnsenc;
    $columnsenc=mssql_query($columns);

    echo'
    

        
        <table>';
      
    
    while($row=mssql_fetch_array($columnsenc)){
        echo'
        
                <th>'.$row['COLUMN_NAME'].'</th>
       
        
        ';
    }
            
            
            while ($row = mssql_fetch_array($consultapag)) {
                echo '
                <tr>
                <td>'.$row[0].'</td>
                <td>'.$row[1].'</td> <!--cedula--> 
                <td>'.$row[2].'</td>
                <td>'.$row[3].'</td>
                <td>'.$row[4].'</td>
                <td>'.$row[5].'</td>
                <td>'.$row[6].'</td>
                <td>'.$row[7].'</td>
                <td>'.$row[8].'</td>
                <td>'.$row[9].'</td>
                <td>'.$row[10].'</td>
                
                </tr>
         ';
    }
    echo'
        </table>
        ';


};
// mostrar_tabla();


?>

