<?php
namespace PFBC\View;

class Search extends Inline {
	protected $class = "form-search";
	
	public function render() {
		$this->form->setClass($this->class);
		parent::render();
    }
}	
