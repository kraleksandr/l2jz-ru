<?php
$sql->saveRows("
	SELECT
		S.skill_id,S.level,Z.icon,Z.name,Z.description,Z.mp_consume,Z.cast_range
	FROM l2jz_npcskills AS S
	LEFT OUTER JOIN l2jz_skills AS Z ON(Z.id = S.skill_id AND Z.level = S.level)
	WHERE S.mob_id = '".$id."'
");
?>