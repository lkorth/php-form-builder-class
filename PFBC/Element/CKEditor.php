<?php
namespace PFBC\Element;

class CKEditor extends Textarea {
	protected $basic;

    public function render() {
        echo "<textarea", $this->getAttributes(array("value", "required")), ">";
        if(!empty($this->attributes["value"]))
            echo $this->attributes["value"];
        echo "</textarea>";
    }

	function renderJS() {
		echo 'CKEDITOR.replace("', $this->attributes["id"], '"';
		if(!empty($this->basic))
			echo ', { toolbar: "Basic" }';
		echo ');';

		$ajax = $this->form->getAjax();
		$id = $this->form->getID();
		if(!empty($ajax)) {
			echo <<<JS
	jQuery("#$id").bind("submit", function() {
		CKEDITOR.instances["{$this->attributes["id"]}"].updateElement();
	});
JS;
		}
	}

	function getJSFiles() {
		return array(
			$this->form->getResourcesPath() . "/ckeditor/ckeditor.js"
		);
	}
}	
