//--------//
// L2JZ  //
//------//
/* 
 * l2jz.cmpFPage(query) -
 *	Функция сравнивает текущий запрос к фрейму с шаблоном query. Обычно она вызывается
 *	в обработчиках страницы, когда обработчик должен по разному вести себя в зависимости
 *	от ситуации и в особенности от предыдущего запроса к этому фрейму. Шаблон это строки
 *	разделённые точками. Вот так например: @back.@any.item.@this Перед сравнением в шаб-
 *	лоне делаются следующие замены строк ограниченных точками:
 *		@back - заменяется на соответствующую по порядку часть предыдущего запроса к
 *						этому фрейму. То-есть если предудущий запрос был: item.main.45239871
 *						а шаблон: @back.drop.@back то текущий запрос будет сравниваться со стро-
 *						кой item.drop.45239871
 *		 @any - заменяется на соответствующую по порядку часть текущего запроса к
 *						этому фрейму. То-есть если предудущий запрос был: item.main.45239871,
 *						текущий запрос item.sell.45239871 а шаблон: @back.@any.@back то текущий
 *						запрос будет сравниваться со строкой item.sell.45239871
 */
var l2jz_h   = {}                 //Хранилище текстовых строк.
var l2jz_tpl = {}                 //Хранилище шаблонов.
var l2jz_pnl = {}                 //Хранилище панелей.
var l2jz_tbl = {}                 //Хранилище таблиц.
var sT = {}                       //Хранилище данных.
var r;                            //Ссылается на результат последнего запроса к серверу.

var mpanel = new Object();        //В поля этого объекта можно загружать дополнительные JS(чтобы не засорять глобальную область переменных)

