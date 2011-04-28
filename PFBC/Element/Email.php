<?php
namespace PFBC\Element;

class Email extends \PFBC\Element\Textbox {
	public function render() {
		$this->validation[] = new \PFBC\Validation\Email;
		parent::render();
	}
}
