<?php
namespace PFBC\View;

class Grid extends \PFBC\View {
	private $gridIncludedElements = 0;

	protected $form;
	protected $grid;
	protected $gridMargin = 2;

	public function __construct(array $grid, array $properties = null) {
		if(!empty($properties))
			$properties["grid"] = $grid;
		else
			$properties = array("grid" => $grid);

		parent::__construct($properties);
	}

	public function jQueryDocumentReady() {
		$id = $this->form->getId();
		/*jQuery is used to remove margin from the elements on the far left/right of each row and apply css 
		entries to the last row.*/
		echo <<<JS
jQuery("#$id .pfbc-grid").each(function() { 
	jQuery(".pfbc-element:first", this).css({ "margin-left": "0" }); 
	jQuery(".pfbc-element:last", this).css({ "margin-right": "0" }); 
});
jQuery("#$id .pfbc-grid:last").css({ 
	"margin-bottom": "0", 
	"padding-bottom": "0", 
	"border-bottom": "none" 
});
JS;
	}	

	public function render() {
		echo '<form', $this->form->getAttributes(), '>';
		$this->form->getError()->render();

		$elements = $this->form->getElements();

		$gridElementCount = 0;
		$gridIndex = 0;
		$gridCount = 0;

		$elementSize = sizeof($elements);
		for($e = 0; $e < $elementSize; ++$e) {
			$element = $elements[$e];

			if($element instanceof \PFBC\Element\Hidden || $element instanceof \PFBC\Element\HTMLExternal)
				$element->render();
			elseif($element instanceof \PFBC\Element\Button) {
				/*Consecutive Button elements are rendered horizontally in the same row.*/
				if($e == 0 || !$elements[($e - 1)] instanceof \PFBC\Element\Button)
					echo '<div class="pfbc-grid pfbc-grid-1"><div class="pfbc-element pfbc-buttons">';
				$element->render();
				if(($e + 1) == $elementSize || !$elements[($e + 1)] instanceof \PFBC\Element\Button)
					echo '</div></div>';
			}
			else {
				if(!empty($this->grid[$gridIndex])) {
					if($gridCount == 0)
						echo '<div class="pfbc-grid pfbc-grid-' . $this->grid[$gridIndex] . '">';
				}
				else
					echo '<div class="pfbc-grid pfbc-grid-1">';

				echo '<div class="pfbc-element">';
				$this->renderLabel($element);
				$element->render();
				echo '</div>';

				if(!empty($this->grid[$gridIndex]) && ($gridElementCount + 1) == $this->gridIncludedElements)
					echo '</div>';
				elseif(!empty($this->grid[$gridIndex])) {
					if(($gridCount + 1) == $this->grid[$gridIndex]) {
						echo '</div>';
						$gridCount = 0;
						++$gridIndex;
					}
					else
						++$gridCount;
				}
				else
					echo '</div>';
				++$gridElementCount;
			}
		}

		echo '</form>';
    }

	public function renderCSS() {
		$id = $this->form->getId();
		$width = $this->form->getWidth();
		$widthSuffix = $this->form->getWidthSuffix();

		parent::renderCSS();
		echo <<<CSS
#$id { width: $width{$widthSuffix}; }
#$id .pfbc-label { margin-bottom: .25em; }
#$id .pfbc-label label { display: block; }
#$id .pfbc-grid { width: 100%; margin-bottom: 1em; padding-bottom: 1em; border-bottom: 1px solid #f4f4f4; }
#$id .pfbc-grid:after { clear: both; display: block; margin: 0; padding: 0; visibility: hidden; height: 0; content: ":)"; }
#$id .pfbc-buttons { text-align: right; }
#$id .pfbc-textbox, #$id .pfbc-textarea, #$id .pfbc-select { width: $width{$widthSuffix}; }
CSS;
	
		$elements = $this->form->getElements();
		foreach($elements as $element) {
			/*Hidden, HTMLExternal, and Button element classes aren't included in the grid.*/
			if(!$element instanceof \PFBC\Element\Hidden && !$element instanceof \PFBC\Element\HTMLExternal && !$element instanceof \PFBC\Element\Button)
				++$this->gridIncludedElements;
		}

		/*If the grid array contains more elements than the form has available, it is revised.*/
		if(array_sum($this->grid) > $this->gridIncludedElements) {
			$gridRevised = array();
			foreach($this->grid as $grid) {
				$gridRemaining = $this->gridIncludedElements - array_sum($gridRevised);
				if(!empty($gridRemaining))
					if($gridRemaining >= $grid)
						$gridRevised[] = $grid;
					else
						$gridRevised[] = $gridRemaining;
				else
					break;
			}
			$this->grid = $gridRevised;
		}

		echo <<<CSS
#$id .pfbc-grid .pfbc-element { margin-right: {$this->gridMargin}$widthSuffix; margin-left: {$this->gridMargin}$widthSuffix; }
CSS;
		$gridValues = array_values(array_unique($this->grid));
		foreach($gridValues as $gridValue) {
			if($widthSuffix == "px")
				$elementWidth = floor((($width - ($this->gridMargin * 2 * ($gridValue - 1)))  / $gridValue));
			else
				$elementWidth = floor(((100 - ($this->gridMargin * 2 * ($gridValue - 1)))  / $gridValue));
			echo '#', $id, ' .pfbc-grid-', $gridValue, ' .pfbc-element { float: left; width: ', $elementWidth, $widthSuffix, '; }';

			if($widthSuffix == "%")
				$elementWidth = 100;

			echo '#', $id, ' .pfbc-grid-', $gridValue, ' .pfbc-textbox, #', $id, ' .pfbc-grid-', $gridValue, ' .pfbc-textarea, #', $id, ' .pfbc-grid-', $gridValue, ' .pfbc-select { width: ', $elementWidth, $widthSuffix, '; }';
		}
	}
}
