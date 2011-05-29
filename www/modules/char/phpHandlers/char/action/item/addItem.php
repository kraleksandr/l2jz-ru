<?php
$item_id=check_numeric($_REQUEST['item_id'],"Item ID must be numeric.");
$item_name=check_item($item_id,"There is no item with such ID.");
$item_count=check_numeric_or_null($_REQUEST['count'],"Item count must be numeric.",1);
$owner=check_obj_id($_REQUEST['obj_id']);
$flag="offline_add";

switch($owner['type']."_".$owner['status']){
	case"char_1":
		$flag="online_add";
	break;
	case"char_0":
		$flag="offline_add";
		$location="INVENTORY";
	break;
	case"clan_0":
		$flag="offline_add";
		$location="CLANWH";
	break;
	default:error("Invalid Object ID.");
}

switch($flag){
	case"offline_add":
		$stackable=check_item_stackable($item_id);
		if(check_item_stackable($item_id)){
			$result=mysql_query("SELECT count,object_id FROM items WHERE item_id='$item_id' AND owner_id='$owner[id]' AND loc='INVENTORY'");
			if(mysql_num_rows($result)>0){
				$item=mysql_fetch_assoc($result);
				$item_count=$item_count+$item['count'];
				mysql_query("UPDATE items SET count=$item_count WHERE object_id='$item[object_id]'");
			} else {
				$object_id=get_obj_id();
				mysql_query("
					INSERT INTO items 
					(owner_id,object_id,item_id,count,enchant_level,loc,loc_data,price_sell,price_buy,time_of_use,custom_type1,custom_type2) 
					VALUES ($owner[id],$object_id,$item_id,$item_count,0,'$location',0,0,0,0,0,0)
				") or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
			}
		} else {
			for($i=0;$i<$item_count;$i++){
				$object_id=get_obj_id();
				mysql_query("
					INSERT INTO items 
					(owner_id,object_id,item_id,count,enchant_level,loc,loc_data,price_sell,price_buy,time_of_use,custom_type1,custom_type2) 
					VALUES ($owner[id],$object_id,$item_id,1,0,'$location',0,0,0,0,0,0)
				") or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
			}
		}
	break;
	case"online_add":
		telnet($item_id." ".$item_count." '".$owner['name']."' find_player inventory+!\r");
	break;
}
print "Item ".$item_name."(".$item_count.") was successfully added to ".$owner['type']." ".$owner['name'].".";
?>