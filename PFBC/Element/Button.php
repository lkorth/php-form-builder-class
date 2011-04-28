<?php
namespace PFBC\Element;

class Button extends \PFBC\Element {
	protected $attributes = array("type" => "submit", "value" => "Submit");

	public function __construct($value = "", $type = "", array $properties = null) {
		if(!is_array($properties))
			$properties = array();

		if(!empty($value))
			$properties["value"] = $value;
		if(!empty($type))
			$properties["type"] = $type;
			
		parent::__construct("", "", $properties);
	}
}
