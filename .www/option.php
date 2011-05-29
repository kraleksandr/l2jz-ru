<?php
#-----------------------------------------------------
# L2JZ Configuration
#-----------------------------------------------------
$config['security_on']    = TRUE;//If you turn it off there will not be security checks.
$config['cache']          = TRUE;//Set FALSE if you want to disable caching queries.
$config['GZip']           = FALSE;
$config['encoding']       = 'utf-8';//Encoding

/**
 * default - L2J Server
 * l2j_ft  - L2J Fortress Server
 * You don't need to change it.
 */
$config['L2J_type']       = 'l2j_ft';

#-----------------------------------------------------
# Login server Configuration
#-----------------------------------------------------
$loginserver['ip']                       = "127.0.0.1";//Server IP.
$loginserver['port']                     = "2106";//Server login port.
$loginserver['telnetport']               = "1905";//Server telnet port. Don't forget to turn on telnet!
$loginserver['telnetpass']               = "la2kkk";//Server telnet pass. Do not forget to uncomment the string with it in telnet.propereties.
$loginserver['mysql_address']            = "localhost";//Sql server address.
$loginserver['mysql_login']              = "la2";//Sql login username.
$loginserver['mysql_password']           = "la2kkk";//Sql login password.
$loginserver['mysql_database']           = "l2jdb";//Sql database name.
$loginserver['LnameTemplate']            = "[A-Za-z0-9]{2,}";// This is login name template.
$loginserver['CnameTemplate']            = "[A-Za-z0-9]{2,}";// This is char nametemplate.


#-----------------------------------------------------
# Game server(s) Configuration
#-----------------------------------------------------
$i = 0; // << DO not Delete this
/**
 * $servers - is array of your GSs. Here you can see one server
 * configuration. If you have more then one GSs, just copy all from
 * '#server begin' to '#server end' and change that options that must 
 * be changed.
 */

#server begin
//DON'T USE QUOTES IN THIS NAME. Also note that name's length MUST be 1-12 symbols.
$servers[$i]['info']['name']             = "LBR x5";//Server name. It will be shown in client(in many places). You may Write here whatever you want.
$servers[$i]['ip']                       = "81.176.65.120";//Server IP.
$servers[$i]['port']                     = "7777";//Server game port.
$servers[$i]['telnetport']               = "1903";//Server telnet port. Don't forget to turn on telnet!
$servers[$i]['telnetpass']               = "la2kkk";//Server telnet pass. Do not forget to uncomment the string with it in telnet.propereties.
$servers[$i]['mysql_address']            = "localhost";//Sql server address.
$servers[$i]['mysql_login']              = "la2";//Sql login username.
$servers[$i]['mysql_password']           = "la2kkk";//Sql login password.
$servers[$i]['mysql_database']           = "l2jdb";//Sql database name.
$servers[$i]['info']['rateXp']           = 5;//Exp rate.
$servers[$i]['info']['rateSp']           = 5;//Sp rate.
$servers[$i]['info']['rateDropAdena']    = 3;//Adena rate.
$servers[$i]['info']['rateDropItems']    = 5;//Drop rate.
$servers[$i]['info']['rateDropSpoil']    = 6;//Spoil rate.
$i++;
#server end

#server begin
//DON'T USE QUOTES IN THIS NAME. Also note that name's length MUST be 1-12 symbols.
$servers[$i]['info']['name']             = "LBR x25";//Server name. It will be shown in client(in many places). You may Write here whatever you want.
$servers[$i]['ip']                       = "81.176.65.121";//Server IP.
$servers[$i]['port']                     = "7777";//Server game port.
$servers[$i]['telnetport']               = "1904";//Server telnet port. Don't forget to turn on telnet!
$servers[$i]['telnetpass']               = "la2kkk";//Server telnet pass. Do not forget to uncomment the string with it in telnet.propereties.
$servers[$i]['mysql_address']            = "localhost";//Sql server address.
$servers[$i]['mysql_login']              = "la2";//Sql login username.
$servers[$i]['mysql_password']           = "la2kkk";//Sql login password.
$servers[$i]['mysql_database']           = "l2jtestdb";//Sql database name.
$servers[$i]['info']['rateXp']           = 25;//Exp rate.
$servers[$i]['info']['rateSp']           = 25;//Sp rate.
$servers[$i]['info']['rateDropAdena']    = 25;//Adena rate.
$servers[$i]['info']['rateDropItems']    = 25;//Drop rate.
$servers[$i]['info']['rateDropSpoil']    = 25;//Spoil rate.
$i++;
#server end


