<?php

//db2
	$db2con = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);	
	$db2conp = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);

//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);


//MSSQL

    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);



$hoy = date("Ymd");
$hoy_1 = date("Ymd",strtotime("$hoy - 1 day"));
$hoy_2 = date("Ymd",strtotime("$hoy - 2 day"));
$hoy_3 = date("Ymd",strtotime("$hoy - 3 day"));
$hoy_4 = date("Ymd",strtotime("$hoy - 4 day"));


$hoy_10 = date("Ymd",strtotime("$hoy - 10 day"));
$n = 1;
$hoy_n = date("Ymd",strtotime("$hoy - $n day"));

$ahora = date("M-d. H:i");  
$ahora = str_replace("Jan","Ene",$ahora);

$area ='Moto';
if($area == 'Portos'){}
if($area == 'Calle73'){}
if($area == 'Moto'){ $farea =" AND SROORSHE.OHDEST IN ('1','2','3') ";}
/**
  $sql ="SELECT
			SROORSHE.OHORNO AS ORDEN
			, SUBSTR(SROORSHE.OHODAT,1,4)||'-'||SUBSTR(SROORSHE.OHODAT,5,2)||'-'||SUBSTR(SROORSHE.OHODAT,7,2) AS FECHA_ORDEN
			, (select max(SRBSOL.OLORDS) FROM AGR620CFAG.SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) AS ESTADO
			, ( SELECT DTDESC FROM AGR620CFAG.SRODST WHERE DTDEST = SROORSHE.OHDEST)  AS DEST
			, '' AS HORA_LIB
			, '' AS OBS
		FROM AGR620CFAG.SROORSHE SROORSHE
		WHERE
		((
		  SROORSHE.OHODAT >= '$hoy_n' 
		  AND 
		  (select max(SRBSOL.OLORDS) FROM AGR620CFAG.SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) BETWEEN '20' AND '59' 
	 	))
	 	
	 	$farea 
		
		ORDER BY SROORSHE.OHORNO DESC
		
";
**/
$cuantoantes = $hoy_10;

$sql = "SELECT 
         OHORNO AS ORDEN
        ,OHORDT AS TIPO
        ,OHCUNO AS CC
        ,OHORDS AS ESTADO_OV
        ,CASE WHEN
          (SELECT Max(OLORDS) AS MAX_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) = '10'
          THEN '10'
          	ELSE
          	  CASE WHEN
          	    (SELECT Max(OLORDS) AS MAX_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) = '60'
          	    THEN '60'
          	    ELSE
          	      '20-45'
          	  END
          END AS ESTADO	    
        ,(SELECT MIN(OLORDS) AS MIN_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) AS MIN_ESTADO
        ,(SELECT Max(OLORDS) AS MAX_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) AS MAX_ESTADO
        ,SUBSTR(OHODAT,1,4)||'-'||SUBSTR(OHODAT,5,2)||'-'||SUBSTR(OHODAT,7,2) AS FECHA
        ,CASE WHEN
          OHODAT >= '$hoy_1'
          THEN '1'
          	ELSE
          	  CASE WHEN
          	    OHODAT = '$hoy_2'
          	    THEN '2'
          	    ELSE
          	      CASE WHEN
          	        OHODAT = '$hoy_3'
          	          THEN '3'
  	                  ELSE
  	                    CASE WHEN
  	                      OHODAT <= '$hoy_4'
  	                      THEN '4 o mas'
  	                    END
  	               END
  	            END
  	          END
  	      AS DIA
  	    , ifnull(( SELECT case when substr(SROORSHE.OHDEST,1,4)= '1100'
  	               then 'DOMI-AGRO'
  	               ELSE
  	                 CASE when substr(SROORSHE.OHDEST,1,4) < 10
  	                 THEN substr(TRIM(DTDESC),1,7)
  	                 ELSE
  	                 'REM-'||substr(TRIM(DTDESC),1,7)
  	                 END
  	               END  
  	        FROM AGR620CFAG.SRODST WHERE DTDEST = SROORSHE.OHDEST),'SIN DEST')  AS DESTINO
                    	    
        FROM AGR620CFAG.SROORSHE SROORSHE

        Where
        OHORDT in( '01', '03', '04', '06','D3','D5','S1','S2', 'S3', 'S5' )
        AND OHODAT >= '$cuantoantes'
        AND ohstat <> 'D'
        AND OHORDS <> '0'
        ORDER BY OHODAT  
		";
	// OHORDT in( '01', '03', '04', '06','D3','D5','S1','S2', 'S3', 'S5' )
	//echo $sql;	

  $result = odbc_exec($db2conp, $sql) ; //echo $sql.odbc_errormsg();
  odbc_close();
	while($row = odbc_fetch_array($result)){
		$row["ACTUALIZADO"] = $ahora;
		$dia = $row["DIA"];
		$orden = $row["ORDEN"];
		$estado = $row["ESTADO"];
		$row["DEST"] = SUBSTR($row["DESTINO"],0,3);
		if($row["MAX_ESTADO"] =='60'){
		  $e60 .= ",'$row[ORDEN]'" ;
		  }
		$comaC = '';
        $comaV = '';
		foreach($row as $campo => $valor){
		  //datos tablero
		  $ti["$dia"]["$orden"]["$campo"]= utf8_encode(strtoupper($valor));
		  
		  //construye insert MySQL
		  $campos .= "$comaC$campo";
          $valores .= "$comaV$valor";
          $comaC = ',';
          $comaV = "','";
		  }
          $mysqlINSERT["$orden"] = "INSERT INTO tablero_dias ($campos) VALUES ('$valores'); ";
          $campos =''; $valores='';   
    }	
    




	

	$e60 = substr($e60,1);
	$sqlMS ="SELECT Orden FROM FacRegistroFactura WHERE Fecha >= '$cuantoantes' AND Orden IN($e60)";
	$resultMS = mssql_query($sqlMS) or die(mssql_get_last_message());
    while($rowMS = mssql_fetch_assoc($resultMS))
	  { $orden = $rowMS["Orden"]; 
	    foreach($ti AS $day => $algo){
	    unset($ti["$day"]["$orden"]);
	    }
	    unset($mysqlINSERT["$orden"]);
	  }

      //inserta encabezados mysql local
    mysqli_query($mysqliL, "DELETE FROM tablero_dias");
    foreach($mysqlINSERT AS $ins){
    // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
    if(mysqli_query($mysqliL, $ins)){
		// echo "$ins";
	}else{echo mysqli_error($mysqliL)."<br> $ins<br>"; }
    }
mssql_close();  
odbc_close();
?>