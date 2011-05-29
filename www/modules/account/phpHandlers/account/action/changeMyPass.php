<?php
$result = $sql->query("
	SELECT login FROM accounts 
	WHERE login='".$login."' AND login='".$USER['login']."' AND password='".$pass."'
","LS");

if(mysql_num_rows($result)!=1)setErrorCode("wrongLoginOrPass");

$sql->query("
	UPDATE accounts
	SET password='".$newPass."'
	WHERE login='".$login."'
","LS");
?>