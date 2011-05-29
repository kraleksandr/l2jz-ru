<?php
if((isset($_REQUEST['login']))&&(isset($_REQUEST['pass']))){
	$login = $_REQUEST['login'];
	$pass = base64_encode(pack("H*",sha1(utf8_encode($_REQUEST['pass']))));
	$remeber = $_REQUEST['remember'];
} elseif((isset($_SESSION["login"]))&&(isset($_SESSION["builder"]))){
	$_RESULT['login'] = $_SESSION["login"];
	$_RESULT['builder'] = $_SESSION["builder"];
	if($_RESULT['login']===''){
		setOkCode('guestLogin');
	} else {
		setOkCode('userLogin');
	}
} elseif((isset($_COOKIE['l2jz_login']))&&(isset($_COOKIE['l2jz_pass']))){
	$login = $_COOKIE['login'];
	$pass  = $_COOKIE['pass'];
} else {
	$_SESSION["login"] = $_RESULT['login'] = '';
	$_SESSION["builder"] = $_RESULT['builder'] = 0;
	setOkCode('guestLogin');
}

$pass  = stripslashes($pass);
$login = stripslashes($login);

if(strpos($login, " ") !== false)
{
	$_SESSION["login"] = $_RESULT['login'] = '';
	$_SESSION["builder"] = $_RESULT['builder'] = 0;
	setcookie("login","",time()-3600);
	setcookie("pass","",time()-3600);
	setErrorCode('hackAttempt');
}
{
	$result = $sql->query("SELECT login,access_level FROM accounts WHERE login='".$login."' AND password='".$pass."'","LS");
	if(mysql_num_rows($result)===1)
	{
		$user = mysql_fetch_assoc($result);
		$_SESSION["login"] = $_RESULT['login'] = $user['login'];
		$_SESSION["builder"] = $_RESULT['builder'] = $user['access_level'];
		if($remember==="checked")
		{
			setcookie("login",$login,0x6FFFFFFF);
			setcookie("pass",$pass,0x6FFFFFFF);
		}
		setOkCode('userLogin');
	} else
	{
		$_SESSION["login"] = $_RESULT['login'] = '';
		$_SESSION["builder"] = $_RESULT['builder'] = 0;
		setcookie("login","",time()-3600);
		setcookie("pass","",time()-3600);
		setErrorCode('incorrectPass');
	}
}
?>