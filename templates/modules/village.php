<?php
function templateVillageShowProductionEnergy(array $data)
{
	?>
	<h3>production per hour</h3>
	<ul class="villageProductionEnergy"><?php
	foreach($data['production_energy'] as $productionType => $energy)
	{
		?>
		<li><?= htmlspecialchars($productionType) ?> : <?= htmlspecialchars($energy) ?></li>
	<?php
	}
	?></ul><?php
}