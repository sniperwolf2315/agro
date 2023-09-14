<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$bus_usu=trim($_GET['b']);
$usuario=strtoupper($bus_usu);

include('conectarbasepruebas.php');

$query1="select ru.id as id_user,ru.active as esta_user,ru.partner_id,ru.login as login,
rp.name as nombre,rp.ref as identi
from res_users ru
left join res_partner rp on ru.partner_id=rp.id
where ru.login='$usuario' OR
rp.name like '%$usuario%' or
rp.ref='$usuario';";

$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Realizo la b&uacute;squeda de: ".$usuario."</p>";
echo 'AQUI: '.$r;
exit();
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\" >";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado.</td>";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Login</td>";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Nombre</td>";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Identidad C.C.</td>";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">";
        $r=$r."Boton Primario</td>";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Bot&oacute;n Secundario</td>";
        $r=$r."</tr>";


        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#DCFBF1";
        }else{
            $color="#E8F6F3";
        }
        $d2=$dato1['esta_user'];
        $d3=$dato1['login'];
        $d4=$dato1['nombre'];
        $d5=$dato1['identi'];
                        //activarUsbtnP(cedu,nombre,usuario,bt1)
                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>";
                                $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d2."</td>";
                                $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d3."</td>";
                                $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d4."</td>";
                                $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d5."</td>";
                               $r=$r." <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>";
                                //consulta botones primarios
                                $r=$r."<table>";
                                $r=$r."<tr style='background-color: #53B998;'><td>boton</td><td>Activar</td><td>Desactivar</td></tr>";
                                $resultSqlP = mssql_query("SELECT Id, boton, identificador FROM [InformesCompVentas].[dbo].[botonreportp]");
                                $b=1;
                                //6FBEA4
                                while($resultadoP = mssql_fetch_array($resultSqlP)){
                                    if(($b%2)==0){
                                        $color2="#A5E1CE";
                                    }else{
                                        $color2="#94C9B8";
                                    }
                                    $btId=$resultadoP["Id"];
                                    $btn=$resultadoP["boton"];
                                    $idbtn=$resultadoP["identificador"];
                                    $r=$r."<tr style='background-color: $color2;' >";
                                    $r=$r."<td>";
                                    $r=$r.$btn;                                    
                                    $r=$r."</td>";
                                    $r=$r."<td>";
                                    $r=$r."&nbsp;<input type=button id=\"$idbtn\" name=\"$btn\" onclick=\"buscarBotonesSec(this.id,this.name,'A','$d3','$d4','$d5','P');\" name=1 value=A>&nbsp;";                                     
                                    $r=$r."</td>";
                                    $r=$r."<td>";
                                    $r=$r."&nbsp;<input type=button id=\"$idbtn\" name=\"$btn\" onclick=\"buscarBotonesSec(this.id,this.name,'D','$d3','$d4','$d5','P');\" name=2 value=D>&nbsp;";                                     
                                    $r=$r."</td>";
                                    $r=$r."</tr>";
                                    $b++;
                                }
                                $r=$r."</table>";
                                
                                $r=$r."</td>";
                                $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>";
                                //botones secundarios
                                $r=$r."<div id=\"verbotons\"></div>";
                                
                                $r=$r."</td>";
                            $r=$r."</tr>";
                            $i++;
}
$r=$r . "</table>";
//CERRRAR CONEXION BASE
mssql_close();
Conexion::cerrarConexion();

echo $r;
?>