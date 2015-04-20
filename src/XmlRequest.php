<?php

namespace Brief;

class XmlRequest {

	public $api;
	public $xml;

	public function __construct($api) {
		$this->api = $api;

		$this->xml = new \SimpleXMLElement('<xmlrequest/>');
		$this->xml->addChild('username', $this->api->username);
		$this->xml->addChild('usertoken', $this->api->usertoken);

		return $this;
	}

	public function addChild($name, $value = null) {
		return $this->xml->addChild($name, $value);
	}

	public function asXml() {
		if (!isset($this->xml->details)) {
			$this->xml->addChild('details');
		}

		return $this->xml->asXml();
	}

}
