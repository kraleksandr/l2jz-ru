<?php
$sql->saveRows("
	SELECT 
		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cLevel","S.level,").
		"'L2Player' AS type,S.class_id,C.x,C.y,C.z
	FROM characters AS C
	INNER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	WHERE C.clanid='".$clan_id."'
");
?>