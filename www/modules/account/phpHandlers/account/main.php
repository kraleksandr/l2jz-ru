<?php
$sql->saveRow("
	SELECT login,lastactive,access_level,lastIP FROM accounts WHERE login='".$login."'
","LS");
?>