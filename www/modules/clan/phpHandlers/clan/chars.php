<?php
$sql->saveRows("
	SELECT
		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cAccount","C.account_name,").
		checkStrAccess("cLevel","C.level,").
		"C.sex,C.classid AS class_id,C.pvpkills,C.pkkills,C.online
	FROM characters AS C
	WHERE C.clanid='".$clan_id."' ORDER BY C.level DESC
");
?>