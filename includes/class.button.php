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
		if(!empty($this->jqueryUI)) {
			if(!empty($this->attributes["class"]))
				$this->attributes["class"] .= " jqueryui-button";
			else	
				$this->attributes["class"] = "jqueryui-button";
		}	

		$str = "\n\t\t";
		if($this->attributes["type"] == "link") {
			$str .= "<a";
			if(!empty($this->attributes) && is_array($this->attributes)) {
				$tmpAllowFieldArr = $this->allowedFields["a"];
				foreach($this->attributes as $key => $value) {
					if(in_array($key, $tmpAllowFieldArr))
						$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
				}		
			}	
			$str .= ">" . $this->attributes["value"] . "</a>";
		}
		else {
			$str .= "<input";
			if(!empty($this->attributes) && is_array($this->attributes)) {
				$tmpAllowFieldArr = $this->allowedFields["button"];
				foreach($this->attributes as $key => $value) {
					if(in_array($key, $tmpAllowFieldArr))
						$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
				}		
			}
			$str .= "/>";
		}

		if(!$returnString)
			echo($str);
		else
			return $str;
	}
}
?>
