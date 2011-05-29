<?php
$class_id = check_numeric($_REQUEST["class_id"],"Class ID must be numeric.");
$char=check_obj_id($_REQUEST['obj_id'],"char");

switch($char['status']){
	case"0":
		mysql_query("UPDATE characters SET classid='$class_id' WHERE obj_id='$char[id]'");
	break;
	case"1":
		mysql_query("UPDATE characters SET classid='$class_id' WHERE obj_id='$char[id]'");
		telnet("$class_id '$char[name]' find_player CLASS!\r");
	break;
}
$_RESULT['result']['class_id']=$classid; 
print "Char's class was succesfully changed.";
?>