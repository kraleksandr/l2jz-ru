<?php
$sql->saveRows("
	SELECT 
		N.map_flag,S.mob_id,N.name,S.price,S.shop_id
	FROM l2jz_shops      AS S
	INNER JOIN l2jz_mobs AS N ON (N.mob_id=S.mob_id)
	WHERE S.item_id='".$id."'
");
?>