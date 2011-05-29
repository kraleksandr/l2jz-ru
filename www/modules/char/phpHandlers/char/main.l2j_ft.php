<?php
$sql->saveRow("
	SELECT C.obj_id AS char_id,C.char_name,C.account_name,C.sex,C.pkkills,C.pvpkills,C.accesslevel,C.online,C.onlinetime,C.title,
	       S.class_id,S.level,S.exp,S.sp,S.curHp,S.maxHp,S.curMp,S.maxMp,
	       P.clan_name,P.clan_id
	FROM characters AS C
	INNER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid)
	WHERE C.obj_id='".$char_id."'
");
?>