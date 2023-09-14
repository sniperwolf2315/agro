<?

if($_POST['completoPROD'] == 'SI'){
  
  //bora dactos existentes
  mysqli_query($mysqli,"DELETE FROM prov_eventos_art WHERE id_eventos = '$_POST[maxId]' ");
  // guarda datos del formulario  
  for($i = 0; $i <= $_POST['prods']; $i++){
    if($_POST["art$i"] != ''){
      $grabe ++; 
      $prods = explode("|", $_POST["prod$i"]);
      $sql = "INSERT INTO prov_eventos_art (id_eventos, CODIGO, NOMBRE, COSTO, MADRE) VALUES ( '$_POST[maxId]', '$prods[0]', '$prods[1]', '$prods[2]', '$prods[3]');";
      mysqli_query($mysqli,$sql) or die('insert '.$i);
    }
  }
  if($grabe > 0){
    echo '<script>alert(" ***** \n '.$grabe.' Productos \n Guardados \n con Exito! \n *******")</script>';
    //die;
  }else{
    echo '<script>alert(" ***** \n *Atencion! \n Seleccione al menos \n 1 producto para guardar \n *******")</script>';
  }
}
$sql = "";
 
$sql ="SELECT EVENTO, DESDE, HASTA, CODIGOS_DE_DESCUENTO
       FROM prov_eventos WHERE 
       prov_eventos.id = '$_POST[maxId]'
      ";

$result = mysqli_query($mysqli, utf8_decode($sql)) or die('atr1 '.mysqli_error($mysqli));
while($row = mysqli_fetch_assoc($result)){
  foreach($row AS $tiDet => $valorDet){
    $titDet["$tiDet"] = $valorDet;
    }
  }

//filtro de palabras
if($_POST['fprod'] !=''){
 $fprodARR = explode(" ",strtoupper($_POST['fprod']));
 $coma ='';
 foreach($fprodARR AS $valor){
   $fprod .= " $coma SRBPRG.PGDESC LIKE '%$valor%' ";  
   $coma ='AND';
 }
 $coma ='';
  //$fprod =" AND ( $fprod ) ";

  $fprodcods = str_replace(' ',"','",str_replace(',',' ',$_POST['fprod']));
  $fprod =" AND (( $fprod ) OR SRBPRG.PGPRDC in ('$fprodcods') ) ";
}


//en edicion busca productos guardados
$sql ="SELECT CODIGO, NOMBRE, MADRE, COSTO FROM prov_eventos_art WHERE id_eventos = '$_POST[maxId]' ";
$result = mysqli_query($mysqli, $sql);
while($row = mysqli_fetch_assoc($result)){
  $nombre = $row['NOMBRE'];
  $itemGuardado["$nombre"] = $row['MADRE']; 
  
  $prod[] = trim($row[CODIGO])."|".trim($row[NOMBRE])."|".trim($row[COSTO]);
  $prodList[] = $row[NOMBRE];
}
//echo $sql;

// busca productos IBS 

$titDet[GRUPO] = str_replace(",","','",$titDet[GRUPO]);
$sql ="SELECT
        trim(SRBPRG.PGPRDC) AS ITEM
        ,trim(SRBPRG.PGDESC) AS DESCRIPCION
        ,SRBPRG.PGPLAN AS RESPONSABLE_ITEM
        ,SRBPRG.PGPGRP AS GRUPO
        ,SRBPRG.PGLPCO AS COSTO
        , (SELECT COUNT(*) FROM SRBOST WHERE SQPRDC =SRBPRG.PGPRDC  ) AS HIJOS   
       FROM AGR620CFAG.SROPRG SRBPRG
       WHERE SRBPRG.PGSTAT != 'AD'
       
       $fprod
       ORDER BY SRBPRG.PGDESC 
      ";
//echo "--- $sql   ----";  //AND SRBPRG.PGPGRP IN ('$titDet[GRUPO]')    
if($_POST[fprod]!=''){
$result = odbc_exec($db2conp, $sql);
}
  while($row = odbc_fetch_array($result)){
  $prod[] = trim($row[ITEM])."|".trim(utf8_encode($row[DESCRIPCION]))."|".trim($row[COSTO]);
  $prodList[] = utf8_encode($row[DESCRIPCION]);
  /*
  $hijos[] = $row[HIJOS]; 
  if($row['HIJOS'] > 0){  
    $sql2 = "SELECT 
               trim(SRBOST.SQCMPC) AS ITEM_HIJOS
               ,trim(SRBPRG_1.PGDESC) AS DESCR_HIJOS
               ,SRBPRG.PGPLAN AS RESPONSABLE_HIJO
               ,SRBPRG_1.PGPGRP AS GRUPO_HIJOS
               ,SRBPRG_1.PGLPCO AS COSTO_HIJOS
               ,TRIM(SQPRDC)||'-'||TRIM(SRBPRG.PGDESC) AS DESCR_MADRE  
             FROM  SRBOST
             LEFT JOIN SRBPRG ON SRBOST.SQPRDC = SRBPRG.PGPRDC 
             LEFT JOIN SRBPRG AS SRBPRG_1 ON SRBOST.SQCMPC =SRBPRG_1.PGPRDC
             WHERE 
               SQPRDC = '$row[ITEM]'
               AND SRBPRG.PGSTAT != 'AD' 
            ";
     $result2 = odbc_exec($db2conp, $sql2);      
       while($row2 = odbc_fetch_array($result2)){
       $itemH = utf8_encode($row[DESCRIPCION]);
       $hijo["$itemH"][] = trim($row2[ITEM_HIJOS])."|".trim(utf8_encode($row2[DESCR_HIJOS]))."|".trim($row2[COSTO_HIJOS])."|".trim(utf8_encode($row2[DESCR_MADRE]));
       $hijoList["$itemH"][] = utf8_encode($row2[DESCR_HIJOS]);
       } 
    }
    */
  }
