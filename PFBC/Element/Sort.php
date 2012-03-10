<?php
namespace PFBC\Element;

class Sort extends \PFBC\OptionElement {
	protected $jQueryOptions;

	public function jQueryDocumentReady() {
		echo 'jQuery("#', $this->attributes["id"], ' ul").sortable(', $this->jQueryOptions(), ');';
		echo 'jQuery("#', $this->attributes["id"], ' ul").disableSelection();';
	}

	public function render() { 
		if(!isset($this->attributes["value"]) || !is_array($this->attributes["value"]))
			$this->attributes["value"] = array();

		if(substr($this->attributes["name"], -2) != "[]")
			$this->attributes["name"] .= "[]";
		
		$count = 0;
		$items = array();
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);

			$index = array_search($value, $this->attributes["value"]);
			if($index === false)
				$index = $count;
			$items[$index] = '<li class="ui-state-default"><input type="hidden" name="' . $this->attributes["name"] . '" value="' . $value . '"/>' . $text . '</li>';

			++$count;
		}	

		ksort($items);
		echo '<div id="', $this->attributes["id"], '"><ul>', implode("", $items), '</ul></div>';
	}

	public function renderCSS() {
		echo '#', $this->attributes["id"], ' ul { list-style-type: none; margin: 0; padding: 0; cursor: pointer; }';
		echo '#', $this->attributes["id"], ' ul li { margin: 0.25em 0; padding: 0.5em; font-size: 1em; }';
	}
}
