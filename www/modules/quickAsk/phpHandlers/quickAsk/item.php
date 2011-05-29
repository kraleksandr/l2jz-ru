<?php
$sql->saveRow("
	SELECT 
		Z.item_id,Z.icon,Z.name,Z.crystal_type,Z.crystal_count
	FROM l2jz_items AS Z 
	WHERE Z.item_id='".$id."' OR name='".$id."'
");
?>