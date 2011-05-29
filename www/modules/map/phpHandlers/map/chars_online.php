<?php
$sql->saveRows("
	SELECT 
		obj_id AS char_id,char_name,".
		checkStrAccess("cLevel","level,").
		"'L2Player' AS type,C.classid AS class_id,C.sex,x,y,z 
	FROM characters AS C WHERE online=1
");
?>