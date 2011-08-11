<?php
namespace PFBC\Element;

class Textarea extends \PFBC\Element {
	protected $attributes = array("class" => "pfbc-textarea", "rows" => "5");

	public function jQueryDocumentReady() {
		echo 'jQuery("#', $this->attributes["id"], '").outerWidth(jQuery("#', $this->attributes["id"], '").width());';
	}

	public function render() {
        echo $this->preHTML, "<textarea", $this->getAttributes("value"), ">";
        if(!empty($this->attributes["value"]))
            echo $this->attributes["value"];
        echo "</textarea>", $this->postHTML;
    }
}
