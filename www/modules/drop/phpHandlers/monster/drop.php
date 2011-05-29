<?php
$sql->saveRows("
	SELECT
		Z.item_id,Z.icon,Z.name as name,Z.crystal_type,Z.crystal_count,D.min,D.max,D.chance,D.sweep
	FROM l2jz_drop AS D
	LEFT OUTER JOIN l2jz_items AS Z ON (Z.item_id = D.item_id) 
	WHERE D.mob_id='".$id."'
	ORDER BY sweep,chance DESC
");
?>