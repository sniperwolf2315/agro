<?
/**
Crea formulario apartir de una tabla

Recibe parametros
-Titulo del formulario:  $titulo ="Formulario de Creacion de Plan";
-Cantidad de preguntas por linea: $preguntasxl = 1;
-Tabla a interenir: $tabla = "prov_plan"; *En las tablas en el primer campo debe ser "id"
-Campos obligatorios: $obligatorios = array('PRIMER_NOMBRE','PRIMER_APELLIDO'); / Para Todos : $obligatorios = "todos";
-Campos que disparan el eveno OnChange: $onchange = array('CUANTOS_HIJOS');
-Listas de origen otro select almacenar en : $lis[CAMPO] = "Opcion1|Opcion2|Opcion3|Opcion4|";
-Valores Predeterminados: $lis[PRED][CAMPO] = "Valor";
-Campos bloqueados a escritura: $readonlys = array('id_plan')
-Control de Contenido $control["$CAMPO"] = ">= '$VALOR'"
-pagina cuando click boton cerrar formulario: $pagCierre = "index.php";
**/

//VALIDA OBLIGATORIOS
if($obligatorios =="todos"){ $todos = 'SI';}
foreach($_POST as $campoP => $valorP){
	if($todos =='SI'){ $obligatorios= array($campoP); }
	if(in_array("$campoP",$obligatorios)){
		if($valorP ==''){ $errores+= 1; $colorE["$campoP"] = "background-color:LIGHTpink;"; }
	}
} 
if(count($obligatorios)== $errores){ $colorE = array(); }

// VALIDA VALORES
  foreach($control as $campoC => $valorC){
	$contr = explode(" ", $valorC);
	$signoCO = trim($contr[0]);
	$valorCO = trim($contr[1]); 
	if($signoCO == '>'){
	  if($_POST["$campoC"] > $valorCO){}else{ $msjCO =" $campoC debe ser MAYOR que $valorCO "; $errores+= 1;  }	
	  }
	if($signoCO == '>='){ 
	  if($_POST["$campoC"] >= $valorCO){}else{ $msjCO =" $campoC debe ser MAYOR O IGUAL que $valorCO "; $errores+= 1;  }	
	  }
	if($signoCO == '<'){
	  if($_POST["$campoC"] < $valorCO){}else{ $msjCO =" $campoC debe ser MENOR que $valorCO "; $errores+= 1;  }	
	  }
	if($signoCO == '<='){
	  if($_POST["$campoC"] <= $valorCO){}else{ $msjCO =" $campoC debe ser MENOR O IGUAL que $valorCO "; $errores+= 1;  }	
	  }  
  
  }
  if( strlen($msjCO) > 2 AND $_POST['completo'] == 'SI' ){ 
    echo "<script>alert('$msjCO')</script>";
    $msjCO ="";
  } 	

//SACA campos
$sql = "SHOW FULL COLUMNS FROM $tabla WHERE Field !='id' AND Field !='Vive_con_adultos_mayores_de_60_años' AND Field !='Esta_persona_padece_de_alguna_de_las_siguientes_enfermedades' AND Field !='Que_parentezco_tiene_con_usted' AND Field !='Convive_con_personas_que_presten_servicios_de_salud'";
$result = $mysqli->query($sql) or die ('error1: '.mysqli_error());
$coma ="";
$tit='';
while($campo = $result->fetch_array())
	{
	$tit[] = utf8_encode($campo['Field']);
	  $tipo = explode('(',$campo['Type']); 
	$typ[] = $tipo[0];
	  $longitud = explode('(',$campo['Type']);
	$lon[] = str_replace(')','',$longitud[1]) + 0 ;
	$lis[] = explode('|',utf8_encode($campo['Comment']));
    //CAMBIADO
    //if($lis[0]=='') $lis[0]='NO';  
	}

//saca datos para editar
if($_POST['editId'] AND( $_POST['editId'] != $_POST['editIdH'] )){
  $sql = "SELECT * FROM $tabla WHERE id ='$_POST[editId]'";
  $result = $mysqli->query($sql) or die ('error2: '.mysqli_error());
  while($campo = $result->fetch_assoc())
	{
		foreach($campo AS $tituloED => $valorED){
			$_POST["$tituloED"] = $valorED;
            
		}
    }
  $_POST[guardo] ='SI';
  $_POST[maxId] =  $_POST['editId'];		
}

