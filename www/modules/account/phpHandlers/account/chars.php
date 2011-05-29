<?php
$sql->saveRows("
	SELECT C.obj_id AS char_id,C.char_name,C.level,C.sex,C.classid AS class_id,P.clan_name,P.clan_id,C.pvpkills,C.pkkills,C.accesslevel
	FROM characters AS C
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid)
	WHERE C.account_name='".$login."' ORDER BY C.level DESC
");
?>