<?php

namespace Barua\Models;

class Campaign {

	public $id;
	public $name;
	public $title;
	public $html;
	public $text;

	public function __construct($data) {
		$this->id    = (int)    $data->id;
		$this->name  = (string) $data->name;
		$this->title = (string) $data->title;
		$this->html  = (string) base64_decode($data->htmlbody);
		$this->text  = (string) $data->textbody;
	}

}
