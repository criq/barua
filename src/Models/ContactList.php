<?php

namespace Barua\Models;

class ContactList {

	public $id;
	public $name;

	public function __construct($data) {
		$this->id    = (int)    $data->id;
		$this->name  = (string) $data->name;
	}

}
