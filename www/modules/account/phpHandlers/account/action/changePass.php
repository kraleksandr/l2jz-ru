<?php
$sql->query("UPDATE accounts SET password='".$newPass."' WHERE login='".$login."'","LS");
?>