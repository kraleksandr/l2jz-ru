<?php
$sql->saveRow("
	SELECT 
		M.map_flag,M.mob_id,M.name,M.type,M.level,M.sex,M.aggro,M.hp,M.mp,M.exp,M.sp,
		M.attackrange,M.patk,M.matk,M.pdef,M.mdef,M.isUndead,M.atkspd,M.matkspd,
		M.walkspd,M.runspd,M.rhand,M.lhand,Zl.name AS litem_name,Zr.name AS ritem_name,
		M.icon,M.boss_flag
	FROM l2jz_mobs AS M
	LEFT OUTER JOIN l2jz_items Zl ON (Zl.item_id=M.lhand)
	LEFT OUTER JOIN l2jz_items Zr ON (Zr.item_id=M.rhand)
	WHERE M.mob_id='".$id."'
");
?>