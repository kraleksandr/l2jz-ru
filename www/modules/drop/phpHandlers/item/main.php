<?php
$result = $sql->query("SELECT gtype FROM l2jz_items WHERE item_id='".$id."'");
if(mysql_num_rows($result)==0)error("No such item.");
$item=mysql_fetch_array($result);
switch($item[0]){
	case"0"://Armor
		$inner_join_table = "INNER JOIN l2jz_armor AS A ON (A.item_id = Z.item_id)";
		$table_select     = ",A.p_def,A.mp_bonus";
	break;
	case"1"://Accessorie
		$inner_join_table = "INNER JOIN l2jz_armor AS A ON (A.item_id = Z.item_id)";
		$table_select     = ",A.m_def";
	break;
	case"2"://Weapon
		$inner_join_table = "INNER JOIN l2jz_weapon AS W ON (W.item_id = Z.item_id)";
		$table_select     = ",W.p_dam,W.m_dam,W.mp_consume,W.soulshots,W.spiritshots,W.atk_speed";
	break;
	case"3"://Shields
		$inner_join_table = "INNER JOIN l2jz_shield AS A ON (A.item_id = Z.item_id)";
		$table_select     = ",A.shield_def AS p_def,A.shield_def_rate,A.avoid_modify";
	break;
	default://Other Items
		$inner_join_table = $table_select  = "";
}
$sql->saveRow("
	SELECT 
		Z.icon,Z.item_id,Z.name,Z.additionalname,Z.description,Z.crystal_type,Z.type,
		Z.rcp_flag,Z.drp_flag,Z.sll_flag,Z.weight,Z.price,Z.crystal_count".
		checkStrAccess("
			iOwners","
				,(SELECT SUM(count) FROM items WHERE item_id=Z.item_id) AS world_count,
				(SELECT count(item_id) FROM items WHERE item_id=Z.item_id) AS owners
		")."
	".$table_select."
	FROM l2jz_items AS Z 
	".$inner_join_table."
	WHERE Z.item_id='".$id."'
");  
?>