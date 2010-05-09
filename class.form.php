<?php
/*
Google Code Project Hosting - http://code.google.com/p/php-form-builder-class/
Google Groups - http://groups.google.com/group/php-form-builder-class/
*/

class base {
	/*This class provides two methods - setAttributes and debug - that can be used for all classes that extend this class 
	which are form, option, element, and button.*/
	function setAttributes($params) {
		if(!empty($params) && is_array($params))
		{
			/*Loop through and get accessible class variables.*/
			$objArr = array();
			foreach($this as $key => $value)
				$objArr[$key] = $value;

			foreach($params as $key => $value)
			{
				if(array_key_exists($key, $objArr))
				{
					if(is_array($this->$key) && !empty($this->$key))
					{
						/*Using array_merge prevents any default values from being overwritten.*/
						if(is_array($value))
							$this->$key = array_merge($this->$key, $value);
					}	
					else
						$this->$key = $value;
				}
				elseif(array_key_exists("attributes", $objArr))
					$this->attributes[$key] = $value;
			}
			unset($objArr);
		}
	}

	/*Used for development/testing.*/
	function debug()
	{
		echo "<pre>";
			print_r($this);
		echo "</pre>";
	}
}

class form extends base { 
	/*Variables that can be set through the setAttributes function on the base class.*/
	protected $attributes;				/*HTML attributes attached to <form> tag.*/
	protected $map;						/*Unrelated to latlng/map field type.  Used to control table structure.*/
	protected $mapMargin;				/*When using the map form attribute, this setting controls the spacing between columns.*/		
	protected $ajax;					/*Activate ajax form submission.*/
	protected $ajaxType;				/*Specify form submission as get/post.*/
	protected $ajaxUrl;					/*Where to send ajax submission.*/
	protected $ajaxPreCallback;			/*Optional function to call before ajax form submission.*/
	protected $ajaxCallback;			/*Optional function to call after successful ajax form submission.*/
	protected $ajaxDataType;			/*Defaults to text.  Options include xml, html, script, json, jsonp, and text.  View details at http://docs.jquery.com/Ajax/jQuery.ajax#options*/
	protected $tooltipIcon;				/*Overrides default tooltip icon.*/
	protected $tooltipBorderColor;		/*Overrides default tooltip border color.*/
	protected $preventJQueryLoad;		/*Prevents jQuery js file from being loaded twice.*/
	protected $preventJQueryUILoad;		/*Prevents jQuery UI js file from being loaded twice.*/
	protected $preventQTipLoad;			/*Prevents qTip js file from being loaded twice.*/
	protected $preventGoogleMapsLoad;	/*Prevents Google Maps js file from being loaded twice.*/
	protected $preventTinyMCELoad;		/*Prevents TinyMCE js file from being loaded twice.*/
	protected $preventTinyMCEInitLoad;	/*Prevents TinyMCE init functions from being loaded twice.*/
	protected $noAutoFocus;				/*Prevents auto-focus feature.*/
	protected $captchaTheme;			/*Allows reCAPTCHA theme to be customized.*/
	protected $captchaLang;				/*Allows reCAPTCHA language to be customized.*/
	protected $captchaPublicKey;		/*Contains reCAPTCHA public key.*/
	protected $captchaPrivateKey;		/*Contains reCAPTCHA private key.*/
	protected $preventCaptchaLoad;		/*Prevents reCAPTCHA js file from being loaded twice.*/
	protected $jqueryDateFormat;		/*Allows date field to be formatted. See http://docs.jquery.com/UI/Datepicker/$.datepicker.formatDate for formatting options.*/
	protected $ckeditorLang;			/*Allows CKEditor language to be customized.*/
	protected $ckeditorCustomConfig;	/*Allows CKEditor settings to be loaded through a supplied js file.*/
	protected $preventCKEditorLoad;		/*Prevents CKEditor js file from being loaded twice.*/
	protected $errorMsgFormat;			/*Allow you to customize was is alerted/returned during js/php validation.*/
	protected $emailErrorMsgFormat;		/*Allow you to customize was is alerted/returned during js/php email validation.*/
	protected $latlngDefaultLocation;	/*Allow you to customize the default location of latlng form elements.*/
	protected $formIDOverride;			/*When using the latlng form element with the elementsToString() function, this attribute will need to be set to the parent form's id.*/
	protected $includesPath;            /*Specifies where the includes directory is located. This path can be relative or absolute.*/
	protected $onsubmitFunction;		/*Allows onsubmit function for handling js error checking and ajax submission to be renamed.*/
	protected $preventDefaultCSS;		/*Prevents default css from being applied.  Allows for custom styling.*/
	protected $jsErrorFunction;			/*Allows js function for handling rendering error error messages to be defined.*/

	/*Variables that can only be set inside this class.*/
	private $elements;					/*Contains all element objects for a form.*/
	private $bindRules;					/*Contains information about nested forms.*/
	private $buttons;					/*Contains all button objects for a form.*/
	private $checkform;					/*If a field has the required attribute set, this field will be set causing javascript error checking.*/
	private $allowedFields;				/*Controls what attributes can be attached to various html elements.*/
	private $stateArr;					/*Associative array holding states.  Prevents generating array each time state form field is used.*/
	private $countryArr;				/*Associative array holding countries.  Prevents generating array each time country form field is used.*/
	private $referenceValues;			/*Associative array of values to pre-fill form fields.*/
	private $captchaExists;				/*If there is a captcha element attached to the form, this flag will be set and force the formhandler js function to be called when the form is submitted.*/
	private $focusElement;				/*Sets focus of first form element.*/
	private $hintExists;				/*If one or more form elements have hints, this flag will be set and force the formhandler js function to be called when the form is submitted.*/
	private $emailExists;				/*If one or more form elements of type email exist, this flag will be set and force the formhandler js function to be called when the form is submitted.*/
	private $jsIncludesPath;            /*For use on client side, holds either absolute path or document root path*/
	private $phpIncludesPath;           /*For use on server side, holds either absolute path or full path */
	private $tinymceIDArr;				/*Uniquely identifies each tinyMCE web editor.*/
	private $ckeditorIDArr;				/*Uniquely identifies each CKEditor web editor.*/
	private $jqueryDateIDArr;			/*Uniquely identifies each date element.*/
	private $jqueryDateRangeIDArr;		/*Uniquely identifies each daterange element.*/
	private $tooltipIDArr;				/*Uniquely identifies each tooltip.*/
	private $jquerySliderIDArr;			/*Uniquely identifies each slider element.*/
	private $jqueryStarRatingIDArr;		/*Uniquely identifies each rating element.*/
	private $jqueryColorIDArr;			/*Uniquely identifies each colorpicker element.*/
	private $latlngIDArr;				/*Uniquely identifies each latlng element.*/
	private $jqueryCheckSort;			/*Indicates there is a checksort field.*/
	private $hasFormTag;				/*Indicates that the form was generated via the render() function as apposed to the elementsToString() function.*/

	/*Variables that can be accessed outside this class directly.*/
	public $errorMsg;					/*Contains human readable error message set in validate() method.*/

	public function __construct($id = "myform") 
	{
		$id = preg_replace("/[^a-zA-Z0-9]/", "_", $id);
		/*Provide default values for class variables.*/
		$this->attributes = array(
			"id" => $id,
			"method" => "post",
			"action" => basename($_SERVER["SCRIPT_NAME"]),
			"style" => "padding: 0; margin: 0;"
		);
		$this->captchaTheme = "white";
		$this->captchaLang = "en";
		$this->captchaPublicKey = "6LcazwoAAAAAADamFkwqj5KN1Gla7l4fpMMbdZfi";
		$this->captchaPrivateKey = "6LcazwoAAAAAAD-auqUl-4txAK3Ky5jc5N3OXN0_";
		$this->jqueryDateFormat = "MM d, yy";
		$this->ajaxType = "post";
		$this->ajaxUrl = basename($_SERVER["SCRIPT_NAME"]);
		$this->ajaxDataType = "text";
		$this->errorMsgFormat = "[LABEL] is a required field.";
		$this->emailErrorMsgFormat = "[LABEL] contains an invalid email address.";
		$this->includesPath = "php-form-builder-class/includes";
		$this->onsubmitFunction = "pfbc_onsubmit_" . $this->attributes["id"];
		$this->jsErrorFunction = "pfbc_error_". $this->attributes["id"];
		$this->mapMargin = 1;

		/*This array prevents junk from being inserted into the form's HTML.  If you find that an attributes you need to use is not included
		in this list, feel free to customize to fit your needs.*/
		$this->allowedFields = array(
			"form" => array("method", "action", "target", "enctype", "onsubmit", "id", "class", "style"),
			"hidden" => array("id", "name", "value", "type"),
			"text" => array("id", "name", "value", "type", "class", "style", "onclick", "onkeyup", "onfocus", "onblur", "maxlength", "size"),
			"textarea" => array("id", "name", "class", "style", "onclick", "onkeyup", "maxlength", "onfocus", "onblur", "size", "rows", "cols"),
			"select" => array("id", "name", "class", "style", "onclick", "onchange", "onfocus", "onblur", "size"),
			"radio" => array("name", "style", "class", "onclick", "type"),
			"checksort" => array("style", "class"),
			"button" => array("name", "value", "type", "id", "onclick", "class", "style"),
			"a" => array("id", "name", "href", "class", "style", "target"),
			"latlng" => array("id", "name", "type", "class", "style", "onclick", "onkeyup", "maxlength", "size")
		);
	}

