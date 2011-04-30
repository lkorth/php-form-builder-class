<?php
namespace PFBC\View;

class SideBySide extends \PFBC\View\Standard {
	protected $labelWidth;
	protected $labelRightAlign;
	protected $labelPaddingRight = 5;
	protected $labelPaddingTop;

	public function __construct($labelWidth, array $properties = null) {
		if(!empty($properties))
			$properties["labelWidth"] = $labelWidth;
		else
			$properties = array("labelWidth" => $labelWidth);

		parent::__construct($properties);
	}

	public function renderCSS() {
		$id = $this->form->getId();
		$width = $this->form->getWidth();
		$widthSuffix = $this->form->getWidthSuffix();
		$elementWidth = $width - $this->labelWidth - $this->labelPaddingRight;

		\PFBC\View::renderCSS();
		echo <<<CSS
#$id { width: $width{$widthSuffix}; }
#$id .pfbc-element { margin-bottom: 1em; padding-bottom: 1em; border-bottom: 1px solid #f4f4f4; }
#$id .pfbc-label { width: {$this->labelWidth}$widthSuffix; float: left; padding-right: {$this->labelPaddingRight}$widthSuffix; }
#$id .pfbc-buttons { text-align: right; }
#$id .pfbc-textbox, #$id .pfbc-textarea, #$id .pfbc-select { width: $elementWidth{$widthSuffix}; }
CSS;
	
		if(!empty($this->labelRightAlign))
			echo '#', $id, ' .pfbc-label { text-align: right; }';
		
		if(empty($this->labelPaddingTop) && !empty($this->style))
			$this->labelPaddingTop = ".75em";

		if(!empty($this->labelPaddingTop)) {
			if(is_numeric($this->labelPaddingTop))
				$this->labelPaddingTop .= "px";
			echo '#', $id, ' .pfbc-label { padding-top: ', $this->labelPaddingTop, '; }';
		}
	}
}
