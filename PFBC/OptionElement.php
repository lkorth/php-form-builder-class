<?php
namespace PFBC;

abstract class OptionElement extends Element {
	protected $options;

	public function __construct($label, $name, array $options, array $properties = null) {
		$this->options = $options;
		if(array_values($this->options) === $this->options)
			$this->options = array_combine($this->options, $this->options);

		parent::__construct($label, $name, $properties);
	}
}
