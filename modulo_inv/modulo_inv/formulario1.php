<?php
if (!isset($_SESSION)) { session_start(); }
$Us=$_SESSION['usuARioI'];
$compania=$_SESSION['Compan'];
$Us=strtoupper($Us);
?>
                    <div style="padding: 50px;">
                    <img src="img/logoAG.png" width="50px" height="60px" />&nbsp;
                    <label class="e1">INVENTARIO: <span style="color: #1636EE;"> <? echo $compania; echo "  ".$sede; ?></span></label><br /><? echo "Usuario: <span style=\"color: #0C22D8; font-size: 1.3em;\"> <b>".$Us;?></span></b><br />
                    <table class="tabla" style="border:1px solid #000000;">
                    <?
                    if ($sede=='Portos'){
                    ?>
                    <!--<tr style="height: 130px;"><td style="height: 50px;"><label class="e1">Seleccione Compa&ntilde;ia:</label>&nbsp;&nbsp;</td><td>
                    <select name="compan" id="compan" class="lista" onchange="leerCompan();">
                        <option value=""></option>
                        <option value="Agrocampo">Agrocampo</option>
                        <option value="Comervet">Comervet</option>
                    </select><br /><br /></td></tr>-->
                    <tr style="height: 130px;"><td style="width: 60%; height: 80px; vertical-align: top"><br /><label class="e1" id="lblv">Solicitar Vencimiento:</label>&nbsp;&nbsp;</td><td style="vertical-align: top"><br /><input type="checkbox" class="check" name="venc" id="venc" /><br /><br /><br /></td></tr>
                    <?
                    }
                    ?>
                    <tr style="height: 130px;"><td style="height: 50px;"><label class="e1">Seleccione conteo:</label>&nbsp;&nbsp;</td><td>
                    <select name="conteo" id="conteo" class="lista" onchange="leerGrupo();">
                        <option value=""></option>
                        <option value="0">1</option>
                        <option value="1">2</option>
                        <option value="2">3</option>
                    </select><br /><br /></td></tr>
                    <tr style="height: 130px;"><td style="height: 50px;"><label class="e1">Grupo:</label>&nbsp;&nbsp;</td><td>
                    <input onkeyup="onKeyUp(event,this.name)" type="text" class="texto2" id="G1" name="G1" maxlength="12" autofocus="true" autocomplete="off" /></td></tr>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton1" name="Iniciar" id="Iniciar" value="INICIAR" onfocus="verificaGrupo('<? echo $sede; ?>');" onclick="verificaGrupo('<? echo $sede; ?>');" /></td></tr></table>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton3" name="Abandonar" id="Abandonar" value="CERRAR" onclick="cerrarFormulario1();" />&nbsp;&nbsp;&nbsp;
                    <?
                    
                    require_once('conexionFacturas.php');
                    //$resultusuY = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invAcceso] WHERE idUsu='$Us'", $cLink);
                    //SELECT IdFuncionario FROM [sqlFacturas].[dbo].[autFuncionario] where login ='RAMIREZD'
                    $resultusuY = mssql_query("SELECT IdFuncionario FROM [sqlFacturas].[dbo].[autFuncionario] where login ='$Us'", $cLinkf);
                    $fila = mssql_fetch_array($resultusuY);
                    $IdFunc=$fila['IdFuncionario'];
                    //***
                    require_once('conexioninventario80.php');
                    //echo "Yo:".$IdFunc;
                    //$resultusuY2 = mssql_query("SELECT IdFuncionario FROM [sqlFacturas].[dbo].[autFuncionario] where login ='$Us'", $cLink);
                    $resultusuY2 = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invAcceso] WHERE idUsu='$IdFunc'", $cLink);
                    $fila2 = mssql_fetch_array($resultusuY2);
                    $Acceso=$fila2['acceso2'];
                    mssql_close($resultusuY);
                    mssql_close($resultusuY2);
                    if($Acceso=="U1"){
                        $_SESSION['usuARioEntra']=1;
                    ?>
                    <input type="button" class="boton3" name="Ubicaciones" id="Ubicaciones" value="UBICA" onclick="Ubicaciones();" />
                    <?
                    }else{
                        $_SESSION['usuARioEntra']=0;
                    }
                    ?>
                    <!--<input type="checkbox" name="bloq" id="bloq" onclick="bloquearBoton(this.checked)" value="Bloquear" />Ocultar&nbsp;
                    <input type="text" id="pasw" value="Digite Clave" style="visibility: hidden;" />&nbsp;-->
                    &nbsp;&nbsp;<input type="button" id="adm" class="boton3alto" onclick="Administra();" value="ADMIN" />
                    <br /><br />
                    <div id="formularioadm" style="visibility: hidden;"><form name="admin" method="post" action="">
                        Usuario:&nbsp;<input type="text" id="Usuario" />&nbsp;Clave:&nbsp;<input type="password" id="Clave" />
                        &nbsp;&nbsp;<input type="button" id="enviaus" onclick="administrarAplicacion();" value="Ingresar" />
                    </form>
                    </div>
                    </td></tr></table>
                    </div>