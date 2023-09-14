<? ?>
<section23 class="frr aut" >

<? 
$hoy = date ("Y-m-d");

//titulo $titulo ="Formulario de Creacion de Plan";
$titulo ="Formulario de Creacion de Evento";

//preguntaspor linea: $preguntasxl = 1;
$preguntasxl = 1;

// TABLA $tabla = "prov_plan";
$tabla = "prov_eventos";

// CAMPOS ONCHANGE SUBMIT FORM $onchange = array('CAMPO1','CAMPO2'); 
//$onchange = array('UNI');

// campos obligatorios $obligatorios = array('CAMPO1','CAMPO2'); Para todos los campos : $obligatorios = "todos";
$obligatorios = array('EVENTO','FECHA','DESDE','HASTA');

//LISTAS DE ORIGEN SELECT : $lis[CAMPO] = "Opcion1|Opcion2|Opcion3|Opcion4";
/*
$sql ="SELECT EVENTO FROM prov_eventos WHERE AÑO = '$_POST[ano]' "; //AÃ‘O
$result = mysqli_query($mysqli, $sql);
while($row = mysqli_fetch_row($result)){
  $lis[DETALLE] .= "$coma$row[0]";
  $coma ='|';
  }
*/

// Valores Predeterminados: $lis[PRED][CAMPO] = "Valor";
$lis[PRED][FECHA] = $hoy;


//campos bloqueados a escritura: $readonlys = array('id_plan') 
$readonlys = array('id_plan','FECHA');

//pagina cuando click boton cerrar formulario: $pagCierre = "index.php";
$pagCierre = "prov_evento.php";

//Control de Contenido $control["$CAMPO"] = ">= '$VALOR'"
$control["PORCENTAJE_1"] = "<= 100";
$control["PORCENTAJE_2"] = "<= 100";

//$control["DESDE"] = ">= $hoy";
$control["HASTA"] = ">= ".$_POST["DESDE"];


// id para editar registros
$_POST['editId'] = $_POST['id_evento'];

// codigo constructor de formulario
include("../../_crud.php");


/*
Se carga el formulario para guardar articulos
Si el crud devuelve guardo ='SI'
*/
if($_POST[guardo] =='SI'){
include("prov_evento_ev_art.php");
}
?>

<input checked onChange="this.form.submit()" type="radio" class="frr" id="queVer" name="queVer" value="nuevoDetalle" >
</section23>
