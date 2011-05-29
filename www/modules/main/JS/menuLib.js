//-------------//
// MAIN MENU  //
//-----------//
/* Эта библиотека отвечает за отрисовку главного меню и
 * его отдельных частей.
 */
var menu = new Object();
menu.main_menu = {
		'lserver': 0,
		'server': 0,
		'castles': 0,
		'chars': 0,
		'accounts': 10,
		'clans': 0,
		'items': 0,
		'monsters': 0,
		'skills': 0
};


menu.item_tab_menu = {
	'armor': {
		'template': 'main.topMenu.items.armor',
		'page': 'top_menu.items.armor'
	},
	'weapon': {
		'template': 'main.topMenu.items.weapon',
		'page': 'top_menu.items.weapon'
	},
	'accessories': {
		'template': 'main.topMenu.items.accessorie',
		'page': 'top_menu.items.accessories'
	},
	'recipes': {
		'template': 'main.topMenu.items.recipe',
		'page': 'top_menu.items.recipes'
	},
	'others': {
		'template': 'main.topMenu.items.etcitem',
		'page': 'top_menu.items.others'
	},
	'sets': {
		'template': 'main.topMenu.items.sets',
		'page': 'top_menu.items.sets'
	},
	'luxor': {
		'template': 'main.topMenu.items.luxor',
		'page': 'items.luxor'
	}
};

menu.draw = function(){
	var array = new Object();
	//отрисовываем пункты меню.
	array['menu_sections'] = '';
	for(var section in menu.main_menu){
		if(sT.l2jz_user.builder>=menu.main_menu[section]){
			array['menu_sections'] += html.t('main.mainMenu.sections.'+section);
		}
	}
	html.t('mainMenu.main',array,'mainMenuSection');
	html.t('navigation',array,'navigationSection');
	if(result.responseText!=null)menu.message(result.responseText);
}

menu.showAddress = function(query){
	elems = query.split('.');
	for(var i in elems)elems[i] = html.a(query,'<font style="font-size: 10px;color:#D49019">'+elems[i]+'</font>');
	html.setSection('address_section',elems.join('&nbsp;&raquo;&nbsp;'));
}

menu.message = function(str){
	if((document.getElementById('l2jz_message'))&&(str!='')){
		document.getElementById('l2jz_message').innerHTML = str;
	}
}

menu.clearMessage = function(){
	html.clearSection('l2jz_message');
}


l2jz.checkScriptVersion('bc8fdb5dc8e4ba0');