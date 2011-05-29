<?php
$sql->saveRows("
	SELECT C.obj_id AS char_id,C.char_name,C.account_name,S.level,C.sex,S.class_id,P.clan_id,P.clan_name,SUM(I.count) AS item_count,I.loc
	FROM items AS I
	INNER JOIN characters AS C ON ( C.obj_id = I. owner_id)
	LEFT OUTER JOIN character_subclasses AS S ON (S.char_obj_id = C.obj_id AND S.isBase = 1)
	LEFT OUTER JOIN clan_data AS P ON(P.clan_id = C.clanid OR P.clan_id = I. owner_id )
	WHERE I.item_id = '".$id."'
	GROUP BY C.obj_id ORDER BY item_count DESC
");
?>