<?php
namespace PFBC\Element;

class Email extends Textbox {
	protected $_attributes = array("type" => "email");

	public function render() {
		$this->validation[] = new \PFBC\Validation\Email;
		parent::render();
	}
}
