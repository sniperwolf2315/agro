<?php
include_once( '../../conectarbaseprodmes.php' );
include( '../../general_funciones.php' );

$lista_area = $_GET[ 'area' ];
$vendedor   = $_GET[ 'vendedores' ];
$nivel      = $_GET[ 'nivel' ];

if ( $nivel === '3' ) {
    $where_add = "and codigo ='".strtoupper( $vendedor )."'";
} else {
    $where_add = '';
}

switch ( $lista_area ) {
    case 'VENTA_EXTERNA':
    $lista_area = 'VENTA EXTERNA';
    break;
}

if ( $lista_area === 'selected' || $lista_area === '' || $lista_area === 'Todos' ) {
    $vendedores = mssql_query( '
        select 
            codigo,Nombres,Apellidos as nombre 
        from 
            CLIVENDEDOR 
        WHERE 
            SECTORLAB IS NOT NULL 
            AND Activo=1 
            '.$where_add .' ;' );

} else if ( $lista_area === 'TELEOPERADOR' ) {

    $vendedores = mssql_query( "
    select  
    codigo, 
    nombres +' '+Apellidos as nombre ,
    sectorlab from CLIVENDEDOR 
    where 
    Codigo  in  ( select  distinct (CODVENDEDOR) from [FACINFCUOTAVENTA] fcv2)
    and Activo =1
    and sectorlab IN('$lista_area','OTROS2')
    ". $where_add."
    order by 
    Codigo,SectorLab
    " );




}else if($lista_area === 'VENTA EXTERNA'){
    $vendedores = mssql_query( "
    select  
    codigo, 
    nombres +' '+Apellidos as nombre ,
    sectorlab from CLIVENDEDOR 
    where 
    Codigo  in  ( select  distinct (CODVENDEDOR) from [FACINFCUOTAVENTA] fcv2)
    and Activo =1
    and sectorlab IN('$lista_area')
    ". $where_add."
    order by 
    Codigo,SectorLab
    " );


} else if ( $lista_area === 'ALMACEN' ) {
        
    $vendedores = mssql_query( "
        select  
            codigo, 
            nombres +' '+Apellidos as nombre ,
            sectorlab from CLIVENDEDOR 
        where 
            Codigo  in  ( select  distinct (CODVENDEDOR) from [FACINFCUOTAVENTA] fcv2)
        and Activo =1
        and sectorlab not in( 'TELEOPERADOR','VENTA EXTERNA','')
        and Codigo not in ('VEND618','VEND157')
        ". $where_add ."
        order by 
            Codigo,SectorLab
    " );
}

echo '
<select  id="vendedores" name="vendedores" class="frm campo"  required>
';

if ( $nivel != 3 ) {
    echo '<option value="Todos" >Todos</option>';
} 

while ( $vend = mssql_fetch_array( $vendedores ) ) {
    echo '<option  value="' . $vend[ 0 ] . '">-✔ ' . $vend[ 0 ] . '  ' . remove_characters( $vend[ 1 ] ) . ' ' . $vend[ 2 ] . '</option>';
}
echo '
</select>

';


?>