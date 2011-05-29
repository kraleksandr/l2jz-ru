<?php
$sql->saveRows("
	SELECT
		S.skill_id,S.skill_level AS level,Z.icon,Z.name,Z.description,Z.mp_consume,
		Z.cast_range,S.class_index
	FROM character_skills AS S
	INNER JOIN l2jz_skills AS Z ON (Z.id = S.skill_id AND Z.level = S.skill_level)
	WHERE S.char_obj_id='".$char_id."'
	ORDER BY class_index
");
?>