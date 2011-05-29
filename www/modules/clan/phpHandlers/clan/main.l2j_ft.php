<?php
$sql->saveRow("
	SELECT
		C.clan_id,C.clan_name,C.clan_level,L.char_name AS clan_lider,C.leader_id AS clan_lider_id,
		SUM(S.level) AS level_sum,COUNT(S.level) AS clan_count,A.ally_name
	FROM clan_data AS C
	INNER JOIN characters AS L ON(L.obj_id=C.leader_id)
	LEFT OUTER JOIN characters AS P ON(P.clanid=C.clan_id)
	LEFT OUTER JOIN character_subclasses AS S ON (S.char_obj_id = P.obj_id AND S.isBase = 1)
	LEFT OUTER JOIN ally_data AS A ON (C.ally_id = A.ally_id)
	WHERE C.clan_id='".$clan_id."' GROUP BY C.clan_name
");
?>