<? 
if(  $_SESSION["usuARio"] == 'BARONF'
  		OR $_SESSION["usuARio"] == 'SILVAJ'
  		OR $_SESSION["usuARio"] == 'TORRESC'
  		OR $_SESSION["usuARio"] == 'OYUELAL'
  		OR $_SESSION["usuARio"] == 'SILVAJ'
  		OR $_SESSION["usuARio"] == 'MORANTESM'
  		OR $_SESSION["usuARio"] == 'JIMENEZR'
  		OR $_SESSION["usuARio"] == 'HOYOSF'
  		OR $_SESSION["usuARio"] == 'SUAREZM'
        OR $_SESSION["usuARio"] == 'SUAREZ'
  		OR $_SESSION["usuARio"] == 'RODRIGUEZA'
  		OR $_SESSION["usuARio"] == 'IBANEZV'
  		OR $_SESSION["usuARio"] == 'NIETOJ'
  		OR $_SESSION["usuARio"] == 'RODRIGUEZC'
		OR $_SESSION["usuARio"] == 'PEREZD'
		OR $_SESSION["usuARio"] == 'LOPEZS'
		OR $_SESSION["usuARio"] == 'LOPEZJ'
		OR $_SESSION["usuARio"] == 'GERENCIA'
		OR $_SESSION["usuARio"] == 'REPORTE'
		OR $_SESSION["usuARio"] == 'ESTADISTIC'
       		OR $_SESSION["usuARio"] == 'PAEZD'
		OR $_SESSION["usuARio"] == 'CHACONL'
		OR $_SESSION["usuARio"] == 'PARDOD'
		OR $_SESSION["usuARio"] == 'SANCHEZL'
       OR $_SESSION["usuARio"] == 'SISTEMSENA'
       OR $_SESSION["usuARio"] == 'PINILLOSM'
       OR $_SESSION["usuARio"] == 'RODRIGUEZF'
       OR $_SESSION["usuARio"] == 'CALDERONM'
		){ 
		$_SESSION["dIr"] ='SI';
		}
		
