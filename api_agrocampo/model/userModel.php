<?php
// require_once PROJECT_ROOT_PATH . "/model/database.php";
require_once "database.php";
 
class UserModel extends Database
{
    public function getUsers($limit)
    {
        // return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
        return $this->select("SELECT NSCAEC AS PRODUCTO,NSCASI AS CATALOGO,SRSTHQ AS INVENTARIOFISICO,PGPGRP AS GRUPOPRODUCTO, CAST(PGLPCO*(100/(100-PSMMVA)) AS INT) AS PRECIO FROM NSOPCAST left outer join SRBSRO on NSOPCAST.NSCAEC = SRBSRO.SRPRDC left outer join SRBPRG on NSOPCAST.NSCAEC = SRBPRG.PGPRDC left outer join SRBPRS on NSOPCAST.NSCAEC = SRBPRS.PSPRDC where NSCASI Like 'YATI%' and SRBSRO.SRSROM = '005' and SRBPRS.PSPRIL='LIS01' and SRBPRS.PSUNIT='UN' AND SRBPRG.PGSTAT <>'D' LIMIT ?", ["i", $limit]);
    }
}

?>


<!-- $sql_ibs = ("SELECT UPUSER, UPDESC, UPHAND, UPEQGR, UPNEOP from AGR620CFAG.SRBUSP  AS TBL_1 INNER JOIN DIAZH.USR_LIST AS TBL_2 ON TBL_1.UPUSER = TBL_2.USER_NAME" ); -->