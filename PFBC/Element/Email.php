<?php
namespace PFBC\Element;

class Email extends Textbox {
	public function render() {
		$this->validation[] = new \PFBC\Validation\Email;
		parent::render();
	}
}
