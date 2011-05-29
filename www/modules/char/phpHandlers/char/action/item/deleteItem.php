<?php
$item = check_obj_id($_REQUEST['object_id'],"item");
$char = check_obj_id($item['owner'],"char");

switch($item['loc']."_".$char['status']){
	case"PAPERDOLL_1":case"INVENTORY_1":
		kick_char($char['name']);
	break;
}
mysql_query("DELETE FROM items WHERE object_id=$item[id]");

print "Item was successfully deleted.";
?>