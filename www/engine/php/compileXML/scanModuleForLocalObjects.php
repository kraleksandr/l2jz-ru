<?php
function scanModuleForLocalObjects($dirName,$path,$module){
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
				case"htm":case"html":
					switch($fileArray[1]){
						case"tlist":
							print "<div class='template'>".$file."</div><div class='container'>";
							preg_match_all(
								'/<template\sid=[\'\"]([\w.]*)[\'\"]>(.*?)<\/template>/sm',
								join('',file($fileName)),
								$templates,
								PREG_SET_ORDER
							);
							foreach($templates as $col=>$template){
								$filename = $filePath.".".$template[1];
								print "<div class='template'>".$template[1]."</div>";
								$GLOBALS['modules'][$module]['templates'][$filename] = $template[2];
							}
							print "</div>";
						break;
						default:
							print "<div class='template'>".$file."</div>";
							$GLOBALS['modules'][$module]['templates'][$filePath] = join('',file($fileName));
					}
				break;
				case"css":
					print "<div class='css'>".$file."</div>";
					$GLOBALS['configArray']['stylesheets'][] = str_replace('.','/',$filePath);
				break;
				case"js":
					print "<div class='js'>".$file."</div>";
					$GLOBALS['configArray']['javaScripts'][] = str_replace('.','/',$filePath);
					$jsCode = join('',file($fileName));
					if(preg_match("/l2jz\.checkScriptVersion\('\w*'\)/m",$jsCode)){
						$jsCode = preg_replace(
							"/l2jz\.checkScriptVersion\('\w*'\)/m",
							"l2jz.checkScriptVersion('".$GLOBALS['l2jzVersionId']."')",
							$jsCode
						);
					} else {
						$jsCode = $jsCode."\nl2jz.checkScriptVersion('".$GLOBALS['l2jzVersionId']."');";
					}
					$fp = fopen($fileName,"w");fwrite($fp,$jsCode);fclose($fp);
				break;
				case"php":
					print "<div class='php'>".$file."</div>";
				break;
				case"xml":
					switch($fileArray[1]){
						case"lng":
							$root = getXML($fileName);
							print "<div class='languageRoot'>".$file."</div>";
							processH($root,"",$fileArray[2]);
						break;
						case"panels":
							$root = getXML($fileName);
							$filePath = (isset($fileArray[2]))?($path.".".$fileArray[2]):($path);
							print "<div class='panelRoot'>".$file."</div>";
							processPanelSection($root,array('name'=>$filePath,'module'=>$module));
						break;
						case"tables":
							$root = getXML($fileName);
							$filePath = (isset($fileArray[2]))?($path.".".$fileArray[2]):($path);
							print "<div class='tableRoot'>".$file."</div>";
							processTableSection(
								$root,
								array(
									'name'     => $filePath
								)
							);
						break;
					}
				break;
			}
		} else {
			print "<div class='folder'>".$file."</div><div class='container'>";
			scanModuleForLocalObjects($fileName,$path.".".$file,$module);
			print "</div>";
		}
	}
	chdir($ask_dir);
}
?>