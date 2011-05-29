<?php
if($cfg["workMode"]=="l2j_ft")$lastactive = time(); else $lastactive = time()*1000;
$lastactive = settype($lastactive,'integer');
$last_ip    = $_SERVER['REMOTE_ADDR'];
$sql->query("
	INSERT INTO accounts(login, password, lastactive, access_level,lastIP,email) 
	VALUES('$login' , '$pass', '$lastactive', '0','$last_ip', '$email')
","LS");	
$_SESSION["login"]   = $_RESULT['login']   = $login;
$_SESSION["builder"] = $_RESULT['builder'] = 0;
setOkCode('userLogin');
?>