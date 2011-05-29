//------------------//
// PANEL FUNCTIONS //
//----------------//
/* JS функции отвечающие за отрисовку панелей.
 */
var control = new Object();
control.fieldHtml = new Object();

control.timer = null;

control._panel = function(pName,row){
	if(row==null||row==undefined)row = new Object();
	var panel = {
		'pName':     pName,
		'template':  pName,
		'class':     'panel',
		'onClick':   null,
		'onChange':  null,
		'onChangeT': 0,
		'hasButton': true,
		'fields':    new Object(),  //здесь хранятся свойства полей панели
		'fHTML':     new Object(),  //здесь хранятся html коды всех видимых полей панели
		'fName':     new Object(),  //здесь хранятся названия всех видимых полей панели
		'endHtml':   '</form>'
	}
	var pnl = l2jz_pnl[pName];
	if(pnl['fields']==null)pnl['fields'] = new Object();
	
	//устанавливаем свойства панели.
	for(var i in pnl)switch(i){
		case"fields":case"queryLinks":
		break;
		case"onAny":
			panel['onClick'] = panel['onChange'] = pnl[i];
		break;
		default:
			panel[i] = pnl[i];
	}
	panel.beginHtml = '<form onSubmit="return false" id="'+html.ID.set('panel')+'" class="'+panel['class']+'">';
	
	//проверяем уровень доступа
	if(pnl.queryLinks)for(var i in pnl.queryLinks){
		try {
			var queryLink = eval(pnl.queryLinks[i]);
		} catch(e){
			alert('panelMaker: The panel "'+pName+'" is using this code as first argument of doQuery:\n   '+pnl.queryLinks[i]+'\nI am sorry, but i can\'t undestand, what query is it. Here is an error:\n'+e);
		}
		if(!l2jz.queryAccess(queryLink,row))return null;
	}
	
	//если у панели нет кнопки, добавляем дефолтовую.
	var addButton = (panel['hasButton']=='FALSE')?false:true;
	for(var i in pnl['fields']){
		if((pnl['fields'][i]['type']=='button')||(pnl['fields'][i]['type']=='image')){
			addButton = false;
		}
	}
	if(addButton)pnl['fields'][pnl['fields'].length] = {
		'html': '',
		'name': 'button',
		'value': 'button',
		'type': 'button'
	}
	
	//устанавливаем свойства полей панели.
	for(var i in pnl['fields']){
		var fName = pnl['fields'][i]['name'];
		panel['fields'][fName] = {
			'html':      '',
			'class':     pnl['fields'][i]['type'],
			'value':     (row[fName])?row[fName]:'',
			'onClick':   panel['onClick'],
			'onChange':  panel['onChange'],
			'onChangeT': panel['onChangeT']
		}
		for(var name in pnl['fields'][i]){
			var value = pnl['fields'][i][name];
			switch(name){
				case"value":
					panel['fields'][fName][name] = html.tSys(value,row);
				break;
				default:
					panel['fields'][fName][name] = value;
			}
		}
	}
	//генерируем html код полей
	for(var fName in panel['fields']){
		var fType = panel['fields'][fName]['type'];
		switch(fType){
			case"hidden":
				panel['beginHtml'] += control.fieldHtml[fType](panel,fName);
			break;
			default:
				panel['fHTML'][fName] = control.fieldHtml[fType](panel,fName);
				panel['fName'][fName] = html.h('panel.'+pName+'.'+fName);
		}
	}
	panel.panelName = html.h('panel.'+pName);
	return panel;
}

control._panelAction = function(pName,pID,fName,actionType){
	if(control.timer)clearTimeout(control.timer);
	var interval = 0;
	if(actionType=='onChange'){
		if(l2jz_pnl[pName]['fields'][fName].onChangeT){
			interval = l2jz_pnl[pName]['fields'][fName].onChangeT;
		} else if(l2jz_pnl[pName].onChangeT){
			interval = l2jz_pnl[pName].onChangeT;
		}
	}
	if(interval>0){
		control.timer = setTimeout(
			function(){control.handler(pName,pID,fName,actionType);},
			interval
		);
	} else {
		control.handler(pName,pID,fName,actionType);
	}
}

