<?php
// echo'QUERY IBS<br>';

include('wsintegracion.php');

if(substr($token_var,0,3)=='PET'){
    $empresa='PET';
}else if(substr($token_var,0,3)=='YAT'){
    $empresa='YATI';
}


$query_ibs_inv = ( "SELECT
NSCAEC AS PRODUCTO,
NSCASI AS CATALOGO,
SRSTHQ AS INVENTARIOFISICO,
PGPGRP AS GRUPOPRODUCTO,
CAST(PGLPCO*(100/(100-PSMMVA)) AS INT) AS PRECIO,
PJEANP as CODIGOEAN
FROM 
NSOPCAST 
left outer join SRBSRO on NSOPCAST.NSCAEC = SRBSRO.SRPRDC 
left outer join SRBPRG on NSOPCAST.NSCAEC = SRBPRG.PGPRDC 
left outer join SRBPRS on NSOPCAST.NSCAEC = SRBPRS.PSPRDC 
left outer join SROEAN  on SROEAN.PJPRDC = NSOPCAST.NSCAEC 
WHERE 
NSCASI Like '$empresa%' 
and SRBSRO.SRSROM = '005' 
and SRBPRS.PSPRIL='LIS01' 
and SRBPRS.PSUNIT='UN' 
AND SRBPRG.PGSTAT <>'D'
and SRSTHQ>=5
" );

$query_ibs_40 = ( "SELECT                                              
NSCAEC AS PRODUCTO,                                 
NSCASI AS CATALOGO,                                 
 SR3DID.DDCDMC AS METODO,                            
SR3DID.DDDIS1 AS DESCUENTO                          
FROM NSOPCAST                                       
INNER JOIN SR3DID on NSOPCAST.NSCAEC = SR3DID.DDDMK2
INNER JOIN SRBPRG on NSOPCAST.NSCAEC = SRBPRG.PGPRDC
where NSCASI Like '$empresa%'                           
and SR3DID.DDCDMC = 'MET40'                         
and SR3DID.DDDMK1 = '901333960'                     
AND SRBPRG.PGSTAT <>'D'
" );

$query_ibs_42 = ( "SELECT                                                      
DISTINCT(NSCAEC) AS PRODUCTO,                              
NSCASI AS CATOLOGO,                                        
SRBDID.DDCDMC AS METODO,                                   
SRBDID.DDDIS1 AS DESCUENTO,                                
PGPGRP AS GRUPO                                            
from                                                        
NSOPCAST                                                   
left outer join SR3DID on NSOPCAST.NSCAEC = SR3DID.DDDMK2  
left outer join SRBPRG on NSOPCAST.NSCAEC = SRBPRG.PGPRDC  
left outer join SRBDID on SRBPRG.PGPGRP = SRBDID.DDDMK2    
where                                                       
NSCASI Like '$empresa%'                                        
and SRBDID.DDCDMC = 'MET42'                                
and SRBDID.DDDMK1 = '901333960'                            
AND SRBPRG.PGSTAT <>'D'
" );

?>