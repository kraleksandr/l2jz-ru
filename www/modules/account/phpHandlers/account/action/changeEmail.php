<?php
$sql->query("UPDATE accounts SET email='$email' WHERE login='".$login."'","LS");
$_RESULT['email'] = $email;
?>