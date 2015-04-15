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

	public function setDetails($array) {
		$details = $this->xml->addChild('details');
		foreach ($array as $key => $value) {
			$details->addChild($key, $value);
		}

		return $this;
	}

	public function getResponse() {
		$client = new \GuzzleHttp\Client();

		if (!isset($this->xml->details)) {
			$this->xml->addChild('details');
		}

		try {

			$response = $client->post($this->api->url, [
				'headers' => [
					'Content-Type' => 'text/xml; charset=UTF8',
				],
				'body' => $this->xml->asXml(),
			]);

			return new Response($response);

		} catch (\GuzzleHttp\Exception\ConnectException $e) {
			throw new Exceptions\HttpException($e->getMessage(), $e->getCode());
		} catch (\GuzzleHttp\Exception\ClientException $e) {
			throw new Exceptions\ResponseException((new \SimpleXMLElement($e->getResponse()->getBody()->getContents()))->errormessage);
		}
	}

}
