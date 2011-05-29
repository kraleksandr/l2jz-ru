map = {
	showing:false,
	drawing:false,
	moving:false,
	x:0,
	y:0,
	px:0,
	py:0,
	
	'onPointerMouseDown': function(e){
		map.moving = true;
		map.small_map_x = html.getX('smallMap');
		map.small_map_y = html.getY('smallMap');
		map.onPointerMouseMove(e);
	},
	
	'onPointerMouseMove': function(e){
		if(map.moving){
			var mapEvent = (e)?e:event;
			var p_x = ((mapEvent.pageX)?mapEvent.pageX:mapEvent.x) - map.small_map_x;
			var p_y = ((mapEvent.pageY)?mapEvent.pageY:mapEvent.y) - map.small_map_y;
			var x = Math.round(p_x*6.3);
			var y = Math.round(p_y*6.3);
			map.move_map(x,y,p_x,p_y);
		}
	},
	
	'onPointerMouseUp': function(){
		map.moving = false;
	},
	
	'show': function(){
		if(map.showing)return;
		map.showing = true;
		document.getElementById("centralSection").style.top = (Math.round(html.getY('centralSection'))+440)+'px';
		if(!map.drawing){
			html.t('main',null,'mapSection');
			if(document.getElementById("smallMapField").addEventListener){
				document.getElementById("smallMapField").addEventListener("mousemove", map.onPointerMouseMove, false);
				document.getElementById("smallMapField").addEventListener("mousedown", map.onPointerMouseDown, false);
			} else {
				document.getElementById("smallMapField").attachEvent("onmousemove", map.onPointerMouseMove);
				document.getElementById("smallMapField").attachEvent("onmousedown", map.onPointerMouseDown);
			}
			map.move_map(map.x,map.y,map.px,map.py);
			map.drawing = true;
		} else {
			document.getElementById("mapSection").style.visibility = 'visible';
		}
	},
	
	'hide': function(){
		if(!map.showing)return;
		map.showing=false;
		document.getElementById("mapSection").style.visibility = 'hidden';
		document.getElementById("centralSection").style.top = (Math.round(html.getY('centralSection'))-440)+'px';
	},
	
	'move_map': function(left,top,p_left,p_top){
		map.x=left;
		map.y=top;
		map.px=p_left;
		map.py=p_top;
		if(left<=225)left=225;
		if(left>=1556)left=1556;
		if(top<=200)top=200;
		if(top>=2320)top=2320;
		if(p_left<=36)p_left=36;
		if(p_left>=247)p_left=247;
		if(p_top<=32)p_top=32;
		if(p_top>=368)p_top=368;	
		left=left-225;
		top=top-200;
		p_left=p_left-36;
		p_top=p_top-32;
		document.getElementById("bigMapContainer").scrollLeft = left;
		document.getElementById("bigMapContainer").scrollTop  = top;
		document.getElementById("map_pointer").style.left     = p_left+"px";
		document.getElementById("map_pointer").style.top      = p_top+"px";
	},
	
	'sh_points': function(showMode){
		var smap_string = new Array();
		var bmap_string = new Array();
		var div_point,point_image,title,b_x,b_y,s_x,s_y,row,s='',s_s='';
		var points_count = 0;
		var point_image  = '';
		var pLink        = '';
		for(var i in sT.map){
			row = sT.map[i];
			l_x=Number(row['x'])+126080;//214480;
			l_y=Number(row['y'])+243200;//;262144
			b_x=Math.round(l_x/200)-3;
			b_y=Math.round(l_y/200)-3;
			s_x=Math.round(l_x/1259)-1;
			s_y=Math.round(l_y/1259)-1;
			tooltip =  new l2jzTooltip(null,{'borderTpl':false});
			switch(showMode){
				case"char":
					points_count++;
					point_image = 'boss';
					tooltip.innerHTML =
						function(array){//http://dklab.ru/chicken/nablas/39.html#list8
							return function(){
								return (new l2jzTable('char.entity',{
										tplName:    'tooltips.L2Player',
										dataSourse: array,
										div:        'innerHTML'
								}).innerHTML);
							}
						}(row);
					pLink       = 'char.main.'+row.char_id;
				break;
				case"mob":
					points_count += Math.round(row.count);
					point_image = 'monster';
					tooltip.innerHTML =
						function(array){//http://dklab.ru/chicken/nablas/39.html#list8
							return function(){
								return (new l2jzTable('monster.entity',{
										tplName:    'tooltips.L2Monster',
										dataSourse: array,
										div:        'innerHTML'
								}).innerHTML);
							}
						}(row);
					pLink       = 'monster.main.'+row.mob_id;	
				break;
				case"drop":
					points_count += Math.round(row.count);
					point_image = 'monster';
					tooltip.innerHTML =
						function(array){//http://dklab.ru/chicken/nablas/39.html#list8
							return function(){
								return (new l2jzTable('monster.entity',{
										tplName:    'tooltips.L2Drop',
										dataSourse: array,
										div:        'innerHTML'
								}).innerHTML);
							}
						}(row);
					pLink       = 'monster.main.'+row.mob_id;
				break;
			}
			bmap_string.push(
				'<div style="position:absolute;top:'+b_y+'px;left:'+b_x+'px;">'+
					html.a2(
						pLink,
						{
							'innerHTML': '<img src="modules/map/i/points/'+point_image+'.gif">',
							'tooltip':   tooltip
						}
					)+
				'</div>');
			smap_string.push('<div style="position:absolute;top:'+s_y+'px;left:'+s_x+'px;"><img src="modules/map/i/points/s_point.gif"></div>');
		}
		document.getElementById("smallMap").innerHTML = smap_string.join('');
		document.getElementById("bigMap").innerHTML   = bmap_string.join('');
		document.getElementById("mapSpawnsCounter").innerHTML     = 'Spawns:&nbsp;'+points_count;
		map.move_map(b_x,b_y,s_x,s_y);
	}
}
l2jz.checkScriptVersion('bc8fdb5dc8e4ba0');



function create(n) {
  var arr = [];
  for (var i=1; i<n; i++) {
    // Создаем функцию...
    arr[i] = function(x) { 
      // создание замыкания с лексической x
      return function() { alert(x*x) } 
    }(i); // и тут же ее вызываем с параметром i!
  }
  return arr;
}


