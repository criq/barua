<?php

namespace Brief;

class Response {

	public $response;
	public $xml;

	public function __construct($response) {
		$this->response = $response;
		$this->xml = new \SimpleXMLElement($this->response->getBody()->getContents());
	}

	public function getData() {
		if (isset($this->xml->data)) {
			return $this->xml->data;
		}

		return false;
	}

	public function getString() {
		return new Data\DataString($this->getData());
	}

	public function getList() {
		return new Data\DataList($this->getData());
	}

	public function getModel($api, $model) {
		$class = "\\Brief\\Models\\" . $model;

		return new $class($api, $this->getData());
	}

}