var l2jz = {
	'modules': {'main': true},   //Массив хранит имена уже загруженных модулей.
	'config': {},                //Хранит всевозможные настройки сгенерированные сервером.
	'funcQueue': new Object(),   //Хранит функции стоящие на очередь в выполнение.
	'busy': false,               //Флаг определяет может-ли система выполнять очередное задание из очереди или нет.
	'frame': 'noFrame',          //Хранит имя фрейма в контексте которого в данный момент всё работает.
	'module': 'main',            //Хранит имя модуля в контексте которого в данный момент всё работает.
	'GS': 0,                     //Хранит номер текущего гейм-сервера.
	'language': 'english',       //Хранит имя текущего языка
	'history': new Array(),      //Хранит историю страниц вызванных пользователем
	'bHistory': new Array(),     //Хранит историю страниц отмотанных пользователем кнопокой назад.
	
	
	'objects': new Object(),     //Хранит контексты сложных элементов страницы(таких как панели, таблицы, меню и.т.д.)
	'objIDcounter': 0,           //Счётчик идентефикаторов
	'getID': function(){
		this.objIDcounter++;
		return 'L2JZOBJID'+this.objIDcounter;
	},
	
	'getObjById': function(objId){
		if(isset(this.objects[objId])){
			return this.objects[objId];
		} else {
			alert('L2JZ: I can not find object with id: '+objId);
		}
	},
	
	'runObjMethod': function(objId,methodName){
		if(!isset(objId))alert('L2JZ.runObjMethod: I need objId!');
		if(!isset(methodName))alert('L2JZ.runObjMethod: I need methodName!');
		if(!isset(this.objects[objId]))alert('L2JZ.runObjMethod: Object '+objId+' does not exist.');
		if(!isset(this.objects[objId]))alert('L2JZ.runObjMethod: Method '+methodName+' does not exist.');
		var argArray = new Array();
		var strArray = new Array();
		for(var i=2;i<arguments.length;i++){
			argArray.push(arguments[i]);
			strArray.push('argArray['+(i-2)+']');
		}
		eval('(this.objects["'+objId+'"]["'+methodName+'"])('+strArray.join(',')+')');
		argArray = null;
	},
	
	'clearObjectsList': function(){
		for(var i in this.objects){
			if(!document.getElementById(i)){
				alert('Deleting: '+i);
				delete this.objects[i];
			}
		}
	},
	
	'checkScriptVersion': function(l2jzVersionId){
		if(l2jzVersionId!=this.config.l2jzVersionId){
			alert(
				'Warning!\n'+
				'Client libs become out of date. Try to refresh page(CTRL+F5).\n'+
				'If you still see this message after refreshing, try to clean your browser cache.'
			);
		}
	},
	
	'addTask': function(frameName,func,codeLevel){
		if(!isset(codeLevel))codeLevel = 0;
		var queuePosition = 0;
		while(queuePosition<l2jz.funcQueue[frameName].length){
			if(codeLevel>l2jz.funcQueue[frameName][queuePosition].codeLevel)break;
			queuePosition++;
		}
		var tempQueue = new Array();
		for(var i=0;i<queuePosition;i++)tempQueue.push(l2jz.funcQueue[frameName].shift());
		tempQueue.push({
			'func': func,
			'codeLevel': codeLevel,
			'module': l2jz.module
		});
		while(l2jz.funcQueue[frameName].length!=0){
			tempQueue.push(l2jz.funcQueue[frameName].shift());
		}
		l2jz.funcQueue[frameName] = tempQueue;
	},

	'clearTasks': function(){
		l2jz.funcQueue[l2jz.frame] = new Array();
		l2jz.setFree();
	},
	
	'setBusy': function(){	
		l2jz_frames[l2jz.frame].busy = true;
		if(document.getElementById('menu_system_indicator')){
			document.getElementById('menu_system_indicator').bgColor = "#CC0033";
		}
	},

	'setFree': function(){
		l2jz_frames[l2jz.frame].busy = false;
		var changeIndicator = true;
		for(var i in l2jz_frames){
			if(l2jz_frames[i].busy==true){
				changeIndicator = false;
			}
		}
		if(changeIndicator)if(document.getElementById('menu_system_indicator')){
			document.getElementById('menu_system_indicator').bgColor = "#339900";
		}
	},
	
	'_checkQueue': function(){
		var frame = '-';
		for(var i in l2jz.funcQueue){
			if((l2jz.funcQueue[i].length!=0)&&(l2jz_frames[i].busy==false)){
				frame = i;
				break;
			}
		}
		if(frame!='-'){
			func = l2jz.funcQueue[frame].shift();
			l2jz.setHandlerContext(frame,func.module);
			(func.func)();
		}
	},
	
	'setHandlerContext': function(frameName,moduleName){
		l2jz.module     = moduleName;
		l2jz.frame      = frameName;
		l2jz.qArrayName = l2jz_frames[l2jz.frame].qArrayName;
		l2jz.qStatus    = l2jz_frames[l2jz.frame].qStatus;
		l2jz.qCount     = l2jz_frames[l2jz.frame].qCount;
	},

	'queryAccess': function(q_link,vars){
		if(!isset(l2jz_q_t[q_link])){
			alert('L2JZ: Trying to run unknown query: '+q_link+'.');
			return false;
		}
		if(Math.round(l2jz_q_t[q_link]['access'])<=Math.round(sT.l2jz_user.builder))return true;
		if(isset(l2jz_q_t[q_link]['sAccess'])){
			var accessFuncName = l2jz_q_t[q_link]['sAccess'];
			if(isset(l2jz.checkAccessSpecial[accessFuncName])){
				return l2jz.checkAccessSpecial[accessFuncName](vars);
			} else {
				return true;
			}
		}
		return false;
	},

	'valueAccess': function(access){
		if(access<=sT.l2jz_user.builder)return true;
		return false;
	},
	
	'checkAccessSpecial': {
		'myAccount': function(vars){
			if(sT.l2jz_user.login===vars.login)return true;
			return false;
		},
		'myChar': function(vars){
			if(isset(sT.GS.chars[vars.char_id]))return true;
			return false;
		}
	},

	'init': function(){
		//Создаём канал клиент<->сервер
		result = new Subsys_JsHttpRequest_Js();
		//Запускаем сборщик мусора
		setInterval(this.clearObjectsList,10000);
		//Запускаем планировщик
		setInterval(l2jz._checkQueue,300);
		//Инициализируем массив состояний фреймов(он используется только для генерации ссылок) и сами фреймы
		l2jz.frames_in_link = new Object();
		for(var i in l2jz_frames){
			l2jz.frames_in_link[i] = 'empty';
			l2jz_frames[i]['log'] = new Array('......','......');
			l2jz_frames[i].busy = false;
			l2jz.funcQueue[i] = new Array();
		}
		//Загружаем язык
		l2jz.addTask('noFrame',function(){doQuery('engine.languageLoader',l2jz.language);});
		//Загружаем шаблоны
		l2jz.addTask('noFrame',function(){doQuery('engine.mloader','main');});
		//Отправляем запрос на вход в систему
		l2jz.addTask('noFrame',function(){doQuery('engine.user.login');});
		//Получаем данные о гейм-сервере и всяческих сущностях принадлежащих аккаунту на этом сервере.
		l2jz.addTask('noFrame',function(){doQuery('engine.changeGS',{'GS':l2jz.GS});});
		//Отрисовываем меню
		l2jz.addTask('noFrame',function(){menu.draw();});
		//Загружаем страницы указанные в url.
		l2jz.addTask('noFrame',function(){
			if(location.hash.length>3){
				var queryArray = location.hash.split('#');
				for(var i in queryArray)if(queryArray[i].length>2){
					doLoad(queryArray[i]);
				}
			} else {
				doLoad('info.welcome');
			}
		});
	},
	
	'setBackLink': function(a){
		if(l2jz.history.length>1)a.href = '#'+l2jz.history[l2jz.history.length-2]; 
	},
	
	'setForwardLink': function(a){
		if(l2jz.bHistory.length!=0)a.href = '#'+l2jz.history[l2jz.history.length-1]; 
	},
	
	'goBack': function(){
		if(l2jz.history.length<2)return;
		l2jz.bHistory.push(l2jz.history.pop());
		doLoad(l2jz.history.pop());
	},
	
	'goForward': function(){
		if(l2jz.bHistory.length==0)return;
		doLoad(l2jz.bHistory.pop());
	},

	'cmpFPage': function(query){
		var f_name = l2jz.frame;
		var frameNow  = l2jz_frames[f_name]['log'].pop();
		var frameBack = l2jz_frames[f_name]['log'].pop();
		l2jz_frames[f_name]['log'].push(frameBack);
		l2jz_frames[f_name]['log'].push(frameNow);
		frameNow   = frameNow.split('.');
		frameBack  = frameBack.split('.');
		var qArray = query.split('.');
		for(var i in qArray){
			switch(qArray[i]){
				case"@any":
				break;
				case"@back":
					if(frameNow[i]!=frameBack[i])return false;
				break;
				default:
					if(frameNow[i]!=qArray[i])return false;
			}
		}
		return true;
	}
}

