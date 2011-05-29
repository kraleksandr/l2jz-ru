<?php
function processFrames($root){
	for($i=0;$i<$root->childNodes->length;$i++){
		$frame = $root->childNodes->item($i);
		if($frame->nodeName!="frame")continue;
		$frameArray = getAttr($frame);
		for($j=0;$j<$frame->childNodes->length;$j++){
			$childNode = $frame->childNodes->item($j);
			switch($childNode->nodeName){
				case"handler":
					$frameArray['handler'] = trim($childNode->firstChild->data);
				break;
			}
		}
		$frameName = $frameArray['name'];
		$GLOBALS['frames'][$frameName] = $frameArray;
	}
}
?>