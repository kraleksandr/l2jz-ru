<?php
$item_obj_id=check_numeric($_REQUEST['object_id'],"Object ID must be numeric.");
$enchant_level=check_numeric($_REQUEST['enchant_level'],"Enchant level must be numeric.");
$item=check_obj_id($item_obj_id);
if($item['type']!='item')error("Invalid Object ID.");
$owner=check_obj_id($item['owner']);

switch($owner['type']."_".$owner['status']){
	case"char_1":
		telnet("'$owner[name]' find_player $item[item_id] $enchant_level enchant-level!\r");
		mysql_query("UPDATE items SET enchant_level=$enchant_level WHERE object_id=$item_obj_id");
	break;
	case"char_0":case"clan_0":
		mysql_query("UPDATE items SET enchant_level=$enchant_level WHERE object_id=$item_obj_id");
	break;
	default:error("Invalid Object ID.");
}

print "Item enchant level was succesfully changed.";
?>