control.handler = function(pName,pID,fName,actionType){
	var vars = new Object();
	var elements = document.getElementById(pID).elements;
	for(var i=0;i<elements.length;i++)switch(elements[i].type){
		case"checkbox":
			if(elements[i].checked)vars[elements[i].name] = elements[i].checked;
		break;
		default:
			vars[elements[i].name] = elements[i].value;
	}
	
	//Делаем проверку полей формы
	for(var i in l2jz_pnl[pName]['fields']){
		var fName = l2jz_pnl[pName]['fields'][i]['name'];
		var fValue = vars[i];
		var fArray = {
			'fName': html.h('panels.'+pName+'.'+fName)
		}
		for(var attrName in l2jz_pnl[pName]['fields'][i]){
			var attrValue = fArray.attrValue = l2jz_pnl[pName]['fields'][i][attrName];
			var isError = false;
			switch(attrName){
				case"minlength":
					if(fValue.length<attrValue)isError = true;
				break;
				case"equal":
					if(fValue!=vars[attrValue])isError = true;
				break;
				case"email":
					if(!fValue.match(/^[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,4}$/i))isError = true;
				break;
			}
			if(isError){
				if(actionType=='onClick'){
					menu.message(html.tSys(html.h('panel.'+pName+'.'+attrName+'Error'),fArray));
				}
				return 0;
			}
		}
	}
	
	//Формируем среду выполнения обработчика
	l2jz.setHandlerContext('noFrame',l2jz_pnl[pName]['module']);
	
	//Ищем обработчик.
	var handler = false;
	if(isset(l2jz_pnl[pName]['fields'][fName])){
		if(isset(l2jz_pnl[pName]['fields'][fName][actionType])){
			handler = l2jz_pnl[pName]['fields'][fName][actionType];
		}
	}
	if(!handler)if(isset(l2jz_pnl[pName][actionType])){
		handler = l2jz_pnl[pName][actionType];
	} else if(isset(l2jz_pnl[pName]['onAny'])){
		handler = l2jz_pnl[pName]['onAny'];
	}
	
	//Выполняем обработчик.
	try{
		eval(handler);
	}catch(e){
		alert('ERROR:\n'+e);
	}
}

control.fieldHtml.onKeyUp = function(panel,fName){
	return 'onKeyUp="control._panelAction('+
	          '\''+panel['pName']+'\','+
	          '\''+html.ID.get('panel')+'\','+
	          '\''+fName+'\','+
	          '\'onChange\''+
	       ')" ';
}

control.fieldHtml.onChange = function(panel,fName){
	return 'onChange="control._panelAction('+
	          '\''+panel['pName']+'\','+
	          '\''+html.ID.get('panel')+'\','+
	          '\''+fName+'\','+
	          '\'onChange\''+
	       ')" ';
}

control.fieldHtml.onClick = function(panel,fName){
	return 'onClick="control._panelAction('+
	          '\''+panel['pName']+'\','+
	          '\''+html.ID.get('panel')+'\','+
	          '\''+fName+'\','+
	          '\'onClick\''+
	       ')" ';
}

control.fieldHtml.hidden = function(panel,fName){
	return '<input type="hidden" '+
	          'name="'+panel['fields'][fName]['name']+'" '+
	          'value="'+panel['fields'][fName]['value']+'"'+
	       '/>';
}

control.fieldHtml.text = function(panel,fName){
	return '<input type="text" '+ 
	          'name="'+panel['fields'][fName]['name']+'" '+
	          'value="'+panel['fields'][fName]['value']+'" '+
	          ((panel['fields'][fName]['onChange'])?control.fieldHtml.onKeyUp(panel,fName):'')+
	          'class="'+panel['fields'][fName]['class']+'" '+
	          panel['fields'][fName]['html']+
	       '/>';
}

control.fieldHtml.pass = function(panel,fName){
	return '<input type="password" '+ 
	          'name="'+panel['fields'][fName]['name']+'" '+
	          'value="'+panel['fields'][fName]['value']+'" '+
	          ((panel['fields'][fName]['onChange'])?control.fieldHtml.onKeyUp(panel,fName):'')+
	          'class="'+panel['fields'][fName]['class']+'" '+
	          panel['fields'][fName]['html']+
	       '/>';
}

