<?php

namespace Brief\Models;

class Contact extends \Brief\Model {

	public $id;
	public $status;
	public $added;
	public $emailAddress;

	public function __construct($api, $data) {
		parent::__construct($api);

		$this->id           = (int)    $data->contact_id;
		$this->status       = (string) $data->status;
		$this->added        = (string) $data->added;
		$this->emailAddress = (string) $data->emailaddress;
	}

}
