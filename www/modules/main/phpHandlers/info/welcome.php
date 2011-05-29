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
  <h1>Добро пожаловать!</h1>
	<span class="style1">
Вы находитесь на сервере La2.Balancer.Ru (LBR).<br /><br />
<ul>
<li>Адрес основного сервера - <a href="http://la2.balancer.ru/">http://la2.balancer.ru/</a></li>
<li>Внутренняя информация (реальные рейты, статистика...) основного сервера: <a href="http://la2.balancer.ru:7776">http://la2.balancer.ru:7776</a>
<li>Внутренняя информация (реальные рейты, статистика...) тестового сервера: <a href="http://la2.balancer.ru:7778">http://la2.balancer.ru:7778</a>
</ul>
	
	</span>
</center>
<?php $_RESULT = ob_get_contents(); ob_end_clean(); ?>