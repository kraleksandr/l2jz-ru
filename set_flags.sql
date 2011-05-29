UPDATE l2jz_items SET drp_flag=0,rcp_flag=0,sll_flag=0 WHERE item_id>0;

UPDATE l2jz_items AS Z SET rcp_flag=1 WHERE(
  SELECT count(item_id) FROM l2jz_recipes WHERE item_id=Z.item_id
)>0;

UPDATE l2jz_items AS Z SET drp_flag=1 WHERE(
  SELECT count(item_id) FROM l2jz_drop WHERE item_id=Z.item_id
)>0;

UPDATE l2jz_items AS Z SET sll_flag=1 WHERE (
  SELECT count(item_id) FROM l2jz_shops WHERE item_id=Z.item_id
)>0;

UPDATE l2jz_mobs SET map_flag=0,boss_flag=0 WHERE mob_id>0;

UPDATE l2jz_mobs AS M SET map_flag=1 WHERE (
  SELECT count(mob_id) FROM l2jz_spawns WHERE mob_id=M.mob_id
)>0;

UPDATE l2jz_mobs AS M SET boss_flag=1 WHERE (
  SELECT count(boss_id) FROM l2jz_minions WHERE boss_id=M.mob_id
)>0;