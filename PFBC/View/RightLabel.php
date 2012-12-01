<?php
namespace PFBC\View;

class RightLabel extends \PFBC\View {
	protected $class = "form-horizontal";

	public function render() {
		$this->_form->appendAttribute("class", $this->class);

		echo '<form', $this->_form->getAttributes(), '><fieldset>';
		$this->_form->getErrorView()->render();

		$elements = $this->_form->getElements();
		$elementSize = sizeof($elements);
		$elementCount = 0;
		for($e = 0; $e < $elementSize; ++$e) {
			$element = $elements[$e];

			if($element instanceof \PFBC\Element\Hidden || $element instanceof \PFBC\Element\HTML)
				$element->render();
            elseif($element instanceof \PFBC\Element\Button) {
                if($e == 0 || !$elements[($e - 1)] instanceof \PFBC\Element\Button)
					echo '<div class="form-actions">';
				else
					echo ' ';

				$element->render();

                if(($e + 1) == $elementSize || !$elements[($e + 1)] instanceof \PFBC\Element\Button)
                    echo '</div>';
            }
            else {
				echo '<div class="control-group"><div class="controls">', $element->render(), $this->renderLabel($element), $this->renderDescriptions($element), '</div></div>';
				++$elementCount;
			}
		}

		echo '</fieldset></form>';
    }

	protected function renderLabel(\PFBC\Element $element) {
        $label = $element->getLabel();
        if(!empty($label)) {
			echo '<label class="control-label" for="', $element->getAttribute("id"), '">';
			echo $label;
                        if($element->isRequired())
				echo '<span class="required"> * </span>';
                        echo '</label>';
        }
    }
}
