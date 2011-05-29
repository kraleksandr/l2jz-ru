<?php
$sql->saveRow("
	SELECT C.obj_id AS char_id,C.char_name,C.account_name,C.sex,C.pkkills,C.pvpkills,C.accesslevel,C.online,C.onlinetime,C.title,
	       C.classid AS class_id,C.level,C.exp,C.sp,C.curHp,C.maxHp,C.curMp,C.maxMp,
	       P.clan_name,P.clan_id,
	       C.pAtk,C.mAtk,C.pDef,C.mDef,C.crit,C.acc,C.mSpd,C.pSpd
	FROM characters AS C
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid)
	WHERE C.obj_id='".$char_id."'
");
?>