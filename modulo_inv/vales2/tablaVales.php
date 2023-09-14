<?php
        $frm="";
        $frm=$frm."<table class='frm' width='100%' cellspacing='0' cellpadding='0' style='background-color: #E7E6E8;' >";
          $frm=$frm."<tr>";
            $frm=$frm."<td colspan='2' style='background-color: #E7E6E8;'>";
            $frm=$frm."<b>Nuevo Dto/Vale : </b>";
            $frm=$frm."<br/><br/>Descripci&oacute;n:<br/><br/>"; 
              $frm=$frm."<select class='frm select' onchange='agregarCuotas();' name='dtoN' id='dtoN' style='width:100%; border-color: gray' >";
              $frm=$frm."<option value='5% ALMACEN Y CALL-CAJAS'>5% ALMACEN Y CALL-CAJAS</option>";
              $frm=$frm."<option value='SERVICIO CELULAR'>SERVICIO CELULAR</option>";
              $frm=$frm."<option value='ROTURAS Y AVERIAS'>ROTURAS Y AVERIAS</option>";
              $frm=$frm."<option value='TIPICAS'>TIPICAS</option>";
              $frm=$frm."<option value='FALTANTES INVENTARIO CONCENT.'>FALTANTES INVENTARIO CONCENT.</option>";
              $frm=$frm."<option value='FONDO DE EMPLEADOS'>FONDO DE EMPLEADOS</option>";
              $frm=$frm."<option value='FUNDACION M.I.A'>FUNDACION M.I.A</option>";
              $frm=$frm."<option value='PONCHIS'>PONCHIS</option>";
              $frm=$frm."<option value='SANCION LINEA DIAMANTE-DELTA'>SANCION LINEA DIAMANTE-DELTA</option>";
              $frm=$frm."<option value='20 % -SEMANAS PROMOCIONALES'>20 % -SEMANAS PROMOCIONALES</option>";
              $frm=$frm."<option value='FALTANTES INVENTARIO MEDICAM.'>FALTANTES INVENTARIO MEDICAM.</option>";
              $frm=$frm."<option value='MENOR VR.COBRADO'>MENOR VR.COBRADO</option>";
              $frm=$frm."<option value='FALTANTES INVENTARIO FERRETR.'>FALTANTES INVENTARIO FERRETR.</option>";
              $frm=$frm."<option value='FLETES'>FLETES</option>";
              $frm=$frm."<option value='VALE TORNEO FIFA'>VALE TORNEO FIFA</option>";
              $frm=$frm."<option value='DESC.NOTAS CAPACITACION'>DESC.NOTAS CAPACITACION</option>";
              
              $frm=$frm."</select>";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          $frm=$frm."<tr>";
            $frm=$frm."<td width='30%' style='background-color: #E7E6E8;padding: 10px;' >Valor $</td>"; 
            $frm=$frm."<td width='70%' style='background-color: #E7E6E8;padding: 10px;' > <input class='frm' type='number' min='1' step='1' name='vlrdtoN' id='vlrdtoN' value='' style=' width:90%; height:28px; border-color:darkgray'>";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          $frm=$frm."<tr>";
            $frm=$frm."<td style='background-color: #E7E6E8; padding: 10px;' >Firma Vale</td>";
            $frm=$frm."<td style='background-color: #E7E6E8;' >"; 
                $frm=$frm."<select class='frm select' onchange='verificaPrefirmado(this.value);' name='firmavale' id='firmavale' style='width:90%; border-color:red;' >";
                       
                $frm=$frm."</select>";
           $frm=$frm."</td>";
          $frm=$frm."</tr>";
          $frm=$frm."<tr>";
            $frm=$frm."<td width='30%' style='background-color: #E7E6E8; padding: 10px;' >";
                $frm=$frm."<div id='msg1'>";
                
                $frm=$frm."</div>";
            $frm=$frm."</td>"; 
            $frm=$frm."<td width='70%' style='background-color: #E7E6E8; padding: 10px;' >"; 
                $frm=$frm."<div id='numvale'>";
                
                $frm=$frm."</div>";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          $frm=$frm."<tr>";
            $frm=$frm."<td colspan='2' style='background-color: #E7E6E8;'>";
            $frm=$frm."Observaciones";
            $frm=$frm."<br /><br />";
            $frm=$frm."<textarea id='obs' name='obs' rows='3' style='width:100%'></textarea>";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          $frm=$frm."<tr>";
            $frm=$frm."<td style='height: 20px; text-align: center;background-color: #E7E6E8; padding: 20px;' colspan='2' >";
              $frm=$frm."<input type='button' onclick='guardarVale();' class='boton4' id='Guardarv' value='Guardar' />";
              
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
        $frm=$frm."</table>";
        
        echo $frm;
        ?>