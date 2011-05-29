 castlesEngine = {
	'getCastleData': function(castleId){
		var castle = {
			'attackers': '',
			'defenders': ''
		}
		for(var i in sT['castles.main'])if(sT['castles.main'][i]['castle_id']==castleId){
			var row = sT['castles.main'][i];
			for(var j in row){
				switch(j){
					case"0":
						castle.defenders += html.a('clan','main',row.clan_id,row.clan_name)+'<br>';
					break;
					case"1":
						castle.attackers += html.a('clan','main',row.clan_id,row.clan_name)+'<br>';
					break;
					default:
						castle[j] = row[j];
				}
			}
		}
		return castle;
	},

	'drawTable': function(){
		var string = new Array();
		for(var castleID=1;castleID<8;castleID++){
			var castle = this.getCastleData(castleID);
			string.push(
				(new l2jzTable(
					'castle.entity',
					{
						tplName:    'castle',
						dataSourse: this.getCastleData(castleID),
						div: 'innerHTML'
					}
				)).innerHTML
			);
		}
		html.setSection('mainSection',string.join(''));
	},
	
	'drawMap': function(){
		html.t('castlesMap',null,'mainSection');
		for(var castleID=1;castleID<8;castleID++){
			new l2jzTable(
				'castle.entity',
				{
					tplName:    'castleMapInfo',
					dataSourse: this.getCastleData(castleID),
					div:        'castles_on_map_info_'+castleID
				}
			);
		}
	},
	
	'show_castle': function(castleID){
		for(var i=0;castle=document.getElementsByName('castle_on_map').item(i);i++)castle.style.visibility="hidden";
		document.getElementById('castle_on_map_'+castleID).style.visibility="visible";
		html.moveSection('castles_on_map_info_'+castleID,'castles_on_map_info');
	},
	
	'hide_castles': function(){
		for(var i=1;i<=7;i++)document.getElementById('castle_on_map_'+i).style.visibility="hidden";
		html.clearSection('castles_on_map_info');
	}
}
l2jz.checkScriptVersion('bc8fdb5dc8e4ba0');