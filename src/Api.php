<?php

namespace Barua;

class Api {

	public $username;
	public $usertoken;
	public $url = 'https://app.smartemailing.cz/api/v2';

	public function __construct($username, $usertoken, $url = null) {
		$this->username = $username;
		$this->usertoken = $usertoken;
		if ($url) {
			$this->url = $url;
		}
	}

	public function createRequest() {
		return new Request($this);
	}

	public function usersTestCredentials() {
		return $this->createRequest()->setEndpoint('Users', 'testCredentials')->getResponse()->getString();
	}

	public function usersGetId() {
		return $this->createRequest()->setEndpoint('Users', 'getId')->getResponse()->getString();
	}

	public function campaignsGetAll() {
		return $this->createRequest()->setEndpoint('Campaigns', 'getAll')->getResponse()->getList()->getAsModels('Campaign');
	}

}
