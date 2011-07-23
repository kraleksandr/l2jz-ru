<?php ob_start(); ?>
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
<br>
<br>
<br>
<center>
  <h1>Welcome!</h1>
	<span class="style1">You may change this page in <em><strong>modules/main/phpHandlers/info/welcome.php</strong></em> file.</span>
</center>
<?php $_RESULT = ob_get_contents(); ob_end_clean(); ?>