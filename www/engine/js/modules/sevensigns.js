//This file was automaticaly generated by L2JZ engine.
l2jz_tpl['sevensigns.sevensigns'] = '<table width=\"569\" height=\"225\" style=\"BACKGROUND: url(./modules/sevensigns/i/ssqViewBg.jpg)\">\r\n	<tr valign=\"top\">\r\n		<td>\r\n			<table style=\"MARGIN: 18px 0px 0px 54px\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"141\">\r\n				<tr align=\"center\" height=\"26\">\r\n					<td style=\"BACKGROUND: url(./modules/sevensigns/i/ssqViewimg1.gif); COLOR:#fff; font-size:11px;\">\r\n					@:\r\n						(a.period>3)? html.h(\'table.sevensigns.-1\')\r\n						:             html.tSys(html.h(\'table.sevensigns.\'+a.period),a.nthDay)\r\n					:@\r\n					</td>\r\n				</tr>\r\n			</table>\r\n			<table style=\"MARGIN: 3px 0px 0px 10px\" cellspacing=\"0\" cellpadding=\"0\" width=\"141\" border=\"0\">\r\n				<tr>\r\n					<td></td>\r\n					<td><img height=\"16\" src=\"./modules/sevensigns/i/timeBox1.jpg\" width=\"140\" border=\"0\"></td>\r\n					<td></td>\r\n				</tr><tr>\r\n					<td valign=\"bottom\" rowspan=\"2\"><img height=\"125\" src=\"./modules/sevensigns/i/timeBox2.jpg\" width=\"45\" border=\"0\"></td>\r\n					<td><img src=\"./modules/sevensigns/i/time/time@:(a.period>1?(Number(a.nthDay)+7):a.nthDay):@.jpg\" width=\"140\" height=\"139\" border=\"0\"></td>\r\n					<td valign=\"bottom\" rowspan=\"2\"><img height=\"125\" src=\"./modules/sevensigns/i/timeBox3.jpg\" width=\"66\" border=\"0\"></td>\r\n				</tr><tr>\r\n					<td><img height=\"12\" src=\"./modules/sevensigns/i/timeBox4.jpg\" width=\"140\" border=\"0\"></td>\r\n				</tr>\r\n			</table>\r\n		</td><td>\r\n			<table style=\"MARGIN: 18px 0px 0px 64px\" cellspacing=\"0\" cellpadding=\"0\" width=\"141\" border=\"0\">\r\n				<tr align=\"center\" height=\"26\">\r\n					<!-- Current Time - Not Real Time but the time of query -->\r\n					<td style=\"BACKGROUND: url(./modules/sevensigns/i/ssqViewimg1.gif); COLOR:#fff; font-size:11px\">@:a.ss_time:@</td>\r\n				</tr>\r\n			</table>\r\n			<table style=\"MARGIN: 21px 0px 0px 22px\" cellspacing=\"0\" cellpadding=\"0\" width=\"220\" border=\"0\">\r\n				<COLGROUP align=\"left\">\r\n				<COL width=\"48\">\r\n				<COL width=\"*\">\r\n				<tr height=\"11\"><!--Dawn Bar Graph-->\r\n					<td width=\"32\" style=\"font-size:11px; color:#000\">Dawn</td>\r\n					<td width=\"188\" valign=\"top\">\r\n						<div style=\"position:absolute; z-index:3\"><img src=\"./modules/sevensigns/i/ssqbar2.gif\" width=\"@:((a.dawn_score*210)/(Number(a.dawn_score)>Number(a.dusk_score)?a.dawn_score:a.dusk_score)):@\" height=\"15\" border=\"0\"></div>\r\n						<div style=\"position:absolute;z-index:3;font-size:11px;color:#000;MARGIN: 0px 0px 0px 5px\">@:a.dawn_score:@</div>\r\n					</td>\r\n				</tr>\r\n				<tr><td colspan=\"2\" height=\"7\"></td></tr>\r\n				<tr height=\"11\"><!--Dusk Bar Graph-->\r\n					<td width=\"32\" style=\"font-size:11px; color:#000\">Dusk</td>\r\n					<td width=\"188\" valign=\"top\">\r\n						<div style=\"position:absolute;z-index:3\"><img src=\"./modules/sevensigns/i/ssqbar1.gif\" width=\"@:((a.dusk_score*210)/(Number(a.dawn_score)>Number(a.dusk_score)?a.dawn_score:a.dusk_score)):@\" height=\"15\" border=\"0\"></div>\r\n						<div style=\"position:absolute;z-index:3;font-size:11px;color:#000;MARGIN: 0px 0px 0px 5px\">@:a.dusk_score:@</div>\r\n					</td>\r\n				</tr></COLGROUP>\r\n			</table>\r\n			<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n				<!-- It not 3 then seal must be shown as grey.Seal Status 0 = closed, 1 or 2 = opened  -->\r\n				<tr valign=\"bottom\" align=\"center\" height=\"95\"><!--Seals-->\r\n					<td><img src=\"./modules/sevensigns/i/Seals/SOA/bongin1@:(a.period==3?((a.avarice==0)?\'close\':\'open\'):\'\'):@.gif\" width=\"85\" height=\"86\" border=\"0\"></td>\r\n					<td><img src=\"./modules/sevensigns/i/Seals/SOG/bongin2@:(a.period==3?((a.gnosis==0)?\'close\':\'open\'):\'\'):@.gif\" width=\"85\" height=\"86\" border=\"0\"></td>\r\n					<td><img src=\"./modules/sevensigns/i/Seals/SOS/bongin3@:(a.period==3?((a.strife==0)?\'close\':\'open\'):\'\'):@.gif\" width=\"85\" height=\"86\" border=\"0\"></td>\r\n				</tr><tr>\r\n					<td colspan=\"3\"><div align=\"center\" style=\"margin-left:10px;\"><img height=\"16\" src=\"./modules/sevensigns/i/bonginName.gif\" width=\"258\" border=\"0\"></div></td>\r\n				</tr>\r\n			</table>\r\n		</td>\r\n	</tr>\r\n</table>';