//print_r($hijo);
$cols ='2';
?>
<center>
<input type="hidden" name="guardo" id="guardo" value="<?= $_POST['guardo']?>">
<input type="hidden" name="maxId" id="maxId" value="<?= $_POST['maxId']?>">
<input type="hidden" name="completo" id="completo" value="NO">
<table border="1" class="frr" width="99%">
  <tr>
    <td align="center" colspan="<?= $cols?>">
      <b>Productos Asociados</b>
      <br>
      <? echo " Evento: <b>$titDet[EVENTO]</b>. Desde: <b>$titDet[DESDE]</b>. Hasta: <b>$titDet[HASTA]</b>. Cods Descuento: <b>$titDet[CODIGOS_DE_DESCUENTO]</b> - "; ?>  
      <br>
      <?
      if(count($itemGuardado) > 0 and 'lino' == 'andres'){
      echo "<font color='crimson'>Editando</font>";
      }else{
      ?>
        <b><u>Buscar Codigos o por Nombre:</u><b>
 <!--       <input onchange="this.form.submit();" type="text" class="frr campo" id="fprod" name="fprod" value="<?= $_POST[fprod]?>" style="width:33%; background-color:<? if($_POST['fprod']!=''){echo "PINK";} ?>">
-->
        <br><textarea onchange="this.form.submit();" type="text" class="frr Acampo" id="fprod" name="fprod" style="width:66%; background-color:<? if($_POST['fprod']!=''){echo "PINK";} ?>" rows='4'><?= $_POST[fprod]?></textarea>

        <input type="button" class="frr" value=" Ok " style="width:auto" >
      <?
      }
      ?>    
    </td>
  </tr>
  <tr>
    <td align="left" colspan="<?= $cols?>">
      <input onchange="this.form.submit();" class='frr' type='checkbox' id='todo' name='todo' value='TODO'> Seleccionar todo
      &nbsp;&nbsp;&nbsp;&nbsp;
      <input onchange="this.form.submit();" class='frr' type='checkbox' id='notodo' name='notodo' value='NOTODO'> Borrar Selecciones
    </td>
  </tr>
  <tr valign='top'>
  <?
  $contAr = -1;
  $contAr2 = -1;
  $contCol= 0;
  foreach($prodList AS $valor){
  $contAr += 1;
  $contCol += 1;
  /*
  if(($_POST["art$contAr"] != '' OR $_POST['todo'] =='TODO') AND $_POST['notodo'] =='' ){
    $checkedART ='checked';
  }else{
    $checkedART ='';
  }
  */
  
  $ancho = 100/$cols;
  if($hijos["$contAr"] > 0){
       
    echo "<td class='campo' style='width:".$ancho."%'>";
    $contHI = 0;
    echo "<b>$valor</b>"; 
    foreach($hijoList["$valor"] AS $child){
    $contAr2 += 1;
    
    //en edicion chequea los ya guardados
    if(array_key_exists($child,$itemGuardado) AND $itemGuardado["$child"] != '' ){
      $_POST["art$contAr2"] ='si';
      }
    
    //chequeados o no
    if(($_POST["art$contAr2"] != '' OR $_POST['todo'] =='TODO') AND $_POST['notodo'] =='' ){
        $checkedART ='checked';
        $colorMarcado ="style='background-color:lime'";
      }else{
        $checkedART ='';
        $colorMarcado ='';
      }
    echo "
          <br>
          <input type='hidden' id='prod$contAr2' name='prod$contAr2' value='".$hijo["$valor"]["$contHI"]."'>
          --h-- <input $checkedART class='frr' type='checkbox' id='art$contAr2' name='art$contAr2' value='$contAr2' tittle='".$titArt[ITEM][$contAr]."'>
          <font $colorMarcado color='navy'>$child</font>
          ";
      $contHI ++;  
      }
   echo "</td>";
  }else{
  $contAr2 += 1;
  
  //en edicion chequea los ya guardados
    if(array_key_exists($valor, $itemGuardado) AND $itemGuardado["$valor"] == '' ){
      $_POST["art$contAr2"] ='si';
      }

  if(($_POST["art$contAr2"] != '' OR $_POST['todo'] =='TODO') AND $_POST['notodo'] =='' ){
        $checkedART ='checked';
        $colorMarcado ="style='background-color:lime'";
      }else{
        $checkedART ='';
        $colorMarcado ='';
      }

  echo "<td class='campo' style='width:".$ancho."%'>
          <input type='hidden' id='prod$contAr2' name='prod$contAr2' value='".$prod["$contAr"]."'>
          <input $checkedART class='frr' type='checkbox' id='art$contAr2' name='art$contAr2' value='$contAr2' tittle='".$titArt[ITEM][$contAr]."'>
          - <font $colorMarcado>$valor</font>
        </td>
       "; 
  }
  
  if($contCol == $cols){
    echo "</tr><tr valign='top'>";
    $contCol = 0;
    }     
  }
  if($contCol != 0){
   for($i = $contCol; $i < $cols; $i++ ){
     echo "<td class='campo'></td>";
   }
  }
  echo "</tr>";
  ?>
  <tr>
    <td align="CENTER" colspan="<?= $cols?>">
        <input type="HIDDEN" name="prods" id="prods" value="<?= $contAr2?>">
        <br>
        <br>
        Datos completos:<input type="checkbox" name="completoPROD" id="completoPROD" value="SI">
		<br>
		<br>
		<input onclick="this.form.submit()" type="button" value=" Guardar Productos ">
		<br>
		<br>
    </td>
  </tr>
</table>
</center>
