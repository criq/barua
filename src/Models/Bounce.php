<?php

namespace Brief\Models;

class Bounce extends \Brief\Model {

	public $contactId;
	public $type;
	public $reason;
	public $message;
	public $time;
	public $emailAddress;

	public function __construct($api, $data) {
		parent::__construct($api);

		$this->contactId    = (int)    $data->contact_id;
		$this->type         = (int)    $data->type;
		$this->reason       = (string) $data->reason;
		$this->message      = (string) trim($data->message);
		$this->time         = (string) $data->time;
		$this->emailAddress = (string) $data->emailaddress;
	}

	public function getHash() {
		return sha1(\Katu\Utils\JSON::encodeStandard([
			(int) $this->contactId,
			(int) $this->type,
			(string) $this->reason,
			(string) $this->message,
			(string) $this->time,
			(string) $this->emailAddress,
		]));
	}

}