//inserta datos
if(count($_POST) > 0 AND $errores == 0 AND $_POST['completo'] == 'SI'){
	$coma = '';
	foreach($tit as $line => $campo){
	$campos .= "$coma$campo";
	
	$values .= "$coma'".$_POST["$campo"]."'";
	$coma =',';
	}
	
	$sql = "INSERT INTO $tabla (".utf8_decode($campos).") VALUES ($values) "; //echo $sql;
	$mysqli->query($sql);
	$errorMS = $mysqli->errno;
	
	$campos = '';
	$values = '';
	
	$siga ='NO';
	
	if($errorMS == ''){ 
	   $_POST = array();
	   $_POST[guardo] ='SI';
	  //buscala primera columna que debe ser el ID del registro
	  $sql = "SHOW FULL COLUMNS FROM $tabla";
        $result = $mysqli->query($sql) or die ('error2: '.mysqli_error($mysqli));
        while($campo = $result->fetch_array())
	      {
	       $primCol = $campo['Field'];
	       break;
          }
      //devuelve el ultimo id creado en la tabla    
      $sql = "SELECT MAX($primCol) FROM $tabla ";
        $result = $mysqli->query($sql) or die ('error3: '.mysqli_error());
        while($campo = $result->fetch_array())
	      {
	       $_POST[maxId] = $campo[0];
          }
      //echo '<script>alert(" ***** \n Detalle de plan \n Guardado con exito \n en id '.$_POST[maxId].' \n *******")</script>';    
	  }
	if($errorMS == '1062'){ 
		echo '<script>alert(" ***** \n Cedula \n Ya existe un Registro \n con estos datos \n *******")</script>';
		}elseif($errorMS != ''){
		echo '<script>alert(" ***** \n Error !\n Tome nota de este error y reporte el caso: \n '.$mysqli->error.' \n *******")</script>';
		}
		
} //fin if errores

?>
<div id="ifra724vlrhy2" align="center" class="aut " style="width:100%; height:auto; ">
<br>
<!-- <input type="hidden" id='cols' name="cols"> -->
<table align="center" class="frr" width="85%" border="0" cellspacing="0">
	<tr>
		<td bgcolor="white" align="center" valign="middle" colspan="<?= $preguntasxl*2?>" ><img src="../../images/logoAG.jpg" height="50%"><br><font size="+3" ><?= $titulo?></font></td>
	</tr> 
	<tr>
	<?
    $filax=1;
	foreach($tit as $fila => $titulo){
	if($lon["$fila"] <= 0){
		$anchoC = "90%";
		}elseif($lon["$fila"] <= 5){
		$anchoC = "15%";
		}elseif($lon["$fila"] <= 10){
		$anchoC = "50%";
		}else{
		$anchoC = "90%";
		}
		
	$tipo = "type='text'";	
	if($typ["$fila"] == 'date'){ $tipo = "type='date'";	}
	if($typ["$fila"] == 'int'){ $tipo = "type='number'";	}
    
    $eventoS ='';
    //campos con propiedad onchange
	if(in_array("$titulo",$onchange)){
		$eventoS .=" onchange='this.form.submit();' ";
		}
	
	//campos con propiedad onchange
	if(in_array("$titulo",$readonlys)){
		$eventoS .=" readonly ";
		}

	//listas select
	if(strlen($lis["$titulo"]) ){$lis["$fila"] = explode('|',utf8_encode($lis["$titulo"])); }
	
	//valores predeterminados
	if($_POST[$titulo] =='' AND strlen($lis[PRED]["$titulo"])  ){$_POST[$titulo] = $lis[PRED]["$titulo"];}
	$filax++;
	//$_POST[$titulo]
	if( count($lis["$fila"]) > 1 ){
		if( $filax > 5){
            $campo = "<select $eventoS class='frr campo' style='width:25%;".$colorE["$titulo"]."' id='$titulo' name='$titulo'>
                    <option>NO</option>";
        }else{
            $campo = "<select $eventoS class='frr campo' style='width:25%;".$colorE["$titulo"]."' id='$titulo' name='$titulo'>
                    <option>".$_POST[$titulo]."</option>";
        }
		foreach($lis["$fila"] as $valorl){
            //cambiado2
            if ($_POST[$titulo] != $valorl ){$campo .= "<option>$valorl</option>";}	
		}
		$campo .= "</select>";	
		}else{
		$campo = "<input $eventoS $tipo class='frr campo' style='width:$anchoC;".$colorE["$titulo"]."' id='$titulo' name='$titulo' value='".$_POST[$titulo]."'>";
		}
	$anchoCT = 40/$preguntasxl;
	$anchoCC = 60/$preguntasxl;	
	
	echo "<td align='right' width='".$anchoCT."%'>".str_replace('_',' ',$titulo)."</td>
		  <td  width='".$anchoCC."%'> : $campo</td>
		  ";
    	if(($fila+1) % $preguntasxl == 0){ 
    	if($color ==''){ $color = "bgcolor='whitesmoke'"; }else{ $color = ''; }
    	echo "</tr><tr $color >"; 
    	}
	}
    echo "</tr>
    	  <tr>
    	  	<td align='center' colspan='".($preguntasxl*2)."'>";
		
    
	echo "</tr>
    	 ";
    	
    echo "</table>
    	</td></tr>";
    ?>
	<tr bgcolor="white" >
		<td align="center" colspan="<?= $preguntasxl*2?>" style="height:auto" >

</td>
	</tr>
	<tr bgcolor="white" >
		<td align="center" colspan="<?= $preguntasxl*2?>" style="height: 31px" >
		Datos completos:<input type="checkbox" name="completo" id="completo" value="SI">
		<br><br />
		<input onclick="this.form.submit()" type="button" value=" Enviar ">
		<br>
		<br>
		<br>
		<input onclick="location.href='<?= $pagCierre?>'" type="button" value=" Cerrar formulario ">
		</td>
	</tr>	    
</table>

</div>

