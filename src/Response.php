<?php

namespace Barua;

class Response {

	public function __construct($curl, $response) {
		$this->curl = $curl;
		$this->response = $response;
	}

	public function getStatus() {
		if (isset($this->response->status)) {
			return (string) $this->response->status;
		}

		return false;
	}

	public function getError() {
		if (isset($this->response->errormessage)) {
			return (string) $this->response->errormessage;
		}

		return false;
	}

	public function getData() {
		if (isset($this->response->data)) {
			return $this->response->data;
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
