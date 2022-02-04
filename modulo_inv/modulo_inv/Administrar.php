<script language="JavaScript">
    function activarUsInv(logins,usuar,pagina,estado){
                    var usu=logins;//document.getElementById('Usuariox').value;
                    var pwd='';//document.getElementById('Clavex').value;
                    tipo='U';
                    valor1='U0';
                    valor2='U0';
                    if(pagina=='UBC'){
                        if(estado=='true' || estado==1){
                            valor2='U1';
                        }else{
                            valor2='U0';
                        }
                    }
                    if(pagina=='INV'){
                        if(estado=='true' || estado==1){
                            valor1='U1';
                        }else{
                            valor1='U0';
                        }
                    }
                    
                    if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'agregarusuario.php?u=' + usu + '&nu=' + usuar + '&c=' + pwd + '&t=' + tipo + '&v1=' + valor1 + '&v2=' + valor2, false);
                    peticion_http.send(null);
    
                    function muestraContenido() {
                        
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert(dato);
                                //setTimeout("location.reload(true);", 200);
                            }
                        }
                    }
                    return true;
    }
    
    function agregarUsuario(tipo){
                    var usu=document.getElementById('Usuariox').value;
                    var pwd=document.getElementById('Clavex').value;
                    usuar='buscarid';
                    valor1='I1';
                    valor2='U1';
                    if(pwd=='' || usu==''){
                        alert('Digite un usuario y clave');
                        return false;
                    }
                    if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'agregarusuario.php?u=' + usu + '&nu=' + usuar + '&c=' + pwd + '&t=' + tipo + '&v1=' + valor1 + '&v2=' + valor2, true);
                    peticion_http.send(null);
    
                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert(dato);
                                //setTimeout("location.reload(true);", 200);
                            }
                        }
                    }
              }
              
    function cerrarAplicacion(){
                    location.href='index.php';
              }
