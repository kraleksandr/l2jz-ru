<?php
$sql->saveRows("
	SELECT 
		N.map_flag,N.mob_id,N.name,N.type,N.level,N.aggro,N.hp,N.mp,N.exp,N.sp,N.attackrange
	FROM l2jz_mobs AS N
	WHERE N.mob_id='".$id."' OR N.name LIKE '%".$id."%' ORDER BY level,exp
");
?>