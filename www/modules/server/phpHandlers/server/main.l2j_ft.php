<?php
$GS = $USER['GS'];
$_RESULT                 = $cfg['GS'][$GS]['info'];
$_RESULT['acc_count']    = $sql->getElem("SELECT COUNT(login) FROM accounts","LS");
$_RESULT['char_count']   = $sql->getElem("SELECT COUNT(obj_id) FROM characters");
$_RESULT['sum_level']    = $sql->getElem("SELECT SUM(level) FROM character_subclasses");
$_RESULT['adena_count']  = $sql->getElem("SELECT SUM(count) FROM items WHERE item_id=57");
?>