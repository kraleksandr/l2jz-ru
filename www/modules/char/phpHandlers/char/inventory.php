<?php
$sql->saveRows("
	SELECT
		I.object_id AS item_obj_id,I.item_id,Z.gtype,Z.icon,Z.name,Z.additionalname,Z.description,
		C.char_name,I.loc,Z.crystal_type,Z.crystal_count,I.count,I.enchant_level,Z.type
	FROM items AS I
	INNER JOIN l2jz_items as Z ON (Z.item_id = I.item_id)
	INNER JOIN characters AS C ON (C.obj_id = I.owner_id)
	WHERE I.owner_id = '".$char_id."'
");
?>