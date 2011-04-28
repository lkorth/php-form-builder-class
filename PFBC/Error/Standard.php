<?php
namespace PFBC\Error;

class Standard extends \PFBC\Error {
	public function applyAjaxErrorResponse() {
		$id = $this->getForm()->getId();
		echo <<<JS
var errorSize = response.errors.length;
if(errorSize == 1)
	var errorFormat = "error was";
else
	var errorFormat = errorSize + " errors were";

var errorHTML = '<div class="pfbc-error ui-state-error ui-corner-all">The following ' + errorFormat + ' found:<ul>';
for(e = 0; e < errorSize; ++e)
	errorHTML += '<li>' + response.errors[e] + '</li>';
errorHTML += '</ul></div>';
jQuery("#$id").prepend(errorHTML);
JS;

	}

	public function render() {
		$errors = \PFBC\Form::getErrors($this->getForm()->getId());

		if(!empty($errors)) {
			$list = array();
			array_walk_recursive($errors, function($value, $key, $list) {
				$list[] = $value;
			}, &$list);

			$size = sizeof($list);
			if($size == 1)
				$format = "error was";
			else
				$format = $size . " errors were";

			echo '<div class="pfbc-error ui-state-error ui-corner-all">The following ', $format, ' found:<ul><li>', implode("</li><li>", $list), "</li></ul></div>";
		}
    }

	public function renderAjaxErrorResponse() {
        $errors = \PFBC\Form::getErrors($this->getForm()->getId());
        if(!empty($errors)) {
            $list = array();
            array_walk_recursive($errors, function($value, $key, $list) {
                $list[] = $value;
            }, &$list);
            header("Content-type: application/json");
            echo json_encode(array("errors" => $list));
        }
	}
}
