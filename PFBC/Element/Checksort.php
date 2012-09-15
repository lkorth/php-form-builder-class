<?php
namespace PFBC\Element;

class Checksort extends Sort {
	protected $attributes = array("type" => "checkbox");
	protected $inline;

	public function render() { 
		if(isset($this->attributes["value"])) {
			if(!is_array($this->attributes["value"]))
				$this->attributes["value"] = array($this->attributes["value"]);
		}
		else
			$this->attributes["value"] = array();

		if(substr($this->attributes["name"], -2) != "[]")
			$this->attributes["name"] .= "[]";

		$labelClass = $this->attributes["type"];
		if(!empty($this->inline))
			$labelClass .= " inline";
		
		$count = 0;
		$existing = "";

		foreach($this->options as $value => $text) {
            $value = $this->getOptionValue($value);
            if(!empty($this->inline) && $count > 0)
                echo ' ';
            echo '<label class="', $labelClass, '"><input id="', $this->attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked", "name", "onclick", "required")), ' value="', $this->filter($value), '"';
            if(in_array($value, $this->attributes["value"]))
                echo ' checked="checked"';
            echo ' onclick="updateChecksort(this, \'', str_replace(array('"', "'"), array('&quot;', "\'"), $text), '\');"/>', $text, '</label>';

			if(in_array($value, $this->attributes["value"]))
				$existing .= '<li id="' . $this->attributes["id"] . "-sort-" . $count . '" class="ui-state-default"><input type="hidden" name="' . $this->attributes["name"] . '" value="' . $value . '"/>' . $text . '</li>';

            ++$count;
        }

		echo '<ul id="', $this->attributes["id"], '">', $existing, '</ul>';
	}

	function renderJS() {
		echo <<<JS
if(typeof updateChecksort != "function") {		
	function updateChecksort(element, text) {
		var position = element.id.lastIndexOf("-");
		var id = element.id.substr(0, position);
		var index = element.id.substr(position + 1);
		if(element.checked) {
			jQuery("#" + id).append('<li id="' + id + '-sort-' + index + '" class="ui-state-default"><input type="hidden" name="{$this->attributes["name"]}" value="' + element.value + '"/>' + text + '</li>');
		}	
		else
			jQuery("#" + id + "-sort-" + index).remove();
	}
}
JS;
	}
}
