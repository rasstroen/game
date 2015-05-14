<?php
namespace Application\Module\Account;

use Application\Module\Base;


class Login extends Base
{
	public function actionShowLogin()
	{
		$data = array();
		if($this->application->currentAccount->isLoggedIn())
		{
			$data['account'] = $this->application->currentAccount->getAccountData(
				$this->application->currentAccount->getAccountId()
			);
		}

		return $data;
	}

	public function doLogin()
	{
		$email    = $this->application->request->getPostParam('email');
		$password = $this->application->request->getPostParam('password');
		if($this->application->currentAccount->login($email, $password))
		{
			die('ok');
		}
	}
}