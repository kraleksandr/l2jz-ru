<?php
$sql->saveRows("
	SELECT 
		login,lastactive,access_level,lastIP 
	FROM accounts 
	WHERE login LIKE '%".$id."%' OR lastIP LIKE '%".$id."%'
	ORDER BY login
","LS");
?>