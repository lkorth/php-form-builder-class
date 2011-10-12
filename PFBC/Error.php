<?php
namespace PFBC;

abstract class Error extends Base {
	protected $_form;

	public function __construct(array $properties = null) {
		$this->configure($properties);
	}

	public abstract function applyAjaxErrorResponse();

	public function clear() {
		echo 'jQuery("#', $this->_form->getId(), ' .pfbc-error").remove();';
	}

	public abstract function render();
	public abstract function renderAjaxErrorResponse();

	public function renderCSS() {
		$id = $this->_form->getId();
		echo <<<CSS
#$id .pfbc-error { padding: .5em; margin-bottom: 1em; }
#$id .pfbc-error ul { padding-left: 1.75em; margin: 0; margin-top: .25em; }
#$id .pfbc-error li { padding-top: .25em; }
CSS;
	}

	public function _setForm(Form $form) {
		$this->_form = $form;
	}
}
