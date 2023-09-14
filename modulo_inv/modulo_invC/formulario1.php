                    <label class="e1">INVENTARIO<br /> Sede:<span style="color: #1636EE;"> <? echo $sede; ?></span></label><br /><br />
                    <table class="tabla" style="border:1px solid #000000;">
                    <?
                    if ($sede=='Portos'){
                    ?>
                    <tr style="height: 130px;"><td style="width: 60%; height: 80px; vertical-align: top"><br /><label class="e1" id="lblv">Solicitar Vencimiento:</label>&nbsp;&nbsp;</td><td style="vertical-align: top"><br /><input type="checkbox" class="check" name="venc" id="venc" /><br /><br /><br /></td></tr>
                    <?
                    }
                    ?>
                    <tr style="height: 130px;"><td style="height: 50px;"><label class="e1">Seleccione conteo:</label>&nbsp;&nbsp;</td><td>
                    <select name="conteo" id="conteo" class="lista" onchange="leerGrupo();">
                        <option value=""></option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select><br /><br /></td></tr>
                    <tr style="height: 130px;"><td style="height: 50px;"><label class="e1">Grupo:</label>&nbsp;&nbsp;</td><td>
                    <input onkeyup="onKeyUp(event,this.name)" type="text" class="texto2" id="G1" name="G1" maxlength="12" autofocus="true" autocomplete="off" /></td></tr>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton1" name="Iniciar" id="Iniciar" value="INICIAR" onfocus="verificaGrupo('<? echo $sede; ?>');" onclick="verificaGrupo('<? echo $sede; ?>');" /></td></tr></table>
                    <tr style="height: 130px;"><td style="height: 50px;"></td><td><br /><input type="button" class="boton3" name="Abandonar" id="Abandonar" value="CERRAR" onclick="cerrarAplicacion();" /></td></tr></table>
                    