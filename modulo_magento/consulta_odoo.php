<?php
require '../nuevo_sia_v2/conection/conexion_pssql.php';
$conn_pssql = new con_pssql('agrocampo');

$sql_pssql = ("
select
	pt.magento_sku 	as sku,
	( coalesce (ppi.precio_lista  ,0) + round(cast(coalesce (ppi.precio_lista  ,0) * ((float4(case when lower(right(substring(trim(pc.name),0,9),3)) ~ '^[^a-z]+$' then float4(lower(right(substring(trim(pc.name),0,9),3))) else  '00'  END)/100) ) as decimal),3)) as  price,
	max(case when sq.qty = 0 then 0 else 1 end ) status,
	sum(sq.qty) as qty,
	max(case when sq.qty <= 5 then 0 else 1 end ) is_in_stock
from 
	stock_quant sq 
	join product_product pp    		on pp .id = sq.product_id 
	join stock_location sl     		on sl.id = sq.location_id 
	join product_template pt   		on pt.id = pp.product_tmpl_id
	join product_list_item pli 		on pli.product_id  = pp.id
	join product_pricelist_item ppi	on pp.id = ppi.product_id 
	left join product_category pc   on pc.id = pt.categ_id 
where 
	pp.active = true
	and pt.magento_published = true
	and substring(trim(sl.complete_name),0,4) = '005'
	and sq.qty > 0
	and (pp.name_template not ilike'% combo %' or pp.name_template not like'KIT %' or  pp.name_template not like'% MAXIKIT %')
	and sq.reservation_id is null
group by 
	pt.magento_sku 
	,ppi.precio_lista 
	,pp.name_template 
	,pp.default_code 
	,pt.description
	,pc.name
order by 
	pp.name_template 
	,pp.default_code
");
//  $result = $conn_pssql->conectar($sql_pssql);
// var_export(pg_fetch_all($result));
?>
