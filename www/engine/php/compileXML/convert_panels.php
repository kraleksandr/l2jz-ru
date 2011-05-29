<?php
function processPanelSection($section,$config){
	//Разбор атрибутов.
	$config = getSectionAttr($section,$config);
	$sectionName = $config['name'];
	
	//Разбор тэгов.
	for($i=0;$i<$section->childNodes->length;$i++){
		$node = $section->childNodes->item($i);
		switch($node->nodeName){
			case"section":
				processPanelSection($node,$config);
			break;
			case"panel":
				processPanel($node,$config);
			break;
		}
	}
}

function processPanel($panel,$config){
	$config = getSectionAttr($panel,$config);
	$panelName = $config['name'];
	$config['fields'] = array();
	for($i=0;$i<$panel->childNodes->length;$i++){
		$node = $panel->childNodes->item($i);
		switch($node->nodeName){
			case"fields":
				$config['fields'] = processPanelFields($node);
			break;
			case"onAny":case"onClick":case"onChange":
				$handler = jsCodeToTasks(trim($node->firstChild->data),'noFrame');
				$config[$node->nodeName] = $handler['code'];
				if(isset($handler['queryLinks']))$config['queryLinks'] = $handler['queryLinks'];
			break;
		}
	}

	$modultName = $GLOBALS['moduleName'];
	if(isset($GLOBALS['modules'][$modultName]['panels'][$panelName])){
		print "Warning: Redefination of <b>$panelName</b> panel.<br>";
	}
	//Выбираем из панели определения для файла языка.
	$config = processPanelForH($config);
	$GLOBALS['modules'][$modultName]['panels'][$panelName]  = $config;
}

function processPanelFields($fieldsNode){
	$fields = array();
	for($i=0;$i<$fieldsNode->childNodes->length;$i++){
		$fieldNode = $fieldsNode->childNodes->item($i);
		$field = getAttr($fieldNode);
		$fieldName = $field['name'];
		$field['type'] = $fieldNode->nodeName;
		$fields[$fieldName] = array('html'=>'');
		if($field['type']=="select")$fields[$fieldName]['optionMaker'] = "var optionArray=new Array();";
		foreach($field as $col=>$val){
			switch($col){
				case"name":
				case"value":
				case"class":
				case"type":
				case"minlength":
				case"equal":
				case"email":
				case"hLink":
				case"h":
					$fields[$fieldName][$col] = $val;
				break;
				default:
					$fields[$fieldName]['html'] .= " $col='$val'";
			}
		}
		for($j=0;$j<$fieldNode->childNodes->length;$j++){
			$node = $fieldNode->childNodes->item($j);
			switch($node->nodeName){
				case"onAny":case"onClick":case"onChange":case"optionMaker":
					$handler = jsCodeToTasks(trim($node->firstChild->data),'noFrame');
					$fields[$fieldName][$node->nodeName] = $handler['code'];
					if(isset($handler['queryLinks']))$config['queryLinks'] = $handler['queryLinks'];
				break;
				case"option":
					$option = getAttr($node);
					$fields[$fieldName]['optionMaker'] .=  "optionArray.push('".$option['name']."');";
				break;
			}
		}
	}
	return $fields;
}

function processPanelForH($config){
	$panelName = $config['name'];
	$language = $GLOBALS['cfg']['baseLanguage'];
	$panelHName = "panel.".$panelName;
	if(isset($config['h'])){
		$GLOBALS['hLanguage'][$language][$panelHName] = str_replace('\n',"\n",str_replace('\t',"\t",$config['h']));
		unset($config['h']);
	}
	foreach($config['fields'] as $fieldName=>$field){
		if(isset($field['h'])){
			$fieldHName = "panel.".$panelName.".".$fieldName;
			print $fieldHName."<br>";
			$GLOBALS['hLanguage'][$language][$fieldHName] = str_replace('\n',"\n",str_replace('\t',"\t",$field['h']));
			unset($config[fields][$fieldName]['h']);
		}
	}
	return $config;
}
?>