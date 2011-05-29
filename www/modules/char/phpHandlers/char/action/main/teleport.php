<?php
if(isset($_REQUEST["xyz"])){
	$xyz=explode(" ",preg_replace("/ {2,}/"," ",$_REQUEST["xyz"]));
	if(!isset($xyz[2])){
		error("I need at least three coordinates to teleport the char.");
		break;
	} else {
		$x=$xyz[0];
		$y=$xyz[1];
		$z=$xyz[2];
	}
}
if((!is_numeric($x))||(!is_numeric($y))||(!is_numeric($z)))error("All coordinates must be numeric.");
$char=check_obj_id($_REQUEST['obj_id']);
switch($char['type']."_".$char['status']){
	case"char_0":
		mysql_query("UPDATE characters SET x=$x,y=$y,z=$z WHERE obj_id='$char[obj_id]';");
	break;
	case"char_1":
		mysql_query("UPDATE characters SET x=$x,y=$y,z=$z WHERE obj_id='$char[obj_id]';");
	  telnet("$x $y $z '$char_name' find_player teleport-char-to\r");
	break;
	default:error("Invalid char object ID.");
}
print "Char was successfully teleported.";
?>