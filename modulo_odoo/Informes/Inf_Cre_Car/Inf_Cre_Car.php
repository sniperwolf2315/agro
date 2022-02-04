<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();

//$cedula=trim($_GET['c']);

$query1="SELECT rp.ref as cedula,rp.name as nombre,rp.display_name as nom_completo,rp.birth_date as fech_nacimiento,rp.street as direccion,rp.street2 as direccion2,rp.phone as tel,rp.mobile as cel,
rp.email as email,rp.credit_limit as lim_credito,rp.tipo_tercero as tip_tercerp,rp.reporte_asegurabilidad as rep_asergu,
ru.login as vendedor,rc.code as cod_ciudad,rc.name as ciudad,rco.code as cod_ciudad2,
rco.name as pais ,rcs.code as cod_depar,rcs.name as departamento,ca.name as establecimiento,
rp.comment,rp.city,rp.type,rp.user_id,rp.city_id
from res_partner as rp
left join res_city as rc on rp.city_id=rc.id
left join res_country as rco on rp.country_id=rco.id
left join res_country_state as rcs on rp.state_id=rcs.id
left join crm_activity as ca on rp.activity_id=ca.id
--left join partner_question_rel as pqr on rp.id=pqr.partner
left join res_users as ru on rp.user_id=ru.id
left join res_partner_res_partner_category_rel as rprpcr on rp.id = rprpcr.partner_id
left join res_partner_category as rpc on rprpcr.category_id=rpc.id
where rp.customer='true' and rpc.name='CREDITO';";// and rp.ref in ('900584968','40403991','4934336','7364101','79953181')

