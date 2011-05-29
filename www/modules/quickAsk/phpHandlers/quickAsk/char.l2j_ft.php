<?php
$sql->saveRow("
	SELECT 
		C.obj_id AS char_id,C.char_name AS name".checkStrAccess("cLevel",",S.level").",C.sex,S.class_id,C.online
	FROM characters AS C
	INNER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	WHERE C.obj_id='".$id."'
");
?>