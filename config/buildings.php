<?php
/**
 * Тут постройки. У каждой постройки есть
 * - зависимости (что нужно построить до постройки данной)
 * - стоимость в ресурсах
 * const RESOURCE_TYPE_CLAY = 0;
 * const RESOURCE_TYPE_CROP = 1;
 * const RESOURCE_TYPE_WOOD = 2;
 * const RESOURCE_TYPE_IRON = 3;
 *
 * - время строительства
 * - прирост культуры
 * - прирост защиты города
 * - потребление кропа для поддержания постройки
 *
 * multi - коэффициент для стоимости, культуры, защиты и т.п. при повышении уровня
 */

$buildingTypeMain = 1;
$buildingTypeClay = 2;
$buildingTypeCrop = 3;

/**
 * хомячьи постройки
 */
$hamstersBuildings = array(
	$buildingTypeMain => array(
		'name'        => 'Пещера рабов',
		'description' => 'В пещере рабов содержатся самые неудачливые хомяки из низших сословий. Именно они херачат все постройки в городе.
		Каждый уровень пещеры рабов добавляет одно койкоместо, что сокращает время постройки новых зданий на 2%',
		'max_level'   => 40,
		'cost'        => array(
			100,
			50,
			100,
			20
		),
		'multi'       => 2.1,
		'time'        => 60,
		'culture'     => 2,
		'defence'     => 1,
		'energy'      => 1
	),
	$buildingTypeClay => array(
		'name'        => 'Фильтронасосная очистная станция при клозетах',
		'description' => 'В станцию входит труба. Выходит нечто, что рабы называют "глиной", но мы-то знаем. Из "глины" строятся основные постройки.',
		'max_level'   => 20,
		'cost'        => array(
			10,
			100,
			140,
			30
		),
		'multi'       => 1.5,
		'time'        => 40,
		'culture'     => 1,
		'defence'     => 0,
		'energy'      => 1
	),
	$buildingTypeCrop => array(
		'name'        => 'Колхоз',
		'description' => 'В колхозе крепостные хомяки занимаются выращиванием зерна. С каждым уровнем колхоза используется больше ГМО',
		'max_level'   => 20,
		'cost'        => array(
			150,
			20,
			100,
			100
		),
		'multi'       => 1.5,
		'time'        => 40,
		'culture'     => 1,
		'defence'     => 0,
		'energy'      => 1
	),
);
/**
 * совиные постройки
 */
$owlsBuildings = array();
/**
 * постройки кротов
 */
$diggersBuildings = array();

return array(
	'hamsters' => $hamstersBuildings,
	'owls'     => $owlsBuildings,
	'diggers'  => $diggersBuildings
);