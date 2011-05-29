<?php
$sql->query("
	UPDATE accounts
	SET access_level='".$builder."'
	WHERE login='".$login."'
","LS");
$_RESULT['access_level'] = $builder;
?>