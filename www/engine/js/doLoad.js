//----------//
// doLoad  //
//--------// 
/* */
function doLoad(query){
	//разбор query и выделение аргументов
	var vars = new Object();
	var vars_array = new Array();
	var qArray = query.split('.');
	while(1){
		if(qArray.length==0){alert('doLoad: Invalid page "'+query+'"(no such page).');return;}
		if(isset(l2jz_p_t[qArray.join('.')]))break;
		vars_array.push(qArray.pop());
	}
	var q_link = qArray.join('.');	
	var page = l2jz_p_t[q_link];
	var pName = vars['l2jz_query'] = q_link;
	var varsList = (page.arguments)?page.arguments.split(','):(new Array());
	for(var i in varsList){
		if(vars_array.length==0){alert('doLoad: No data for "'+varsList[i]+'" variable for page "'+pName+'".');return;}
		vars[varsList[i]] = vars_array.pop();
	}
	if(vars_array.length!=0){alert('doLoad: I got too many arguments for page "'+pName+'".');return;}
	//проверяем уровень доступа
	if(isset(page.queryLinks))for(var i in page.queryLinks){
		var queryLink = '';
		try {
			queryLink = eval(page.queryLinks[i]);
		} catch(e){
			alert('doLoad: The page "'+pName+'" is using this code as first argument of doQuery:\n   '+page.queryLinks[i]+'\nI am sorry, but i can\'t undestand, what query is it. Here is an error:\n'+e);
		}
		if(!l2jz.queryAccess(queryLink,vars)){
			menu.message('Access denied for page <b>'+pName+'</b> (<b>'+queryLink+'</b> query).');
			return 0;
		}
	}
	
	//проверяем, загружен-ли необходимый для страницы модуль
	if(!isset(l2jz.modules[page.module])){
		l2jz.addTask('noFrame',function(){doQuery('engine.mloader',page.module);});
		l2jz.addTask('noFrame',function(){l2jz.modules[page.module]=true;});
		l2jz.addTask('noFrame',function(){doLoad(query);});
		return 0;
	}
	l2jz.setHandlerContext(page.frame,page.module);
	//изменяем состояние фреймов и сохраняем эти изменения.
	var f_name = page.frame;
	if(l2jz_frames[f_name]['addToUrl']=='TRUE'){
		l2jz.frames_in_link[f_name] = query;
	}
	if(l2jz_frames[f_name]['history']=='TRUE'){
		l2jz.history.push(query);
	}
	l2jz_frames[f_name]['log'].push(query);
	
	//вызываем обработчик фрейма если он есть.
	if(l2jz_frames[f_name]['handler']){
		try{
			eval(l2jz_frames[f_name]['handler']);
		}catch(e){
			alert('FRAME['+f_name+']\nHANDLER:\n'+l2jz_frames[f_name]['handler']+'\nHANDLER ERROR:\n'+e);
		}
	}
	
	//вызываем обработчик страницы
	if(page.handler){
		try{
			eval(page.handler);
		}catch(e){
			alert('PAGE['+pName+']\nHANDLER:\n'+page.handler+'\nHANDLER ERROR:\n'+e);
		}
	}
}