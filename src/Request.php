<?php

namespace Brief;

class Request {

	public $api;
	public $xmlRequest;

	public function __construct($api) {
		$this->api = $api;
		$this->xmlRequest = new XmlRequest($api);

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
		$client = new \GuzzleHttp\Client();

		try {

			$response = $client->post($this->api->url, [
				'headers' => [
					'Content-Type' => 'text/xml; charset=UTF8',
				],
				'body' => $this->xmlRequest->asXml(),
			]);

			return new Response($response);

		} catch (\GuzzleHttp\Exception\ConnectException $e) {
			throw new Exceptions\HttpException($e->getMessage(), $e->getCode());
		} catch (\GuzzleHttp\Exception\ClientException $e) {
			throw new Exceptions\ResponseException((new \SimpleXMLElement($e->getResponse()->getBody()->getContents()))->errormessage);
		}
	}

}