</script>
<style type="text/css">
.tabla {
    width: 90%;
    border: 1px;
    border-color: aqua;
}
.celdaa{
    background-color: #C5EFF9;
}
.celdab{
    background-color: #A8E9F9;
}
</style>
<label class="e1" id="lblv">ADMINISTRACI&Oacute;N DE USUARIOS:</label><br />
<table class="tabla">
<tr><td>Nombres</td><td>Usuario</td><td>Consultar Ubicaciones</td></tr>
<?php
    $conta=1;
   $color1="#BBE0F";
    $color2="#E1D8F";
    //$resultusu = mssql_query("SELECT * FROM [sqlFacturas].[dbo].[autFuncionario] WHERE Login LIKE '%TEMPORAL%' AND Login NOT LIKE '%VEND%' AND Activo='1'", $cLink);
    /*$Queries="SELECT DISTINCT Login,Nombres,Apellidos FROM [sqlFacturas].[dbo].[autFuncionario]";
    $Queries=$Queries." WHERE ISNUMERIC(LOGIN)=0 AND LEFT(Login,4) NOT IN('VEND','CAJA','DOMI','GONDO','CALL','MERC','VENP','AUXD','ASIS','RAPP','DIGI')";
    $Queries=$Queries." AND LEFT(Login,6) NOT IN('DOMICI','GONDOL','GOLOSI','USUARI','ADVANC','REYESM','FACTUR','TIPICA','AGROCA','NIÑONJ','S0D1V1','MOSTRA','D1960R','F1960B','BARONF','SEGURI','DIAZH','ROZOI','ADMIN','J1960C','SILVAJ','VARGAS','J1960G','ZAPIER','LOPEZS')";
    $Queries=$Queries." AND LEFT(Apellidos,3) NOT IN('COY','PRU') AND login NOT IN('CARLOS.CASTEL','VANANDELL','ADMINISTRA','RODRIGUEZC','GONZALEZS','OCHOAC','RODRIGUEZD','MORANTESN','CARDOZOJ','SYKLO','REYESC','BALLESTEROS','LUISVARGAS','NINOP','NINOM','PINILLOSM','RODRIGUEZF','CADMASCOTA','GERENCIA')";
    $Queries=$Queries." AND Login NOT IN('ALEXANDRAS','ANIMALFACTOR','MARTINEZG','GOMEZC')";
    $Queries=$Queries." AND IdPerfil is NULL AND Activo=1 ORDER BY Nombres ASC";
    */
   /*$Queries="SELECT DISTINCT";
    $Queries=$Queries=" concat(af.Nombres,' ',af.Apellidos) as Nombre";
    $Queries=$Queries=" FROM [sqlFacturas].[dbo].[facRegistroValidacion] rv";
    $Queries=$Queries=" LEFT JOIN [sqlFacturas].[dbo].[autFuncionario] af ON af.Login=rv.Funcionario";
    $Queries=$Queries=" WHERE datepart(year,rv.HoraFinal)>=2020 AND rv.Bodega='008' and af.Activo=1";
    $Queries=$Queries=" GROUP BY concat(af.Nombres,' ',af.Apellidos)";
    */
    require_once('conexionFacturas.php');
    require_once('conexioninventario80.php');
    $resultusu = mssql_query("SELECT DISTINCT af.IdFuncionario as IdFuncionario, rv.Funcionario as Login, concat(af.Nombres,' ',af.Apellidos) as Nombre FROM [sqlFacturas].[dbo].[facRegistroValidacion] rv LEFT JOIN [sqlFacturas].[dbo].[autFuncionario] af ON af.Login=rv.Funcionario WHERE datepart(year,rv.HoraFinal)>=2020 AND rv.Bodega='008' and af.Activo=1 GROUP BY af.IdFuncionario, rv.Funcionario, concat(af.Nombres,' ',af.Apellidos)", $cLinkf);
    while($fila = mssql_fetch_array($resultusu)){
        $N=$fila['Nombre'];
        $N1=utf8_encode($N);
        $L=$fila['Login'];
        $L1=utf8_encode($L);
        $L=strtoupper($L);
        $F=$fila['IdFuncionario'];
        if($conta%2==0){
            $clase="celdaa";
        }else{
            $clase="celdab";
        } 
        $conta++;
        //verifique activacion de scheck
        $resultusu2 = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invAcceso] WHERE idUsu='$F'", $cLink);
        $fila2 = mssql_fetch_array($resultusu2);
        $numero = mssql_num_rows($resultusu2);
        //echo $F."--".$numero.";";
        if($numero>0){
            $Activado=$fila2['acceso2'];
            //<td class=\"$clase\">$A</td>
            if($Activado=="U1"){
                echo "<tr><td class=\"$clase\">$N1</td><td class=\"$clase\">$L1</td><td class=\"$clase\"><input type=\"checkbox\" id=\"$F\" name=\"$L\" onchange=\"return activarUsInv(this.id,this.name,'UBC',this.checked)\" checked=\"true\" /></td></tr>";
            }else{
                echo "<tr><td class=\"$clase\">$N1</td><td class=\"$clase\">$L1</td><td class=\"$clase\"><input type=\"checkbox\" id=\"$F\" name=\"$L\" onchange=\"return activarUsInv(this.id,this.name,'UBC',this.checked)\" /></td></tr>";
            }
        }else{
            echo "<tr><td class=\"$clase\">$N1</td><td class=\"$clase\">$L1</td><td class=\"$clase\"><input type=\"checkbox\" id=\"$F\" name=\"$L\" onchange=\"return activarUsInv(this.id,this.name,'UBC',this.checked)\" /></td></tr>";
        }
    }
    mssql_close($resultusu);
?>
</table>

<br /><hr /><label class="e1" id="lblv">AGREGAR USUARIOS ADMINISTRADORES:</label><br /><br />
<form name="agregar" method="post" action="">
<table class="tabla" style="border:1px solid #000000;">
<tr>
<td>Usuario:</td><td><input type="text" id="Usuariox" /></td>
<td>Clave:</td><td><input type="password" id="Clavex" /></td>
<td><input type="button" id="enviausx" onclick="agregarUsuario('A');" value="Guardar" />
<input type="button" class="boton1" name="Abandonar" id="Abandonar" value="CERRAR" onclick="cerrarAplicacion();" />
</td>
</tr>
</table>
</form>