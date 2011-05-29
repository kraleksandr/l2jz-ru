<?php
$sql->saveRow("
	SELECT 
		C.obj_id AS char_id,C.char_name,".checkStrAccess("cLevel","C.level,")."C.sex,C.classid AS class_id,C.online
	FROM characters AS C
	WHERE C.char_name='".$id."' OR C.obj_id='".$id."'
");
?>