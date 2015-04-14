<?php

namespace Brief;

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

	public function setDetails($details) {
		$details = $this->xml->addChild('details');
		foreach ($details as $key => $value) {
			$details->addChild($key, $value);
		}

		return $this;
	}

	public function getResponse() {
		$curl = new \Curl\Curl();

		if (!isset($this->xml->details)) {
			$this->xml->addChild('details');
		}

		$response = new Response($curl, $curl->post($this->api->url, $this->xml->asXml()));

		if ($curl->curl_error_code) {
			throw new Exceptions\CurlException($curl->curl_error_message, $curl->curl_error_code);
		}
		if ($curl->http_status_code !== 200 && $curl->http_status_code !== 400) {
			throw new Exceptions\HttpException($curl->error_message, $curl->http_status_code);
		}
		if ($curl->http_status_code === 400) {
			throw new Exceptions\ResponseException($response->getError());
		}
		if ($response->isFailed()) {
			throw new Exceptions\ResponseException($response->getError());
		}

		return $response;
	}

}
