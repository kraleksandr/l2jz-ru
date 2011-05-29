//----------//
// TABLES  //
//--------//
/* 
 */

var l2jz_tableHandlers = {
	'default': {
		'rowCounter': function(){
			string.push(tableIterator+1);
		},
		'chance': function(){
			var sClass;
			var chance =(row.sweep=='0')?Math.round(row.chance*sT.GS.rateDropItems)/10000:Math.round(row.chance*sT.GS.rateDropSpoil)/10000;
			if(chance>100)chance=100;
			if(chance<1)sClass='low'; else if(chance<50)sClass='medium'; else sClass='high';
			string.push('<span class="'+sClass+'">'+chance+'%<br><span class="digit">1/'+Math.round(100/chance)+'</span></span>');
		},
		'icon': function(){
			string.push('<img width="32" height="32" src="i/items/'+row.icon+'.png">');
		}
	},
//PLAYER HANDLERS
	'char': {
		'pkkills': null,
		'clan_id': null,
		'char_id': null,
		'location': function(){
			string.push(html.a('map.char.'+row.char_id,html.h('etc.mapStatus.loc')));
		},
		'char_name': function(){
			string.push(html.a('char.main.'+row.char_id,row.char_name));
		},
		'account_name': function(){
			string.push(html.a('account.main.'+row.account_name,row.account_name));
		},
		'clan_name': function(){
			if(typeof(row.clan_name)=='string')string.push(html.a('clan.main.'+row.clan_id,row.clan_name));
		},
		'sex': function(){
			string.push((row['sex']=='1')?'<img src=i/female.gif>':'<img src=i/male.gif>');
		},
		'pvpkills': function(){
			string.push(row.pvpkills+'/'+row.pkkills);
		},
		'class_id': function(){
			string.push(html.a('skills.class.'+row.class_id));
		},
		'online': function(){
			string.push(((row.online>0)?html.h('etc.charStatus.online'):html.h('etc.charStatus.offline')));
		},
		'loc': function(){
			string.push(html.h('etc.itemLoc.'+row.loc));
		},
		'onlinetime': function(){
			string.push(Math.round(row.onlinetime/360)/10+' h');
		},
		'maxHp': function(){
			string.push(Math.round(row.curHp)+'/'+row.maxHp);
		},
		'maxMp': function(){
			string.push(Math.round(row.curMp)+'/'+row.maxMp);
		},
		'kickCharPanel': function(){
			string.push(html.pnl('char.main.kick',row));
		}
	},
//ACCOUNT HANDLERS
	'account': {
		'login': function(){
			string.push(html.a('account.main.'+row.login,row.login));
		},
		'lastactive': function(){
			var date=new Date(row.lastactive/1);
			string.push(
				date.getDate()+' '+html.h('etc.month.'+date.getMonth())+' '+date.getFullYear()+' '+date.getHours()+':'+date.getMinutes()
			);
		}
	},
//CLAN HANDLERS
	'clan': {
		'clan_id': null,
		'ally_id': null,
		'ally_name': null,
		'clan_lider_id': null,
		'location': function(){
			string.push(html.a('map.clan.'+row.clan_id,html.h('etc.mapStatus.loc')));
		},
		'clan_name': function(){
			string.push(html.a('clan.main.'+row.clan_id,row.clan_name));
		},
		'clan_lider': function(){
			string.push(html.a('char.main.'+row.clan_lider_id,row.clan_lider));
		},
		'level_sum': function(){
			string.push(((row.clan_count>0)?Math.round(row.level_sum/row.clan_count*10)/10:0));
		}
	},
//ITEMS HANDLERS
	'items': {
		'item_id': null,
		'mob_id': null,
		'item_obj_id': null,
		'additionalname': null,
		'description': null,
		'crystal_count': null,
		'char_name_s': null,
		'online': null,
		'm_dam': null,
		'count': null,
		'sweep': null,
		'min': null,
		'max': null,
		'enchant_level': null,
		'merchant_area_id': null,
		'gtype': null,
		'mp_consume': null,
		'spiritshots': null,
		'bodypart': null,
		'owner_id': null,
		'consume_type': null,
		'loc': null,
		'shop_id': null,
		'recipe_level': null,
		'rcp_flag':null,
		'drp_flag':null,
		'sll_flag':null,
		'owners':null,
		'world_count':null,
		'set_id':null,
		'set_name':null,
		'set_desc':null,
		'name': function(){
			var additional_info='';
			if(row.description==undefined)row.description = '';
			if(row.additionalname!=undefined)additional_info+='<b>'+row.additionalname+'</b>';
			if(((row['min']!=row['max'])||(row['max']!=1))&&(row['min']!=undefined)&&(row['max']!=undefined)){
				if(row.item_id=='57'){
					row['min']=row['min']*sT.GS.rateDropAdena;
					row['max']=row['max']*sT.GS.rateDropAdena;
				}
				additional_info+=' [<b>'+row['min']+'</b> - <b>'+row['max']+'</b>]';
			}
			additional_info += (row.enchant_level>0)?'<span class="enchant">+'+row.enchant_level+'</span>':'';
			additional_info += (row.count>1)?' ('+row.count +')':'';
			if(row.rcp_flag>0)additional_info += '&nbsp;'+html.a('item.recipe.'+row.item_id,'Recipe','class="recipe"');
			if(row.sll_flag>0)additional_info += '&nbsp;'+html.a('item.sell.'+row.item_id,'Shop','class="shop"');
			if(row.drp_flag>0)additional_info += '&nbsp;'+html.a('item.drop.'+row.item_id,'Drop','class="drop"');
			string.push(html.a('item.main.'+row.item_id,row.name)+additional_info+'<p class="description">'+row.description+'</p>');
		},
		'crystal_type': function(){
			if(row.crystal_count===undefined)row.crystal_count='';
			if(row['crystal_type']!='0'){
				string.push(
					'<img width="11" border="1" style="border-color:black;" src="i/grade_'+row.crystal_type+'.gif"><br>'+
					'<font size="-2">'+row['crystal_count']+'</font>'
				);
			}
		},
		'mp_bonus': function(){
			if(row.mp_bonus>0)string.push(row.mp_bonus);
		},
		'p_dam': function(){
			string.push(row.p_dam+'/'+row.m_dam);
		},
		'soulshots': function(){
			string.push(
				'<span class="x">x</span><span class="soulshots">'+row.soulshots+'</span>'+
				'<span class="x">/x</span><span class="spiritshots">'+row.spiritshots+'</span>'+
				'<span class="x">/</span><span class="mp_consume">'+row.mp_consume+'</span>'
			);
		},
		'char_name': function(){
			string.push(html.a('char.main.'+row.owner_id,row.char_name)+'<br>'+html.h('etc.itemLoc.'+row.loc));
		},
		'merchant_area_name': function(){
			string.push(html.a('areas.main.'+row.merchant_area_id,row.merchant_area_name));
		},
		'type': function(){
			string.push(html.a('items.type.'+row.type));
		},
		'deleteItemPanel': function(){
			string.push(html.pnl('action.item.deleteItem',row));
		},
		'itemPanel': function(){
			if((row.consume_type==='asset')||(row.consume_type==='stackable')){
				string.push('<span style="font-size:11px;">Item Count</span><br>'+html.pnl('action.item.changeItemCount',row));
			} else if(row.crystal_type!='0'){
				string.push('<span style="font-size:11px;">Enchant</span><br>'+html.pnl('action.item.enchantItem',row));
			}
		},
		'delete_from_shop': function(){
			string.push(html.pnl('delete_item_from_shop',row));
		},
		'drop_panel': function(){
			string.push(html.t('item_drop_panel',row));
		}
	},
//MONSTER HANDLERS
	'monster': {
		'mp': null,
		'sweep': null,
		'min': null,
		'max': null,
		'mob_id': null,
		'shop_id': null,
		'boss_flag': null,
		'map_flag': function(){
			if(row.map_flag==1){
				string.push(html.a('map.monster.'+row.mob_id,html.h('etc.mapStatus.loc')));
			} else string.push(html.h('etc.mapStatus.noloc'));
		},
		'name': function(){
			var min_max = (row['min']!=row['max'])?' [<b>'+row['min']+'</b> - <b>'+row['max']+'</b>]':'';
			string.push(html.a('monster.main.'+row.mob_id,row.name)+min_max);
		},
		'aggro': function(){
			string.push((row.aggro>0)?html.h('etc.mobStatus.aggro'):html.h('etc.mobStatus.pssiv'));
		},
		'hp': function(){
			string.push(row.hp+'/'+row.mp);
		},
		'exp': function(){
			string.push(Math.round(row['exp']*sT.GS.rateXp));
		},
		'sp': function(){
			string.push(Math.round(row['sp']*sT.GS.rateSp));
		},
		'sex': function(){
			string.push((row.sex=='1')?'<img src=i/female.gif>':'<img src=i/male.gif>');
		},
		'isUndead': function(){
			if(row.isUndead==0)string.push('<font color="#676A2D" size="-2">Undead</font>');
		}
	},
//SKILL HANDLERS
	'skill': {
		'class_id': null,
		'level': null,
		'description': null,
		'min_level': null,
		'cast_range': null,
		'skill_id': null,
		'char_id': null,
		'class_index': null,
		'name': function(){
			string.push(html.a('skills.skill.'+row.skill_id,'<b>'+row.name+' '+row.level+'</b>'+'<br>')+'<span class="description">'+row.description+'</span>');
		},
		'mp_consume': function(){
			string.push(
				'<span class="mp_consume">'+((row.mp_consume)?row.mp_consume:'0')+'</span> '+
				'<span class="x">/</span> '+
				'<span class="hp_consume">0</span>'+
				'<br>'+
				'<span class="cast_range">'+((row.cast_range!=-1)?row.cast_range:'')+'</span>'
			);
		},
		'setSkillLevelPanel': function(){
			string.push(html.pnl('action.char.skills.setSkillLevel',row));
		},
		'deleteSkillPanel': function(){
			string.push(html.pnl('action.char.skills.deleteSkill',row));
		}
	},
//SERVER HANDLERS
	'server': {
		'sum_level': function(){
			string.push(row.char_count?Math.round(row.sum_level/row.char_count*100)/100:0);
		}
	},
//CASTLE HANDLERS
	'castle': {
		'owner_id': function(){
			string.push(
				(row.owner_id>0)?html.a('clan.main.'+row.owner_id,row.owner_name):'NPC'
			);
		},
		'siegeDate': function(){
			var date=new Date(row.siegeDate/1);
			string.push(
				date.getDate()+' '+html.h('etc.month.'+date.getMonth())+' '+date.getFullYear()+' '+date.getHours()+':'+date.getMinutes()
			);
		},
		'defenders': function(){
			string.push((row.defenders=='')?'NPC':row.defenders);
		},
		'attackers': function(){
			string.push((row.attackers=='')?' - ':row.attackers);
		}
	}
}