	/*Creates new element object instances and attaches them to the form object.  This function is private and can only be called inside this class.*/
	private function attachElement($params)
	{
		$ele = new element();
		$ele->setAttributes($params);
		$eleType = &$ele->attributes["type"];

		/*This set of conditions handles form elements requiring the $option class.*/		
		if($eleType == "state")
		{
			/*This section prevents the stateArr from being generated for each form and/or multiple state field types per form.*/
			$eleType = "select";
			if(empty($this->stateArr))
			{
				$this->stateArr = array(
					array("value" => "", "text" => "--Select a State/Province--"),
					array("value" => "AL", "text" => "Alabama"),
					array("value" => "AK", "text" => "Alaska"),
					array("value" => "AZ", "text" => "Arizona"),
					array("value" => "AR", "text" => "Arkansas"),
					array("value" => "CA", "text" => "California"),
					array("value" => "CO", "text" => "Colorado"),
					array("value" => "CT", "text" => "Connecticut"),
					array("value" => "DE", "text" => "Delaware"),
					array("value" => "DC", "text" => "District of Columbia"),
					array("value" => "FL", "text" => "Florida"),
					array("value" => "GA", "text" => "Georgia"),
					array("value" => "HI", "text" => "Hawaii"),
					array("value" => "ID", "text" => "Idaho"),
					array("value" => "IL", "text" => "Illinois"),
					array("value" => "IN", "text" => "Indiana"),
					array("value" => "IA", "text" => "Iowa"),
					array("value" => "KS", "text" => "Kansas"),
					array("value" => "KY", "text" => "Kentucky"),
					array("value" => "LA", "text" => "Louisiana"),
					array("value" => "ME", "text" => "Maine"),
					array("value" => "MD", "text" => "Maryland"),
					array("value" => "MA", "text" => "Massachusetts"),
					array("value" => "MI", "text" => "Michigan"),
					array("value" => "MN", "text" => "Minnesota"),
					array("value" => "MS", "text" => "Mississippi"),
					array("value" => "MO", "text" => "Missouri"),
					array("value" => "MT", "text" => "Montana"),
					array("value" => "NE", "text" => "Nebraska"),
					array("value" => "NV", "text" => "Nevada"),
					array("value" => "NH", "text" => "New Hampshire"),
					array("value" => "NJ", "text" => "New Jersey"),
					array("value" => "NM", "text" => "New Mexico"),
					array("value" => "NY", "text" => "New York"),
					array("value" => "NC", "text" => "North Carolina"),
					array("value" => "ND", "text" => "North Dakota"),
					array("value" => "OH", "text" => "Ohio"),
					array("value" => "OK", "text" => "Oklahoma"),
					array("value" => "OR", "text" => "Oregon"),
					array("value" => "PA", "text" => "Pennsylvania"),
					array("value" => "RI", "text" => "Rhode Island"),
					array("value" => "SC", "text" => "South Carolina"),
					array("value" => "SD", "text" => "South Dakota"),
					array("value" => "TN", "text" => "Tennessee"),
					array("value" => "TX", "text" => "Texas"),
					array("value" => "UT", "text" => "Utah"),
					array("value" => "VT", "text" => "Vermont"),
					array("value" => "VA", "text" => "Virginia"),
					array("value" => "WA", "text" => "Washington"),
					array("value" => "WV", "text" => "West Virginia"),
					array("value" => "WI", "text" => "Wisconsin"),
					array("value" => "WY", "text" => "Wyoming"),
					array("value" => "", "text" => ""),
					array("value" => "", "text" => "-- Canadian Province--"),
					array("value" => "AB", "text" => "Alberta"),
					array("value" => "BC", "text" => "British Columbia"),
					array("value" => "MB", "text" => "Manitoba"),
					array("value" => "NB", "text" => "New Brunswick"),
					array("value" => "NL", "text" => "Newfoundland and Labrador"),
					array("value" => "NS", "text" => "Nova Scotia"),
					array("value" => "NT", "text" => "Northwest Territories"),
					array("value" => "NU", "text" => "Nunavut"),
					array("value" => "ON", "text" => "Ontario"),
					array("value" => "PE", "text" => "Prince Edward Island"),
					array("value" => "QC", "text" => "Qu&#233;bec"),
					array("value" => "SK", "text" => "Saskatchewan"),
					array("value" => "YT", "text" => "Yukon"),
					array("value" => "", "text" => ""),
					array("value" => "", "text" => "-- US Territories--"),
					array("value" => "AS", "text" => "American Samoa"),
					array("value" => "FM", "text" => "Federated States of Micronesia"),
					array("value" => "GU", "text" => "Guam"),
					array("value" => "MH", "text" => "Marshall Islands"),
					array("value" => "PW", "text" => "Palau"),
					array("value" => "PR", "text" => "Puerto Rico"),
					array("value" => "VI", "text" => "Virgin Islands")
				);
			}
			$ele->options = array();
			$stateSize = sizeof($this->stateArr);
			for($s = 0; $s < $stateSize; ++$s)
			{
				$opt = new option();
				$opt->setAttributes($this->stateArr[$s]);
				$ele->options[] = $opt;
			}
		}	
		elseif($eleType == "country")
		{
			/*This section prevents the countryArr from being generated for each form and/or multiple country field types per form.*/
			$eleType = "select";
			if(empty($this->countryArr))
			{
				$this->countryArr = array(
					array("value" => "", "text" => "--Select a Country--"),
					array("value" => "US", "text" => "United States"),
					array("value" => "AF", "text" => "Afghanistan"),
					array("value" => "AL", "text" => "Albania"),
					array("value" => "DZ", "text" => "Algeria"),
					array("value" => "AS", "text" => "American Samoa"),
					array("value" => "AD", "text" => "Andorra"),
					array("value" => "AO", "text" => "Angola"),
					array("value" => "AI", "text" => "Anguilla"),
					array("value" => "AG", "text" => "Antigua and Barbuda"),
					array("value" => "AR", "text" => "Argentina"),
					array("value" => "AM", "text" => "Armenia"),
					array("value" => "AW", "text" => "Aruba"),
					array("value" => "AU", "text" => "Australia"),
					array("value" => "AT", "text" => "Austria"),
					array("value" => "AZ", "text" => "Azerbaijan"),
					array("value" => "BS", "text" => "Bahamas"),
					array("value" => "BH", "text" => "Bahrain"),
					array("value" => "BD", "text" => "Bangladesh"),
					array("value" => "BB", "text" => "Barbados"),
					array("value" => "BY", "text" => "Belarus"),
					array("value" => "BE", "text" => "Belgium"),
					array("value" => "BZ", "text" => "Belize"),
					array("value" => "BJ", "text" => "Benin"),
					array("value" => "BM", "text" => "Bermuda"),
					array("value" => "BT", "text" => "Bhutan"),
					array("value" => "BO", "text" => "Bolivia"),
					array("value" => "BA", "text" => "Bosnia and Herzegowina"),
					array("value" => "BW", "text" => "Botswana"),
					array("value" => "BR", "text" => "Brazil"),
					array("value" => "IO", "text" => "British Indian Ocean Territory"),
					array("value" => "BN", "text" => "Brunei Darussalam"),
					array("value" => "BG", "text" => "Bulgaria"),
					array("value" => "BF", "text" => "Burkina Faso"),
					array("value" => "BI", "text" => "Burundi"),
					array("value" => "KH", "text" => "Cambodia"),
					array("value" => "CM", "text" => "Cameroon"),
					array("value" => "CA", "text" => "Canada"),
					array("value" => "CV", "text" => "Cape Verde"),
					array("value" => "KY", "text" => "Cayman Islands"),
					array("value" => "CF", "text" => "Central African Republic"),
					array("value" => "TD", "text" => "Chad"),
					array("value" => "CL", "text" => "Chile"),
					array("value" => "CN", "text" => "China"),
					array("value" => "CO", "text" => "Colombia"),
					array("value" => "CG", "text" => "Congo"),
					array("value" => "CK", "text" => "Cook Islands"),
					array("value" => "CR", "text" => "Costa Rica"),
					array("value" => "CI", "text" => "Cote d'Ivoire"),
					array("value" => "HR", "text" => "Croatia"),
					array("value" => "CY", "text" => "Cyprus"),
					array("value" => "CZ", "text" => "Czech Republic"),
					array("value" => "DK", "text" => "Denmark"),
					array("value" => "DJ", "text" => "Djibouti"),
					array("value" => "DM", "text" => "Dominica"),
					array("value" => "DO", "text" => "Dominican Republic"),
					array("value" => "EC", "text" => "Ecuador"),
					array("value" => "EG", "text" => "Egypt"),
					array("value" => "SV", "text" => "El Salvador"),
					array("value" => "GQ", "text" => "Equatorial Guinea"),
					array("value" => "ER", "text" => "Eritrea"),
					array("value" => "EE", "text" => "Estonia"),
					array("value" => "ET", "text" => "Ethiopia"),
					array("value" => "FO", "text" => "Faroe Islands"),
					array("value" => "FJ", "text" => "Fiji"),
					array("value" => "FI", "text" => "Finland"),
					array("value" => "FR", "text" => "France"),
					array("value" => "GF", "text" => "French Guiana"),
					array("value" => "PF", "text" => "French Polynesia"),
					array("value" => "GA", "text" => "Gabon"),
					array("value" => "GM", "text" => "Gambia"),
					array("value" => "GE", "text" => "Georgia"),
					array("value" => "DE", "text" => "Germany"),
					array("value" => "GH", "text" => "Ghana"),
					array("value" => "GI", "text" => "Gibraltar"),
					array("value" => "GR", "text" => "Greece"),
					array("value" => "GL", "text" => "Greenland"),
					array("value" => "GD", "text" => "Grenada"),
					array("value" => "GP", "text" => "Guadeloupe"),
					array("value" => "GU", "text" => "Guam"),
					array("value" => "GT", "text" => "Guatemala"),
					array("value" => "GN", "text" => "Guinea"),
					array("value" => "GW", "text" => "Guinea-Bissau"),
					array("value" => "GY", "text" => "Guyana"),
					array("value" => "HT", "text" => "Haiti"),
					array("value" => "HM", "text" => "Heard Island And Mcdonald Islands"),
					array("value" => "HK", "text" => "Hong Kong"),
					array("value" => "HU", "text" => "Hungary"),
					array("value" => "IS", "text" => "Iceland"),
					array("value" => "IN", "text" => "India"),
					array("value" => "ID", "text" => "Indonesia"),
					array("value" => "IR", "text" => "Iran, Islamic Republic Of"),
					array("value" => "IL", "text" => "Israel"),
					array("value" => "IT", "text" => "Italy"),
					array("value" => "JM", "text" => "Jamaica"),
					array("value" => "JP", "text" => "Japan"),
					array("value" => "JO", "text" => "Jordan"),
					array("value" => "KZ", "text" => "Kazakhstan"),
					array("value" => "KE", "text" => "Kenya"),
					array("value" => "KI", "text" => "Kiribati"),
					array("value" => "KP", "text" => "Korea, Democratic People's Republic Of"),
					array("value" => "KW", "text" => "Kuwait"),
					array("value" => "KG", "text" => "Kyrgyzstan"),
					array("value" => "LA", "text" => "Lao People's Democratic Republic"),
					array("value" => "LV", "text" => "Latvia"),
					array("value" => "LB", "text" => "Lebanon"),
					array("value" => "LS", "text" => "Lesotho"),
					array("value" => "LR", "text" => "Liberia"),
					array("value" => "LI", "text" => "Liechtenstein"),
					array("value" => "LT", "text" => "Lithuania"),
					array("value" => "LU", "text" => "Luxembourg"),
					array("value" => "MO", "text" => "Macau"),
					array("value" => "MK", "text" => "Macedonia, The Former Yugoslav Republic Of"),
					array("value" => "MG", "text" => "Madagascar"),
					array("value" => "MW", "text" => "Malawi"),
					array("value" => "MY", "text" => "Malaysia"),
					array("value" => "MV", "text" => "Maldives"),
					array("value" => "ML", "text" => "Mali"),
					array("value" => "MT", "text" => "Malta"),
					array("value" => "MH", "text" => "Marshall Islands"),
					array("value" => "MQ", "text" => "Martinique"),
					array("value" => "MR", "text" => "Mauritania"),
					array("value" => "MU", "text" => "Mauritius"),
					array("value" => "MX", "text" => "Mexico"),
					array("value" => "FM", "text" => "Micronesia, Federated States Of"),
					array("value" => "MD", "text" => "Moldova, Republic Of"),
					array("value" => "MC", "text" => "Monaco"),
					array("value" => "MN", "text" => "Mongolia"),
					array("value" => "MS", "text" => "Montserrat"),
					array("value" => "MA", "text" => "Morocco"),
					array("value" => "MZ", "text" => "Mozambique"),
					array("value" => "NA", "text" => "Namibia"),
					array("value" => "NP", "text" => "Nepal"),
					array("value" => "NL", "text" => "Netherlands"),
					array("value" => "AN", "text" => "Netherlands Antilles"),
					array("value" => "NC", "text" => "New Caledonia"),
					array("value" => "NZ", "text" => "New Zealand"),
					array("value" => "NI", "text" => "Nicaragua"),
					array("value" => "NE", "text" => "Niger"),
					array("value" => "NG", "text" => "Nigeria"),
					array("value" => "NF", "text" => "Norfolk Island"),
					array("value" => "MP", "text" => "Northern Mariana Islands"),
					array("value" => "NO", "text" => "Norway"),
					array("value" => "OM", "text" => "Oman"),
					array("value" => "PK", "text" => "Pakistan"),
					array("value" => "PW", "text" => "Palau"),
					array("value" => "PA", "text" => "Panama"),
					array("value" => "PG", "text" => "Papua New Guinea"),
					array("value" => "PY", "text" => "Paraguay"),
					array("value" => "PE", "text" => "Peru"),
					array("value" => "PH", "text" => "Philippines"),
					array("value" => "PL", "text" => "Poland"),
					array("value" => "PT", "text" => "Portugal"),
					array("value" => "PR", "text" => "Puerto Rico"),
					array("value" => "QA", "text" => "Qatar"),
					array("value" => "RE", "text" => "Reunion"),
					array("value" => "RO", "text" => "Romania"),
					array("value" => "RU", "text" => "Russian Federation"),
					array("value" => "RW", "text" => "Rwanda"),
					array("value" => "KN", "text" => "Saint Kitts and Nevis"),
					array("value" => "LC", "text" => "Saint Lucia"),
					array("value" => "VC", "text" => "Saint Vincent and the Grenadines"),
					array("value" => "WS", "text" => "Samoa"),
					array("value" => "SM", "text" => "San Marino"),
					array("value" => "SA", "text" => "Saudi Arabia"),
					array("value" => "SN", "text" => "Senegal"),
					array("value" => "SC", "text" => "Seychelles"),
					array("value" => "SL", "text" => "Sierra Leone"),
					array("value" => "SG", "text" => "Singapore"),
					array("value" => "SK", "text" => "Slovakia"),
					array("value" => "SI", "text" => "Slovenia"),
					array("value" => "SB", "text" => "Solomon Islands"),
					array("value" => "SO", "text" => "Somalia"),
					array("value" => "ZA", "text" => "South Africa"),
					array("value" => "ES", "text" => "Spain"),
					array("value" => "LK", "text" => "Sri Lanka"),
					array("value" => "SD", "text" => "Sudan"),
					array("value" => "SR", "text" => "Suriname"),
					array("value" => "SZ", "text" => "Swaziland"),
					array("value" => "SE", "text" => "Sweden"),
					array("value" => "CH", "text" => "Switzerland"),
					array("value" => "SY", "text" => "Syrian Arab Republic"),
					array("value" => "TW", "text" => "Taiwan, Province Of China"),
					array("value" => "TJ", "text" => "Tajikistan"),
					array("value" => "TZ", "text" => "Tanzania, United Republic Of"),
					array("value" => "TH", "text" => "Thailand"),
					array("value" => "TG", "text" => "Togo"),
					array("value" => "TO", "text" => "Tonga"),
					array("value" => "TT", "text" => "Trinidad and Tobago"),
					array("value" => "TN", "text" => "Tunisia"),
					array("value" => "TR", "text" => "Turkey"),
					array("value" => "TM", "text" => "Turkmenistan"),
					array("value" => "TC", "text" => "Turks and Caicos Islands"),
					array("value" => "TV", "text" => "Tuvalu"),
					array("value" => "UG", "text" => "Uganda"),
					array("value" => "UA", "text" => "Ukraine"),
					array("value" => "AE", "text" => "United Arab Emirates"),
					array("value" => "GB", "text" => "United Kingdom"),
					array("value" => "UY", "text" => "Uruguay"),
					array("value" => "UZ", "text" => "Uzbekistan"),
					array("value" => "VU", "text" => "Vanuatu"),
					array("value" => "VE", "text" => "Venezuela"),
					array("value" => "VN", "text" => "Vietnam"),
					array("value" => "VG", "text" => "Virgin Islands (British)"),
					array("value" => "VI", "text" => "Virgin Islands (U.S.)"),
					array("value" => "WF", "text" => "Wallis and Futuna Islands"),
					array("value" => "EH", "text" => "Western Sahara"),
					array("value" => "YE", "text" => "Yemen"),
					array("value" => "YU", "text" => "Yugoslavia"),
					array("value" => "ZM", "text" => "Zambia"),
					array("value" => "ZR", "text" => "Zaire"),
					array("value" => "ZW", "text" => "Zimbabwe")
				);
			}
			$ele->options = array();
			$countrySize = sizeof($this->countryArr);
			for($s = 0; $s < $countrySize; ++$s)
			{
				$opt = new option();
				$opt->setAttributes($this->countryArr[$s]);
				$ele->options[] = $opt;
			}
		}
		elseif($eleType == "yesno")
		{
			/*The yesno field is shortcut creating a radio button with two options: yes and no.*/
			$eleType = "radio";
			$ele->options = array();
			$opt = new option();
			$opt->setAttributes(array("value" => "1", "text" => "Yes"));
			$ele->options[] = $opt;
			$opt = new option();
			$opt->setAttributes(array("value" => "0", "text" => "No"));
			$ele->options[] = $opt;
		}
		elseif($eleType == "truefalse")
		{
			/*Similar to yesno, the truefalse field is shortcut creating a radio button with two options: true and false.*/
			$eleType = "radio";
			$ele->options = array();
			$opt = new option();
			$opt->setAttributes(array("value" => "1", "text" => "True"));
			$ele->options[] = $opt;
			$opt = new option();
			$opt->setAttributes(array("value" => "0", "text" => "False"));
			$ele->options[] = $opt;
		}
		elseif(array_key_exists("options", $params) && is_array($params["options"]))
		{
			/*Various form types (select, radio, ect.) use the options parameter to handle multiple choice elements.*/
			if(array_key_exists("options", $params) && is_array($params["options"]))
			{
				$ele->options = array();
				/*If the options array is numeric, assign the key and text to each value.*/
				if(array_values($params["options"]) === $params["options"])
				{
					foreach($params["options"] as $key => $value)
					{
						$opt = new option();
						$opt->setAttributes(array("value" => $value, "text" => $value));
						$ele->options[] = $opt;
					}
				}
				/*If the options array is associative, assign the key and text to each key/value pair.*/
				else
				{
					foreach($params["options"] as $key => $value)
					{
						$opt = new option();
						$opt->setAttributes(array("value" => $key, "text" => $value));
						$ele->options[] = $opt;
					}
				}
			}
		}

		/*This set of conditions sets default information for specific form elements. Setting information here allow the elementsToString() function to be compressed.*/
		if($eleType == "email")
			$this->emailExists = 1;
		elseif($eleType == "file")
			$this->attributes["enctype"] = "multipart/form-data";
		elseif($eleType == "webeditor")
		{
			/*This section ensures that each webeditor field has a unique identifier.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "webeditor_" . rand(0, 999);
			if(empty($this->tinymceIDArr))
				$this->tinymceIDArr = array();
			while(in_array($ele->attributes["id"], $this->tinymceIDArr))
				$ele->attributes["id"] = "webeditor_" . rand(0, 999);
			$this->tinymceIDArr[] = $ele->attributes["id"];
		}
		elseif($eleType == "ckeditor")
		{
			/*This section ensures that each ckeditor field has a unique identifier.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "ckeditor_" . rand(0, 999);
			if(empty($this->ckeditorIDArr))
				$this->ckeditorIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->ckeditorIDArr))
				$ele->attributes["id"] = "ckeditor_" . rand(0, 999);
		}
		elseif($eleType == "date")
		{
			/*This section ensures that each date field has a unique identifier.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "dateinput_" . rand(0, 999);
			if(!isset($this->jqueryDateIDArr))
				$this->jqueryDateIDArr = array();
			while(in_array($ele->attributes["id"], $this->jqueryDateIDArr))
				$ele->attributes["id"] = "dateinput_" . rand(0, 999);
			$this->jqueryDateIDArr[] = $ele->attributes["id"];

			if(empty($ele->hint))
				$ele->hint = "Click to Select Date...";
		}
		elseif($eleType == "daterange")
		{
			/*This section ensure that each daterange field has a unique identifier.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "daterangeinput_" . rand(0, 999);
			if(!isset($this->jqueryDateRangeIDArr))
				$this->jqueryDateRangeIDArr = array();
			while(in_array($ele->attributes["id"], $this->jqueryDateRangeIDArr))
				$ele->attributes["id"] = "daterangeinput_" . rand(0, 999);
			$this->jqueryDateRangeIDArr[] = $ele->attributes["id"];

			if(empty($ele->hint))
				$ele->hint = "Click to Select Date Range...";
		}
		elseif($eleType == "sort")
		{
			/*This section ensures that each sort field has a unique identifier.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "sort_" . rand(0, 999);
			if(!isset($this->jquerySortIDArr))
				$this->jquerySortIDArr = array();
			while(in_array($ele->attributes["id"], $this->jquerySortIDArr))
				$ele->attributes["id"] = "sort_" . rand(0, 999);
			$this->jquerySortIDArr[] = $ele->attributes["id"];
		}
		elseif($eleType == "latlng")
		{
			/*This section ensures that each latlng (Google Map) field has a unique identifier.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "latlnginput_" . rand(0, 999);
			if(!isset($this->latlngIDArr))
				$this->latlngIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->latlngIDArr))
				$ele->attributes["id"] = "latlnginput_" . rand(0, 999);

			if(empty($ele->latlngHeight))
				$ele->latlngHeight = 200;

			if(empty($ele->hint))
				$ele->hint = "Drag Map Marker to Select Location...";
		}
		elseif($eleType == "checksort")
		{
			/*This section ensure that each checksort field has a unique identifier.  You will notice that sort and checksort are stores in the same
			array (this->jquerySortIDArr).  This is done because they both use the same jquery ui sortable functionality.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "checksort_" . rand(0, 999);
			if(!isset($this->jquerySortIDArr))
				$this->jquerySortIDArr = array();
			while(in_array($ele->attributes["id"], $this->jquerySortIDArr))
				$ele->attributes["id"] = "checksort_" . rand(0, 999);
			$this->jquerySortIDArr[] = $ele->attributes["id"];

			/*This variable triggers a javascript section for handling the dynamic adding/removing of sortable option when a user clicks the checkbox.*/
			$this->jqueryCheckSort = 1;
		}
		elseif($eleType == "captcha")
		{
			/*If there is a captcha elements in the form, make sure javascript onsubmit function is enabled.*/
			if(empty($this->captchaExists))
				$this->captchaExists = 1;
			else
				return;

			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "captchainput_" . rand(0, 999);

			$this->captchaID = array();
			$this->captchaID = $ele->attributes["id"];
		}
		elseif($eleType == "slider")
		{
			/*This section ensures that each slider field has a unique identifier.*/
			if(empty($ele->attributes["id"]))
				$ele->attributes["id"] = "sliderinput_" . rand(0, 999);
			if(!isset($this->jquerySliderIDArr))
				$this->jquerySliderIDArr = array();
			while(array_key_exists($ele->attributes["id"], $this->jquerySliderIDArr))
				$ele->attributes["id"] = "sliderinput_" . rand(0, 999);

			if(empty($ele->sliderMin))
				$ele->sliderMin = "0";

			if(empty($ele->sliderMax))
				$ele->sliderMax = "100";

			if(empty($ele->sliderOrientation) || !in_array($ele->sliderOrientation, array("horizontal", "vertical")))
				$ele->sliderOrientation = "horizontal";

			if(empty($ele->sliderPrefix))
				$ele->sliderPrefix = "";

			if(empty($ele->sliderSuffix))
				$ele->sliderSuffix = "";

			if($ele->sliderOrientation == "vertical" && !empty($ele->sliderHeight))
			{
				if(substr($ele->sliderHeight, -2) != "px")
					$ele->sliderHeight .= "px";
			}		

			$this->jquerySliderIDArr[$ele->attributes["id"]] = $ele;
		}
		elseif($eleType == "rating")
		{
			/*This section ensures each rating field has a unique identifier.*/
			$ele->ratingID = "starrating_" . rand(0, 999);
			if(!isset($this->jqueryStarRatingIDArr))
				$this->jqueryStarRatingIDArr = array();
			while(array_key_exists($ele->ratingID, $this->jqueryStarRatingIDArr))
				$ele->ratingID = "starrating_" . rand(0, 999);
		}
		elseif($eleType == "colorpicker")
		{
			/*This section ensures that each colorpicker field has a unique identifier.*/
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

		/*If there is a required field type in the form, make sure javascript error checking is enabled.*/
		if(!empty($ele->required) && empty($this->checkform))
		 	$this->checkform = 1;

		if(!empty($ele->label) && !empty($ele->tooltip))
		{
			/*This section ensures that each tooltip has a unique identifier.*/
			if(!isset($this->tooltipIDArr))
				$this->tooltipIDArr = array(); 
			$ele->tooltipID = "tooltip_" . rand(0, 999);
			while(array_key_exists($ele->tooltipID, $this->tooltipIDArr))
				$ele->tooltipID = "tooltip_" . rand(0, 999);
			$this->tooltipIDArr[$ele->tooltipID] = $ele;
		}

		$this->elements[] = $ele;
	}
	
	/*-------------------------------------------START: HOW USERS CAN ADD FORM FIELDS--------------------------------------------*/

	/*addElement allows users to add a single form element by passing an array.*/
	public function addElement($label, $name, $type="", $value="", $additionalParams="")
	{
		$params = array("label" => $label, "name" => $name);
		if(!empty($type))
			$params["type"] = $type;
		$params["value"] = $value;
			
		/*Commonly used attributes such as name, type, and value exist as parameters in the function.  All other attributes
		that need to be included should be passed in the additionalParams field.  This field should exist as an associative
		array with the key being the attribute's name.  Examples of attributes passed in the additionalParams field include
		style, class, and onkeyup.*/	
		if(!empty($additionalParams) && is_array($additionalParams))
		{
			foreach($additionalParams as $key => $value)
				$params[$key] = $value;
		}
		$this->attachElement($params);
	}

	/*The remaining function are shortcuts for adding each supported form field.*/
	public function addHidden($name, $value="", $additionalParams="") {
		$this->addElement("", $name, "hidden", $value, $additionalParams);
	}
	public function addTextbox($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "text", $value, $additionalParams);
	}
	public function addTextarea($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "textarea", $value, $additionalParams);
	}
	public function addWebEditor($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "webeditor", $value, $additionalParams);
	}
	public function addCKEditor($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "ckeditor", $value, $additionalParams);
	}
	public function addPassword($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "password", $value, $additionalParams);
	}
	public function addFile($label, $name, $additionalParams="") {
		$this->addElement($label, $name, "file", "", $additionalParams);
	}
	public function addDate($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "date", $value, $additionalParams);
	}
	public function addDateRange($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "daterange", $value, $additionalParams);
	}
	public function addState($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "state", $value, $additionalParams);
	}
	public function addCountry($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "country", $value, $additionalParams);
	}
	public function addYesNo($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "yesno", $value, $additionalParams);
	}
	public function addTrueFalse($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "truefalse", $value, $additionalParams);
	}
	/*This function is included for backwards compatability.*/
	public function addSelectbox($label, $name, $value="", $options="", $additionalParams="") {
		$this->addSelect($label, $name, $value, $options, $additionalParams);
	}
	public function addSelect($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "select", $value, $additionalParams);
	}
	public function addRadio($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "radio", $value, $additionalParams);
	}
	public function addCheckbox($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "checkbox", $value, $additionalParams);
	}
	public function addSort($label, $name, $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "sort", "", $additionalParams);
	}
	public function addLatLng($label, $name, $value="", $additionalParams="") {
		$this->addMap($label, $name, $value, $additionalParams);
	}
	/*This function is included for backwards compatability.*/
	public function addMap($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "latlng", $value, $additionalParams);
	}
	public function addCheckSort($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "checksort", $value, $additionalParams);
	}
	public function addCaptcha($label="", $additionalParams="") {
		$this->addElement($label, "recaptcha_response_field", "captcha", "", $additionalParams);
	}	
	public function addSlider($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "slider", $value, $additionalParams);
	}
	public function addRating($label, $name, $value="", $options="", $additionalParams="") {
		if(!is_array($additionalParams))
			$additionalParams = array();
		$additionalParams["options"] = $options;	
		$this->addElement($label, $name, "rating", $value, $additionalParams);
	}
	public function addHTML($value) {
		$this->addElement("", "", "html", $value);
	}
	public function addColorPicker($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "colorpicker", $value, $additionalParams);
	}
	public function addEmail($label, $name, $value="", $additionalParams="") {
		$this->addElement($label, $name, "email", $value, $additionalParams);
	}

	/*-------------------------------------------END: HOW USERS CAN ADD FORM FIELDS--------------------------------------------*/

	/*This function can be called to clear all attached element object instances from the form - beneficial when using the elementsToString function.*/
	public function clearElements() {
		$this->elements = array();
	}

	/*This function can be called to clear all attached button object instances from the form.*/
	public function clearButtons() {
		$this->buttons = array();
	}

	/*This function creates new button object instances and attaches them to the form.  It is private and can only be used inside this class.*/
	private function attachButton($params)
	{
		$button = new button();
		$button->setAttributes($params);
		$this->buttons[] = $button;
	}

	/*This function allows users to add multiple button object instances to the form by passing a multi-dimensional array.*/
	public function addButtons($params)
	{
		$paramSize = sizeof($params);
		for($i = 0; $i < $paramSize; ++$i)
			$this->attachButton($params[$i]);
	}

	/*This function allows users to add a single button object instance to the form by passing an array.*/
	public function addButton($value="Submit", $type="submit", $additionalParams="")
	{
		$params = array("value" => $value, "type" => $type);

		/*The additionalParams performs a similar role as in the addElement function.  For more information, please read to description
		of this field in the addElement function.  Commonly used attributes included for additionalParams in this function include
		onclick.*/
		if(!empty($additionalParams) && is_array($additionalParams))
		{
			foreach($additionalParams as $key => $value)
				$params[$key] = $value;
		}
		$this->attachButton($params);
	}

	/*This function renders the form's HTML.*/
	public function render($returnString=false)
	{
		$this->hasFormTag = 1;
		ob_start();

		/*Render the form tag with all appropriate attributes.*/
		echo "\n<form";
		if(!empty($this->attributes) && is_array($this->attributes))
		{
			/*This syntax will be used throughout the render() and elementsToString() functions ensuring that attributes added to various HTML tags
			are allowed and valid.  If you find that an attribute is not being included in your HTML tag definition, please reference $this->allowedFields.
			This variable can be modified to fit your specific needs.*/
			$tmpAllowFieldArr = $this->allowedFields["form"];
			foreach($this->attributes as $key => $value)
			{
				/*If an onsubmit function is defined and the form is setup for javascript error checking (checkform) or ajax submission (ajax), the user
				defined onsubmit function will be overwritten and discarded.*/
				if($key == "onsubmit" && (!empty($this->checkform) || !empty($this->ajax) || !empty($this->captchaExists) || !empty($this->hintExists) || !empty($this->emailExists)))
					continue;
				if(in_array($key, $tmpAllowFieldArr))
					echo ' ', $key, '="', str_replace('"', '&quot;', $value), '"';
			}	
		}
			
		if(!empty($this->checkform) || !empty($this->ajax) || !empty($this->captchaExists) || !empty($this->hintExists) || !empty($this->emailExists))	
			echo ' onsubmit="return ', $this->onsubmitFunction, '(this);"';
		echo ">";

		/*This section renders all the hidden form fields outside the <table> tag.*/
		$hiddenElementExists = false;
		$elementSize = sizeof($this->elements);
		for($i = 0; $i < $elementSize; ++$i)
		{
			$ele = $this->elements[$i];
			if($ele->attributes["type"] == "hidden")
			{
				/*If the referenceValues array is filled, check for this specific element's name in the associative array key and populate the field's value if applicable.*/
				if(!empty($this->referenceValues) && is_array($this->referenceValues))
				{
					if(array_key_exists($ele->attributes["name"], $this->referenceValues))
						$ele->attributes["value"] = $this->referenceValues[$ele->attributes["name"]];
					elseif(substr($ele->attributes["name"], -2) == "[]" && array_key_exists(substr($ele->attributes["name"], 0, -2), $this->referenceValues))
						$ele->attributes["value"] = $this->referenceValues[substr($ele->attributes["name"], 0, -2)];
				}	

				if(!$hiddenElementExists)
				{
					echo "\n" . '<div class="pfbc-hidden">';
					$hiddenElementExists = true;
				}	

				echo "\n\t<input";
				if(!empty($ele->attributes) && is_array($ele->attributes))
				{
					$tmpAllowFieldArr = $this->allowedFields["hidden"];
					foreach($ele->attributes as $key => $value)
					{
						if(in_array($key, $tmpAllowFieldArr))
							echo ' ', $key, '="', str_replace('"', '&quot;', $value), '"';
					}		
				}
				echo "/>";
			}
		}	

		if($hiddenElementExists)
			echo "\n</div>";

		/*The form fields are rendered in a basic table structure.*/
		echo "\n" . '<div class="pfbc-main">';

		echo "\n\t" . '<div id="pfbc-error-' . $this->attributes["id"] . '"></div>';

		/*Render the elements by calling elementsToString function with the includeMainDiv tags field set to false.  There is no need
		to eender the table tag b/c we have just done that above.*/
		echo $this->elementsToString(false);

		/*If there are buttons included, render those to the screen now.*/
		if(!empty($this->buttons))
		{
			echo "\n\t", '<div class="pfbc-buttons">';
			$buttonSize = sizeof($this->buttons);
			for($i = 0; $i < $buttonSize; ++$i)
			{
				/*The wraplink parameter will simply wrap an anchor tag (<a>) around the button treating it as a link.*/
				if(!empty($this->buttons[$i]->wrapLink))
				{
					echo "\n\t\t<a";
					if(!empty($this->buttons[$i]->linkAttributes) && is_array($this->buttons[$i]->linkAttributes))
					{
						$tmpAllowFieldArr = $this->allowedFields["a"];
						foreach($this->buttons[$i]->linkAttributes as $key => $value)
						{
							if(in_array($key, $tmpAllowFieldArr))
								echo ' ', $key, '="', str_replace('"', '&quot;', $value), '"';
						}		
					}
					echo ">";
				}
				else
					echo "\n\t\t";


				/*The phpFunction parameter was included to give the developer the flexibility to use any custom button generation function 
				they might currently use in their development environment.*/
				if(!empty($this->buttons[$i]->phpFunction))
				{
					$execStr = $this->buttons[$i]->phpFunction . "(";
					if(!empty($this->buttons[$i]->phpParams))
					{
						if(is_array($this->buttons[$i]->phpParams))
						{
							$paramSize = sizeof($this->buttons[$i]->phpParams);
							for($p = 0; $p < $paramSize; ++$p)
							{
								if($p != 0)
									$execStr .= ",";

								if(is_string($this->buttons[$i]->phpParams[$p]))	
									$execStr .= '"' . $this->buttons[$i]->phpParams[$p] . '"';
								else	
									$execStr .= $this->buttons[$i]->phpParams[$p];	
							}
						}
						else
							$execStr .= $this->buttons[$i]->phpParams;
					}
					$execStr .= ");";
					echo eval("return " . $execStr);
				}
				else
				{
					echo "<input";
					if(!empty($this->buttons[$i]->attributes) && is_array($this->buttons[$i]->attributes))
					{
						$tmpAllowFieldArr = $this->allowedFields["button"];
						foreach($this->buttons[$i]->attributes as $key => $value)
						{
							if(in_array($key, $tmpAllowFieldArr))
								echo ' ', $key, '="', str_replace('"', '&quot;', $value), '"';
						}		
					}
					echo "/>";
				}

				if(!empty($this->buttons[$i]->wrapLink))
					echo "</a>";
			}
			echo "\n\t</div>";
		}
		echo "\n</div>";

		echo "\n</form>\n\n";


		$content = ob_get_contents();
		ob_end_clean();

		if(!$returnString)
			echo($content);
		else
			return $content;
	}

	/*This function builds and returns a string containing the HTML for the form fields.  Typeically, this will be called from within the render() function; however, it can also be called by the user during unique situations.*/
	public function elementsToString($includeMainDiv = true)
	{
		$str = "";

		if(empty($this->referenceValues) && !empty($_SESSION["pfbc-values"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-values"]))
			$this->setReferenceValues($_SESSION["pfbc-values"][$this->attributes["id"]]);

		//If windows normalize backslashes to forward slashes
		if( PHP_OS == 'WINNT' )
			$this->includesPath = str_replace( "\\" , "/" , $this->includesPath );

		//check if includesPath is absolute or not, then create variables for where you need to use it
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

		if(empty($this->phpIncludesPath) || !is_dir($this->phpIncludesPath))
			$str .= "\n\t" . '<script type="text/javascript">' . $this->jsErrorFunction . '("php-form-builder-class Configuration Error: Invalid includes Directory Path\n\nUse the includesPath form attribute to identify the location of the inclues directory included within the php-form-builder-class folder.\n\nPath specified:\n' . $this->includesPath . '\n\nEXTRA INFORMATION:\nPHP Path Used:\n' . $this->phpIncludesPath . '\n\nJavascript Path Used:\n' . $this->jsIncludesPath . '");</script>';

		if(empty($this->tooltipIcon))
			$this->tooltipIcon = $this->jsIncludesPath . "/jquery/plugins/qtip/tooltip-icon.gif";

		if(empty($this->noAutoFocus))
			$focus = true;
		else
			$focus = false;

		if($includeMainDiv)
		{
			$str .= "\n" . '<div id="' . $this->attributes["id"] . '">';
			$str .= "\n" . '<div id="pfbc-error-' . $this->attributes["id"] . '"></div>';
			$str .= "\n" . '<div class="pfbc-main">';
		}	

		if(!empty($this->map))
		{
			$mapIndex = 0;
			$mapCount = 0;
		}	

		$elementSize = sizeof($this->elements);
		for($i = 0; $i < $elementSize; ++$i)
		{
			$ele = &$this->elements[$i];
			$map_element_first = false;
			$map_element_last = false;

			/*If the referenceValues array is filled, check for this specific element's name in the associative array key and populate the field's value if applicable.*/
			if(!empty($this->referenceValues) && is_array($this->referenceValues))
			{
				if(array_key_exists($ele->attributes["name"], $this->referenceValues))
					$ele->attributes["value"] = $this->referenceValues[$ele->attributes["name"]];
				elseif(substr($ele->attributes["name"], -2) == "[]" && array_key_exists(substr($ele->attributes["name"], 0, -2), $this->referenceValues))
					$ele->attributes["value"] = $this->referenceValues[substr($ele->attributes["name"], 0, -2)];
			}	

			/*Hidden values do not need to be inside any table cell container; therefore, they are handled differently than the other fields.*/
			if($ele->attributes["type"] == "hidden")
			{
				if($includeMainDiv)
				{
					$str .= "\n<input";
					if(!empty($ele->attributes) && is_array($ele->attributes))
					{
						$tmpAllowFieldArr = $this->allowedFields["hidden"];
						foreach($ele->attributes as $key => $value)
						{
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}		
					}
					$str .= "/>";
				}
			}
			else
			{
				if(!empty($this->map))
				{
					if(array_key_exists($mapIndex, $this->map) && $this->map[$mapIndex] > 1)
					{
						if($mapCount == 0)
						{
							$map_element_first = true;
							$str .= "\n\t" . '<div class="pfbc-map pfbc-clear">';
						}	
					}
					else
					{
						$map_element_first = true;
						$str .= "\n\t" . '<div class="pfbc-map pfbc-clear">';
					}	

					if(($i + 1) == $elementSize)
						$map_element_last = true;
					elseif(array_key_exists($mapIndex, $this->map) && $this->map[$mapIndex] > 1)
					{
						if(($mapCount + 1) == $this->map[$mapIndex])
							$map_element_last = true;
					}
					else
						$map_element_last = true;
				}

				$str .= "\n\t";
				if(!empty($this->map))
					$str .= "\t";
				$str .= '<div class="pfbc-element';
				if($map_element_first && $map_element_last)
					$str .= ' pfbc-map-element-single';
				elseif($map_element_first)
					$str .= ' pfbc-map-element-first';
				elseif($map_element_last)
					$str .= ' pfbc-map-element-last';
				if(!empty($this->map))
					$str .= ' pfbc-map-columns-' . $this->map[$mapIndex];
				$str .= '">';

				/*preHTML and postHTML allow for any special case scenarios.  One specific situation where these may be used would
				be if you need to toggle the visibility of an item or items based on the state of another field such as a radio button.*/
				if(!empty($ele->preHTML))
					$str .= $this->indent() . $ele->preHTML;

				if(!empty($ele->label))
				{
					$str .= $this->indent();
					$str .= '<label class="pfbc-label">';

					/*If this field is set as required, render an "*" inside a <span> tag.*/
					if(!empty($ele->required))
						$str .= '<span class="pfbc-required">*</span> ';
					$str .= $ele->label;

					/*jQuery Tooltip Functionality*/
					if(!empty($ele->tooltip))
						$str .= ' <img id="' . $ele->tooltipID . '" src="' . $this->tooltipIcon . '" alt=""/>';

					$str .= "</label>";
				}	

				/*Check the element's type and render the field accordinly.*/
				$eleType = &$ele->attributes["type"];
				
				/*Add appropriate javascript event functions if hint is present.*/
				if(in_array($eleType, array("text", "textarea", "date", "daterange", "colorpicker", "latlng", "email")) && !empty($ele->hint) && empty($ele->attributes["value"]))
				{
					$ele->attributes["value"] = $ele->hint;
					$hintFocusFunction = "hintfocus_" . $this->attributes["id"] . "(this);";
					if(empty($ele->attributes["onfocus"]))
						$ele->attributes["onfocus"] = $hintFocusFunction;
					else
						$ele->attributes["onfocus"] .= " " . $hintFocusFunction;

					$hintBlurFunction = "hintblur_" . $this->attributes["id"] . "(this);";
					if(empty($ele->attributes["onblur"]))
						$ele->attributes["onblur"] = $hintBlurFunction;
					else
						$ele->attributes["onblur"] .= " " . $hintBlurFunction;
					$this->hintExists = 1;	
				}
				elseif(!empty($ele->hint))
					unset($ele->hint);

				$str .= $this->indent();
				if(in_array($eleType, array("text", "password", "email", "date", "daterange", "colorpicker")))
				{
					/*Temporarily set the type attribute to "text" for <input> tag.*/
					if(in_array($eleType, array("email", "date", "daterange", "colorpicker")))
					{
						$resetTypeTo = $eleType;
						$eleType = "text";
					}	

					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-textbox";
					else	
						$ele->attributes["class"] = "pfbc-textbox";
						
					$str .= "<input";
					if(!empty($ele->attributes) && is_array($ele->attributes))
					{
						$tmpAllowFieldArr = $this->allowedFields["text"];
						foreach($ele->attributes as $key => $value)
						{
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}		
					}
					if(!empty($ele->disabled))
						$str .= ' disabled="disabled"';
					if(!empty($ele->readonly))
						$str .= ' readonly="readonly"';
					$str .= "/>";
					if($focus)
						$this->focusElement = $ele->attributes["name"];
					
					/*Now that <input> tag his been rendered, change type attribute back appropriately.*/
					if(isset($resetTypeTo))
					{
						$eleType = $resetTypeTo;
						unset($resetTypeTo);
					}
				}
				elseif($eleType == "file")
				{
					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-file";
					else	
						$ele->attributes["class"] = "pfbc-file";

					$str .= "<input";
					if(!empty($ele->attributes) && is_array($ele->attributes))
					{
						$tmpAllowFieldArr = $this->allowedFields["text"];
						foreach($ele->attributes as $key => $value)
						{
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}		
					}
					if(!empty($ele->disabled))
						$str .= ' disabled="disabled"';
					if(!empty($ele->readonly))
						$str .= ' readonly="readonly"';
					$str .= "/>";
					if($focus)
						$this->focusElement = $ele->attributes["name"];
				}
                elseif(in_array($eleType, array("textarea", "webeditor", "ckeditor")))
                {
                    if(empty($ele->attributes["rows"]))
                        $ele->attributes["rows"] = "6";
                    if(empty($ele->attributes["cols"]))
                        $ele->attributes["cols"] = "30";

                    if(!empty($ele->attributes["class"]))
                        $ele->attributes["class"] .= " pfbc-textarea";
                    else
                        $ele->attributes["class"] = "pfbc-textarea";

                    if($eleType == "webeditor")
                    {
                        if(!empty($ele->webeditorSimple))
                            $ele->attributes["class"] .= " tiny_mce_simple";
                        else
                            $ele->attributes["class"] .= " tiny_mce";
                    }

                    $str .= "<textarea";
                    if(!empty($ele->attributes) && is_array($ele->attributes))
                    {
                        $tmpAllowFieldArr = $this->allowedFields["textarea"];
                        foreach($ele->attributes as $key => $value)
                        {
                            if(in_array($key, $tmpAllowFieldArr))
                                $str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
                        }
                    }
                    if(!empty($ele->disabled))
                        $str .= ' disabled="disabled"';
                    if(!empty($ele->readonly))
                        $str .= ' readonly="readonly"';
                    $str .= ">" . $ele->attributes["value"] . "</textarea>";
                    if($focus)
                        $this->focusElement = $ele->attributes["name"];

					if($eleType == "ckeditor")
						$this->ckeditorIDArr[$ele->attributes["id"]] = $ele; 
                }
                elseif($eleType == "select" || $eleType == "rating")
                {
                    if(!empty($ele->attributes["class"]))
                        $ele->attributes["class"] .= " pfbc-select";
                    else
                        $ele->attributes["class"] = "pfbc-select";

                    if($eleType == "rating")
                        $str .= '<table cellpadding="0" cellspacing="0" border="0"><tr><td valign="middle"><div id="' . $ele->ratingID . '">';

                    $str .= "<select";
                    if(!empty($ele->attributes) && is_array($ele->attributes))
                    {
                        $tmpAllowFieldArr = $this->allowedFields["select"];
                        foreach($ele->attributes as $key => $value)
                        {
                            if(in_array($key, $tmpAllowFieldArr))
                                $str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
                        }
                    }
                    if(!empty($ele->disabled))
                        $str .= ' disabled="disabled"';
                    if(!empty($ele->readonly))
                        $str .= ' readonly="readonly"';
                    if(!empty($ele->multiple))
                        $str .= ' multiple="multiple"';
                    $str .= ">";

                    $selected = false;
                    if(is_array($ele->options))
                    {
                        $optionSize = sizeof($ele->options);
                        for($o = 0; $o < $optionSize; ++$o)
                        {
                            $str .= $this->indent("\t");
                            $str .= '<option value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"';
                            if((!is_array($ele->attributes["value"]) && !$selected && $ele->attributes["value"] == $ele->options[$o]->value) || (is_array($ele->attributes["value"]) && in_array($ele->options[$o]->value, $ele->attributes["value"], true)))
                            {
                                $str .= ' selected="selected"';
                                $selected = true;
                            }
                            $str .= '>' . $ele->options[$o]->text . "</option>";
                        }
                    }

                    $str .= $this->indent();
                    $str .= "</select>";

                    if($eleType == "rating")
                    {
                        $str .= $this->indent();
                        $str .= '</div></td>';

                        if(empty($ele->ratingHideCaption))
                            $str .= '<td valign="middle"><div id="' . $ele->ratingID . '_caption" style="padding-left: 5px;"></div></td>';

                        $str .= '</tr></table>';
						$this->jqueryStarRatingIDArr[$ele->ratingID] = $ele;
                    }

                    if($focus)
                        $this->focusElement = $ele->attributes["name"];
                }
				elseif($eleType == "radio")
				{
					if(is_array($ele->options))
					{
						$optionSize = sizeof($ele->options);
						for($o = 0; $o < $optionSize; ++$o)
						{
							if($o != 0)
								$str .= $this->indent();

							$str .= '<div class="pfbc-radio';
							if($o == 0)
								$str .= ' pfbc-radio-first';
							elseif($o + 1 == $optionSize)	
								$str .= ' pfbc-radio-last';
							$str .= '"><input';
							$tmpAllowFieldArr = $this->allowedFields["radio"];
							if(!empty($ele->attributes) && is_array($ele->attributes))
							{
								foreach($ele->attributes as $key => $value)
								{
									if(in_array($key, $tmpAllowFieldArr))
										$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
								}		
							}
							$str .= ' id="' . str_replace('"', '&quot;', $ele->attributes["name"]) . $o . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"';		
							if($ele->attributes["value"] == $ele->options[$o]->value)
								$str .= ' checked="checked"';
							if(!empty($ele->disabled))
								$str .= ' disabled="disabled"';
							$str .= '/>';
							$str .= '<label for="' . str_replace('"', '&quot;', $ele->attributes["name"]) . $o . '" style="cursor: pointer;">' . $ele->options[$o]->text . "</label></div>";
						}	

						if(!empty($ele->clear))
							$str .= '<div style="clear: both;"></div>';

						if($focus)
							$this->focusElement = $ele->attributes["name"];
					}
				}
				elseif($eleType == "checkbox")
				{
					if(is_array($ele->options))
					{
						$optionSize = sizeof($ele->options);

						if($optionSize > 1 && substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";

						for($o = 0; $o < $optionSize; ++$o)
						{
							if($o != 0)
								$str .= $this->indent();

							$str .= '<div class="pfbc-checkbox';
							if($o == 0)
								$str .= ' pfbc-checkbox-first';
							elseif($o + 1 == $optionSize)	
								$str .= ' pfbc-checkbox-last';
							$str .= '"><input';
							if(!empty($ele->attributes) && is_array($ele->attributes))
							{
								$tmpAllowFieldArr = $this->allowedFields["radio"];
								foreach($ele->attributes as $key => $value)
								{
									if(in_array($key, $tmpAllowFieldArr))
										$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
								}		
							}
							$tmpID = str_replace(array('"', '[]'), array('&quot;', '-'), $ele->attributes["name"]) . $o;
							$str .= ' id="' . $tmpID . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"';		

							/*For checkboxes, the value parameter can be an array - which allows for multiple boxes to be checked by default.*/
							if((!is_array($ele->attributes["value"]) && $ele->attributes["value"] == $ele->options[$o]->value) || (is_array($ele->attributes["value"]) && in_array($ele->options[$o]->value, $ele->attributes["value"], true)))
								$str .= ' checked="checked"';
							if(!empty($ele->disabled))
								$str .= ' disabled="disabled"';
							$str .= '/>';
							$str .= '<label for="' . $tmpID . '" style="cursor: pointer;">' . $ele->options[$o]->text . '</label></div>';
						}	

						if(!empty($ele->clear))
							$str .= '<div style="clear: both;"></div>';

						if($focus)
							$this->focusElement = $ele->attributes["name"];
					}
				}
				elseif($eleType == "sort")
				{
					if(is_array($ele->options))
					{
						if(substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";

						if(!empty($ele->attributes["value"]))
						{
                            $options = array();
                            $optionSize = sizeof($ele->options);
                            for($o = 0; $o < $optionSize; ++$o)
                                $options[$ele->options[$o]->value] = $ele->options[$o]->text;

							foreach($options as $key => $value)
							{
								$index = array_search($key, $ele->attributes["value"]);
								if($index !== false)
								{
									$opt = new option();
									$opt->setAttributes(array("value" => $key, "text" => $value));
									$ele->options[$index] = $opt;
								}	
							}
						}

						$str .= '<ul id="' . str_replace('"', '&quot;', $ele->attributes["id"]) . '" style="list-style-type: none; margin: 0; padding: 0; cursor: pointer;">';
						$optionSize = sizeof($ele->options);
						for($o = 0; $o < $optionSize; ++$o)
						{
							$str .= $this->indent("\t");
							$str .= '<li class="ui-state-default" style="margin: 3px 0; padding-left: 0.5em; font-size: 1em; height: 2em; line-height: 2em;"><input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"/>' . $ele->options[$o]->text . '</li>';
						}	
						$str .= $this->indent();
						$str .= "</ul>";
					}
				}
				elseif($eleType == "latlng")
				{
					if(!empty($ele->attributes["class"]))
						$ele->attributes["class"] .= " pfbc-textbox";
					else	
						$ele->attributes["class"] = "pfbc-textbox";
					
					if(empty($ele->attributes["style"]))
						$ele->attributes["style"] = "";

					/*If the value is formatted "Latitude: 123.45, Longitude: -67.89" parse and convert to array.*/
					if(!empty($ele->attributes["value"]) && !is_array($ele->attributes["value"]) && strpos($ele->attributes["value"], "Latitude:", 0) === 0)
						$ele->attributes["value"] = array(substr($ele->attributes["value"], strpos($ele->attributes["value"], ":") + 2, strpos($ele->attributes["value"], ",") - strpos($ele->attributes["value"], ":") - 2), substr($ele->attributes["value"], strrpos($ele->attributes["value"], ":") + 1));

					$latlngID = htmlentities($ele->attributes["id"], ENT_QUOTES);

					/*Temporarily set the type attribute to "text" for <input> tag.*/
					$eleType = "text";

					$str .= "<input";
					if(!empty($ele->attributes) && is_array($ele->attributes))
					{
						$tmpAllowFieldArr = $this->allowedFields["latlng"];
						foreach($ele->attributes as $key => $value)
						{
							if(in_array($key, $tmpAllowFieldArr))
								$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
						}	
					}
					$str .= ' value="';
					if(!empty($ele->hint))
						$str .= $ele->hint;
					elseif(!empty($ele->attributes["value"]) && is_array($ele->attributes["value"]))	
						$str .=  "Latitude: " . $ele->attributes["value"][0] . ", Longitude: " . $ele->attributes["value"][1];
					$str .= '"';

					$str .= ' readonly="readonly"';
					$str .= "/>";

					/*Now that <input> tag his been rendered, change type attribute back to "latlng".*/
					$eleType = "latlng";

					$str .= $this->indent();
					$str .= '<div id="' . $latlngID . '_canvas" style="margin: 2px 0; height: ' . $ele->latlngHeight . 'px;';
					if(!empty($ele->latlngWidth))
						$str .= ' width: ' . $ele->latlngWidth . 'px;';
					$str .= '"></div>';
					if(empty($ele->latlngHideJump))
					{
						$str .= $this->indent();
						$str .= '<input id="' . $latlngID . '_locationJump" type="text" value="Location Jump: Enter Keyword, City/State, Address, or Zip Code" class="' . str_replace('"', '&quot;', $ele->attributes["class"]) . '" style="' . str_replace('"', '&quot;', $ele->attributes["style"]) . '" onfocus="focusJumpToLatLng_' . $this->attributes["id"] . '(this);" onblur="blurJumpToLatLng_' . $this->attributes["id"] . '(this);" onkeyup="jumpToLatLng_' . $this->attributes["id"] . '(this, \'' . $latlngID . '\', \'' . htmlentities($ele->attributes["name"]) . '\');"/>';
					}
					$str .= $this->indent();
					$str .= '<div id="' . $latlngID . '_clearDiv" style="';
					if(empty($ele->attributes["value"]) || !is_array($ele->attributes["value"]))
						$str .= 'display: none;';
					$str .= '"><a href="javascript: clearLatLng_' . $this->attributes["id"] . '(\'' . $latlngID . '\', \'' . htmlentities($ele->attributes["name"], ENT_QUOTES) . '\');" class="pfbc-link">Clear Latitude/Longitude</a></div>';	

					$this->latlngIDArr[$ele->attributes["id"]] = $ele;
				}
				elseif($eleType == "checksort")
				{
					if(is_array($ele->options))
					{
						if(substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";

						/*This variable triggers a javascript section for handling the dynamic adding/removing of sortable option when a user clicks the checkbox.*/
						$this->jqueryCheckSort = 1;

						/*Temporary variable for building <ul> sorting structure for checked options.*/
						$sortLIArr = array();

						$optionSize = sizeof($ele->options);
						for($o = 0; $o < $optionSize; ++$o)
						{
							if($o != 0)
								$str .= $this->indent();

							$str .= '<div class="pfbc-checkbox';
							if($o == 0)
								$str .= ' pfbc-checkbox-first';
							elseif($o + 1 == $optionSize)	
								$str .= ' pfbc-checkbox-last';
							$str .= '"><input';
							if(!empty($ele->attributes) && is_array($ele->attributes))
							{
								$tmpAllowFieldArr = $this->allowedFields["checksort"];
								foreach($ele->attributes as $key => $value)
								{
									if(in_array($key, $tmpAllowFieldArr))
										$str .= ' ' . $key . '="' . str_replace('"', '&quot;', $value) . '"';
								}		
							}

							$tmpID = str_replace(array('"', '[]'), array('&quot;', '-'), $ele->attributes["name"]) . $o;
							$str .= ' id="' . $tmpID . '" type="checkbox" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '" onclick="addOrRemoveCheckSortItem_' . $this->attributes["id"] . '(this, \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->attributes["id"]) . '\', \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->attributes["name"]) . '\', ' . $o . ', \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->options[$o]->value) . '\', \'' . str_replace(array('"', "'"), array('&quot;', "\'"), $ele->options[$o]->text) . '\');"';

							/*For checkboxes, the value parameter can be an array - which allows for multiple boxes to be checked by default.*/
							if((!is_array($ele->attributes["value"]) && $ele->attributes["value"] == $ele->options[$o]->value) || (is_array($ele->attributes["value"]) && in_array($ele->options[$o]->value, $ele->attributes["value"], true)))
							{
								$str .= ' checked="checked"';
								$sortLIArr[$ele->options[$o]->value] = '<li id="' . str_replace('"', '&quot;', $ele->attributes["id"]) . $o . '" class="ui-state-default" style="margin: 3px 0; padding-left: 0.5em; font-size: 1em; height: 2em; line-height: 2em;"><input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->options[$o]->value) . '"/></span>' . $ele->options[$o]->text . '</li>' . "\n";
							}	
							if(!empty($ele->disabled))
								$str .= ' disabled="disabled"';
							$str .= '/>';
							$str .= '<label for="' . $tmpID . '" style="cursor: pointer;">' . $ele->options[$o]->text . '</label></div>';
						}	

						if(!empty($ele->clear))
							$str .= '<div style="clear: both;"></div>';

						/*If there are any check options by default, render the <ul> sorting structure.*/
						$str .= $this->indent();
						$str .= '<ul id="' . str_replace('"', '&quot;', $ele->attributes["id"]) . '" style="list-style-type: none; margin: 0; padding: 0; cursor: pointer;">';
						if(!empty($sortLIArr))
						{
							if(is_array($ele->attributes["value"]))
							{
								$eleValueSize = sizeof($ele->attributes["value"]);
								for($li = 0; $li < $eleValueSize; ++$li)
								{
									if(isset($sortLIArr[$ele->attributes["value"][$li]]))
									{
										$str .= $this->indent("\t");
										$str .= $sortLIArr[$ele->attributes["value"][$li]];	
									}
								}
							}
							else
							{
								if(isset($sortLIArr[$ele->attributes["value"][$li]]))
								{
									$str .= $this->indent("\t");
									$str .= $sortLIArr[$ele->attributes["value"]];
								}
							}		
						}
						$str .= $this->indent("\t");
						$str .= "<li style='display: none'>&nbsp;</li>" . $this->indent() . "</ul>";
					}
				}
				elseif($eleType == "captcha")
					$str .= '<div id="' . $ele->attributes["id"] . '"></div>';
				elseif($eleType == "slider")
				{
					if(empty($ele->attributes["value"]))
						$ele->attributes["value"] = "0";
					if(is_array($ele->attributes["value"]) && sizeof($ele->attributes["value"]) == 1)
						$ele->attributes["value"] = $ele->attributes["value"][0];
					
					$str .= '<div id="' . $ele->attributes["id"] . '" style="font-size: 12px !important; margin: 2px 0;';
					if($ele->sliderOrientation == "vertical" && !empty($ele->sliderHeight))
						$str .= ' height: ' . $ele->sliderHeight;
					$str .= '"></div>';

					if(empty($ele->sliderHideDisplay))
					{
						$str .= $this->indent();
						$str .= '<div id="' . $ele->attributes["id"] . '_display">';
						if(is_array($ele->attributes["value"]))
						{
							sort($ele->attributes["value"]);
							$str .= $ele->sliderPrefix . $ele->attributes["value"][0] . $ele->sliderSuffix . " - " . $ele->sliderPrefix . $ele->attributes["value"][1] . $ele->sliderSuffix;
						}	
						else
							$str .= $ele->sliderPrefix . $ele->attributes["value"] . $ele->sliderSuffix;
						$str .= '</div>';
					}

					$str .= $this->indent();
					if(is_array($ele->attributes["value"]))
					{
						if(substr($ele->attributes["name"], -2) != "[]")
							$ele->attributes["name"] .= "[]";
						$str .= '<input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->attributes["value"][0]) . '"/>';
						$str .= $this->indent();
						$str .= '<input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->attributes["value"][1]) . '"/>';
					}
					else
						$str .= '<input type="hidden" name="' . str_replace('"', '&quot;', $ele->attributes["name"]) . '" value="' . str_replace('"', '&quot;', $ele->attributes["value"]) . '"/>';

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

				if(!empty($this->map))
				{
					if(($i + 1) == $elementSize)
						$str .= "\n\t</div>";
					elseif(array_key_exists($mapIndex, $this->map) && $this->map[$mapIndex] > 1)
					{
						if(($mapCount + 1) == $this->map[$mapIndex])
						{
							$mapCount = 0;
							++$mapIndex;
							$str .= "\n\t</div>";
						}
						else
							++$mapCount;
					}
					else
					{
						++$mapIndex;
						$mapCount = 0;
						$str .= "\n\t</div>";
					}	
				}
				$focus = false;
			}	
		}

		if($includeMainDiv)
		{
			$str .= "\n</div>";
			$str .= "\n</div>";
		}	

		$str .= <<<STR
	
	<div class="pfbc-script">
		<script type="text/javascript">
			var head = document.getElementsByTagName("head")[0];

			var css = document.createElement('link');
			css.rel = 'stylesheet';
			css.type = 'text/css';
			css.href = '{$this->jsIncludesPath}/jquery/ui/jquery-ui.css';
			head.appendChild(css);
		</script>

STR;
			if(empty($this->preventJQueryLoad))
			{
				$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/jquery/jquery.js"></script>

STR;
			}	

		if(!empty($this->jqueryDateIDArr) || !empty($this->jqueryDateRangeIDArr) || !empty($this->jquerySortIDArr) || !empty($this->tooltipIDArr) || !empty($this->jquerySliderIDArr) || !empty($this->jqueryStarRatingIDArr) || !empty($this->jqueryColorIDArr))
		{
			if(!empty($this->jqueryDateIDArr) || !empty($this->jqueryDateRangeIDArr) || !empty($this->jquerySortIDArr) || !empty($this->jquerySliderIDArr) || !empty($this->jqueryStarRatingIDArr))
			{
				if(empty($this->preventJQueryUILoad))
				{
					$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/jquery/ui/jquery-ui.js"></script>

STR;
				}	
			}

			if(!empty($this->tooltipIDArr) && empty($this->preventQTipLoad))
			{
				$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/jquery/plugins/qtip/jquery.qtip.js"></script>

STR;
			}	

			if(!empty($this->jqueryStarRatingIDArr))
			{
				$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/jquery/plugins/starrating/jquery.ui.stars.js"></script>
STR;
			}

			if(!empty($this->jqueryDateRangeIDArr))
			{
				$str .= <<<STR
		<script type="text/javascript">
			var css = document.createElement('link');
			css.rel = 'stylesheet';
			css.type = 'text/css';
			css.href = '{$this->jsIncludesPath}/jquery/ui/ui.daterangepicker.css';
			head.appendChild(css);
		</script>
		<script type="text/javascript" src="{$this->jsIncludesPath}/jquery/ui/daterangepicker.jQuery.js"></script>

STR;
			}	

			if(!empty($this->jqueryColorIDArr))
			{
				$str .= <<<STR
		<script type="text/javascript">
			var css = document.createElement('link');
			css.rel = 'stylesheet';
			css.type = 'text/css';
			css.href = '{$this->jsIncludesPath}/jquery/plugins/colorpicker/colorpicker.css';
			head.appendChild(css);
		</script>
		<script type="text/javascript" src="{$this->jsIncludesPath}/jquery/plugins/colorpicker/colorpicker.js"></script>

STR;
			}

		}	

		if(!empty($this->latlngIDArr))
		{
			if(!empty($this->formIDOverride))
				$latlngForm = $this->formIDOverride;
			else
				$latlngForm = $this->attributes["id"];

			if(empty($this->preventGoogleMapsLoad))
			{
				$str .= <<<STR
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

STR;
			}	
		}

		if(!empty($this->tinymceIDArr))
		{
			if(empty($this->preventTinyMCELoad))
			{
				$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/tiny_mce/tiny_mce.js"></script>

STR;
			}	

		}

		if(!empty($this->ckeditorIDArr))
		{
			if(empty($this->preventCKEditorLoad))
			{
				$str .= <<<STR
		<script type="text/javascript" src="{$this->jsIncludesPath}/ckeditor/ckeditor.js"></script>

STR;
			}	
		}	

		if(!empty($this->captchaID))
		{
			if(empty($this->preventCaptchaLoad))
			{
				$str .= <<<STR
		<script type="text/javascript" src="http://api.recaptcha.net/js/recaptcha_ajax.js"></script>

STR;
			}	
		}

		/*Serialize the form and store it in a session array.  This variable will be unserialized and used within the validate() method.*/
		$_SESSION["pfbc-instances"][$this->attributes["id"]] = serialize($this);

		$session_param = "";
		$session_name = session_name();
		if($session_name != "PHPSESSID")
			$session_param = "&session_name=$session_name";

		$str .= <<<STR
		<script type="text/javascript">
			var css = document.createElement('link');
			css.rel = 'stylesheet';
			css.type = 'text/css';
			css.href = '{$this->jsIncludesPath}/css.php?id={$this->attributes["id"]}$session_param';
			head.appendChild(css);

			var script = document.createElement('script');
			script.type = 'text/javascript';
			script.src = '{$this->jsIncludesPath}/js.php?id={$this->attributes["id"]}$session_param';
			head.appendChild(script);
		</script>
	</div>	

STR;

		return $str;
	}

	/*This function handles javascript validation of all required form elements as well as ajax submission.  It was moved from within the render function to it's own function to be reused by nested forms.*/
	private function jsCycleElements($elements)
	{
		$str = "";
		$elementSize = sizeof($elements);
		for($i = 0; $i < $elementSize; ++$i)
		{
			$ele = $elements[$i];
			$eleType = $ele->attributes["type"];
			$eleName = str_replace('"', '&quot;', $ele->attributes["name"]);
			if(!empty($ele->attributes["id"]))
				$eleId = str_replace('"', '&quot;', $ele->attributes["id"]);
			if(!empty($ele->label))
			{
				$eleLabel = str_replace('"', '&quot;', strip_tags($ele->label));
				if(substr($eleLabel, -1) == ":")
					$eleLabel = substr($eleLabel, 0, -1);
			}	
			else
				$eleLabel = str_replace('"', '&quot;', strip_tags($ele->attributes["name"]));
			$alertMsg = $this->jsErrorFunction . '("' . str_replace(array("[LABEL]", '"'), array($eleLabel, '&quot;'), $this->errorMsgFormat) . '");';

			if($eleType == "html")
				continue;

			if($eleType == "checkbox")
			{
				$str .= <<<STR
		if(formObj.elements["$eleName"].length) {

STR;
					if(!empty($ele->required))
					{
						$str .= <<<STR
			var is_checked = false;

STR;
					}	
					$str .= <<<STR
			for(i = 0; i < formObj.elements["$eleName"].length; i++) {
				if(formObj.elements["$eleName"][i].checked) {

STR;
						if(!empty($this->ajax))
						{
							$str .= <<<STR
					form_data += "&$eleName=" + escape(formObj.elements["$eleName"][i].value);

STR;
						}	
						if(!empty($ele->required))
						{
							$str .= <<<STR
					is_checked = true;

STR;
						}	
						$str .= <<<STR
				}
			}
STR;
					if(!empty($ele->required))
					{
						$str .= <<<STR
			if(!is_checked) {
				$alertMsg
				return false;
			}

STR;
					}
				$str .= <<<STR
		}
		else {

STR;
				if(!empty($this->ajax))
				{
					$str .= <<<STR
			if(formObj.elements["$eleName"].checked)
				form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if(!empty($ele->required))
				{
					$str .= <<<STR
			if(!formObj.elements["$eleName"].checked) {
				$alertMsg
				return false;
			}

STR;
				}
				$str .= <<<STR
		}

STR;
			}
			elseif($eleType == "radio")
			{
				$str .= <<<STR
		if(formObj.elements["$eleName"].length) {

STR;
					if(!empty($ele->required))
					{
						$str .= <<<STR
			var is_checked = false;

STR;
					}	
						
					$str .= <<<STR
			for(i = 0; i < formObj.elements["$eleName"].length; i++) {
				if(formObj.elements["$eleName"][i].checked) {

STR;
						if(!empty($this->ajax))
						{
							$str .= <<<STR
					form_data += "&$eleName=" + escape(formObj.elements["$eleName"][i].value);

STR;
						}	
						if(!empty($ele->required))
						{
							$str .= <<<STR
					is_checked = true;

STR;
						}	
					$str .= <<<STR
				}
			}		

STR;
					if(!empty($ele->required))
					{
						$str .= <<<STR
			if(!is_checked) {
				$alertMsg
				return false;
			}

STR;
					}
				$str .= <<<STR
		}
		else {

STR;
				if(!empty($this->ajax))
				{
					$str .= <<<STR
			if(formObj.elements["$eleName"].checked)
				form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if(!empty($ele->required))
				{
					$str .= <<<STR
			if(!formObj.elements["$eleName"].checked) {
				$alertMsg
				return false;
			}

STR;
				}

				$str .= <<<STR
		}

STR;
			}
			elseif($eleType == "text" || $eleType == "textarea" || $eleType == "date" || $eleType == "daterange" || $eleType == "latlng" || $eleType == "colorpicker" || $eleType == "email")
			{
				$eleHint = str_replace('"', '&quot;', $ele->hint);
				if(!empty($this->ajax))
				{
					$str .= <<<STR
		form_data += "&$eleName=";
		if(formObj.elements["$eleName"].value != "$eleHint")
			form_data += formObj.elements["$eleName"].value;

STR;
				}	
				if(!empty($ele->required))
				{
					$str .= <<<STR
		if(formObj.elements["$eleName"].value == "$eleHint") {
			$alertMsg
			formObj.elements["$eleName"].focus();
			return false;
		}

STR;
				}
			}
			elseif($eleType == "select" || $eleType == "hidden" || $eleType == "file" || $eleType == "password")
			{
				if(!empty($this->ajax))
				{
					$str .= <<<STR
		form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if(!empty($ele->required))
				{
					$str .= <<<STR
		if(formObj.elements["$eleName"].value == "") {
			$alertMsg
			formObj.elements["$eleName"].focus();
			return false;
		}

STR;
				}
			}
			elseif($eleType == "rating")
			{
				if(!empty($this->ajax))
				{
					$str .= <<<STR
		if(formObj.elements["$eleName"].value != "")
			form_data += "&$eleName=" + escape(formObj.elements["$eleName"].value);

STR;
				}	
				if(!empty($ele->required))
				{
					$str .= <<<STR
		if(formObj.elements["$eleName"].value == "") {
			$alertMsg
			formObj.elements["$eleName"].focus();
			return false;
		}

STR;
				}
			}
			elseif($eleType == "slider")
			{
				if(!empty($this->ajax))
				{
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
			elseif($eleType == "captcha")
			{
				if(!empty($ele->required))
				{
					$str .= <<<STR
		if(formObj.elements["recaptcha_response_field"].value == "") {		
			$alertMsg
			formObj.elements["recaptcha_response_field"].focus();
			return false;
		}	

STR;
				}
				if(!empty($this->ajax))
				{
					$str .= <<<STR
		form_data += "&recaptcha_challenge_field=" + escape(Recaptcha.get_challenge());		
		form_data += "&recaptcha_response_field=" + escape(Recaptcha.get_response());

STR;
				}	
			}
			elseif($eleType == "webeditor")
			{
				if(!empty($this->ajax))
				{
					$str .= <<<STR
		form_data += "&$eleName=" + escape(tinyMCE.get("$eleId").getContent());

STR;
				}	
				if(!empty($ele->required))
				{
					$str .= <<<STR
		if(tinyMCE.get("$eleId").getContent() == "") {
			$alertMsg
			tinyMCE.get("$eleId").focus();
			return false;
		}

STR;
				}
			}
			elseif($eleType == "ckeditor")
			{
				if(!empty($this->ajax))
				{
					$str .= <<<STR
		form_data += "&$eleName=" + escape(CKEDITOR.instances.$eleId.getData());

STR;
				}	
				if(!empty($ele->required))
				{
					$str .= <<<STR
		if( CKEDITOR.instances.$eleId.getData() == "") {
			$alertMsg
			CKEDITOR.instances.$eleId.focus();
			return false;
		}

STR;
				}
			}
			elseif($eleType == "checksort")
			{
				if(!empty($this->ajax))
				{
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
				if(!empty($ele->required))
				{
					$str .= <<<STR
		if(!formObj.elements["$eleName"]) {
			$alertMsg
			return false;
		}	

STR;
				}	
			}
			elseif(!empty($this->ajax) && $eleType == "sort")
			{
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
			
			if($eleType == "email")
			{
				$str .= <<<STR
		if(formObj.elements["$eleName"].value != "$eleHint") {
			$.ajax({
				async: false,
				type: "post",
				url: "{$this->jsIncludesPath}/php-email-address-validation/ajax-handler.php",
				dataType: "text",
				data: "email=" + escape(formObj.elements["$eleName"].value) + "&label=" + escape("$eleLabel") + "&format=" + escape("{$this->emailErrorMsgFormat}"),
				success: function(responseMsg, textStatus) {
					if(responseMsg != "") {
						validemail_{$this->attributes["id"]} = false;
						{$this->jsErrorFunction}(responseMsg);
					}
					else
						validemail_{$this->attributes["id"]} = true;
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { {$this->jsErrorFunction}(XMLHttpRequest.responseText); }
			});

			if(!validemail_{$this->attributes["id"]}) {
				formObj.elements["$eleName"].focus();
				return false;
			}
		}

STR;
			}
		}	

		/*Remove hints if they remain as form element values.*/
		for($i = 0; $i < $elementSize; ++$i)
		{
			$ele = $elements[$i];
			if(!empty($ele->hint))
			{
				$eleName = str_replace('"', '&quot;', $ele->attributes["name"]);
				$str .= <<<STR
		if(formObj.elements["$eleName"].value == formObj.elements["$eleName"].defaultValue)
			formObj.elements["$eleName"].value = "";

STR;
			}
		}	
		return $str;
	}

	/*This function renders the form's javascript.  This function is invoked within includes/js.php.  The contents returned by this function are then placed in the document's head tag for xhtml strict compliance.*/
	public function renderJS($returnString=false)
	{
		$str = "";
		if(!empty($_SESSION["pfbc-instances"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-instances"]))
		{
			/*Automatically unserialize the appropriate form instance stored in the session array.*/
			$form = unserialize($_SESSION["pfbc-instances"][$this->attributes["id"]]);

			if(!empty($form->jqueryDateIDArr) || !empty($form->jqueryDateRangeIDArr) || !empty($form->jquerySortIDArr) || !empty($form->tooltipIDArr) || !empty($form->jquerySliderIDArr) || !empty($form->jqueryStarRatingIDArr) || !empty($form->jqueryColorIDArr))
			{
				$str .= <<<STR
$(function() {

STR;
				if(!empty($form->jqueryDateIDArr))
				{
					$dateSize = sizeof($form->jqueryDateIDArr);
					for($d = 0; $d < $dateSize; ++$d)
					{
						$str .= <<<STR
	$("#{$form->jqueryDateIDArr[$d]}").datepicker({ dateFormat: "{$form->jqueryDateFormat}", showButtonPanel: true });

STR;
					}	
				}

				if(!empty($form->jqueryDateRangeIDArr))
				{
					$dateRangeSize = sizeof($form->jqueryDateRangeIDArr);
					for($d = 0; $d < $dateRangeSize; ++$d)
					{
						$str .= <<<STR
	$("#{$form->jqueryDateRangeIDArr[$d]}").daterangepicker({ dateFormat: "{$form->jqueryDateFormat}" });

STR;
					}	
				}

				if(!empty($form->jquerySortIDArr))
				{
					$sortSize = sizeof($form->jquerySortIDArr);
					for($s = 0; $s < $sortSize; ++$s)
					{
						$str .= <<<STR
	$("#{$form->jquerySortIDArr[$s]}").sortable({ axis: "y" });
	$("#{$form->jquerySortIDArr[$s]}").disableSelection();

STR;
					}	
				}

				/*For more information on qtip, visit http://craigsworks.com/projects/qtip/.*/
				if(!empty($form->tooltipIDArr))
				{
					$tooltipKeys = array_keys($form->tooltipIDArr);
					$tooltipSize = sizeof($tooltipKeys);
					for($t = 0; $t < $tooltipSize; ++$t)
					{
						$tooltipEle = $form->tooltipIDArr[$tooltipKeys[$t]];
						$tooltipContent = str_replace('"', '\"', $tooltipEle->tooltip);
						$str .= <<<STR
	$("#{$tooltipKeys[$t]}").qtip({ content: "$tooltipContent", style: { name: "light", tip: { corner: "bottomLeft", size: { x: 10, y: 8 } }, border: { radius: 3, width: 3
STR;
						if(!empty($form->tooltipBorderColor))
						{
							if($form->tooltipBorderColor[0] != "#")
								$form->tooltipBorderColor = "#" . $form->tooltipBorderColor;
							$str .= <<<STR
, color: "{$form->tooltipBorderColor}"
STR;
						}	
						$str .= <<<STR
} 
STR;
						if(!empty($tooltipEle->tooltipWidth))
						{
							if(substr($tooltipEle->tooltipWidth, -2) == "px")
								$tooltipEle->tooltipWidth = substr($tooltipEle->tooltipWidth, 0, -2);
							$str .= <<<STR
, width: {$tooltipEle->tooltipWidth}
STR;
						}

						$str .= <<<STR
}, position: { corner: { target: "topRight", tooltip: "bottomLeft" } } });

STR;
					}	
				}

				/*For more information on the jQuery UI slider, visit http://jqueryui.com/demos/slider/.*/
				if(!empty($form->jquerySliderIDArr))
				{
					$sliderKeys = array_keys($form->jquerySliderIDArr);
					$sliderSize = sizeof($form->jquerySliderIDArr);
					for($s = 0; $s < $sliderSize; ++$s)
					{
						$slider = $form->jquerySliderIDArr[$sliderKeys[$s]];
						$sliderName = str_replace('"', '&quot;', $slider->attributes["name"]);
						$str .= <<<STR
	$("#{$sliderKeys[$s]}").slider({

STR;
						if(is_array($slider->attributes["value"]))
						{
							$str .= <<<STR
		range: true, 
		values: [{$slider->attributes["value"][0]}, {$slider->attributes["value"][1]}],

STR;
						}	
						else
						{
							$str .= <<<STR
		range: "min", 
		value: {$slider->attributes["value"]},

STR;
						}	
						$str .= <<<STR
		min: {$slider->sliderMin}, 
		max: {$slider->sliderMax}, 
		orientation: "{$slider->sliderOrientation}",

STR;
						if(!empty($slider->sliderSnapIncrement))
						{
							$str .= <<<STR
		step: {$slider->sliderSnapIncrement},

STR;
						}	
						if(is_array($slider->attributes["value"]))
						{
							$str .= <<<STR
		slide: function(event, ui) {

STR;
							if(empty($slider->sliderHideDisplay))
							{
								$str .= <<<STR
			$("#{$sliderKeys[$s]}_display").text("{$slider->sliderPrefix}" + ui.values[0] + "{$slider->sliderSuffix} - {$slider->sliderPrefix}" + ui.values[1] + "{$slider->sliderSuffix}");

STR;
							}	
							$str .= <<<STR
			document.getElementById("{$this->attributes["id"]}").elements["$sliderName"][0].value = ui.values[0]; document.getElementById("{$this->attributes["id"]}").elements["$sliderName"][1].value = ui.values[1];
		}	

STR;
						}	
						else
						{
							$str .= <<<STR
		slide: function(event, ui) {

STR;
							if(empty($slider->sliderHideDisplay))
							{
								$str .= <<<STR
			$("#{$slider->attributes["id"]}_display").text("{$slider->sliderPrefix}" + ui.value + "{$slider->sliderSuffix}");

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

				/*For more information on the jQuery rating plugin, visit http://plugins.jquery.com/project/Star_Rating_widget.*/
				if(!empty($form->jqueryStarRatingIDArr))
				{
					$ratingKeys = array_keys($form->jqueryStarRatingIDArr);
					$ratingSize = sizeof($form->jqueryStarRatingIDArr);
					for($r = 0; $r < $ratingSize; ++$r)
					{
						$rating = $form->jqueryStarRatingIDArr[$ratingKeys[$r]];
						$str .= <<<STR
	$("#{$ratingKeys[$r]}").stars({

STR;
						if(empty($rating->ratingHideCaption))
						{
							$str .= <<<STR
		captionEl: $("#{$ratingKeys[$r]}_caption"),

STR;
						}	
						if(!empty($rating->ratingHideCancel))
						{
							$str .= <<<STR
		cancelShow: false,

STR;
						}	
						$str .= <<<STR
		inputType: "select", 
		cancelValue: "" 
	});

STR;
					}	
				}

				/*For more information on the jQuery colorpicker plugin, visit http://plugins.jquery.com/project/color_picker.*/
				if(!empty($form->jqueryColorIDArr))
				{
					$colorSize = sizeof($form->jqueryColorIDArr);
					for($c = 0; $c < $colorSize; ++$c)
					{
						$str .= <<<STR
	$("#{$form->jqueryColorIDArr[$c]}").ColorPicker({	
		onSubmit: function(hsb, hex, rgb, el) { 
			$(el).val(hex); 
			$(el).ColorPickerHide(); 
		}, 
		onBeforeShow: function() { 
			if(this.value != "Click to Select Color..." && this.value != "") 
				$(this).ColorPickerSetColor(this.value); 
		} 
	}).bind("keyup", function(){ 
		$(this).ColorPickerSetColor(this.value); 
	});

STR;
					}	
				}

					$str .= <<<STR
});

STR;
			}	

			if(!empty($form->latlngIDArr))
			{
				if(!empty($form->formIDOverride))
					$latlngForm = $form->formIDOverride;
				else
					$latlngForm = $this->attributes["id"];

				if(empty($form->latlngDefaultLocation))
					$form->latlngDefaultLocation = array(41.847, -87.661);

				$latlngSize = sizeof($form->latlngIDArr);
				$latlngKeys = array_keys($form->latlngIDArr);

				for($l = 0; $l < $latlngSize; ++$l)
				{
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
				for($l = 0; $l < $latlngSize; ++$l)
				{
					$latlng = $form->latlngIDArr[$latlngKeys[$l]];
					$latlngID = str_replace('"', '&quot;', $latlng->attributes["id"]);
					$latlngName = str_replace('"', '&quot;', $latlng->attributes["name"]);
					$latlngHint = str_replace('"', '&quot;', $latlng->hint);
					if(!empty($latlng->attributes["value"]) && $latlng->attributes["value"] != $latlng->hint)
					{
						$latlngCenter = $latlng->attributes["value"];
						if(empty($latlng->latlngZoom))
							$latlngZoom = 9;
						else
							$latlngZoom = $latlng->latlngZoom;
					}		
					else	
					{
						$latlngCenter = $form->latlngDefaultLocation;
						if(empty($latlng->latlngZoom))
							$latlngZoom = 5;
						else
							$latlngZoom = $latlng->latlngZoom;
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
		document.getElementById("$latlngForm").elements["$latlngName"].value = "Latitude: " + lat.toFixed(3) + ", Longitude: " + lng.toFixed(3);
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
				document.getElementById("$latlngForm").elements[fieldName].value = "Latitude: " + lat.toFixed(3) + ", Longitude: " + lng.toFixed(3);
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
function clearLatLng_{$this->attributes["id"]}(latlngID, latlngFieldName) {
	if(document.getElementById("$latlngForm").elements[latlngID + "_locationJump"])
		document.getElementById("$latlngForm").elements[latlngID + "_locationJump"].value = "Location Jump: Enter Keyword, City/State, Address, or Zip Code";
	document.getElementById("$latlngForm").elements[latlngFieldName].value = "$latlngHint";
	document.getElementById(latlngID + "_clearDiv").style.display = "none";
}
setTimeout("initializeLatLng_{$this->attributes["id"]}();", 250);

STR;
			}

			if(!empty($form->jqueryCheckSort))
			{
				$str .= <<<STR
function addOrRemoveCheckSortItem_{$this->attributes["id"]}(cs_fieldObj, cs_id, cs_name, cs_index, cs_value, cs_text) {
	if(cs_fieldObj.checked != true)
		document.getElementById(cs_id).removeChild(document.getElementById(cs_id + cs_index));
	else {
		var li = document.createElement('li');
		li.id = cs_id + cs_index;
		li.className = 'ui-state-default';
		li.style.cssText = 'margin: 3px 0; padding-left: 0.5em; font-size: 1em; height: 2em; line-height: 2em;';
		li.innerHTML = '<input type="hidden" name="' + cs_name + '" value="' + cs_value + '"/>' + cs_text;
		document.getElementById(cs_id).appendChild(li);
	}
}

STR;
			}

			if(!empty($form->tinymceIDArr))
			{
				if(empty($form->preventTinyMCEInitLoad))
				{
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

			if(!empty($form->ckeditorIDArr))
			{
				$ckeditorSize = sizeof($form->ckeditorIDArr);
				$ckeditorKeys = array_keys($form->ckeditorIDArr);

				for($c = 0; $c < $ckeditorSize; ++$c)
				{
					$ckeditor = $form->ckeditorIDArr[$ckeditorKeys[$c]];
					$ckeditorID = str_replace('"', '&quot;', $ckeditor->attributes["id"]);
					$ckeditorParamArr = array();
					if(!empty($ckeditor->ckeditorBasic))
						$ckeditorParamArr[] = 'toolbar: "Basic"';
					if(!empty($form->ckeditorCustomConfig))	
						$ckeditorParamArr[] = 'customConfig: "' . $form->ckeditorCustomConfig . '"';
					if(!empty($form->ckeditorLang))
						$ckeditorParamArr[] = 'language: "' . $form->ckeditorLang . '"';
					$str .= <<<STR
CKEDITOR.replace("$ckeditorID"
STR;
					if(!empty($ckeditorParamArr))
					{
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

			if(!empty($form->captchaID))
			{
				$str .= <<<STR
Recaptcha.create("{$form->captchaPublicKey}", "{$form->captchaID}", { theme: "{$form->captchaTheme}", lang: "{$form->captchaLang}" });

STR;
			}

			if(!empty($form->hintExists))
			{
				$str .= <<<STR
function hintfocus_{$this->attributes["id"]}(eleObj) {
	if(eleObj.value == eleObj.defaultValue)
		eleObj.value = '';
}
function hintblur_{$this->attributes["id"]}(eleObj) {
	if(eleObj.value == '')
		eleObj.value = eleObj.defaultValue;
}

STR;
			}

			if(!empty($form->hasFormTag))
			{
				/*
				If there are any required fields in the form or if this form is setup to utilize ajax, build a javascript 
				function for performing form validation before submission and/or for building and submitting a data string through ajax.
				*/
				if(!empty($form->checkform) || !empty($form->ajax) || !empty($form->captchaExists) || !empty($form->hintExists) || !empty($form->emailExists))
				{
					if(!empty($form->emailExists))
					{
						$str .= <<<STR
var validemail_{$this->attributes["id"]};

STR;
					}	
					$str .= <<<STR
function pfbc_error_{$form->attributes["id"]}(errorMsg) {
	document.getElementById('pfbc-error-{$form->attributes["id"]}').innerHTML = '';
	var error = document.createElement('div');
	error.className = 'ui-widget';
	error.style.cssText = 'margin: 7px 0;';
	error.innerHTML = '<div class="ui-state-error ui-corner-all" style="padding: 7px;"><b>Error:</b> ' + errorMsg + '</div>';
	document.getElementById('pfbc-error-{$form->attributes["id"]}').appendChild(error);
	$('html, body').animate({ scrollTop: $("#{$form->attributes["id"]}").offset().top }, 500);
}
function {$form->onsubmitFunction}(formObj) {

STR;
					/*If this form is setup for ajax submission, a javascript variable (form_data) is defined and built.  This variable holds each
					key/value pair and acts as the GET or POST string.*/
					if(!empty($form->ajax))
					{
						$str .= <<<STR
	var form_data = "";

STR;
					}	

					$str .= $form->jsCycleElements($form->elements);
					if(!empty($form->bindRules))
					{
						$bindRuleKeys = array_keys($form->bindRules);
						$bindRuleSize = sizeof($bindRuleKeys);
						for($b = 0; $b < $bindRuleSize; ++$b)
						{
							if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements))
							{
								if(!empty($form->bindRules[$bindRuleKeys[$b]][1]))
								{
									$str .= <<<STR
	if({$form->bindRules[$bindRuleKeys[$b]][1]}) {
STR;
								}	
								$str .= $form->jsCycleElements($form->bindRules[$bindRuleKeys[$b]][0]->elements);
								if(!empty($form->bindRules[$bindRuleKeys[$b]][1]))
								{
									$str .= <<<STR
	}

STR;
								}	
							}
						}
					}
						
					if(!empty($form->ajax))
					{
						$str .= <<<STR
	form_data = form_data.substring(1, form_data.length);
	$.ajax({
		type: "{$form->ajaxType}",
		url: "{$form->ajaxUrl}",
		dataType: "{$form->ajaxDataType}",
		data: form_data,

STR;
						if(!empty($form->ajaxPreCallback))
						{
							$str .= <<<STR
		beforeSend: function() {
			{$form->ajaxPreCallback}();
		},

STR;
						}
						$str .= <<<STR
		success: function(responseMsg) {

STR;
						if(!empty($form->ajaxCallback))
						{
							$str .= <<<STR
						{$form->ajaxCallback}(responseMsg);

STR;
						}	
						else
						{
							$str .= <<<STR
			if(responseMsg != "")
				{$form->jsErrorFunction}(responseMsg);

STR;
						}		
						$str .= <<<STR
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) { {$form->jsErrorFunction}(XMLHttpRequest.responseText); }
	});
	return false;

STR;
					}	
					else	
					{
						$str .= <<<STR
	return true;

STR;
					}	
					$str .= <<<STR
}

STR;
				}

				/*This javascript section sets the focus of the first field in the form.  This default behavior can be overwritten by setting the
				noAutoFocus parameter.*/
				if(empty($form->noAutoFocus) && !empty($form->focusElement))
				{
					/*The webeditor and ckeditor fields are a special case.*/
					if(!empty($form->tinymceIDArr) && is_array($form->tinymceIDArr) && in_array($form->focusElement, $form->tinymceIDArr))
					{
						$str .= <<<STR
setTimeout("if(tinyMCE.get(\"{$form->focusElement}\")) tinyMCE.get(\"{$form->focusElement}\").focus();", 1000);

STR;
					}	
					elseif(!empty($form->ckeditorIDArr) && is_array($form->ckeditorIDArr) && array_key_exists($form->focusElement, $form->ckeditorIDArr))
					{
						$str .= <<<STR
setTimeout("CKEDITOR.instances.{$form->focusElement}.focus();", 1000);
STR;

					}	
					else
					{
						/*Any fields with multiple options such as radio button, checkboxes, etc. are handled accordingly.*/
						$str .= <<<STR
if(document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].type != "select-one" && document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].type != "select-multiple" && document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].length)
	document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"][0].focus();
else
	document.getElementById("{$this->attributes["id"]}").elements["{$form->focusElement}"].focus();

STR;
					}		
				}
			}	
		}	

		if(!$returnString)
			echo($str);
		else
			return $str;
	}

	/*This function renders the form's css.  This function is invoked within includes/css.php.  The contents returned by this function are then placed in the document's head tag for xhtml strict compliance.*/
	public function renderCSS($returnString=false)
	{
		$str = "";
		if(!empty($_SESSION["pfbc-instances"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-instances"]))
		{
			/*Automatically unserialize the appropriate form instance stored in the session array.*/
			$form = unserialize($_SESSION["pfbc-instances"][$this->attributes["id"]]);

			if(empty($form->preventDefaultCSS))
			{
				$id = "#" . $this->attributes["id"];
				$str .= <<<STR
$id .pfbc-clear:after {
	clear: both;
	display: block;
	margin: 0;
	padding: 0;
	visibility: hidden;
	height: 0;
	content: ":)";
}	
$id .pfbc-label {
	display: block;
}
$id .pfbc-buttons {
	text-align: right;
}
$id .pfbc-required {
	color: #990000; 
}
$id .pfbc-element {
	padding-bottom: 5px;
}

STR;

				if(!empty($form->attributes["width"]))
				{
					if(substr($form->attributes["width"], -1) == "%")
					{
						$formWidth = substr($form->attributes["width"], 0, -1);
						$suffix = "%";
					}	
					elseif(substr($form->attributes["width"], -2) == "px")
					{
						$formWidth = substr($form->attributes["width"], 0, -2);
						$suffix = "px";
					}
					else
					{
						$formWidth = $form->attributes["width"];
						$suffix = "px";
					}	
					$str .= <<<STR
$id .pfbc-main {
	width: {$formWidth}$suffix;
}

STR;
				}
				else
					$suffix = "%";

				if(!empty($form->map))
				{
					$mapVals = array_values(array_unique($form->map));
					$mapValSize = sizeof($mapVals);
					for($m = 0; $m < $mapValSize; ++$m)
					{
						if($suffix == "px")
						{
							$elementWidth = number_format((($formWidth - ($form->mapMargin * 2 * ($mapVals[$m] - 1)))  / $mapVals[$m]), 2, ".", "");
							$textboxWidth = $elementWidth - 6;
							$textareaWidth = $elementWidth - 2;
							$selectWidth = $elementWidth;
						}	
						else
						{
							$elementWidth = number_format(((100 - ($form->mapMargin * 2 * ($mapVals[$m] - 1)))  / $mapVals[$m]), 2, ".", "");
							$textboxWidth = 98;
							$textareaWidth = 98;
							$selectWidth = 98;
						}	
							
						$str .= <<<STR
$id .pfbc-map-columns-{$mapVals[$m]} {
	float: left; 
	width: {$elementWidth}$suffix;
}
$id .pfbc-map-columns-{$mapVals[$m]} .pfbc-textbox {
	width: {$textboxWidth}$suffix;
}
$id .pfbc-map-columns-{$mapVals[$m]} .pfbc-textarea {
	width: {$textboxWidth}$suffix;
}
$id .pfbc-map-columns-{$mapVals[$m]} .pfbc-select {
	width: {$selectWidth}$suffix;
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
	margin: 0 {$form->mapMargin}$suffix;
}

STR;
				}
				else
				{
					if($suffix == "px")
					{
						$textboxWidth = $formWidth - 6;
						$textareaWidth = $formWidth - 2;
						$selectWidth = $formWidth;
					}
					else
					{
						$textboxWidth = 98;
						$textareaWidth = 98;
						$selectWidth = 98;
					}
					$str .= <<<STR
$id .pfbc-textbox {
	width: {$textboxWidth}$suffix;
}
$id .pfbc-textarea {
	width: {$textareaWidth}$suffix;
}
$id .pfbc-select {
	width: {$selectWidth}$suffix;
}

STR;
				}
			}

			if(!empty($form->jqueryDateIDArr) || !empty($form->jqueryDateRangeIDArr) || !empty($form->jquerySortIDArr) || !empty($form->tooltipIDArr) || !empty($form->jquerySliderIDArr) || !empty($form->jqueryStarRatingIDArr) || !empty($form->jqueryColorIDArr))
			{
				if(!empty($form->jqueryDateIDArr))
				{
					$str .= <<<STR
	.ui-datepicker-div, .ui-datepicker-inline, #ui-datepicker-div { font-size: 1em !important; }

STR;
				}	

				if(!empty($form->jquerySliderIDArr))
				{
					$str .= <<<STR
	.ui-slider-handle { cursor: pointer !important; }

STR;
				}	

				if(!empty($form->jqueryStarRatingIDArr))
				{
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
		}	

		if(!$returnString)
			echo($str);
		else
			return $str;
	}

	private function indent($extra = "")
	{
		$str = "\n$extra";
		$str .= "\t\t";
		if(!empty($this->map))
			$str .= "\t";
		return $str;
	}

	/*
	This function validates all required fields.  If a captcha field is found, it is validated as well.  This function returns 
	true if the form successfully passes validation or false if errors were found.  If the form does return false, the errorMsg 
	variable will be populated with a human readable error message that can be displayed to the user upon redirect if desired.
	*/
	public function validate()
	{
		/*Determine if the form's submit method was get or post.*/
		if(!empty($_POST))
			$referenceValues = $_POST;
		elseif(!empty($_GET))
			$referenceValues = $_GET;
		else
		{
			$this->errorMsg = 'The $_GET/$_POST array containing the form\'s submitted values does not exists.';
			return false;
		}

		if(!empty($_SESSION["pfbc-instances"]) && array_key_exists($this->attributes["id"], $_SESSION["pfbc-instances"]))
		{
			/*Automatically unserialize the appropriate form instance stored in the session array.*/
			$form = unserialize($_SESSION["pfbc-instances"][$this->attributes["id"]]);

			/*Store the form's submitted values in a session array for prefilling if validation fails.*/
			$this->buildSessionValues($form, $referenceValues);
			if(!empty($form->bindRules))
			{
				$bindRuleKeys = array_keys($form->bindRules);
				$bindRuleSize = sizeof($bindRuleKeys);
				for($b = 0; $b < $bindRuleSize; ++$b)
				{
					if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements))
					{
						if(empty($form->bindRules[$bindRuleKeys[$b]][2]) || (eval("if(" . $form->bindRules[$bindRuleKeys[$b]][2] . ") return true; else return false;")))
							$this->buildSessionValues($form->bindRules[$bindRuleKeys[$b]][0], $referenceValues);
					}		
				}	
			}	

			/*Cycle through the form's required elements to ensure they are valid.*/
			if(!$this->phpCycleElements($form->elements, $referenceValues, $form))
				return false;
			if(!empty($form->bindRules))
			{
				$bindRuleKeys = array_keys($form->bindRules);
				$bindRuleSize = sizeof($bindRuleKeys);
				for($b = 0; $b < $bindRuleSize; ++$b)
				{
					if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements))
					{
						if(empty($form->bindRules[$bindRuleKeys[$b]][2]) || (eval("if(" . $form->bindRules[$bindRuleKeys[$b]][2] . ") return true; else return false;")))
						{
							if(!$this->phpCycleElements($form->bindRules[$bindRuleKeys[$b]][0]->elements, $referenceValues, $form))
								return false;
						}	
					}
				}
			}

			/*Unset the session array(s) containing the form's submitted values to prevent unwanted prefilling.*/
			if(!empty($_SESSION["pfbc-values"][$form->attributes["id"]]))
				unset($_SESSION["pfbc-values"][$form->attributes["id"]]);
			if(!empty($form->bindRules))
			{
				$bindRuleKeys = array_keys($form->bindRules);
				$bindRuleSize = sizeof($bindRuleKeys);
				for($b = 0; $b < $bindRuleSize; ++$b)
				{
					if(!empty($form->bindRules[$bindRuleKeys[$b]][0]->elements))
					{
						if(empty($form->bindRules[$bindRuleKeys[$b]][2]) || (eval("if(" . $form->bindRules[$bindRuleKeys[$b]][2] . ") return true; else return false;")))
						{
							if(!empty($_SESSION["pfbc-values"][$form->bindRules[$bindRuleKeys[$b]][0]->attributes["id"]]))
								unset($_SESSION["pfbc-values"][$form->bindRules[$bindRuleKeys[$b]][0]->attributes["id"]]);
						}
					}	
				}	
			}	
			return true;
		}
		else
		{
			$this->errorMsg = 'The $_SESSION variable containing this form\'s serialized instance does not exists.';
			return false;
		}
	}

	/*This function is responsible for storing the form's submitted values in a session array for prefilling if the form fails validation.*/
	private function buildSessionValues($form, $referenceValues)
	{
		$elementSize = sizeof($form->elements);
		for($e = 0; $e < $elementSize; ++$e)
		{
			$eleName = $form->elements[$e]->attributes["name"];
			if(substr($eleName , -2) == "[]")
				$eleName = substr($eleName, 0, -2);

			if(array_key_exists($eleName, $referenceValues))
			{
				if(is_array($referenceValues[$eleName]))
				{
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

	/*This function handles php validation of all required form elements.  It was moved from within the validate function to it's own function to be reused by nested forms.*/
	private function phpCycleElements($elements, $referenceValues, $form)
	{
		$elementSize = sizeof($elements);
		for($i = 0; $i < $elementSize; ++$i)
		{
			$ele = $elements[$i];

			/*The html, sort, and element types are ignored.*/
			if($ele->attributes["type"] == "html" || $ele->attributes["type"] == "sort" || $ele->attributes["type"] == "hidden")
				continue;
			elseif($ele->attributes["type"] == "captcha")
			{
				require_once($form->phpIncludesPath . "/recaptchalib.php");
				$recaptchaResp = recaptcha_check_answer($form->captchaPrivateKey, $_SERVER["REMOTE_ADDR"], $referenceValues["recaptcha_challenge_field"], $referenceValues["recaptcha_response_field"]);
				if(!$recaptchaResp->is_valid)
				{
					if($recaptchaResp->error == "invalid-site-public-key")
						$this->errorMsg = "The reCAPTCHA public key could not be verified.";
					elseif($recaptchaResp->error == "invalid-site-private-key")
						$this->errorMsg = "The reCAPTCHA private key could not be verified.";
					elseif($recaptchaResp->error == "invalid-request-cookie")
						$this->errorMsg = "The reCAPTCHA challenge parameter of the verify script was incorrect.";
					elseif($recaptchaResp->error == "incorrect-captcha-sol")
						$this->errorMsg = "The reCATPCHA solution entered was incorrect.";
					elseif($recaptchaResp->error == "verify-params-incorrect")
						$this->errorMsg = "The reCAPTCHA parameters passed to the verification script were incorrect, make sure you are passing all the required parameters.";
					elseif($recaptchaResp->error == "invalid-referrer")
						$this->errorMsg = "The reCAPTCHA API public/private keys are tied to a specific domain name for security reasons.";
					else
						$this->errorMsg = "An unknown reCAPTCHA error has occurred.";
					return false;
				}
			}
			elseif(!empty($ele->required))
			{
				if(($ele->attributes["type"] == "checkbox" || $ele->attributes["type"] == "radio" || $ele->attributes["type"] == "checksort" || $ele->attributes["type"] == "rating") && !isset($referenceValues[$ele->attributes["name"]]))
				{
					$this->errorMsg = str_replace("[LABEL]", $ele->label, $form->errorMsgFormat);
					return false;
				}
				elseif(empty($referenceValues[$ele->attributes["name"]]))
				{
					$this->errorMsg = str_replace("[LABEL]", $ele->label, $form->errorMsgFormat);
					return false;
				}	
			}

			if($ele->attributes["type"] == "email" && !empty($referenceValues[$ele->attributes["name"]]))
			{
				require_once($form->phpIncludesPath . "/php-email-address-validation/EmailAddressValidator.php");
				$emailObj = new EmailAddressValidator;
				if(!$emailObj->check_email_address($referenceValues[$ele->attributes["name"]]))
				{
					$this->errorMsg = str_replace("[LABEL]", $ele->label, $form->emailErrorMsgFormat);
					return false;
				}	
			}
		}
		return true;
	}	

	/*This function sets the referenceValues variables which can be used to pre-fill form fields.  This function needs to be called before the render function.*/
	public function setReferenceValues($ref)
	{
		$this->referenceValues = $ref;
	}

	/*This function can be used to bind nested form elements rendered through elementsToString to the parent form object.*/
	public function bind($ref, $jsIfCondition = "", $phpIfCondition = "")
	{
		$this->bindRules[$ref->attributes["id"]] = array($ref, $jsIfCondition, $phpIfCondition);
		if(!empty($ref->emailExists))
			$this->emailExists = 1;
	}
}

class element extends base {
	/*Public variables to be read/written in both the base and form classes. These variables can be assigned in the last parameter
	of each function for adding form fields.*/
	public $attributes;					/*HTML attibutes that are applied to form input type.*/
	public $label;						/*Text/HTML that is placed in <div> about form input type.*/
	public $options;					/*Contains multiple options such as select, radio, checkbox, etc.  Can exist as associative or one-dimensional array.*/
	public $required;					/*Will trigger javascript error checking.*/
	public $disabled;					/*Adds "disabled" keyword to input element.*/
	public $multiple;					/*Adds "multiple" keyword to input element.*/
	public $readonly;					/*Adds "readonly" keyword to input element.*/
	public $nobreak;					/*Applicable for radio, yesno, truefalse, and checkbox elements.  If this parameter is set, there will not be <br> tags separating each option.*/
	public $preHTML;					/*HTML content that is rendered before <div> containing the element's label.*/
	public $postHTML;					/*HTML content that is rendered just before the closing </td> of the element.*/
	public $tooltip;					/*If provided, this content (text or HTML) will generate a tooltip activated onkeyup.*/
	public $tooltipWidth;				/*Allows tooltip widths to be customized.*/
	public $tooltipID;					/*Uniquely identifies each tooltip.*/
	public $hint;						/*If provided, this content will be displayed as the field's value until focus event.*/
	public $clear;						/*Only applicable for checkbox, radio, and checksort elements.  Inserts float-clearing div tag after last option.*/

	/*webeditor specific fields*/
	public $webeditorSimple;			/*Overrides default webeditor settings and renders a simplified version.*/

	/*ckeditor specific fields*/
	public $ckeditorBasic;				/*Overrides default ckeditor settings and renders a simplified toolbar.*/

	/*latlng specific fields*/
	public $latlngHeight;				/*Controls height of Google Map.*/
	public $latlngWidth;				/*Controls width of Google Map.*/
	public $latlngZoom;					/*Controls zoom level when Google Map is initially loaded.*/
	public $latlngHideJump;				/*Will hide the textbox for location jump functionality.*/

	/*slider specific fields*/
	public $sliderMin;					/*Controls lowest value of slider.*/ 
	public $sliderMax;					/*Controls highest value of slider.*/
	public $sliderSnapIncrement;		/*Controls incremental step of slider.*/
	public $sliderOrientation;			/*Defaults to horizontal but can be set to vertical.*/
	public $sliderPrefix;				/*Will prepend dynamic slider label with specified string.*/
	public $sliderSuffix;				/*Will append end of dynamic slider label with specified string.*/
	public $sliderHeight;				/*If the sliderOrientation is set to vertical, this parameter controls the slider height.*/
	public $sliderHideDisplay;			/*Hides dynamic slider label.*/

	/*rating specific fields*/
	public $ratingHideCaption;			/*Hides dynamic rating label.*/
	public $ratingHideCancel;			/*Hides rating cancel image.*/

	public function __construct() {
		/*Set default values where appropriate.*/
		$this->attributes = array(
			"type" => "text"
		);
	}
}
class option extends base {
	/*Public variables to be read/written in both the base and form classes.*/
	public $value;						/*Contains input value.*/
	public $text;						/*Contains displayed text.*/
}
class button extends base {
	/*Public variables to be read/written in both the base and form classes.*/
	public $attributes;					/*HTML attibutes that are applied to button input type.*/
	public $phpFunction;				/*Specified php function for generating button images.*/
	public $phpParams;					/*Array containing paramters passed to phpFunction.*/
	public $wrapLink;					/*Wraps anchor tag around button.*/
	public $linkAttributes;				/*HTML attibutes that are applied to the anchor tag is the wrapLink parameter is specified.*/

	/*Set default values where appropriate.*/
	public function __construct() {
		$this->linkAttributes = array(
			"style" => "text-decoration: none;"
		);
	}
}
?>
