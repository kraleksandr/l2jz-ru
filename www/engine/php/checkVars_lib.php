<?php
function checkVariable_string($varValue,$varArray){
	foreach($varArray as $col=>$val)switch($col){
		case"minlength":
			if(strlen($varValue)<$val)error($varArray['name']." has to be at least ".$val." charaters.");
		break;
	}
	return $varValue;
}

function checkVariable_numeric($varValue,$varArray){
	if(!is_numeric($varValue))error("<b>".$varArray['name']."</b> must be numeric.");
	foreach($varArray as $col=>$val)switch($col){
		case"min":
			if($varValue<$val)error("<b>".$varArray['name']."</b> can not be lower then ".$val.".");
		break;
		case"max":
			if($varValue>$val)error("<b>".$varArray['name']."</b> can not be bigger then ".$val.".");
		break;
	}
	return $varValue;
}

function checkVariable_login($varValue,$varArray){
	$result = $GLOBALS['sql']->query("SELECT login FROM accounts WHERE login='$varValue'","LS");
	if(mysql_num_rows($result)!=1)error("No such account.");
	return $varValue;
}

function checkVariable_newLogin($varValue,$varArray){
	if(!preg_match("/^".$GLOBALS['cfg']['LS'][0]['LnameTemplate']."$/",$varValue)){
		error("Account name '".$varValue."' is not valid.");
	}
	$result = $GLOBALS['sql']->query("SELECT login FROM accounts WHERE login='".$login."'","LS");
	if(mysql_num_rows($result)!==0){
		error("I am sorry but login <b>".$varValue."</b> is already taken.");
	}
	return $varValue;
}

function checkVariable_newPass($varValue,$varArray){
	if(strlen($varValue)<8)error("Password has to be at least 8 charaters.");
	return base64_encode(pack("H*", sha1(utf8_encode($varValue))));
}

function checkVariable_pass($varValue,$varArray){
	return base64_encode(pack("H*", sha1(utf8_encode($varValue))));
}

function checkVariable_email($varValue,$varArray){
	if(!preg_match("/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{2,4}$/",$varValue)){
		error("Email address is not valid.");
	}
	return $varValue;
}

function checkVariable_char_id($varValue,$varArray){
	$result = $GLOBALS['sql']->query("
		SELECT obj_id AS id,online AS status,char_name AS name,'char' AS type 
		FROM characters
		WHERE obj_id='$varValue'
	");
	if($GLOBALS['sql']->numRows($result)!=1)error("Invalid Char Object ID.");
	return $GLOBALS['sql']->fetchAssoc($result);
}
?>