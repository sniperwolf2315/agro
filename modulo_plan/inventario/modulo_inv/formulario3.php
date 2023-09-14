                    <center><label class="e1">INVENTARIO Sede:<span style="color: #1636EE;"> <? echo $sede; ?></span></label></center><br /><input type="button" class="boton4" name="Cambiar" value="LEER CODIGO" onclick="leernewItem();" />&nbsp;&nbsp;&nbsp;&nbsp;<label class="e1">Conteo: <span style="color: red;"><? echo $conteo; ?></span></label><br />
                    <input onblur="onKeyUp(event,this.name)" type="text" class="texto1" id="T1" name="T1" maxlength="30" autofocus="true" autocomplete="off" /><input type="button" class="boton2" name="D" value="D" onclick="onKeyUp(event,this.name)" /><br /><br />
                    <label class="e1">Descripci&oacute;n:</label>&nbsp;&nbsp;&nbsp;
                    &nbsp;<textarea id="T2" name="T2" class="area" readonly="true"></textarea><br /><br />
                    <!--<input type="text" class="texto2" id="T2" name="T2" style="width: 200px;" readonly="true" /><br /><br />-->
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="boton2" name="Suma" value="S" onclick="agregaLetra(this.value);" />&nbsp;
                    <input type="button" class="boton2" name="Resta" value="R" onclick="agregaLetra(this.value);" />&nbsp;&nbsp;
                    <input type="text" class="texto1" id="T3" name="T3" readonly="true" style="width: 50px; text-align: center;" />
                    <input onkeyup="onKeyUp(event,this.name)" type="number" class="texto1" id="T4" name="T4" onkeyUp="return ValNumero(this);" maxlength="4" style="width: 20%;" autocomplete="off" /><br /><br />
                    
                    
                    <!--'<input type="text" class="texto1" id="bodega" name="bodega" readonly="true" style="width: 100px;" />-->
                    <label class="e1" style="visibility: visible;">Fecha Vencimiento</label><br /><hr /><br />
                    <label class="e1" style="visibility: visible;">A&ntilde;o: </label>&nbsp;
                    <select name="fva" id="fva" style="visibility: visible;" class="texto3" onchange="leerLote();"><option value=""></option><? $i=$anio;while($i<$aniofin){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select>&nbsp;&nbsp;
                    <label class="e1" style="visibility: visible;">Mes: </label>&nbsp;
                    <select name="fvm" id="fvm" style="visibility: visible;" class="texto4" onchange="leerLote();"><option value=""></option><? $i=1;while($i<13){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select><br /><br /><br />
                    <!--<input type="number" class="texto1" id="fv" name="fv" style="width: 300px;visibility: visible;" /><br /><br />-->
                    <label class="e1" style="visibility: visible;">Lote: </label>&nbsp;
                    <input type="text" class="texto2" id="lot" name="lot" maxlength="15" style="width: 300px;visibility: visible;" />&nbsp;&nbsp;&nbsp;
                    <input type="button" class="boton4" name="Registrar" value="GUARDAR" onclick="registrarDatos();" /><br /><br /><br /><hr /><br /><br />
                    <input type="button" class="boton4" name="Salir" value="<< INICIO" onclick="cerrarSession();" />
                    <input type="text" class="texto1" id="conteo" name="conteo" value="<? echo $conteo; ?>" readonly="true" style="width: 30px;visibility: hidden;" />
                    <input type="text" class="texto1" id="ubicag" name="ubicag" value="<? echo $ubicag; ?>" readonly="true" style="width: 30px;visibility: hidden;" />
                    <input type="text" class="texto1" id="item" name="item" readonly="true" style="width: 30px;visibility: hidden;" />&nbsp;&nbsp;
                    <input type="button" class="boton3" name="Abandonar" id="Abandonar" value="CERRAR" onclick="cerrarAplicacion();" />
                    <!--onkeyup="onKeyUp(event,this.name)"-->