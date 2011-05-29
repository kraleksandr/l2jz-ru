//-------------//
// TABLE LIB  //
//-----------//
/*
	tProfile - Имя конфигурации таблицы. Конфигурации заданы в XML файлах модулей.
	inArray  - Массив содержащий дополнительные параметры.
	Параметры могут быть следующие:
		Любые параметры тэга <table> в xml конфигурационных файлах.
		div
			ID тэга в котором надо вывести таблицу. По умолчанию таблица выводится в infoSection тэг.
			Если div равен 'innerHTML', l2jzTable записывает HTML код таблицы в своё свойство innerHTML.
		dataSourse
			Задаёт массив, который мы хотим отобразить в виде таблицы.
			Если dataSourse это массив или объект то именно его мы и отображаем.
			Если dataSourse это строка, то мы отображаем результат запроса к серверу с именем dataSourse.
			Если dataSourse не задан, то мы отображаем результат последнего запроса к серверу.
		tplName
			Имя шаблона для entityTable фильтра.		
*/
var l2jzTable = function(tProfile,inArray){
	if(!isset(inArray))inArray = new Object();
	//Ищем конфигурацию таблицы, которую нам надо отрисовать.
	if(isset(l2jz_tbl[l2jz.module+'.'+tProfile])){
		this.tProfile = l2jz_tbl[l2jz.module+'.'+tProfile];
	} else if(isset(l2jz_tbl['main.'+tProfile])){
		this.tProfile = l2jz_tbl['main.'+tProfile];
	} else if(isset(l2jz_tbl[tProfile])){
		this.tProfile = l2jz_tbl[tProfile];
	} else {
		alert('l2jzTable: I can\'t find table: '+tProfile+'.');return '';
	}
	//Устанавливаем параметы из конфигурации
	for(var i in this.tProfile){
		this[i] = this.tProfile[i];
	}
	//Регестрируем таблицу в глобальном массиве DOM объектов.
	this.uid = l2jz.getID();
	l2jz.objects[this.uid] = this;
	this.tT = sT[l2jz.qArrayName];
	
	//Инициализируем фильтры.
	if(!isset(this.filters)){
		this.filters = [{'type': 'showAll'}];
	}
	for(var i in this.filters){
		if(this.filters[i]['default'])this.defaultFilter = i;
	}
	
	//Разбираем inArray
	for(var i in inArray)switch(i){
		case"dataSourse":
			switch(typeof(inArray[i])){
				case"undefined":
					alert('l2jzTable: dataSourse is empty.');return '';
				break;
				case"string":
					this.tT = sT[inArray[i]];
				break;
				default:
					this.tT = inArray[i];
			}
		break;
		default:
			this[i] = inArray[i];
	}
	
	//Проверяем корректность заданного div
	if(this.div=='innerHTML'){
		if(!((this.filters[this.defaultFilter].type=='entityTable')||(this.filters[this.defaultFilter].type=='rowTable'))){
			alert('l2jzTable: I can\'t send '+this.filters[this.defaultFilter].type+' filter as an innerHTML result.');return '';
		}
	} else if(!document.getElementById(this.div)){
		alert('l2jzTable: Can`t find div: '+this.div+'.');return '';
	}
	
	//Инициализируем таблицу
	if(this.div!='innerHTML')document.getElementById(this.div).innerHTML = 
			'<div id="'+this.uid+'">'+
				'<div id="'+this.uid+'_filterList" class="tableFiltersPanel"></div>'+
				'<div id="'+this.uid+'_table"></div>'+
			'</div>';
	if(this.filters.length>1)this.drawFilterList();
	this.setFilter(this.defaultFilter);
}
l2jzTable.prototype = {
	'defaultFilter': 0,          //Номер фильтра по умолчанию
	'filters': [],               //Массив фильтров таблицы.
	'tableType': '',             //Тип таблицы.
	'div': 'infoSection',        //ID тэга в который будет загружена таблица
	'tT': null,                  //Ссылка на массив с данными по которым будет строиться таблица
	'class': 'standardTable',    //CSS Класс таблицы
	'width': 600,                //Ширина таблицы
	'columns': null,             //Ссылка на текущую настройку столбцов таблицы
	'filter': null,              //Ccылка на текущий фильтр
	'sArray': null,              //Массив значений текущего сепаратора
	'sArrayRow': null,           //Хранит указания на одну из строк с данным значением сепаратора
	'groupBy': '',               //Имя текущего сепаратора
	'sDefault': '',              //Дефолтовое значение текущего сепаратора
	
	'drawFilterList': function(){
		if(this.filters.length==1)return;
		var s = new Array();
		s.push('<ul><li>');
		for(var i in this.filters){
			var filter     = this.filters[i];
			var filterID   = i;
			if(filter.type=='showAll')filter.groupBy = 'showAll';
			var filterName = html.h('table.sys.filter.'+filter.groupBy);
			s.push(
				'<a '+
					'href="#" '+
					'id="'+this.uid+'filter'+filterID+'" '+
					'onClick="l2jz.runObjMethod(\''+this.uid+'\',\'setFilter\','+filterID+')" '+
					'OnMouseDown="html._doGetLink(this)" '+
				'>'+filterName+'</a>'
			);
		}
		s.push('</li></ul>');
		document.getElementById(this.uid+'_filterList').innerHTML = s.join('');
	},
	
	'setFilter': function(filterID){
		this.filter  = this.filters[filterID];
		this.columns = (this.filter.columns)?this.filter.columns:[{'type':'incomeColumns','access':'0'}];
		if(this.filters.length>1){
			var a = document.getElementById(this.uid+'filter'+filterID);
			var li = a.parentNode;
			for(var i=0;li.childNodes[i];i++)li.childNodes[i].className = '';
			a.className = 'active';
		}
		this['draw_'+this.filter.type]();
	},
	
	'draw_tabFilter': function(){
		this._makeSeparateArray();
		var filterName = (this.filter.name)?this.filter.name:this.filter.groupBy;
		var s =
			'<br><br><table width="'+this.width+'"><tr><td><div style="position:relative">'+
				'<ul class="tabset_tabs"><li>';
		var firstTab = true;
		for(var i in this.sArray){
			var tabID    = i;
			var tabValue = this.sArray[tabID];
			var tabName  = html.tSys(html.h('table.sys.filter.'+filterName+'.'+tabID),{'value':tabID,'count':tabValue});
			s+='<a '+
					'href="#" '+
					'id="'+this.uid+'tab'+tabID+'" '+
					((firstTab)?'style="border-left:1px solid #636563;" ':' ')+
					'onClick="l2jz.runObjMethod(\''+this.uid+'\',\'setTabFilter\',\''+tabID+'\')" '+
					'OnMouseDown="html._doGetLink(this)" '+
				'>'+tabName+'</a>';
			var firstTab = false;
		}
		s += '</li></ul><div class="menu" id="'+this.uid+'_tContainer"></div></div></td></tr></table>';
		document.getElementById(this.uid+'_table').innerHTML = s;
		this.setTabFilter(this.sDefault);
	},
	
	'setTabFilter': function(tabID){
		var a = document.getElementById(this.uid+'tab'+tabID);
		var li = a.parentNode;
		for(var i=0;li.childNodes[i];i++)li.childNodes[i].className = '';
		a.className = 'active';
		document.getElementById(this.uid+'_tContainer').innerHTML = this._renderTable('row[\''+this.groupBy+'\']==\''+tabID+'\'');
	},

	'draw_jumpTables': function(){
		this._makeSeparateArray();
		var filterName = (this.filter.name)?this.filter.name:this.filter.groupBy;
		
		var s = new Array();
		var jumpsArray = new Array();
		for(var i in this.sArray){
			jumpsArray.push(html.a(
				'jump.table_'+this.uid+'_'+i,
				html.h('table.sys.filter.'+filterName+'.'+i)
			));
		}
		var jumpPanel = 
			'<font size="-2">&nbsp;'+html.a('jump.pageTop','<img src="i/1.gif" alt="Top" border="0">')+'[&nbsp;'+
				jumpsArray.join(' - ')+
			'&nbsp;]'+html.a('jump.pageTop','<img src="i/1.gif" alt="Top" border="0">')+'</font>';
		if(html.h('table.sys.filter.'+filterName)=='NO_JUMP_PANEL')jumpPanel = '';
		
		for(var i in this.sArray){
			s.push('<br>');
			s.push(
				'<div id="table_'+this.uid+'_'+i+'"><pre class="tableJumpPanelName">'+
					html.tSys(
						html.h('table.sys.filter.'+filterName+'.'+i),
						{
							'value':i,
							'count':this.sArray[i],
							'row':this.sArrayRow[i]
						}
					)+
				'</pre></div>'
			);
			s.push(jumpPanel);
			s.push(
				this._renderTable('row[\''+this.groupBy+'\']=='+((i=='L2JZ_NULL')?'null':('\''+i+'\'')))
			);
		}
		s.push(jumpPanel);
		document.getElementById(this.uid+'_table').innerHTML = s.join('');
	},

	'draw_inlineTables': function(){
		this._makeSeparateArray();
		var filterName = (this.filter.name)?this.filter.name:this.filter.groupBy;
		var tableNames = '';
		var tableCount = 0;
		for(var i in this.sArray){
			var tableName = html.tSys(html.h('table.sys.filter.'+filterName+'.'+i),{'value':i,'count':this.sArray[i]});
			tableNames += '<td><span class="tableJumpPanelName">'+tableName+'</span></td>';
			tableCount++;
		}
		var s = new Array();
		s.push('<table><tr align="center">');
		s.push(tableNames);
		s.push('</tr><tr align="center"><td valign="top">');
		for(var i in this.sArray){
			s.push(this._renderTable('row[\''+this.groupBy+'\']==\''+i+'\''));
			if(i!=tableCount-1)s.push('</td><td valign="top">');
		}
		s.push('</td></tr></table>');
		document.getElementById(this.uid+'_table').innerHTML = s.join('');
	},
	
	'draw_showAll': function(){
		document.getElementById(this.uid+'_table').innerHTML = this._renderTable();
	},
	
	'draw_entityTable': function(){
		if(!this.tplName){alert('l2jzTable: I need tplName variable!');return '';}
		var tArray = clone(this.tT);
		tArray.fName = new Object();
		tArray.fHTML = new Object();
		this.tColumns = new Array();
		
		for(var i in this.columns){
			var column = this.columns[i];
			if(column.type=='incomeColumns'){
				for(var columnName in this.tT){
					this.tColumns.push(columnName);
				}
			} else {
				if(l2jz.valueAccess(column.access))this.tColumns.push(column.name);
			}
		}
		
		var row = tArray;
		for(var i in this.tColumns){
			var tColumn = this.tColumns[i];
			if(l2jz_tableHandlers[this.tableType][tColumn]===null)continue;
			tArray.fName[tColumn] = html.h('table.'+this.tableType+'.'+tColumn);
			var string = new Array();
			if(l2jz_tableHandlers[this.tableType][tColumn]){
				var s = l2jz_tableHandlers[this.tableType][tColumn].toString().replace(/\n/gm,'').replace(/function\s*\(\s*\)\s*\{\s*(.*)\s*\}\s*$/gm,"$1");		
			} else if(l2jz_tableHandlers['default'][tColumn]){
				var s = l2jz_tableHandlers['default'][tColumn].toString().replace(/\n/gm,'').replace(/function\s*\(\s*\)\s*\{\s*(.*)\s*\}\s*$/gm,"$1");
			} else {
				var s = 'string.push(row[\''+tColumn+'\']);';
			}
			try {eval(s);} catch(e) {
				alert('CODE:\n'+s+'\nERROR:\n'+e);
			}
			tArray.fHTML[tColumn] = '<span class="'+tColumn+'">'+string.join('')+'<span>';
		}
		var s =
			'<table class="table"><tbody class="'+this.tableType+'"><tr><td>'+
				html.t(this.tplName,tArray)+
			'</td><tr></tbody></table>';
		if(this.div!='innerHTML'){
			document.getElementById(this.div).innerHTML = s;
		} else this.innerHTML = s;
	},
	
	'draw_rowTable': function(){
		this.tT = new Array(this.tT);
		var s = this._renderTable();
		if(this.div!='innerHTML'){
			document.getElementById(this.div).innerHTML = s;
		} else this.innerHTML = s;
	},
	
	//генерирует еденичную таблицу.
	'_renderTable': function(ifCode){
		string = new Array();
		//определяем, какие столбцы входят в таблицу
		this.tColumns = new Array();
		for(var i in this.columns){
			var column = this.columns[i];
			if(column.type=='incomeColumns'){
				for(var columnName in this.tT[0])this.tColumns.push(columnName);
			} else {
				if(l2jz.valueAccess(column.access))this.tColumns.push(column.name);
			}
		}
		//Формируем обработчик строки таблицы.
		this._makeHandler(this.tableType,ifCode);
		
		string.push('<div class="table"><table cellpadding="2" cellspacing="1"  width="'+this.width+'" class="'+this['class']+'">');
		
		//Рисуем заголовок таблицы.
		string.push('<thead class="'+this.tableType+'"><tr>');
		for(var i in this.tColumns){
			var tColumn = this.tColumns[i];
			if(l2jz_tableHandlers[this.tableType][tColumn]===null)continue;
			string.push('<td onClick="sort(this)" class="'+tColumn+'">'+html.h('table.'+this.tableType+'.'+tColumn)+'</td>');
		}
		string.push('</tr></thead>');
		
		//рисуем тело таблицы.
		string.push('<tbody class="'+this.tableType+'">');
		tableIterator = 0;
		while(this.tT[tableIterator]){
			this.rowHandler(this.tT[tableIterator]);
			tableIterator++;
		}
		
		string.push('</tbody></table></div>');
		return string.join('');
	},
	
	'_makeHandler': function(tableType,ifCode){
		var s =(ifCode)?'if(!('+ifCode+'))return;':'';
		s += 'string.push(\'<tr>\');';
		for(var i in this.tColumns){
			var tColumn = this.tColumns[i];
			if(l2jz_tableHandlers[tableType][tColumn]===null)continue;
			s += 'string.push(\'<td class="'+tColumn+'">\');';
			if(l2jz_tableHandlers[tableType][tColumn]){
				s += l2jz_tableHandlers[tableType][tColumn].toString().replace(/\n/gm,'').replace(/function\s*\(\s*\)\s*\{\s*(.*)\s*\}\s*$/gm,"$1");		
			} else if(l2jz_tableHandlers['default'][tColumn]){
				s += l2jz_tableHandlers['default'][tColumn].toString().replace(/\n/gm,'').replace(/function\s*\(\s*\)\s*\{\s*(.*)\s*\}\s*$/gm,"$1");
			} else {
				s += 'string.push(row.'+tColumn+');';
			}
			s += 'string.push(\'</td>\');';
		}
		s += 'string.push(\'</tr>\');';
		this.rowHandler = new Function('row',s);
		return 0;
	},
	
	'_makeSeparateArray': function(){
		this.sArray    = new Object();
		this.sArrayRow = new Object();
		this.groupBy   = this.filter.groupBy;
		this.sDefault  = false;
		var firstValue = false;
		//Ищем все значения сепараторов
		for(var i in this.tT){
			var sValue = this.tT[i][this.groupBy];
			if(sValue===null)sValue = 'L2JZ_NULL';
			if(!firstValue)firstValue = sValue;
			if(isset(this.sArray[sValue])){
				this.sArray[sValue]++;
			} else {
				this.sArray[sValue] = 0;
				this.sArrayRow[sValue] = this.tT[i];
			}
		}
		//Устанавливаем дефолтовое значение сепаратора
		if(isset(this.filter['default'])){
			if(isset(this.sArray[this.filter['default']])){
				this.sDefault = this.filter['default'];
			}
		}	
		if(!this.sDefault)this.sDefault = firstValue;
	}
}
l2jz.checkScriptVersion('bc8fdb5dc8e4ba0');