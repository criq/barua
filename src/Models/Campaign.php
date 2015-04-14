<?php

namespace Brief\Models;

class Campaign {

	public $id;
	public $name;
	public $title;
	public $htmlbody;
	public $textbody;

	public function __construct($data) {
		$this->id       = (int)    $data->id;
		$this->name     = (string) $data->name;
		$this->title    = (string) $data->title;
		$this->htmlbody = (string) base64_decode($data->htmlbody);
		$this->textbody = (string) $data->textbody;
	}

}
