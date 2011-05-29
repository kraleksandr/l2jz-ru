<?php
$sql->saveRows("
	SELECT
		N.mob_id,N.name,N.level,N.aggro,N.type,N.sex,S.locx AS x,S.locy AS y,S.count,S.respawn_delay
	FROM l2jz_spawns AS S
	INNER JOIN l2jz_mobs AS N ON (N.mob_id = S.mob_id)
	WHERE S.mob_id='".$id."'
");
?>