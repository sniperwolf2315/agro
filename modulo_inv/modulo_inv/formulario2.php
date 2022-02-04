                    <?php
                    $grpub=$_SESSION['Ubicag'];
                    ?>
                    <img src="img/logoAG.png" width="50px" height="60px" />&nbsp;
                    <label class="e1">INVENTARIO AGROCAMPO<br /> Sede:<span style="color: #1636EE;"> <? echo $sede; ?></span></label></center><br /><br /><input type="button" class="boton4" name="Cambiar" value="CODIGO" onclick="leernewItem();" />&nbsp;&nbsp;&nbsp;&nbsp;<label class="e1">Conteo:<span style="color: red;"> <? echo $conteo+1; ?></span></label><br /><label class="e1">Ubicacion: <span style="color: red;"> <? echo $grpub; ?></span></label><br />
                    <input  type="text" onblur="onKeyUp(event,this.name)" class="texto1" id="T1" name="T1" maxlength="30" autofocus="true" autocomplete="off" />&nbsp;<input type="button" class="boton2" name="D" value="B" onclick="onKeyUp(event,this.name)" /><br /><br />
                    <label class="e1">Descripci&oacute;n:</label>&nbsp;&nbsp;&nbsp;
                    &nbsp;<textarea id="T2" name="T2" class="area" readonly="true"></textarea><br /><br />
                    <label id="tbus" class="e1">Producto a buscar:</label><input type="text" class="texto1" id="Bdesc" name="Bdesc" style="width: 350px; text-align: left;" />
                    <input type="button" class="boton2" name="Buscades" value="B" onclick="consultarDatosNombre();" /><br /><br />
                    <!--<input type="text" class="texto2" id="T2" name="T2" style="width: 200px;" readonly="true" /><br /><br />-->
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="boton2" name="Suma" value="S" onclick="agregaLetra(this.value);" />&nbsp;
                    <input type="button" class="boton2" name="Resta" value="R" onclick="agregaLetra(this.value);" />&nbsp;&nbsp;
                    <input type="text" class="texto1" id="T3" name="T3" readonly="true" style="width: 50px; text-align: center;" />
                    <input onblur="onKeyUp(event,this.name)" type="number" class="texto1" id="T4" name="T4" onkeyUp="return ValNumero(this);" maxlength="4" style="width: 30%;" autocomplete="off" /><br /><br />
                    
                    
                    <!--<input type="text" class="texto1" id="bodega" name="bodega" readonly="true" style="width: 100px;" />-->
                    
                    <input type="text" class="texto1" value="0" id="lot" name="lot" maxlength="15" style="visibility: hidden;" /><br /><br />
                    <center><input type="button" class="boton4" id="Registrarfrm" name="Registrar" value="GUARDAR" onclick="registrarDatos();" /></center><br /><hr /><br /><br />
                    <input type="button" class="boton4" name="Salir" value="INICIO" onclick="cerrarSession();" />&nbsp;&nbsp;
                    <input type="button" class="boton3" name="Abandonar" id="Abandonar" value="SALIR" onclick="cerrarAplicacion();" />
                    <input type="button" class="boton3" name="Abandonar" id="Abandonar" value="VOLVER" onclick="volverAplicacion();" />
                    <input type="text" class="texto1" id="conteo" name="conteo" value="<? echo $conteo; ?>" readonly="true" style="width: 30px;visibility: hidden;" />
                    <input type="text" class="texto1" id="ubicag" name="ubicag" value="<? echo $ubicag; ?>" readonly="true" style="width: 30px;visibility: hidden;" />
                    <input type="text" class="texto1" id="item" name="item" readonly="true" style="width: 30px;visibility: hidden;" /><br />
                    
                    <label class="e1" style="visibility: hidden;">Fecha Vencimiento</label><br /><br />
                    <label class="e1" style="visibility: hidden;">A&ntilde;o: </label>&nbsp;
                    <select name="fva" id="fva" style="visibility: hidden;" class="texto3"><option value=""></option><? $i=$anio;while($i<$aniofin){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select>&nbsp;&nbsp;
                    <label class="e1" style="visibility: hidden;">Mes: </label>&nbsp;
                    <select name="fvm" id="fvm" style="visibility: hidden;" class="texto4"><option value=""></option><? $i=1;while($i<13){echo '<option value='.$i.'>'.$i.'</option>';$i=$i+1;} ?></select><br /><br />
                    <!--<input type="number" class="texto1" value="0" id="fv" name="fv" style="width: 300px;visibility: hidden;" /><br /><br />-->
                    <label class="e1" style="visibility: hidden;">Lote: </label>&nbsp;
                    
                     
                    <!--onkeyup="onKeyUp(event,this.name)"-->