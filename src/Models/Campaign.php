<?php

namespace Barua\Models;

class Campaign {

	public $id;
	public $htmlbody;
	public $textbody;
	public $title;
	public $name;

	public function __construct($data) {
		$this->id       = (int)    $data->id;
		$this->htmlbody = (string) base64_decode($data->htmlbody);
		$this->textbody = (string) $data->textbody;
		$this->title    = (string) $data->title;
		$this->name     = (string) $data->name;
	}

}
