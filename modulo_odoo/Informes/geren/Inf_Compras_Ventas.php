<?php

setlocale(LC_TIME, 'es_ES');
session_start();
include('../conectarbase.php'); //sql server 
include('../usercon_odoo.php'); // postgrees sql
// require_once('../conectarbasepruebas.php');




Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

$anio       = trim($_GET['a']);
$mes        = trim($_GET['m']);
$consulta   = trim($_GET['consulta']);
$anio_desde = trim($_GET['anio_desde']);
$mes_desde  = trim($_GET['mes_desde']);
$anio_hasta = trim($_GET['anio_hasta']);
$mes_hasta  = trim($_GET['mes_hasta']);




$anio_p = trim($_POST['a']);
$mes_p = trim($_POST['m']);
$consulta_p = trim($_POST['consulta']);
/* 
    echo 'anio_p'.$anio_p.'<br>mes_p'.$mes_p.'<br>'; 
    $anio = $_POST['anio_uno'];
    $mes  = $_POST['mes_uno'];
*/


/* if ($consulta == 'normal') {
    echo 'consulta ' . $consulta . '<br>' . 'anio->' . $anio . '<br>mes->' . $mes . '<br>';
} else {
    echo 'consulta->' . $consulta . '<br>' .
        'anio->' . $anio . '<br>' .
        'mes->' . $mes . '<br>' .
        'Año desde->' . $anio_desde . '<br>' .
        'mes desde->' . $mes_desde . '<br>' .
        'Año hasta->' . $anio_hasta . '<br>' .
        'mes hasta->' . $mes_hasta . '<br>';
} */


/* 
    solo si se habilita la sesion para PHP
    $anio = $_SESSION['a2'];
    $mes = $_SESSION['m']; 
    echo $anio.'<br>';
    echo $mes.'<br>';
*/

/*
                                 //SI SE REQUIEREN PASAR VALOR FIJOS SE DEBE HABILITAR ESTA SECCION
    $anioReport='2022';
    $anioReportAnt=$anioReport;
    $mesReport='03'; 
    $periodo="202001";
*/

strlen($anio) === 0 ? $anio = date("Y") : $anio = $anio;
strlen($mes)  === 0 ? $mes = date("m") : $mes = $mes;

$anioReport = $anio;
$anioReportAnt = strval($anioReport);
$mesReport = $mes;

//fecha actual
$anioA = $anio;
$mesA = $mes;
$mesN = $mesA;

$fechaActual = $mesN . " " . $anioA;


//////////////////////////

$periodo = trim($_GET['periodo']);
$categ = new ArrayIterator();
$manejanom = new ArrayIterator();
$manejacat = new ArrayIterator();
//newhoy
$periodoi = substr($periodo, 0, 4);
$anio = $periodoi;
$periodoi = $periodoi . "01";
$m = substr($periodo, 4, 2);

$inicial = $m - 1;
$final = $m;
//mes anterior y actual
$mesant = $inicial;
$mesact = $final;

if (strlen($inicial) == 1) {
    $inicial = "0" . $inicial;
}
if (strlen($final) == 1) {
    $final = "0" . $final;
}
$inicial = $anio . $inicial;
$final = $anio . $final;
//evalua periodo anterior en caso de enero
if (intval($mesact) == 1 || $mesact == "01") {
    $mesact = 12;
    //a�o anterior y mes
    $anio = (intval($anio) - 1);
    $peranterior = $anio . $mesact;
} else {
    $mesact = (intval($mesact) - 1);
    if (strlen($mesact) == 1) {
        $mesact = "0" . $mesact;
    }
    $peranterior = $anio . $mesact;
}

//limpia array solo la primera vez no con los demas manejadores
$tamcg = count($categ);
for ($cg = 0; $cg <= $tamcg; $cg++) {
    $categ[$cg] = "";
}

$tamcg = count($manejanom);
for ($cg = 0; $cg <= $tamcg; $cg++) {
    $manejanom[$cg] = "";
}

