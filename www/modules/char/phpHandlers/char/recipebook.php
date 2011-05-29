<?php
$sql->saveRows("
	SELECT 
		Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,E.item_id,E.weight,E.price
	FROM character_recipebook AS C
	INNER JOIN l2jz_recipes AS R ON (R.id = C.id)
	INNER JOIN l2jz_items AS Z ON (Z.item_id = R.recipe_id)
	INNER JOIN etcitem AS E ON (E.item_id = Z.item_id)
	WHERE C.char_id = '".$char_id."'
	GROUP BY Z.item_id ORDER BY Z.name
");
?>