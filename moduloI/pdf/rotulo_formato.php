<?php

/*

http://192.168.1.115/moduloI/pdf/rotulo.php?ov=8114719&cajas=1&emp=AG&tte=ERIK_PRUEBAS&guia=01020305&peso=10&tipo=caja

*/
// $ruta_powershell = 'c:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe'; #Necesitamos el powershell
//     $opciones_para_ejecutar_comando = "-c";#Ejecutamos el powershell y necesitamos el "-c" para decirle que ejecutaremos un comando
//     $espacio = " "; #ayudante para concatenar
//     $comillas = '"'; #ayudante para concatenar
//     $comando = 'get-WmiObject -class Win32_printer |ft name'; #Comando de powershell para obtener lista de impresoras
//     $lista_de_impresoras = array(); #Aquí pondremos las impresoras
//     exec(
//         $ruta_powershell
//         . $espacio
//         . $opciones_para_ejecutar_comando
//         . $espacio
//         . $comillas
//         . $comando
//         . $comillas,
//         $resultado,
//         $codigo_salida);

//     if ($codigo_salida === 0) {
//         if (is_array($resultado)) {
//             #Omitir los primeros 3 datos del arreglo, pues son el encabezado
//             for($x = 3; $x < count($resultado); $x++){
//                 $impresora = trim($resultado[$x]);
//                 if (strlen($impresora) > 0) # Ignorar los espacios en blanco o líneas vacías
//                     array_push($lista_de_impresoras, $impresora);
//             }
//         }
//         echo "<pre>";
//         print_r($lista_de_impresoras);
//         echo "</pre>";
//     } else {
//         echo "Error al ejecutar el comando.";
//     }
?>

<?php
// http://192.168.1.115/moduloI/pdf/rotulo_formato.php?ov=8506008&cajas=1&emp=AG&tte=ERIK_PRUEBAS&guia=01020305&peso=10&tipo=caja

$emp 	 = $_GET['emp'];
$ov		 = $_GET['ov'];
$cajas 	 = $_GET['cajas'];
$tte 	 = $_GET['tte'];
$guia 	 = $_GET['guia'];
$peso 	 = $_GET['peso'];
// $tipo_ov = $_GET['tipo'];

$stilos="
    font-size:40px;
    text-transform: uppercase;
";

echo "
<center>
    <form name ='frm_tipo_imp' id ='frm_tipo_imp' class='frm_tipo_imp' action='rotulo.php?ov=$ov&cajas=$cajas&emp=$emp&tte=$tte&guia=$guia&peso=$peso' method='GET' style='font-size:80px;'>
    <table>
        <tr >
            <input id ='emp'   name='emp'   type='text' value='".$emp."'  style='background-color:white; color:gray;border:2px solid darkgray'><br>
        </tr>
    
        <tr>
            <input id ='ov'    name='ov'    type='text' value='".$ov."'   style='background-color:white; color:gray;border:2px solid darkgray'><br>
        </tr>
        <tr>
            <input id ='cajas' name='cajas' type='text' value='".$cajas."'style='background-color:white; color:gray;border:2px solid darkgray'><br>
        </tr>
        <tr>
            <input id ='tte'   name='tte'   type='text' value='".$tte."'  style='background-color:white; color:gray;border:2px solid darkgray'><br>
        </tr>
        <tr>
            <input id ='guia'  name='guia'  type='text' value='".$guia."' style='background-color:white; color:gray;border:2px solid darkgray'><br>
        </tr>
        <tr>
             <input id ='guia'  name='guia'  type='text' value='".$guia."' style='background-color:white; color:gray;border:2px solid darkgray'><br>
         </tr>
        <tr>
            <input id ='peso'  name='peso'  type='text' value='".$peso."' style='background-color:white; color:gray;border:2px solid darkgray'><br>
        </tr>
        
        <tr>
             <input id ='reset' name='reset' type='button' value='reset' style='background-color:white; color:gray;border:2px solid darkgray' onclick='clear_form();'><br>
        </tr>
        <tr>
        <td><input id='tipo' name='tipo' type='button' value='tirilla' onclick='abrir_ventana(this.value);' style='$stilos'></td>
        <td><input id='tipo' name='tipo' type='button' value='grande'  onclick='abrir_ventana(this.value);' style='$stilos'></td>
        </tr>
        
        
        
    </table>    
    
        </form>
</center>

";
?>
<script>
function abrir_ventana(tipo){
    // console.log('Si dio click',tipo);
    let empresa  = document.getElementById('emp').value;
    let orden    = document.getElementById('ov').value;
    let num_caja = document.getElementById('cajas').value;
    let tte      = document.getElementById('tte').value;
    let peso     = document.getElementById('guia').value;
    let guia     = document.getElementById('peso').value;
    tipo= (tipo=='tirilla')?'bolsa':'caja';
    window.close();
    window.open(`rotulo.php?ov=${orden}&cajas=${num_caja}&emp=${empresa}&tte=${tte}&guia=${guia}&peso=${peso}&tipo=${tipo}`, "Rotulos", "width=1000, height=800")
    // console.log(` ${empresa} ${orden} ${num_caja} ${tte} ${peso} ${guia} ${tipo} ` );

}

function clear_form(){
    document.getElementById("frm_tipo_imp").reset();
}



</script>
