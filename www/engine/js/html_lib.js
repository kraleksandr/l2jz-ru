//------------//
// HTML LIB  //
//----------//
/* html.a - генератор ссылок на страницы системы.
 *	АРГУМЕНТЫ:
 *		query -
 *			Путь к странице. Вся система это дерево страниц и к каждой есть путь. Страницы зада-
 *			ются в config/pages_tree.xml
 *		name -
 *			HTML код, который будет вставлен в тэг <a></a>. Вот так: <a>name</a>
 *		html (необязательный параметр) -
 *			HTML код, который будет вставлен в тэг <a></a>. Вот так: <a html></a>
 *		/return
 *			HTML код полученной ссылки. Это тег <a></a> со всякими хитрыми штуками внутри.
 *
 *
 * html.t - шаблонизатор который собирает из HTML шаблонов готовый для вывода в браузер код.
 *	АРГУМЕНТЫ:
 *		templateName - 
 *			Имя шаблона. Шаблон это HTML код со специальными вставками, которые будут динамичес-
 *			ки заменяться в зависимоти от входного массива.
 *		a (необязательный параметр) -
 *			Массив в соответсвие с которым будут производиться замены.
 *		targetDiv (необязательный параметр) -
 *			Задаёт <div id="targetDiv">...</div> тэг в который будет помещён результат.
 *		/return
 *			Полученный из шаблона текст.
 *	@:java_script_code:@
 *		java_script_code выполняется как JavaScript код. Фрагмент заменяется на результат рабо-
 *		ты этого кода. Для этого кода определён специальный массив a который был переден в шаб-
 *		лонизатор.
 *
 *
 * html.tSys - упрощённая версия шаблонизатора.
 *	АРГУМЕНТЫ:
 *		template - 
 *			шаблон.
 *		array(необязательный параметр) - 
 *			массив замен.
 *
 *
 *
 * html.aTabs
 *		 _______   _______   ______
 *		| PAGE1 |_| PAGE2 |_| HOME |___________________
 *		|                                              |
 *		|             tContainer                       |
 *		|______________________________________________|
 *	Функция генерирует меню табов. Табы представляют из себя обычные ссылки на страницы системы.
 *	Таб меню само перерисовывает табы-закладки и выделяет активный таб но не заполняет своё содер-
 *	жимое. Вместо этого она передаёт обработчику страницы глобальную переменную tContainer которая
 *	содержит id <div> тэга c содержимым таб меню.
 *	АРГУМЕНТЫ:	
 *		menuName
 *			Имя меню.
 *		active
 *			Имя начального активного таба.
 *		target_div (необязательный параметр) -
 *			Задаёт <div id="target_div">...</div> тэг в который будет помещён результат.
 *		/return
 *			Полученный HTML код таб меню.
 */
var html = new Object();


html.a2 = function(query,name){
	var aRow = {
		'class': 'aLink'
	}
	switch(typeof(name)){
		case"string":
			aRow.innerHTML = name;
		break;
		case"object":
			for(var i in name)aRow[i] = name[i];
		break;
	}
	if(!aRow.innerHTML)aRow.innerHTML = html.tSys(html.h2('page.'+query+'.linkName'));
	if(!aRow.tooltip){
		var tooltip = html.h2('page.'+query+'.tooltip');
		if(tooltip!='tooltip'){
			aRow.tooltip = new l2jzTooltip(html.tSys(html.h2('page.'+query+'.tooltip')));
		}
	}
	
	return '<a '+
				'href="#" '+
				'onClick="doLoad(\''+query+'\')" '+
				'OnMouseDown="html._doSetLink(this,\''+query+'\')" '+
				'class="'+aRow['class']+'" '+
				((aRow.tooltip)?(aRow.tooltip.htmlCode):'')+
			'><font class="aName">'+aRow.innerHTML+'</font></a>';
}

html.a = function(query,name,aHtml){
	if(!name)name = html.h2('page.'+query+'.linkName');
	if(!aHtml)aHtml = '';
	return '<a href="#" onClick="doLoad(\''+query+'\')" OnMouseDown="html._doSetLink(this,\''+query+'\')" '+aHtml+'>'+name+'</a>';
}

html.aButton = function(query,name,html){
	if(name==undefined)name='';
	if(html==undefined)html='';
	return '<div class="abutton"><a href="#" onClick="doLoad(\''+query+'\')" OnMouseDown="html._doSetLink(this,\''+query+'\')" '+html+'>'+name+'</a></div>';
}

