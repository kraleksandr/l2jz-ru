//This file was automaticaly generated by L2JZ engine.
l2jz_tpl['map.main'] = '<div class=\"mapContainer\">\r\n	<div id=\"smallMapContainer\">\r\n		<div id=\"smallMap\"></div>\r\n		<div id=\"map_pointer\"></div>\r\n		<div id=\"smallMapField\"\r\n			onMouseUp=\"map.onPointerMouseUp()\"\r\n			onMouseOut=\"map.onPointerMouseUp()\"\r\n		></div>\r\n	</div>\r\n	\r\n	<div id=\"bigMapContainer\">\r\n		<div id=\"bigMap\"></div>\r\n	</div>\r\n	\r\n	<div class=\"mapPanel\">\r\n		<table>\r\n			<tr>\r\n				<td><div id=\"mapSpawnsCounter\"></div></td>\r\n				<td>@:html.a2(\'map.chars_online\',{\'class\':\'bigPageName\'}):@</td>\r\n				<td width=\"100%\"></td>\r\n				<td>@:html.aButton(\'map.hide\',\'Hide\'):@</td>\r\n			</tr>\r\n		</table>\r\n	</div>\r\n</div>';
l2jz_tpl['map.tooltips.L2Drop'] = '<table class=\"entityTable\" cellpadding=\"3\" cellspacing=\"0\">\r\n	<tr class=\"bodyTr\">\r\n		<td colspan=\"3\">\r\n			<span class=\"entityName\">@:a.name:@</span> @:(a[\'min\']!=a[\'max\'])?\' [<b>\'+a[\'min\']+\'</b> - <b>\'+a[\'max\']+\'</b>]\':\'\':@<br>\r\n			@:a.fHTML.chance:@<br>\r\n			<span style=\"font-size:10px\">@:html.h(\'table.sys.filter.sweep.\'+a.sweep):@</span>\r\n		</td>\r\n	</tr><tr class=\"headTr\">\r\n		<td>@:a.fName.level:@</td>\r\n		<td>@:a.fName.sex:@</td>\r\n		<td>@:a.fName.aggro:@</td>\r\n	</tr><tr class=\"bodyTr\">\r\n		<td>@:a.level:@</td>\r\n		<td>@:a.fHTML.sex:@</td>\r\n		<td>@:a.fHTML.aggro:@</td>\r\n	</tr><tr class=\"headTr\">\r\n		<td>@:a.fName.type:@</td>\r\n		<td>@:a.fName.respawn_delay:@</td>\r\n		<td>@:a.fName.count:@</td>\r\n	</tr><tr class=\"bodyTr\">\r\n		<td>@:a.type:@</td>\r\n		<td>@:a.respawn_delay:@ sec.</td>\r\n		<td>@:a.count:@</td>\r\n	</tr>\r\n</table>';
l2jz_tpl['map.tooltips.L2Monster'] = '<table class=\"entityTable\" cellpadding=\"3\" cellspacing=\"0\">\r\n	<tr class=\"bodyTr\">\r\n		<td colspan=\"3\" class=\"entityName\">@:a.name:@</td>\r\n	</tr><tr class=\"headTr\">\r\n		<td>@:a.fName.level:@</td>\r\n		<td>@:a.fName.sex:@</td>\r\n		<td>@:a.fName.aggro:@</td>\r\n	</tr><tr class=\"bodyTr\">\r\n		<td>@:a.level:@</td>\r\n		<td>@:a.fHTML.sex:@</td>\r\n		<td>@:a.fHTML.aggro:@</td>\r\n	</tr><tr class=\"headTr\">\r\n		<td>@:a.fName.type:@</td>\r\n		<td>@:a.fName.respawn_delay:@</td>\r\n		<td>@:a.fName.count:@</td>\r\n	</tr><tr class=\"bodyTr\">\r\n		<td>@:a.type:@</td>\r\n		<td>@:a.respawn_delay:@ sec.</td>\r\n		<td>@:a.count:@</td>\r\n	</tr>\r\n</table>';
l2jz_tpl['map.tooltips.L2Player'] = '<table class=\"entityTable\" cellpadding=\"3\" cellspacing=\"0\">\r\n	<tr class=\"bodyTr\">\r\n		<td colspan=\"3\" class=\"entityName\">@:a.char_name:@</td>\r\n	</tr><tr class=\"headTr\">\r\n		<td>@:a.fName.level:@</td>\r\n		<td>@:a.fName.sex:@</td>\r\n		<td>@:a.fName.class_id:@</td>\r\n	</tr><tr class=\"bodyTr\">\r\n		<td>@:a.level:@</td>\r\n		<td>@:a.fHTML.sex:@</td>\r\n		<td>@:a.fHTML.class_id:@</td>\r\n	</tr>\r\n</table>';