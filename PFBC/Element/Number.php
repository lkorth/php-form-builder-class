<?php
namespace PFBC\Element;

class Number extends Textbox {
	protected $attributes = array("type" => "number");

	public function render() {
		$this->validation[] = new \PFBC\Validation\Numeric;
		parent::render();
	}
}
