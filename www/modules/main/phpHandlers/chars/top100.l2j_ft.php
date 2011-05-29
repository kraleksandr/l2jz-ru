<?php
$sql->saveRows("
	SELECT
		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cAccount","C.account_name,").
		checkStrAccess("cLevel","S.level,").
		"C.sex,S.class_id,P.clan_name,C.clanid AS clan_id,C.pvpkills,C.pkkills,C.onlinetime,C.online
	FROM characters AS C
	INNER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid) 
	WHERE C.accesslevel = 0 ORDER BY S.exp DESC LIMIT 0,100"
);
?>