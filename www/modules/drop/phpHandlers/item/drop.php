<?php
$sql->saveRows("
	SELECT 
		N.map_flag,D.mob_id,N.name,N.level,D.min,D.max,D.chance,D.sweep
	FROM l2jz_drop AS D
	LEFT OUTER JOIN l2jz_mobs AS N ON (N.mob_id = D.mob_id)
	WHERE D.item_id='".$id."'
	ORDER BY chance DESC
");
?>