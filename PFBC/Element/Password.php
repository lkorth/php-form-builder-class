<?php
namespace PFBC\Element;

class Password extends Textbox {
	protected $_attributes = array("type" => "password");
	protected $prefillAfterValidation = 0;
}
