<?php
$char=check_obj_id($_REQUEST['obj_id']);
$builder=check_numeric($_REQUEST["builder"],"Access level must be numeric.");

switch($char['type']."_".$char['status']){
	case"char_0":
		mysql_query("UPDATE characters SET accesslevel='$builder' WHERE obj_id='$char[id]'");
	break;
	case"char_1":
		kick_char($char['name']);
		mysql_query("UPDATE characters SET accesslevel='$builder' WHERE obj_id='$char[id]'");
	break;
	default:error("Invalid Object ID.");
}
$_RESULT['result']['accesslevel']=$builder;
$_RESULT['result']['online']=0;
print "Char's access level was successfully changed.";
?>
