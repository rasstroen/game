<?php
function templateHtmlShowMain(array $data)
{
	?>
	<div class="header">
		<div class="plank">
			<ul class="links">
				<li>
					<a target="inner" href="/start">шахты</a>
					<a target="inner" href="/buildings">постройки</a>
					<a target="inner" href="/map">карта</a>
					<a target="inner" href="/reports">отчеты</a>
				</li>
			</ul>
			<ul class="production">
				<li class="crop"><span>0</span><input type="hidden" value="0" class="value"><input type="hidden" value="0" class="energy"></li>
				<li class="wood"><span>0</span><input type="hidden" value="0" class="value"><input type="hidden" value="0" class="energy"></li>
				<li class="iron"><span>0</span><input type="hidden" value="0" class="value"><input type="hidden" value="0" class="energy"></li>
				<li class="clay"><span>0</span><input type="hidden" value="0" class="value"><input type="hidden" value="0" class="energy"></li>
			</ul>
		</div>
	</div>
	<div class="content">
		<iframe name="inner" id="inner" frameborder="0" width="100%" height="500px" src="<?= $data['iframe']['src'] ?>"></iframe>
	</div>
	<div class="friends">

	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/js/main.js"></script>
	<script>
		game.start();
	</script>
<?php
}