if(  $_SESSION["dIr"] == 'SI'){ 
	$patrones ='SI';
  }elseif(
  $_SESSION["usuARio"] == 'GRAJALESC'
  ){ $_POST['area'] = 'Mascotas'; $patrones ='SI';
  }elseif(
  $_SESSION["usuARio"] == 'TAMAYOD'
  OR $_SESSION["usuARio"] == 'ROMEROH' 
  ){ $_POST['area'] = 'Ganaderia'; $patrones ='SI';
  }elseif(
  $_SESSION["usuARio"] == 'FERROR'
  ){ $_POST['area'] = 'Venta Externa';
  }elseif(
  $_SESSION["usuARio"] == 'CHACONL'
  ){ $_POST['area'] = 'Call';
  }elseif(
  $_SESSION["usuARio"] == 'CASTILLOW'
  OR $_SESSION["usuARio"] == 'MONTENEGRO'
  OR $_SESSION["usuARio"] == 'VILLAJ'
  OR $_SESSION["usuARio"] == 'RODRIGUEZD'
  ){ $_POST['area'] = 'Almacen';
  }elseif(
  $_SESSION["usuARio"] == 'DIGITAL'
  ){ $_POST['area'] = 'Rappi';
  }elseif(
  $_SESSION["usuARio"] == 'POLOP'
  ){ $_POST['area'] = 'Plagas';
  }else{
  $sql ="select UPHAND from SROUSP WHERE UPUSER = '$_SESSION[usuARio]'";
  $result = odbc_exec($db2conp, $sql);
  while($row = odbc_fetch_array($result)){
  	if(trim($row["UPHAND"]) == 'VANANDELL'){
  		$_POST['vendedor'] = str_replace("EXT","D",$_SESSION['usuARio']);
  		}else{
 	 	$_POST['vendedor'] = TRIM($row["UPHAND"]);
  		}
  //PESTAR GANADERIA
	if($_SESSION['usuARio'] =='CRUZS'){ $_POST['vendedor'] = 'VENPEST003'; }
	if($_SESSION['usuARio'] =='TORRESY'){ $_POST['vendedor'] = 'VENPEST004'; }
	if($_SESSION['usuARio'] =='ORJUELAK'){ $_POST['vendedor'] = 'VENPEST006'; }
	//if($_SESSION['usuARio'] =='HERNANDEZF'){ $_POST['vendedor'] = 'VENPEST007'; }
    if($_SESSION['usuARio'] =='SUAREZM'){ $_POST['vendedor'] = 'VENPEST007'; }
	if($_SESSION['usuARio'] =='MARTINEZJ'){ $_POST['vendedor'] = 'VENPEST008'; }
	if($_SESSION['usuARio'] =='TORRESJ'){ $_POST['vendedor'] = 'VENPEST009'; }
	if($_SESSION['usuARio'] =='AMOROCHOM'){ $_POST['vendedor'] = 'VENPEST010'; }
	if($_SESSION['usuARio'] =='GARZONJ'){ $_POST['vendedor'] = 'VENPEST011'; } 
	if($_SESSION['usuARio'] =='SILVAM'){ $_POST['vendedor'] = 'VENPEST012'; }
	if($_SESSION['usuARio'] =='FIRIGUAC'){ $_POST['vendedor'] = 'VENPEST013'; }
	if($_SESSION['usuARio'] =='GRISALESC'){ $_POST['vendedor'] = 'VENPEST016'; }
    if($_SESSION['usuARio'] =='VASQUEZY'){ $_POST['vendedor'] = 'VENPEST021'; }

  //PESTAR MASCOTAS
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST014'; }
	if($_SESSION['usuARio'] =='GARCIAD'){ $_POST['vendedor'] = 'VENPEST015'; }
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST017'; }
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST018'; }
	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENPEST019'; }
  
  // COMERVET
  	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENDCO01'; }
  	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENDCO02'; }
  	if($_SESSION['usuARio'] =='TRUJILLOT'){ $_POST['vendedor'] = 'VENDCO03'; }
  	if($_SESSION['usuARio'] ==''){ $_POST['vendedor'] = 'VENDCO04'; }
  	if($_SESSION['usuARio'] =='LOPEZM'){ $_POST['vendedor'] = 'VENDCO05'; }
  	if($_SESSION['usuARio'] =='OTARTEO'){ $_POST['vendedor'] = 'VENDCO06'; }
  	if($_SESSION['usuARio'] =='SALAMANCAJ'){ $_POST['vendedor'] = 'VENDCO11'; }
  	
  	//if($_SESSION['usuARio'] =='POLOP'){ $_POST['vendedor'] = 'VENDCO16'; }
  
  //BODEGAS RAPPI * debe agregar tambien en grupo de vendedroes
    if($_SESSION['usuARio'] =='RAPPIBOSQU'){ 
      $_POST['vendedor'] = 'VEND528'; 
      $_POST['bod'] = '020';
      }
    if($_SESSION['usuARio'] =='ANIMALF'){ 
      $_POST['vendedor'] = 'VEND549'; 
      $_POST['bod'] = '030';
      }
    if($_SESSION['usuARio'] =='RAPPICHIA'){ 
      $_POST['vendedor'] = 'VEND560';
      $_POST['bod'] = '040';
     }
    if($_SESSION['usuARio'] =='RAPPITOBER'){ 
      $_POST['vendedor'] = 'VEND561';
      $_POST['bod'] = '050';
     }  
  	
  //USUARIO consultas sin bodega bodega
    if($_SESSION['usuARio'] =='CONSULTA'){ 
      $_POST['vendedor'] = 'CONSULTA'; 
      $_POST['bod'] = '000';
      }	
  }
  }



