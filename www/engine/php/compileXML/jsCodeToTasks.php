<?php
function jsOperatorsToTasks($tokens,$frameName,$codeLevel=0){
	$code = "";
	//Если в коде нету вызовов doQuery помещаем его весь в один l2jz.addTask().
	$codeToTasks = FALSE;
	for($i=0;$i<count($tokens);$i++){
		if(preg_match("/^doQuery\(/",$tokens[$i]))$codeToTasks = TRUE;
	}
	if($codeToTasks==FALSE){
		while($oprt=array_pop($tokens))$code .= $oprt;
		return $code;
	}
	while($oprt=array_pop($tokens)){
		switch($oprt){
			case"if":case"switch":case"for":case"while":
				//IF
				$code .= "l2jz.addTask('".$frameName."',function(){".$oprt.array_pop($tokens);
				$oprt = array_pop($tokens);
				if($oprt=="{"){
					$ifBody = array();
					$codeBalance = 1;
					while(1){
						$oprt = array_pop($tokens);
						if($oprt=='{')$codeBalance++;
						if($oprt=='}')$codeBalance--;
						if($codeBalance==0)break;
						array_push($ifBody,$oprt);
					}
					$code .= "{".jsOperatorsToTasks(array_reverse($ifBody),$frameName,$codeLevel+1)."}";
				} else $code .= $oprt;
				//ELSE
				$oprt = array_pop($tokens);
				if($oprt=="else"){
					$code .= "else ";
					$oprt = array_pop($tokens);
					if($oprt=="{"){
						$ifBody = array();
						$codeBalance = 1;
						while(1){
							$oprt = array_pop($tokens);
							if($oprt=='{')$codeBalance++;
							if($oprt=='}')$codeBalance--;
							if($codeBalance==0)break;
							array_push($ifBody,$oprt);
						}
						$code .= "{".jsOperatorsToTasks(array_reverse($ifBody),$frameName,$codeLevel+1)."}";
					} else $code .= $oprt;
				} else array_push($tokens,$oprt);
				$code .= "},".$codeLevel.");";
			break;
			default:
				$code .= "l2jz.addTask('".$frameName."',function(){".$oprt."},".$codeLevel.");\n";
		}
	}
	return $code;
}

function jsClearCode($code){
	
}

function jsCodeToTasks($code,$frameName){
	//Разбиваем код на токены.
	$tokens    = array();
	$tokensCount = 0;
	$code = trim($code);
	$result = array();
	while(strlen($code)>0){
		$tokensCount++;
		$c = $code[0];
		if(preg_match('/\w/',$c)){
			preg_match('/^(\w*)/',$code,$array);
			$tokens[] = $array[1];
			$code = substr($code,strlen($array[1]));
		} elseif(($c=='\'')||($c=='"')){
			for($j=1;1;$j++)if($code[$j]==$c)if($code[$j-1]!='\\')break;
			$tokens[] = substr($code,0,$j+1);
			$code = substr($code,$j+1);
		} elseif(preg_match('/\s/',$c)) {
			$code = trim($code);
			$tokens[] = ' ';
		} elseif($c=='('){
			$balance = 1;
			for($j=1;$balance!=0;$j++){
				if($code[$j]=='(')$balance++;
				if($code[$j]==')')$balance--;
			}
			$tokens[] = substr($code,0,$j);
			$code = substr($code,$j);
		} else {
			$tokens[] = $c;
			$code = substr($code,1);
		}
	}
	
	//Удаляем лишние пробелы и собираем все группы токенов в круглых скобках в один токен.
	$mode = "new";
	$code = array("");
	$balance = $i = 0;
	foreach($tokens as $col=>$token){
		if($token=="("){
			$mode = "add";
			$balance++;
		}
		if($token==")"){
			$balance--;
		}
		$code[$i] .= $token;
		if($mode=="new"){
			$i++;
			$code[$i] = "";
		}
	}
	
	//Собираем в один токен операторы оканчивающиеся точкой с запятой.
	$code = array_reverse($code);
	$mode = "new";
	$tokens = array();
	$i = -1;
	foreach($code as $col=>$token){
		if(($token=='{')||($token=='}')||($token=="if")||($token=="else")||($token=="switch")||($token=="for")||($token=="while")){	
			$i++;
			$mode = "new";
			$tokens[$i] = $token;
		} else if($token==";"){
			$i++;
			$mode = "add";
			$tokens[$i] = $token;
		} else if($mode=="new"){
			$i++;
			$tokens[$i] = $token;
		} else {
			$tokens[$i] = $token.$tokens[$i];
		}
	}
	
	//Удаляем все пробельные операторы
	$code = array();
	foreach($tokens as $col=>$token)if(($token!="")&&($token!=" "))$code[] = trim($token);
	
	//Сканируем код на наличие операторов doQuery
	foreach($code as $col=>$oprt)if(preg_match("/^doQuery\((.*?),/",$oprt,$array)){
		$result['queryLinks'][] = $array[1];
	}
	$result['code'] = jsOperatorsToTasks($code,$frameName);
	return $result;
}
?>