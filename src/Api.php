<?php

namespace Barua;

class Api {

	public $username;
	public $token;
	public $url = 'https://app.smartemailing.cz/api/v2';

	public function __construct($username, $token, $url = null) {
		$this->username = $username;
		$this->token = $token;
		if ($url) {
			$this->url = $url;
		}
	}

	public function post() {

	}

	public function usersTestCredentials() {
		$request = new Request($this);

		var_dump($request);
	}

}
