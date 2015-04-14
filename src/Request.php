<?php

namespace Barua;

class Request {

	public $api;
	public $xml;

	public function __construct($api) {
		$this->api = $api;

		$this->xml = new \SimpleXMLElement('<xmlrequest/>');
		$this->xml->addChild('username', $this->api->username);
		$this->xml->addChild('usertoken', $this->api->usertoken);

		return $this;
	}

	public function setEndpoint($type, $method) {
		$this->xml->addChild('requesttype', $type);
		$this->xml->addChild('requestmethod', $method);

		return $this;
	}

	public function post() {
		$curl = new \Curl\Curl();

		if (!isset($this->xml->details)) {
			$this->xml->addChild('details');
		}

		return new Response($curl, $curl->post($this->api->url, $this->xml->asXml()));
	}

}
