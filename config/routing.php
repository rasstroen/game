<?php

$modules = array(
	'main_frame' => array(
		'className' => '\Application\Module\Html\MainFrame',
		'template'  => 'html',
		'action'    => 'show',
		'mode'      => 'main'
	),
	'method'     => array(
		'className' => '\Application\Module\API\Method',
		'template'  => 'method',
		'action'    => 'execute',
		'mode'      => 'method'
	),
	'farms'      => array(
		'className' => '\Application\Module\Html\Farms',
		'template'  => 'farms',
		'action'    => 'show',
		'mode'      => 'farms'
	),
	'buildings'  => array(
		'className' => '\Application\Module\Html\Buildings',
		'template'  => 'buildings',
		'action'    => 'show',
		'mode'      => 'buildings'
	),
	/**
	 * Плашка с производством деревни
	 */
	'village_production_energy' => array(
		'className' => '\Application\Module\Village\Production',
		'template'  => 'village',
		'action'    => 'show',
		'mode'      => 'productionEnergy'
	),

);

return array(
	'map'     => array(
		''          => 'index',
		'start'     => 'start',
		'buildings' => 'buildings',
		'method'    => array(
			'%s' => array(
				'' => 'method'
			)
		)
	),
	'pages'   => array(
		/**
		 * Главный фрейм
		 */
		'index'     => array(
			'layout' => 'index',
			'title'  => 'Кроты Хомяки'
		),
		/**
		 * Стартовая страница - внутренний фрейм
		 */
		'start'     => array(
			'layout' => 'inner',
			'title'  => '-',
			'blocks' => array(
				'content' => array(
					'farms' => $modules['farms']
				),
				'sidebar' => array(
					'production_energy' => $modules['village_production_energy'],
					//'troops'            => $modules['troops']
				)
			)
		),
		/**
		 * Постройки
		 */
		'buildings' => array(
			'layout' => 'inner',
			'title'  => '-',
			'blocks' => array(
				'content' => array(
					'buildings' => $modules['buildings']
				),
				'sidebar' => array(
					'production_energy' => $modules['village_production_energy'],
				)
			)
		),
		/**
		 * Методы апи
		 */
		'method'    => array(
			'layout' => 'ajax',
			'blocks' => array(
				'response' => array(
					'method' => $modules['method']
				),
			)
		)
	),
	/**
	 * Умолчания для лайаутов
	 */
	'layouts' => array(
		/**
		 * Умолчания для админки
		 */
		'index' => array(
			'css'    => array(
				'reset' => '/css/reset.css',
				'index' => '/css/mainFrame.css',
			),
			'blocks' => array(
				'header'  => array(
					'login' => $modules['main_frame']
				),
				'footer'  => array(),
				'content' => array()
			)
		),
		'inner' => array(
			'css'    => array(
				'reset' => '/css/reset.css',
				'index' => '/css/inner.css',
			),
			'blocks' => array()
		),
	)
);