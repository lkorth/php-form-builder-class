<?php
namespace PFBC;

abstract class Error extends Base {
	private $form;

	public function __construct(array $properties = null) {
		$this->configure($properties);
	}

	public abstract function applyAjaxErrorResponse();

	public function clear() {
		echo 'jQuery("#', $this->getForm()->getId(), ' .pfbc-error").remove();';
	}

	public abstract function render();
	public abstract function renderAjaxErrorResponse();

	public function renderCSS() {
		$id = $this->getForm()->getId();
		echo <<<CSS
#$id .pfbc-error { padding: .5em; margin-bottom: 1em; }
#$id .pfbc-error ul { padding-left: 1.75em; margin: 0; margin-top: .25em; }
CSS;
	}

	public function setForm(Form $form) {
		$this->form = $form;
	}

	public function getForm() {
		return $this->form;
	}
}
