<?php
namespace PFBC\Validation;

class AlphaNumeric extends RegExp {
	protected $message = "Error: %element% must be alphanumeric (contain only numbers, letters, underscores, and/or hyphens).";

	public function __construct($message = "") {
		parent::__construct("/^[a-zA-Z0-9_-]+$/", $message);
	}
}
