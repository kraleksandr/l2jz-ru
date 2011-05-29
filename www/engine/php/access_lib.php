<?php

function checkAccess($l2jz_query,$login,$builder){
	if((isset($GLOBALS['l2jz'][$l2jz_query]['access']))&&($builder>=$GLOBALS['l2jz'][$l2jz_query]['access']))return TRUE;
	if(isset($GLOBALS['l2jz'][$l2jz_query]['sAccess'])){
		if(call_user_func($GLOBALS['l2jz'][$l2jz_query]['sAccess']))return TRUE;
	}
	$GLOBALS['_RES']['status']['status'] = 'no_access';
	exit();
}

//Checks that user is a owner of the account.
function checkAccessSpecial_myAccount(){
	if($GLOBALS['VARS']['login']===$GLOBALS['USER']['login'])return true;
	return false;
}

//Checks that user is a owner of the char.
function checkAccessSpecial_myChar(){
	$result = $GLOBALS['sql']->query("
		SELECT account_name FROM characters 
		WHERE obj_id='".$GLOBALS['VARS']['char_id']."' AND account_name='".$GLOBALS['USER']['login']."'
	");
	if(mysql_num_rows($result)===1)return true;
	return false;
}

//Checks that user is an owner of the clan.
function checkAccessSpecial_myClan(){
	$result = $GLOBALS['sql']->query("
		SELECT clan_id,C.account_name
		FROM clan_data
		INNER JOIN characters AS C ON (C.obj_id = leader_id)
		WHERE clan_id='".$GLOBALS['VARS']['clan_id']."' AND account_name='".$GLOBALS['USER']['login']."'
	");
	if(mysql_num_rows($result)===1)return true;
	return false;
}

//Checks that user is a member of the clan.
function checkAccessSpecial_myClan2(){
	$result = $GLOBALS['sql']->query("
		SELECT clanid AS clan_id,account_name FROM characters
		WHERE clan_id='".$GLOBALS['VARS']['clan_id']."' AND account_name='".$GLOBALS['USER']['login']."'
	");
	if(mysql_num_rows($result)>0)return true;
	return false;
}

function checkStrAccess($column,$strTrue="",$strFalse=""){
	if($GLOBALS['cfg']['columnAccess'][$column]<=$GLOBALS['USER']['builder']){
		return $strTrue;
	} else {
		return $strFalse;
	}
}
?>