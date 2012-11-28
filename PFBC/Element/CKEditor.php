<?php
namespace PFBC\Element;

class CKEditor extends Textarea {
    public function render() {
        echo "<textarea", $this->getAttributes(array("value", "required")), ">";
        if(!empty($this->_attributes["value"]))
            echo $this->_attributes["value"];
        echo "</textarea>";
    }

	function renderJS() {
		echo 'CKEDITOR.replace("', $this->_attributes["id"], '");';

		$ajax = $this->_form->getAjax();
		$id = $this->_form->getAttribute("id");
		if(!empty($ajax))
			echo 'jQuery("#', $id, '").bind("submit", function() { CKEDITOR.instances["', $this->_attributes["id"], '"].updateElement(); });';
	}

	function getJSFiles() {
		return array(
			$this->_form->getResourcesPath() . "/ckeditor/ckeditor.js"
		);
	}
}	
