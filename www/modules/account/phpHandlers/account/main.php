<?php
$sql->saveRow("
	SELECT login,lastactive,access_level,lastIP,email FROM accounts WHERE login='".$login."'
","LS");
?>