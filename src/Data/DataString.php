<?php

namespace Brief\Data;

class DataString extends Data {

	public function __toString() {
		return trim((string) $this->data);
	}

	public function getString() {
		return (string) $this;
	}

	public function getInt() {
		return (int) $this->getString();
	}

	public function getBoolean() {
		return (bool) $this->getString();
	}

}
