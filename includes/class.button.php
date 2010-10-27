<?php
class button extends pfbc {
	protected $attributes;
	protected $jqueryUI;

	private $allowedFields; 

	public function __construct() {
		$this->allowedFields = array(
			"button" => array("alt", "disabled", "name", "size", "src", "type", "value", "accesskey", "class", "dir", "id", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onchange", "onclick", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup", "onselect"),
			"a" => array("charset", "coords", "href", "hreflang", "name", "rel", "rev", "sharp", "accesskey", "class", "dir", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onclick", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup"),
		);
	}

	public function render($returnString) {
		if(!empty($this->jqueryUI))
			$this->applyClass("jqueryui-button");	

		$str = "\n\t\t";
		if($this->attributes["type"] == "link")
			$str .= "<a" . $this->attributesToHTML($this->attributes, $this->allowedFields["a"]) . ">" . $this->attributes["value"] . "</a>";
		else
			$str .= "<input" . $this->attributesToHTML($this->attributes, $this->allowedFields["button"]) . "/>";

		if(!$returnString)
			echo($str);
		else
			return $str;
	}
}
?>
