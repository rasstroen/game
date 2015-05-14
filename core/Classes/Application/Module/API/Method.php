<?php
namespace Application\Module\API;

use Application\Module\Base;


class Method extends Base
{
	public function actionExecuteMethod()
	{
		$data                     = array();
		$data['production']       = $this->application->currentVillage->getProduction();
		$data['productionEnergy'] = $this->application->currentVillage->getProductionEnergy();

		return $data;
	}
}