#-----------------------------------------------------
# Sections and Types configuration
#-----------------------------------------------------
/*ENGLISH
 * AL = access level.
 * Here is an array of queries from client to server. Array is a number of sections.
 * Each section is a number of queries. Each query is a number of it's parameters. Here
 * are parameters of query:
 *	access(each query must have it):
 *		AL to query. Each user of l2jz has AL. For anonymous user it is zero. For logined 
 *		user AL is the same as AL of it's account(account, not chars on this account).
 *	cache(optional parameter):
 *		First this parameter says that the result of query must be cached. Second it sets 
 *		time (in seconds) for using the cached data. Query will not be cached if:
 *			1)AL of query is more then zero.
 *			2)AL of user is more then zero. Server will build the special result for this 
 *			user which can contain some special information(accounts in top100 for example).		
 */
/*RUSSIAN
 * AL = уровень доступа
 * ћассив $l2jz содержит все запросы, которые поддерживает сервер.
 * «апрос определ€етс€ секцией и типом (то-есть все запросы заданы
 * в двухурувневой иерархии). $l2jz это массив секций.  ажда€ сек-
 * ци€ это набор типов.  аждый тип это массив параметров запроса.
 * «апрос может иметь следующие параметры:
 *	access(об€зательный параметр):
 *		Ётот параметр опередел€ет AL к запросу.  аждый пользователь 
 *		l2jz имеет AL. ≈сли пользователь не вошЄл в систему, он имеет 
 *		AL равный нулю, если вошЄл, AL равный AL своего аккаунта(акка-
 *		унта а не чаров на этом аккунте). ѕользователь должен иметь AL 
 *		не меньше чем AL к запросу(то-есть больше либо равно), чтобы по-
 *		лучить к нему доступ.
 *	cache(необ€зательный параметр):
 *		Ётот параметр во первых говорит системе, что запрос следует кеширо-
 *		вать, а во вторых задаЄт сколько времени(в секундах) можно использо-
 *		вать закешированную информацию. «апрос не будет закэширован в том слу-
 *		чае если он имеет AL больше 0.  эширование также не будет использо-
 *		ватьс€, если информацию запрашивает пользователь с AL больше 0. Ёто 
 *		сделано так-как система может отдавать разную информацию на одни и те-же 
 *		запросы в зависимости от AL пользовател€(например в топ100 она может от-
 *		правл€ть на клиент названи€ аккаунтов чаров если AL больше 10).
 */
