<?php
$sql->saveRows("
	SELECT C.obj_id AS char_id,C.char_name,S.level,C.sex,S.class_id,P.clan_name,P.clan_id,C.pvpkills,C.pkkills,C.accesslevel
	FROM characters AS C
	INNER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid)
	WHERE C.account_name='".$login."' ORDER BY S.level DESC
");
?>