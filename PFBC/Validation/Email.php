<?php
namespace PFBC\Validation;

class Email extends \PFBC\Validation {
	protected $message = "Error: %element% must contain an email address.";

	public function isValid($value) {
		if($this->isNotApplicable($value) || filter_var($value, FILTER_VALIDATE_EMAIL))
			return true;
		return false;	
	}
}
