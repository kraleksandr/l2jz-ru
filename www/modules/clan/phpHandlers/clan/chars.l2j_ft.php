<?php
$sql->saveRows("
	SELECT
		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cAccount","C.account_name,").
		checkStrAccess("cLevel","S.level,").
		"C.sex,S.class_id,C.pvpkills,C.pkkills,C.online
	FROM characters AS C
	INNER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	WHERE C.clanid='".$clan_id."' ORDER BY S.level DESC
");
?>