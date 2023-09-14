<?php
// echo "incluye IBS";
/* ICA - IVA - RTFTE */
$query_certificado = ("select * from AGR620CFAG.SROPST where SROPST.PSPERI >= ".str_replace('-','',substr($fec_desde,0,7))." and SROPST.PSPERI <= ".str_replace('-','',substr($fec_hasta,0,7))." and SROPST.PSDIM1 Like '2365%' and PSUNM1='$nit'");
// $query_certificado = ("select * from AGR620CFAG.SROPST where SROPST.PSPERI >= ".str_replace('-','',substr($fec_desde,0,7))." and SROPST.PSPERI <= ".str_replace('-','',substr($fec_hasta,0,7))." and SROPST.PSDIM1 Like '2365%' and PSUNM1='$nit'");
// $datos_cert_ibs = $con_ibs->conectar($query_certificado);
// $find_count_puc = [];

// while( $row = odbc_fetch_array( $datos_cert_ibs ) ) {
//     echo $row['PSDIM1']."<br>";
// }

// /* ICA - IVA - RTFTE */

?>