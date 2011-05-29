<?php
function processPageSection($section,$config){
	//Разбор атрибутов.
	$config = getSectionAttr($section,$config);
	$sectionName = $config['name'];
	if(isset($config['name']))$sectionName = $config['name'];

	//Разбор startHandler и endHandler.
	$startHandler = $endHandler = '';
	for($i=0;$i<$section->childNodes->length;$i++){
		$node = $section->childNodes->item($i);
		switch($node->nodeName){
			case"startHandler":case"endHandler":
				$attr = getAttr($node);
				$handler = trim($node->firstChild->data);
				if(isset($attr['if'])){
					$handler = "if(".$attr['if']."){".$handler."}";
				}
				if($node->nodeName=="startHandler"){
					$startHandler = $startHandler.$handler;
				} else {
					$endHandler = $endHandler.$handler;
				}
			break;
		}
	}
	$config['startHandler'] = $config['startHandler'].$startHandler;
	$config['endHandler'] = $endHandler.$config['endHandler'];
	
	//Разбор остальных тэгов.
	for($i=0;$i<$section->childNodes->length;$i++){
		$node = $section->childNodes->item($i);
		switch($node->nodeName){
			case"section":
				processPageSection($node,$config);
			break;
			case"page":
				processPage($node,$config);
			break;
		}
	}
}

function processPage($node,$config){
	$config = getSectionAttr($node,$config);
	$page = $config['name'];
	$config['handler'] = (isset($node->firstChild->data))?trim($node->firstChild->data):'';
	$handler = jsCodeToTasks(
		$config['startHandler'].$config['handler'].$config['endHandler'],
		$config['frame']
	);
	$config['handler'] = $handler['code'];
	if(isset($handler['queryLinks']))$config['queryLinks'] = $handler['queryLinks'];
	unset($config['startHandler']);
	unset($config['endHandler']);

	$arguments = array();
	if(isset($config['arguments'])){
		$argumentsArray = explode(',',$config['arguments']);
		foreach($argumentsArray as $col=>$val){
			$arguments[$val] = $val;
		}
	}

	if(isset($GLOBALS['pages'][$page]))print "Warning: Redefination of <b>$page</b> page.<br>";
	if($config['handler']==="")print "Warning: Page <b>$page</b> has an empty handler.<br>";
	unset($config['name']);
	$GLOBALS['pagesTree'][$page]  = $config;
}
?>