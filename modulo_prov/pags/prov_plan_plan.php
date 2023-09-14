<section23 class="frr aut" >

<? 
$hoy = date ("Y-m-d");

//titulo $titulo ="Formulario de Creacion de Plan";
$titulo ="Formulario de Creacion de Plan Año";

//preguntaspor linea: $preguntasxl = 1;
$preguntasxl = 1;

// TABLA $tabla = "prov_plan";
$tabla = "prov_plan";

// CAMPOS ONCHANGE SUBMIT FORM $onchange = array('CAMPO1','CAMPO2'); 
$onchange = array('CUANTOS_HIJOS');

// campos obligatorios $obligatorios = array('CAMPO1','CAMPO2'); Para todos los campos : $obligatorios = "todos";
$obligatorios = array('PROVEEDOR','NIT','TOTAL_COMPRAS','APORTE_PLAN','AÑO','GRUPO','DTO_FINANCIERO');

//LISTAS DE ORIGEN SELECT : $lis[CAMPO] = "Opcion1|Opcion2|Opcion3|Opcion4";


// Valores Predeterminados: $lis[PRED][CAMPO] = "Valor";
$lis[PRED][AÑO] = "2020";

//pagina cuando click boton cerrar formulario: $pagCierre = "index.php";
$pagCierre = "prov_plan.php";

//Control de Contenido $lis[CONT]["$CAMPO"] = ">= '$VALOR'"

$lis[CONT]["AÑO"] = ">= '".date("Y")."'";

// codigo constructor de formulario
include("../../_crud.php");

if($guardo =='SI'){
$_POST = array();

echo '<script onload="recarga()" onClick="recarga()"></script> ';
}else{
echo '<input checked onChange="this.form.submit()" type="radio" class="frr" id="queVer" name="queVer" value="nuevoPlan" >';
}
?>

</section23>
