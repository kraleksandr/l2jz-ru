<?php
$sql->saveRows("
	SELECT 
		Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,
		Z.rcp_flag,Z.drp_flag,Z.sll_flag,Z.weight,Z.price
	FROM l2jz_items as Z
	INNER JOIN l2jz_recipes AS R ON (R.recipe_id = Z.item_id)
	WHERE Z.type='recipe' AND Z.show_flag=1 AND R.recipe_level='".$id."'
	ORDER BY Z.name
");
?>