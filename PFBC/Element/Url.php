<?php
namespace PFBC\Element;

class Url extends Textbox {
	protected $attributes = array("type" => "url");

	public function render() {
		$this->validation[] = new \PFBC\Validation\Url;
		parent::render();
	}
}