$TotalCat = 0;
$TotalMan = 0;
$mes = array('', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
$mm = intval($m);
$Ms = $mes[$mm] . " " . $anio;



//mes actual y anterior inv inicial o final
if ((int)$mesReport == 1) {
    $mesReportAnt == 12;
    $anioReportAnt = $anioReportAnt - 1;
} else {
    $mesReportAnt = (int)$mesReport - 1;
}
if (strlen($mesReport) == 1) {
    $mesReport = '0' . $mesReport;
}
if (strlen($mesReportAnt) == 1) {
    $mesReportAnt = '0' . $mesReportAnt;
}

$TotalCat = 0;
$TotalMan = 0;
$i = 0;

$r = "";
$r = $r . "<p style=\"text-align: center;\" class=\"z-depth-1\">Esta visualizando el informe: </p>";
$r = $r . "<p style=\"text-align: center;\" class=\"z-depth-1\">Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: </p>"; //Fecha Inicio: ".$feini." - hasta: ".$fefin.".
$r = $r . "<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
$r = $r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
$r = $r . "<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TIPO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTADO ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA ORDEN</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">PROVEEEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCR. PROVEEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ITEM</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Codigo_Barras</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DESCRICPION</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD SOLICITADA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD RECIBIDA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CANTIDAD DEVUELTAS</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTADO LINEA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">OLITIT</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">VALOR X UND.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TOTAL</td><td>";
$r = $r . "</tr>";

//consultas a la base
$i = 0;
$iA = 0;

$iC = 0;
$iD = 0;
//$nomA
$logA = new ArrayIterator();
$parA = new ArrayIterator();
//NOMBRE DEL MANEJADOR
global $iB;

$iB = 0;
$logginB = new ArrayIterator();
$maneB = new ArrayIterator();

$queryB = "
            select
                u.login as login, 
                rp.name as nombre
            from res_users u
                inner join  res_partner rp on u.partner_id=rp.id
            where 
                u.login in('SUAREZM','RODRIGUEZF','BARONF','PINILLOSM')
            and u.active =true
            order by 
                u.login asc
        ";

$resultadoB = $Conn->prepare($queryB);
$resultadoB->execute();
$datosB = $resultadoB->fetchAll();

foreach ($datosB as $datoB) {
    $loggin = $datoB['login'];
    $logginB[$iB] = trim($loggin);
    $nameus = $datoB['nombre'];
    $maneB[$iB] = trim($nameus);
    $iB++;
}

// NO HAY DATOS PARA CONSULTAR
// GRUPOS Y NOMBRE DEL PRODUCTO X MANEJADOR
$gprC = new ArrayIterator();
$desC = new ArrayIterator();
$manC = new ArrayIterator();
$catC = new ArrayIterator();

//manejadores*******************************************************************
$numan = count($logginB);
$m = 0;

/*
/**
 *                          #ojo activar al terminar si usa tabla temporal***
                            $resultSqlB = mssql_query("truncate table [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo]");
                            $resultadoB=mssql_query($resultSqlB);
*/

while ($m < $numan) {
    $QueryG = "
        select
            c2.name AS categoria,
            split_part(c1.name, '-', 1) AS grupo,
            u.login as manejador
        from 
            product_category c1
            left join product_category c2 on c1.parent_id=c2.id
            left join product_template t ON c1.id = t.categ_id
            left join res_users u ON t.product_manager=u.id
        group 
            by c2.name, split_part(c1.name, '-', 1),u.login
        having 
            c2.name is not null
            and c2.name not like '%CONTABILIDAD%' 
            and c2.name not like '%SERVICIOS%' 
            and c2.name not like '%ACTIVOS FIJOS%'
            and u.login in('$logginB[$m]')
        order by 
            split_part(c1.name, '-', 1) asc
    ";
    $resultadoC = $Conn->prepare($QueryG);
    $resultadoC->execute();
    $datosC = $resultadoC->fetchAll();

    foreach ($datosC as $datoC) {
        $grp = trim($datoC['grupo']);
        $QueryNom = "
        select 
            trim(
                    case when substr(c1.name,4,2)='- ' then substr(c1.name,8,40) 
                        when substr(c1.name,5,2)!=' ' then substr(c1.name,5,40) 
                        else substr(c1.name,7,40) end) as desc_grupo
        from 
            product_category c1
        where 
            split_part(c1.name, '-', 1) ='$grp' limit 1
        ";
        $dgrp = "-";
        $resultadoN = $Conn->prepare($QueryNom);
        $resultadoN->execute();
        $datosN = $resultadoN->fetchAll();
        foreach ($datosN as $datoN) {
            $dgrp = trim($datoN['desc_grupo']);
        }
        $man = $datoC['manejador'];
        $gprC[$iC] = trim($grp);
        $desC[$iC] = trim($dgrp);
        $manC[$iC] = trim($man);
        $Categ = $datoC['categoria'];
        $catC[$iC] = trim($Categ);
        $iC++;
    }
    $m++;
}
/*
                                fin carga de grupos y categorias*********************************************************    

                                QUERY DE VENTAS**************************************************************************
 */
$VentGrp = new ArrayIterator();
$VentMan = new ArrayIterator();
$VentVal = new ArrayIterator();
$QueryV = "
    select
        --o.name,
        --p.default_code,
        left(c1.name,3) as grupo,
        trim(substr(split_part(c1.name, '-', 2),5,50)) as descgrupo,
        sum(il.quantity) as cantidadvend,
        sum(il.price_subtotal) as valor,
        trim(u.login) as manejador
    from 
        sale_order o
        left join sale_order_invoice_rel oi ON o.id=oi.order_id
        left join account_invoice cf ON oi.invoice_id=cf.id and o.state='done'
        left join account_invoice_line il ON cf.id=il.invoice_id
        left join product_product p ON (ltrim(split_part(il.name, ']', 1),'['))=p.default_code
        left join product_list_item i ON i.product_id=p.id
        left join product_template t ON p.product_tmpl_id=t.id
        left join product_category c1 ON t.categ_id=c1.id
        left join res_users u ON t.product_manager=u.id
    GROUP BY
        left(c1.name,3),
        trim(substr(split_part(c1.name, '-', 2),5,50)),
        u.login,
        o.state,
        left(cf.internal_number,1) IN('F','S','D','0'),
        EXTRACT(YEAR FROM  cf.date_invoice),
        EXTRACT(MONTH FROM  cf.date_invoice)
        HAVING o.state='done' 
        ";
if ($consulta == 'normal') {
    $sql_where = "and EXTRACT(YEAR FROM  cf.date_invoice)  =  $anioReport  and EXTRACT(MONTH FROM  cf.date_invoice) =  $mesReport 
                  and left(cf.internal_number,1) IN('F','S','D','0')
                order by 
                  left(c1.name,3) asc
            ";
} else {
    $sql_where = "and EXTRACT(YEAR FROM  cf.date_invoice) between $anio_desde and $anio_hasta 
                  and left(cf.internal_number,1) IN('F','S','D','0')
                order by 
                  left(c1.name,3) asc
            ";
}


$QueryV = $QueryV . $sql_where;


$resultadoV = $Conn->prepare($QueryV);
$resultadoV->execute();
$datosV = $resultadoV->fetchAll();
$m = 0;


foreach ($datosV as $datoV) {
    /*
                                            ojo si es necesario pendiente sumar por grupos repetidos del usuario
*/

    $VentGrp[$m] = $datoV['grupo'];
    $VentMan[$m] = $datoV['manejador'];
    $VentVal[$m] = $datoV['valor'];
    $m++;
}
/*
                                            verificacion de acumulados en caso de tener varias ventas por grupo
*/
$VentGrp2 = new ArrayIterator();
$VentMan2 = new ArrayIterator();
$VentVal2 = new ArrayIterator();
$cmp1 = 0;
$fil = 0;
$numCom = count($VentGrp);
while ($cmp1 < $numCom) {
    $grp = $VentGrp[$cmp1];
    $man = $VentMan[$cmp1];
    $val = $VentVal[$cmp1];
    $sumVal = 0;
    $cmp2 = 0;
    $esta = false;
    while ($cmp2 < $numCom) {
        if (trim($grp) == trim($VentGrp[$cmp2]) && trim($man) == trim($VentMan[$cmp2]) && trim($VentGrp[$cmp2] != "-")) {
            $sumVal = $sumVal + $VentVal[$cmp2];
            if ($cmp1 != $cmp2) {
                $VentVal[$cmp2] = 0;
                $VentGrp[$cmp2] = "-";
            }
            $esta = true;
        }
        $cmp2++;
    }
    if ($esta == true) {
        $VentGrp2[$fil] = $VentGrp[$cmp1];
        $VentMan2[$fil] = $VentMan[$cmp1];
        $VentVal2[$fil] = $sumVal;
        $fil++;
    }
    $cmp1++;
}

//QUERY DE COMPRAS
$compGrp = new ArrayIterator();
$compMan = new ArrayIterator();
$compCos = new ArrayIterator();
$compVal = new ArrayIterator();

$QueryC = "
    select distinct
        left(c1.name,3) as grupo,
        trim(substr(split_part(c1.name, '-', 2),5,50)) as descgrupo,
        p.default_code as item,
        p.name_template as nombre,
        o.name as ordencomp,
        ol.state as estadoord,
        avg(st.last_average_cost) as costo_promedio,
        max((st.cost + pi.price)/2) as costo,
        max(ol.product_qty) as cantidad,
        max(ol.price_unit * ol.product_qty) as valorcomp_exc_iva,
        o.date_order as fechaorden,
        trim(u.login) as manejador
    from 
        purchase_order o
        left join purchase_order_line ol ON o.id=ol.order_id
        left join purchase_invoice_rel oi ON ol.order_id=oi.purchase_id
        left join account_invoice cf ON o.id=cf.purchase_order_origin_id
        left join product_product p ON ol.product_id=p.id
        left join stock_move st ON o.name=st.origin
        left join product_template t ON p.product_tmpl_id=t.id
        left join product_category c1 ON t.categ_id=c1.id
        left join res_users u ON t.product_manager=u.id
        left join product_supplierinfo si ON p.product_tmpl_id=si.product_tmpl_id
        left join pricelist_partnerinfo pi ON si.id=pi.suppinfo_id
    GROUP BY
        left(c1.name,3),
        trim(substr(split_part(c1.name, '-', 2),5,50)),
        p.default_code,
        p.name_template,
        o.name,
        ol.state,
        o.date_order,
        trim(u.login),
        cf.supplier_invoice,
        EXTRACT(YEAR FROM  o.date_approve),
        EXTRACT(MONTH FROM  o.date_approve) 
        HAVING 

";
if ($consulta == 'normal') {
    $sql_where = "  EXTRACT(YEAR FROM  o.date_approve)  ='" . $anioReport . "' 
                    AND EXTRACT(MONTH FROM  o.date_approve) = '" . $mesReport . "'
                    and cf.supplier_invoice is not null and trim(u.login) is not null
                    and ol.state='done'
            ";
} else {
    $sql_where = "  EXTRACT(YEAR FROM  o.date_approve) between $anio_desde and $anio_hasta 
                    AND EXTRACT(MONTH FROM  o.date_approve) between $mes_desde and $mes_hasta
                    and cf.supplier_invoice is not null and trim(u.login) is not null
                    and ol.state='done'
    ";
}
$QueryC = $QueryC . $sql_where;

/*
                                    ojo suma por grupo cantidad, y costos excepto costo promedio
*/
$resultadoC = $Conn->prepare($QueryC);
$resultadoC->execute();
$datosC = $resultadoC->fetchAll();
$m = 0;
foreach ($datosC as $datoC) {
    /*
                                ojo si es necesario pendiente sumar por grupos repetidos del usuario
*/

    $grupoC1 = trim($datoC['grupo']);
    $manC1  = $datoC['manejador'];
    $costoC1 = $datoC['costo_promedio'];
    $valorC1 = $datoC['valorcomp_exc_iva'];
    $numCom = count($compGrp);
    //echo "CantidADX".$numCom."---";
    $compGrp[$m] = $grupoC1;
    $compMan[$m] = $manC1;
    $compCos[$m] = $costoC1;
    $compVal[$m] = $valorC1;
    $m++;
}
//sumatoria compras y costos por grupos
$compGrp2 = new ArrayIterator();
$compMan2 = new ArrayIterator();
$compCos2 = new ArrayIterator();
$compVal2 = new ArrayIterator();
$cmp1 = 0;
$fil = 0;
$numCom = count($compGrp);
while ($cmp1 < $numCom) {
    $grp = $compGrp[$cmp1];
    $man = $compMan[$cmp1];
    $val = $compVal[$cmp1];
    $cost = $compCos[$cmp1];
    $sumVal = 0;
    $sumCos = 0;
    $cmp2 = 0;
    $esta = false;
    while ($cmp2 < $numCom) {
        if (trim($grp) == trim($compGrp[$cmp2]) && trim($man) == trim($compMan[$cmp2]) && trim($compGrp[$cmp2] != "-")) {
            $sumVal = $sumVal + $compVal[$cmp2];
            $sumCos = $sumCos + $compCos[$cmp2];
            if ($cmp1 != $cmp2) {
                $compVal[$cmp2] = 0;
                $compCos[$cmp2] = 0;
                $compGrp[$cmp2] = "-";
            }
            $esta = true;
        }
        $cmp2++;
    }
    if ($esta == true) {
        $compGrp2[$fil] = $compGrp[$cmp1];
        $compMan2[$fil] = $compMan[$cmp1];
        $compVal2[$fil] = $sumVal;
        $compCos2[$fil] = $sumCos;
        $fil++;
    }
    $cmp1++;
}
/*
                                        #PRODUCTOS
                                        query todos los idProd de los productos por grupo y 4 manejadoreS
                                        solo los productos que tuvieron venta filtrado por grupo
*/
$productoInv = new ArrayIterator();
$grpProduInv = new ArrayIterator();
$manProduInv = new ArrayIterator();
$m2 = 0;
$numGrp = count($VentGrp2);
while ($m2 < $numGrp) {
    $grupoProd = trim($VentGrp2[$m2]);
    $QueryP = "select
        --,case when ((left(trim(split_part(pc.name, '-', 2)),2))='19' or (left(trim(split_part(pc.name, '-', 2)),2))='00') then right(trim(split_part(pc.name, '-', 2)),-2) else trim(split_part(pc.name, '-', 2)) end as desc_grupo
                        pp.id as idprod,
                        left(pc.name,3) as grupo,
                        ru.login as manejador
                from product_product pp
                        left join product_list_item pli ON pli.product_id=pp.id
                        left join product_template pt ON pp.product_tmpl_id=pt.id
                        left join product_category pc ON pc.id=pt.categ_id
                        left join res_users ru ON pt.product_manager=ru.id
                group by
                         pp.id,
                         ru.login
                         ,left(pc.name,3)
                         ,pc.name
                         ,pp.active=true
                having pp.active=true AND ru.login in('SUAREZM','RODRIGUEZF','BARONF','PINILLOSM')
                        and left(pc.name,3)='" . $grupoProd . "'
                        and left(pc.name,3) not in('Eva','Tod')
                ORDER BY ru.login ASC
        ";
    $resultadoP = $Conn->prepare($QueryP);
    $resultadoP->execute();
    $datosP = $resultadoP->fetchAll();
    $i = 0;
    foreach ($datosP as $datoP) {
        $productoInv[$i] = trim($datoP['idprod']);
        $grpProduInv[$i] = trim($datoP['grupo']);
        $manProduInv[$i] = trim($datoP['manejador']);
        $i++;
    }
    $m2++;
}

//QUERY INVENTARIO INICIAL
$grpInvInicial = new ArrayIterator();
$invCantInicial = new ArrayIterator();
$manInvInicial = new ArrayIterator();
//ARRAYS INV FINAL  
$grpInvFinal = new ArrayIterator();
$invCantFinal = new ArrayIterator();
$manInvFinal = new ArrayIterator();
$cantProdInv = count($productoInv);
$i = 0;
$m = 0;
$m2 = 0;
while ($i < $cantProdInv) {
    $idProd = trim($productoInv[$i]);
    $manInv = $manProduInv[$i];
    //echo $manInv."...";
    $QueryI = "select distinct
            max(ru.login) as manejador,
            max(EXTRACT(YEAR FROM  in_date)) AS anio,
            max(EXTRACT(MONTH FROM  in_date)-1) as mes,
            max(EXTRACT(MONTH FROM  in_date)) as mesultmov
        from stock_quant q
                left join product_product p on q.product_id = p.id
                left join product_template pt ON p.product_tmpl_id=pt.id
                left join res_users ru ON pt.product_manager=ru.id
        WHERE 
            q.product_id='" . $idProd . "' 
            and ru.login='" . $manInv . "' 
            and q.location_id NOT IN('8','9') limit 1
        ";

    $resultadoI = $Conn->prepare($QueryI);
    $resultadoI->execute();
    $datosI = $resultadoI->fetchAll();
    foreach ($datosI as $datoI) {
        $manInvI = trim($datoI['manejador']);
        $aniInvF = trim($datoI['anio']);
        $aniInvI = $aniInvF;
        // $mesInvI=trim($datoI['mes']);
        $mesInvI = trim($datoI[2]);
        $mesInvIF = trim($datoI['mesultmov']);
        /*  no tiene en cuenta el mes actual 
                                                si a�o mov es > reporte solicitado
                                            */
        if ((int)$aniInvF > (int)$anioReport) {
            //a�o = a�o reporte
            $aniInvF = $anioReport;
            $aniInvI = $anioReportAnt;

            if ((int)$mesInvIF > (int)$mesReport) {
                $mesInvIF = $mesReport;
                //si es enero retrocede un mes para el inicial
                if ((int)$mesInvIF == 1) {
                    $mesInvI = 12;
                    $aniInvI = $aniInvF - 1;
                } else {
                    $mesInvI = $mesInvIF - 1;
                }
            }
        } else if ((int)$aniInvF == (int)$anioReport) {
            if ((int)$mesInvIF > (int)$mesReport) {
                $mesInvIF = $mesReport;
                //si es enero retrocede un mes para el inicial
                if ((int)$mesInvIF == 1) {
                    $mesInvI = 12;
                    $aniInvI = $aniInvF - 1;
                } else {
                    $mesInvI = $mesInvIF - 1;
                }
            }
        }

        if ($aniInvI == '') {
            $aniInvI = $anioReport;
        }
        if ($aniInvF == '') {
            $aniInvF = $anioReport;
        }

        if ($mesInvI == '') {
            $mesInvI = $mesReport;
        }
        if ($mesInvIF == '') {
            $mesInvIF = ($mesReport + 1);
        }

        //longitud del mes
        if (strlen($mesInvI) == 1) {
            $mesInvI = '0' . strval($mesInvI);
        }
        if (strlen($mesInvIF) == 1) {
            $mesInvIF = '0' . strval($mesInvIF);
        }
    }
    /*END WHILE*/
    // //$aniInvI!='' && $mesInvI!='' &&
    if ($manInv != '') {
        /*
                        # con el dato del mes anterior obtenido del query anterior obtengo el inv inicial
                        # arreglando******************************ojo*******************ojo************************
            */
        $queryInvI = "
            select
                ru.login as manejador,
                max(left(c.name,3)) as grupo,
                sum(qty) as cantid
            from 
                stock_quant q
                left join product_category c ON q.categ_id = c.id
                left join product_product p on q.product_id = p.id
                left join product_template pt ON p.product_tmpl_id=pt.id
                left join res_users ru ON pt.product_manager=ru.id
            group by
                ru.login,product_id,in_date,location_id
                having product_id='" . $idProd . "' and ru.login='" . $manInv . "'
                
            ";

        if ($consulta == 'normal') {
            $sql_where = "and EXTRACT(YEAR FROM  in_date)  = '" . $aniInvI . "' 
                        and EXTRACT(MONTH FROM  in_date) <= '" . $mesInvI . "' 
                        and location_id NOT IN('8','9')
                        ";
        } else {

            $sql_where = "and EXTRACT(YEAR FROM  in_date) between $aniInvI and $anio_hasta
                        and EXTRACT(MONTH FROM  in_date) <= '" . $mesInvI . "' 
                        and location_id NOT IN('8','9')
                                ";
        }

        $queryInvI = $queryInvI . $sql_where;

        $resultadoII = $Conn->prepare($queryInvI);
        $resultadoII->execute();
        $datosII = $resultadoII->fetchAll();
        $cantid = 0;
        $grpInvI = '';
        $tiene = false;
        foreach ($datosII as $datoII) {
            if ($datoII['cantid'] != null) {
                $grpInvI = $datoII['grupo'];
                $aux    = $datoII['cantid'];
                $cantid = $cantid + (int)$aux;
                $tiene  = true;
                $aux    = 0;
            }
        }
/* 
                        INV FINAL
                        con el dato del mes anterior obtenido del query anterior obtengo el inv FINAL
*/
        $queryInvF = "select
                ru.login as manejador,
                max(left(c.name,3)) as grupo,
                sum(qty) as cantid
                from stock_quant q
                left join product_category c ON q.categ_id = c.id
                left join product_product p on q.product_id = p.id
                left join product_template pt ON p.product_tmpl_id=pt.id
                left join res_users ru ON pt.product_manager=ru.id
                group by ru.login,product_id,in_date,location_id
                having product_id='" . $idProd . "' and ru.login='" . $manInv . "'
            ";
           if($consulta=='normal' ){
                $sql_where ="and EXTRACT(YEAR FROM  in_date)  = '" . $aniInvF . "' AND EXTRACT(MONTH FROM  in_date) = '" . $mesInvIF . "'
                and location_id NOT IN('8','9')";
            }else{
                $sql_where ="and EXTRACT(YEAR FROM  in_date)  between $aniInvF and $anio_hasta AND EXTRACT(MONTH FROM  in_date) between $mesInvIF  and $mes_hasta
                and location_id NOT IN('8','9')";
           }
        $queryInvF =  $queryInvF . $sql_where;

        $resultadoIF = $Conn->prepare($queryInvF);
        $resultadoIF->execute();
        $datosIF = $resultadoIF->fetchAll();
        $cantidF = 0;
        $grpInvF = '';
        $tieneF = false;
        $aux = 0;
        foreach ($datosIF as $datoIF) {
            if ($datoIF['cantid'] != null) {
                $grpInvF = $datoIF['grupo'];
                $aux    = $datoIF['cantid'];
                $cantidF = $cantidF + (int)$aux;
                $tieneF = true;
                $aux    = 0;
            }
        }
        $cantidF = $cantidF + $cantid;
        if ($grpInvF == 'CPH') {
            echo "</br>I:" . $cantid . ",F:" . $cantidF . "--G:" . $grpInvF . " -- ID: " . $idProd . "--" . $manInv;
        }
/*
                        OJO AQUI VERIFICAR EN EL ARREGLO DE VENTAS SI EL PRODUCTO TUVO VENTA MES ANTERIOR AL ACTUAL PARA ENTRAR AL tiene 
                        HACER SUMATORIAS DE GRUPOS IGUALES MISMO MANEJADOR POR DENTRO
*/
        if ($tiene == true) {
            $f = 0;
            $cf = count($grpInvInicial);
            $estagrp = false;
            //suma grupos
            while ($f < $cf) {
                if (trim($grpInvInicial[$f]) == trim($grpInvI) && trim($manInvInicial[$f]) == trim($manInv)) {
                    $invCantInicial[$f] = $invCantInicial[$f] + $cantid;
                    $estagrp = true;
                }
                $f++;
            }
            if ($estagrp == false) {
                $grpInvInicial[$m] = trim($grpInvI);
                $invCantInicial[$m] = $cantid;
                $manInvInicial[$m] = trim($manInv);
            }
            //final
            $f = 0;
            $estagrpF = false;
            $cf = count($grpInvFinal);
            //suma grupos
            while ($f < $cf) {
                if (trim($grpInvFinal[$f]) == trim($grpInvF) && trim($manInvFinal[$f]) == trim($manInv)) {
                    $invCantFinal[$f] = $invCantFinal[$f] + $cantidF;
                    $estagrpF = true;
                }
                $f++;
            }
            if ($estagrpF == false) {
                $grpInvFinal[$m] = trim($grpInvF);
                $invCantFinal[$m] = $cantidF;
                $manInvFinal[$m] = trim($manInv);
            }
/*
            if($grpInvInicial[$m]=='CPH'){
                    echo "</br>Inicial:".$aniInvI."-".$mesInvI."--".$idProd."->".$grpInvInicial[$m]."--".$invCantInicial[$m]."-suma:-".$invCantInicial[$f]."--".$manInvInicial[$m]."</br>";
            }
*/
        }
        //FINAL
        if ($tiene == true) {
            $m++;
        }
    }
    $i++;
}
/*   
$t=count($grpInvInicial);
$i=0;
echo "</br>inicial".$t;
while($i<$t){
    if($grpInvInicial[$i]=='CPH'){
    echo $grpInvInicial[$i]."--".$invCantInicial[$i]."--".$manInvInicial[$m]."</br>";
    }
    $i++;
}
$t=count($grpInvFinal);
$i=0;
echo "</br>final".$t;
while($i<$t){
    if($grpInvFinal[$i]=='CPH'){
    echo $grpInvFinal[$i]."--".$invCantFinal[$i]."--".$manInvFinal[$m2]."</br>";
    }
    $i++;
}*/
//exit();

//echo $cantid;
//exit();
//prueba
/* $m=0;
    echo "</br>resultado2:</br>";
    $c=count($compGrp2);
    while($m<$c){
        echo $compGrp2[$m]."--".$compMan2[$m]."--".$compCos2[$m]."--".$compVal2[$m]."</br>";
        $m++;
    }*/
/*
    $m=0;
    echo "</br>resultado1:</br>";
    $c=count($compGrp);
    while($m<$c){
        echo $compGrp[$m]."--".$compMan[$m]."--".$compCos[$m]."--".$compVal[$m]."</br>";
        $m++;
    }
    //echo "  T=".$c;
    exit();  */

$r = $r . "</table>";
/*
                                            # reporte del pdf
                                            # require('../fpdf/fpdf.php');

*/
include('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $x = 20; //pos x
        $y = 10;  //pos y
        $w = 10;  //ancho
        $h = 10;  //alto
        $fitbox = 1;
        $this->SetXY(8, 10);
        //$this->Image('imagenesemp/logo-cym-plano.jpg', $x, $y, $w, $h, 'JPG', '', '', false, 80, '', false, false, 0, $fitbox, false, false);
        //cabecera de la tabla
        $fecha = date("d/m/Y");
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(2, 157, 116); //Fondo verde de celda
        $ejeX = 10;
        $PosY = 30;


        $this->SetTextColor(0, 0, 0); //Letra color blanco
        $this->SetXY(102, 20);
        $this->Cell(10, 7, 'INFORME DE COMPRAS Y VENTAS ODOO', 0, 'C', 'C', '0', '');
        //$this->SetXY(95, 30);
        //$this->Cell(10,7, utf8_decode('Fecha Informe: ').$fecha, 0, 'C', 'C','0','');
        $this->SetFont('Arial', 'B', 8);

        $this->SetFillColor(2, 157, 116); //Fondo verde de celda
        $this->SetTextColor(240, 255, 240); //Letra color blanco
        //$pdf->SetXY(10, 12);
        $this->SetXY(10, 30);
        $ejeX = 10;
        $PosY = 30;
        //$this->Ln(20);
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'P. ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
}
//datos CONTENIDO
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages(); //como queremos que se muestre el paginado
$pdf->AddPage();

//$y2=$this->GetY();
$ancho = 7;
$ejeY = 20;
$Vacio = "";
$pdf->SetFont('Helvetica', '', 7);
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro

$pdf->SetXY(20, $ejeY);
$pdf->SetFont('Arial', 'B', 12);

//fecha 
$ejeY = $ejeY + 7;
$pdf->SetXY(95, $ejeY);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(2, 157, 116);
if($consulta =='normal' ){
    $fechaActual  = $fechaActual ;
    $pdf->Cell(30, $ancho, $fechaActual, 0, 'C', 'L');

}else{
    $fechaActual = $mes_desde.'-'.$anio_hasta.'   '.$mes_hasta.'-'.$anio_hasta;
    $pdf->Cell(30, $ancho, $fechaActual  , 0, 'C', 'L');
}

$nombA = 0;
$nombB = 0;
$maneA = count($cate1D);

$m = 0;
$totVentEmp = 0;
$totCompEmp = 0;
$totCostEmp = 0;
$catxVend = new ArrayIterator();
while ($m < $numan) {
    //NOMBRE DEL MANEJADOR
    $nommanejador = $maneB[$m];
    // echo' manejador '.$nommanejador.'<br>' ;
    $ejeY = $ejeY + 7;
    $pdf->SetXY(20, $ejeY);
    $pdf->SetFont('Arial', 'B', 12);
    //$pdf->SetFillColor(2,157,116);
    //$pdf->Cell(30,$ancho, $maneB[$nombA],0, 'C' , 'L' );
    $pdf->Cell(30, $ancho, $nommanejador, 0, 'C', 'L');
    $pdf->SetFont('Arial', '', 7);

    $subtotVentUs = 0;
    $subtotCompUs = 0;
    $subtotCostUs = 0;
    //ciclo de categorias*********************************************************************
    //ojito 
    //borra arreglo
    unset($catxVend);
    //discrimina categorias por usuario
    $numCats = count($catC);
    $nc1 = 0;
    $ic = 0;
    //echo $numCats."--".$logginB[$m]."--";
    while ($nc1 < $numCats) {
        if (trim($manC[$nc1]) == trim($logginB[$m])) {
            $x = 0;
            $nNewCat = count($catxVend);
            $estaCat = false;
            while ($x < $nNewCat) {
                if (trim($catxVend[$x]) == trim($catC[$nc1])) {
                    $estaCat = true;
                    $x = $nNewCat;
                }
                $x++;
            }
            if ($estaCat == false) {
                $catxVend[$ic] = trim($catC[$nc1]);
                // echo $catxVend[$ic]."---";
                $ic++;
            }
        }
        $nc1++;
    }
    //CATEGORIAS POR MANEJADOR
    $numCats2 = count($catxVend);
    $nc = 0;
    while ($nc < $numCats2) {
        //$resultSqlM = mssql_query("SELECT DISTINCT DESCRIPCION AS CATEGORIA FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='$logginB[$m]'"); 
        //while($fila = mssql_fetch_array($resultSqlM)){
        $catBuscada = trim($catxVend[$nc]); //$fila['CATEGORIA'];   

        $ejeY = $ejeY + 7;
        $pdf->SetXY(20, $ejeY);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(2, 157, 116);
        $pdf->Cell(30, $ancho, $catBuscada, 0, 'C', 'L');

        //titulos de tabla
        $ejeY = $ejeY + 7;
        $pdf->SetFillColor(231, 229, 228); //gris
        $pdf->SetXY(20, $ejeY);
        $pdf->Cell(10, $ancho - 2, utf8_decode('GRP'), 1, 'C', 'C', 1);
        //DESCRIPCION
        $pdf->SetXY(30, $ejeY);
        $pdf->Cell(60, $ancho - 2, utf8_decode('DESCRIPCION'), 1, 'C', 'C', 1);
        //INV INICIAL
        $pdf->SetXY(90, $ejeY);
        $pdf->Cell(20, $ancho - 2, utf8_decode('INV.INICIAL'), 1, 'C', 'C', 1);
        //VENAS
        $pdf->SetXY(110, $ejeY);
        $pdf->Cell(20, $ancho - 2, utf8_decode('VENTAS'), 1, 'C', 'C', 1);
        //MARGEN
        $pdf->SetXY(130, $ejeY);
        $pdf->Cell(20, $ancho - 2, utf8_decode('MARGEN'), 1, 'C', 'C', 1);
        //COSTO
        $pdf->SetXY(150, $ejeY);
        $pdf->Cell(20, $ancho - 2, utf8_decode('COSTO'), 1, 'C', 'C', 1);
        //COMPRAS
        $pdf->SetXY(170, $ejeY);
        $pdf->Cell(20, $ancho - 2, utf8_decode('COMPRAS'), 1, 'C', 'C', 1);
        //INV FINAL
        $pdf->SetXY(190, $ejeY);
        $pdf->Cell(20, $ancho - 2, utf8_decode('INV.FINAL'), 1, 'C', 'C', 1);

        $subtotCatV = 0;
        $subtotCompCat = 0;
        $subtotCostCat = 0;

        //GRUPOS POR CATEGORIA Y MANEJADOR
        $numCatsg = count($gprC);
        $nc2 = 0;
        while ($nc2 < $numCatsg) {
            //si la categoria= a la discriminada por usuario
            if ($catBuscada == trim($catC[$nc2]) && trim($manC[$nc2]) == trim($logginB[$m])) {
                //$resultSqlC = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE DESCRIPCION='$catBuscada'");
                //while($filaC = mssql_fetch_array($resultSqlC)){
                $grupo = trim($gprC[$nc2]); //trim($filaC['CTPPGN']);
                $dgrupo = trim($desC[$nc2]); //$filaC['CTPPGD'];               
                //FILAS DE LA TABLA
                $valx = '0';
                $prueba = 30;
                //llenar DATOS de la tabla

                //GRP
                $ejeY = $ejeY + 7;
                $pdf->SetXY(20, $ejeY);
                $pdf->SetFont('Arial', '', 6);
                $pdf->Cell(10, $ancho, $grupo, 1, 'C', 'C');

                //DESCRIPCION
                $pdf->SetXY(30, $ejeY);
                $pdf->SetFont('Arial', '', 6);
                $pdf->Cell(60, $ancho, $dgrupo, 1, 'C', 'C');
                $pdf->SetFont('Arial', '', 7);

                //INV INICIAL
                //$grpInvInicial[$m]=trim($grpInvI);
                //$invCantInicial[$m]=$cantid;
                //$manInvInicial[$m]=trim($manInv);
                $m2 = 0;
                $SubTotI = 0;
                $numGrp = count($grpInvInicial);
                while ($m2 < $numGrp) {
                    if ((trim($manInvInicial[$m2]) == $logginB[$m]) && ($grpInvInicial[$m2] == $grupo)) {
                        $SubTotI = $invCantInicial[$m2];
                        $m2 = $numGrp;
                    }
                    $m2++;
                }

                $pdf->SetXY(90, $ejeY);
                $pdf->Cell(20, $ancho, $SubTotI, 1, 'C', 'R');

                $SubTotV = 0;

                //VENTAS
                $m2 = 0;
                $SubTotV = 0;
                $numGrp = count($VentGrp2);
                while ($m2 < $numGrp) {
                    if ((trim($VentMan2[$m2]) == $logginB[$m]) && ($VentGrp2[$m2] == $grupo)) {
                        $SubTotV = $VentVal2[$m2];
                        $m2 = $numGrp;
                    }
                    $m2++;
                }

                $subtotCatV = $subtotCatV + $SubTotV;

                $pdf->SetXY(110, $ejeY);
                $pdf->Cell(20, $ancho, number_format($SubTotV), 1, 'C', 'R');


                //COSTO y compra
                $m2 = 0;
                $numGrp = count($compGrp2);
                while ($m2 < $numGrp) {
                    //echo trim($VentMan[$m2])."==".'$logginB[$m]' && $VentGrp[$m2]=='$grupo';
                    if ((trim($compMan2[$m2]) == $logginB[$m]) && ($compGrp2[$m2] == $grupo)) {
                        $SubTotComp = $compVal2[$m2];
                        $subTotCost = $compCos2[$m2];
                        $m2 = $numGrp;
                    }
                    $m2++;
                }

                $subtotCompCat = $subtotCompCat + $SubTotComp;
                $subtotCostCat = $subtotCostCat + $subTotCost;
                //MARGEN

                //margen=(ventas-costo)/ventas
                if ($SubTotV > 0) {
                    $margen = ($SubTotV - $subTotCost) / $SubTotV;
                    //echo "(".$SubTotV."-".$subTotCost.")/".$SubTotV."=".$margen."---|---";
                    $margen = round($margen, 4);
                    $margen = ($margen * 100) . "%";
                    //$margen='';
                } else {
                    $margen = "0";
                }
                $SubTotV = 0;

                $pdf->SetXY(130, $ejeY);
                $pdf->Cell(20, $ancho, $margen, 1, 'C', 'C');

                //costo
                $pdf->SetXY(150, $ejeY);
                $pdf->Cell(20, $ancho, number_format($subTotCost), 1, 'C', 'R');
                $subTotCost = 0;
                //COMPRAS
                $pdf->SetXY(170, $ejeY);
                $pdf->Cell(20, $ancho, number_format($SubTotComp), 1, 'C', 'R');
                $SubTotComp = 0;
                //INV FINAL
                //$grpInvFinal[$m2]=trim($grpInvF);
                //$invCantFinal[$m2]=$cantidF;
                //$manInvFinal[$m2]=trim($manInv);
                $m2 = 0;
                $SubTotF = 0;
                $numGrp = count($grpInvFinal);
                while ($m2 < $numGrp) {
                    if ((trim($manInvFinal[$m2]) == $logginB[$m]) && ($grpInvFinal[$m2] == $grupo)) {
                        $SubTotF = $invCantFinal[$m2];
                        $m2 = $numGrp;
                    }
                    $m2++;
                }

                $pdf->SetXY(190, $ejeY);
                $pdf->Cell(20, $ancho, number_format($SubTotF), 1, 'C', 'R');

                //nuevas hojas
                if ($ejeY > 210) {

                    //$nombA=0;
                    $ejeY = 20;
                    $pdf->AddPage();
                    //fecha 
                    $ejeY = $ejeY + 7;
                    $pdf->SetXY(95, $ejeY);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->SetFillColor(2, 157, 116);
                    $pdf->Cell(30, $ancho, $fechaActual, 0, 'C', 'L');
                    //NOMBRE DEL MANEJADOR
                    $ejeY = $ejeY + 7;
                    $pdf->SetXY(20, $ejeY);
                    $pdf->SetFont('Arial', 'B', 12);
                    //$pdf->SetFillColor(2,157,116);
                    $pdf->Cell(30, $ancho, $nommanejador, 0, 'C', 'L');
                    $pdf->SetFont('Arial', '', 7);
                    //NOMBRE DEL GRUPO O PRODUCTO
                    $ejeY = $ejeY + 7;
                    $pdf->SetXY(20, $ejeY);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->SetFillColor(2, 157, 116);
                    $pdf->Cell(30, $ancho, $catBuscada, 0, 'C', 'L');

                    //titulos
                    $ejeY = $ejeY + 7;
                    $pdf->SetFillColor(231, 229, 228); //gris
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->SetXY(20, $ejeY);
                    $pdf->Cell(10, $ancho - 2, utf8_decode('GRP'), 1, 'C', 'C', 1);
                    //DESCRIPCION
                    $pdf->SetXY(30, $ejeY);
                    $pdf->Cell(60, $ancho - 2, utf8_decode('DESCRIPCION'), 1, 'C', 'C', 1);
                    //INV INICIAL
                    $pdf->SetXY(90, $ejeY);
                    $pdf->Cell(20, $ancho - 2, utf8_decode('INV.INICIAL'), 1, 'C', 'C', 1);
                    //VENAS
                    $pdf->SetXY(110, $ejeY);
                    $pdf->Cell(20, $ancho - 2, utf8_decode('VENTAS'), 1, 'C', 'C', 1);
                    //MARGEN
                    $pdf->SetXY(130, $ejeY);
                    $pdf->Cell(20, $ancho - 2, utf8_decode('MARGEN'), 1, 'C', 'C', 1);
                    //COSTO
                    $pdf->SetXY(150, $ejeY);
                    $pdf->Cell(20, $ancho - 2, utf8_decode('COSTO'), 1, 'C', 'C', 1);
                    //COMPRAS
                    $pdf->SetXY(170, $ejeY);
                    $pdf->Cell(20, $ancho - 2, utf8_decode('COMPRAS'), 1, 'C', 'C', 1);
                    //INV FINAL
                    $pdf->SetXY(190, $ejeY);
                    $pdf->Cell(20, $ancho - 2, utf8_decode('INV.FINAL'), 1, 'C', 'C', 1);
                }

                $nombB++;

                $nombA++;
            }
            $nc2++;
        }       //fin while categorias

        //Subtotales por categoria
        $ejeY = $ejeY + 7;
        $pdf->SetXY(30, $ejeY);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, $ancho, 'SUBTOTAL ' . substr($catBuscada, 0, 5) . ' $', 1, 'C', 'C');
        $pdf->SetFont('Arial', '', 7);
        //subtot inv inicial
        $pdf->SetXY(90, $ejeY);
        $pdf->Cell(20, $ancho, "", 1, 'C', 'R');
        //subtot ventas
        $pdf->SetXY(110, $ejeY);
        $pdf->Cell(20, $ancho, number_format($subtotCatV), 1, 'C', 'R');
        //subtot margen
        $pdf->SetXY(130, $ejeY);
        //subtot margen=(ventas-costo)/ventas
        if ($subtotCatV > 0) {
            $margen = ($subtotCatV - $subtotCostCat) / $subtotCatV;
            $margen = round($margen, 4);
            $margen = ($margen * 100) . "%";
        } else {
            $margen = "0";
        }
        $pdf->Cell(20, $ancho, $margen, 1, 'C', 'C');
        //subtot costo
        $pdf->SetXY(150, $ejeY);
        $subtotCostCat = round($subtotCostCat, 2);
        $pdf->Cell(20, $ancho, number_format($subtotCostCat), 1, 'C', 'R');
        //subtot val compras
        $pdf->SetXY(170, $ejeY);
        $pdf->Cell(20, $ancho, number_format($subtotCompCat), 1, 'C', 'R');
        //sub tot inv final
        $pdf->SetXY(190, $ejeY);
        $pdf->Cell(20, $ancho, "", 1, 'C', 'R');

        //subtotales para usuarios
        $subtotVentUs = $subtotVentUs + $subtotCatV;
        $subtotCompUs = $subtotCompUs + $subtotCompCat;
        $subtotCostUs = $subtotCostUs + $subtotCostCat;
        //}
        //fin while usuarios
        $nc++;
    }
    //Subtotales por manejador
    $ejeY = $ejeY + 7;
    $pdf->SetXY(30, $ejeY);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, $ancho, 'SUBTOTAL $', 1, 'C', 'C');
    $pdf->SetFont('Arial', '', 7);
    //sut inv inicial usuario
    $pdf->SetXY(90, $ejeY);
    $pdf->Cell(20, $ancho, "", 1, 'C', 'R');
    //subtot venta us        
    $pdf->SetXY(110, $ejeY);
    $pdf->Cell(20, $ancho, number_format($subtotVentUs), 1, 'C', 'R');
    //subtot margen us        
    $pdf->SetXY(130, $ejeY);
    //subtot margen=(ventas-costo)/ventas
    if ($subtotVentUs > 0) {
        $margen = ($subtotVentUs - $subtotCostUs) / $subtotVentUs;
        $margen = round($margen, 4);
        $margen = ($margen * 100) . "%";
    } else {
        $margen = "0";
    }
    $pdf->Cell(20, $ancho, $margen, 1, 'C', 'C');
    //subtot costo us        
    $pdf->SetXY(150, $ejeY);
    $pdf->Cell(20, $ancho, number_format($subtotCostUs), 1, 'C', 'R');
    //subtot compras us        
    $pdf->SetXY(170, $ejeY);
    $pdf->Cell(20, $ancho, number_format($subtotCompUs), 1, 'C', 'R');
    //sub tot inv final us        
    $pdf->SetXY(190, $ejeY);
    $pdf->Cell(20, $ancho, "", 1, 'C', 'R');

    //Totales empresa
    $totVentEmp = $totVentEmp + $subtotVentUs;
    $totCompEmp = $totCompEmp + $subtotCompUs;
    $totCostEmp = $totCostEmp + $subtotCostUs;

    $m++;
    //nueva hoja nuevo manejador
    $ejeY = 20;
    $pdf->AddPage();
}   //FIN while

