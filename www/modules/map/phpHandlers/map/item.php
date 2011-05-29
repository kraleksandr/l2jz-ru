<?php
$sql->saveRows("
	SELECT
		D.mob_id,M.name,M.level,M.aggro,M.type,M.sex,D.sweep,D.chance,D.min,D.max,
		S.locx AS x,S.locy AS y,S.count,S.respawn_delay
	FROM l2jz_drop AS D
	LEFT OUTER JOIN l2jz_mobs AS M ON (M.mob_id=D.mob_id)
	LEFT OUTER JOIN l2jz_spawns AS S ON (S.mob_id=M.mob_id)
	WHERE D.item_id='".$id."'
");
?>