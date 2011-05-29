<?php
$sql->saveRows("
	SELECT 
		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cAccount","C.account_name,").
		checkStrAccess("cLevel","C.level,").
		"C.sex,C.classid AS class_id,
		P.clan_name,C.clanid AS clan_id,C.pvpkills,C.pkkills,C.online,C.accesslevel
	FROM characters AS C
	LEFT OUTER JOIN clan_data AS P ON (P.clan_id = C.clanid) 
	WHERE C.accesslevel>0 ORDER BY C.accesslevel DESC
");
?>