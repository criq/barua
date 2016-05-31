<?php

namespace Brief\Models;

class Autoresponder extends \Brief\Model {

	public $id;
	public $name;
	public $active;

	public function __construct($api, $data) {
		parent::__construct($api);

		$this->id       = (int)    $data->id;
		$this->name     = (string) $data->name;
		$this->active   = (bool)   $data->active;
	}

	public function getBounces() {
		return $this->api->autoresponderStatsGetBounces($this->id)
			;
	}

	public function getSentReport() {
		$url = $this->api->getCsvUrl('autoresponder-sent', [
			'jobid' => $this->id,
		]);

		return \Katu\Utils\CSV::readToArray(\Katu\Utils\Tmp::save('autoresponderGetSentReport.csv', (new \Curl\Curl)->get($url)), [
			'delimiter' => ';',
		]);
	}

	public function getBouncedReport() {
		$url = $this->api->getCsvUrl('autoresponder-bounced', [
			'jobid' => $this->id,
		]);

		return \Katu\Utils\CSV::readToArray(\Katu\Utils\Tmp::save('autoresponderGetBouncedReport.csv', (new \Curl\Curl)->get($url)), [
			'delimiter' => ';',
		]);
	}

}
