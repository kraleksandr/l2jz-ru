<?php
$sql->saveRows("
	SELECT 
		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cLevel","C.level,").
		"'L2Player' AS type,C.classid AS class_id,C.sex,C.x,C.y,C.z
	FROM characters AS C
	WHERE C.clanid='".$clan_id."'
");
?>