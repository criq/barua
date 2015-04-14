<?php

namespace Barua\Data;

class DataString extends Data {

	public function __toString() {
		return trim((string) $this->data);
	}

}
