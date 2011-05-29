<?php
switch($id){
	case"01_10":$query="N.level>=1 AND N.level<=10 AND N.type = 'L2Monster'";
	break;
	case"11_20":$query="N.level>=11 AND N.level<=20 AND N.type = 'L2Monster'";
	break;
	case"21_30":$query="N.level>=21 AND N.level<=30 AND N.type = 'L2Monster'";
	break;
	case"31_40":$query="N.level>=31 AND N.level<=40 AND N.type = 'L2Monster'";
	break;
	case"41_50":$query="N.level>=41 AND N.level<=50 AND N.type = 'L2Monster'";
	break;
	case"51_60":$query="N.level>=51 AND N.level<=60 AND N.type = 'L2Monster'";
	break;
	case"61_70":$query="N.level>=61 AND N.level<=70 AND N.type = 'L2Monster'";
	break;
	case"71_80":$query="N.level>=71 AND N.level<=80 AND N.type = 'L2Monster'";
	break;
	case"81_90":$query="N.level>=81 AND N.level<=90 AND N.type = 'L2Monster'";
	break;
	case"undead":$query="N.isUndead = 1";
	break;
	case"npc":$query="N.type = 'L2Npc'";
	break;
	case"merchant":$query="N.type = 'L2Merchant'";
	break;
	case"warehouse":$query="N.type = 'L2Warehouse'";
	break;
	case"teleporter":$query="N.type = 'L2Teleporter' ";
	break;
	case"guard":$query="N.type = 'L2Guard'";
	break;
	case"raidboss":$query="N.type = 'L2RaidBoss'";
	break;
	default:error("Unknown mob type: '$id'");
}
$sql->saveRows("
	SELECT 
		N.map_flag,N.mob_id,N.name,N.level,N.aggro,N.hp,N.mp,N.exp,N.sp,N.attackrange
	FROM l2jz_mobs AS N WHERE ".$query." ORDER BY level,exp
");
?>