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

		if ($curl->curlError) {
			throw new Exceptions\CurlException($curl->curlErrorMessage, $curl->curlErrorCode);
		} elseif ($curl->httpError) {
			throw new Exceptions\HttpException($curl->httpErrorMessage, $curl->httpStatusCode);
		}

		return new Response($response);
	}

}
