<?php
namespace PFBC\Element;

class Date extends Textbox {
	protected $jQueryOptions;
	
	public function jQueryDocumentReady() {
		parent::jQueryDocumentReady();
		echo 'jQuery("#', $this->attributes["id"], '").datepicker(', $this->jQueryOptions(), ');';
	}

	public function render() {
		$this->validation[] = new \PFBC\Validation\Date;
		parent::render();
	}
}
