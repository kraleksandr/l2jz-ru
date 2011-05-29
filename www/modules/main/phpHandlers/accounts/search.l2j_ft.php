<?php
$sql->saveRows("
	SELECT login,lastactive*1000 AS lastactive,access_level,lastIP
	FROM accounts 
	WHERE login LIKE '%$id%' OR lastIP LIKE'%$id%'
	ORDER BY login
","LS");
?>