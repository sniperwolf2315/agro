<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
require_once('../conectarbasepruebas.php');
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

//$anio=trim($_GET['a']);
//$mes=trim($_GET['m']);

////////////////////////////
//fecha actual
$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;
setlocale(LC_TIME, 'es_ES');
$fecha = DateTime::createFromFormat('!m', $mesA);
$meN = strftime("%B", $fecha->getTimestamp());
$mesN=strtoupper($meN);
$anioA = date('Y');
$fechaActual=$mesN." ".$anioA;
//////////////////////////

$periodo=trim($_GET['periodo']);
$categ = new ArrayIterator(); 
$manejanom = new ArrayIterator(); 
$manejacat = new ArrayIterator();
//newhoy
//$verficacosto = new ArrayIterator(); 
//$periodo="202001";
$periodoi=substr($periodo,0,4);
$anio=$periodoi;
$periodoi=$periodoi."01";
$m=substr($periodo,4,2);

$inicial=$m-1;
$final=$m;
//mes anterior y actual
$mesant=$inicial;
$mesact=$final;

if (strlen($inicial)==1) {
    $inicial="0".$inicial;
}
if (strlen($final)==1) {
    $final="0".$final;
}
$inicial=$anio.$inicial;
$final=$anio.$final;
//evalua periodo anterior en caso de enero
if(intval($mesact)==1 || $mesact=="01"){
    $mesact=12;
    //año anterior y mes
    $anio=(intval($anio)-1);
    $peranterior=$anio.$mesact;
}else{
    $mesact=(intval($mesact)-1);
    if(strlen($mesact)==1){
        $mesact="0".$mesact;
    }
    $peranterior=$anio.$mesact;
}

//limpia array solo la primera vez no con los demas manejadores
$tamcg=count($categ);
for ($cg=0; $cg<=$tamcg; $cg++){
    $categ[$cg]="";
}

$tamcg=count($manejanom);
for ($cg=0; $cg<=$tamcg; $cg++){
    $manejanom[$cg]="";
}

