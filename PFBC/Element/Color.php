<?php
namespace PFBC\Element;

class Color extends Textbox {
	protected $_attributes = array("type" => "color");

	public function render() {
		$this->_attributes["pattern"] = "#[a-g0-9]{6}";
		$this->_attributes["title"] = "6-digit hexidecimal color (e.g. #000000)";
		$this->validation[] = new \PFBC\Validation\RegExp("/" . $this->_attributes["pattern"] . "/", "Error: The %element% field must contain a " . $this->_attributes["title"]);
		parent::render();
	}
}