//GRUPOS DE VEDEDORES
// pagina web
$vendweb = "'VENDWEB'";
$arrweb= explode(",", $vendweb);
if(in_array("'".trim($_POST['vendedor'])."'",$arrweb)){$_POST['area'] = "Pagina WEB";}


// bodegas rappi
$vendrappi = "'VEND417','VEND549','VEND528','VEND560','VEND561'";
$arrrappi= explode(",", $vendrappi);
if(in_array("'".trim($_POST['vendedor'])."'",$arrrappi)){$_POST['area'] = "Rappi";}
 
//CALCENTER AGRO
$vendcall = "'VEND321','VEND389','VEND414','VEND419','VEND437','VEND439','VEND443','VEND452','VEND466','VEND468','VEND469',
			 'VEND471','VEND473','VEND475','VEND480','VEND481','VEND483','VEND500','VEND501','VEND502','VEND503',
			 'VEND510','VEND515','VEND525','VEND526','VEND530','VEND531','VEND532','VEND533','VEND535','VEND539','VEND540',
			 'VEND542','VEND543','VEND553','VEND565','VEND577','VEND578','VEND579','VEND580','VEND583','VEND582','VEND584','VEND585',
             'VEND588','VEND589','VEND590','VEND594'"; 
			 //,'VEND524','VEND558','VEND550' son del almacen haciendo teletrabajo
$arrcall= explode(",", $vendcall);
if(in_array("'".trim($_POST['vendedor'])."'",$arrcall)){$_POST['area'] = "Call";}


//VENTA EXTERNA	agrocampo
$vendext = "'VEND014','VEND039','VEND040','VEND045','VEND078','VEND079','VEND081','VEND114','VEND165','VEND183','VEND214', 
	        'VEND252','VEND260','VEND310','VEND313','VEND314','VEND334','VEND338','VENDOTC'";
$arrext= explode(",", $vendext);
if(in_array("'".trim($_POST['vendedor'])."'",$arrext)){$_POST['area'] = "Venta Externa";}


//ALMACEN	         
/*$vendalm = "'VEND050','VEND164','VEND250','VEND251','VEND302','VEND304','VEND358','VEND363','VEND368','VEND369',
			'VEND380','VEND404','VEND408','VEND425','VEND492','VEND495','VEND498','VEND506','VEND507','VEND509',
			'VEND513','VEND516','VEND517','VEND518','VEND519','VEND520','VEND522','VEND523',
			'VEND524','VEND527','VEND529','VEND534','VEND537','VEND538','VEND541','VEND544','VEND545','VEND547',
			'VEND550','VEND552','VEND554','VEND555','VEND556','VEND557','VEND558','VEND559','VEND563','VEND564','VEND567','VEND568','VEND569','VEND570','VEND571'
                        ,'VEND572','VEND573','VEND574','VEND575','VEND576','VEND888','VEND586','VEND250A','VEND250B','VEND595','VENJOR' ";
$arralm= explode(",", $vendalm);			
if(in_array("'".trim($_POST['vendedor'])."'",$arralm)){$_POST['area'] = "Almacen";}
*/

