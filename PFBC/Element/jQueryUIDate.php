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
			$this->_form->getResourcesPath() . "/jquery-ui-1.10.0/css/smoothness/jquery-ui.min.css"
		);
	}

	public function getJSFiles() {
		return array(
			$this->_form->getResourcesPath() . "/jquery-ui-1.10.0/js/jquery-ui.min.js"
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
