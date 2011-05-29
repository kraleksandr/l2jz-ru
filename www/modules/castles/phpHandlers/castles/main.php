<?php
$sql->saveRows("
	SELECT 
		C.id AS castle_id,C.name AS castle_name,
		C.taxPercent,C.treasury,C.siegeDate,
		C.siegeDayOfWeek,C.siegeHourOfDay,S.clan_id,S.type,Cl.clan_name,
		Cc.clan_id AS owner_id,Cc.clan_name AS owner_name
	FROM  castle AS C
	LEFT OUTER JOIN siege_clans AS S ON (S.castle_id = C.id)
	LEFT OUTER JOIN clan_data AS Cl ON (Cl.clan_id = S.clan_id)
	LEFT OUTER JOIN clan_data AS Cc ON (Cc.hasCastle = C.id)
	ORDER BY C.id
");
?>