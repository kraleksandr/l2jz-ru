<?php
$sql->saveRow("
	SELECT N.mob_id,N.name,N.type,N.level,N.aggro 
	FROM l2jz_mobs AS N 
	WHERE N.mob_id='".$id."' OR N.name='".$id."'
");
?>