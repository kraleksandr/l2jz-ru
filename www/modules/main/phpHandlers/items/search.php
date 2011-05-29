<?php
$sql->saveRows("
	SELECT 
		Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,Z.crystal_type,Z.crystal_count,
		Z.type,Z.gtype,Z.rcp_flag,Z.drp_flag,Z.sll_flag,Z.weight,Z.price
	FROM l2jz_items as Z
	WHERE Z.item_id='".$id."' OR Z.name LIKE '%".$id."%'
	ORDER BY Z.crystal_type,Z.name
");
?>