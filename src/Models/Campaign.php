<?php

namespace Barua\Models;

class Campaign {

	public $id;
	public $html;
	public $text;
	public $title;
	public $name;

	public function __construct($data) {
		$this->id    = (int)    $data->id;
		$this->html  = (string) base64_decode($data->htmlbody);
		$this->text  = (string) $data->textbody;
		$this->title = (string) $data->title;
		$this->name  = (string) $data->name;
	}

}
