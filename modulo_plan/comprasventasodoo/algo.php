<?php
include_once 'usercon_odoo.php';
//conexion base pruebas 0.206
include('conectarbase.php');
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();
$periodo=$_GET['p'];
$anio=substr($periodo,0,4);
$mes=substr($periodo,4,2); 
$vista=$_GET['v'];
                if($vista=='V'){
                    //VENTAS ODOO  ol.product_uos_qty
                    $nomvis='Ventas';
                    $sql="
                        select
                           left(c1.name,3) as grupo,
                           trim(substr(split_part(c1.name, '-', 2),5,50)) as descgrupo,
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
                                      AND EXTRACT(YEAR FROM  cf.date_invoice)  = '$anio' AND EXTRACT(MONTH FROM  cf.date_invoice) = '$mes'
                                AND left(cf.internal_number,1) IN('F','S','D','0')
                                AND u.login IN('RODRIGUEZF','SUAREZM','PINILLOSM','BARONF')
                                order by left(c1.name,3) asc
                    ";
                    //limpia tabla
                    $sqlb = "DELETE FROM [InformesCompVentas].[dbo].[infVentasIbsOdoo] WHERE PERIODO='$periodo'";
                    mssql_query($sqlb,$cLink);
                    
                    //insertar datos a la tabla
                    $resultado1= $Conn->prepare($sql);
                    $resultado1->execute();
                    $datos1=$resultado1->fetchAll();
                    $dv4=0;
                    foreach($datos1 as $dato1){
                        $dv1=$dato1['grupo'];
                        $dv2=$periodo;
                        $dv3=trim($dato1['manejador']);
                        $dv4=0;//costo total//$dato1['valor'];
                        $dv5=$dato1['valor'];
                        
                        //echo "<br>".$dv1."-----".$dv2."-----".$dv3."-----".$dv4."-----".$dv5."<br>";
                        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbsOdoo] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                        //echo "<br><hr>SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbsOdoo] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'";
                        if (!mssql_num_rows($query)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentasIbsOdoo](IDPGRP,PERIODO,IDPLAN,PBDESC,COSTO_TOTAL,VLR_EXC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','','$dv4','$dv5')"; 
                            //echo "<br>".$sqlv;
                            mssql_query($sqlv,$cLink);
                        } else if (mssql_num_rows($query)) {
                            //lee el valor que esta y le suma la otra linea del mismo grupo
                            $ValorC=0;
                            $valorR=0;
                            $resultSQL = mssql_query("SELECT VLR_EXC_IVA as ValorAnt FROM [InformesCompVentas].[dbo].[infVentasIbsOdoo] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                            if($resultado = mssql_fetch_array($resultSQL)){
                                $ValorC=$resultado["ValorAnt"];
                                $valorR=$ValorC+$dv5;
                                //actualiza valor
                                $resultSQLE = mssql_query("UPDATE [InformesCompVentas].[dbo].[infVentasIbsOdoo] SET VLR_EXC_IVA='".$valorR."' WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                                mssql_query($resultSQLE,$cLink);
                            }
                        }
                    }
                    
                    //COSTO por ventas * cantidad vistas por item
                    $sql="
                        select
					       p.id as codprod,
					       o.name as orden,
					       ol.product_uos_qty as cant,
                           left(c1.name,3) as grupo,
						   trim(u.login) as manejador
                                from sale_order o
								left join sale_order_line ol ON ol.order_id=o.id
                                left join sale_order_invoice_rel oi ON o.id=oi.order_id
                                left join account_invoice cf ON oi.invoice_id=cf.id and o.state='done'
                                left join account_invoice_line il ON cf.id=il.invoice_id
                                left join product_product p ON (ltrim(split_part(il.name, ']', 1),'['))=p.default_code
                                left join product_list_item i ON i.product_id=p.id
                                left join product_template t ON p.product_tmpl_id=t.id
                                left join product_category c1 ON t.categ_id=c1.id
                                left join res_users u ON t.product_manager=u.id
                                GROUP BY
								p.id,
								o.name,
								left(c1.name,3),
								ol.product_uos_qty,
								u.login,
                                o.state,
								left(cf.internal_number,1) IN('F','S','D','0'),
                                EXTRACT(YEAR FROM  cf.date_invoice),
                                EXTRACT(MONTH FROM  cf.date_invoice)
                                HAVING
                                      o.state='done'
                                      and EXTRACT(YEAR FROM  cf.date_invoice)  = '$anio' AND EXTRACT(MONTH FROM  cf.date_invoice) = '$mes'
                                AND left(cf.internal_number,1) IN('F','S','D','0')
                                AND u.login IN('RODRIGUEZF','SUAREZM','PINILLOSM','BARONF')
                                order by left(c1.name,3) asc
                    ";
                    
                    $resultado1= $Conn->prepare($sql);
                    $resultado1->execute();
                    $datos1=$resultado1->fetchAll();
                    $dv4=0;
                    $valorR=0;
                    foreach($datos1 as $dato1){
                        $codprod=$dato1['codprod'];
                        $dv1=$dato1['grupo'];
                        $dv3=trim($dato1['manejador']);
                        $cant=$dato1['cant'];
                        
                        //consulta costo
                        $sql2="
                            select id, name_template, group_product_id, default_code, costo_standard, cost_purchase, price_sale, qty_purchase
                                from product_product 
                                where id='$codprod'
                        ";
                        $resultado2= $Conn->prepare($sql2);
                        $resultado2->execute();
                        $datos2=$resultado2->fetchAll();
                        foreach($datos2 as $dato2){
                            $val1=$dato2['costo_standard'];
                            $val2=$dato2['cost_purchase'];
                            if($val2==null || $val2==0){
                                $subcosto=$val1;
                            } else {
                                $subcosto=$val2;
                            }
                            $costo=$subcosto * $cant;
                            //actualiza costo en base
                            $query = mssql_query("SELECT COSTO_TOTAL as CostoTAnt FROM [InformesCompVentas].[dbo].[infVentasIbsOdoo] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                            if (mssql_num_rows($query) > 0) {
                                $resultado = mssql_fetch_array($query);
                                $ValorC=$resultado["CostoTAnt"];
                                $valorR=$ValorC + $costo;
                                
                                $resultSQLE = mssql_query("UPDATE [InformesCompVentas].[dbo].[infVentasIbsOdoo] SET COSTO_TOTAL='".$valorR."' WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                                mssql_query($resultSQLE,$cLink);
                            }
                        }
              
                    }
                    
                    /*
                    $sql = "SELECT * FROM AGR620CFAG.VISINFVENT WHERE PERIODO='$periodo' AND IDPLAN IN('RODRIGUEZF','SUAREZM','PINILLOSM','BARONF')";
                    $result = odbc_exec($db2con, $sql);
                    while($row = odbc_fetch_array($result)){
                        $dv1 = $row['IDPGRP'];
                        $dv2 = $row['PERIODO'];
                        $dv3 = $row['IDPLAN'];
                        $dv3=trim($dv3);
                        $dv4 = $row['COSTO_TOTAL'];
                        $dv5 = $row['VLR_EXC_IVA'];
                        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infVentasIbs] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                       
                        if (!mssql_num_rows($query)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infVentasIbs](IDPGRP,PERIODO,IDPLAN,PBDESC,COSTO_TOTAL,VLR_EXC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','','$dv4','$dv5')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }*/
                } else if($vista=='C'){    
                    //COMPRAS ODOO
                    $nomvis='Compras';
                    $sql="
                        select distinct
                            left(c1.name,3) as grupo,
                			trim(u.login) as manejador,
                            sum(ol.price_unit * ol.product_qty) as valorcomp_exc_iva    
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
                                ol.state,
                                trim(u.login),
                                cf.supplier_invoice,
                                EXTRACT(YEAR FROM  o.date_approve),
                                EXTRACT(MONTH FROM  o.date_approve)
                            HAVING EXTRACT(YEAR FROM  o.date_approve)  = '$anio' AND EXTRACT(MONTH FROM  o.date_approve) = '$mes'
                            and cf.supplier_invoice is not null and trim(u.login) is not null
                            and ol.state='done'
                			AND trim(u.login) IN('RODRIGUEZF','SUAREZM','PINILLOSM','BARONF')
                    ";
                    
                    //limpia tabla
                    $sqlb = "DELETE FROM [InformesCompVentas].[dbo].[infComprasIbsOdoo] WHERE PERIODO='$periodo'";
                    mssql_query($sqlb,$cLink);
                    //ojo consolidar compras repetidas por grupo
                    //insertar datos a la tabla
                    $resultado1= $Conn->prepare($sql);
                    $resultado1->execute();
                    $datos1=$resultado1->fetchAll();
                    $dv4=0;
                    foreach($datos1 as $dato1){
                        $dv1=$dato1['grupo'];
                        $dv2=$periodo;
                        $dv3=trim($dato1['manejador']);
                        $dv4=$dato1['valorcomp_exc_iva'];
                        //echo "<br>".$dv1."-----".$dv2."-----".$dv3."-----".$dv4."-----".$dv5."<br>";
                        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infComprasIbsOdoo] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."' AND IDPLAN='".$dv3."'");
                        echo "<br><br>SELECT * FROM [InformesCompVentas].[dbo].[infComprasIbsOdoo] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."'";
                        if (!mssql_num_rows($query)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infComprasIbsOdoo](IDPGRP,PERIODO,IDPLAN,VLR_EXC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','$dv4')"; 
                            //echo "<br><br>".$sqlv;
                            mssql_query($sqlv,$cLink);
                        } else {
                            //lee el valor que esta y le suma la otra linea del mismo grupo
                            //echo "actualiza".$dv1."<br>";
                            $ValorC=0;
                            $valorR=0;
                            $resultSQL = mssql_query("SELECT VLR_EXC_IVA as ValorAnt FROM [InformesCompVentas].[dbo].[infComprasIbsOdoo] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."'");
                            if($resultado = mssql_fetch_array($resultSQL)){
                                $ValorC=$resultado["ValorAnt"];
                                $valorR=$ValorC+$dv4;
                                echo "actualiza2".$ValorC." R=".$valorR;
                                //actualiza valor
                                $resultSQLE = mssql_query("UPDATE [InformesCompVentas].[dbo].[infComprasIbsOdoo] SET VLR_EXC_IVA='".$valorR."' WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."'");
                                mssql_query($resultSQLE,$cLink);
                            }
                        }
                    }
                    
                    
                    /*
                    $sql = "SELECT * FROM AGR620CFAG.VISINFCOM WHERE PERIODO='$periodo'";
                    $result = odbc_exec($db2con, $sql);
                    //if($row = odbc_fetch_array($result)){
                    while($row = odbc_fetch_array($result)){
                        $dv1 = trim($row['PGPGRP']);
                        $dv2 = trim($row['PERIODO']);
                        $dv3 = '';//$row['IDPLAN'];
                        $dv4 = $row['VLR_EXC_IVA'];
                        $query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infComprasIbs] WHERE PERIODO='".$periodo."' AND IDPGRP='".$dv1."'");
                        //$query = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[infComprasIbs] WHERE PERIODO='".$periodo."'");
                        if (!mssql_num_rows($query)) {
                            $sqlv = "INSERT INTO [InformesCompVentas].[dbo].[infComprasIbs](IDPGRP,PERIODO,IDPLAN,VLR_EXC_IVA) 
                            VALUES('$dv1','$dv2','$dv3','$dv4')"; 
                            mssql_query($sqlv,$cLink);
                        }
                    }*/
                }
            echo "Datos ".$nomvis.", periodo: ".$periodo." Guardados.";        
            //odbc_close($result);
            Conexion::cerrarConexion();
            //mssql_close();

?>