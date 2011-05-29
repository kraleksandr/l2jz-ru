<?php
if(!defined('L2JZ'))exit;
if(!isset($cfg['GS'][$GS]))setErrorCode('noSuchGS');
$_SESSION['GS'] = $USER['GS'] = $GS;
setcookie("GS",$GS,0x6FFFFFFF);
foreach($cfg['GS'][$GS]['info'] as $col=>$val){
	$_RESULT[$col]=$cfg['GS'][$GS]['info'][$col];
}
$_RESULT['online']  = $sql->getElem("SELECT COUNT(online) FROM characters WHERE online=1");
$_RESULT['chars']   = $sql->getAssocColumn("SELECT obj_id FROM characters WHERE account_name='".$USER['login']."'");
?>