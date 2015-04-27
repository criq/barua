<?php

namespace Brief\Models;

class ContactList extends \Brief\Model {

	public $id;
	public $name;

	public function __construct($api, $data) {
		parent::__construct($api);

		$this->id    = (int)    $data->id;
		$this->name  = (string) $data->name;
	}

}