html.aTabs = function(menuName,active,targetDiv){
	tContainer = html.ID.set('tContainer');
	var s = '<div name="tab_menu_'+menuName+'" style="position:relative"><ul class="tabset_tabs"><li>';
	var firstTab = true;
	for(var i in menu[menuName]){
		s += '<a href="#"'+ 
		     	'onClick="tContainer=\''+html.ID.get('tContainer')+'\';html._doSetTabs(\''+menuName+'\',this,\''+i+'\');doLoad(\''+menu[menuName][i]['page']+'\')"'+
		     	'OnMouseDown="html._doSetLink(this,\''+menu[menuName][i]['page']+'\')" '+
		     	'name="tab" '+((firstTab)?'style="border-left:1px solid #636563;"':'')+' '+
		     	((i==active)?'class="active"':'')+
		     '>'+html.h2('page.'+menu[menuName][i]['page']+'.linkName')+'</a>';
			 firstTab = false;
	}
	s += '</li></ul><div class="menu" id="'+html.ID.get('tContainer')+'">'+
			((menu[menuName][active]['template'])?html.t(menu[menuName][active]['template']):'')+
		 '</div></div>';
	if(targetDiv){
		if(document.getElementById(targetDiv)){
			document.getElementById(targetDiv).innerHTML = s;
		} else alert('No such section:'+targetDiv);
	}
	return s;
}

html.aList = function(query,lArray,delimeter,targetDiv){
	var s = new Array();
	for(var i in lArray)s.push(
		html.a(
			query+'.'+lArray[i],
			html.tSys(
				html.h2('page.'+query+'.'+lArray[i]+'.linkName'),
				{'id':lArray[i]}
			)
		)
	);
	s = s.join(delimeter);
	if(targetDiv){
		if(document.getElementById(targetDiv)){
			document.getElementById(targetDiv).innerHTML = s;
		} else alert('No such section:'+targetDiv);
	}
	return s;
}

html._t_reg = new RegExp(/@:([^@]*?):@/gm);
html.t = function(tName,a,targetDiv){
	if(l2jz_tpl[l2jz.module+'.'+tName]){
		tName = l2jz.module+'.'+tName;
	} else if(l2jz_tpl['main.'+tName]){
		tName = 'main.'+tName;
	} else if(l2jz_tpl[tName]){
		//Нам был дан полный путь к панели.
	} else {
		alert('Can\'t find template "'+tName+'".');
		return '';
	}
	if((a==null)||(a==undefined))a = new Object();
	var s = l2jz_tpl[tName].replace(html._t_reg,function(str,val){
		var t_s;
		try {
			t_s = eval(val);
		} catch (e) {
			alert('CODE:\n'+val+'\nERROR:\n'+e);
		}
		return (t_s)?t_s:'';
	});
	if(targetDiv){
		if(document.getElementById(targetDiv)){
			document.getElementById(targetDiv).innerHTML = s;
		} else alert('templateMaker: No such section: '+targetDiv);
	}
	return s;
}

html.tSys = function(template,a){
	if((a==null)||(a==undefined))a = new Object();
	return template.replace(html._t_reg,function(str,val){return eval(val);});
}

html.pnl = function(pName,row,targetDiv){
	if(l2jz_pnl[l2jz.module+'.'+pName]){
		pName = l2jz.module+'.'+pName;
	} else if(l2jz_pnl['main.'+pName]){
		pName = 'main.'+pName;
	} else if(l2jz_pnl[pName]){
		//Нам был дан полный путь к панели.
	} else {
		alert('Can\'t find panel "'+pName+'".');
		return '';
	}
	if(isset(targetDiv)){
		document.getElementById(targetDiv).innerHTML = control[l2jz_pnl[pName].panelType](pName,row);
	} else {
		return control[l2jz_pnl[pName].panelType](pName,row);
	}
}

html.jumpTo = function(div){
	var y = 0;
	if(div){
		if(!document.getElementById(div))return;
		obj = document.getElementById(div);
		while(obj){
			y+=obj.offsetTop;
			obj=obj.offsetParent;
		}
	} 
	window.scroll(0,y);
}


html.setSection = function(section,text){
	if(document.getElementById(section))document.getElementById(section).innerHTML = text;
}

html.getSection = function(section){
	return document.getElementById(section).innerHTML;
}

html.moveSection = function(sourse,target){
	document.getElementById(target).innerHTML = document.getElementById(sourse).innerHTML;
}

html.clearSection = function(section){
	document.getElementById(section).innerHTML = '';
}