control.fieldHtml.select = function(panel,fName){
	var optionList = '';
	var optionArray = new Object();
	var defaultOption = panel['fields'][fName]['value'];
	var hLink = (isset(panel['fields'][fName]['hLink']))?panel['fields'][fName]['hLink']:('panel.'+panel.pName+'.'+fName);
	try{
		eval(panel['fields'][fName]['optionMaker']);
	}catch(e){
		alert('ERROR OF SELECT optionMaker:\n'+e);
	}
	for(var i in optionArray){
		if(i==defaultOption){
			optionList += '<option value="'+i+'" selected>'+optionArray[i]+'</option>';
		} else {
			optionList += '<option value="'+i+'">'+optionArray[i]+'</option>';
		}
	}
	return '<select '+
	          'name="'+panel['fields'][fName]['name']+'" '+
	          ((panel['fields'][fName]['onChange'])?control.fieldHtml.onChange(panel,fName):'')+
	          'class="'+panel['fields'][fName]['class']+'" '+
	          panel['fields'][fName]['html']+
	       '>'+optionList+'</seclect>';
}

control.fieldHtml.checkbox = function(panel,fName){
	return '<input type="checkbox" '+
	          'name="'+panel['fields'][fName]['name']+'" '+
	          'value="'+panel['fields'][fName]['value']+'" '+
	          ((panel['fields'][fName]['onChange'])?control.fieldHtml.onKeyUp(panel,fName):'')+
	          'class="'+panel['fields'][fName]['class']+'" '+
	          panel['fields'][fName]['html']+
	       '/>';
}

control.fieldHtml.button = function(panel,fName){
	return '<input type="submit" '+
	          'name="'+panel['fields'][fName]['name']+'" '+
	          'value="'+html.h('panel.'+panel['pName']+'.'+fName)+'" '+
	          ((panel['fields'][fName]['onClick'])?control.fieldHtml.onClick(panel,fName):'')+
	          'class="'+panel['fields'][fName]['class']+'" '+
	          panel['fields'][fName]['html']+
	       '/>';
}

control.fieldHtml.image = function(panel,fName){
	return '<input type="image" '+
	          'name="'+panel['fields'][fName]['name']+'" '+
	          ((panel['fields'][fName]['onClick'])?control.fieldHtml.onClick(panel,fName):'')+
	          'class="'+panel['fields'][fName]['class']+'" '+
	          panel['fields'][fName]['html']+
	       '/>';
}



control.panel = function(pName,row){
	var panelData = control._panel(pName,row);
	if(panelData===null)return '';
	panelData.header = panelData.fields = '';
	for(var fName in panelData.fHTML)if(fName!='button'){
		panelData.header += '<td>'+panelData.fName[fName]+'</td>';
		panelData.fields += '<td>'+panelData.fHTML[fName]+'</td>';
	}
	return panelData['beginHtml']+html.t('panel',panelData)+panelData['endHtml'];
}

control.tpanel = function(pName,row){
	var panelData = control._panel(pName,row);
	if(panelData===null)return '';
	return panelData['beginHtml']+html.t(panelData['template'],panelData)+panelData['endHtml'];
}


control.lpanel = function(pName,row,target_div,save_mode){
	var panelData = control._panel(pName,row);
	if(panelData===null)return '';
	var code = '';
	for(var i in panelData['fHTML']){
		code += ('<td>'+panelData['fHTML'][i]+'</td>');
	}
	return panelData['beginHtml']+'<table border="0" cellpadding="0" cellspacing="0"><tr>'+code+'</tr></table>'+panelData['endHtml'];
}


control.button = function(pName,row,target_div,save_mode){
	var panelData = control._panel(pName,row);
	if(panelData===null)return '';
	var code = '';
	for(var i in panelData['fHTML'])code += panelData['fHTML'][i];
	return panelData['beginHtml']+code+panelData['endHtml'];
}
l2jz.checkScriptVersion('bc8fdb5dc8e4ba0');