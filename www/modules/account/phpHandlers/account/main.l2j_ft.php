<?php
$sql->saveRow("
	SELECT login,lastactive*1000 AS lastactive,access_level,lastIP,email FROM accounts WHERE login='".$login."'
","LS");
?>