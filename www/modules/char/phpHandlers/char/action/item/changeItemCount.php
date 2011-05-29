<?php
$item      = check_obj_id($_REQUEST['object_id'],"item");
$char      = check_obj_id($item['owner'],"char");
$new_count = check_numeric($_REQUEST['count'],"Item count must be numeric.");

switch($item['loc']."_".$char['status']){
	case"PAPERDOLL_1":case"INVENTORY_1":
		if($item['count']>$new_count){
			$change=$item['count']-$new_count;
			telnet("$item[item_id] $change '$char[name]' find_player inventory-!\r");
		} else {
			$change=$new_count-$item['count'];
			telnet("$item[item_id] $change '$char[name]' find_player inventory+!\r");
		}
	break;
	case"PAPERDOLL_0":case"INVENTORY_0":
	case"WAREHOUSE_0":case"CLANWH_0":
	case"WAREHOUSE_1":case"CLANWH_1":
		mysql_query("UPDATE items SET count=$new_count WHERE object_id=$item[id]");
	break;
	}
	print "Item count was succesfully changed.";
?>