$TotalCat=0;
$TotalMan=0;
$mes=array('','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
$mm=intval($m);
$Ms=$mes[$mm]." ".$anio;


$TotalCat=0;
$TotalMan=0;
$i=0;

$r="";

$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Esta visualizando el informe: </p>";
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Ordenes en Estado Pendiente. Compras Pendientes Por Entregar a Corte: </p>";//Fecha Inicio: ".$feini." - hasta: ".$fefin.".

        $r=$r."<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
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
        $r=$r."</tr>";

//consultas a la base
$i=0;
$iA=0;

$iC=0;
$iD=0;
//$nomA
$logA = new ArrayIterator();
$parA = new ArrayIterator();
//NOMBRE DEL MANEJADOR
$iB=0;
$logginB = new ArrayIterator();
$maneB = new ArrayIterator();
$queryB="SELECT u.login as login, rp.name as nombre FROM res_users u
        left join  res_partner rp ON u.partner_id=rp.id
        where u.login in('SUAREZM','RODRIGUEZF','BARONF','PINILLOSM')
        ORDER BY u.login ASC
      ";  
        $resultadoB= $Conn->prepare($queryB);
        $resultadoB->execute();
        $datosB=$resultadoB->fetchAll();
        
        foreach($datosB as $datoB){
            $loggin=$datoB['login'];
            $logginB[$iB]=trim($loggin);
            $nameus=$datoB['nombre'];
            $maneB[$iB]=trim($nameus);
            $iB++;
        }
//}
// NO HAY DATOS PARA CONSULTAR
// GRUPOS Y NOMBRE DEL PRODUCTO X MANEJADOR
$gprC = new ArrayIterator();
$desC = new ArrayIterator();
$manC = new ArrayIterator();
$catC = new ArrayIterator();
//manejadores*******************************************************************
$numan=count($logginB);
$m=0;


//***ojo activar al terminar***
//$resultSqlB = mssql_query("truncate table [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo]");
//$resultadoB=mssql_query($resultSqlB);

while($m < $numan){
    $queryC="select
        --pp.default_code
        left(pc.name,3) as grupo
        ,case when ((left(trim(split_part(pc.name, '-', 2)),2))='19' or (left(trim(split_part(pc.name, '-', 2)),2))='00') then right(trim(split_part(pc.name, '-', 2)),-2) else trim(split_part(pc.name, '-', 2)) end as desc_grupo
        ,ru.login as manejador
        --,pp.name_template as descripcion
        from product_product pp
        left join product_list_item pli ON pli.product_id=pp.id
        left join product_template pt ON pp.product_tmpl_id=pt.id
        left join product_category pc ON pc.id=pt.categ_id  --pli.categ_id
        left join res_users ru ON pt.product_manager=ru.id
        group by
         --pp.default_code
         ru.login
         ,left(pc.name,3)
         ,pc.name
         ,pp.active=true
         --,pp.name_template
        having pp.active=true AND ru.login ='$logginB[$m]'
        and left(pc.name,3) not in('Eva','Tod')
        ORDER BY left(pc.name,3) ASC
    ";
    $resultadoC= $Conn->prepare($queryC);
    $resultadoC->execute();
    $datosC=$resultadoC->fetchAll();
            
    foreach($datosC as $datoC){
        $grp=$datoC['grupo'];
        $dgrp=trim($datoC['desc_grupo']);
        $man=$datoC['manejador'];
        $gprC[$iC]=trim($grp);
        $desC[$iC]=trim($dgrp);
        $manC[$iC]=trim($man);
        //echo $man."||||||";
        //consulta sqlserver categorias
        if($grp != ''){
            $Categ="-";
            $resultSqlS = mssql_query("SELECT DESCRIPCION as CATEGOR FROM [InformesCompVentas].[dbo].[infPeriodosAcumulados] WHERE CTPPGN='$grp'");
            if($filacat = mssql_fetch_array($resultSqlS)){
                $Categ=$filacat['CATEGOR'];
                $catC[$iC]=trim($Categ);
            }
        }
        
        $resultSqlS = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE CTPPGN='$grp'");
        $numero2 = mssql_num_rows($resultSqlS);
        if($numero2 <=0 && $catC[$iC]!=''){
            $consulta2="INSERT INTO [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] (CTPPGN,CTPPGD,RESPONSABLE,DESCRIPCION) VALUES ('$gprC[$iC]','$desC[$iC]','$manC[$iC]','$catC[$iC]')";
            $resultado1=mssql_query($consulta2);
        }
        $iC++;
    }
$m++;
}
//fin carga de grupos y categorias*********************************************************    

//QUERY DE VENTAS
$VentGrp = new ArrayIterator();
$VentMan = new ArrayIterator();
$VentVal = new ArrayIterator();
$QueryV="select
    --o.name,
    --p.default_code,
    left(c1.name,3) as grupo,
    trim(substr(split_part(c1.name, '-', 2),5,50)) as descgrupo,
    sum(il.quantity) as cantidadvend,
    sum(il.price_subtotal) as valor,
    trim(u.login) as manejador
    from sale_order o
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
    HAVING
    o.state='done'
    AND EXTRACT(YEAR FROM  cf.date_invoice)  = '2021' AND EXTRACT(MONTH FROM  cf.date_invoice) = '06'
    AND left(cf.internal_number,1) IN('F','S','D','0')
    --AND u.login IN('$logginB[$m]') and left(c1.name,3)='$grupo'
    order by left(c1.name,3) asc
    ";
    $resultadoV= $Conn->prepare($QueryV);
    $resultadoV->execute();
    $datosV=$resultadoV->fetchAll();  
    $m=0;  
    foreach($datosV as $datoV){
        //ojo si es necesario pendiente sumar por grupos repetidos del usuario
        $VentGrp[$m]=$datoV['grupo'];
        $VentMan[$m]=$datoV['manejador'];
        $VentVal[$m]=$datoV['valor'];
        $m++;
    }
    //verificacion de acumulados en caso de tener varias ventas por grupo
    $VentGrp2 = new ArrayIterator();
    $VentMan2 = new ArrayIterator();
    $VentVal2 = new ArrayIterator();
    $cmp1=0;
    $fil=0;
    $numCom=count($VentGrp);
    while($cmp1 < $numCom){
        $grp=$VentGrp[$cmp1];
        $man=$VentMan[$cmp1];
        $val=$VentVal[$cmp1];
        $sumVal=0;
        $cmp2=0;
        $esta=false;
        while($cmp2 < $numCom){
            if(trim($grp)==trim($VentGrp[$cmp2]) && trim($man)==trim($VentMan[$cmp2]) && trim($VentGrp[$cmp2]!="-")){
                $sumVal=$sumVal+$VentVal[$cmp2];
                if($cmp1!=$cmp2){
                    $VentVal[$cmp2]=0;
                    $VentGrp[$cmp2]="-";
                }
                $esta=true;
            }
            $cmp2++;
        }
        if($esta==true){
            $VentGrp2[$fil]=$VentGrp[$cmp1];
            $VentMan2[$fil]=$VentMan[$cmp1];
            $VentVal2[$fil]=$sumVal;
            $fil++;
        }
        $cmp1++;
    }
    
    //QUERY DE COMPRAS
    $compGrp = new ArrayIterator();
    $compMan = new ArrayIterator();
    $compCos = new ArrayIterator();
    $compVal = new ArrayIterator();
    $QueryC="select distinct
                left(c1.name,3) as grupo,
                trim(substr(split_part(c1.name, '-', 2),5,50)) as descgrupo,
                p.default_code as item,
                p.name_template as nombre,
                o.name as ordencomp,
                ol.state as estadoord,
                avg(st.last_average_cost) as costo_promedio,
                --p.costo_standard,
                --st.cost as costo_historico,
                --pi.price as ultimo_costo,
                max((st.cost + pi.price)/2) as costo,
                max(ol.product_qty) as cantidad,
                max(ol.price_unit * ol.product_qty) as valorcomp_exc_iva,
                o.date_order as fechaorden,
                trim(u.login) as manejador
            from purchase_order o
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
                --((st.cost + pi.price)/2),
                --ol.product_qty,
                --(ol.price_unit * ol.product_qty),
                --p.costo_standard,
               --st.cost,
                --pi.price,
                --((st.cost + pi.price)/2) as costo,
                --ol.product_qty as cantidad,
                --(ol.price_unit * ol.product_qty) as valorcomp_exc_iva,
                o.date_order,
                trim(u.login),
                cf.supplier_invoice,
                EXTRACT(YEAR FROM  o.date_approve),
                EXTRACT(MONTH FROM  o.date_approve)
            HAVING EXTRACT(YEAR FROM  o.date_approve)  = '2021' AND EXTRACT(MONTH FROM  o.date_approve) = '06'
            and cf.supplier_invoice is not null and trim(u.login) is not null
            and ol.state='done'
            --and p.default_code='019000057'
            --and left(c1.name,3)='019'
            --and left(c1.name,3) ='019'
            --and o.name='PO00617'
    ";
    
    //ojo suma por grupo cantidad, y costos excepto costo promedio*******************************************
    $resultadoC= $Conn->prepare($QueryC);
    $resultadoC->execute();
    $datosC=$resultadoC->fetchAll();  
    $m=0; 
    foreach($datosC as $datoC){
        //ojo si es necesario pendiente sumar por grupos repetidos del usuario
        $grupoC=trim($datoC['grupo']);
        $manC=$datoC['manejador'];
        $costoC=$datoC['costo_promedio'];
        $valorC=$datoC['valorcomp_exc_iva'];
        $numCom=count($compGrp);
        //echo "CantidADX".$numCom."---";
        $compGrp[$m]=$grupoC;
        $compMan[$m]=$manC;
        $compCos[$m]=$costoC;
        $compVal[$m]=$valorC;
        $m++;
    }
    //sumatoria compras y costos por grupos
    $compGrp2 = new ArrayIterator();
    $compMan2 = new ArrayIterator();
    $compCos2 = new ArrayIterator();
    $compVal2 = new ArrayIterator();
    $cmp1=0;
    $fil=0;
    $numCom=count($compGrp);
    while($cmp1 < $numCom){
        $grp=$compGrp[$cmp1];
        $man=$compMan[$cmp1];
        $val= $compVal[$cmp1];
        $cost=$compCos[$cmp1];
        $sumVal=0;
        $sumCos=0;
        $cmp2=0;
        $esta=false;
        while($cmp2 < $numCom){
            if(trim($grp)==trim($compGrp[$cmp2]) && trim($man)==trim($compMan[$cmp2]) && trim($compGrp[$cmp2]!="-")){
                $sumVal=$sumVal+$compVal[$cmp2];
                $sumCos=$sumCos+$compCos[$cmp2];
                if($cmp1!=$cmp2){
                    $compVal[$cmp2]=0;
                    $compCos[$cmp2]=0;
                    $compGrp[$cmp2]="-";
                }
                $esta=true;
            }
            $cmp2++;
        }
        if($esta==true){
            $compGrp2[$fil]=$compGrp[$cmp1];
            $compMan2[$fil]=$compMan[$cmp1];
            $compVal2[$fil]=$sumVal;
            $compCos2[$fil]=$sumCos;
            $fil++;
        }
        $cmp1++;
    }
    
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
$r=$r . "</table>";          
//reporte del pdf
require('../fpdf/fpdf.php');
            //P? es normal. El valor para apaisada es ?L
            
            class PDF extends FPDF
            {
                function Header(){
                    $x = 10; //pos x
                    $y = 10;  //pos y
                    $w = 10;  //ancho
                    $h = 10;  //alto
                    $fitbox=1;
                    $this->SetXY(8, 10);
                    //$this->Image('imagenesemp/logo-cym-plano.jpg', $x, $y, $w, $h, 'JPG', '', '', false, 80, '', false, false, 0, $fitbox, false, false);
                    //cabecera de la tabla
                        $fecha=date("d/m/Y");
                        $this->SetFont('Arial','B',12);
                        $this->SetFillColor(2,157,116);//Fondo verde de celda
                        $ejeX = 10;
                        $PosY=30;
                        
                        
                        $this->SetTextColor(0, 0, 0); //Letra color blanco
                        $this->SetXY(102, 20);
                        $this->Cell(10,7, 'INFORME DE COMPRAS Y VENTAS ODOO', 0, 'C', 'C','0','');
                        //$this->SetXY(95, 30);
                        //$this->Cell(10,7, utf8_decode('Fecha Informe: ').$fecha, 0, 'C', 'C','0','');
                        $this->SetFont('Arial','B',8);
                
                        $this->SetFillColor(2,157,116);//Fondo verde de celda
                        $this->SetTextColor(240, 255, 240); //Letra color blanco
                        //$pdf->SetXY(10, 12);
                        $this->SetXY(10, 30);
                        $ejeX = 10;
                        $PosY=30;            
                    //$this->Ln(20);
                }
                function Footer()
                {
                    $this->SetY(-15);
                    $this->SetFont('Arial','I',8);
                    $this->Cell(0,10,'P. '.$this->PageNo().' / {nb}',0,0,'C');

                }
            }
            //datos CONTENIDO
            $pdf = new PDF('P','mm','Letter');
            $pdf->AliasNbPages(); //como queremos que se muestre el paginado
            $pdf->AddPage();    
            
            //$y2=$this->GetY();
            $ancho=7;
            $ejeY = 20;
            $Vacio="";
            $pdf->SetFont('Helvetica','',7);
            $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
            
            $pdf->SetXY (20,$ejeY);
            $pdf->SetFont('Arial','B',12);
           
            //fecha 
            $ejeY=$ejeY+7; 
            $pdf->SetXY (95,$ejeY);
            $pdf->SetFont('Arial','B',12);
            $pdf->SetFillColor(2,157,116);
            $pdf->Cell(30,$ancho, $fechaActual,0, 'C' , 'L' ); 
            
            $nombA=0;
            $nombB=0;
            $maneA = count($cate1D);
                        
            $m=0;
            while($m < $numan){
                    //NOMBRE DEL MANEJADOR
                    $nommanejador=$maneB[$m];
                    $ejeY=$ejeY+7; 
                    $pdf->SetXY (10,$ejeY);
                    $pdf->SetFont('Arial','B',12);
                    //$pdf->SetFillColor(2,157,116);
                    //$pdf->Cell(30,$ancho, $maneB[$nombA],0, 'C' , 'L' );
                    $pdf->Cell(30,$ancho, $nommanejador,0, 'C' , 'L' );
                    $pdf->SetFont('Arial','',7);
                    
                    $subtotVentUs=0;
                    $subtotCompUs=0;
                    $subtotCostUs=0;
                    //ciclo de categorias*********************************************************************
                    $resultSqlM = mssql_query("SELECT DISTINCT DESCRIPCION AS CATEGORIA FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE RESPONSABLE='$logginB[$m]'"); 
                    while($fila = mssql_fetch_array($resultSqlM)){
                        $catBuscada=$fila['CATEGORIA'];                       
                        $ejeY=$ejeY+7; 
                        $pdf->SetXY (10,$ejeY);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->SetFillColor(2,157,116);
                        $pdf->Cell(30,$ancho, $catBuscada,0, 'C' , 'L' );
                        
                        //titulos de tabla
                        $ejeY=$ejeY+7;
                        $pdf->SetFillColor(231,229,228); //gris
                        $pdf->SetXY (10,$ejeY);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
                        //DESCRIPCION
                        $pdf->SetXY (20,$ejeY);
                        $pdf->Cell(40,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                        //INV INICIAL
                        $pdf->SetXY (60,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.INICIAL'),1, 'C' , 'C', 1 );
                        //VENAS
                        $pdf->SetXY (80,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('VENTAS'),1, 'C' , 'C', 1 );
                        //VEN ACU
                        $pdf->SetXY (100,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('VEN ACU'),1, 'C' , 'C', 1 );
                        //MARGEN
                        $pdf->SetXY (120,$ejeY);
                        $pdf->Cell(10,$ancho-2, utf8_decode('MARG'),1, 'C' , 'C', 1 );
                        //COST ACU
                        $pdf->SetXY (130,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COST ACU'),1, 'C' , 'C', 1 );
                        //COMPRAS
                        $pdf->SetXY (150,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COMPRAS'),1, 'C' , 'C', 1 );
                        //COM ACU
                        $pdf->SetXY (170,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('COM ACU'),1, 'C' , 'C', 1 );
                        //INV FINAL
                        $pdf->SetXY (190,$ejeY);
                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.FINAL'),1, 'C' , 'C', 1 );
                        
                        $subtotCatV=0;
                        $subtotCompCat=0;
                        $subtotCostCat=0;
                        
                        $resultSqlC = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infPeriodosAcumuladosOdoo] WHERE DESCRIPCION='$catBuscada'");
                        while($filaC = mssql_fetch_array($resultSqlC)){
                            $grupo=trim($filaC['CTPPGN']);
                            $dgrupo=$filaC['CTPPGD'];               
                                //FILAS DE LA TABLA
                                $valx='0';
                                $prueba=30;
                                    //llenar DATOS de la tabla
                                    
                                    //GRP
                                    $ejeY = $ejeY+7;
                                    $pdf->SetXY (10,$ejeY);
                                    $pdf->SetFont('Arial','',6);
                                    $pdf->Cell(10,$ancho, $grupo,1, 'C' , 'C' );
                                    
                                    //DESCRIPCION
                                    $pdf->SetXY (20,$ejeY);
                                    $pdf->SetFont('Arial','',6);
                                    $pdf->Cell(40,$ancho, $dgrupo,1, 'C' , 'C' );
                                    $pdf->SetFont('Arial','',7);
                                    
                                    //INV INICIAL
                                    $pdf->SetXY (60,$ejeY);
                                    $pdf->Cell(20,$ancho, $valx,1, 'C' , 'R' );
                                    
                                    $SubTotV=0; 
                                    
                                    //VENTAS
                                    $m2=0;
                                    $SubTotV=0;
                                    $numGrp=count($VentGrp2);
                                    while($m2<$numGrp){
                                        if((trim($VentMan2[$m2])==$logginB[$m]) && ($VentGrp2[$m2]==$grupo)){
                                            $SubTotV=$VentVal2[$m2];
                                            $m2=$numGrp;
                                        }
                                        $m2++;
                                    }
                                    
                                    $subtotCatV=$subtotCatV+$SubTotV;
                                    
                                    $pdf->SetXY (80,$ejeY);
                                    $pdf->Cell(20,$ancho, number_format($SubTotV),1, 'C' , 'R' );
                                    
                                    
                                    //COSTO y compra
                                    $m2=0;
                                    $numGrp=count($compGrp2);
                                    while($m2<$numGrp){
                                        //echo trim($VentMan[$m2])."==".'$logginB[$m]' && $VentGrp[$m2]=='$grupo';
                                        if((trim($compMan2[$m2])==$logginB[$m]) && ($compGrp2[$m2]==$grupo)){
                                            $SubTotComp=$compVal2[$m2];
                                            $subTotCost=$compCos2[$m2];
                                            $m2=$numGrp;
                                        }
                                        $m2++;
                                    }
                                    
                                    $subtotCompCat=$subtotCompCat+$SubTotComp;
                                    $subtotCostCat=$subtotCostCat+$subTotCost;
                                    //MARGEN
                                    
                                    //margen=(ventas-costo)/ventas
                                    if($SubTotV>0){
                                        $margen=($SubTotV-$subTotCost)/$SubTotV;
                                        //echo "(".$SubTotV."-".$subTotCost.")/".$SubTotV."=".$margen."---|---";
                                        $margen=round($margen,4);
                                        $margen=($margen*100)."%";
                                        //$margen='';
                                    }else{
                                        $margen="0";
                                    }
                                    $SubTotV=0;
                                    
                                    //VEN ACU
                                    $VEN_ACU=0;
                                    $pdf->SetXY (100,$ejeY);
                                    $pdf->Cell(20,$ancho, $VEN_ACU,1, 'C' , 'R' );
                                    
                                    //MARGEN
                                    $pdf->SetXY (120,$ejeY);
                                    $pdf->Cell(10,$ancho, $margen,1, 'C' , 'C' );                               
                                    
                                    //costo
                                    $pdf->SetXY (130,$ejeY);
                                    $pdf->Cell(20,$ancho, number_format($subTotCost),1, 'C' , 'R' );
                                    $subTotCost=0;
                                    //COMPRAS
                                    $pdf->SetXY (150,$ejeY);
                                    $pdf->Cell(20,$ancho, number_format($SubTotComp),1, 'C' , 'R' );
                                    $SubTotComp=0;
                                    //COM ACU
                                    $SubTotacu=0;
                                    $pdf->SetXY (170,$ejeY);
                                    $pdf->Cell(20,$ancho, number_format($SubTotacu),1, 'C' , 'R' );
                                    $SubTotacu=0;
                                    //INV FINAL
                                    $pdf->SetXY (190,$ejeY);
                                    $pdf->Cell(20,$ancho, number_format($valx),1, 'C' , 'R' );
                                    
                                    //nuevas hojas
                                    
                                    if($ejeY>210){
                                    
                                        //$nombA=0;
                                        $ejeY=20;
                                        $pdf->AddPage();
                                        //fecha 
                                        $ejeY=$ejeY+7;
                                        $pdf->SetXY (95,$ejeY);
                                        $pdf->SetFont('Arial','B',12);
                                        $pdf->SetFillColor(2,157,116);
                                        $pdf->Cell(30,$ancho, $fechaActual,0, 'C' , 'L' );
                                        //NOMBRE DEL MANEJADOR
                                        $ejeY=$ejeY+7;
                                        $pdf->SetXY (10,$ejeY);
                                        $pdf->SetFont('Arial','B',12);
                                        //$pdf->SetFillColor(2,157,116);
                                        $pdf->Cell(30,$ancho, $nommanejador,0, 'C' , 'L' );
                                        $pdf->SetFont('Arial','',7);
                                        //NOMBRE DEL GRUPO O PRODUCTO
                                        $ejeY=$ejeY+7;
                                        $pdf->SetXY (10,$ejeY);
                                        $pdf->SetFont('Arial','B',10);
                                        $pdf->SetFillColor(2,157,116);
                                        $pdf->Cell(30,$ancho, $catBuscada,0, 'C' , 'L' );
                                        
                                        //titulos
                                        $ejeY=$ejeY+7;
                                        $pdf->SetFillColor(231,229,228); //gris
                                        $pdf->SetFont('Arial','B',10);
                                        $pdf->SetXY (10,$ejeY);
                                        $pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C', 1 );
                                        //DESCRIPCION
                                        $pdf->SetXY (20,$ejeY);
                                        $pdf->Cell(40,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                                        //INV INICIAL
                                        $pdf->SetXY (60,$ejeY);
                                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.INICIAL'),1, 'C' , 'C', 1 );
                                        //VENAS
                                        $pdf->SetXY (80,$ejeY);
                                        $pdf->Cell(20,$ancho-2, utf8_decode('VENTAS'),1, 'C' , 'C', 1 );
                                        //VEN ACU
                                        $pdf->SetXY (100,$ejeY);
                                        $pdf->Cell(20,$ancho-2, utf8_decode('VEN ACU'),1, 'C' , 'C', 1 );
                                        //MARGEN
                                        $pdf->SetXY (120,$ejeY);
                                        $pdf->Cell(10,$ancho-2, utf8_decode('MARG'),1, 'C' , 'C', 1 );
                                        //COST ACU
                                        $pdf->SetXY (130,$ejeY);
                                        $pdf->Cell(20,$ancho-2, utf8_decode('COST ACU'),1, 'C' , 'C', 1 );
                                        //COMPRAS
                                        $pdf->SetXY (150,$ejeY);
                                        $pdf->Cell(20,$ancho-2, utf8_decode('COMPRAS'),1, 'C' , 'C', 1 );
                                        //COM ACU
                                        $pdf->SetXY (170,$ejeY);
                                        $pdf->Cell(20,$ancho-2, utf8_decode('COM ACU'),1, 'C' , 'C', 1 );
                                        //INV FINAL
                                        $pdf->SetXY (190,$ejeY);
                                        $pdf->Cell(20,$ancho-2, utf8_decode('INV.FINAL'),1, 'C' , 'C', 1 );
                                    }
                                    
                                    $nombB++;
                                
                                $nombA++;
                        }       //fin while categorias
                        
                            //Subtotales por categoria
                            $ejeY = $ejeY+7;
                            $pdf->SetXY (20,$ejeY);
                            $pdf->SetFont('Arial','',10);
                            $pdf->Cell(40,$ancho, 'SUBTOTAL CAT $',1, 'C' , 'C' );
                            $pdf->SetFont('Arial','',7);
                            //subtot inv inicial
                            $pdf->SetXY (60,$ejeY);
                            $pdf->Cell(20,$ancho, "",1, 'C' , 'R' );
                            //subtot ventas
                            $pdf->SetXY (80,$ejeY);
                            $pdf->Cell(20,$ancho, number_format($subtotCatV),1, 'C' , 'R' );
                            //VEN ACU
                            $VEN_ACUA=0;
                            $pdf->SetXY (100,$ejeY);
                            $pdf->Cell(20,$ancho, number_format($VEN_ACUA),1, 'C' , 'R' );
                            //subtot margen
                            $pdf->SetXY (120,$ejeY);
                            //subtot margen=(ventas-costo)/ventas
                            if($subtotCatV>0){
                                $margen=($subtotCatV-$subtotCostCat)/$subtotCatV;
                                $margen=round($margen,4);
                                $margen=($margen*100)."%";
                            }else{
                                $margen="0";
                            }
                            $pdf->Cell(10,$ancho, $margen,1, 'C' , 'C' );
                            //subtot costo
                            $pdf->SetXY (130,$ejeY);
                            $subtotCostCat=round($subtotCostCat,2);
                            $pdf->Cell(20,$ancho, number_format($subtotCostCat),1, 'C' , 'R' );
                            //subtot val compras
                            $pdf->SetXY (150,$ejeY);
                            $pdf->Cell(20,$ancho, number_format($subtotCompCat),1, 'C' , 'R' );
                            //COM ACU
                            $COM_ACUB=0;
                            $pdf->SetXY (170,$ejeY);
                            $pdf->Cell(20,$ancho, number_format($COM_ACUB),1, 'C' , 'R' );
                            //sub tot inv final
                            $pdf->SetXY (190,$ejeY);
                            $pdf->Cell(20,$ancho, "",1, 'C' , 'R' );
                            
                            //subtotales para usuarios
                            $subtotVentUs=$subtotVentUs+$subtotCatV;
                            $subtotCompUs=$subtotCompUs+$subtotCompCat;
                            $subtotCostUs=$subtotCostUs+$subtotCostCat;
                         
                    //fin while usuarios
                    }
                    //Subtotales por manejador
                    $ejeY = $ejeY+7;
                    $pdf->SetXY (20,$ejeY);
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(40,$ancho, 'SUBTOTAL $',1, 'C' , 'C' );
                    $pdf->SetFont('Arial','',7);
                    //sut inv inicial usuario
                    $pdf->SetXY (60,$ejeY);
                    $pdf->Cell(20,$ancho, "",1, 'C' , 'R' );
                    //subtot venta us        
                    $pdf->SetXY (80,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($subtotVentUs),1, 'C' , 'R' );
                    //VEN ACU   
                    $VEN_ACUC=0;
                    $pdf->SetXY (100,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($VEN_ACUC),1, 'C' , 'R' );
                    //MARGEN
                    $MARGENA=0;
                    $pdf->SetXY (120,$ejeY);
                    $pdf->Cell(10,$ancho, number_format($MARGENA),1, 'C' , 'C' );
                    //subtot margen us        
                    $pdf->SetXY (130,$ejeY);
                    //subtot margen=(ventas-costo)/ventas
                    if($subtotVentUs>0){
                        $margen=($subtotVentUs-$subtotCostUs)/$subtotVentUs;
                        $margen=round($margen,4);
                        $margen=($margen*100)."%";
                    }else{
                        $margen="0";
                    }
                    $pdf->Cell(20,$ancho, $margen,1, 'C' , 'R' );
                    //subtot costo us        
                    $pdf->SetXY (150,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($subtotCostUs),1, 'C' , 'R' );
                    //subtot compras us        
                    $pdf->SetXY (170,$ejeY);
                    $pdf->Cell(20,$ancho, number_format($subtotCompUs),1, 'C' , 'R' );
                    //sub tot inv final us        
                    $pdf->SetXY (190,$ejeY);
                    $pdf->Cell(20,$ancho, "",1, 'C' , 'R' );
                    
                    
                $m++;
                //nueva hoja nuevo manejador
                $ejeY=20;
                $pdf->AddPage();
                //$ejeY=$ejeY+7;
                //$pdf->SetXY (70,$ejeY);
                //$pdf->SetFont('Arial','B',12);
                
            }   //FIN while
            
            
            
            /*
            if($nomA==4){
                $ejeY=20;
                $pdf->AddPage();
                //fecha 
                $ejeY=$ejeY+7;
                $pdf->SetXY (95,$ejeY);
                $pdf->SetFont('Arial','B',12);
                $pdf->SetFillColor(2,157,116);
                $pdf->Cell(30,$ancho, $fechaActual,0, 'C' , 'L' );
                
                $ejeY=$ejeY+7;
                $pdf->SetXY (70,$ejeY);
                $pdf->SetFont('Arial','B',12);
                //$pdf->SetFillColor(2,157,116);
                //$pdf->Cell(50,$ancho, $Ms,0, 'C' , 'C' );
                
                $pdf->SetFont('Arial','',7);
                $ejeY = $ejeY+12;
                $pdf->SetFont('Arial','B',10);
                //$pdf->SetXY (20,$ejeY);
                //$pdf->Cell(10,$ancho-2, utf8_decode('GRP'),1, 'C' , 'C' );
                
                //DESCRIPCION
                $pdf->SetFillColor(231,229,228); //gris
                $pdf->SetXY (30,$ejeY);
                $pdf->Cell(60,$ancho-2, utf8_decode('DESCRIPCION'),1, 'C' , 'C', 1 );
                //INV INICIAL
                $pdf->SetXY (90,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('INV.INICIAL'),1, 'C' , 'C', 1 );
                //VENAS
                $pdf->SetXY (110,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('VENTAS'),1, 'C' , 'C', 1 );
                //MARGEN
                $pdf->SetXY (130,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('MARGEN'),1, 'C' , 'C', 1 );
                //COSTO
                $pdf->SetXY (150,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('COSTO'),1, 'C' , 'C', 1 );
                //COMPRAS
                $pdf->SetXY (170,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('COMPRAS'),1, 'C' , 'C', 1 );
                //INV FINAL
                $pdf->SetXY (190,$ejeY);
                $pdf->Cell(20,$ancho-2, utf8_decode('INV.FINAL'),1, 'C' , 'C', 1 );
                
                //TOTAL EMP $
                $ejeY = $ejeY+7;
                $pdf->SetXY (30,$ejeY);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(60,$ancho, 'TOTAL EMP $',1, 'C' , 'C' );
                $pdf->SetFont('Arial','',7);
                  
                //INV.INICIAL
                $TotMesIniTT=0;
                $pdf->SetXY (90,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesIniTT),1, 'C' , 'R' );
                //$TotMesIniTT=0;
                
                //VENTAS
                $TotVenIvaTT=1;
                $pdf->SetXY (110,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenIvaTT),1, 'C' , 'R' );
                //$TotVenIvaTT=0;

                //MARGEN
                $margenTT=2;
                $pdf->SetXY (130,$ejeY);
                $pdf->Cell(20,$ancho, $margenTT,1, 'C' , 'C' );
                //$margenTT=0;
                
                //COSTO
                $TotVenCostoTT=3;
                $pdf->SetXY (150,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotVenCostoTT),1, 'C' , 'R' );
                //$TotVenCostoTT=0;
                        
                //COMPRAS
                $TotComIvaTT=4;
                $pdf->SetXY (170,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotComIvaTT),1, 'C' , 'R' );
                //$TotComIvaTT=0;
                    
                //INV FINAL
                $TotMesFinTT=5;
                $pdf->SetXY (190,$ejeY);
                $pdf->Cell(20,$ancho, number_format($TotMesFinTT),1, 'C' , 'R' );
                //$TotMesFinTT=0;
            }
            */
            $ejeY=$ejeY+20;
            $pdf->SetXY (95,$ejeY);
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(30,$ancho, '***FIN INFORME***',0, 'C' , 'C' );
            
            //verLink('INFORME_COMPRAS_VENTAS_MES.pdf');
            $cod=time()+1;
            $nombrearc="../pdf/INFORME_COMPRAS_VENTAS_MES.pdf";
            $pdf->Output($nombrearc,"I");  //"F"
            echo $nombrearc;
            /*FIN PDF*/

Conexion::cerrarConexion();
mssql_close();

?>