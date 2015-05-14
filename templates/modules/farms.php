<?php
function templateFarmsShowFarms(array $data)
{
	?>
	<ul class="farms"><?php
	foreach($data['farms'] as $farm)
	{
		?>
		<li class="<?=$farm['level'] ? 'active' : ''?>">
		<h3><?= htmlspecialchars($farm['title']); ?> уровня <?= htmlspecialchars($farm['level']); ?></h3>

		<p>времени на постройку: <b><?= htmlspecialchars($farm['time_next']) ?></b></p>

		<p>ресурсов на постройку: <b><?= htmlspecialchars(implode(', ', $farm['cost_next'])) ?></b></p>

		<p>текущий прирост: <b><?= htmlspecialchars($farm['energy']) ?></b></p>

		<p>прирост при апгрейде: <b><?= htmlspecialchars($farm['energy_next']) ?></b></p>
		</li><?php
	}
	?></ul><?php
}