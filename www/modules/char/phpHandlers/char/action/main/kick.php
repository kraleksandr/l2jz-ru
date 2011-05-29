<?php
$char=check_obj_id($_REQUEST['obj_id'],"char");

switch($char['type']){
	case"1":
		telnet("kick ".$char['name']."\r");
	break;
}

$_RESULT['result']['online']=0;
print "Char was successfully kicked"; 
?>