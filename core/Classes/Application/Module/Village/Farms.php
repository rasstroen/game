<?php
namespace Application\Module\Village;

use Application\Module\Base;


class Farms extends Base
{
	public function actionShowFarms()
	{
		$data               = array();

		$data['farms'] = $this->application->currentVillage->getFarms();
		return $data;
	}
}