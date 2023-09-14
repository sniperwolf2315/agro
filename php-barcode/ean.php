<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="ofi/antenna.css" id="css" />

<title>Untitled 1</title>
</head>

<body>

<?php
$ref ='18090553';
$talla ='8';
$color = substr('negro corazo',0,10);
$codcolor ='1285';
$ean = '7701829500407';
$precio = number_format('47900',0,',','.');

?>
<table width="377px"  class="frs" border="0" cellspacing="0">
<? $contF ='';
while($contF < 3 ){ $contF +=1; ?>
<tr>
<? $contC ='';
while($contC < 3 ){ $contC +=1; ?>
<td align="center" valign="top" height="95" nowrap>
<?=$ref?> T<?=$talla?><br/>
<?=$codcolor?> <?=$color?><br/>
<img border="0" width="100px" src='php-barcode/php/sample php/sample-gd.php?width=10&height=4&barcode=<?=$ean?>' rotate='90'  /><br/>
<?=$ean?><br/>
$ <?=$precio?>
</td>
<? } ?>
</tr>
<? } ?>
</table>
</body>

</html>

