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
	/**
	 * @var arrayСлоты для постройки ферм в деревне.
	 * Всего 16 слотов, по 4 слота на каждый ресурс
	 */
	private $farmsSlots = array(
		0  => Village::RESOURCE_TYPE_CLAY,
		1  => Village::RESOURCE_TYPE_CLAY,
		2  => Village::RESOURCE_TYPE_CLAY,
		3  => Village::RESOURCE_TYPE_CLAY,
		4  => Village::RESOURCE_TYPE_CROP,
		5  => Village::RESOURCE_TYPE_CROP,
		6  => Village::RESOURCE_TYPE_CROP,
		7  => Village::RESOURCE_TYPE_CROP,
		8  => Village::RESOURCE_TYPE_WOOD,
		9  => Village::RESOURCE_TYPE_WOOD,
		10 => Village::RESOURCE_TYPE_WOOD,
		11 => Village::RESOURCE_TYPE_WOOD,
		12 => Village::RESOURCE_TYPE_IRON,
		13 => Village::RESOURCE_TYPE_IRON,
		14 => Village::RESOURCE_TYPE_IRON,
		15 => Village::RESOURCE_TYPE_IRON,
	);

	private $farmTypeToBuildingType = array(
		Village::RESOURCE_TYPE_CLAY => 2,
		Village::RESOURCE_TYPE_CROP => 3,
		Village::RESOURCE_TYPE_WOOD => 4,
		Village::RESOURCE_TYPE_IRON => 5,
	);

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

	/**
	 * Какие слоты для ферм свободны в деревне?
	 */
	public function getFarms()
	{
		$buildings     = $this->application->configuration->getLibrary('buildings');
		$raceBuildings = $buildings[$this->application->currentAccount->getRaceName()];

		/**
		 * Какие слоты заняты, id слота => уровень
		 */
		$existFarms = $this->application->bll->village->getFarms(
			$this->currentAccount->getCurrentVillageId()
		);
		/**
		 * По каждому слоту считаем, сколько стоит апгрейд (для незанятых - постройка первого уровня) фермы
		 */
		$availableToBuildFarms = array();

		foreach($this->farmsSlots as $slotId => $slotType)
		{
			$libBuilding                    = $raceBuildings[$this->farmTypeToBuildingType[$slotType]];
			$availableToBuildFarms[$slotId] = $libBuilding;


			if(isset($existFarms[$slotId]))
			{
				$availableToBuildFarms[$slotId]['level']   = $existFarms[$slotId];
				$availableToBuildFarms[$slotId]['cost_next']    = $this->multArray($libBuilding['cost'], $libBuilding['multi'], $existFarms[$slotId]);
				$availableToBuildFarms[$slotId]['energy']  = $this->mult($libBuilding['energy'], $libBuilding['multi'], $existFarms[$slotId]);
				$availableToBuildFarms[$slotId]['culture'] = $this->mult($libBuilding['culture'], $libBuilding['multi'], $existFarms[$slotId]);
				$availableToBuildFarms[$slotId]['defence'] = $this->mult($libBuilding['defence'], $libBuilding['multi'], $existFarms[$slotId]);

				$availableToBuildFarms[$slotId]['energy_next']  = $this->mult($libBuilding['energy'], $libBuilding['multi'], $existFarms[$slotId] + 1);
				$availableToBuildFarms[$slotId]['culture_next'] = $this->mult($libBuilding['culture'], $libBuilding['multi'], $existFarms[$slotId] + 1);
				$availableToBuildFarms[$slotId]['defence_next'] = $this->mult($libBuilding['defence'], $libBuilding['multi'], $existFarms[$slotId] + 1);
				$availableToBuildFarms[$slotId]['time_next']    = $this->mult($libBuilding['time'], $libBuilding['multi'], $existFarms[$slotId]);

			}
			else
			{
				$availableToBuildFarms[$slotId]['level'] = 0;
				$availableToBuildFarms[$slotId]['cost_next']  = $libBuilding['cost'];

				$availableToBuildFarms[$slotId]['energy']  = 0;
				$availableToBuildFarms[$slotId]['culture'] = 0;
				$availableToBuildFarms[$slotId]['defence'] = 0;


				$availableToBuildFarms[$slotId]['energy_next']  = $this->mult($libBuilding['energy'], $libBuilding['multi'], 1);
				$availableToBuildFarms[$slotId]['culture_next'] = $this->mult($libBuilding['culture'], $libBuilding['multi'], 1);
				$availableToBuildFarms[$slotId]['defence_next'] = $this->mult($libBuilding['defence'], $libBuilding['multi'], 1);
				$availableToBuildFarms[$slotId]['time_next']    = $this->mult($libBuilding['time'], $libBuilding['multi'], 1);
			}
		}

		/**
		 * @todo помечать, какие из ферм строятся сейчас на основе очередей - их апгрейдить нельзя
		 */

		return $availableToBuildFarms;
	}

	private function mult($value, $multiplicator, $level, $roundBy = 0)
	{
		for($i = 1; $i < $level; $i++)
		{
			$value *= $multiplicator;
			$value = round($value, $roundBy);
		}

		return $value;
	}

	private function multArray($array, $multiplicator, $level, $roundBy = 0)
	{
		for($i = 0; $i < $level; $i++)
		{
			foreach($array as &$value)
			{
				$value *= $multiplicator;
				$value = round($value, $roundBy);
			}

			unset($value);
		}

		return $array;
	}
}