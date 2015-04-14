<?php

namespace Barua;

class Request {

	public $api;

	public function __construct($api) {
		$this->api = $api;
	}

	public function post($endpoint, $payload) {
		$curl = new \Curl\Curl(implode('/', [
			rtrim($this->api->url, '/'),
			ltrim($endpoint, '/'),
		]));

		var_dump($curl);

		return $curl->post($payload);
	}

}
