<?php
namespace PFBC;

abstract class Error extends Base {
	protected $form;

	public function __construct(array $properties = null) {
		$this->configure($properties);
	}

	public abstract function applyAjaxErrorResponse();

	public function clear() {
		echo 'jQuery("#', $this->form->getId(), ' .alert-error").remove();';
	}

	public abstract function render();
	public abstract function renderAjaxErrorResponse();

	public function renderCSS() {}

	public function setForm(Form $form) {
		$this->form = $form;
	}
}
