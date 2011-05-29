<?php
$sql->saveRows("
	SELECT
		login,lastactive,access_level,lastIP
	FROM accounts
	ORDER BY login
","LS");
?>