html.loadImage = function(src){
	var image = new Image();
	image.src = src;
}

html._doSetLink = function(a,query){
	var qArray = query.split('.');
	while(1){
		if(qArray.length==0){alert('doLoad: Invalid page "'+query+'"(no such page).');return;}
		if(isset(l2jz_p_t[qArray.join('.')]))break;
		qArray.pop();
	}
	var q_link = qArray.join('.');
	var f_array = clone(l2jz.frames_in_link);	
	var f_name = l2jz_p_t[q_link]['frame'];
	if(l2jz_frames[f_name]['addToUrl']=='TRUE')f_array[f_name] = query;
	q_link = "#";
	for(var i in f_array)if(f_array[i]!='empty')q_link += f_array[i]+"#";
	a.href = q_link;
}

html._doGetLink = function(a){
	var q_link = "#";
	for(var i in l2jz.frames_in_link)if(l2jz.frames_in_link[i]!='empty')q_link += l2jz.frames_in_link[i]+"#";
	a.href = q_link;
}

html._doSetTabs = function(menuName,a,tab){
	var li = a.parentNode;
	for(var i=0;t_tab=li.childNodes[i];i++)t_tab.className = '';
	a.className = 'active';
	if(menu[menuName][tab]['template']){
		html.t(menu[menuName][tab]['template'],null,tContainer)
	}
}

html._doSaveHtml = function(s,target_div,save_mode){
	if(target_div!=undefined){
		if(save_mode==undefined)save_mode = '=';
		switch(save_mode){
			case '=':
				document.getElementById(target_div).innerHTML = '';
				document.getElementById(target_div).innerHTML = s;
			break;
			case '+':document.getElementById(target_div).innerHTML += s;
			break;
		}	
	}
	return s;
}

/*
	query - 
		имя строки текста которую надо получить.
	return -
		Строка текста из lng.xml файла.
	Строка ищется по следующему алгоритму:
		h[' имя1.    имя2.    имя3.    имя4.    имя5.    имя6    ']
		h[' имя1.    имя2.    имя3.    имя4.    имя5.    default ']
		h[' имя1.    имя2.    имя3.    имя4.    default. имя6    ']
		h[' имя1.    имя2.    имя3.    default. имя6             ']
		h[' имя1.    имя2.    default. имя6                      ']
		h[' имя1.    default. имя6                               ']
	Если все эти элементы отсутсвуют, возвращается имя6.
*/
html.h = function(query){
	var elems = query.split('.');
	var elem = elems.pop();
	if(l2jz_h[query]!=undefined)return l2jz_h[query];
	query = elems.join('.')+'.default';
	if(l2jz_h[query]!=undefined)return l2jz_h[query];
	elems.pop();
	while(elems.length>0){
		query = elems.join('.')+'.default.'+elem;
		if(l2jz_h[query]!=undefined)return l2jz_h[query];
		elems.pop();
	}
	return elem;
}

/*
	query - 
		имя строки текста которую надо получить.
	return -
		Строка текста из lng.xml файла.
	Строка ищется по следующему алгоритму:
		h[' имя1.    имя2.    имя3.    имя4.    имя5.    имя6    ']
		h[' имя1.    имя2.    имя3.    имя4.    имя6             ']
		h[' имя1.    имя2.    имя3.    имя6                      ']
		h[' имя1.    имя2.    имя6                               ']
		h[' имя1.    имя6                                        ']
	Если все эти элементы отсутсвуют, возвращается имя6.
*/
html.h2 = function(query){
	var elems = query.split('.');
	var elem = elems.pop();
	while(elems.length>0){
		if(l2jz_h[elems.join('.')+'.'+elem]!=undefined)return l2jz_h[elems.join('.')+'.'+elem];
		elems.pop();
	}
	return elem;
}

html.getX = function(div){
	var x = 0;
	obj = document.getElementById(div);
	while(obj){
		x+=obj.offsetLeft;
		obj=obj.offsetParent;
	} 
	return x;
}

html.getY = function(div){
	var y = 0;
	obj = document.getElementById(div);
	while(obj){
		y+=obj.offsetTop;
		obj=obj.offsetParent;
	}
	return y;
}


html.ID = new Object();
html.ID.current_id = 0;
html.ID.ids_array = new Object();
html.ID.get = function(id_name){
	return html.ID.ids_array[id_name];
}
html.ID.set = function(id_name){
	html.ID.current_id++;
	html.ID.ids_array[id_name] = 'id_factory_'+html.ID.current_id;
	return html.ID.ids_array[id_name];
}
