<?php
$sql->saveRows("
	SELECT
  		C.obj_id AS char_id,C.char_name,".
		checkStrAccess("cAccount","C.account_name,").
		checkStrAccess("cLevel","C.level,").
		"C.sex,C.classid AS class_id,
  		P.clan_id,P.clan_name
  		".checkStrAccess("cAdena",",(SELECT SUM(count) FROM items WHERE owner_id=C.obj_id AND item_id=57) AS adena_count ")."
	FROM characters AS C
	LEFT OUTER JOIN clan_data AS P ON (C.clanid = P.clan_id)
	WHERE C.accesslevel = 0
	ORDER BY (SELECT SUM(count) FROM items WHERE owner_id=C.obj_id AND item_id=57)
	DESC LIMIT 0,100
");
?>