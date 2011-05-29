<?php
if($sql->getCount("SELECT obj_id FROM characters WHERE char_name='$char_name'")!=1){
	setErrorCode("noSuchChar");
}
if($sql->getCount("SELECT obj_id FROM characters WHERE account_name='$login'")>6){
	setErrorCode("fullAccount");
}

//$telnet->kick($char_id);
$sql->query("UPDATE characters SET account_name='$login' WHERE char_name='$char_name'");
?>