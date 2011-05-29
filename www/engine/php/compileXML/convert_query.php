<?php
function processQuery($query,$configJS,$configPHP){
	//Разбор атрибутов.
	$configJS  = getSectionAttr($query,$configJS);
	$configPHP = getSectionAttr($query,$configPHP);
	$queryName = $configJS['name'];
	if(isset($configPHP['cacheJS']))unset($configPHP['cacheJS']);
	if(isset($configPHP['saveJS']))unset($configPHP['saveJS']);
	if(isset($configPHP['saveMode']))unset($configPHP['saveMode']);
	//Разбор тэгов.
	for($i=0;$i<$query->childNodes->length;$i++){
		$node = $query->childNodes->item($i);
		switch($node->nodeName){
			case"variable":
				$var = getAttr($node,array('clearVar'=>'TRUE'));
				$varName = $var['name'];
				$configJS['vars'][$varName] = $configPHP['vars'][$varName] = $var;
			break;
			case"phpHandler":
				$phpHandler = getAttr($node,array('workMode'=>'default'));
				$workMode = $phpHandler['workMode'];
				$modultName = $GLOBALS['moduleName'];
				
				if(!isset($GLOBALS['cfg']['workModes'][$workMode])){
					print "Warning: Invalid workMode '".$workMode."'.";
				} else {
					$configPHP['handler'][$workMode] = "engine/php/phpHandlers/".$queryName.".".$workMode.".php";
					$fp = fopen($GLOBALS['cfg']['l2jzHomeDir']."/".$configPHP['handler'][$workMode], "w");
					fwrite($fp,"<?php if(!defined('L2JZ'))exit;\n".trim($node->firstChild->data)." ?>");
					fclose($fp);
				}
			break;
		}
	}
	//Определение обработчиков запроса.
	$modultName = $GLOBALS['moduleName'];
	foreach($GLOBALS['cfg']['workModes'] as $group)if(!isset($configPHP['handler'][$group])){
		$configPHP['handler'][$group] = searchQueryHandler($group,$modultName,$queryName);
		if($configPHP['handler'][$group]===NULL){
			print "Warning: Query <b>$queryName</b> has no handler for <b>$group</b> handler group.<br>";
		}
	}
	if(isset($GLOBALS['l2jz'][$queryName])){
		print "Warning: Redefination of <b>$queryName</b> query.<br>";
	}
	unset($configJS['name']);
	unset($configPHP['name']);
	$GLOBALS['l2jzJS'][$queryName]  = $configJS;
	$GLOBALS['l2jz'][$queryName]     = $configPHP;
}

function processQuerySection($section,$configJS,$configPHP){
	//Разбор атрибутов.
	$configJS  = getSectionAttr($section,$configJS);
	$configPHP = getSectionAttr($section,$configPHP);
	//Разбор тэгов.
	for($i=0;$i<$section->childNodes->length;$i++){
		$node = $section->childNodes->item($i);
		switch($node->nodeName){
			case"section":
				processQuerySection($node,$configJS,$configPHP);
			break;
			case"query":
				processQuery($node,$configJS,$configPHP);
			break;
			case"variable":
				$var = getAttr($node,array('clearVar'=>'TRUE'));
				$varName = $var['name'];
				$configJS['vars'][$varName] = $configPHP['vars'][$varName] = $var;
			break;
		}
	}
}
	
function searchQueryHandler($group,$modultName,$query){
	$search_path = str_replace('.','/',$query);
	$length = strlen($search_path);
	while(1){
		if(file_exists($GLOBALS['cfg']['l2jzHomeDir']."/modules/".$modultName."/phpHandlers/".$search_path.".".$group.".php")){
			return "modules/".$modultName."/phpHandlers/".$search_path.".".$group.".php";
		}
		$search_path = preg_replace("/(.*)\/\w*/","$1",$search_path);
		if($length === strlen($search_path))break;
		$length = strlen($search_path);
	}
	$search_path = str_replace('.','/',$query);
	$length = strlen($search_path);
	while(1){
		if(file_exists($GLOBALS['cfg']['l2jzHomeDir']."/modules/".$modultName."/phpHandlers/".$search_path.".php")){
			return "modules/".$modultName."/phpHandlers/".$search_path.".php";
		}
		$search_path = preg_replace("/(.*)\/\w*/","$1",$search_path);
		if($length === strlen($search_path))break;
		$length = strlen($search_path);
	}
	return NULL;
}
?>