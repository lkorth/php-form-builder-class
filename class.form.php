<?php
/*
Google Code Project Hosting - http://code.google.com/p/php-form-builder-class/
User Google Group - http://groups.google.com/group/php-form-builder-class/
Developer Google Group - http://groups.google.com/group/php-form-builder-class-developer/
*/

abstract class pfbc {
	function debug() {
		echo "<pre>", print_r($this, true), "</pre>";
	}

	function setAttributes($params) {
		if(!empty($params) && is_array($params)) {
			//Loop through and get accessible class variables. Build lookup array for the keys allowing for case insensitive attribute setting.
			$objArr = array();
			$keyLookupArr = array();
			foreach($this as $key => $value) {
				$objArr[$key] = $value;
				$keyLookupArr[strtolower($key)] = $key;
			}	

			foreach($params as $key => $value) {
				//Set the appropriate class variable if it exists.
				$key = strtolower($key);
				if(array_key_exists($key, $keyLookupArr)) {
					$key = $keyLookupArr[$key];
					if(is_array($this->$key) && !empty($this->$key)) {
						//Using array_merge prevents any default values from being overwritten.
						if(is_array($value))
							$this->$key = array_merge($this->$key, $value);
					}	
					else
						$this->$key = $value;
				}
				//Insert key/value pair into the attributes array if it does not match any class variables.
				elseif(array_key_exists("attributes", $objArr))
					$this->attributes[$key] = $value;
			}
		}
	}
}

class form extends pfbc { 
	protected $ajax;
	protected $ajaxCallback;
	protected $ajaxPreCallback;
	protected $alphanumericErrorMsgFormat;
	protected $attributes;
	protected $captchaLang;
	protected $captchaPublicKey;
	protected $captchaPrivateKey;
	protected $captchaTheme;
	protected $ckeditorCustomConfig;
	protected $ckeditorLang;
	protected $emailErrorMsgFormat;
	protected $errorDisplayOption;
	protected $errorMsgFormat;
	protected $includesPath;
	protected $integerErrorMsgFormat;
	protected $jqueryDateFormat;
	protected $jqueryUIButtons;
	protected $jqueryUITheme;
	protected $jsErrorFunction;
	protected $labelPaddingRight;
	protected $labelRightAlign;
	protected $labelWidth;
	protected $latlngDefaultLocation;
	protected $map;
	protected $mapMargin;
	protected $noAutoFocus;
	protected $preventJQueryLoad;
	protected $preventJQueryUILoad;
	protected $preventJSValidation;
	protected $preventTinyMCELoad;	
	protected $preventTinyMCEInitLoad;
	protected $preventCaptchaLoad;
	protected $preventCKEditorLoad;
	protected $preventDefaultCSS;
	protected $tooltipIcon;

	private $allowedFields;
	private $alphanumbericExists;
	private $bindRules;
	private $captchaExists;
	private $checkform;
	private $ckeditorIDArr;
	private $countryArr;
	private $elements;
	private $emailExists;
	private $focusElement;
	private $hasFormTag;
	private $hintExists;
	private $https;
	private $integerExists;
	private $jqueryAllowedParams;
	private $jqueryCheckSort;
	private $jqueryColorIDArr;
	private $jqueryDateIDArr;
	private $jqueryDateRangeIDArr;
	private $jquerySliderIDArr;
	private $jqueryStarRatingIDArr;
	private $jqueryUIButtonExists;
	private $jsIncludesPath;
	private $labelWidthExists;
	private $latlngIDArr;
	private $phpIncludesPath;
	private $referenceValues;
	private $stateArr;
	private $tinymceIDArr;
	private $tooltipIDArr;
	private $generateInlineResources;

	public $errorMsg;

	public function __construct($id = "myform") {
		//Non alpha-numeric characters are replaced with underscores to prevent invalid javascript function names.
		$id = preg_replace("/\W/", "_", $id);
		$this->attributes = array(
			"id" => $id,
			"method" => "post",
			"action" => basename($_SERVER["SCRIPT_NAME"]),
		);
		$this->alphanumericErrorMsgFormat = "Error: [LABEL] contains one or more invalid characters - only letters and/or numbers are allowed.";
		$this->captchaLang = "en";
		$this->captchaPrivateKey = "6LcazwoAAAAAAD-auqUl-4txAK3Ky5jc5N3OXN0_";
		$this->captchaPublicKey = "6LcazwoAAAAAADamFkwqj5KN1Gla7l4fpMMbdZfi";
		$this->captchaTheme = "white";
		//[LABEL] is replaced with the appropriate element's label for both emailErrorMsgFormat and errorMsgFormat attributes.
		$this->emailErrorMsgFormat = "Error: [LABEL] contains an invalid email address.";
		$this->errorMsgFormat = "Error: [LABEL] is a required field.";
		if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
			$this->https = true;
		else	
			$this->https = false;
		$this->includesPath = "php-form-builder-class/includes";
		$this->integerErrorMsgFormat = "Error: [LABEL] contains one or more invalid characters - only numbers are allowed.";
		$this->jqueryDateFormat = "MM d, yy";
		$this->jqueryUITheme = "smoothness";
		$this->jsErrorFunction = "pfbc_error_". $this->attributes["id"];
		$this->labelPaddingRight = 4;
		$this->mapMargin = 2;
		//These lists represent all xhtml 1.0 strict compliant attributes. See http://www.w3schools.com/tags/default.asp for reference.
		$this->allowedFields = array(
			"form" => array("action", "accept", "accept-charset", "enctype", "method", "class", "dir", "id", "lang", "style", "title", "xml:lang", "onclick", "ondblclick", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup", "onreset", "onsubmit"),
			"text" => array("accept", "disabled", "maxlength", "name", "readonly", "size", "type", "value", "accesskey", "class", "dir", "id", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onchange", "onclick", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup", "onselect"),
			"textarea" => array("cols", "rows", "disabled", "name", "readonly", "accesskey", "class", "dir", "id", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onchange", "onclick", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup", "onselect"),
			"select" => array("disabled", "multiple", "name", "size", "class", "dir", "id", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onchange", "onclick", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup"),
			"radio" => array("checked", "disabled", "name", "size", "type", "accesskey", "class", "dir", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onchange", "onclick", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup", "onselect"),
			"checksort" => array("checked", "disabled", "size", "accesskey", "class", "dir", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onchange", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup", "onselect"),
			"latlng" => array("disabled", "maxlength", "name", "readonly", "size", "type", "accesskey", "class", "dir", "id", "lang", "style", "tabindex", "title", "xml:lang", "onblur", "onchange", "onclick", "ondblclick", "onfocus", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onkeydown", "onkeypress", "onkeyup", "onselect"),
		);
	}

	//Instead of calling the render() function to display your form, this magic method allows you to use the familiar echo function.
	public function __toString() {
		return $this->render(true);
	}

	public function addButton($value="Submit", $type="submit", $additionalParams="") {
		$params = array("value" => $value, "type" => $type);
		if(!empty($additionalParams) && is_array($additionalParams)) {
			foreach($additionalParams as $key => $value)
				$params[$key] = $value;
		}

		if(!empty($this->jqueryUIButtons))
			$params["jqueryUI"] = 1;

		$button = new button();
		$button->setAttributes($params);
		if(!empty($params["jqueryUI"]))
			$this->jqueryUIButtonExists = 1;

		$this->addElement("", "", "button", $button->render(true));
	}

	public function addCaptcha($label="", $additionalParams="") {
		$this->addElement($label, "recaptcha_response_field", "captcha", "", $additionalParams);
	}	

	public function addCheckbox($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "checkbox", $value, $additionalParams);
	}

	public function addCheckSort($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "checksort", $value, $additionalParams);
	}

