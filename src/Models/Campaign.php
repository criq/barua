<?php

namespace Brief\Models;

class Campaign extends \Brief\Model {

	public $id;
	public $name;
	public $title;
	public $htmlbody;
	public $textbody;

	public function __construct($api, $data) {
		parent::__construct($api);

		$this->id       = (int)    $data->id;
		$this->name     = (string) $data->name;
		$this->title    = (string) $data->title;
		$this->htmlbody = (string) base64_decode($data->htmlbody);
		$this->textbody = (string) $data->textbody;
	}

	public function update($name, $title, $htmlbody, $textbody) {
		return $this->api->campaignsUpdate($this->id, $name, $title, $htmlbody, $textbody);
	}

}