//Totales empresa
//titulos de tabla
$ejeY = $ejeY + 7;
$pdf->SetFillColor(231, 229, 228); //gris
//$pdf->SetXY (20,$ejeY);
//$pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
//DESCRIPCION
$pdf->SetXY(30, $ejeY);
$pdf->Cell(60, $ancho - 2, utf8_decode('DESCRIPCION'), 1, 'C', 'C', 1);
//INV INICIAL
$pdf->SetXY(90, $ejeY);
$pdf->Cell(20, $ancho - 2, utf8_decode('INV.INICIAL'), 1, 'C', 'C', 1);
//VENAS
$pdf->SetXY(110, $ejeY);
$pdf->Cell(20, $ancho - 2, utf8_decode('VENTAS'), 1, 'C', 'C', 1);
//MARGEN
$pdf->SetXY(130, $ejeY);
$pdf->Cell(20, $ancho - 2, utf8_decode('MARGEN'), 1, 'C', 'C', 1);
//COSTO
$pdf->SetXY(150, $ejeY);
$pdf->Cell(20, $ancho - 2, utf8_decode('COSTO'), 1, 'C', 'C', 1);
//COMPRAS
$pdf->SetXY(170, $ejeY);
$pdf->Cell(20, $ancho - 2, utf8_decode('COMPRAS'), 1, 'C', 'C', 1);
//INV FINAL
$pdf->SetXY(190, $ejeY);
$pdf->Cell(20, $ancho - 2, utf8_decode('INV.FINAL'), 1, 'C', 'C', 1);

