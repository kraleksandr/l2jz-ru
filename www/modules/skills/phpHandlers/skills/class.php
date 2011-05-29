<?php
$sql->saveRows("
	SELECT
		S.class_id,S.level,Z.icon,Z.name,Z.description,Z.mp_consume,Z.cast_range,S.sp,S.min_level,S.skill_id 
	FROM l2jz_skill_trees AS S 
	INNER JOIN l2jz_skills AS Z ON (Z.id = S.skill_id AND Z.level = S.level AND S.class_id='".$id."')
	ORDER BY S.min_level,S.skill_id,S.level
");
?>