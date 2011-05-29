<?php
$sql->saveRows("
	SELECT clan_id,clan_name,clan_level,L.char_name AS clan_lider,L.obj_id AS clan_lider_id,
	SUM(C.level) AS level_sum,COUNT(C.level) AS clan_count,ally_name
	FROM clan_data 
	LEFT OUTER JOIN characters AS L ON(L.obj_id=leader_id)
	LEFT OUTER JOIN characters AS C ON(C.clanid=clan_id)
	WHERE clan_id>0 GROUP BY clan_name 
	ORDER BY ally_name DESC,clan_level DESC,clan_name
");
?>