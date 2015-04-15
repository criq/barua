<?php

namespace Brief;

class Response {

	public $response;
	public $xml;

	public function __construct($response) {
		$this->response = $response;
		$this->xml = new \SimpleXMLElement($this->response->getBody()->getContents());
	}

	public function getStatus() {
		if (isset($this->xml->status)) {
			return (string) $this->xml->status;
		}

		return false;
	}

	public function getError() {
		if (isset($this->xml->errormessage)) {
			return (string) $this->xml->errormessage;
		}

		return false;
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

	public function isSuccessful() {
		return $this->getStatus() == 'SUCCESS';
	}

	public function isFailed() {
		return $this->getStatus() == 'FAILED';
	}

}
