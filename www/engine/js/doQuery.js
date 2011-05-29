//-----------//
// doQuery  //
//---------//
/* doQuery(query,_vars) - 
 *	doQuery делает запрос серверу, получает от него данные и, если для этого запроса задан
 *	обработчик исполняет его. Также doQuery может особым образом сохранять данные полученные
 *	от сервера для последующего использования, кешировать запросы к серверу и делать ещё некоторые
 *	вещи. Более подробно о настройках запросов можно почитать в config/query_tree.xml
 *		query -
 *			Имя запроса. Например 'items.drop', 'engine.ploader.welcome', 'action.login_user' и.т.д. Все зап-
 *			росы описаны в config/query_tree.xml.
 *		_vars -
 *			Одномерный ассоциативный массив. Будет доступен php обработчику на стороне сервера через $_REQUEST

 */
function doQuery(query,_vars){
	var varCount = 0;
	var firstVarName = null;
	if(isset(l2jz_q_t[query]['vars']))for(var i in l2jz_q_t[query]['vars']){
		firstVarName = i;
		break;
	}
	//разбираем входные данные
	if(!isset(l2jz_q_t[query])){alert('Unknown query:"'+query+'".');return;}
	switch(typeof(_vars)){
		case"undefined":
			var vars = new Object();
		break;
		case"object":
			var vars = clone(_vars);
		break;
		default:
			var vars = new Object();
			if(firstVarName!=null)vars[firstVarName] = _vars;
	}
	vars.l2jz_query = query;
	//определяем обработчик загрузки запроса
	result.onreadystatechange = function(){
		if(result.readyState == 4)if(result.responseJS){
			var query      = l2jz_frames[l2jz.frame].queryName;
			var vars       = clone(l2jz_frames[l2jz.frame].queryVars);
			var status     = result.responseJS.status;
			var fullStatus = isset(status.statusCode)?(status.status+':'+status.statusCode):status.status;
			l2jz_frames[l2jz.frame].qStatus = clone(status);
			l2jz_frames[l2jz.frame].qCount  = status.count;
			//Преобразовываем полученные данные
			if(isset(l2jz_q_t[query]['saveJS'])&&(l2jz_q_t[query]['saveJS']!='')){
				var saveMode = isset(l2jz_q_t[query]['saveMode'])?l2jz_q_t[query]['saveMode']:'=';
				var arrayName = html.tSys(l2jz_q_t[query]['saveJS'],vars);
				l2jz_frames[l2jz.frame].qArrayName = arrayName;
				switch(status.dataType){
					case"mixed":
						if(!isset(sT[arrayName]))sT[arrayName] = new Object();
						switch(saveMode){
							case"+":
								for(var i in result.responseJS.result){
									sT[arrayName][i]=clone(result.responseJS.result[i]);
								}
							break;
							case"=":
								sT[arrayName] = clone(result.responseJS.result);
							break;
						}
					break;
					case"sqlRows":
						sT[arrayName] = new Array();
						for(var i in result.responseJS.result['body']){
							sT[arrayName][i] = new Object();
							for(var j in result.responseJS.result.head){
								sT[arrayName][i][result.responseJS.result.head[j]] = result.responseJS.result['body'][i][j];
							}
						}
						if((status.count==0)&&(status.status=='ok'))status.status='empty';
					break;
					case"error":
						//ничего не делаем
					break;
					default:
						alert("doQuery: Unknown data type: "+status.dataType);
				}
			}
			result.caching = false;
			r = (arrayName)?sT[arrayName]:result.responseJS.result;
			html.setSection('query_time_section',Math.round(result.responseTime*1000)/1000);
			//выводим сообщение если оно задано
			if(result.responseText.length==0){
				menu.message(html.tSys(
					html.h('query.'+query+'.'+fullStatus),
					{
						'vars': vars,
						'status': result.responseJS.status,
						'r': result.responseJS.result
					}
				));
			} else {
				menu.message(result.responseText);
			}
			//Если запрос закончился со статусом отличным от OK, очищаем очередь заданий фрейма и прекращаем работу doQuery
			if(status.status!='ok'){
				l2jz.clearTasks();
				return;
			}
			
			//Если на сервере был задан JS код, выполняем его.
			if(isset(result.responseJS.js)){
				if(typeof(result.responseJS.js)=="string"){
					try {
						eval(result.responseJS.js);
					} catch (e) {
						alert('ERROR:\n'+e);
					}
				} else {
					alert('Invalid JS format.');
				}
			}
			l2jz.setFree();
		}
	}
	l2jz.setBusy();
	//если нужно, включаем кеширование
	if(isset(l2jz_q_t[query]['cacheJS']))if(l2jz_q_t[query]['cacheJS']=='TRUE')result.caching = true;
	l2jz_frames[l2jz.frame].queryName = query;
	l2jz_frames[l2jz.frame].queryVars = clone(vars);
	result.open('POST','load.php', true);
	result.send(vars); 
}


function clone(object){
  if (typeof(object)!="object")return object;
  var newObject = new Object();
  for(objectItem in object){
    newObject[objectItem] = clone(object[objectItem]);
  }
  return newObject;
}

function isset(object){
	if(object==undefined)return false; else return true;
}

Array.prototype.toString = Object.prototype.toString = function() {
  var cont = [];
  var addslashes = function(s) {
    // Использовать replace НЕЛЬЗЯ - в Опере
    // происходит зацикливание, т.к. из replace
    // зачем-то вызывается Object.toString().
    return 
      s.split('\\').join('\\\\').split('"').join('\\"');
  }
  for (var k in this) {
    if (cont.length) cont[cont.length-1] += ",";
    var v = this[k];
    var vs = '';
    if (v.constructor == String) 
      vs = '"' + addslashes(v) + '"';
    else 
      vs = v.toString();
        if (this.constructor == Array)
      cont[cont.length]
        else 
      cont[cont.length] = k + ": " + vs;
  }
  // Здесь тоже нельзя делать replace()! 
  cont = "  " + cont.join("\n").split("\n").join("\n  ");
  var s = cont;
  if (this.constructor == Object) {
    s = "{\n"+cont+"\n}";
  } else if (this.constructor == Array) {
    s = "[\n"+cont+"\n]";
  }
  return s;
}
