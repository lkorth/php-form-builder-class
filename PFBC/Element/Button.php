<?php
namespace PFBC\Element;

class Button extends \PFBC\Element {
	protected $attributes = array("type" => "submit", "value" => "Submit");
	protected $icon;

	public function __construct($value = "", $type = "", array $properties = null) {
		if(!is_array($properties))
			$properties = array();

		if(!empty($value))
			$properties["value"] = $value;
		if(!empty($type))
			$properties["type"] = $type;
			
		parent::__construct("", "", $properties);
	}

	public function jQueryDocumentReady() {
		if(!in_array("jQueryUIButtons", $this->form->getPrevent())) {
			echo 'jQuery("#', $this->attributes["id"], '").button(';
			if(!empty($this->icon))
				echo '{ icons: { primary: "ui-icon-', $this->icon, '" } }';
			echo ');';
		}
	}

	public function render() {
		echo '<button', $this->getAttributes("value"), '>', $this->attributes["value"], '</button>';
	}	
}
