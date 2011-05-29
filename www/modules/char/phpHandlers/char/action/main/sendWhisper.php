<?php
$char=check_obj_id($_REQUEST['obj_id'],"char");

switch($char['status']){
	case"char_1":
		telnet("msg ".$char['name']." ".$whisper."\r");
	break;
}

print "Whisper has been sent.";
?>