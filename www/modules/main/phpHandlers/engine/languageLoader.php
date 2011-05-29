<?php
if(!defined('L2JZ'))exit;
if(!preg_match("/^\w*$/",$languageName))setErrorCode("wrongLanguage");
if(!file_exists($GLOBALS['cfg']['l2jzHomeDir']."/engine/js/language/".$languageName.".js"))setErrorCode("wrongLanguage");

setcookie("language",$languageName,0x6FFFFFFF);
$_JS = join('',file($GLOBALS['cfg']['l2jzHomeDir']."/engine/js/language/".$languageName.".js"));
?>