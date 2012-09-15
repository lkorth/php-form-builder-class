<?php
namespace PFBC\Element;

class Select extends \PFBC\OptionElement {
	protected $attributes = array();

	public function render() { 
		if(isset($this->attributes["value"])) {
			if(!is_array($this->attributes["value"]))
				$this->attributes["value"] = array($this->attributes["value"]);
		}
		else
			$this->attributes["value"] = array();

		if(!empty($this->attributes["multiple"]) && substr($this->attributes["name"], -2) != "[]")
			$this->attributes["name"] .= "[]";

		echo '<select', $this->getAttributes(array("value", "selected")), '>';
		$selected = false;
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);
			echo '<option value="', $this->filter($value), '"';
			if(!$selected && in_array($value, $this->attributes["value"])) {
				echo ' selected="selected"';
				$selected = true;
			}	
			echo '>', $text, '</option>';
		}	
		echo '</select>';
	}
}