	public function addCKEditor($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "ckeditor", $value, $additionalParams);
	}

	public function addColor($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "color", $value, $additionalParams);
	}

	//Included for backwards compatibility.  The preferred function is now addColor.
	public function addColorPicker($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "color", $value, $additionalParams);
	}

	public function addCountry($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "country", $value, $additionalParams);
	}

	public function addDate($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "date", $value, $additionalParams);
	}

	public function addDateRange($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "daterange", $value, $additionalParams);
	}

	private function addElement($label, $name, $type="", $value="", $additionalParams="") {
		$params = array("label" => $label, "name" => $name);
		if(!empty($type))
			$params["type"] = $type;
		$params["value"] = $value;
		if(!empty($additionalParams) && is_array($additionalParams)) {
			foreach($additionalParams as $key => $value)
				$params[$key] = $value;
		}
		$this->attachElement($params);
	}

	public function addEmail($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "email", $value, $additionalParams);
	}

	public function addFile($label, $name, $additionalParams="") {
		$this->addElement($label, $name, "file", "", $additionalParams);
	}

	public function addHidden($name, $value="", $additionalParams="") {
		$this->addElement("", $name, "hidden", $value, $additionalParams);
	}

	public function addHTML($value , $additionalParams="") {
		$this->addElement("", "", "html", $value, $additionalParams);
	}

	public function addHTMLExternal($value , $additionalParams="") {
		$this->addElement("", "", "htmlexternal", $value, $additionalParams);
	}

	public function addLatLng($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "latlng", $value, $additionalParams);
	}

	public function addPassword($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "password", $value, $additionalParams);
	}

	public function addRadio($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "radio", $value, $additionalParams);
	}

	public function addRating($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "rating", $value, $additionalParams);
	}

	public function addSelect($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "select", $value, $additionalParams);
	}

	public function addSlider($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "slider", $value, $additionalParams);
	}

	public function addSort($label, $name, $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "sort", "", $additionalParams);
	}

	public function addState($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "state", $value, $additionalParams);
	}

	public function addTextarea($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "textarea", $value, $additionalParams);
	}

	public function addTextbox($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "text", $value, $additionalParams);
	}

	public function addTrueFalse($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "truefalse", $value, $additionalParams);
	}

	public function addWebEditor($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "webeditor", $value, $additionalParams);
	}

	public function addYesNo($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "yesno", $value, $additionalParams);
	}

	private function attachElement($params) {
		$ele = new element();
		$ele->setAttributes($params);
		$eleType = &$ele->attributes["type"];

		if($eleType == "yesno") {
			//The yesno field is a shortcut for creating a radio button with two options - yes and no.
			$eleType = "radio";
			$ele->options = array();
			$opt = new option();
			$opt->setAttributes(array("value" => "1", "text" => "Yes"));
			$ele->options[] = $opt;
			$opt = new option();
			$opt->setAttributes(array("value" => "0", "text" => "No"));
			$ele->options[] = $opt;
			if(!isset($ele->noBreak))
				$ele->noBreak = 1;
		}
		elseif($eleType == "truefalse") {
			//Similar to yesno, the truefalse field is shortcut creating a radio button with two options - true and false.
			$eleType = "radio";
			$ele->options = array();
			$opt = new option();
			$opt->setAttributes(array("value" => "1", "text" => "True"));
			$ele->options[] = $opt;
			$opt = new option();
			$opt->setAttributes(array("value" => "0", "text" => "False"));
			$ele->options[] = $opt;
			if(!isset($ele->noBreak))
				$ele->noBreak = 1;
		}
		elseif(array_key_exists("options", $params) && is_array($params["options"])) {
			//Various form types (select, radio, sort, checksort, etc.) use the options parameter to handle value/text scenarios.
			if(array_key_exists("options", $params) && is_array($params["options"])) {
				$ele->options = array();
				//If the options array is one-dimensional, assign the array's value to both the value and text.
				if(array_values($params["options"]) === $params["options"]) {
					foreach($params["options"] as $key => $value) {
						$opt = new option();
						$opt->setAttributes(array("value" => $value, "text" => $value));
						$ele->options[] = $opt;
					}
				}
				//If the options array is associative, assign the value and text for each key/value pair.
				else {
					foreach($params["options"] as $key => $value) {
						$opt = new option();
						$opt->setAttributes(array("value" => $key, "text" => $value));
						$ele->options[] = $opt;
					}
				}
			}
		}

		//This set of conditions sets default information for specific form elements. Setting information here allows similar elements within the elementsToString() function to be compressed.
		if($eleType == "email")
			$this->emailExists = 1;
		elseif($eleType == "file")
			$this->attributes["enctype"] = "multipart/form-data";
		elseif($eleType == "webeditor") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "webeditor_" . rand(0, 999);
			if(empty($this->tinymceIDArr))
				$this->tinymceIDArr = array();
			while(in_array($ele->attributes["id"], $this->tinymceIDArr))
				$ele->attributes["id"] = "webeditor_" . rand(0, 999);
			$this->tinymceIDArr[] = $ele->attributes["id"];
		}
		elseif($eleType == "ckeditor") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "ckeditor_" . rand(0, 999);
			if(empty($this->ckeditorIDArr))
				$this->ckeditorIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->ckeditorIDArr))
				$ele->attributes["id"] = "ckeditor_" . rand(0, 999);
		}
		elseif($eleType == "date") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "dateinput_" . rand(0, 999);
			if(!isset($this->jqueryDateIDArr))
				$this->jqueryDateIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->jqueryDateIDArr))
				$ele->attributes["id"] = "dateinput_" . rand(0, 999);

			$ele->attributes["readonly"] = "readonly";
			if(empty($ele->hint))
				$ele->hint = "Click to Select Date...";

			$jqueryOptions = array("dateFormat" => $this->jqueryDateFormat, "changeMonth" => true, "changeYear" => true);	
			if(empty($this->jqueryAllowedParams["date"]))
				$this->jqueryAllowedParams["date"] = array("disabled", "altField", "altFormat", "appendText", "autoSize", "buttonImage", "buttonImageOnly", "buttonText", "calculateWeek", "changeMonth", "changeYear", "closeText", "constrainInput", "currentText", "dateFormat", "dayNames", "dayNamesMin", "dayNamesShort", "defaultDate", "duration", "firstDay", "gotoCurrent", "hideIfNoPrevNext", "isRTL", "maxDate", "minDate", "monthNames", "monthNamesShort", "navigationAsDateFormat", "nextText", "numberOfMonths", "prevText", "selectOtherMonths", "shortYearCutoff", "showAnim", "showButtonPanel", "showCurrentAtPos", "showMonthAfterYear", "showOn", "showOptions", "showOtherMonths", "showWeek", "stepMonths", "weekHeader", "yearRange", "yearSuffix");
			if(!empty($ele->jqueryOptions)) {
				foreach($ele->jqueryOptions as $key => $val) {
					if(in_array($key, $this->jqueryAllowedParams["date"])) 
						$jqueryOptions[$key] = $val;
				}
			}
			//Added for backwards compatibility to ensure the minDate, maxDate, and months element attributes are still functional in future releases  The jqueryOptions attribute scales better and is now the favored approach.
			if(isset($ele->min) && !array_key_exists("minDate", $jqueryOptions))
				$jqueryOptions["minDate"] = $ele->min;
			if(isset($ele->max) && !array_key_exists("maxDate", $jqueryOptions))
				$jqueryOptions["maxDate"] = $ele->max;
			if(!empty($ele->months) && !array_key_exists("numberOfMonths", $jqueryOptions))
				$jqueryOptions["numberOfMonths"] = $ele->months;
			$ele->jqueryOptions = $jqueryOptions;

			$this->jqueryDateIDArr[$ele->attributes["id"]] = $ele;
		}
		elseif($eleType == "daterange") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "daterangeinput_" . rand(0, 999);
			if(!isset($this->jqueryDateRangeIDArr))
				$this->jqueryDateRangeIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->jqueryDateRangeIDArr))
				$ele->attributes["id"] = "daterangeinput_" . rand(0, 999);

			$ele->attributes["readonly"] = "readonly";
			if(empty($ele->hint))
				$ele->hint = "Click to Select Date Range...";

			$jqueryOptions = array("dateFormat" => $this->jqueryDateFormat, "changeMonth" => true, "changeYear" => true);	
			if(empty($this->jqueryAllowedParams["daterange"]))
				$this->jqueryAllowedParams["daterange"] = array("disabled", "altField", "altFormat", "appendText", "autoSize", "buttonImage", "buttonImageOnly", "buttonText", "calculateWeek", "changeMonth", "changeYear", "closeText", "constrainInput", "currentText", "dateFormat", "dayNames", "dayNamesMin", "dayNamesShort", "defaultDate", "duration", "firstDay", "gotoCurrent", "hideIfNoPrevNext", "isRTL", "maxDate", "minDate", "monthNames", "monthNamesShort", "navigationAsDateFormat", "nextText", "numberOfMonths", "prevText", "selectOtherMonths", "shortYearCutoff", "showAnim", "showButtonPanel", "showCurrentAtPos", "showMonthAfterYear", "showOn", "showOptions", "showOtherMonths", "showWeek", "stepMonths", "weekHeader", "yearRange", "yearSuffix");
			if(!empty($ele->jqueryOptions)) {
				foreach($ele->jqueryOptions as $key => $val) {
					if(in_array($key, $this->jqueryAllowedParams["daterange"])) 
						$jqueryOptions[$key] = $val;
				}
			}
			//Added for backwards compatibility to ensure the minDate, maxDate, and months element attributes are still functional in future releases.
			if(isset($ele->min) && !array_key_exists("minDate", $jqueryOptions))
				$jqueryOptions["minDate"] = $ele->min;
			if(isset($ele->max) && !array_key_exists("maxDate", $jqueryOptions))
				$jqueryOptions["maxDate"] = $ele->max;
			$ele->jqueryOptions = $jqueryOptions;

			$this->jqueryDateRangeIDArr[$ele->attributes["id"]] = $ele;
		}
		elseif($eleType == "sort") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "sort_" . rand(0, 999);
			if(!isset($this->jquerySortIDArr))
				$this->jquerySortIDArr = array();
			while(in_array($ele->attributes["id"], $this->jquerySortIDArr))
				$ele->attributes["id"] = "sort_" . rand(0, 999);
			$this->jquerySortIDArr[] = $ele->attributes["id"];
		}
		elseif($eleType == "latlng") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "latlnginput_" . rand(0, 999);
			if(!isset($this->latlngIDArr))
				$this->latlngIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->latlngIDArr))
				$ele->attributes["id"] = "latlnginput_" . rand(0, 999);

			if(empty($ele->height))
				$ele->height = 200;

			$ele->attributes["readonly"] = "readonly";
			if(empty($ele->hint))
				$ele->hint = "Drag Map Marker to Select Location...";
		}
		elseif($eleType == "checksort") {
			//The identifiers for both the sort and checksort element types are stores in the same array (this->jquerySortIDArr).  This is done because they use the same jquery ui sortable functionality.
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "checksort_" . rand(0, 999);
			if(!isset($this->jquerySortIDArr))
				$this->jquerySortIDArr = array();
			while(in_array($ele->attributes["id"], $this->jquerySortIDArr))
				$ele->attributes["id"] = "checksort_" . rand(0, 999);
			$this->jquerySortIDArr[] = $ele->attributes["id"];

			//This variable triggers a javascript section for handling the dynamic adding/removing of sortable option when a user clicks the checkbox.
			$this->jqueryCheckSort = 1;
		}
		elseif($eleType == "captcha") {
			//If there is a captcha elements in the form, make sure javascript onsubmit function is enabled.
			if(empty($this->captchaExists))
				$this->captchaExists = 1;
			else
				return;

			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "captchainput_" . rand(0, 999);

			$this->captchaID = array();
			$this->captchaID = $ele->attributes["id"];
		}
		elseif($eleType == "slider") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "sliderinput_" . rand(0, 999);
			if(!isset($this->jquerySliderIDArr))
				$this->jquerySliderIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->jquerySliderIDArr))
				$ele->attributes["id"] = "sliderinput_" . rand(0, 999);

			$jqueryOptions = array();
			if(empty($this->jqueryAllowedParams["slider"]))
				$this->jqueryAllowedParams["slider"] = array("disabled", "animate", "max", "min", "orientation", "step");
			if(!empty($ele->jqueryOptions)) {
				foreach($ele->jqueryOptions as $key => $val) {
					if(in_array($key, $this->jqueryAllowedParams["slider"])) 
						$jqueryOptions[$key] = $val;
				}
			}

			//Added for backwards compatibility to ensure the min, max, orientation, and snapIncrement element attributes are still functional in future releases.
			if(isset($ele->min) && !array_key_exists("min", $jqueryOptions))
				$jqueryOptions["min"] = $ele->min;
			if(isset($ele->max) && !array_key_exists("max", $jqueryOptions))
				$jqueryOptions["max"] = $ele->max;
			if(!empty($ele->orientation) && !array_key_exists("orientation", $jqueryOptions))
				$jqueryOptions["orientation"] = $ele->orientation;
			if(!empty($ele->snapIncrement) && !array_key_exists("step", $jqueryOptions))
				$jqueryOptions["step"] = $ele->snapIncrement;

			//Set default values if not specified by user.
			if(!array_key_exists("min", $jqueryOptions))
				$jqueryOptions["min"] = "0";
			if(!array_key_exists("max", $jqueryOptions))
				$jqueryOptions["max"] = "100";
			if(!array_key_exists("orientation", $jqueryOptions) || !in_array($jqueryOptions["orientation"], array("horizontal", "vertical")))
				$jqueryOptions["orientation"] = "horizontal";

			$ele->jqueryOptions = $jqueryOptions;

			if(empty($ele->prefix))
				$ele->prefix = "";

			if(empty($ele->suffix))
				$ele->suffix = "";

			if($ele->jqueryOptions["orientation"] == "vertical" && !empty($ele->height)) {
				if(substr($ele->height, -2) != "px")
					$ele->height .= "px";
			}		

			$this->jquerySliderIDArr[$ele->attributes["id"]] = $ele;
		}
		elseif($eleType == "rating") {
			$ele->ratingID = "starrating_" . rand(0, 999);
			if(!isset($this->jqueryStarRatingIDArr))
				$this->jqueryStarRatingIDArr = array();
			while(array_key_exists($ele->ratingID, $this->jqueryStarRatingIDArr))
				$ele->ratingID = "starrating_" . rand(0, 999);
			$this->jqueryStarRatingIDArr[$ele->ratingID] = "";

			$jqueryOptions = array("inputType" => "select", "cancelValue" => "");
			if(empty($this->jqueryAllowedParams["rating"]))
				$this->jqueryAllowedParams["rating"] = array("disabled", "split", "oneVoteOnly", "captionEl", "cancelShow");
			if(!empty($ele->jqueryOptions)) {
				foreach($ele->jqueryOptions as $key => $val) {
					if(in_array($key, $this->jqueryAllowedParams["rating"])) 
						$jqueryOptions[$key] = $val;
				}
			}

			//Added for backwards compatibility to ensure the hideCancel element attribute is still functional in future releases.
			if(!empty($ele->hideCancel) && !array_key_exists("cancelShow", $jqueryOptions))
				$jqueryOptions["cancelShow"] = false;

			//Set default values if not specified by user.
			if(empty($ele->hideCaption) && !array_key_exists("captionEl", $jqueryOptions))
				$jqueryOptions["captionEl"] = 'js:jQuery("#' . $ele->ratingID . '_caption")';

			$ele->jqueryOptions = $jqueryOptions;
		}
		elseif($eleType == "color") {
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "colorinput_" . rand(0, 999);
			if(!isset($this->jqueryColorIDArr))
				$this->jqueryColorIDArr = array();
			while(in_array($ele->attributes["id"], $this->jqueryColorIDArr))
				$ele->attributes["id"] = "colorinput_" . rand(0, 999);
			$this->jqueryColorIDArr[] = $ele->attributes["id"];

			if(empty($ele->hint))
				$ele->hint = "Click to Select Color...";
		}

		//If there is a required field type in the form, make sure javascript error checking is enabled.
		if(!empty($ele->required) && empty($this->checkform))
			$this->checkform = 1;

		if(!empty($ele->label) && !empty($ele->tooltip)) {
			if(!isset($this->tooltipIDArr))
				$this->tooltipIDArr = array(); 
			$ele->tooltipID = "tooltip_" . rand(0, 999);
			while(array_key_exists($ele->tooltipID, $this->tooltipIDArr))
				$ele->tooltipID = "tooltip_" . rand(0, 999);
			$this->tooltipIDArr[$ele->tooltipID] = $ele;
		}

		//Add the appropriate javascript event functions if hint is present.  Several elements such as date and latlng have default hints that will be automatically applied.  An example of a hint is "Click to Select Date".
		if(in_array($eleType, array("text", "textarea", "date", "daterange", "color", "latlng", "email")) && !empty($ele->hint)) {
			$hintFocusFunction = "hintfocus_" . $this->attributes["id"] . '(this, "' . str_replace('"', '\"', stripslashes($ele->hint)) . '");';
			if(empty($ele->attributes["onclick"]))
				$ele->attributes["onclick"] = $hintFocusFunction;
			else
				$ele->attributes["onclick"] .= " " . $hintFocusFunction;

			$hintBlurFunction = "hintblur_" . $this->attributes["id"] . '(this, "' . str_replace('"', '\"', stripslashes($ele->hint)) . '");';
			if(empty($ele->attributes["onblur"]))
				$ele->attributes["onblur"] = $hintBlurFunction;
			else
				$ele->attributes["onblur"] .= " " . $hintBlurFunction;
			$this->hintExists = 1;	
		}
		else
			unset($ele->hint);
		
		if(!empty($this->labelWidth) || !empty($ele->labelWidth))
			$this->labelWidthExists = true;
		
		if(!empty($ele->integer) && empty($this->integerExists))
			$this->integerExists = 1;
		
		if(!empty($ele->alphanumeric) && empty($this->alphanumericExists))
			$this->alphanumericExists = 1;

		$this->elements[] = $ele;
	}

	public function bind($ref, $jsIfCondition = "", $phpIfCondition = "") {
		$this->bindRules[$ref->attributes["id"]] = array($ref, $jsIfCondition, $phpIfCondition);
		if(!empty($ref->emailExists))
			$this->emailExists = 1;
	}

	private function buildSessionValues($form, $referenceValues) {
		$elementSize = sizeof($form->elements);
		for($e = 0; $e < $elementSize; ++$e) {
			$eleName = $form->elements[$e]->attributes["name"];
			if(substr($eleName , -2) == "[]")
				$eleName = substr($eleName, 0, -2);

			if(array_key_exists($eleName, $referenceValues)) {
				if(is_array($referenceValues[$eleName])) {
					$valSize = sizeof($referenceValues[$eleName]);
					for($v = 0; $v < $valSize; ++$v)
						$_SESSION["pfbc-values"][$form->attributes["id"]][$eleName][$v] = stripslashes($referenceValues[$eleName][$v]);
				}
				else
					$_SESSION["pfbc-values"][$form->attributes["id"]][$eleName] = stripslashes($referenceValues[$eleName]);
			}	
		}

		if(array_key_exists("recaptcha_challenge_field", $_SESSION["pfbc-values"][$form->attributes["id"]]))
			unset($_SESSION["pfbc-values"][$form->attributes["id"]]["recaptcha_challenge_field"]);
		if(array_key_exists("recaptcha_response_field", $_SESSION["pfbc-values"][$form->attributes["id"]]))
			unset($_SESSION["pfbc-values"][$form->attributes["id"]]["recaptcha_response_field"]);
	}

	public function clearElements() {
		$this->elements = array();
	}

	public function closeFieldset() {
		$this->addElement("", "", "htmlexternal", '</fieldset>');
	}

	public function elementsToString() {
		$str = "";

		if(empty($this->referenceValues) && !empty($_SESSION["pfbc-values"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-values"]))
			$this->setValues($_SESSION["pfbc-values"][$this->attributes["id"]]);

		if(empty($this->generateInlineResources))
			$this->setIncludePaths();

		if(empty($this->phpIncludesPath) || !is_dir($this->phpIncludesPath))
			$str .= "\n\t" . '<script type="text/javascript">alert("php-form-builder-class Configuration Error: Invalid includes Directory Path\n\nUse the includesPath form attribute to identify the location of the inclues directory included within the php-form-builder-class folder.\n\nPath specified:\n' . $this->includesPath . '\n\nEXTRA INFORMATION:\nPHP Path Used:\n' . $this->phpIncludesPath . '\n\nJavascript Path Used:\n' . $this->jsIncludesPath . '");</script>';

		if(empty($this->tooltipIcon))
			$this->tooltipIcon = $this->jsIncludesPath . "/jquery/plugins/poshytip/tooltip-icon.gif";

		if(empty($this->noAutoFocus))
			$focus = true;
		else
			$focus = false;

		if(empty($this->hasFormTag)) {
			$str .= "\n" . '<div id="' . $this->attributes["id"] . '"';
			if(empty($this->generateInlineResources))
				$str .= ' style="visibility: hidden;"';
			$str .= ">";
		}	
		else {
			$str .= "\n<form";
			if(!empty($this->attributes["class"]))
				$this->attributes["class"] .= " pfbc-form";
			else	
				$this->attributes["class"] = "pfbc-form";
			if(empty($this->generateInlineResources)) {
				if(!empty($this->attributes["style"]))
					$this->attributes["style"] .= " visibility: hidden;";
				else	
					$this->attributes["style"] = "visibility: hidden;";
			}	
			if(!empty($this->attributes) && is_array($this->attributes)) {
				/*This syntax will be used throughout the render() and elementsToString() functions ensuring that attributes added to various HTML tags
				are allowed and valid.  If you find that an attribute is not being included in your HTML tag definition, please reference $this->allowedFields.*/
				$tmpAllowFieldArr = $this->allowedFields["form"];
				foreach($this->attributes as $key => $value) {
					//Skip any user-defined onsubmit function if one or more of the following conditions is met.
					if($key == "onsubmit" && (!empty($this->checkform) || !empty($this->ajax) || !empty($this->captchaExists) || !empty($this->hintExists) || !empty($this->emailExists) || !empty($this->integerExists) || !empty($this->alphanumericExists)))
						continue;
					if(in_array($key, $tmpAllowFieldArr))
						$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
				}	
			}
			if(!empty($this->checkform) || !empty($this->ajax) || !empty($this->captchaExists) || !empty($this->hintExists) || !empty($this->emailExists) || !empty($this->integerExists) || !empty($this->alphanumericExists))	
				$str .= ' onsubmit="return pfbc_onsubmit_' . $this->attributes["id"] . '(this);"';
			$str .= ">";
		}

		$str .= "\n" . '<div class="pfbc-main">';

		if(!empty($this->errorMsg))
			$str .= '<div class="pfbc-error ui-state-error ui-corner-all">' . $this->errorMsg . '</div>';

		if(!empty($this->map)) {
			$mapIndex = 0;
			$mapCount = 0;
		}	

		$elementSize = sizeof($this->elements);

		$hiddenElementExists = false;
		$nonHiddenElements = array();
		$nonHiddenInternalElementSize = 0;
		for($i = 0; $i < $elementSize; ++$i) {
			$ele = &$this->elements[$i];

			/*This if/elseif section reads in the appropriate states/countries from an external file if necessary.
			It's included here because the phpIncludesPath attribute is not available in the attachElement function.*/
			if($ele->attributes["type"] == "state") {
				$ele->attributes["type"] = "select";

				if(empty($this->stateArr)) {
					include($this->phpIncludesPath . "/stateArr.json.php");
					$jsonObj = json_decode($jsonStates);
					$this->stateArr = array();
					for($s = 0; $s < sizeof($jsonObj->keys); $s++)
						$this->stateArr[] = array("value" => $jsonObj->keys[$s], "text" => $jsonObj->values[$s]);
				}		

				$ele->options = array();
				$stateSize = sizeof($this->stateArr);
				for($s = 0; $s < $stateSize; ++$s) {
					$opt = new option();
					$opt->setAttributes($this->stateArr[$s]);
					$ele->options[] = $opt;
				}
			}	
			elseif($ele->attributes["type"] == "country") {
				$ele->attributes["type"] = "select";

				if(empty($this->countryArr)) {
					include($this->phpIncludesPath . "/countryArr.json.php");
					$jsonObj = json_decode($jsonCountries);
					$this->countryArr = array();
					for($s = 0; $s < sizeof($jsonObj->keys); $s++)
						$this->countryArr[] = array("value" => $jsonObj->keys[$s], "text" => $jsonObj->values[$s]);
				}		

				$ele->options = array();
				$countrySize = sizeof($this->countryArr);
				for($s = 0; $s < $countrySize; ++$s) {
					$opt = new option();
					$opt->setAttributes($this->countryArr[$s]);
					$ele->options[] = $opt;
				}
			}	

			if($ele->attributes["type"] == "hidden") {
				//If the referenceValues array is filled, check for this specific element's name in the associative array key and populate the field's value if applicable.
				if(!empty($this->referenceValues) && is_array($this->referenceValues)) {
					if(array_key_exists($ele->attributes["name"], $this->referenceValues))
						$ele->attributes["value"] = $this->referenceValues[$ele->attributes["name"]];
					elseif(substr($ele->attributes["name"], -2) == "[]" && array_key_exists(substr($ele->attributes["name"], 0, -2), $this->referenceValues))
						$ele->attributes["value"] = $this->referenceValues[substr($ele->attributes["name"], 0, -2)];
				}	

				if(!$hiddenElementExists) {
					$str .= "\n\t" . '<div class="pfbc-hidden">';
					$hiddenElementExists = true;
				}	

				$str .= "\n\t\t<input";
				if(!empty($ele->attributes) && is_array($ele->attributes)) {
					$tmpAllowFieldArr = $this->allowedFields["text"];
					foreach($ele->attributes as $key => $value) {
						if(in_array($key, $tmpAllowFieldArr))
							$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
					}		
				}
				$str .= "/>";
			}
			else {
				if(!in_array($ele->attributes["type"], array("button", "htmlexternal")))
					++$nonHiddenInternalElementSize;
				$nonHiddenElements[] = &$this->elements[$i];
			}	
		}	
		if($hiddenElementExists)
			$str .= "\n\t</div>";
		
		$elementSize = sizeof($nonHiddenElements);
		$nonHiddenInternalElementCount = 0;

		for($i = 0; $i < $elementSize; ++$i) {
			$ele = &$nonHiddenElements[$i];
			$map_element_first = false;
			$map_element_last = false;

			//If the referenceValues array is filled, check for this specific element's name in the associative array key and populate the field's value if applicable.
			if(!empty($this->referenceValues) && is_array($this->referenceValues)) {
				if(array_key_exists($ele->attributes["name"], $this->referenceValues))
					$ele->attributes["value"] = $this->referenceValues[$ele->attributes["name"]];
				elseif(substr($ele->attributes["name"], -2) == "[]" && array_key_exists(substr($ele->attributes["name"], 0, -2), $this->referenceValues))
					$ele->attributes["value"] = $this->referenceValues[substr($ele->attributes["name"], 0, -2)];
			}	

			if($ele->attributes["type"] == "htmlexternal")
				$str .= "\n\t" . $ele->attributes["value"];
			elseif($ele->attributes["type"] == "button") {
				if($i == 0 || $nonHiddenElements[($i - 1)]->attributes["type"] != "button") {
					$str .= "\n\t" . '<div class="pfbc-buttons';
					if($nonHiddenInternalElementCount == $nonHiddenInternalElementSize)
						$str .= ' pfbc-nopaddingbottom';
					$str .= '">';
				}	
				$str .= $ele->attributes["value"];
				if(($i + 1) == $elementSize || $nonHiddenElements[($i + 1)]->attributes["type"] != "button")
					$str .= "\n\t" . '</div>';
			}	
			else {	
				if(!empty($this->map)) {
					if(array_key_exists($mapIndex, $this->map) && $this->map[$mapIndex] > 1) {
						if($mapCount == 0) {
							$map_element_first = true;
							$str .= "\n\t" . '<div class="pfbc-map pfbc-clear">';
							if(($nonHiddenInternalElementSize - $nonHiddenInternalElementCount) < $this->map[$mapIndex])
								$this->map[$mapIndex] = $nonHiddenInternalElementSize - $nonHiddenInternalElementCount;
						}	
					}
					else {
						$this->map[$mapIndex] = 1;
						$map_element_first = true;
						$str .= "\n\t" . '<div class="pfbc-map pfbc-clear">';
					}	

					if(($nonHiddenInternalElementCount + 1) == $nonHiddenInternalElementSize)
						$map_element_last = true;
					elseif(array_key_exists($mapIndex, $this->map) && $this->map[$mapIndex] > 1) {
						if(($mapCount + 1) == $this->map[$mapIndex])
							$map_element_last = true;
					}
					else
						$map_element_last = true;
				}

				$str .= "\n\t";
				if(!empty($this->map))
					$str .= "\t";

				$ele->container = "pfbc-" . $this->attributes["id"] . "-element-" . $nonHiddenInternalElementCount;
				$str .= '<div id="' . $ele->container . '" class="pfbc-element';
				$ele->container = "#" . $ele->container;

				if($map_element_first && $map_element_last)
					$str .= ' pfbc-map-element-single';
				elseif($map_element_first)
					$str .= ' pfbc-map-element-first';
				elseif($map_element_last)
					$str .= ' pfbc-map-element-last';
				if(!empty($this->map)) {
					if(array_key_exists($mapIndex, $this->map))
						$str .= ' pfbc-map-columns-' . $this->map[$mapIndex];
					else
						$str .= ' pfbc-map-columns-1';
				}
				if(!empty($this->labelWidth) || !empty($ele->labelWidth))
					$str .= ' pfbc-clear';
				if((empty($this->map) && ($i + 1) == $elementSize) || (!empty($this->map) && ($i + ($this->map[$mapIndex] - $mapCount)) == $elementSize))
					$str .= ' pfbc-nopaddingbottom';
				$str .= '">';

				if(!empty($ele->preHTML))
					$str .= $this->indent() . $ele->preHTML;

				if(!empty($ele->label)) {
					$str .= $this->indent() . '<label class="pfbc-label">';

					if(!empty($ele->required))
						$str .= '<span class="pfbc-required">*</span> ';
					$str .= $ele->label;

					if(!empty($ele->tooltip))
						$str .= ' <img id="' . $ele->tooltipID . '" src="' . $this->tooltipIcon . '" alt=""/>';

					$str .= "</label>";
				}	

				$eleType = &$ele->attributes["type"];
				
				if(!empty($ele->hint) && empty($ele->attributes["value"]))
					$ele->attributes["value"] = $ele->hint;

				$str .= $this->indent();
				if(in_array($eleType, array("text", "password", "email", "date", "daterange", "color"))) {
					//Temporarily set the type attribute to "text" for <input> tag.
					if(in_array($eleType, array("email", "date", "daterange", "color"))) {
						$resetTypeTo = $eleType;
						$eleType = "text";
					}	

					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-textbox";
					else	
						$ele->attributes["class"] = "pfbc-textbox";
					
					if(!empty($ele->integer))
						$ele->attributes["class"] .= " pfbc-integer";
					elseif(!empty($ele->alphanumeric))
						$ele->attributes["class"] .= " pfbc-alphanumeric";
						
					$str .= "<input";
					if(!empty($ele->attributes) && is_array($ele->attributes)) {
						$tmpAllowFieldArr = $this->allowedFields["text"];
						foreach($ele->attributes as $key => $value) {
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}		
					}
					$str .= "/>";
					if($focus)
						$this->focusElement = $ele->attributes["name"];
					
					//Now that <input> tag his been rendered, change type attribute back appropriately.
					if(isset($resetTypeTo)) {
						$eleType = $resetTypeTo;
						unset($resetTypeTo);
					}
				}
				elseif($eleType == "file") {
					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-file";
					else	
						$ele->attributes["class"] = "pfbc-file";

					$str .= "<input";
					if(!empty($ele->attributes) && is_array($ele->attributes)) {
						$tmpAllowFieldArr = $this->allowedFields["text"];
						foreach($ele->attributes as $key => $value) {
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}		
					}
					$str .= "/>";
					if($focus)
						$this->focusElement = $ele->attributes["name"];
				}
				elseif(in_array($eleType, array("textarea", "webeditor", "ckeditor"))) {
					if(empty($ele->attributes["rows"]))
						$ele->attributes["rows"] = "6";
					if(empty($ele->attributes["cols"]))
						$ele->attributes["cols"] = "30";

					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-textarea";
					else
						$ele->attributes["class"] = "pfbc-textarea";

					if($eleType == "webeditor") {
						if(!empty($ele->basic))
							$ele->attributes["class"] .= " tiny_mce_simple";
						else
							$ele->attributes["class"] .= " tiny_mce";
					}

					$str .= "<textarea";
					if(!empty($ele->attributes) && is_array($ele->attributes)) {
						$tmpAllowFieldArr = $this->allowedFields["textarea"];
						foreach($ele->attributes as $key => $value) {
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}
					}
					$str .= ">" . $ele->attributes["value"] . "</textarea>";
					if($focus)
						$this->focusElement = $ele->attributes["name"];

					if($eleType == "ckeditor")
						$this->ckeditorIDArr[$ele->attributes["id"]] = $ele; 
				}
				elseif($eleType == "select" || $eleType == "rating") {
					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-select";
					else
						$ele->attributes["class"] = "pfbc-select";
					
					if(!empty($ele->attributes["multiple"]) && substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";

					if($eleType == "rating")
						$str .= '<table cellpadding="0" cellspacing="0" border="0"><tr><td valign="middle"><div id="' . $ele->ratingID . '">';

					$str .= "<select";
					if(!empty($ele->attributes) && is_array($ele->attributes)) {
						$tmpAllowFieldArr = $this->allowedFields["select"];
						foreach($ele->attributes as $key => $value) {
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}
					}
					$str .= ">";

					if(!is_array($ele->attributes["value"])) {
						if($ele->attributes["value"] !== "") {
							if(is_numeric($ele->attributes["value"]))
								$ele->attributes["value"] = (string) $ele->attributes["value"];
						}		
					}
					else {
						$valueSize = sizeof($ele->attributes["value"]);
						for($v = 0; $v < $valueSize; ++$v) {
							if($ele->attributes["value"][$v] !== "") {
								if(is_numeric($ele->attributes["value"][$v]))
									$ele->attributes["value"][$v] = (string) $ele->attributes["value"][$v];
							}		
						}
					}

					$selected = false;
					if(is_array($ele->options)) {
						$optionSize = sizeof($ele->options);
						for($o = 0; $o < $optionSize; ++$o) {
							if($ele->options[$o]->value !== "") {
								if(is_numeric($ele->options[$o]->value))
									$ele->options[$o]->value = (string) $ele->options[$o]->value;
							}		

							$str .= $this->indent("\t") . '<option value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"';
							if((!is_array($ele->attributes["value"]) && !$selected && $ele->attributes["value"] === $ele->options[$o]->value) || (is_array($ele->attributes["value"]) && in_array($ele->options[$o]->value, $ele->attributes["value"], true))) {
								$str .= ' selected="selected"';
								$selected = true;
							}
							$str .= '>' . $ele->options[$o]->text . "</option>";
						}
					}

					$str .= $this->indent() . "</select>";

					if($eleType == "rating") {
						$str .= $this->indent() . '</div></td>';

						if(empty($ele->hideCaption))
							$str .= '<td valign="middle"><div id="' . $ele->ratingID . '_caption" style="padding-left: 0.5em;"></div></td>';

						$str .= '</tr></table>';
						$this->jqueryStarRatingIDArr[$ele->ratingID] = $ele;
					}

					if($focus)
						$this->focusElement = $ele->attributes["name"];
				}
				elseif($eleType == "radio") {
					if(is_array($ele->options)) {

						if($ele->attributes["value"] !== "") {
							if(is_numeric($ele->attributes["value"]))
								$ele->attributes["value"] = (string) $ele->attributes["value"];
						}		

						$optionSize = sizeof($ele->options);
						$str .= '<div class="pfbc-radio-buttons">';
						for($o = 0; $o < $optionSize; ++$o) {

							if($ele->options[$o]->value !== "") {
								if(is_numeric($ele->options[$o]->value))
									$ele->options[$o]->value = (string) $ele->options[$o]->value;
							}		

							$str .= $this->indent("\t") . '<div class="pfbc-radio';
							if($o == 0)
								$str .= ' pfbc-radio-first';
							elseif($o + 1 == $optionSize)	
								$str .= ' pfbc-radio-last';

							$str .= '"><input';
							$tmpAllowFieldArr = $this->allowedFields["radio"];
							if(!empty($ele->attributes) && is_array($ele->attributes)) {
								foreach($ele->attributes as $key => $value) {
									if(in_array($key, $tmpAllowFieldArr))
										$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
								}		
							}
							$str .= ' id="' . str_replace('"', '&quot;', $ele->attributes["name"]) . $o . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"';		
							if($ele->attributes["value"] === $ele->options[$o]->value)
								$str .= ' checked="checked"';
							$str .= '/>';
							$str .= '<label for="' . str_replace('"', '&quot;', $ele->attributes["name"]) . $o . '" style="cursor: pointer;">' . $ele->options[$o]->text . "</label></div>";
						}	

						if(!empty($ele->noBreak))
							$str .= $this->indent("\t") . '<div style="clear: both;"></div>';

						$str .= $this->indent() . '</div>';

						if($focus)
							$this->focusElement = $ele->attributes["name"];
					}
				}
				elseif($eleType == "checkbox") {
					if(is_array($ele->options)) {
						$optionSize = sizeof($ele->options);

						if($optionSize > 1 && substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";

						if(!is_array($ele->attributes["value"])) {
							if($ele->attributes["value"] !== "") {
								if(is_numeric($ele->attributes["value"]))
									$ele->attributes["value"] = (string) $ele->attributes["value"];
							}		
						}
						else {
							$valueSize = sizeof($ele->attributes["value"]);
							for($v = 0; $v < $valueSize; ++$v) {
								if($ele->attributes["value"][$v] !== "") {
									if(is_numeric($ele->attributes["value"][$v]))
										$ele->attributes["value"][$v] = (string) $ele->attributes["value"][$v];
								}		
							}
						}

						$str .= '<div class="pfbc-checkboxes">';
						for($o = 0; $o < $optionSize; ++$o) {
							if($ele->options[$o]->value !== "") {
								if(is_numeric($ele->options[$o]->value))
									$ele->options[$o]->value = (string) $ele->options[$o]->value;
							}		

							$str .= $this->indent("\t") . '<div class="pfbc-checkbox';
							if($o == 0)
								$str .= ' pfbc-checkbox-first';
							elseif($o + 1 == $optionSize)	
								$str .= ' pfbc-checkbox-last';

							$str .= '"><input';
							if(!empty($ele->attributes) && is_array($ele->attributes)) {
								$tmpAllowFieldArr = $this->allowedFields["radio"];
								foreach($ele->attributes as $key => $value) {
									if(in_array($key, $tmpAllowFieldArr))
										$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
								}		
							}
							$tmpID = str_replace(array('"', '[]'), array('&quot;', '-'), $ele->attributes["name"]) . $o;
							$str .= ' id="' . $tmpID . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"';		

							//For checkboxes, the value parameter can be an array - which allows for multiple boxes to be checked by default.
							if((!is_array($ele->attributes["value"]) && $ele->attributes["value"] === $ele->options[$o]->value) || (is_array($ele->attributes["value"]) && in_array($ele->options[$o]->value, $ele->attributes["value"], true)))
								$str .= ' checked="checked"';
							$str .= '/>';
							$str .= '<label for="' . $tmpID . '" style="cursor: pointer;">' . $ele->options[$o]->text . '</label></div>';
						}	

						if(!empty($ele->noBreak))
							$str .= $this->indent("\t") . '<div style="clear: both;"></div>';

						$str .= $this->indent() . '</div>';

						if($focus)
							$this->focusElement = $ele->attributes["name"];
					}
				}
				elseif($eleType == "sort") {
					if(is_array($ele->options)) {
						if(substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";

						if(!empty($ele->attributes["value"])) {
							$options = array();
							$optionSize = sizeof($ele->options);
							for($o = 0; $o < $optionSize; ++$o)
								$options[$ele->options[$o]->value] = $ele->options[$o]->text;

							foreach($options as $key => $value) {
								$index = array_search($key, $ele->attributes["value"]);
								if($index !== false) {
									$opt = new option();
									$opt->setAttributes(array("value" => $key, "text" => $value));
									$ele->options[$index] = $opt;
								}	
							}
						}

						$str .= '<ul id="' . str_replace('"', '&quot;', $ele->attributes["id"]) . '" class="pfbc-sort" style="list-style-type: none; margin: 0; padding: 0; cursor: pointer;">';

						$optionSize = sizeof($ele->options);
						for($o = 0; $o < $optionSize; ++$o)
							$str .= $this->indent("\t") . '<li class="ui-state-default" style="margin: 3px 0; padding-left: 0.5em; font-size: 1em; height: 2.5em; line-height: 2.5em;"><input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"/>' . $ele->options[$o]->text . '</li>';

						$str .= $this->indent() . "</ul>";
					}
				}
				elseif($eleType == "latlng") {
					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-textbox";
					else	
						$ele->attributes["class"] = "pfbc-textbox";
					
					if(empty($ele->attributes["style"]))
						$ele->attributes["style"] = "";

					//If the value is formatted "Latitude: 123.45, Longitude: -67.89" parse and convert to array.
					if(!empty($ele->attributes["value"]) && !is_array($ele->attributes["value"]) && strpos($ele->attributes["value"], "Latitude:", 0) === 0)
						$ele->attributes["value"] = array(substr($ele->attributes["value"], strpos($ele->attributes["value"], ":") + 2, strpos($ele->attributes["value"], ",") - strpos($ele->attributes["value"], ":") - 2), substr($ele->attributes["value"], strrpos($ele->attributes["value"], ":") + 1));

					$latlngID = htmlentities($ele->attributes["id"], ENT_QUOTES);

					//Temporarily set the type attribute to "text" for <input> tag.
					$eleType = "text";

					$str .= '<div class="pfbc-latlng">';
					$str .= $this->indent("\t") . "<input";
					if(!empty($ele->attributes) && is_array($ele->attributes)) {
						$tmpAllowFieldArr = $this->allowedFields["latlng"];
						foreach($ele->attributes as $key => $value) {
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}	
					}
					$str .= ' value="';
					if(!empty($ele->attributes["value"]) && is_array($ele->attributes["value"]))	
						$str .=  "Latitude: " . $ele->attributes["value"][0] . ", Longitude: " . $ele->attributes["value"][1];
					else
						$str .= str_replace('"', '&quot;', $ele->hint);
					$str .= '"/>';

					//Now that <input> tag his been rendered, change type attribute back to "latlng".
					$eleType = "latlng";

					$str .= $this->indent("\t") . '<div id="' . $latlngID . '_canvas" style="margin: 2px 0; height: ' . $ele->height . 'px;';
					if(!empty($ele->width))
						$str .= ' width: ' . $ele->width . 'px;';
					$str .= '"></div>';

					if(empty($ele->hideJump))
						$str .= $this->indent("\t") . '<input id="' . $latlngID . '_locationJump" type="text" value="Location Jump: Enter Keyword, City/State, Address, or Zip Code" class="' . str_replace('"', '&quot;', $ele->attributes["class"]) . '" style="' . str_replace('"', '&quot;', $ele->attributes["style"]) . '" onfocus="focusJumpToLatLng_' . $this->attributes["id"] . '(this);" onblur="blurJumpToLatLng_' . $this->attributes["id"] . '(this);" onkeyup="jumpToLatLng_' . $this->attributes["id"] . '(this, \'' . $latlngID . '\', \'' . htmlentities($ele->attributes["name"], ENT_QUOTES) . '\');"/>';

					$str .= $this->indent("\t") . '<div id="' . $latlngID . '_clearDiv" style="';
					if(empty($ele->attributes["value"]) || !is_array($ele->attributes["value"]))
						$str .= 'display: none;';
					$str .= '"><a href="javascript: clearLatLng_' . $this->attributes["id"] . '(\'' . $latlngID . '\', \'' . htmlentities($ele->hint, ENT_QUOTES) . '\');" class="pfbc-link">Clear Latitude/Longitude</a></div>';	
					$str .= $this->indent() . "</div>";

					$this->latlngIDArr[$ele->attributes["id"]] = $ele;
				}
				elseif($eleType == "checksort") {
					if(is_array($ele->options)) {
						if(substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";

						if(!is_array($ele->attributes["value"])) {
							if($ele->attributes["value"] !== "") {
								if(is_numeric($ele->attributes["value"]))
									$ele->attributes["value"] = (string) $ele->attributes["value"];
							}		
						}
						else {
							$valueSize = sizeof($ele->attributes["value"]);
							for($v = 0; $v < $valueSize; ++$v) {
								if($ele->attributes["value"][$v] !== "") {
									if(is_numeric($ele->attributes["value"][$v]))
										$ele->attributes["value"][$v] = (string) $ele->attributes["value"][$v];
								}		
							}
						}

						//This variable triggers a javascript section for handling the dynamic adding/removing of sortable option when a user clicks the checkbox.
						$this->jqueryCheckSort = 1;

						$str .= '<div class="pfbc-checkboxes">';
						$sortLIArr = array();
						$optionSize = sizeof($ele->options);
						for($o = 0; $o < $optionSize; ++$o) {
							if($ele->options[$o]->value !== "") {
								if(is_numeric($ele->options[$o]->value))
									$ele->options[$o]->value = (string) $ele->options[$o]->value;
							}		

							$str .= $this->indent("\t") . '<div class="pfbc-checkbox';
							if($o == 0)
								$str .= ' pfbc-checkbox-first';
							elseif($o + 1 == $optionSize)	
								$str .= ' pfbc-checkbox-last';
							$str .= '"><input';
							if(!empty($ele->attributes) && is_array($ele->attributes)) {
								$tmpAllowFieldArr = $this->allowedFields["checksort"];
								foreach($ele->attributes as $key => $value) {
									if(in_array($key, $tmpAllowFieldArr))
										$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
								}		
							}

							$tmpID = str_replace(array('"', '[]'), array('&quot;', '-'), $ele->attributes["name"]) . $o;
							$str .= ' id="' . $tmpID . '" type="checkbox" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '" onclick="addOrRemoveCheckSortItem_' . $this->attributes["id"] . '(this, \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->attributes["id"]) . '\', \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->attributes["name"]) . '\', ' . $o . ', \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->options[$o]->value) . '\', \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->options[$o]->text) . '\');"';

							//For checkboxes, the value parameter can be an array - which allows for multiple boxes to be checked by default.
							if((!is_array($ele->attributes["value"]) && $ele->attributes["value"] === $ele->options[$o]->value) || (is_array($ele->attributes["value"]) && in_array($ele->options[$o]->value, $ele->attributes["value"], true))) {
								$str .= ' checked="checked"';
								$sortLIArr[$ele->options[$o]->value] = '<li id="' . str_replace('"', '&quot;', $ele->attributes["id"]) . $o . '" class="ui-state-default" style="margin: 3px 0; padding-left: 0.5em; font-size: 1em; height: 2.5em; line-height: 2.5em;"><input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"/></span>' . $ele->options[$o]->text . '</li>' . "\n";
							}	
							$str .= '/>';
							$str .= '<label for="' . $tmpID . '" style="cursor: pointer;">' . $ele->options[$o]->text . '</label></div>';
						}	
						$str .= $this->indent() . "</div>";

						if(!empty($ele->noBreak))
							$str .= '<div style="clear: both;"></div>';

						//If there are any check options by default, render the <ul> sorting structure.
						$str .= $this->indent() . '<ul id="' . str_replace('"', '&quot;', $ele->attributes["id"]) . '" class="pfbc-sort" style="list-style-type: none; margin: 0; padding: 0; cursor: pointer;">';
						if(!empty($sortLIArr)) {
							if(is_array($ele->attributes["value"])) {
								$eleValueSize = sizeof($ele->attributes["value"]);
								for($li = 0; $li < $eleValueSize; ++$li) {
									if(isset($sortLIArr[$ele->attributes["value"][$li]]))
										$str .= $this->indent("\t") . $sortLIArr[$ele->attributes["value"][$li]];	
								}
							}
							else {
								if(isset($sortLIArr[$ele->attributes["value"]]))
									$str .= $this->indent("\t") . $sortLIArr[$ele->attributes["value"]];
							}		
						}
						$str .= $this->indent("\t") . "<li style='display: none'>&nbsp;</li>" . $this->indent() . "</ul>";
					}
				}
				elseif($eleType == "captcha")
					$str .= '<div id="' . $ele->attributes["id"] . '" class="pfbc-captcha"></div>';
				elseif($eleType == "slider") {
					if(empty($ele->attributes["value"]))
						$ele->attributes["value"] = "0";
					if(is_array($ele->attributes["value"]) && sizeof($ele->attributes["value"]) == 1)
						$ele->attributes["value"] = $ele->attributes["value"][0];

					if(!is_array($ele->attributes["value"])) {
						if(!empty($ele->jqueryOptions["min"]) && $ele->attributes["value"] < $ele->jqueryOptions["min"])
							$ele->attributes["value"] = $ele->jqueryOptions["min"];
						if(!empty($ele->jqueryOptions["max"]) && $ele->attributes["value"] > $ele->jqueryOptions["max"])
							$ele->attributes["value"] = $ele->jqueryOptions["max"];
					}	

					$str .= '<div class="pfbc-slider">';
					$str .= $this->indent("\t") . '<div id="' . $ele->attributes["id"] . '" style="font-size: 12px !important; margin: 2px 0;';
					if($ele->jqueryOptions["orientation"] == "vertical" && !empty($ele->height))
						$str .= ' height: ' . $ele->height;
					$str .= '"></div>';

					if(empty($ele->hideDisplay)) {
						$str .= $this->indent("\t") . '<div id="' . $ele->attributes["id"] . '_display">';
						if(is_array($ele->attributes["value"])) {
							sort($ele->attributes["value"]);
							$str .= $ele->prefix . $ele->attributes["value"][0] . $ele->suffix . " - " . $ele->prefix . $ele->attributes["value"][1] . $ele->suffix;
						}	
						else
							$str .= $ele->prefix . $ele->attributes["value"] . $ele->suffix;
						$str .= '</div>';
					}

					$str .= $this->indent("\t");
					if(is_array($ele->attributes["value"])) {
						if(substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";
						$str .= '<input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->attributes["value"][0]) . '"/>';
						$str .= $this->indent("\t");
						$str .= '<input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->attributes["value"][1]) . '"/>';
					}
					else
						$str .= '<input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->attributes["value"]) . '"/>';
					$str .= $this->indent() . "</div>";	

					$this->jquerySliderIDArr[$ele->attributes["id"]] = $ele;
				}
				elseif($eleType == "html")
					$str .= $ele->attributes["value"];

				if(!empty($ele->postHTML))
					$str .= $this->indent() . $ele->postHTML;
				
				$str .= "\n\t";
				if(!empty($this->map))
					$str .= "\t";

				$str .= "</div>";

				if(!empty($this->map)) {
					if(($nonHiddenInternalElementCount + 1) == $nonHiddenInternalElementSize)
						$str .= "\n\t</div>";
					elseif(array_key_exists($mapIndex, $this->map) && $this->map[$mapIndex] > 1) {
						if(($mapCount + 1) == $this->map[$mapIndex]) {
							$mapCount = 0;
							++$mapIndex;
							$str .= "\n\t</div>";
						}
						else
							++$mapCount;
					}
					else {
						++$mapIndex;
						$mapCount = 0;
						$str .= "\n\t</div>";
					}	
				}

				if($focus && $ele->attributes["type"] != "html")
					$focus = false;

				++$nonHiddenInternalElementCount;
			}
		}

		//This javascript section loads all required js and css files needed for a specific form.  CSS files are loaded into the <head> tag with javascript.
		$str .= <<<STR

	<div class="pfbc-script">

STR;
		//Serialize the form and store it in a session array.  This variable will be unserialized and used within js/css.php and the validate() method.
		$_SESSION["pfbc-instances"][$this->attributes["id"]] = serialize($this);

		if($this->https)
			$prefix = "https";
		else
			$prefix = "http";

		if(empty($this->preventJQueryLoad)) {
			$str .= <<<STR
		<script type="text/javascript" src="$prefix://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

STR;
		}

		if(empty($this->preventJQueryUILoad)) {
			$str .= <<<STR
		<script type="text/javascript" src="$prefix://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>

STR;
		}

		$session_param = "";
		$session_name = session_name();
		if($session_name != "PHPSESSID")
			$session_param = "&session_name=$session_name";

		$str .= <<<STR
		<script type="text/javascript">
			//<![CDATA[
			var jQueryElementObj;
			function pfbc_adjust_{$this->attributes["id"]}() {
				jQuery("#{$this->attributes["id"]} .pfbc-main .pfbc-textbox, #{$this->attributes["id"]} .pfbc-main .pfbc-textarea").each(function() { 
					if(!jQuery(this).hasClass("pfbc-adjusted")) {
						if(jQuery(this).parent().parent().is(":hidden")) {
							jQueryElementObj = jQuery(this);
							jQuery.swap(jQueryElementObj.parent().parent()[0], { position: "absolute", visibility: "hidden", display: "block" }, function() {
								if(jQueryElementObj.hasClass("tiny_mce") || jQueryElementObj.hasClass("tiny_mce_simple"))
									jQueryElementObj.width(jQueryElementObj.width());
								else	
									jQueryElementObj.outerWidth(jQueryElementObj.width());
								jQueryElementObj.addClass("pfbc-adjusted");	
							});
						}	
						else {
							if(jQuery(this).hasClass("tiny_mce") || jQuery(this).hasClass("tiny_mce_simple"))
								jQuery(this).width(jQuery(this).width());
							else	
								jQuery(this).outerWidth(jQuery(this).width());
							jQuery(this).addClass("pfbc-adjusted");	
						}
					}
				});
			}

STR;
		
		if(empty($this->generateInlineResources)) {
			$str .= <<<STR
			jQuery(document).ready(function() {
				jQuery.get('{$this->jsIncludesPath}/css.php?id={$this->attributes["id"]}$session_param', function(cssText) {
					jQuery("head").append('<style type="text/css">' + cssText + '<\/style>');
					if(jQuery("#{$this->attributes["id"]}").parent().is(":hidden")) {
						jQuery.swap(jQuery("#{$this->attributes["id"]}").parent()[0], { position: "absolute", visibility: "hidden", display: "block" }, pfbc_adjust_{$this->attributes["id"]});
					}	
					else
						pfbc_adjust_{$this->attributes["id"]}();
					jQuery("#{$this->attributes["id"]}").css("visibility", "visible");	
				});
				jQuery.getScript("{$this->jsIncludesPath}/js.php?id={$this->attributes["id"]}$session_param", function() {

STR;
			if(!empty($this->hasFormTag)) {
				$str .= <<<STR
					setTimeout("pfbc_focus_{$this->attributes["id"]}();", 250);

STR;
			}
			$str .= <<<STR
				});	
			});

STR;
		}
		$str .= <<<STR
			//]]>
		</script>

STR;
		if(!empty($this->tinymceIDArr)) {
			if(empty($this->preventTinyMCELoad)) {
				$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/tiny_mce/tiny_mce.js"></script>

STR;
			}
		}

		if(!empty($this->ckeditorIDArr)) {
			if(empty($this->preventCKEditorLoad)) {
				$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="{$this->jsIncludesPath}/ckeditor/adapters/jquery.js"></script>

STR;
			}
		}
		$str .= <<<STR
	</div>	

STR;

		$str .= "</div>";

		if(empty($this->hasFormTag))
			$str .= "\n</div>";
		else
			$str .= "\n</form>";

		return $str;
	}

	private function indent($extra = "") {
		$str = "\n$extra";
		$str .= "\t\t";
		if(!empty($this->map))
			$str .= "\t";
		return $str;
	}

	private function jsCycleElements($elements) {
		$str = "";
		$elementSize = sizeof($elements);
		for($i = 0; $i < $elementSize; ++$i) {
			$ele = $elements[$i];
			$eleType = $ele->attributes["type"];
			$eleName = str_replace('"', '&quot;', $ele->attributes["name"]);
			if(!empty($ele->hint))
				$eleHint = str_replace('"', '&quot;', $ele->hint);
			else
				$eleHint = "";

			if(!empty($ele->attributes["id"]))
				$eleId = str_replace('"', '&quot;', $ele->attributes["id"]);
			else
				$eleId = "";

			if(!empty($ele->label)) {
				$eleLabel = str_replace('"', '&quot;', strip_tags($ele->label));
				if(substr($eleLabel, -1) == ":")
					$eleLabel = substr($eleLabel, 0, -1);
			}	
			else
				$eleLabel = str_replace('"', '&quot;', strip_tags($ele->attributes["name"]));                       

			$isRequired = false;
			if(empty($this->preventJSValidation) && !empty($ele->required)) {
				$isRequired = true;
				$errorMsg = str_replace(array("[LABEL]", '"'), array($eleLabel, '&quot;'), $this->errorMsgFormat);
			}

			if($eleType == "html")
				continue;

			if($eleType == "checkbox") {
				$str .= <<<STR
	if(formObj.elements["$eleName"].length) {

STR;
				if($isRequired) {
					$str .= <<<STR
		var is_checked = false;

STR;
				}	
				$str .= <<<STR
		for(i = 0; i < formObj.elements["$eleName"].length; i++) {
			if(formObj.elements["$eleName"][i].checked) {

STR;
				if(!empty($this->ajax)) {
					$str .= <<<STR
				form_data += "&$eleName=" + escape(formObj.elements["$eleName"][i].value);

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
				is_checked = true;

STR;
				}	
				$str .= <<<STR
			}
		}
STR;
				if($isRequired) {
					$str .= <<<STR
		if(!is_checked)
			js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });

STR;
				}
				$str .= <<<STR
	}
	else {

STR;
				if(!empty($this->ajax)) {
					$str .= <<<STR
		if(formObj.elements["$eleName"].checked)
			form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
		if(!formObj.elements["$eleName"].checked)
			js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });

STR;
				}
				$str .= <<<STR
	}

STR;
			}
			elseif($eleType == "radio") {
				$str .= <<<STR
	if(formObj.elements["$eleName"].length) {

STR;
				if($isRequired) {
					$str .= <<<STR
		var is_checked = false;

STR;
				}	
							
				$str .= <<<STR
		for(i = 0; i < formObj.elements["$eleName"].length; i++) {
			if(formObj.elements["$eleName"][i].checked) {

STR;
				if(!empty($this->ajax)) {
					$str .= <<<STR
				form_data += "&$eleName=" + escape(formObj.elements["$eleName"][i].value);

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
				is_checked = true;

STR;
				}	
				$str .= <<<STR
			}
		}		

STR;
				if($isRequired) {
					$str .= <<<STR
		if(!is_checked)
			js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });

STR;
				}
			$str .= <<<STR
	}
	else {

STR;
				if(!empty($this->ajax)) {
					$str .= <<<STR
		if(formObj.elements["$eleName"].checked)
			form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
		if(!formObj.elements["$eleName"].checked)
			js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });

STR;
				}
				$str .= <<<STR
	}

STR;
			}
			elseif($eleType == "text" || $eleType == "textarea" || $eleType == "date" || $eleType == "daterange" || $eleType == "latlng" || $eleType == "color" || $eleType == "email") {
				if(!empty($this->ajax)) {
					$str .= <<<STR
	form_data += "&$eleName=";
	if(formObj.elements["$eleName"].value != "$eleHint")
		form_data += formObj.elements["$eleName"].value;

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
	if(formObj.elements["$eleName"].value == "$eleHint" || formObj.elements["$eleName"].value == "") {
		js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
		if(js_errors_{$this->attributes["id"]}.length == 1)
			formObj.elements["$eleName"].focus();
	}

STR;
				}
			}
			elseif($eleType == "select" || $eleType == "hidden" || $eleType == "file" || $eleType == "password") {
				if(!empty($this->ajax)) {
					$str .= <<<STR
	form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
	if(formObj.elements["$eleName"].value == "") {
		js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
		if(js_errors_{$this->attributes["id"]}.length == 1)
			formObj.elements["$eleName"].focus();
	}

STR;
				}
			}
			elseif($eleType == "rating") {
				if(!empty($this->ajax)) {
					$str .= <<<STR
	if(formObj.elements["$eleName"].value != "")
		form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
	if(formObj.elements["$eleName"].value == "")
		js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });

STR;
				}
			}
			elseif($eleType == "slider") {
				if(!empty($this->ajax)) {
					$str .= <<<STR
	if(formObj.elements["$eleName"].length) {
		form_data += "&$eleName=" + escape(formObj.elements["$eleName"][0].value);
		form_data += "&$eleName=" + escape(formObj.elements["$eleName"][1].value);
	}
	else
		form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
			}
			elseif($eleType == "captcha") {
				if($isRequired) {
					$str .= <<<STR
	if(formObj.elements["recaptcha_response_field"].value == "") {		
		js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
		if(js_errors_{$this->attributes["id"]}.length == 1)
			formObj.elements["recaptcha_response_field"].focus();
	}	

STR;
				}
				if(!empty($this->ajax)) {
					$str .= <<<STR
	form_data += "&recaptcha_challenge_field=" + escape(Recaptcha.get_challenge());		
	form_data += "&recaptcha_response_field=" + escape(Recaptcha.get_response());

STR;
				}	
			}
			elseif($eleType == "webeditor") {
				if(!empty($this->ajax)) {
					$str .= <<<STR
	form_data += "&$eleName=" + escape(tinyMCE.get("$eleId").getContent());

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
	if(tinyMCE.get("$eleId").getContent() == "") {
		js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
		if(js_errors_{$this->attributes["id"]}.length == 1)
			tinyMCE.get("$eleId").focus();
	}

STR;
				}
			}
			elseif($eleType == "ckeditor") {
				if(!empty($this->ajax)) {
					$str .= <<<STR
	form_data += "&$eleName=" + escape(CKEDITOR.instances.$eleId.getData());

STR;
				}	
				if($isRequired) {
					$str .= <<<STR
	if( CKEDITOR.instances.$eleId.getData() == "") {
		js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
		if(js_errors_{$this->attributes["id"]}.length == 1)
			CKEDITOR.instances.$eleId.focus();
	}

STR;
				}
			}
			elseif($eleType == "checksort") {
				if(!empty($this->ajax)) {
					$str .= <<<STR
	if(formObj.elements["$eleName"]) {
		if(formObj.elements["$eleName"].length) {
			var ulObj = document.getElementById("$eleId");
			var childLen = ulObj.childNodes.length;
			for(i = 0; i < childLen; i++) {
				childObj = document.getElementById("$eleId").childNodes[i];
				if(childObj.tagName && childObj.tagName.toLowerCase() == "li")
					form_data += "&$eleName=" + escape(childObj.childNodes[0].value);
			}
		}
		else
			form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);
	}

STR;
				}
				if($isRequired) {
					$str .= <<<STR
	if(!formObj.elements["$eleName"])
		js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });

