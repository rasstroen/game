<?php
namespace Application\Module\Html;

use Application\Module\Base;


class MainFrame extends Base
{
	public function actionShowMain()
	{
		$data               = array();
		$data['iframe']     = array(
			'src' => $this->application->urlManager->getStartUrl()
		);
		return $data;
	}
}