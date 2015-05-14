<?php

namespace Application\Component\Account;

use Application\BLL\Village;
use Application\Component\Base;

class CurrentVillage extends Base
{
	/**
	 * @var Current
	 */
	private $currentAccount;

	public $resourceName = array(
		Village::RESOURCE_TYPE_CLAY => 'clay',
		Village::RESOURCE_TYPE_CROP => 'crop',
		Village::RESOURCE_TYPE_WOOD => 'wood',
		Village::RESOURCE_TYPE_IRON => 'iron'
	);

	public function initialize()
	{
		$this->currentAccount = $this->application->currentAccount;
	}

	public function getProduction()
	{
		$out        = array();
		$production = $this->application->bll->village->getProduction($this->currentAccount->getCurrentVillageId());
		$this->recalculateProduction($production);
		foreach($production as $key => $value)
		{
			$out[$this->resourceName[$key]] = $value;
		}

		return $out;
	}

	public function getLastProductionSave()
	{
		$productionSave = $this->application->bll->village->getProductionLastSave($this->currentAccount->getCurrentVillageId());

		return $productionSave;
	}

	public function getProductionEnergy()
	{
		$out              = array();
		$productionEnergy = $this->application->bll->village->getProductionEnergy($this->currentAccount->getCurrentVillageId());
		foreach($productionEnergy as $key => $value)
		{
			$out[$this->resourceName[$key]] = $value;
		}

		return $out;
	}

	public function recalculateProduction(&$production, $needSave = false)
	{
		$productionEnergy = $this->getProductionEnergy();
		$timeLeft         = time() - $this->getLastProductionSave();
		foreach($production as $key => &$value)
		{
			$value += $timeLeft * $productionEnergy[$this->resourceName[$key]] / 60 / 60;
		}
		unset($value);
		if($needSave)
		{
			$this->saveProduction($production);
		}
	}

	public function saveProduction($production)
	{
		$this->application->bll->village->saveProduction(
			$this->currentAccount->getCurrentVillageId(),
			$production
		);
	}
}