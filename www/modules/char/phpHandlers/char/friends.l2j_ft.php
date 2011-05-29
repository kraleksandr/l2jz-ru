<?php
$sql->saveRows("
	SELECT 
		C.obj_id AS char_id,C.char_name,".checkStrAccess("cAccount","C.account_name,").",S.level,C.sex,S.class_id,P.clan_id,P.clan_name
	FROM character_friends AS F
	INNER JOIN characters AS C ON ( C.char_name = F.friend_name)
	LEFT OUTER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid )
	WHERE F.char_id = '".$char_id."'
	GROUP BY C.obj_id ORDER BY F.friend_name DESC
");
?>