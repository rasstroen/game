<?php
namespace Application\Module\Village;

use Application\Module\Base;


class Production extends Base
{
	public function actionShowProductionEnergy()
	{
		$data = array();

		$data['production_energy'] = $this->application->currentVillage->getProductionEnergy();

		return $data;
	}
}