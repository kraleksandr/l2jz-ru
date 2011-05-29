<?php
//--------//
// LOAD  //
//------//
/* Скрипт, который вызывает клиент, когда хочет получить какие-нибудь данные.
 * Этот скрипт производит начальную инициализацию системы, проверяет доступ и,
 * если всё нормально передаёт управление обработчику запроса. Обработчики за-
 * просов лежат в папке handlers.
 */
Error_Reporting(E_ALL & ~E_NOTICE);
define("L2JZ","L2JZ");
include 'option.php';
include 'engine/php/query_tree.php';
include 'engine/php/access_lib.php';
include 'engine/php/checkVars_lib.php';
include 'engine/php/telnet_lib.php';
include 'engine/php/sql_lib.php';
require 'engine/php/ajax.php';

function error($string){
	print "<font color=red>Error: </font>".$string."<br>";
	$GLOBALS['_RES']['status']['status'] = 'error';
	exit();
}

function setErrorCode($errorCode){
	$GLOBALS['_RES']['status']['status']     = 'error';
	$GLOBALS['_RES']['status']['statusCode'] = $errorCode;
	$GLOBALS['_RES']['status']['dataType']   = 'error';
	exit();
}

function setOkCode($okCode){
	$GLOBALS['_RES']['status']['statusCode'] = $okCode;
	exit();
}

if($cfg['GZip'])ob_start("ob_gzhandler",9);
#---------------------------------------
# Bulding new channel.
#---------------------------------------
$JsHttpRequest =& new Subsys_JsHttpRequest_Php("UTF-8");
$telnet        =& new l2jz_telnet();
$sql           =& new l2jz_SQL();

#---------------------------------------
# Starting session and autorithing user
#---------------------------------------
session_name("PHPSESSID_L2JZsystem");
session_start();
if(!isset($_SESSION['GS']))$_SESSION['GS'] = 0;
if(!isset($_SESSION['login']))$_SESSION['login'] = '';
if(!isset($_SESSION['builder']))$_SESSION['builder'] = 0;
#---------------------------------------
# Initializing user array.
#---------------------------------------
$l2jz_user['login']   = $USER['login']   = $_SESSION["login"];
$l2jz_user['builder'] = $USER['builder'] = $_SESSION["builder"];
$l2jz_user['GS']      = $USER['GS']      = $_SESSION['GS'];
$l2jz_user['LS']      = $USER['LS']      = 0;

#---------------------------------------
# Security check.
#---------------------------------------
//начальная инициализация системных переменных.
$_RES = array(
	'status' => array(
		'status'   => 'ok',
		'dataType' => 'mixed',
	),
	'result' => NULL,
);
$_RESULT =& $_RES['result'];
$_JS     =& $_RES['js'];
$fullQuery = $l2jz_query = $VARS['l2jz_query'] = $_REQUEST['l2jz_query'];
$QUERY = $l2jz[$l2jz_query];
//проверка наличия запроса
if(!isset($l2jz[$l2jz_query])){
	$GLOBALS['_RES']['status']['status'] = 'no_access';
	print "No such query: $l2jz_query.";
	exit();
}
//начальная проверка безопасности
$access = FALSE;
if($USER['builder']>=$GLOBALS['l2jz'][$l2jz_query]['access']){
	$access = TRUE;
}
if((!isset($QUERY['sAccess']))&&(!$access)){
	$GLOBALS['_RES']['status']['status'] = 'no_access';
	exit();
}
//проверяем и инициализируем переменные переданные сценарию
if(isset($QUERY['vars']))foreach($QUERY['vars'] as $varName=>$var){
	if(!isset($_POST[$varName]))error("No <b>".$varName."</b> variable.");
	$varValue = $_POST[$varName];
	if($var['clearVar']=='TRUE')$varValue = trim(addslashes($varValue));
	if($var['type']=="none"){
		$GLOBALS[$varName] = $VARS[$varName] = $varValue;
	} else {
		$GLOBALS[$varName] = $VARS[$varName] = call_user_func("checkVariable_".$var['type'],$varValue,$var);
	}
	$fullQuery .= ".".$VARS[$varName];
}
//Если мы ещё не получили доступ на общих основаниях и запрос предусматривает
//специальную проверку доступа, делаем её.
if(isset($QUERY['sAccess'])&&(!$access)){
	$access = call_user_func("checkAccessSpecial_".$QUERY['sAccess']);
}
if(!$access){
	$GLOBALS['_RES']['status']['status'] = 'no_access';
	exit();
}

#---------------------------------------
# Checking caching of this page.
#---------------------------------------
if(
	($cfg['cache']===TRUE)&&
	(isset($l2jz[$l2jz_query]['cache']))&&
	($l2jz[$l2jz_query]['access']==0)&&
	($USER['builder']==0)
){
	$cache_string = $USER['GS'];
	foreach($VARS as $varName=>$varValue){
		$cache_string .= '_'.$varValue;
	}
	$JsHttpRequest->cache_string = $cache_string;
	$last_modify=time()-@filemtime($GLOBALS['cfg']['l2jzHomeDir']."/cache/".$cache_string);
	if($last_modify<$l2jz[$l2jz_query]['cache']){
		$JsHttpRequest->use_cache = TRUE;
		print "The data was generated ".$last_modify." seconds ago.";
		exit();
	} else {
		$JsHttpRequest->cache_result = TRUE;
	}
}
#---------------------------------------
# executing client query.
#---------------------------------------
$workMode = $cfg['workMode'];
if($l2jz[$l2jz_query]['handler'][$workMode]){
	require $l2jz[$l2jz_query]['handler'][$workMode];
} else error("There is no handler for this query.");
?>