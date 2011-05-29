<?php
//-----------//
// MLOADER  //
//---------//
/* Этот скрипт предназначен для закачки на клиент модуля. Модуль это папка
 * лежащая в папке modules.
 * Могут быть следующие типы файлов:
 *	имя.htm имя.html
 *		на клиент будет загружен шаблон с именем "путь.имя".
 *	имя.tlist.htm имя.tlist.html
 *		В таких файлах будут искаться все тэги вида <template id="имя_шаблона"></template>.
 *		Содержимое каждого такого тэга будет загружено на сервер в виде шаблона с именем "путь.имя_шаблона".
 *	имя.js
 *		Содержимое файла загружается на клиент и исполняется как JS код.
 */
if(!defined('L2JZ'))exit;
if(!preg_match("/^\w*$/",$moduleName))setErrorCode("wrongModule");
if(!file_exists($GLOBALS['cfg']['l2jzHomeDir']."/modules/".$moduleName))setErrorCode("wrongModule");
	
$_JS = join('',file($GLOBALS['cfg']['l2jzHomeDir']."/engine/js/modules/".$moduleName.".js"));
?>