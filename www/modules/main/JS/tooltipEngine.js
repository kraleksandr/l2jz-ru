l2jzTooltip = function(innerHTML,inArray){
	if(!isset(inArray))inArray = new Object();
	for(var i in inArray)this[i] = inArray[i];
	this.uid = l2jz.getID();
	this.module = l2jz.module;
	l2jz.objects[this.uid] = this;
	this.innerHTML = innerHTML;
	this.htmlCode =
		' id="'+this.uid+'" '+
		'onMouseMove="l2jz.runObjMethod(\''+this.uid+'\',\'linkMove\',event)" '+
		'onMouseOut="l2jz.runObjMethod(\''+this.uid+'\',\'linkOut\')" '+
		'onMouseOver="l2jz.runObjMethod(\''+this.uid+'\',\'linkOver\',event)" ';
}
l2jzTooltip.prototype = {
	'innerHTML': '',    //Это свойство хранит либо строку либо функцию возвращающую содержимое tooltip-а
	'borderTpl': 'main.tooltip', //Шаблон рамки.
	'linkMove': function(e){
		var tEvent = (e)?e:event;
		document.getElementById("tooltip_section").style.left = (((tEvent.pageX)?tEvent.pageX:tEvent.x)+10)+"px";
		document.getElementById("tooltip_section").style.top  = (((tEvent.pageY)?tEvent.pageY:tEvent.y)+10)+"px";
	},
	
	'linkOut': function(){
		document.getElementById("tooltip_section").style.visibility = 'hidden';
	},
	
	'linkOver': function(e){
		var tEvent = (e)?e:event;
		document.getElementById("tooltip_section").style.left = (((tEvent.pageX)?tEvent.pageX:tEvent.x)+10)+"px";
		document.getElementById("tooltip_section").style.top  = (((tEvent.pageY)?tEvent.pageY:tEvent.y)+10)+"px";
		l2jz.setHandlerContext('noFrame',this.module);
		this.innerHTML = (typeof(this.innerHTML)=='function')?(this.innerHTML)(this.row):this.innerHTML;
		document.getElementById("tooltip_section").innerHTML  =
			(this.borderTpl)?
				html.t(this.borderTpl,this.innerHTML)
			:   this.innerHTML;
		document.getElementById("tooltip_section").style.visibility = 'visible';
	}
}
l2jz.checkScriptVersion('bc8fdb5dc8e4ba0');