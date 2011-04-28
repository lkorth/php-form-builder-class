<?php
namespace PFBC\Element;

class Date extends \PFBC\Element\Textbox {
	protected $jQueryOptions;
	
	public function jQueryDocumentReady() {
		parent::jQueryDocumentReady();
		echo 'jQuery("#', $this->attributes["id"], '").datepicker(', $this->jQueryOptions(), ');';
	}
}
