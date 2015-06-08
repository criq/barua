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

}
