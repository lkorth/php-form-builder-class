<?php
namespace PFBC\Element;

class Color extends Textbox {
	protected $attributes = array("type" => "color");

	public function render() {
		$this->attributes["pattern"] = "#[a-g0-9]{6}";
		$this->attributes["title"] = "6-digit hexidecimal color (e.g. #000000)";
		$this->validation[] = new \PFBC\Validation\RegExp("/" . $this->attributes["pattern"] . "/", "Error: The %element% field must contain a " . $this->attributes["title"]);
		parent::render();
	}
}
