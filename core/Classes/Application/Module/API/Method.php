<?php
namespace Application\Module\API;

use Application\Module\Base;


class Method extends Base
{
	public function actionExecuteMethod()
	{
		$method = $this->application->request->getQueryParam('method');
		switch($method)
		{
			case 'refresh':
				return $this->methodRefresh();
				break;
			default:
				break;
		}
	}

	private function methodRefresh()
	{
		$data                     = array();
		$data['production']       = $this->application->currentVillage->getProduction();
		$data['productionEnergy'] = $this->application->currentVillage->getProductionEnergy();

		return $data;
	}
}