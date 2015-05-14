<?php
namespace Application\BLL;

class Village extends BLL
{
	private $cachedVillages = array();

	public function getVillage($villageId)
	{
		if(!isset($this->cachedVillages[$villageId]))
		{
			$this->cachedVillages[$villageId] =  $this->getDbWeb()->selectRow(
				'SELECT * FROM village WHERE `village_id` = ?',
				array(
					$villageId
				)
			);
		}
		return $this->cachedVillages[$villageId];
	}

	private function getVillageProperty($villageId, $propertyName)
	{
		$villageData = $this->getVillage($villageId);

		return $villageData[$propertyName];
	}

	public function getProduction($villageId)
	{
		return explode('|', $this->getVillageProperty($villageId, 'production'));
	}

	public function getProductionLastSave($villageId)
	{
		return $this->getVillageProperty($villageId, 'production_save');
	}

	public function saveProduction($villageId, array $production, $time = null)
	{
		if(!$time)
		{
			$time = time();
		}

		unset($this->cachedVillages[$villageId]);

		return $this->getDbMaster()->query(
			'UPDATE `village` SET `production` = ?, `production_save` = ? WHERE `village_id` = ?',
			array(
				implode('|', $production),
				$time,
				$villageId
			)
		);
	}

	public function getProductionEnergy($villageId)
	{
		return explode('|', $this->getVillageProperty($villageId, 'production_energy'));
	}
}