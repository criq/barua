<?php

namespace Brief\Models;

class CustomField {

	public $id;
	public $name;
	public $type;

	public function __construct($data) {
		$this->id   = (int)    $data->id;
		$this->name = (string) $data->name;
		$this->type = (string) $data->type;
	}

}
