<?php

namespace Brief\Data;

class DataList extends Data implements \IteratorAggregate {

	public function getList() {
		if (isset($this->data->item)) {
			$list = [];
			foreach ($this->data->item as $i) {
				$list[] = $i;
			}

			return $list;
		}

		return false;
	}

	public function getIterator() {
		return new \ArrayIterator($this->getList());
	}

	public function getModels($api, $model) {
		$class = "\\Brief\\Models\\" . $model;
		$list = [];
		foreach ($this as $item) {
			$list[] = new $class($api, $item);
		}

		return $list;
	}

}
