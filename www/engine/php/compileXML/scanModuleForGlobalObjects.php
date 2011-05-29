<?php
function scanModuleForGlobalObjects($dirName,$path,$module){
	chdir($dirName);
	$dir = opendir($dirName);
	while($file=readdir($dir)){
		if(preg_match("/^\..*$/",$file))continue;
		$fileName  = $dirName."/".$file;
		if(is_file($fileName)){
			$fileArray = explode(".",$file);
			$filePath  = $path.".".$fileArray[0];
			$fileArray = array_reverse($fileArray);
			switch($fileArray[0]){
				case"xml":
					switch($fileArray[1]){
						case"pages":
							$root = getXML($fileName);
							processPageSection(
								$root,
								array(
									'startHandler' => '',
									'endHandler'   => '',
									'handler'      => '',
									'module'       => $module,
									'frame'        => 'main',
								)
							);
						break;
						case"query":
							$root = getXML($fileName);
							processQuerySection(
								$root,
								array('saveJS'=>'@:a.l2jz_query:@','access'=>0),
								array('access'=>0)
							);
						break;
						case"frames":
							$root = getXML($fileName);
							processFrames($root);
						break;
					}
				break;
			}
		}
	}
	chdir($ask_dir);
}
?>