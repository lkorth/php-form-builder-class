<?php
namespace PFBC\Element;

class Sort extends \PFBC\OptionElement {
    protected $jQueryOptions;

	public function getCSSFiles() {
		return array(
			$this->form->getPrefix() . "://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css"
		);
	}

	public function getJSFiles() {
		return array(
			$this->form->getPrefix() . "://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"
		);
	}

    public function jQueryDocumentReady() {
        echo 'jQuery("#', $this->attributes["id"], '").sortable(', $this->jQueryOptions(), ');';
        echo 'jQuery("#', $this->attributes["id"], '").disableSelection();';
    }

    public function render() {
        if(substr($this->attributes["name"], -2) != "[]")
            $this->attributes["name"] .= "[]";

        echo '<ul id="', $this->attributes["id"], '">';
        foreach($this->options as $value => $text) {
            $value = $this->getOptionValue($value);
            echo '<li class="ui-state-default"><input type="hidden" name="', $this->attributes["name"], '" value="', $value, '"/>', $text, '</li>';
        }
        echo "</ul>";
    }

    public function renderCSS() {
        echo '#', $this->attributes["id"], ' { list-style-type: none; margin: 0; padding: 0; cursor: pointer; max-width: 400px; }';
        echo '#', $this->attributes["id"], ' li { margin: 0.25em 0; padding: 0.5em; font-size: 1em; }';
    }
}
