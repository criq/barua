<?php

namespace Brief;

class Request {

	public $api;
	public $xmlRequest;

	public $timeout = 30;

	public function __construct($api) {
		$this->api = $api;
		$this->xmlRequest = new XmlRequest($api);

		return $this;
	}

	public function setTimeout($timeout) {
		$this->timeout = $timeout;

		return $this;
	}

	public function setEndpoint($type, $method) {
		$this->xmlRequest->addChild('requesttype', $type);
		$this->xmlRequest->addChild('requestmethod', $method);

		return $this;
	}

	public function setXmlRequest($xmlRequest) {
		$this->xmlRequest = $xmlRequest;

		return $this;
	}

	public function setDetails($array) {
		$details = $this->xmlRequest->addChild('details');
		foreach ($array as $key => $value) {
			$details->addChild($key, $value);
		}

		return $this;
	}

	public function getResponse() {
		$curl = new \Curl\Curl();
		$curl->setHeader('Content-Type', 'text/xml; charset=UTF8');
		$curl->setTimeout($this->timeout);
		$response = $curl->post($this->api->apiUrl, $this->xmlRequest->asXml());

		if ($curl->curl_error) {
			throw new Exceptions\CurlException($curl->curl_error_message, $curl->curl_error_code);
		} elseif ($curl->http_error) {
			throw new Exceptions\HttpException($curl->http_error_message, $curl->http_status_code);
		}

		return new Response($response);
	}

}
