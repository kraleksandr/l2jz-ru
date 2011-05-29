<?php
$sql->saveRows("
	SELECT login,lastactive*1000 AS lastactive,access_level,lastIP
	FROM accounts
	ORDER BY login
","LS");
?>