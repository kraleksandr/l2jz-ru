<?php
$sql->saveRows("
	SELECT 
		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cAccount","C.account_name,").
		checkStrAccess("cLevel","C.level,").
		"C.sex,C.classid AS class_id,
		P.clan_name,P.clan_id,C.pvpkills,C.pkkills,C.online
	FROM characters AS C
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid) 
	WHERE C.char_name LIKE '%$id%' OR C.obj_id='$id'
	ORDER BY C.char_name
");
?>