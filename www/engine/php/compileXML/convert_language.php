<?php
function processH($h,$path,$language){
	$attr = getAttr($h);
	if(isset($attr['name'])){
		if($path===""){
			$path = $attr['name'];
		} else {
			$path .= ".".$attr['name'];
		}
	}
	if(isset($attr['value'])){
		switch($attr['value']){
			case"@@CDATA@@":
				if($h->firstChild->nodeName=="#text"){
					$attr['value'] = $h->firstChild->data;
				} else {
					print "Warning: Invalid @@CDATA@@ instruction for <b>$name</b";
				}
			break;
			default:
				$attr['value'] = str_replace('\n',"\n",$attr['value']);
				$attr['value'] = str_replace('\t',"\t",$attr['value']);
		}
		if(isset($GLOBALS['hLanguage'][$language][$path])){
			$moduleName = $GLOBALS['moduleName'];
			print "Warning: Redefinetion of language element <b>$path</b> in module <b>$moduleName</b>, language <b>$language</b>.<br>";
		}
		$GLOBALS['hLanguage'][$language][$path] = $attr['value'];
	}
	for($i=0;$i<$h->childNodes->length;$i++){
		processH($h->childNodes->item($i),$path,$language);
	}
}
?>