<?php
namespace PFBC\Element;

class CKEditor extends Textarea {
	protected $basic;

    public function render() {
        echo "<textarea", $this->getAttributes(array("value", "required")), ">";
        if(!empty($this->_attributes["value"]))
            echo $this->_attributes["value"];
        echo "</textarea>";
    }

	function renderJS() {
		echo 'CKEDITOR.replace("', $this->_attributes["id"], '"';
		if(!empty($this->basic))
			echo ', { toolbar: "Basic" }';
		echo ');';

		$ajax = $this->_form->getAjax();
		$id = $this->_form->getAttribute("id");
		if(!empty($ajax)) {
			echo <<<JS
	jQuery("#$id").bind("submit", function() {
		CKEDITOR.instances["{$this->_attributes["id"]}"].updateElement();
	});
JS;
		}
	}

	function getJSFiles() {
		return array(
			$this->_form->getResourcesPath() . "/ckeditor/ckeditor.js"
		);
	}
}	
