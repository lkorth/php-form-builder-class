<?php
class element extends pfbc {
	public $alphanumeric;
	public $attributes;
	public $basic;
	public $container;
	public $errorMsg;
	public $float;
	public $height;
	public $hint;
	public $hideDisplay;
	public $hideJump;
	public $ignoreGSSend;
	public $integer;
	public $jqueryOptions;
	public $label;
	public $labelDisplayRight;
	public $labelPaddingLeft;
	public $labelPaddingRight;
	public $labelPaddingTop;
	public $labelRightAlign;
	public $labelWidth;
	public $max;
	public $min;
	public $months;
	public $noBreak;
	public $optionKeys;
	public $optionValues;
	public $orientation;
	public $prefix;
	public $preHTML;
	public $postHTML;
	public $required;
	public $snapIncrement;
	public $suffix;
	public $tooltip;
	public $tooltipID;
	public $width;
	public $zoom;

	public function __construct() {
		$this->attributes = array(
			"type" => "text"
		);
	}
}
?>
