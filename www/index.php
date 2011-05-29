<?php
include 'option.php';
require "engine/php/config.php";
function php2js($a){
	if(is_null($a))return 'null';if($a===false)return 'false';if($a===true) return 'true';
	if(is_scalar($a)){
		$a=addslashes($a);
		$a=str_replace("\n",'\n',$a);
		$a=str_replace("\r",'\r',$a);
		return "'$a'";
	}
	$isList=true;
	for($i=0,reset($a);$i<count($a);$i++,next($a))if(key($a)!==$i){$isList=false;break;}
	$result = array();
	if($isList){
		foreach($a as $v)$result[]=php2js($v);
		return "[".join(",",$result)."]";
	} else {
		foreach ($a as $k=>$v)$result[]=php2js($k).': '.php2js($v);
		return "{".join(",",$result)."}";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>L2JZsystem 0.81</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php foreach($config['stylesheets'] as $col=>$css)print '<link rel="stylesheet" href="modules/'.$css.'.css" type="text/css">'; ?>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/tables.js"></script>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/preloadedData.js"></script>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/ajax.js"></script>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/doQuery.js"></script>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/doLoad.js"></script>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/html_lib.js"></script>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/sort_tables.js"></script>
		<script language="JavaScript" type="text/JavaScript" src="engine/js/l2jz.js"></script>
		<script language="JavaScript">
<?php
//Если пользователь менял Гейм сервер, устанавливаем Гейм сервер отличный от дефолтового.
if(isset($_COOKIE['GS'])){
	$GS = $_COOKIE['GS'];
	if(isset($cfg['GS'][$GS])){
		print "l2jz.GS = ".$GS.";";
	}
}

//Если пользователь менял язык, устанавливаем язык отличный от дефолтового.
if(isset($_COOKIE['language'])){
	$language = $_COOKIE['language'];
	foreach($config['languages'] as $col=>$val){
		if($val==$language)print "l2jz.language = '".$language."';";
	}
}

foreach($cfg['GS'] as $serverId=>$server){
	$config['gServers'][$serverId] = $server['info']['name'];
}
print "l2jz.config = ".php2js($config).";";
?>
		</script>
<?php 
foreach($config['javaScripts'] as $col=>$script){
	print '<script language="JavaScript" type="text/JavaScript" src="modules/'.$script.'.js"></script>';
}
?>
	</head>
	<body onLoad="l2jz.init();">
		<!-- This div is using to show tooltips. Don't edit it -->
		<div id="tooltip_section" style="visibility:hidden; position:absolute;z-index:101;"></div>
		
		<!-- Navigation panel -->
		<div id="navigationSection"></div>
		
		<!-- Main menu section -->
		<div id="mainMenuSection">
			<div id="l2jz_message">Loading...</div>
		</div>
		
		<!-- Map showing in this section -->
		<div id="mapSection" align="left"></div>
		
		<!-- All central sections -->
		<div id="centralSection">
			<table width="750">
				<tr align="left">
					<td><div id="topMenuSection"></div></td>
				</tr><tr align="center">
					<td><div id="adminSection" align="left"></div></td>
				</tr><tr align="center">
					<td id="pageTitleSection"></td>
				</tr><tr align="center">
					<td><div id="mainSection"></div></td>
				</tr><tr align="center">
					<td><div id="panelSection"></div></td>
				</tr><tr align="center">
					<td><div id="infoSection"></div></td>
				</tr>
			</table>
		</div>
		<br>
		<br>
	</body>
</html>