STR;
				}	
			}
			elseif(!empty($this->ajax) && $eleType == "sort") {
				$str .= <<<STR
	if(formObj.elements["$eleName"]) {
		if(formObj.elements["$eleName"].length) {
			var ulObj = document.getElementById("$eleId");
			var childLen = ulObj.childNodes.length;
			for(i = 0; i < childLen; i++) {
				childObj = document.getElementById("$eleId").childNodes[i];
				if(childObj.tagName && childObj.tagName.toLowerCase() == "li")
					form_data += "&$eleName=" + escape(childObj.childNodes[0].value);
			}
		}
		else
			form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);
	}		

STR;
			}
				
			if(empty($this->preventJSValidation) && $eleType == "email") {
				$errorMsg = str_replace(array("[LABEL]", '"'), array($eleLabel, '&quot;'), $this->emailErrorMsgFormat);
				$str .= <<<STR
	if(formObj.elements["$eleName"].value != "$eleHint") {
		jQuery.ajax({
			async: false,
			type: "post",
			url: "{$this->jsIncludesPath}/php-email-address-validation/ajax-handler.php",
			dataType: "text",
			data: "email=" + escape(formObj.elements["$eleName"].value),
			success: function(responseMsg) {
				if(responseMsg == "valid")
					validemail_{$this->attributes["id"]} = true;
				else {
					validemail_{$this->attributes["id"]} = false;
					js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { {$this->jsErrorFunction}(XMLHttpRequest.responseText); }
		});

		if(!validemail_{$this->attributes["id"]}) {
			if(js_errors_{$this->attributes["id"]}.length == 1)
				formObj.elements["$eleName"].focus();
		}
	}

STR;
			}

			if(empty($this->preventJSValidation) && !empty($ele->integer)) {
				$errorMsg = str_replace(array("[LABEL]", '"'), array($eleLabel, '&quot;'), $this->integerErrorMsgFormat);
				$str .= <<<STR
	if(formObj.elements["$eleName"].value != "$eleHint" && formObj.elements["$eleName"].value != "") {
		if(!formObj.elements["$eleName"].value.match(/^\d+$/)) {
			js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
			if(js_errors_{$this->attributes["id"]}.length == 1)
				formObj.elements["$eleName"].focus();
		}		
	}

STR;
				
			}
			elseif(empty($this->preventJSValidation) && !empty($ele->alphanumeric)) {
				$errorMsg = str_replace(array("[LABEL]", '"'), array($eleLabel, '&quot;'), $this->alphanumericErrorMsgFormat);
				$str .= <<<STR
	if(formObj.elements["$eleName"].value != "$eleHint" && formObj.elements["$eleName"].value != "") {
		if(!formObj.elements["$eleName"].value.match(/^[0-9a-zA-Z]+$/)) {
			js_errors_{$this->attributes["id"]}.push({ errormsg: "$errorMsg", container: "{$ele->container}" });
			if(js_errors_{$this->attributes["id"]}.length == 1)
				formObj.elements["$eleName"].focus();
		}		
	}

STR;
				
			}
		}	

		//Remove hints if they remain as form element values.
		for($i = 0; $i < $elementSize; ++$i) {
			$ele = $elements[$i];
			if(!empty($ele->hint)) {
				$eleName = str_replace('"', '&quot;', $ele->attributes["name"]);
				$eleHint = str_replace('"', '&quot;', $ele->hint);
				$str .= <<<STR
	if(formObj.elements["$eleName"].value == "$eleHint")
		formObj.elements["$eleName"].value = "";

STR;
			}
		}	
		return $str;
	}

	public function openFieldset($legend, $additionalParams="") {
		$this->addElement("", "", "htmlexternal", '<fieldset class="pfbc-fieldset"><legend>' . $legend . "</legend>");
	}

	private function phpCycleElements($elements, $referenceValues, $form) {
		$elementSize = sizeof($elements);
		for($i = 0; $i < $elementSize; ++$i) {
			$ele = $elements[$i];
			if(substr($ele->attributes["name"], -2) == "[]")
				$ele->attributes["name"] = substr($ele->attributes["name"], 0, -2);

			if(!empty($ele->label)) {
				$eleLabel = strip_tags($ele->label);
				if(substr($eleLabel, -1) == ":")
					$eleLabel = substr($eleLabel, 0, -1);
			}	
			else
				$eleLabel = strip_tags($ele->attributes["name"]);
			
			$errorMsg = "";

			//The html, sort, and hidden element types are ignored.
			if($ele->attributes["type"] == "html" || $ele->attributes["type"] == "sort" || $ele->attributes["type"] == "hidden")
				continue;
			elseif($ele->attributes["type"] == "captcha") {
				require_once($form->phpIncludesPath . "/recaptchalib.php");
				$recaptchaResp = recaptcha_check_answer($form->captchaPrivateKey, $_SERVER["REMOTE_ADDR"], $referenceValues["recaptcha_challenge_field"], $referenceValues["recaptcha_response_field"]);
				if(!$recaptchaResp->is_valid) {
					if($recaptchaResp->error == "invalid-site-public-key")
						$errorMsg = "The reCAPTCHA public key could not be verified.";
					elseif($recaptchaResp->error == "invalid-site-private-key")
						$errorMsg = "The reCAPTCHA private key could not be verified.";
					elseif($recaptchaResp->error == "invalid-request-cookie")
						$errorMsg = "The reCAPTCHA challenge parameter of the verify script was incorrect.";
					elseif($recaptchaResp->error == "incorrect-captcha-sol")
						$errorMsg = "The reCATPCHA solution entered was incorrect.";
					elseif($recaptchaResp->error == "verify-params-incorrect")
						$errorMsg = "The reCAPTCHA parameters passed to the verification script were incorrect, make sure you are passing all the required parameters.";
					elseif($recaptchaResp->error == "invalid-referrer")
						$errorMsg = "The reCAPTCHA API public/private keys are tied to a specific domain name for security reasons.";
					else
						$errorMsg = "An unknown reCAPTCHA error has occurred.";
				}
			}
			elseif(!empty($ele->required)) {
				if($ele->attributes["type"] == "checkbox" || $ele->attributes["type"] == "radio" || $ele->attributes["type"] == "checksort" || $ele->attributes["type"] == "rating") {
					if(!isset($referenceValues[$ele->attributes["name"]]))
						$errorMsg = str_replace("[LABEL]", $eleLabel, $form->errorMsgFormat);
				}
				elseif($referenceValues[$ele->attributes["name"]] === $ele->hint || $referenceValues[$ele->attributes["name"]] === "")
					$errorMsg = str_replace("[LABEL]", $eleLabel, $form->errorMsgFormat);
			}

			if(empty($errorMsg) && $ele->attributes["type"] == "email" && $referenceValues[$ele->attributes["name"]] !== $ele->hint && $referenceValues[$ele->attributes["name"]] !== "") {
				require_once($form->phpIncludesPath . "/php-email-address-validation/EmailAddressValidator.php");
				$emailObj = new EmailAddressValidator;
				if(!$emailObj->check_email_address($referenceValues[$ele->attributes["name"]]))
					$errorMsg = str_replace("[LABEL]", $eleLabel, $form->emailErrorMsgFormat);
			}

			if(empty($errorMsg) && !empty($ele->integer) && $referenceValues[$ele->attributes["name"]] !== $ele->hint && $referenceValues[$ele->attributes["name"]] !== "" && !preg_match("/^\d+$/", $referenceValues[$ele->attributes["name"]]))
				$errorMsg = str_replace("[LABEL]", $eleLabel, $form->integerErrorMsgFormat);
			elseif(empty($errorMsg) && !empty($ele->alphanumeric) && $referenceValues[$ele->attributes["name"]] !== $ele->hint && $referenceValues[$ele->attributes["name"]] !== "" && !preg_match("/^[0-9a-zA-Z]+$/", $referenceValues[$ele->attributes["name"]]))
				$errorMsg = str_replace("[LABEL]", $eleLabel, $form->alphanumericErrorMsgFormat);

			if(!empty($errorMsg)) {
				$_SESSION["pfbc-errors"][$form->attributes["id"]]["container"][] = $ele->container;
				$_SESSION["pfbc-errors"][$form->attributes["id"]]["errormsg"][] = $errorMsg;
			}
		}
	}	

	public function render($returnString=false) {
		$this->hasFormTag = 1;
		ob_start();

		echo $this->elementsToString();

		$content = ob_get_contents();
		ob_end_clean();

		if(!$returnString)
			echo($content);
		else
			return $content;
	}

	public function renderAjaxErrorResponse($returnString=false) {
		$str = "";
		if(!empty($_SESSION["pfbc-instances"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-instances"])) {
			//Unserialize the appropriate form instance stored in the session array.
			$form = unserialize($_SESSION["pfbc-instances"][$this->attributes["id"]]);
			if((!isset($form->errorDisplayOption) && !empty($form->map)) || (isset($form->errorDisplayOption) && $form->errorDisplayOption == 1)) {
				$errorMsg = array();
				if(!empty($_SESSION["pfbc-errors"][$this->attributes["id"]])) {
					$errors = $_SESSION["pfbc-errors"][$this->attributes["id"]];
					if(!empty($errors["errormsg"])) {
						$errorSize = sizeof($errors["errormsg"]);
						for($e = 0; $e < $errorSize; ++$e) {
							$error = $errors["errormsg"][$e];
							if(!empty($error)) {
								if(strpos($error, "Error: ") === 0)
									$error = substr($error, 7);
								$errorMsg[] = $error;
							}
						}
					}
				}	
				if(!empty($errorMsg)) {
					$errorSize = sizeof($errorMsg);
					if($errorSize > 1)
						$str .= "The following " . $errorSize . " errors were found:";
					else	
						$str .= "The following error was found:";
					$str .= "<ul><li>" . implode("</li><li>", $errorMsg) . "</li></ul>";
					$str = json_encode(array("container" => array(""), "errormsg" => array($str)));
				}
			}
			else
				$str = json_encode($_SESSION["pfbc-errors"][$this->attributes["id"]]);
		}	
		if(!$returnString) {
			header("Content-type: application/json");
			echo $str;
		}	
		else
			return $str;
	}

	public function renderBody($returnString=false) {
		if(empty($this->generateInlineResources)) {
			$this->setIncludePaths();
			$this->generateInlineResources = 1;
		}
		$str = $this->render(true);

		$str .= "\n" . $this->renderJS(true);

		if(!$returnString)
			echo($str);
		else
			return $str;
	}

	//This function renders the form's css.  This function is invoked within includes/css.php.  The contents returned by this function are then placed in the document's head tag for xhtml strict compliance.
	public function renderCSS($returnString=false) {
		$str = "";
		if(empty($this->generateInlineResources)) {
			if(!empty($_SESSION["pfbc-instances"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-instances"])) {
				//Unserialize the appropriate form instance stored in the session array.
				$form = unserialize($_SESSION["pfbc-instances"][$this->attributes["id"]]);
			}	
		}	
		else
			$form = $this;
		
		if(!empty($form)) {
			if($form->https)
				$prefix = "https";
			else
				$prefix = "http";

			if(empty($form->generateInlineResources)) {
				$str .= str_replace("images/", "$prefix://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/{$form->jqueryUITheme}/images/", file_get_contents("$prefix://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/{$form->jqueryUITheme}/jquery-ui.css"));
				if(!empty($form->jqueryDateRangeIDArr))
					$str .= file_get_contents("{$form->jsIncludesPath}/jquery/ui/ui.daterangepicker.css");
				if(!empty($form->jqueryColorIDArr))
					$str .= str_replace("images/", "{$form->jsIncludesPath}/jquery/plugins/colorpicker/images/", file_get_contents("{$form->jsIncludesPath}/jquery/plugins/colorpicker/colorpicker.css"));
				if(!empty($form->tooltipIDArr))
					$str .= str_replace(array("tip-yellow_arrows.png", "tip-yellow.png"), array("{$form->jsIncludesPath}/jquery/plugins/poshytip/tip-yellow/tip-yellow_arrows.png", "{$form->jsIncludesPath}/jquery/plugins/poshytip/tip-yellow/tip-yellow.png"), file_get_contents("{$form->jsIncludesPath}/jquery/plugins/poshytip/tip-yellow/tip-yellow.css"));
			} else  {
				$str .= "<link href='$prefix://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/{$form->jqueryUITheme}/jquery-ui.css' rel='stylesheet' type='text/css'/>";
				if(!empty($form->jqueryDateRangeIDArr))
					$str .= "<link href='{$form->jsIncludesPath}/jquery/ui/ui.daterangepicker.css' rel='stylesheet' type='text/css'/>";
				if(!empty($form->jqueryColorIDArr))
					$str .= "<link href='{$form->jsIncludesPath}/jquery/plugins/colorpicker/colorpicker.css' rel='stylesheet' type='text/css'/>";
				if(!empty($form->tooltipIDArr))
					$str .= "<link href='{$form->jsIncludesPath}/jquery/plugins/poshytip/tip-yellow/tip-yellow.css' rel='stylesheet' type='text/css'/>";
				$str .= '<style type="text/css">';
			}

			if(empty($form->preventDefaultCSS)) {
				$id = "#" . $this->attributes["id"];
				$str .= <<<STR
$id {
	margin: 0;
	padding: 0;
}
$id .pfbc-clear:after {
	clear: both;
	display: block;
	margin: 0;
	padding: 0;
	visibility: hidden;
	height: 0;
	content: ":)";
}	
$id .pfbc-error {
	padding: 0.5em;
	margin-bottom: 0.5em;
}
$id .pfbc-error ul {
	padding-left: 1.75em;
	margin: 0;
	margin-top: 0.25em;
}
$id .pfbc-buttons {
	text-align: right;
	padding-bottom: 1em;
}
$id .pfbc-required {
	color: #990000; 
}
$id .pfbc-element {
	padding-bottom: 1em;
}
$id .pfbc-nopaddingbottom {
	padding-bottom: 0 !important;
}	

STR;

				if(!empty($form->attributes["width"])) {
					if(substr($form->attributes["width"], -1) == "%") {
						$formWidth = substr($form->attributes["width"], 0, -1);
						$formWidthSuffix = "%";
					}	
					elseif(substr($form->attributes["width"], -2) == "px") {
						$formWidth = substr($form->attributes["width"], 0, -2);
						$formWidthSuffix = "px";
					}
					else {
						$formWidth = $form->attributes["width"];
						$formWidthSuffix = "px";
					}	
					$str .= <<<STR
$id .pfbc-main {
	width: {$formWidth}$formWidthSuffix;
}

STR;
				}
				else
					$formWidthSuffix = "%";
				
				//This section is seperated b/c it is used with and without labelWidths.
				if(!empty($form->map)) {
					$mapVals = array_values(array_unique($form->map));
					$mapValSize = sizeof($mapVals);
					$elementWidthMap = array();
					for($m = 0; $m < $mapValSize; ++$m) {  
						if($formWidthSuffix == "px") {
							$elementWidth = floor((($formWidth - ($form->mapMargin * 2 * ($mapVals[$m] - 1)))  / $mapVals[$m]));
							$elementWidthMap[$mapVals[$m]] = $elementWidth;
						} 
						else
							$elementWidth = floor(((100 - ($form->mapMargin * 2 * ($mapVals[$m] - 1)))  / $mapVals[$m]));

						$str .= <<<STR
$id .pfbc-map-columns-{$mapVals[$m]} {
	float: left; 
	width: {$elementWidth}$formWidthSuffix;
}

STR;
					}	

					$str .= <<<STR
$id .pfbc-map-element-first {
	margin-left: 0 !important;
}
$id .pfbc-map-element-last {
	float: right !important;
	margin-right: 0 !important;
}
$id .pfbc-map-element-single {
	margin: 0 !important;
}
$id .pfbc-element {
	margin: 0 {$form->mapMargin}$formWidthSuffix;
}

STR;
				}

				if(empty($form->labelWidthExists)) {
					$str .= <<<STR
$id .pfbc-label {
	display: block;
	padding-bottom: .25em;
}

STR;
					if(!empty($form->map)) {
						for($m = 0; $m < $mapValSize; ++$m) {  
							if($formWidthSuffix == "px")
								$elementWidth = $elementWidthMap[$mapVals[$m]];
							else
								$elementWidth = floor(((100 - ($form->mapMargin * 2 * ($mapVals[$m] - 1)))  / $mapVals[$m]));

							$str .= <<<STR
$id .pfbc-map-columns-{$mapVals[$m]} .pfbc-textbox {
	width: {$elementWidth}$formWidthSuffix;
}
$id .pfbc-map-columns-{$mapVals[$m]} .pfbc-textarea {
	width: {$elementWidth}$formWidthSuffix;
}
$id .pfbc-map-columns-{$mapVals[$m]} .pfbc-select {
	width: {$elementWidth}$formWidthSuffix;
}

STR;
						}                                

					}
					else {
						if($formWidthSuffix == "px")
							$elementWidth = $formWidth;
						else
							$elementWidth = 98;
						$str .= <<<STR
$id .pfbc-textbox {
	width: {$elementWidth}$formWidthSuffix;
}
$id .pfbc-textarea {
	width: {$elementWidth}$formWidthSuffix;
}
$id .pfbc-select {
	width: {$elementWidth}$formWidthSuffix;
}

STR;
					}
				}

				$elementSize = sizeof($form->elements);
				$id = str_replace("#", "", $id);
				$nonHiddenInternalElementCount = 0;
				if(!empty($form->map)) {
					$mapIndex = 0;
					$mapCount = 0;
				}

				for($e = 0; $e < $elementSize; ++$e) {
					$ele = $form->elements[$e];
					if(!in_array($ele->attributes["type"], array("hidden", "htmlexternal", "button"))) {

						//If the noBreak attribute is set, handle appropriately.
						if(!empty($ele->noBreak)) {
							if($ele->attributes["type"] == "radio") {
								$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-radio {
	float: left;
	margin-left: 0.5em;
}
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-radio-first {
	margin: 0 !important;
}

STR;
							}
							elseif(in_array($ele->attributes["type"], array("checkbox", "checksort"))) {
								$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-checkbox {
	float: left;
	margin-left: 0.5em;
}
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-checkbox-first {
	margin: 0 !important;
}

STR;
							}
						}

						//If the labelWidth attribute is set, handle appropriately.
						if(!empty($form->labelWidthExists)) {
							$labelWidth = "";
							if(!empty($ele->labelWidth))
								$labelWidth = $ele->labelWidth;
							elseif(!empty($form->labelWidth))
								$labelWidth = $form->labelWidth;

							if(!empty($labelWidth)) {
								$labelRightAlign = false;
								if(!empty($ele->labelRightAlign))
									$labelRightAlign = true;
								elseif(!empty($form->labelRightAlign))
									$labelRightAlign = true;
								
								if($labelRightAlign) {
									$labelPaddingRight = $form->labelPaddingRight;
									if(!empty($ele->labelPaddingRight))
										$labelPaddingRight = $ele->labelPaddingRight;
								}	

								if(substr($labelWidth, -1) == "%") {
									$labelWidth = substr($labelWidth, 0, -1);
									$labelWidthSuffix = "%";
								}	
								elseif(substr($labelWidth, -2) == "px") {
									$labelWidth = substr($labelWidth, 0, -2);
									$labelWidthSuffix = "px";
								}	
								else
									$labelWidthSuffix = "px";

								if($labelWidthSuffix == $formWidthSuffix) {
									if(!empty($form->map)) {
										if($formWidthSuffix == "px")
											$elementWidth = $elementWidthMap[$form->map[$mapIndex]] - $labelWidth;
										else
											$elementWidth = 98 - $labelWidth;
									} 
									else {
										if($formWidthSuffix == "px")
											$elementWidth = $formWidth - $labelWidth;
										else
											$elementWidth = 98 - $labelWidth;
									}

									$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-label {
	float: left;

STR;
									if(!empty($labelRightAlign)) {
										$str .= <<<STR
	text-align: right;

STR;
									}

									if(!empty($labelPaddingRight)) {
										if(substr($labelPaddingRight, -1) == "%")
											$labelPaddingRight = substr($labelPaddingRight, 0, -1);
										elseif(substr($labelPaddingRight, -2) == "px")
											$labelPaddingRight = substr($labelPaddingRight, 0, -2);
										$labelWidth -= $labelPaddingRight;
										$str .= <<<STR
	padding-right: {$labelPaddingRight}$labelWidthSuffix;

STR;
									}

									$str .= <<<STR
	width: {$labelWidth}$labelWidthSuffix;
}

STR;
									if(in_array($ele->attributes["type"], array("text", "password", "email", "date", "daterange", "color"))) {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-textbox {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif(in_array($ele->attributes["type"], array("textarea", "webeditor", "ckeditor"))) {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-textarea {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									if(in_array($ele->attributes["type"], array("select", "rating"))) {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-select {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif($ele->attributes["type"] == "radio") {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-radio-buttons {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif($ele->attributes["type"] == "checkbox") {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-checkboxes {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif($ele->attributes["type"] == "checksort") {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-checkboxes {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-sort {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif($ele->attributes["type"] == "sort") {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-sort {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif($ele->attributes["type"] == "latlng") {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-latlng {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-textbox {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif($ele->attributes["type"] == "captcha") {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-captcha {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
									elseif($ele->attributes["type"] == "slider") {
										$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-slider {
	width: {$elementWidth}$labelWidthSuffix;
	float: right;
}

STR;
									}
								}
							}

							if(empty($labelWidth) || $labelWidthSuffix != $formWidthSuffix) {
								$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-label {
	display: block;
}	

STR;
								if(!empty($form->map)) {
									if($formWidthSuffix == "px")
										$elementWidth = $elementWidthMap[$form->map[$mapIndex]];
									else
										$elementWidth = 98;
								} 
								else {
									if($formWidthSuffix == "px")
										$elementWidth = $formWidth;
									else
										$elementWidth = 98;
								}

								$str .= <<<STR
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-textbox {
	width: {$elementWidth}$formWidthSuffix;
}
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-textarea {
	width: {$elementWidth}$formWidthSuffix;
}
#pfbc-$id-element-$nonHiddenInternalElementCount .pfbc-select {
	width: {$elementWidth}$formWidthSuffix;
}

STR;
							}
						}

						if(!empty($form->map)) {
							if(array_key_exists($mapIndex, $form->map) && $form->map[$mapIndex] > 1) {
								if(($mapCount + 1) == $form->map[$mapIndex]) {
									$mapCount = 0;
									++$mapIndex;
								}
								else
									++$mapCount;
							}
							else {
								++$mapIndex;
								$mapCount = 0;
							}	
						}

						++$nonHiddenInternalElementCount;
					}
				}	
			}
                        
			if(!empty($form->jqueryDateIDArr)) {
				$str .= <<<STR
.ui-datepicker-div, .ui-datepicker-inline, #ui-datepicker-div { font-size: 1em !important; }

STR;
			}	

			if(!empty($form->jquerySliderIDArr)) {
				$str .= <<<STR
.ui-slider-handle { cursor: pointer !important; }

STR;
			}	

			if(!empty($form->jqueryStarRatingIDArr)) {
				$str .= <<<STR
.ui-stars-star,
.ui-stars-cancel {
	float: left;
	display: block;
	overflow: hidden;
	text-indent: -999em;
	cursor: pointer;
}
.ui-stars-star a,
.ui-stars-cancel a {
	width: 28px;
	height: 26px;
	display: block;
	position: relative;
	background: transparent url("$form->jsIncludesPath/jquery/plugins/starrating/images/remove_inactive.png") 0 0 no-repeat;
	_background: none;
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader
		(src="$form->jsIncludesPath/jquery/plugins/starrating/images/remove_inactive.png", sizingMethod="scale");
}
.ui-stars-star a {
	background: transparent url("$form->jsIncludesPath/jquery/plugins/starrating/images/star_inactive.png") 0 0 no-repeat;
	_background: none;
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader
		(src="$form->jsIncludesPath/jquery/plugins/starrating/images/star_inactive.png", sizingMethod="scale");
}
.ui-stars-star-on a {
	background: transparent url("$form->jsIncludesPath/jquery/plugins/starrating/images/star_active.png") 0 0 no-repeat;
	_background: none;
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader
		(src="$form->jsIncludesPath/jquery/plugins/starrating/images/star_active.png", sizingMethod="scale");
}
.ui-stars-star-hover a {
	background: transparent url("$form->jsIncludesPath/jquery/plugins/starrating/images/star_hot.png") 0 0 no-repeat;
	_background: none;
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader
		(src="$form->jsIncludesPath/jquery/plugins/starrating/images/star_hot.png", sizingMethod="scale");
}
.ui-stars-cancel-hover a {
	background: transparent url("$form->jsIncludesPath/jquery/plugins/starrating/images/remove_active.png") 0 0 no-repeat;
	_background: none;
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader
		(src="$form->jsIncludesPath/jquery/plugins/starrating/images/remove_active.png", sizingMethod="scale");
}
.ui-stars-star-disabled,
.ui-stars-star-disabled a,
.ui-stars-cancel-disabled a {
	cursor: default !important;
}

STR;
			}
		}

		if(!empty($form->generateInlineResources)) {
			 $str .= "</style>\n";
		}

		if(!$returnString)
			echo($str);
		else
			return $str;
	}

	public function renderHead($returnString=false) {
		if(empty($this->generateInlineResources)) {
			$this->setIncludePaths();
			$this->generateInlineResources = 1;
		}
		$str = $this->renderCSS(true);

		if(!$returnString)
			echo($str);
		else
			return $str;
	}

	//This function renders the form's javascript.  This function is invoked within includes/js.php.  The contents returned by this function are then placed in the document's head tag for xhtml strict compliance.
	public function renderJS($returnString=false) {
		$str = "";
		if(!empty($_SESSION["pfbc-instances"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-instances"])) {
			//Unserialize the appropriate form instance stored in the session array.
			$form = unserialize($_SESSION["pfbc-instances"][$this->attributes["id"]]);

			if($form->https)
				$prefix = "https";
			else
				$prefix = "http";

			if(empty($form->generateInlineResources)) {
				if(!empty($form->tooltipIDArr))
					$str .= file_get_contents("{$form->jsIncludesPath}/jquery/plugins/poshytip/jquery.poshytip.min.js");
				if(!empty($form->jqueryStarRatingIDArr))
					$str .= file_get_contents("{$form->jsIncludesPath}/jquery/plugins/starrating/jquery.ui.stars.js");
				if(!empty($form->jqueryDateRangeIDArr))
					$str .= str_replace(array(), array(), file_get_contents("{$form->jsIncludesPath}/jquery/ui/daterangepicker.jQuery.js"));
				if(!empty($form->jqueryColorIDArr))
					$str .= file_get_contents("{$form->jsIncludesPath}/jquery/plugins/colorpicker/colorpicker.js");
				if(empty($form->preventGoogleMapsLoad) && !empty($form->latlngIDArr))
					$str .= file_get_contents("http://maps.google.com/maps/api/js?callback=myfunction&sensor=false");
				if(empty($form->preventCaptchaLoad) && !empty($form->captchaID))
					$str .= file_get_contents("$prefix://www.google.com/recaptcha/api/js/recaptcha_ajax.js");
			} else {
				if(!empty($form->tooltipIDArr))
					$str .= "<script type='text/javascript' src='{$form->jsIncludesPath}/jquery/plugins/poshytip/jquery.poshytip.min.js'></script>";
				if(!empty($form->jqueryStarRatingIDArr))
					$str .= "\n<script type='text/javascript' src='{$form->jsIncludesPath}/jquery/plugins/starrating/jquery.ui.stars.js'></script>";
				if(!empty($form->jqueryDateRangeIDArr))
					$str .= "\n<script type='text/javascript' src='{$form->jsIncludesPath}/jquery/ui/daterangepicker.jQuery.js'></script>";
				if(!empty($form->jqueryColorIDArr))
					$str .= "\n<script type='text/javascript' src='{$form->jsIncludesPath}/jquery/plugins/colorpicker/colorpicker.js'></script>";
				if(empty($form->preventGoogleMapsLoad) && !empty($form->latlngIDArr))
					$str .= "\n<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>";
				if(empty($form->preventCaptchaLoad) && !empty($form->captchaID))
					$str .= "<script type='text/javascript' src='$prefix://www.google.com/recaptcha/api/js/recaptcha_ajax.js'></script>";
				$str .= "\n" . '<script type="text/javascript">';
				$str .= "//<![CDATA[";
				$str .= "\npfbc_adjust_" . $this->attributes["id"] . "();";
			}


			if(!empty($form->integerExists) || !empty($form->alphanumericExists)) {
			$str .= <<<STR
var pfbc_allowed_keys = [8, 9, 13, 37, 39, 46];			

STR;
			}

			if(!empty($form->integerExists)) {
				$str .= <<<STR
jQuery("#{$this->attributes["id"]} .pfbc-integer").bind("keydown", function(event) {
	if(jQuery.inArray(event.keyCode, pfbc_allowed_keys) != -1
		|| (event.keyCode == 67 && (event.ctrlKey || event.metaKey))
		|| (event.keyCode == 86 && (event.ctrlKey || event.metaKey))
		|| (!event.shiftKey && ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)))
	)
		return true;
	else
		return false;
});

STR;
			}

			if(!empty($form->alphanumericExists)) {
				$str .= <<<STR
jQuery("#{$this->attributes["id"]} .pfbc-alphanumeric").bind("keydown", function(event) {
	if(jQuery.inArray(event.keyCode, pfbc_allowed_keys) != -1
		|| (event.keyCode == 67 && (event.ctrlKey || event.metaKey))
		|| (event.keyCode == 86 && (event.ctrlKey || event.metaKey))
		|| (!event.shiftKey && ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)))
		|| (event.keyCode >= 65 && event.keyCode <= 90)
	)
		return true;
	else
		return false;
});

STR;
			}

			if(!empty($form->jqueryDateIDArr)) {
				$dateKeys = array_keys($form->jqueryDateIDArr);
				$dateSize = sizeof($form->jqueryDateIDArr);
				for($d = 0; $d < $dateSize; ++$d) {
					$date = $form->jqueryDateIDArr[$dateKeys[$d]];

					$jqueryOptionStr = "";
					foreach($date->jqueryOptions as $key => $val) {
						if(!empty($jqueryOptionStr))
							$jqueryOptionStr .= ", ";
						$jqueryOptionStr .= $key . ': ';
						if(is_string($val) && substr($val, 0, 3) == "js:")
							$jqueryOptionStr .= substr($val, 3);
						else
							$jqueryOptionStr .= var_export($val, true);
					}

					$str .= <<<STR
jQuery("#{$dateKeys[$d]}").datepicker({ $jqueryOptionStr });

STR;
				}	
			}

			if(!empty($form->jqueryDateRangeIDArr)) {
				$dateRangeKeys = array_keys($form->jqueryDateRangeIDArr);
				$dateRangeSize = sizeof($form->jqueryDateRangeIDArr);
				for($d = 0; $d < $dateRangeSize; ++$d) {
					$dateRange = $form->jqueryDateRangeIDArr[$dateRangeKeys[$d]];

					$jqueryDateFormat = $dateRange->jqueryOptions["dateFormat"];
					unset($dateRange->jqueryOptions["dateFormat"]);

					$jqueryOptionStr = "";
					foreach($dateRange->jqueryOptions as $key => $val) {
						if(!empty($jqueryOptionStr))
							$jqueryOptionStr .= ", ";
						$jqueryOptionStr .= $key . ': ';
						if(is_string($val) && substr($val, 0, 3) == "js:")
							$jqueryOptionStr .= substr($val, 3);
						else
							$jqueryOptionStr .= var_export($val, true);
					}

					$str .= <<<STR
jQuery("#{$dateRangeKeys[$d]}").daterangepicker({ dateFormat: "$jqueryDateFormat", datepickerOptions: { $jqueryOptionStr } });

STR;
				}	
			}

			if(!empty($form->jquerySortIDArr)) {
				$sortSize = sizeof($form->jquerySortIDArr);
				for($s = 0; $s < $sortSize; ++$s) {
					$str .= <<<STR
jQuery("#{$form->jquerySortIDArr[$s]}").sortable({ axis: "y" });
jQuery("#{$form->jquerySortIDArr[$s]}").disableSelection();

STR;
				}	
			}

			//For more information on poshytip, visit http://vadikom.com/tools/poshy-tip-jquery-plugin-for-stylish-tooltips/.
			if(!empty($form->tooltipIDArr)) {
				$tooltipKeys = array_keys($form->tooltipIDArr);
				$tooltipSize = sizeof($tooltipKeys);
				for($t = 0; $t < $tooltipSize; ++$t) {
					$tooltipEle = $form->tooltipIDArr[$tooltipKeys[$t]];
					$tooltipContent = str_replace('"', '\"', $tooltipEle->tooltip);
					$str .= <<<STR
jQuery("#{$tooltipKeys[$t]}").poshytip({ content: "$tooltipContent", className: "tip-yellow" });

STR;
				}	
			}

			//For more information on the jQuery UI slider, visit http://jqueryui.com/demos/slider/.
			if(!empty($form->jquerySliderIDArr)) {
				$sliderKeys = array_keys($form->jquerySliderIDArr);
				$sliderSize = sizeof($form->jquerySliderIDArr);
				for($s = 0; $s < $sliderSize; ++$s) {
					$slider = $form->jquerySliderIDArr[$sliderKeys[$s]];
					$sliderName = str_replace('"', '&quot;', $slider->attributes["name"]);

					if(is_array($slider->attributes["value"])) {
						$slider->jqueryOptions["range"] = true;
						$slider->jqueryOptions["values"] = "js:[" . $slider->attributes["value"][0] . ", " . $slider->attributes["value"][1] . "]";
					}
					else {
						$slider->jqueryOptions["range"] = "min";
						$slider->jqueryOptions["value"] = $slider->attributes["value"];
					}


					$jqueryOptionStr = "";
					foreach($slider->jqueryOptions as $key => $val) {
						$jqueryOptionStr .= $key . ': ';
						if(is_string($val) && substr($val, 0, 3) == "js:")
							$jqueryOptionStr .= substr($val, 3);
						else
							$jqueryOptionStr .= var_export($val, true);
						$jqueryOptionStr .= ", ";
					}

					$str .= <<<STR
jQuery("#{$sliderKeys[$s]}").slider({ $jqueryOptionStr

STR;
					if(is_array($slider->attributes["value"])) {
						$str .= <<<STR
	slide: function(event, ui) {

STR;
						if(empty($slider->hideDisplay)) {
							$str .= <<<STR
		jQuery("#{$sliderKeys[$s]}_display").text("{$slider->prefix}" + ui.values[0] + "{$slider->suffix} - {$slider->prefix}" + ui.values[1] + "{$slider->suffix}");

STR;
						}	
						$str .= <<<STR
		document.getElementById("{$this->attributes["id"]}").elements["$sliderName"][0].value = ui.values[0]; document.getElementById("{$this->attributes["id"]}").elements["$sliderName"][1].value = ui.values[1];
	}	

STR;
					}	
					else {
						$str .= <<<STR
	slide: function(event, ui) {

STR;
						if(empty($slider->hideDisplay)) {
							$str .= <<<STR
		jQuery("#{$slider->attributes["id"]}_display").text("{$slider->prefix}" + ui.value + "{$slider->suffix}");

STR;
						}	
						$str .= <<<STR
		document.getElementById("{$this->attributes["id"]}").elements["$sliderName"].value = ui.value;
	}

STR;
					}	
					$str .= <<<STR
});

STR;
				}
			}

			//For more information on the jQuery rating plugin, visit http://plugins.jquery.com/project/Star_Rating_widget.
			if(!empty($form->jqueryStarRatingIDArr)) {
				$ratingKeys = array_keys($form->jqueryStarRatingIDArr);
				$ratingSize = sizeof($form->jqueryStarRatingIDArr);
				for($r = 0; $r < $ratingSize; ++$r) {
					$rating = $form->jqueryStarRatingIDArr[$ratingKeys[$r]];

					$jqueryOptionStr = "";
					foreach($rating->jqueryOptions as $key => $val) {
						if(!empty($jqueryOptionStr))
							$jqueryOptionStr .= ", ";
						$jqueryOptionStr .= $key . ': ';
						if(is_string($val) && substr($val, 0, 3) == "js:")
							$jqueryOptionStr .= substr($val, 3);
						else
							$jqueryOptionStr .= var_export($val, true);
					}

					$str .= <<<STR
jQuery("#{$ratingKeys[$r]}").stars({ $jqueryOptionStr });

STR;
				}	
			}

			//For more information on the jQuery colorpicker plugin, visit http://plugins.jquery.com/project/color_picker.
			if(!empty($form->jqueryColorIDArr)) {
				$colorSize = sizeof($form->jqueryColorIDArr);
				for($c = 0; $c < $colorSize; ++$c) {
					$str .= <<<STR
jQuery("#{$form->jqueryColorIDArr[$c]}").ColorPicker({	
	onSubmit: function(hsb, hex, rgb, el) { 
		jQuery(el).val(hex); 
		jQuery(el).ColorPickerHide(); 
	}, 
	onBeforeShow: function() { 
		if(this.value != "Click to Select Color..." && this.value != "") 
			jQuery(this).ColorPickerSetColor(this.value); 
	} 
}).bind("keyup", function(){ 
	jQuery(this).ColorPickerSetColor(this.value); 
});

STR;
				}	
			}

			if(!empty($form->jqueryUIButtonExists)) {
				$str .= <<<STR
jQuery(".jqueryui-button").button();

STR;
			}

			if(!empty($form->latlngIDArr)) {
				if(empty($form->latlngDefaultLocation))
					$form->latlngDefaultLocation = array(41.847, -87.661);

				$latlngSize = sizeof($form->latlngIDArr);
				$latlngKeys = array_keys($form->latlngIDArr);

				for($l = 0; $l < $latlngSize; ++$l) {
					$latlng = $form->latlngIDArr[$latlngKeys[$l]];
					$latlngID = str_replace('"', '&quot;', $latlng->attributes["id"]);
					$str .= <<<STR
var map_$latlngID;
var marker_$latlngID;
var geocoder_$latlngID;

STR;
				}
				$str .= <<<STR
function initializeLatLng_{$this->attributes["id"]}() {

STR;
				for($l = 0; $l < $latlngSize; ++$l) {
					$latlng = $form->latlngIDArr[$latlngKeys[$l]];
					$latlngID = str_replace('"', '&quot;', $latlng->attributes["id"]);
					$latlngName = str_replace('"', '&quot;', $latlng->attributes["name"]);
					if(!empty($latlng->attributes["value"]) && $latlng->attributes["value"] != $latlng->hint) {
						$latlngCenter = $latlng->attributes["value"];
						if(empty($latlng->zoom))
							$latlngZoom = 9;
						else
							$latlngZoom = $latlng->zoom;
					}		
					else {
						$latlngCenter = $form->latlngDefaultLocation;
						if(empty($latlng->zoom))
							$latlngZoom = 5;
						else
							$latlngZoom = $latlng->zoom;
					}	

				$str .= <<<STR
	geocoder_$latlngID = new google.maps.Geocoder();
	var latlng_$latlngID = new google.maps.LatLng({$latlngCenter[0]}, {$latlngCenter[1]});
	var mapoptions_$latlngID = { zoom: $latlngZoom, center: latlng_$latlngID, mapTypeId: google.maps.MapTypeId.ROADMAP, mapTypeControl: false }
	map_$latlngID = new google.maps.Map(document.getElementById("{$latlngID}_canvas"), mapoptions_$latlngID);
	var markeroptions_$latlngID = { position: latlng_$latlngID, map: map_$latlngID, draggable: true }
	marker_$latlngID = new google.maps.Marker(markeroptions_$latlngID);
	google.maps.event.addListener(marker_$latlngID, "dragend", function() {
		var latlng = marker_$latlngID.getPosition();
		var lat = latlng.lat();
		var lng = latlng.lng();
		document.getElementById("$latlngID").value = "Latitude: " + lat.toFixed(3) + ", Longitude: " + lng.toFixed(3);
		document.getElementById("{$latlngID}_clearDiv").style.display = "block";
	});	

STR;
				}

				$str .= <<<STR
}
function jumpToLatLng_{$this->attributes["id"]}(fieldObj, latlngID, fieldName) {
	eval('var geocoderObj = geocoder_' + latlngID);
	eval('var mapObj = map_' + latlngID);
	eval('var markerObj = marker_' + latlngID);
	if(geocoderObj) {
		geocoderObj.geocode({'address': fieldObj.value}, function(results, status) {
			if(status == google.maps.GeocoderStatus.OK) {
				mapObj.setCenter(results[0].geometry.location);
				markerObj.setPosition(results[0].geometry.location);
				var lat = results[0].geometry.location.lat();
				var lng = results[0].geometry.location.lng();
				document.getElementById(latlngID).value = "Latitude: " + lat.toFixed(3) + ", Longitude: " + lng.toFixed(3);
				document.getElementById(latlngID + "_clearDiv").style.display = "block";
			}
		});
	}
}
function focusJumpToLatLng_{$this->attributes["id"]}(fieldObj) {
	if(fieldObj.value == 'Location Jump: Enter Keyword, City/State, Address, or Zip Code')
		fieldObj.value = '';
}
function blurJumpToLatLng_{$this->attributes["id"]}(fieldObj) {
	if(fieldObj.value == '')
		fieldObj.value = 'Location Jump: Enter Keyword, City/State, Address, or Zip Code';
}
function clearLatLng_{$this->attributes["id"]}(latlngID, latlngHint) {
	if(document.getElementById(latlngID + "_locationJump"))
		document.getElementById(latlngID + "_locationJump").value = "Location Jump: Enter Keyword, City/State, Address, or Zip Code";
	document.getElementById(latlngID).value = latlngHint
	document.getElementById(latlngID + "_clearDiv").style.display = "none";
}

STR;
				if(empty($form->preventGoogleMapsLoad)) {
					$str .= <<<STR
setTimeout("initializeLatLng_{$this->attributes["id"]}();", 250);

STR;
				}
			}

			if(!empty($form->jqueryCheckSort)) {
				$str .= <<<STR
function addOrRemoveCheckSortItem_{$this->attributes["id"]}(cs_fieldObj, cs_id, cs_name, cs_index, cs_value, cs_text) {
	if(cs_fieldObj.checked != true)
		document.getElementById(cs_id).removeChild(document.getElementById(cs_id + cs_index));
	else {
		var li = document.createElement('li');
		li.id = cs_id + cs_index;
		li.className = 'ui-state-default';
		li.style.cssText = 'margin: 3px 0; padding-left: 0.5em; font-size: 1em; height: 2.5em; line-height: 2.5em;';
		li.innerHTML = '<input type="hidden" name="' + cs_name + '" value="' + cs_value + '"/>' + cs_text;
		document.getElementById(cs_id).appendChild(li);
	}
}

STR;
			}

			if(!empty($form->tinymceIDArr)) {
				if(empty($form->preventTinyMCEInitLoad)) {
					$str .= <<<STR
tinyMCE.init({
	mode: "textareas",
	theme: "advanced",
	plugins: "safari,table,paste,inlinepopups,preview",
	dialog_type: "modal",
	theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
	theme_advanced_buttons2: "formatselect,fontselect,fontsizeselect,|,pastetext,pasteword,|,link,image",
	theme_advanced_buttons3: "tablecontrols,|,code,preview,|,undo,redo",
	theme_advanced_toolbar_location: "top",
	editor_selector: "tiny_mce",
	forced_root_block: false,
	force_br_newlines: true,
	force_p_newlines: false
});
tinyMCE.init({
	mode: "textareas",
	theme: "simple",
	editor_selector: "tiny_mce_simple",
	forced_root_block: false,
	force_br_newlines: true,
	force_p_newlines: false
});

STR;
				}
			}

			if(!empty($form->ckeditorIDArr)) {
				$ckeditorSize = sizeof($form->ckeditorIDArr);
				$ckeditorKeys = array_keys($form->ckeditorIDArr);

				for($c = 0; $c < $ckeditorSize; ++$c) {
					$ckeditor = $form->ckeditorIDArr[$ckeditorKeys[$c]];
					$ckeditorID = str_replace('"', '&quot;', $ckeditor->attributes["id"]);
					$ckeditorParamArr = array();
					if(!empty($ckeditor->basic))
						$ckeditorParamArr[] = 'toolbar: "Basic"';
					if(!empty($form->ckeditorCustomConfig))	
						$ckeditorParamArr[] = 'customConfig: "' . $form->ckeditorCustomConfig . '"';
					if(!empty($form->ckeditorLang))
						$ckeditorParamArr[] = 'language: "' . $form->ckeditorLang . '"';
					$str .= <<<STR
jQuery("#$ckeditorID").ckeditor( function() {  jQuery("#cke_{$ckeditorID}").outerWidth(jQuery("#cke_{$ckeditorID}").width()); }
STR;
					if(!empty($ckeditorParamArr)) {
						$ckeditorParamStr = implode(", ", $ckeditorParamArr);
						$str .= <<<STR
, { $ckeditorParamStr }
STR;
					}	
					$str .= <<<STR
);

STR;
				}
			}	

			if(!empty($form->captchaID)) {
				$str .= <<<STR
Recaptcha.create("{$form->captchaPublicKey}", "{$form->captchaID}", { theme: "{$form->captchaTheme}", lang: "{$form->captchaLang}" });

STR;
			}

			if(!empty($form->hintExists)) {
				$str .= <<<STR
function hintfocus_{$this->attributes["id"]}(eleObj, hint) {
	if(eleObj.value == hint)
		eleObj.value = '';
}
function hintblur_{$this->attributes["id"]}(eleObj, hint) {
	if(eleObj.value == '')
		eleObj.value = hint;
}

STR;
			}

			$str .= <<<STR
function pfbc_error_{$this->attributes["id"]}(errorMsg, container) {
	var error = '<div class="pfbc-error ui-state-error ui-corner-all">' + errorMsg + '<\/div>';
	if(container != undefined && container != "" && jQuery(container).length)
		jQuery(container).prepend(error);
	else	
		jQuery("#{$this->attributes["id"]} .pfbc-main:first").prepend(error);
}

STR;

			//Apply error message created within the validate function if appropriate.
			if(!empty($_SESSION["pfbc-errors"][$this->attributes["id"]])) {
				$errors = $_SESSION["pfbc-errors"][$this->attributes["id"]];
				if(!empty($errors["container"]) && !empty($errors["errormsg"])) {
					$errorSize = sizeof($errors["container"]);
					if((!isset($form->errorDisplayOption) && !empty($form->map)) || (isset($form->errorDisplayOption) && $form->errorDisplayOption == 1)) {
						$errorMsg = "";
						if($errorSize == 1)
							$errorMsg = "The following error was found:";
						else	
							$errorMsg = "The following " . $errorSize . " errors were found:";
						$errorMsg .= "<ul><li>" . implode("</li><li>", $errors["errormsg"]) . "</li></ul>";	
						$str .= <<<STR
	pfbc_error_{$this->attributes["id"]}("$errorMsg");

STR;
					}
					else {
						for($e = 0; $e < $errorSize; ++$e) {
							if(!empty($errors["container"][$e]) && !empty($errors["errormsg"][$e])) {
								$errorMsg = str_replace('"', '&quot;', $errors["errormsg"][$e]);
								$str .= <<<STR
	pfbc_error_{$this->attributes["id"]}("$errorMsg", "{$errors["container"][$e]}");

STR;
							}
						}
					}
				}
			}

			if(!empty($form->hasFormTag)) {
				/*If there are any required fields in the form or if this form is setup to utilize ajax, build a javascript 
				function for performing form validation before submission and/or for building and submitting a data string through ajax.*/
				if(!empty($form->checkform) || !empty($form->ajax) || !empty($form->captchaExists) || !empty($form->hintExists) || !empty($form->emailExists) || !empty($form->integerExists) || !empty($form->alphanumericExists)) {
					if(empty($form->preventJSValidation) && !empty($form->emailExists)) {
						$str .= <<<STR
var validemail_{$this->attributes["id"]};

STR;
					}	
					$str .= <<<STR
function pfbc_scroll_{$this->attributes["id"]}() {
   jQuery("html, body").animate({ scrollTop: jQuery("#{$this->attributes["id"]}").offset().top }, 500 );
}
function pfbc_onsubmit_{$this->attributes["id"]}(formObj) {
	jQuery("#{$this->attributes["id"]} .pfbc-error").remove();

STR;
					if(empty($form->preventJSValidation)) {
						$str .= <<<STR
        var js_errors_{$this->attributes["id"]} = [];

STR;
					}

					/*If this form is setup for ajax submission, a javascript variable (form_data) is defined and built.  This variable holds each
					key/value pair and acts as the GET or POST string.*/
					if(!empty($form->ajax)) {
						$str .= <<<STR
	var form_data = "";

STR;
					}	

					$str .= $form->jsCycleElements($form->elements);
					if(!empty($form->bindRules)) {
						$bindRuleKeys = array_keys($form->bindRules);
						$bindRuleSize = sizeof($bindRuleKeys);
						for($b = 0; $b < $bindRuleSize; ++$b) {
							if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements)) {
								if(!empty($form->bindRules[$bindRuleKeys[$b]][1])) {
									$str .= <<<STR
	if({$form->bindRules[$bindRuleKeys[$b]][1]}) {
STR;
								}	
								$str .= $form->jsCycleElements($form->bindRules[$bindRuleKeys[$b]][0]->elements);
								if(!empty($form->bindRules[$bindRuleKeys[$b]][1])) {
									$str .= <<<STR
	}

STR;
								}	
							}
						}
					}

					if(empty($form->preventJSValidation)) {
						$str .= <<<STR
	if(js_errors_{$this->attributes["id"]}.length) {
		var js_error_size_{$this->attributes["id"]} = js_errors_{$this->attributes["id"]}.length;

STR;
						if((!isset($form->errorDisplayOption) && !empty($form->map)) || (isset($form->errorDisplayOption) && $form->errorDisplayOption == 1)) {
							$str .= <<<STR
		if(js_error_size_{$this->attributes["id"]} == 1)
			var js_error_message{$this->attributes["id"]} = "The following error was found:";
		else	
			var js_error_message{$this->attributes["id"]} = "The following " + js_error_size_{$this->attributes["id"]} + " errors were found:";
		
		js_error_message{$this->attributes["id"]} += "<ul>";
		for(e = 0; e < js_error_size_{$this->attributes["id"]}; ++e) {
			js_error_message{$this->attributes["id"]} += "<li>" + js_errors_{$this->attributes["id"]}[e].errormsg + "</li>";
		}
		js_error_message{$this->attributes["id"]} += "</ul>";
		pfbc_error_{$this->attributes["id"]}(js_error_message{$this->attributes["id"]});

STR;
						}
						else {
							$str .= <<<STR
		for(e = 0; e < js_error_size_{$this->attributes["id"]}; ++e)
			pfbc_error_{$this->attributes["id"]}(js_errors_{$this->attributes["id"]}[e].errormsg, js_errors_{$this->attributes["id"]}[e].container);

STR;
						}
						$str .= <<<STR
		pfbc_scroll_{$this->attributes["id"]}();
		return false;
						
	}

STR;
					}
						
					if(!empty($form->ajax)) {
						$str .= <<<STR
	form_data = form_data.substring(1, form_data.length);
	jQuery.ajax({
		type: "{$form->attributes["method"]}",
		url: "{$form->attributes["action"]}",

STR;
						$str .= <<<STR
		data: form_data,

STR;
						if(!empty($form->ajaxPreCallback)) {
							$str .= <<<STR
		beforeSend: function() {
			{$form->ajaxPreCallback}();
		},

STR;
						}
						$str .= <<<STR
		success: function(responseMsg) {
			if(responseMsg != undefined && typeof responseMsg == "object" && responseMsg.container) {
				for(e = 0; e < responseMsg.container.length; ++e)
					pfbc_error_{$this->attributes["id"]}(responseMsg.errormsg[e], responseMsg.container[e]);
				pfbc_scroll_{$this->attributes["id"]}();
			}
			else {
STR;
						if(!empty($form->ajaxCallback)) {
							$str .= <<<STR
			{$form->ajaxCallback}(responseMsg);

STR;
						}
						else {
							$str .= <<<STR
			if(responseMsg != undefined && typeof responseMsg == "string") {
				pfbc_error_{$this->attributes["id"]}(responseMsg);
				pfbc_scroll_{$this->attributes["id"]}();
			}	

STR;
						}
						$str .= <<<STR
			}			
		},	
		error: function(XMLHttpRequest, textStatus, errorThrown) { {$form->jsErrorFunction}(XMLHttpRequest.responseText); }
	});
	return false;

STR;
					}	
					else {
						$str .= <<<STR
	return true;					

STR;
					}
					$str .= <<<STR
}

STR;
				}

				$str .= <<<STR
function pfbc_focus_{$form->attributes["id"]}() {
STR;
				//This javascript section sets the focus of the first field in the form.  This default behavior can be overwritten by setting the noAutoFocus parameter.
				if(empty($form->noAutoFocus) && !empty($form->focusElement)) {
					//The webeditor and ckeditor fields are a special case.
					if(!empty($form->tinymceIDArr) && is_array($form->tinymceIDArr) && in_array($form->focusElement, $form->tinymceIDArr)) {
						$str .= <<<STR
	setTimeout("if(tinyMCE.get(\"{$form->focusElement}\")) tinyMCE.get(\"{$form->focusElement}\").focus();", 1000);

STR;
					}	
					elseif(!empty($form->ckeditorIDArr) && is_array($form->ckeditorIDArr) && array_key_exists($form->focusElement, $form->ckeditorIDArr)) {
						$str .= <<<STR
	setTimeout("CKEDITOR.instances.{$form->focusElement}.focus();", 1000);

STR;
					}	
					else {
						//Any fields with multiple options such as radio button, checkboxes, etc. are handled accordingly.
						$str .= <<<STR
	if(document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].type != "select-one" && document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].type != "select-multiple" && document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].length)
		document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"][0].focus();
	else
		document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].focus();

STR;
					}		
				}
				$str .= <<<STR
}				

STR;
			}	
		}	

		if(!empty($form->generateInlineResources)) {
			$str .= "\n" . 'setTimeout("pfbc_focus_' . $this->attributes["id"] . '();", 250);';
			$str .= "//]]>";
			$str .= "</script>\n";
		}

		if(!$returnString)
			echo($str);
		else
			return $str;
	}

	private function setIncludePaths() {
		//If windows normalize backslashes to forward slashes.
		if(PHP_OS == "WINNT")
			$this->includesPath = str_replace( "\\" , "/" , $this->includesPath );

		//Check if includesPath is absolute or not, then create js/php specific variables.
		if($this->includesPath[0] != '/') {
			$this->jsIncludesPath = $this->includesPath;
			$this->phpIncludesPath = $this->includesPath;
		}
		else {
			if(strpos($this->includesPath , $_SERVER['DOCUMENT_ROOT']) === 0) {
				$this->jsIncludesPath = substr($this->includesPath , strlen($_SERVER['DOCUMENT_ROOT']));
				$this->phpIncludesPath = $this->includesPath;
			}
			else {
				$this->jsIncludesPath = $this->includesPath;
				$this->phpIncludesPath = $_SERVER['DOCUMENT_ROOT'] . $this->includesPath;
			}
		}
	}

	//This function is identical to setValues() and is included for backwards compatibility.
	public function setReferenceValues($params) {
		$this->setValues($params);
	}

	public function setValues($params) {
		$this->referenceValues = $params;
	}

	public function validate() {
		$_SESSION["pfbc-errors"][$this->attributes["id"]] = array();
		//Determine if the form's submit method was get or post.
		if(!empty($_POST))
			$referenceValues = $_POST;
		elseif(!empty($_GET))
			$referenceValues = $_GET;
		else {
			$_SESSION["pfbc-errors"][$this->attributes["id"]]["container"][] = "";
			$_SESSION["pfbc-errors"][$this->attributes["id"]]["errormsg"][] = "The get/post array containing the form's submitted values does not exists.";
			return false;
		}

		if(!empty($_SESSION["pfbc-instances"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-instances"])) {
			//Unserialize the appropriate form instance stored in the session array.
			$form = unserialize($_SESSION["pfbc-instances"][$this->attributes["id"]]);

			//Store the form's submitted values in a session array for prefilling if validation fails.
			$this->buildSessionValues($form, $referenceValues);
			if(!empty($form->bindRules)) {
				$bindRuleKeys = array_keys($form->bindRules);
				$bindRuleSize = sizeof($bindRuleKeys);
				for($b = 0; $b < $bindRuleSize; ++$b) {
					if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements)) {
						if(empty($form->bindRules[$bindRuleKeys[$b]][2]) || (eval("if(" . $form->bindRules[$bindRuleKeys[$b]][2] . ") return true; else return false;")))
							$this->buildSessionValues($form->bindRules[$bindRuleKeys[$b]][0], $referenceValues);
					}		
				}	
			}	

			//Cycle through the form's required elements to ensure they are valid.
			$this->phpCycleElements($form->elements, $referenceValues, $form);
			if(!empty($form->bindRules)) {
				$bindRuleKeys = array_keys($form->bindRules);
				$bindRuleSize = sizeof($bindRuleKeys);
				for($b = 0; $b < $bindRuleSize; ++$b) {
					if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements)) {
						if(empty($form->bindRules[$bindRuleKeys[$b]][2]) || (eval("if(" . $form->bindRules[$bindRuleKeys[$b]][2] . ") return true; else return false;")))
							$this->phpCycleElements($form->bindRules[$bindRuleKeys[$b]][0]->elements, $referenceValues, $form);
					}
				}
			}
			if(!empty($_SESSION["pfbc-errors"][$this->attributes["id"]]))
				return false;
			
			//Unset the session array(s) containing the form's errors.
			if(!empty($_SESSION["pfbc-errors"][$this->attributes["id"]]))
				unset($_SESSION["pfbc-errors"][$this->attributes["id"]]);

			//Unset the session array(s) containing the form's submitted values to prevent unwanted prefilling.
			if(!empty($_SESSION["pfbc-values"][$this->attributes["id"]]))
				unset($_SESSION["pfbc-values"][$this->attributes["id"]]);
			if(!empty($form->bindRules)) {
				$bindRuleKeys = array_keys($form->bindRules);
				$bindRuleSize = sizeof($bindRuleKeys);
				for($b = 0; $b < $bindRuleSize; ++$b) {
					if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements)) {
						if(empty($form->bindRules[$bindRuleKeys[$b]][2]) || (eval("if(" . $form->bindRules[$bindRuleKeys[$b]][2] . ") return true; else return false;"))) {
							if(!empty($_SESSION["pfbc-values"][$form->bindRules[$bindRuleKeys[$b]][0]->attributes["id"]]))
								unset($_SESSION["pfbc-values"][$form->bindRules[$bindRuleKeys[$b]][0]->attributes["id"]]);
						}
					}	
				}	
			}	
			return true;
		}
		else {
			$_SESSION["pfbc-errors"][$this->attributes["id"]]["container"][] = "";
			$_SESSION["pfbc-errors"][$this->attributes["id"]]["errormsg"][] = "The session variable containing this form's serialized object instance does not exists.";
			return false;
		}
	}
}

class element extends pfbc {
	public $alphanumeric;
	public $attributes;
	public $basic;
	public $container;
	public $height;
	public $hint;
	public $hideCancel;
	public $hideCaption;
	public $hideDisplay;
	public $hideJump;
	public $integer;
	public $jqueryOptions;
	public $label;
	public $labelPaddingRight;
	public $labelRightAlign;
	public $labelWidth;
	public $max;
	public $min;
	public $months;
	public $noBreak;
	public $options;
	public $orientation;
	public $prefix;
	public $preHTML;
	public $postHTML;
	public $required;
	public $snapIncrement;
	public $suffix;
	public $tooltip;
	public $tooltipID;
	public $width;
	public $zoom;

	public function __construct() {
		$this->attributes = array(
			"type" => "text"
		);
	}
}
class option extends pfbc {
	public $text;
	public $value;
}
class button extends pfbc {
	private $allowedFields; 

	protected $attributes;
	protected $jqueryUI;

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
