<?php
namespace PFBC\Element;

class Radio extends \PFBC\OptionElement {
	protected $attributes = array("type" => "radio");
	protected $inline;

	public function render() { 
		$labelClass = $this->attributes["type"];
		if(!empty($this->inline))
			$labelClass .= " inline";

		$count = 0;
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);

			echo '<label class="', $labelClass . '"> <input id="', $this->attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked")), ' value="', $this->filter($value), '"';
			if(isset($this->attributes["value"]) && $this->attributes["value"] == $value)
				echo ' checked="checked"';
			echo '/> ', $text, ' </label> ';
			++$count;
		}	
	}
}
