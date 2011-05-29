<?php
//-----------//
// SQL LIB  //
//---------//
/* ѕроста€ библиотека дл€ работы с MySQL базой данных.
 */
class l2jz_SQL {
	var $sqlBases = array(
		"LS" => FALSE,
		"GS" => FALSE,
	);
	
	function l2jz_SQL(){}
	
	function connect($type){
		if(!isset($this->sqlBases[$type]))error("Invalid DataBase type: <b>$type</b>.");
		$num = $GLOBALS['USER'][$type];
		$this->sqlBases[$type] = mysql_pconnect(
			$GLOBALS['cfg'][$type][$num]['mysql_address'],
			$GLOBALS['cfg'][$type][$num]['mysql_login'],
			$GLOBALS['cfg'][$type][$num]['mysql_password']
		);
		if(!$this->sqlBases[$type])error("<h3>".$type."[".$GLOBALS['cfg'][$type][$num]['info']['name']."]:Problem connecting to MySQL database...</h3>\n");
		mysql_select_db($GLOBALS['cfg'][$type][$num]['mysql_database']);
	}
	
	function getElem($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			$row = mysql_fetch_row($result);
			return $row[0];
		} else {
			error("Invalid SQL result for query: $query");
		}
	}
	
	function getRow($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			return mysql_fetch_assoc($result);
		} else {
			error("Invalid SQL result for query: $query");
		}
	}
	
	function getColumn($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			$column = array();
			while($row=mysql_fetch_row($result))$column[] = $row[0];
			return $column;
		} else {
			error("Invalid SQL result for query: $query");
		}
	}
	
	function getAssocColumn($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			$column = array();
			for($i=0;$row=mysql_fetch_row($result);$i++){
				$value = $row[0];
				$column[$value] = $i;
			}
			return $column;
		} else {
			error("Invalid SQL result for query: $query");
		}
	}
	
	function getRows($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			$rows = array();
			while($row=mysql_fetch_assoc($result))$rows[] = $row;
			return $rows;
		} else {
			error("Invalid SQL result for query: $query");
		}
	}
	
	function getCount($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			return mysql_num_rows($result);
		} else {
			error("Invalid SQL result for query: $query");
		}
	}
	
	function fetchAssoc($result){
		return mysql_fetch_assoc($result);
	}
	
	function numRows($result){
		return mysql_num_rows($result);
	}
	
	function saveRow($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			$GLOBALS['_RESULT'] = mysql_fetch_assoc($result);
			if(mysql_num_rows($result)===0){
				$GLOBALS['_RES']['status']['status'] = 'empty';
			}
		} else {
			error("Invalid SQL result for query: ".$query.".");
		}
	}
	
	function saveRows($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			if(!isset($GLOBALS['_RESULT']['count'])){
				while($field = mysql_fetch_field($result)){
					$GLOBALS['_RESULT']['head'][] = $field->name;
				}
			}
			$GLOBALS['_RES']['status']['count'] += mysql_num_rows($result);
			while($row = mysql_fetch_row($result)){
				$GLOBALS['_RESULT']['body'][] = $row;
			}
			$GLOBALS['_RES']['status']['dataType'] = 'sqlRows';
		} else {
			error("Invalid SQL result for query: ".$query.".");
		}
	}
	
	function query($query,$type="GS"){
		if($this->sqlBases[$type]===FALSE)$this->connect($type);
		$result = mysql_query($query,$this->sqlBases[$type]) or error("<font color=red>MySQL ERROR:</font> ".mysql_error());
		if($result){
			return $result;
		} else {
			error("Invalid SQL result for query: $query");
		}
	}
}
?>