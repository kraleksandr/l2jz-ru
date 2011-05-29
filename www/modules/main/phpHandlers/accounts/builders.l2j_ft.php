<?php
$sql->saveRows("
	SELECT login,lastactive*1000 AS lastactive,access_level,lastIP
	FROM accounts
	WHERE access_level>0
	ORDER BY login
","LS");
?>