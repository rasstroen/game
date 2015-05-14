<?php

namespace Application\Component\Account;

use Application\Component\Base;

class Current extends Base
{
	private $isLoggedIn = false;
	private $accountId = 0;

	public function login($email, $password)
	{

	}

	public function getCurrentVillageId()
	{
		return 1;
	}

	public function getLoggedAccountId()
	{
		if($this->isLoggedIn())
		{
			return $this->accountId;
		}
	}

	protected function initialize()
	{

	}

	public function isLoggedIn()
	{
		return $this->isLoggedIn;
	}

	public function getAccountData($accountId)
	{
		return $this->application->bll->account->getById($accountId);
	}
}