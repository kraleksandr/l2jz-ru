<?php
$result = $sql->query("
	UPDATE accounts
	SET access_level=0
	WHERE login='".$login."'
","LS");
$_RESULT['access_level'] = 0;
?>