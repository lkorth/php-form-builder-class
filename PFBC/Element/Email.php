<?php
namespace PFBC\Element;

class Email extends Textbox {
	protected $attributes = array("type" => "email");

	public function render() {
		$this->validation[] = new \PFBC\Validation\Email;
		parent::render();
	}
}