$resultado1= $Conn->prepare($query1);
$resultado1->execute();
$datos1=$resultado1->fetchAll();
//$cantP1=count($datos1);
$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Categorizaci&oacute;n Credito y Cartera. Consulta del cliente: </p>";
//$r=$r."<p style=\"text-align: center;\" class=\"z-depth-1\">Categorizaci&oacute;n Credito y Cartera. Consulta del cliente: ".$cedula."</p>";
    $i=1;
        $r=$r."<table style=\"border: 1px solid #000; width:100%;\" class=\"#009688 teal\">";
        $r=$r."<tr style=\"border-bottom: 1pt solid black; font-size: 0.8em;\">";
        $r=$r."<td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CEDULA</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">NOMBRE</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">NOMBRE COMPLETO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">FECHA DE NACIMIENTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DIRECCION</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DIRECCION 2</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">NUMERO_TEL</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">NUMERO_CEL</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">EMAIL</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">LIMITE DE CREDITO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">TIPO DE TERCERO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">REPORTE ASEGURABILIDAD</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">VENDEDOR</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CODIGO CIUDAD</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CIUDAD</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CODIGO CIUDAD 2</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">PAIS</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">CODIGO DEPARTAMENTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">DEPARTAMENTO</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">ESTABLECIMIENTO</td>
        <td><Strong><a href='Informexls/Cat_Credito_y_Cartera.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 1</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 1</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 2</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 2</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 3</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 3</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 4</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 4</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 5</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 5</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 6</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 6</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 7</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 7</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 8</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 8</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 9</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 9</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pregunta 10</td>
        <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Respuesta 10</td>
        <td><a href='Informexls/Cat_Credito_y_Cartera.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
        $r=$r . "</tr>";
    $fd=3;
       // $r="Informexls/Informe_Inventario008.xlsx"
        $miruta='../Informexls/';
        $nombre_fichero = 'Cat_Credito_y_Cartera';
        $mipath=$miruta.$nombre_fichero.'.xlsx';
        if(file_exists($miruta)) {
            include('../Classes/PHPExcel.php');
            include('../Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            $mipath2=$miruta.$nombre_fichero.'.xlsx';
            if(file_exists($mipath2)) {
                $archivo = $mipath2;
                $inputFileType = PHPExcel_IOFactory::identify($archivo);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($archivo);                
            } else {              
                $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
                $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
                $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
                $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
                $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
                $objPHPExcel->getProperties()->setCategory("Resultado de Informe"); 
                
                $objWorkSheet = $objPHPExcel->createSheet(0);
                    
                    $objWorkSheet->setCellValue('A2', 'No.')
                        ->setCellValue('B2', 'CEDULA')
                        ->setCellValue('C2', 'NOMBRE')
                        ->setCellValue('D2', 'NOMBRE COMPLETO')
                        ->setCellValue('E2', 'FECHA DE NACIMIENTO')
                        ->setCellValue('F2', 'DIRECCION')
                        ->setCellValue('G2', 'DIRECCION 2')
                        ->setCellValue('H2', 'NUMERO_TEL')
                        ->setCellValue('I2', 'NUMERO_CEL')
                        ->setCellValue('J2', 'EMAIL')
                        ->setCellValue('K2', 'LIMITE DE CREDITO')
                        ->setCellValue('L2', 'TIPO DE TERCERO')
                        ->setCellValue('M2', 'REPORTE ASEGURABILIDAD')
                        ->setCellValue('N2', 'VENDEDOR')
                        ->setCellValue('O2', 'CODIGO CIUDAD')
                        ->setCellValue('P2', 'CIUDAD')
                        ->setCellValue('Q2', 'CODIGO CIUDAD 2')
                        ->setCellValue('R2', 'PAIS')
                        ->setCellValue('S2', 'CODIGO DEPARTAMENTO')
                        ->setCellValue('T2', 'DEPARTAMENTO')
                        ->setCellValue('U2', 'ESTABLECIMIENTO')
                        ->setCellValue('V2', 'Pregunta 1')
                        ->setCellValue('W2', 'Respuesta 1')
                        ->setCellValue('X2', 'Pregunta 2')
                        ->setCellValue('Y2', 'Respuesta 2')
                        ->setCellValue('Z2', 'Pregunta 3')
                        ->setCellValue('AA2', 'Respuesta 3')
                        ->setCellValue('AB2', 'Pregunta 4')
                        ->setCellValue('AC2', 'Respuesta 4')
                        ->setCellValue('AD2', 'Pregunta 5')
                        ->setCellValue('AE2', 'Respuesta 5')
                        ->setCellValue('AF2', 'Pregunta 6')
                        ->setCellValue('AG2', 'Respuesta 6')
                        ->setCellValue('AH2', 'Pregunta 7')
                        ->setCellValue('AI2', 'Respuesta 7')
                        ->setCellValue('AJ2', 'Pregunta 8')
                        ->setCellValue('AK2', 'Respuesta 8')
                        ->setCellValue('AL2', 'Pregunta 9')
                        ->setCellValue('AM2', 'Respuesta 9')
                        ->setCellValue('AN2', 'Pregunta 10')
                        ->setCellValue('AO2', 'Respuesta 10');
                     
                    
                    $objWorkSheet->setTitle("Credito y Cartera.");
                }
            
        } 
        //BORRAR DTOS
        $fil=3;
        $objPHPExcel->setActiveSheetIndex(0);
        $totalreg = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $totalreg=$totalreg+1;
        while ($fil <= $totalreg) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('O'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('P'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('R'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('S'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('T'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('U'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('V'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('W'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('X'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AK'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AL'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AM'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AN'.$fil, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AO'.$fil, '');
            
            $fil++;
        }
        //ANCHOS
        $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(25);
        
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', "Credito y Cartera");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
//DATOS        
foreach($datos1 as $dato1){
        if(($i%2)==0){
            $color="#AED6F1";
        }else{
            $color="#E8F6F3";
        }
        //$d2=$dato1['cedula'];
        $d3=$dato1['cedula'];
        $d4=$dato1['nombre'];
        $d5=$dato1['nom_completo'];
        $d6=$dato1['fech_nacimiento'];
        $d7=$dato1['direccion'];
        $d8=$dato1['direccion2'];
        $d9=$dato1['tel'];
        $d10=$dato1['cel'];
        $d11=$dato1['email'];
        $d12=$dato1['lim_credito'];
        $d13=$dato1['tip_tercerp'];
        $d14=$dato1['rep_asergu'];
        $d15=$dato1['vendedor'];
        $d16=$dato1['cod_ciudad'];
        $d17=$dato1['ciudad'];
        $d18=$dato1['cod_ciudad2'];
        $d19=$dato1['pais'];
        $d20=$dato1['cod_depar'];
        $d21=$dato1['departamento'];
        $d22=$dato1['establecimiento'];
        //forma 2: number_format($numero, 2, ",", ".");
        $num_de=number_format($d12);
        //$prue=number_format($d8, ",", ".");
        $ce=0;
        $Cedu=array($d2=$dato1['cedula']);
        
        $dc=$dato1['id_cliente'];
        
        $querypre="select rp.name as nombre,cpq.name as pregunta,cpa.name as respuesta from res_partner as rp
        left join partner_question_rel as pqr on rp.id=pqr.partner
        left join res_partner_res_partner_category_rel as rprpcr on rp.id = rprpcr.partner_id
        left join res_partner_category as rpc on rprpcr.category_id=rpc.id
        left join crm_profiling_answer as cpa on pqr.answer=cpa.id
        left join crm_profiling_question as cpq on cpa.question_id=cpq.id
        where rp.customer='true' and rpc.name='CREDITO' and rp.ref='".$Cedu[$ce]."';";
            
        //$porciones = explode(" ", $pizza);
        //$limit = explode("-",$_POST['paginador']);
            //consulta funciona pero genera mucha demora 
            /*
            $query2="select * from ir_property where res_id like '%".$dc."%' and name='property_account_receivable';";
            $resultado2= $Conn->prepare($query2);
            $resultado2->execute();
            $datos2=$resultado2->fetchAll();
            
            foreach($datos2 as $dato2){
                $id_aa=$dato2['value_reference'];
                
                    $respa = explode('account.account,', $id_aa);
                    $Resa=$respa[1];
                    
                    $querya="select code,name from account_account where id='".$Resa."';";
                    $resultadoa= $Conn->prepare($querya);
                    $resultadoa->execute();
                    $datosa=$resultadoa->fetchAll();
        
                    foreach($datosa as $datoa){
                        $id_na1=$datoa['name'];
                        if($id_na1!=''){
                            $id_na1=$datoa['name'];
                            $id_ca1=$datoa['code'];
                            $respuesta1=$id_ca1."-1-".$id_na1;
                        }else{
                            $respuesta1="N/A";
                        }
                    }
            }
            $query3="select * from ir_property where res_id like '%".$dc."%' and name='property_account_payable';";
            $resultado3= $Conn->prepare($query3);
            $resultado3->execute();
            $datos3=$resultado3->fetchAll();
            
            foreach($datos3 as $dato3){
                    $id_ba=$dato3['value_reference'];                    
                    
                        $respb = explode('account.account,', $id_ba);
                        $Resb=$respb[1];
                        
                        $queryb="select * from account_account where id='".$Resb."';";
                        $resultadob= $Conn->prepare($queryb);
                        $resultadob->execute();
                        $datosb=$resultadob->fetchAll();
                        
                        foreach($datosb as $datob){
                            $id_ab1=$datob['name'];
                            if($id_ab1!=''){
                                $id_nb1=$datob['name'];
                                $id_cb1=$datob['code'];
                                $respuesta2=$id_nb1."-2-".$id_cb1;
                            }else{
                                $respuesta2="N/A";
                            }
                            //$r=$r."<p>Categorizaci&oacute;n ".$queryb."</p>";
                        }
                    
              }  
            $query4="select * from ir_property where res_id like '%".$dc."%' and name='property_account_anticipo_cliente';";
            $resultado4= $Conn->prepare($query4);
            $resultado4->execute();
            $datos4=$resultado4->fetchAll();
            
            foreach($datos4 as $dato4){
                    $id_ca=$dato4['value_reference'];
                    
                        $respc = explode('account.account,', $id_ca);
                        $Resc=$respc[1];
                        
                        $queryc="select * from account_account where id='".$Resc."';";
                        $resultadoc= $Conn->prepare($queryc);
                        $resultadoc->execute();
                        $datosc=$resultadoc->fetchAll();
                        //$cantP3=count($datos3);
                        //$i=0;
            
                        foreach($datosc as $datoc){
                            $id_ac1=$datoc['name'];
                            if($id_ac1!=''){
                                $id_nc1=$datoc['name'];
                                $id_cc1=$datoc['code'];
                                $respuesta3=$id_nc1."-3-".$id_cc1;
                            }else{
                                $respuesta3="N/A";
                            }
                        }
                    
            }*/
            $ce1=0;
            $resultadopre= $Conn->prepare($querypre);
            $resultadopre->execute();
            $datospre=$resultadopre->fetchAll();
            
            foreach($datospre as $datopre){
                $cantP1=count($datospre);
                //$nompreg=$datopre['nombre'];
                //$nombrepr=array($nompr);
                
                $pregu=$datopre['pregunta'];
                
                $respu=$datopre['respuesta'];

                    if($ce1==0){
                        $pre0=$pregu;
                        $resp0=$respu;
                    }else if($ce1==1){
                        $pre1=$pregu;
                        $resp1=$respu;
                    }else if($ce1==2){
                        $pre2=$pregu;
                        $resp2=$respu;
                    }else if($ce1==3){
                        $pre3=$pregu;
                        $resp3=$respu;
                    }else if($ce1==4){
                        $pre4=$pregu;
                        $resp4=$respu;
                    }else if($ce1==5){
                        $pre5=$pregu;
                        $resp5=$respu;
                    }else if($ce1==6){
                        $pre6=$pregu;
                        $resp6=$respu;
                    }else if($ce1==7){
                        $pre7=$pregu;
                        $resp7=$respu;
                    }else if($ce1==8){
                        $pre8=$pregu;
                        $resp8=$respu;
                    }else if($ce1==9){
                        $pre9=$pregu;
                        $resp9=$respu;
                    }else if($ce1==10){
                        $pre9=$pregu;
                        $resp9=$respu;
                    }
                    $ce1++;
            }
                            $r=$r."<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
                            $r=$r."<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$i."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d3."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d4."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d5."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d6."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d7."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d8."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d9."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d10."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d11."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$num_de."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d13."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d14."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d15."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d16."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d17."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d18."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d19."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d20."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d21."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$d22."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'></td>
                                
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre0."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp0."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre1."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp1."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre2."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp2."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre3."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp3."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre4."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp4."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre5."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp5."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre6."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp6."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre7."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp7."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre8."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp8."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre9."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp9."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$pre10."</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(220,220,220);height: 10px;padding: 5px;'>".$resp10."</td>";
                            $r=$r."</tr>";
        
                            
                            //EXCEL
                            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$fd, $i)            
                            ->setCellValueExplicitByColumnAndRow(1, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('B'.$fd, $d2)
                            ->setCellValue('C'.$fd, $d4)
                            ->setCellValue('D'.$fd, $d5)
                            //->setCellValueExplicitByColumnAndRow(2, $fd, $d4, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValueExplicitByColumnAndRow(3, $fd, $d13, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('E'.$fd, $d6)
                            //->setCellValue('F'.$fd, $d7)
                            ->setCellValueExplicitByColumnAndRow(5, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
                            //->setCellValue('G'.$fd, $d7)
                            ->setCellValue('G'.$fd, $d8)
                            ->setCellValue('H'.$fd, $d9)
                            ->setCellValue('I'.$fd, $d10)
                            //->setCellValueExplicitByColumnAndRow(8, $fd, $d18, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValue('J'.$fd, $d11)
                            ->setCellValue('K'.$fd, $num_de)
                            ->setCellValue('L'.$fd, $d13)
                            ->setCellValue('M'.$fd, $d14)
                            ->setCellValue('N'.$fd, $d15)
                            ->setCellValue('O'.$fd, $d16)
                            ->setCellValue('P'.$fd, $d17)
                            ->setCellValue('Q'.$fd, $d18)
                            ->setCellValue('R'.$fd, $d19)
                            ->setCellValue('S'.$fd, $d20)
                            ->setCellValue('T'.$fd, $d21)
                            ->setCellValue('U'.$fd, $d22)
                            ->setCellValue('V'.$fd, $pre0)
                            ->setCellValue('W'.$fd, $resp0)
                            ->setCellValue('X'.$fd, $pre1)
                            ->setCellValue('Y'.$fd, $resp1) 
                            ->setCellValue('Z'.$fd, $pre2)
                            ->setCellValue('AA'.$fd, $resp2)
                            ->setCellValue('AB'.$fd, $pre3)
                            ->setCellValue('AC'.$fd, $resp3)
                            ->setCellValue('AD'.$fd, $pre4)
                            ->setCellValue('AE'.$fd, $resp4)
                            ->setCellValue('AF'.$fd, $pre5)
                            ->setCellValue('AG'.$fd, $resp5)
                            ->setCellValue('AH'.$fd, $pre6)
                            ->setCellValue('AI'.$fd, $resp6)
                            ->setCellValue('AJ'.$fd, $pre7)
                            ->setCellValue('AK'.$fd, $resp7)
                            ->setCellValue('AL'.$fd, $pre8)
                            ->setCellValue('AM'.$fd, $resp8)
                            ->setCellValue('AN'.$fd, $pre9) 
                            ->setCellValue('AO'.$fd, $resp9)
                            ->setCellValue('AP'.$fd, $pre10)
                            ->setCellValue('AQ'.$fd, $resp10);
                            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('V2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('W2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('X2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('Y2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('Z2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AA2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AB2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AC2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AD2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AE2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AF2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AG2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AH2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AI2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AJ2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AK2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AL2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AM2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AN2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AO2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AP2')->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AQ2')->getFont()->setBold(true);
                            $fd++;
                            $i++;
                            $ce++;
}
$r=$r . "</table>";

//CERRRAR CONEXION BASE
mssql_close();
    //CREA ARCHIVO************************************************************
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    //Guardar el achivo: 
    $objWriter->save($mipath2);

echo $r;
?>
