<?php
$frm="";
        $frm=$frm."<table class='frm' width='100%' cellspacing='0' cellpadding='0' style='background-color: #E7E6E8;' >";
          $frm=$frm."<tr>";
            $frm=$frm."<td colspan='2' style='background-color: #E7E6E8;'>";
            $frm=$frm."<b>Nuevo Usuario : </b>";
            $frm=$frm."<br/><br/>"; 
                          
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          
          $frm=$frm."<tr>";
            $frm=$frm."<td width='30%' style='background-color: #E7E6E8;padding: 10px;' >empresa:</td>"; 
            $frm=$frm."<td width='70%' style='background-color: #E7E6E8;padding: 10px;' >";
            $frm=$frm."<select class=\"frm select\" name=\"emp\" id=\"emp\" style=\"width:100%; border-color: gray\" >";
                $frm=$frm."<option value='AGROCAMPO'>AGROCAMPO</option>";
                $frm=$frm."<option value='COMERVET'>COMERVET</option>";
                $frm=$frm."<option value='PESTAR'>PESTAR</option>";
              $frm=$frm."</select>";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          
          $frm=$frm."<tr>";
            $frm=$frm."<td width='30%' style='background-color: #E7E6E8;padding: 10px;' >Area:</td>"; 
            $frm=$frm."<td width='70%' style='background-color: #E7E6E8;padding: 10px;' > <input type='text' id='Are' >";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          
          $frm=$frm."<tr>";
            $frm=$frm."<td width='30%' style='background-color: #E7E6E8;padding: 10px;' >Documento:</td>"; 
            $frm=$frm."<td width='70%' style='background-color: #E7E6E8;padding: 10px;' > <input type='text' onkeyUp='return ValNumero(this);' maxlength='12' id='doc' >";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          
          $frm=$frm."<tr>";
            $frm=$frm."<td width='30%' style='background-color: #E7E6E8;padding: 10px;' >Nombres:</td>"; 
            $frm=$frm."<td width='70%' style='background-color: #E7E6E8;padding: 10px;' > <input type='text' id='Nom' >";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
          
          $frm=$frm."<tr>";
            $frm=$frm."<td width='30%' style='background-color: #E7E6E8;padding: 10px;' >Apellidos:</td>"; 
            $frm=$frm."<td width='70%' style='background-color: #E7E6E8;padding: 10px;' > <input type='text' id='Ape' >";
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
                   
          $frm=$frm."<tr>";
            $frm=$frm."<td style='height: 20px; text-align: center;background-color: #E7E6E8; padding: 20px;' colspan='2' >";
              $frm=$frm."<input type='button' onclick='guardarUsuario();' class='boton4' id='Guardaru' value='Guardar' />";
              
            $frm=$frm."</td>";
          $frm=$frm."</tr>";
        $frm=$frm."</table>";
        
        echo $frm;
?>