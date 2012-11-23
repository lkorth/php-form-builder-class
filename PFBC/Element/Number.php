<?php
namespace PFBC\Element;

class Number extends Textbox {
	protected $_attributes = array("type" => "number");

	public function render() {
		$this->validation[] = new \PFBC\Validation\Numeric;
		parent::render();
	}
}
