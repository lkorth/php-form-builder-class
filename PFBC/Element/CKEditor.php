<?php
namespace PFBC\Element;

class CKEditor extends Textarea {
	protected $basic;

	function renderJS() {
		echo 'CKEDITOR.replace("', $this->attributes["id"], '"';
		if(!empty($this->basic))
			echo ', { toolbar: "Basic" }';
		echo ');';

		$ajax = $this->_form->getAjax();
		$id = $this->_form->getID();
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
			$this->_form->getResourcesPath() . "/ckeditor/ckeditor.js"
		);
	}
}	
