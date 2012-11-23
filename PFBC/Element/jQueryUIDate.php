<?php
namespace PFBC\Element;

class jQueryUIDate extends Textbox {
	protected $_attributes = array(
		"type" => "text",
		"autocomplete" => "off"
	);
    protected $jQueryOptions;

	public function getCSSFiles() {
		return array(
			$this->_form->getPrefix() . "://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css"
		);
	}

	public function getJSFiles() {
		return array(
			$this->_form->getPrefix() . "://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"
		);
	}

    public function jQueryDocumentReady() {
        parent::jQueryDocumentReady();
        echo 'jQuery("#', $this->_attributes["id"], '").datepicker(', $this->jQueryOptions(), ');';
    }

    public function render() {
        $this->validation[] = new \PFBC\Validation\Date;
        parent::render();
    }
}
