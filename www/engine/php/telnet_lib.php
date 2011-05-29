<?php
class l2jz_telnet {
	function command($command){
		$GS = $GLOBALS['USER']['GS'];
		$fp=@fsockopen(
			$GLOBALS['cfg']['GS'][$GS]['ip'],
			$GLOBALS['cfg']['GS'][$GS]['telnetport'],
			$errno,
			$errstr
		);
		if(!$fp){
			error("<font color=#6F5A0B>Warning:</font> No telnet connection to ".$GLOBALS['cfg']['GS'][$GS]['info']['name'].".<br>");
		} else{
			fputs($fp,$GLOBALS['GS'][$GS]['telnetpass']."\r");
			fputs($fp, $command);
			fputs($fp,"quit\r");
			while(!feof($fp))$output.=fread($fp,16);
			fclose($fp);
			$clear_r=array("Please Insert Your Password!","Password: Password Correct!","Welcome To The L2J Telnet Session.","[L2J]","Bye Bye!");
			$output = str_replace($clear_r,"", $output);
			if(strstr($output,"Incorrect Password!")){
				error("<font color=#6F5A0B>Warning:</font> Incorrect Telnet Password.<br>");
			}
			return $output;
		}
	}
	
	function kickById($char_id){
		
	}
	
	function kickByName($char_name){
		$this->command("kick ".$char_name."\r");
	}
	
	function getObjId(){
		
	}
}
?>