<?php
/* tenemos uns listado con cantidades para saber si se han revivido */
$consulta_revividas="SELECT 
                Orden ,
                count(Orden ) repite
              from 
                facRegistroFactura
              where 
                year(Fecha)=YEAR(GETDATE()) 
                and month(Fecha) = MONTH(getdate())
                and (Fecha is not null and FechaIngreso is not null)
              group by 
                Orden
              having 
                count(Orden )in(3,5)
              order by 
                Orden";

                
/* tenemos el listado de las orfenes ya quemadas en el sia.net = a despachadas */
$consulta_despachadas="SELECT Orden from facRegistroFactura where year(Fecha)=YEAR(GETDATE()) ";

?>
