<?php
function get_recipe_body($res_id,$base_res_id){
	$res = $GLOBALS['sql']->getRows("
		SELECT
			'".$base_res_id."' AS recipe_id,I.item_id,I.count,I.has_recipe,Z.name,Z.icon,E.price,R.count as r_count
		FROM l2jz_ingredients AS I
		INNER JOIN l2jz_items        AS Z ON (I.item_id = Z.item_id)
		LEFT OUTER JOIN l2jz_recipes AS R ON (I.item_id = R.item_id)
		INNER JOIN etcitem           AS E ON (I.item_id = E.item_id)
		WHERE I.recipe_id='".$res_id."'
		ORDER BY I.count
	");
	$recipe = array();
	foreach($res as $col=>$item){
		$item['body'] = ($item['has_recipe']>0)?get_recipe_body($item['has_recipe'],$base_res_id):NULL;
		$recipe[] = $item;
	}
	return $recipe;
}

if($sql->getElem("SELECT type FROM l2jz_items WHERE item_id='".$id."'")=='recipe'){
	$query = "Z.item_id=R.item_id";
} else {
	$query = "Z.item_id=R.recipe_id";
}
$recipes= $sql->getRows("
	SELECT
		R.id,R.recipe_id,R.recipe_level,R.item_id,R.count,R.mp,R.chance,Z.icon,Z.name,Z.item_id AS sid
	FROM l2jz_recipes AS R
	INNER JOIN l2jz_items AS Z ON (".$query.")
	WHERE Z.item_id='".$id."' OR R.item_id='".$id."'
");
foreach($recipes as $col=>$recipe){
	$recipe['body'] = get_recipe_body($recipe['id'],$recipe['id']);
	$_RESULT[] = $recipe;
}
?>