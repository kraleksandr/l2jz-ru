<?php
$sql->saveRow("
	SELECT
		clan_id,clan_name,clan_level,L.char_name AS clan_lider,leader_id AS clan_lider_id,
		SUM(C.level) AS level_sum,COUNT(C.level) AS clan_count,ally_name
	FROM clan_data 
	INNER JOIN characters AS L ON(L.obj_id=leader_id)
	LEFT OUTER JOIN characters AS C ON(C.clanid=clan_data.clan_id) 
	WHERE clan_id='".$clan_id."' GROUP BY clan_name
");
?>