//valores totales
$ejeY = $ejeY + 7;
$pdf->SetXY(30, $ejeY);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60, $ancho, 'TOTAL EMPRESA $', 1, 'C', 'C');
$pdf->SetFont('Arial', '', 7);
//sut inv inicial usuario
$pdf->SetXY(90, $ejeY);
$pdf->Cell(20, $ancho, "", 1, 'C', 'R');
//subtot venta emp        
$pdf->SetXY(110, $ejeY);
$pdf->Cell(20, $ancho, number_format($totVentEmp), 1, 'C', 'R');
//subtot margen emp        
$pdf->SetXY(130, $ejeY);
//subtot margen=(ventas-costo)/ventas
if ($totVentEmp > 0) {
    $margen = ($totVentEmp - $totCostEmp) / $totVentEmp;
    $margen = round($margen, 4);
    $margen = ($margen * 100) . "%";
} else {
    $margen = "0";
}
$pdf->Cell(20, $ancho, $margen, 1, 'C', 'C');
//subtot costo emp        
$pdf->SetXY(150, $ejeY);
$pdf->Cell(20, $ancho, number_format($totCostEmp), 1, 'C', 'R');
//subtot compras emp        
$pdf->SetXY(170, $ejeY);
$pdf->Cell(20, $ancho, number_format($totCompEmp), 1, 'C', 'R');
//sub tot inv final emp        
$pdf->SetXY(190, $ejeY);
$pdf->Cell(20, $ancho, "", 1, 'C', 'R');

$ejeY = $ejeY + 20;
$pdf->SetXY(95, $ejeY);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(30, $ancho, '***FIN INFORME***', 0, 'C', 'C');

//llama funcion del index verLink('INFORME_COMPRAS_VENTAS_MES.pdf');
$cod = time() + 1;
$nombrearc = "../pdf/INFORME_COMPRAS_VENTAS_MES.pdf";
$pdf->Output($nombrearc, "F");
echo 'INFORME PROCESADO';
/*FIN PDF*/

Conexion::cerrarConexion();
mssql_close();
