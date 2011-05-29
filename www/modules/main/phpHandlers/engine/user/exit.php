<?php
$_RESULT['login'] = $_SESSION["login"] = '';
$_RESULT['builder'] = $_SESSION["builder"] = 0;
setcookie("login","",time()-3600);
setcookie("pass","",time()-3600);
?>