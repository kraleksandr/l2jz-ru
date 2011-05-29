<?php
switch($id){
	case'chest':case'legs':case'fullbody':case"pet_armor":
		$sql->saveRows("
			SELECT 
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,
				Z.crystal_type,
				Z.bodypart,Z.rcp_flag,Z.drp_flag,Z.sll_flag,
				A.p_def,A.mp_bonus,Z.weight,Z.price,Z.crystal_count
			FROM l2jz_items as Z 
			INNER JOIN l2jz_armor AS A ON (Z.item_id=A.item_id)
			WHERE Z.type='".$id."' AND Z.show_flag=1
			ORDER BY Z.bodypart,Z.crystal_type,price
		");
	break;
	case'feet':case'gloves':case'head':case'back':case'underwear':
		$sql->saveRows("
			SELECT 
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,Z.crystal_type,
				Z.rcp_flag,Z.drp_flag,Z.sll_flag,
				A.p_def,Z.price,Z.weight,Z.crystal_count
			FROM l2jz_items as Z 
			INNER JOIN l2jz_armor AS A ON (Z.item_id=A.item_id)
			WHERE Z.type='".$id."' AND Z.show_flag=1
			ORDER BY Z.crystal_type,Z.price
		");
	break;
	case'shield':
		$sql->saveRows("
			SELECT 
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,Z.crystal_type,
				Z.rcp_flag,Z.drp_flag,Z.sll_flag,
				S.avoid_modify,S.shield_def,S.shield_def_rate,
				Z.weight,Z.price,Z.crystal_count  
			FROM l2jz_items as Z
			INNER JOIN l2jz_shield AS S ON (Z.item_id=S.item_id)
			WHERE Z.type='".$id."' AND Z.show_flag=1
			ORDER BY Z.crystal_type,Z.price
		");
	break;
	case"sword":case"blunt":case"dagger":case"etc":case"pet_weapon":case"bow":case"pole":case"dualfist":case"dual":case"bigsword":
		$sql->saveRows("
			SELECT 
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,Z.crystal_type,Z.bodypart,
				Z.rcp_flag,Z.drp_flag,Z.sll_flag,
				W.p_dam,W.m_dam,W.mp_consume,W.soulshots,W.spiritshots,W.atk_speed,
				Z.weight,Z.price,Z.crystal_count
			FROM l2jz_items as Z 
			INNER JOIN l2jz_weapon AS W ON (Z.item_id=W.item_id)
			WHERE Z.type='".$id."' AND Z.show_flag=1
			ORDER BY Z.bodypart DESC,Z.crystal_type,Z.price
		");
	break;
	case'ear':case'finger':case'neck'
		:$sql->saveRows("
			SELECT 
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,Z.crystal_type,
				Z.rcp_flag,Z.drp_flag,Z.sll_flag,
				A.m_def,
				Z.weight,Z.price,Z.crystal_count
			FROM l2jz_items as Z 
			INNER JOIN l2jz_armor AS A ON (Z.item_id=A.item_id)
			WHERE Z.type='".$id."' AND Z.show_flag=1
			ORDER BY Z.crystal_type,Z.price
		");
	break;
	case'scroll':case'soulshots':
		$sql->saveRows("
			SELECT
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,Z.bodypart,Z.crystal_type,
				Z.rcp_flag,Z.drp_flag,Z.sll_flag,Z.weight,Z.price
			FROM l2jz_items as Z
			WHERE Z.type='".$id."'
			ORDER BY Z.bodypart,Z.crystal_type,Z.name
		");
	break;
	case'arrow':
		$sql->saveRows("
			SELECT
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,Z.crystal_type,
				Z.rcp_flag,Z.drp_flag,Z.sll_flag,Z.weight,Z.price
			FROM l2jz_items as Z
			WHERE Z.type='".$id."'
			ORDER BY Z.crystal_type,Z.name
		");
	break;
	default:
		$sql->saveRows("
			SELECT 
				Z.item_id,Z.icon,Z.name,Z.additionalname,Z.description,
				Z.rcp_flag,Z.drp_flag,Z.sll_flag,Z.weight,Z.price 
			FROM l2jz_items as Z
			WHERE Z.type='".$id."'
			ORDER BY Z.name
		");
}
?>