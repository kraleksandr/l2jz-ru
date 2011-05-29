<?php
$sql->saveRows("
	SELECT
		C.clan_id,C.clan_name,C.clan_level,L.char_name AS clan_lider,L.obj_id AS clan_lider_id,
		SUM(S.level) AS level_sum,COUNT(S.level) AS clan_count,A.ally_name
	FROM clan_data AS C
	LEFT OUTER JOIN characters AS L ON(L.obj_id=C.leader_id)
	LEFT OUTER JOIN characters AS P ON(P.clanid=C.clan_id)
	LEFT OUTER JOIN character_subclasses AS S ON (S.char_obj_id = P.obj_id AND S.isBase = 1)
	LEFT OUTER JOIN ally_data AS A ON (C.ally_id = A.ally_id)
	WHERE clan_name LIKE '%".$id."%' OR clan_id='".$id."'
	GROUP BY clan_name ORDER BY A.ally_name DESC,clan_level DESC,clan_name
");
?>