/////////////////////////Jorge Lopez //// pendiente realizar la conexion a sql y de hay sacar los vendedores por almacen
///SELECT * FROM [sqlFacturas].[dbo].[cliVendedor]
//  WHERE SectorLab='CONCENTRADOS'  --,'GATOS','MOSTRADOR','PEQUEÑOS','IMPORTADOS','SEMILLAS  Y FERRETERIA','VACUNACION','CANALES DIGITALES','OTROS'
//  order by Codigo asc
$labcont=0;
$contvendslql=1;
require_once('conectarbaseprodmes.php');
$laboratorios=array("CONCENTRADOS","GATOS","MOSTRADOR","PEQUE","IMPORTADOS","SEMILLAS  Y FERRETERIA","VACUNACION","CANALES DIGITALES","OTROS");
$vendalm="";
for($i=0;$i<9;$i++){
//$queryv = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab = '$area' ORDER BY Codigo ASC;", $cLink);
$consultaVend="SELECT * FROM [sqlFacturas].[dbo].[cliVendedor] WHERE SectorLab like '%$laboratorios[$labcont]%' order by Codigo asc;";
  $queryv = mssql_query($consultaVend, $cLink);
  $numvend=mssql_num_rows($queryv);
  while($rowVend = mssql_fetch_array($queryv)){
    $Labved = trim($rowVend['SectorLab']);
    $Nomved = trim($rowVend['Nombres']);
    $Apeved = trim($rowVend['Apellidos']);
    $Nombres=$Nomved." ".$Apeved;
    if($labcont==8){
      if($numvend==$contvendslql){
        $vend = "'".trim($rowVend['Codigo'])."'";//* ".$Nombres." *:"
        $venlabo = trim($rowVend['SectorLab'].",");
      }else{
        $vend = "'".trim($rowVend['Codigo'])."',";
        $venlabo = trim($rowVend['SectorLab'].",");
      }
    }else{
      $vend = "'".trim($rowVend['Codigo'])."',";
      $venlabo = trim($rowVend['SectorLab'].",");
    }
    $labo = $laboratorios[$labcont].",";
    if($labcont==0){
      $vendcon=$vendcon.$vend;
      $labvendedorcon=$labvendedorcon.$venlabo;//.$venlabo
    }else if($labcont==1){
      $vendgat=$vendgat.$vend;
      $labvendedorgat=$labvendedorgat.$venlabo;
    }else if($labcont==2){
      $vendmos=$vendmos.$vend;
      $labvendedormos=$labvendedormos.$venlabo;
    }else if($labcont==3){
      $vendpeq=$vendpeq.$vend;
      $labvendedorpeq=$labvendedorpeq.$venlabo;
    }else if($labcont==4){
      $vendimp=$vendimp.$vend;
      $labvendedorimp=$labvendedorimp.$venlabo;
    }else if($labcont==5){
      $vendsem=$vendsem.$vend;
      $labvendedorsem=$labvendedorsem.$venlabo;
    }else if($labcont==6){
      $vendvac=$vendvac.$vend;
      $labvendedorvac=$labvendedorvac.$venlabo;
    }else if($labcont==7){
      $vendcan=$vendcan.$vend;
      $labvendedorcan=$labvendedorcan.$venlabo;
    }else if($labcont==8){
      $vendotro=$vendotro.$vend;
      $labvendedorotro=$labvendedorotro.$venlabo;
    }
    $contvendslql++;
    //$vendcod=$labcont." ".$vendcon." - ".$vendgat." -* ".$vendgat." lab a: ".$labcont." lab b: ".$labo."<\ br>";


    //$lab = trim($rowVend['SectorLab']).",";
    //$vendcod=$vendcod.$vend."**".$labcont.";*".$i.":*";
    //if($lab!=''){
    //  $labven=$lab;
    //}
    //$nose=$nose.$consultaVend;
  }
  $labcont++;
  $contvendslql=1;
  //$vendlabo=$vendlabo.$labven;   ///array($labven);
}
$vendalm=$vendalm.$vendcon.$vendgat.$vendmos.$vendpeq.$vendimp.$vendsem.$vendvac.$vendcan.$vendotro;  ///array($vendcod);
$totallabven=$totallabven.$labvendedorcon.$labvendedorgat.$labvendedormos.$labvendedorpeq.$labvendedorimp.$labvendedorsem.$labvendedorvac.$labvendedorcan.$labvendedorotro;
//$arralm=$vendalm;
//$arrall=$laboratorios;
$arralm= explode(",", $vendalm);	
$arrall= explode(",", $totallabven);
//$arrall= $vendlabo;	
if(in_array("'".trim($_POST['vendedor'])."'",$arralm)){
  $_POST['area'] = "Almacen";
}
if(in_array("'".trim($_POST['vendedor'])."'",$arrall)){
  $_POST['area'] = "lab";
}

?>
