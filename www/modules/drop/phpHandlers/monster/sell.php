<?php
$sql->saveRows("
	SELECT 
		S.item_id,Z.icon,Z.name,Z.description,Z.crystal_type,Z.crystal_count,
		Z.type,Z.gtype,S.price,Z.drp_flag,Z.rcp_flag,Z.sll_flag
	FROM l2jz_shops AS S
	LEFT OUTER JOIN l2jz_items AS Z ON (Z.item_id = S.item_id)
	WHERE S.mob_id='".$id."' ORDER BY Z.crystal_type,type,S.price
");
?>