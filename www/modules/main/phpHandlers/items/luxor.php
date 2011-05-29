<?php
$sql->saveRows("
	SELECT 
		Z.item_id,Z.icon,Z.name,
		Z.rcp_flag,Z.drp_flag,Z.sll_flag,
		L.d_count,L.c_count,Z.gtype
	FROM l2jz_luxor AS L
	INNER JOIN l2jz_items AS Z ON (L.item_id=Z.item_id)
	ORDER BY Z.gtype
");
?>