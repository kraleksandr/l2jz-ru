<?php
//-----------//
// MLOADER  //
//---------//
/* ���� ������ ������������ ��� ������� �� ������ ������. ������ ��� �����
 * ������� � ����� modules.
 * ����� ���� ��������� ���� ������:
 *	���.htm ���.html
 *		�� ������ ����� �������� ������ � ������ "����.���".
 *	���.tlist.htm ���.tlist.html
 *		� ����� ������ ����� �������� ��� ���� ���� <template id="���_�������"></template>.
 *		���������� ������� ������ ���� ����� ��������� �� ������ � ���� ������� � ������ "����.���_�������".
 *	���.js
 *		���������� ����� ����������� �� ������ � ����������� ��� JS ���.
 */
if(!defined('L2JZ'))exit;
if(!preg_match("/^\w*$/",$moduleName))setErrorCode("wrongModule");
if(!file_exists($GLOBALS['cfg']['l2jzHomeDir']."/modules/".$moduleName))setErrorCode("wrongModule");
	
$_JS = join('',file($GLOBALS['cfg']['l2jzHomeDir']."/engine/js/modules/".$moduleName.".js"));
?>