<?php

namespace Brief\Models;

class CustomField extends \Brief\Model {

	public $id;
	public $name;
	public $type;

	public function __construct($api, $data) {
		parent::__construct($api);

		$this->id   = (int)    $data->id;
		$this->name = (string) $data->name;
		$this->type = (string) $data->type;
	}

}
