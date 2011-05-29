<?php
$sql->saveRows("
	SELECT 
		N.map_flag,N.mob_id,N.name,N.level,N.aggro,N.hp,N.mp,N.exp,N.sp,N.attackrange,M.amount_min,M.amount_max
	FROM l2jz_minions AS M
	INNER JOIN l2jz_mobs AS N ON (N.mob_id = M.minion_id)
	WHERE M.boss_id = '".$id."' 
	ORDER BY N.level
");
?>