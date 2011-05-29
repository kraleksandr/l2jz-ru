<?php
$sql->saveRows("
	SELECT S.id AS set_id,S.name AS set_name,S.description AS set_desc,
	       Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,S.crystal_type,
		   Z.rcp_flag,Z.drp_flag,Z.sll_flag,Z.weight,Z.price
	FROM l2jz_sets AS S
	LEFT OUTER JOIN l2jz_setitems AS I ON (I.set_id=S.id)
	INNER JOIN l2jz_items AS Z ON (Z.item_id=I.item_id)
	WHERE S.crystal_type = '".$id."'
	ORDER BY S.crystal_type,S.id
");
?>