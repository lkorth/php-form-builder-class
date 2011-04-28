<?php
namespace PFBC;

abstract class View extends Base {
	private $form;
	protected $style = 1;

	public function __construct(array $properties = null) {
		$this->configure($properties);
	}

	public function getForm() {
		return $this->form;
	}

	/*This method encapsulates the various pieces that are included in an element's label.*/
	protected function renderLabel($element) {
		$label = $element->getLabel();
		$id = $element->getID();
		if(!empty($label)) {
			$description = $element->getDescription();
			echo '<div class="pfbc-label"><label for="', $id, '">';
			if($element->isRequired())
				echo '<strong>*</strong> ';
			echo $label, '</label>';	
			if(!empty($description))
				echo '<em>', $description, '</em>';
			echo '</div>';
		}	
	}

	public function setForm(Form $form) {
		$this->form = $form;
	}

	/*jQuery is used to apply css entries to the last element.*/
	public function jQueryDocumentReady() {
		echo 'jQuery("#', $this->getForm()->getId(), ' .pfbc-element:last").css({ "margin-bottom": "0", "padding-bottom": "0", "border-bottom": "none" });';
	}	

	public function render() {}

	public function renderCSS() {
		$id = $this->getForm()->getId();

		/*For ease-of-use, default styles are applied to form elements.*/
		if(!empty($this->style)) {
			echo <<<CSS
#$id .pfbc-label label { font-weight: bold; }
#$id .pfbc-label em { font-size: .9em; color: #888; }
#$id .pfbc-label strong { color: #990000; }
#$id .pfbc-textbox, #$id .pfbc-textarea, #$id .pfbc-select { padding: 0.5em; border: 1px solid #ccc; font-size: 14px; }
#$id .pfbc-textbox { height: 16px; }
#$id .pfbc-select { height: 32px; }
CSS;
		}
	}

	public function renderJS() {}
}