$l2jz = array(
	'main_menu'=>array(
		'lserver'=>array('access'=>0),
		'server'=>array('access'=>0),
		'castles'=>array('access'=>0),
		'chars'=>array('access'=>0),
		'accounts'=>array('access'=>50),
		'clans'=>array('access'=>0),
		'items'=>array('access'=>0),
		'monsters'=>array('access'=>0),
		'map'=>array('access'=>0),
		'skills'=>array('access'=>0),
	),

	'server'=>array(
		'main'=>array('access'=>0,'cache'=>600)
	),

	'chars'=>array(
		'search'=>array('access'=>50),
		'builders'=>array('access'=>0,'cache'=>3600),
		'online'=>array('access'=>0,'cache'=>360),
		'top100'=>array('access'=>0,'cache'=>3600),
		'top100adena'=>array('access'=>0,'cache'=>3600),
	),
	'player'=>array(
		'main'=>array('access'=>50),
		'skills'=>array('access'=>50),
		'map'=>array('access'=>50),
		'recipebook'=>array('access'=>50),
		'friends'=>array('access'=>50),
	),
	'accounts'=>array(
		'search'=>array('access'=>50),
		'builders'=>array('access'=>50),
		'all'=>array('access'=>50),
	),
	'account'=>array(
		'main'=>array('access'=>50),
		'chars'=>array('access'=>50),
	),
	'clans'=>array(
		'search'=>array('access'=>0),
		'all_clans'=>array('access'=>0,'cache'=>600),
	),
	'clan'=>array(
		'main'=>array('access'=>0,'cache'=>1800),
		'chars'=>array('access'=>0,'cache'=>600),
	),
	'items'=>array(
		'type'=>array('access'=>0,'cache'=>3600),
		'recipe'=>array('access'=>0,'cache'=>3600),
		'sets'=>array('access'=>0,'cache'=>3600),
		'luxor'=>array('access'=>0,'cache'=>3600),
		'search'=>array('access'=>0),
	),
	'inventory'=>array(
		'main'=>array('access'=>50),
	), 
	'item'=>array(
		'main'=>array('access'=>0,'cache'=>3600),
		'drop'=>array('access'=>0,'cache'=>3600),
		'sell'=>array('access'=>0,'cache'=>3600),
		'recipe'=>array('access'=>0,'cache'=>3600),
		'owners'=>array('access'=>50),
	),
	'monsters'=>array(
		'type'=>array('access'=>0,'cache'=>3600),
		'search'=>array('access'=>0),
	),
	'monster'=>array(
		'main'=>array('access'=>0,'cache'=>3600),
		'drop'=>array('access'=>0,'cache'=>3600),
		'sell'=>array('access'=>0,'cache'=>3600),
		'skills'=>array('access'=>0,'cache'=>3600),
		'minions'=>array('access'=>0,'cache'=>3600),
		'map'=>array('access'=>0,'cache'=>3600),
	),
	'skills'=>array(
		'class'=>array('access'=>0,'cache'=>3600),
	),
	'map'=>array(
		'main'=>array('access'=>0),
		'player'=>array('access'=>30),
		'monster'=>array('access'=>0,'cache'=>3600),
		'chars_online'=>array('access'=>0,'cache'=>180),
		'clan'=>array('access'=>0)
	),
	'castles'=>array(
		'main'=>array('access'=>0),	
	),
	'quick_ask'=>array(
		'char_search'=>array('access'=>0),
		'item_search'=>array('access'=>0),
		'mob_search'=>array('access'=>0),
		'add_drop'=>array('access'=>0),
	),
	'action'=>array(
		//CHAR
		'change_char_builder'=>array('access'=>100),
		'change_char_class'=>array('access'=>100),
		'change_char_name'=>array('access'=>100),
		'send_whisper_to_char'=>array('access'=>10),
		'kick_char'=>array('access'=>100),
		'teleport_char'=>array('access'=>100),
		'move_char_to_account'=>array('access'=>100),
		'char_set_skill'=>array('access'=>100),
		'char_delete_skill'=>array('access'=>100),
		//ACCOUNT
		'change_account_password'=>array('access'=>100),
		'change_account_builder'=>array('access'=>100),
		'change_account_email'=>array('access'=>100),
		'change_my_account_password'=>array('access'=>0),
		'forgot_my_account_password'=>array('access'=>0),
		'change_my_account_email'=>array('access'=>0),
		'ban_account'=>array('access'=>100),
		//ITEM
		'add_item'=>array('access'=>100),
		'delete_item'=>array('access'=>100),
		'change_item_count'=>array('access'=>100),
		'enchant_item'=>array('access'=>100),
		//MONSTER
		'add_item_to_shop'=>array('access'=>100),
		'delete_item_from_shop'=>array('access'=>100),
		'add_item_to_drop'=>array('access'=>100),
		'delete_item_from_drop'=>array('access'=>100),
		//SERVER
		'set_announce'=>array('access'=>100),
		'set_announce_to_gms'=>array('access'=>100),
		'restart_server'=>array('access'=>100),
		'shutdown_server'=>array('access'=>100),
		'abort_server'=>array('access'=>100),
		//L2JZ
		'change_game_server'=>array('access'=>0),
		'register_user'=>array('access'=>0),
		'login_user'=>array('access'=>0),
		'exit_user'=>array('access'=>0),
	),
	'ploader'=>array(
		'skills'=>array('access'=>0),
		'welcome'=>array('access'=>0),
	),
	'mloader'=>array(
		'main'=>array('access'=>0,'cache'=>3600),
	),
	'other'=>array(
		'char_levels'=>array('access'=>0),
	)
);
?>