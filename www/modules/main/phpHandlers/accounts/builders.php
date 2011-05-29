<?php
$sql->saveRows("
	SELECT 
		login,lastactive,access_level,lastIP
	FROM accounts
	WHERE access_level>0
	ORDER BY login
","LS");
?>