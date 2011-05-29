<?php
$sql->saveRows("
	SELECT 
		obj_id AS char_id,char_name,".checkStrAccess("cLevel","level,")."'L2Player' AS type,C.sex,classid AS class_id,C.sex,x,y,z 
	FROM characters 
	WHERE obj_id='".$char_id."'
");
?>