<?php
function processTableSection($section,$config){
	//Разбор атрибутов.
	$config = getSectionAttr($section,$config);	
	//Разбор тэгов.
	for($i=0;$i<$section->childNodes->length;$i++){
		$node = $section->childNodes->item($i);
		switch($node->nodeName){
			case"section":
				processTableSection($node,$config);
			break;
			case"table":
				processTable($node,$config);
			break;
		}
	}
}

function processTable($tableNode,$config){
	//Разбор атрибутов.
	$config = getSectionAttr($tableNode,$config);
	$tableName = $config['name'];
	//Разбор тэгов.
	for($i=0;$i<$tableNode->childNodes->length;$i++){
		$node = $tableNode->childNodes->item($i);
		switch($node->nodeName){
			default:
				$config['filters'][] = processTableFilter($node);
		}
	}
	$modultName = $GLOBALS['moduleName'];
	if(isset($GLOBALS['modules'][$modultName]['tables'][$tableName]))print "Warning: Redefination of <b>$tableName</b> table.<br>";
	unset($config['name']);
	$GLOBALS['modules'][$modultName]['tables'][$tableName]  = $config;
}

function processTableFilter($filterNode){
	$filter = getAttr($filterNode,array('type'=>$filterNode->nodeName));
	for($i=0;$i<$filterNode->childNodes->length;$i++){
		$node = $filterNode->childNodes->item($i);
		$column = getAttr($node,array('type'=>$node->nodeName,'access'=>0));
		if(!preg_match('/^\d+$/',$column['access'])){
			$queryLink = $column['access'];
			if(isset($GLOBALS['l2jz'][$queryLink])){
				$column['access'] = $GLOBALS['l2jz'][$queryLink]['access'];
			} else {
				print "Warning: Column[".$column['name']."] is linked to unknown query: $queryLink<br>";
				$column['access'] = 0;
			}
		}
		$filter['columns'][] = $column;
	}
	return $filter;
}
?>