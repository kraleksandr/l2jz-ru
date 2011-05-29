<?php
error("Sorry, this function is dangerous.");
if(!preg_match("/^".$loginserver['CnameTemplate']."$/",$_REQUEST['char_name'])){
	error("Invalid char name format.");
} else $new_char_name = $_REQUEST['char_name'];
$char = check_obj_id($_REQUEST['obj_id']);

kick($char[id]);
$result = mysql_query("SELECT obj_id FROM characters WHERE char_name='$new_char_name'");
if(mysql_num_rows($result)>0)error("Sorry, char with such name allready exists.");
mysql_query("UPDATE characters SET char_name='$new_char_name' WHERE obj_id='$char[id]'");
$_RESULT['result']['char_name'] = $new_char_name;
print "Char name was succesfully changed.";
?>