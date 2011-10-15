<?php
namespace PFBC;

/*This project's namespace structure is leveraged to autoload requested classes at runtime.*/
function Load($class) {
	$file = __DIR__ . "/../" . str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
	if(is_file($file))
		include_once $file;
}
spl_autoload_register("PFBC\Load");
if(in_array("__autoload",spl_autoload_functions()))
	spl_autoload_register("__autoload");

class Form extends Base {
	protected $_elements = array();
	protected $_prefix = "http";
	protected $_resourcesPath;
	protected $_values = array();
	protected $_widthSuffix = "px";

	protected $ajax;
	protected $ajaxCallback;
	protected $attributes;
	protected $error;
	/*jQueryUI themes can be previewed at http://jqueryui.com/themeroller/.*/
	protected $jQueryUITheme = "smoothness";
	/*Prevents various automated from being automatically applied.  Current options for this array
	included jQuery, jQueryUI, jQueryUIButtons, focus, and style.*/
	protected $prevent = array();
	protected $view;
	protected $width;

	public function __construct($id = "pfbc", $width = "") {
		$this->configure(array(
			"width" => $width,
			"action" => basename($_SERVER["SCRIPT_NAME"]),
			"id" => preg_replace("/\W/", "-", $id),
			"method" => "post"
		));

		if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
			$this->_prefix = "https";
		
		/*The Standard view class is applied by default and will be used unless a different view is
		specified in the form's configure method*/
		if(empty($this->view))
			$this->view = new View\Standard;

		if(empty($this->error))
			$this->error = new Error\Standard;
		
		/*The resourcePath property is used to identify where third-party resources needed by the
		project are located.  This property will automatically be set properly if the PFBC directory
		is uploaded within the server's document root.  If symbolic links are used to reference the PFBC
		directory, you may need to set this property in the form's configure method or directly in this
		constructor.*/
		$path = __DIR__ . "/Resources";
		if(strpos($path, $_SERVER["DOCUMENT_ROOT"]) !== false)
			$this->_resourcesPath = substr($path, strlen($_SERVER["DOCUMENT_ROOT"]));
		else
			$this->_resourcesPath = "/PFBC/Resources";
	}

	/*When a form is serialized and stored in the session, this function prevents any non-essential
	information from being included.*/
	public function __sleep() {
		return array("attributes", "_elements", "error");
	}

	public function addElement(Element $element) {
		$element->_setForm($this);
		//If the element doesn't have a specified id, a generic identifier is applied.
		$id = $element->getID();
		if(empty($id))
			$element->setID($this->attributes["id"] . "-element-" . sizeof($this->_elements));
		$this->_elements[] = $element;

		/*For ease-of-use, the form tag's encytype attribute is automatically set if the File element
		class is added.*/
		if($element instanceof Element\File)
			$this->attributes["enctype"] = "multipart/form-data";
    }

	/*Values that have been set through the setValues method, either manually by the developer
	or after validation errors, are applied to elements within this method.*/
    protected function applyValues() {
        foreach($this->_elements as $element) {
            $name = $element->getName();
            if(isset($this->_values[$name]))
                $element->setValue($this->_values[$name]);
            elseif(substr($name, -2) == "[]" && isset($this->_values[substr($name, 0, -2)]))
                $element->setValue($this->_values[substr($name, 0, -2)]);
        }
    }

	public static function clearErrors($id = "pfbc") {
		if(!empty($_SESSION["pfbc"][$id]["errors"]))
			unset($_SESSION["pfbc"][$id]["errors"]);
	}

	public static function clearValues($id = "pfbc") {
		if(!empty($_SESSION["pfbc"][$id]["values"]))
			unset($_SESSION["pfbc"][$id]["values"]);
	}

	/*This method parses the form's width property into a numeric width value and a width suffix - either px or %.
	These values are used by the form's concrete view class.*/
	public function formatWidthProperties() {
		if(!empty($this->width)) {
			if(substr($this->width, -1) == "%") {
				$this->width = substr($this->width, 0, -1);
				$this->_widthSuffix = "%";
			}
			elseif(substr($this->width, -2) == "px")
				$this->width = substr($this->width, 0, -2);
		}
		else {
			/*If the form's width property is empty, 100% will be assumed.*/
			$this->width = 100;
			$this->_widthSuffix = "%";
		}
	}

    public function getAjax() {
        return $this->ajax;
    }

    public function getElements() {
        return $this->_elements;
    }

	public function getError() {
		return $this->error;
	}

    public function getId() {
        return $this->attributes["id"];
    }

    public function getJQueryUIButtons() {
        return $this->jQueryUIButtons;
	}

	public function getPrevent() {
        return $this->prevent;
    }

    public function getResourcesPath() {
        return $this->_resourcesPath;
    }

	public function getErrors() {
		$errors = array();
		if(session_id() == "")
			$errors[""] = array("Error: The pfbc project requires an active session to function properly.  Simply add session_start() to your script before any output has been sent to the browser.");
		else {
			$errors = array();
			$id = $this->attributes["id"];
			if(!empty($_SESSION["pfbc"][$id]["errors"]))
				$errors = $_SESSION["pfbc"][$id]["errors"];
		}	

		return $errors;	
	}

	public static function getSessionValues($id = "pfbc") {
		$values = array();
		if(!empty($_SESSION["pfbc"][$id]["values"]))
			$values = $_SESSION["pfbc"][$id]["values"];
		return $values;
	}

	public function getWidth() {
		return $this->width;
	}	

	public function getWidthSuffix() {
		return $this->_widthSuffix;
	}	

	public static function isValid($id = "pfbc", $clearValues = true) {
		$valid = true;
		/*The form's instance is recovered (unserialized) from the session.*/
		$form = self::recover($id);
		if(!empty($form)) {
			if($_SERVER["REQUEST_METHOD"] == "POST")
				$data = $_POST;
			else
				$data = $_GET;
			
			/*Any values/errors stored in the session for this form are cleared.*/
			self::clearValues($id);
			self::clearErrors($id);

			/*Each element's value is saved in the session and checked against any validation rules applied
			to the element.*/
			if(!empty($form->_elements)) {
				foreach($form->_elements as $element) {
					$name = $element->getName();
					if(substr($name, -2) == "[]")
						$name = substr($name, 0, -2);

					/*The File element must be handled differently b/c it uses the $_FILES superglobal and
					not $_GET or $_POST.*/
					if($element instanceof Element\File)
						$data[$name] = $_FILES[$name]["name"];

					if(isset($data[$name])) {
						$value = $data[$name];
						if(is_array($value)) {
							$valueSize = sizeof($value);
							for($v = 0; $v < $valueSize; ++$v)
								$value[$v] = stripslashes($value[$v]);
						}
						else
							$value = stripslashes($value);
						self::_setSessionValue($id, $name, $value);
					}		
					else
						$value = null;
					
					/*If a validation error is found, the error message is saved in the session along with
					the element's name.*/
					if(!$element->isValid($value)) {
						self::setError($id, $element->getErrors(), $name);
						$valid = false;
					}	
				}
			}

			/*If no validation errors were found, the form's session values are cleared.*/
			if($valid) {
				if($clearValues)
					self::clearValues($id);
				self::clearErrors($id);
			}		
		}
		else
			$valid = false;

		return $valid;
	}

	/*This method restores the serialized form instance.*/
	protected static function recover($id) {
		if(!empty($_SESSION["pfbc"][$id]["form"]))
			return unserialize($_SESSION["pfbc"][$id]["form"]);
		else
			return "";
	}

	public function render($returnHTML = false) {
		$this->view->_setForm($this);
		$this->error->_setForm($this);

		/*When validation errors occur, the form's submitted values are saved in a session 
		array, which allows them to be pre-populated when the user is redirected to the form.*/
		$values = self::getSessionValues($this->attributes["id"]);
		if(!empty($values))
			$this->setValues($values);
		$this->applyValues();

		$this->formatWidthProperties();

		if($returnHTML)
			ob_start();

		$this->renderCSS();
		$this->view->render();
		$this->renderJS();

		/*The form's instance is serialized and saved in a session variable for use during validation.*/
		$this->save();

		if($returnHTML) {
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
	}

	/*When ajax is used to submit the form's data, validation errors need to be manually sent back to the 
	form using json.*/
	public static function renderAjaxErrorResponse($id = "pfbc") {
		$form = self::recover($id);
		if(!empty($form))
			$form->error->renderAjaxErrorResponse();
	}

	protected function renderCSS() {
		$this->renderCSSFiles();

		echo '<style type="text/css">';
		$this->view->renderCSS();
		$this->error->renderCSS();
		foreach($this->_elements as $element)
			$element->renderCSS();
		echo '</style>';
	}

	protected function renderCSSFiles() {
		$urls = array();
		if(!in_array("jQueryUI", $this->prevent))
			$urls[] = $this->_prefix . "://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/" . $this->jQueryUITheme . "/jquery-ui.css";
		foreach($this->_elements as $element) {
			$elementUrls = $element->getCSSFiles();
			if(is_array($elementUrls))
				$urls = array_merge($urls, $elementUrls);
		}	

		/*This section prevents duplicate css files from being loaded.*/ 
		if(!empty($urls)) {	
			$urls = array_values(array_unique($urls));
			foreach($urls as $url)
				echo '<link type="text/css" rel="stylesheet" href="', $url, '"/>';
		}	
	}

	protected function renderJS() {
		$this->renderJSFiles();	

		echo '<script type="text/javascript">';
		$this->view->renderJS();
		foreach($this->_elements as $element)
			$element->renderJS();
		
		$id = $this->attributes["id"];

		echo 'jQuery(document).ready(function() {';

		/*When the form is submitted, disable all submit buttons to prevent duplicate submissions.*/
		echo 'jQuery("#', $id, '").bind("submit", function() {';
		if(!in_array("jQueryUIButtons", $this->prevent)) {
			echo 'jQuery(this).find("button[type=submit]").button("disable");';
			echo 'jQuery(this).find("button[type=submit] span.ui-button-text").css("padding-right", "2.1em").append("<img class=\"pfbc-loading\" src=\"', $this->_resourcesPath, '/loading.gif\"/>");';
		}	
		else
			echo 'jQuery(this).find("button[type=submit]").attr("disabled", "disabled");';
		echo '});';

		/*jQuery is used to set the focus of the form's initial element.*/
		if(!in_array("focus", $this->prevent))
			echo 'jQuery("#', $id, ' :input:visible:enabled:first").focus();';

		$this->view->jQueryDocumentReady();
		foreach($this->_elements as $element)
			$element->jQueryDocumentReady();
		
		/*For ajax, an anonymous onsubmit javascript function is bound to the form using jQuery.  jQuery's
		serialize function is used to grab each element's name/value pair.*/
		if(!empty($this->ajax)) {
			echo 'jQuery("#', $id, '").bind("submit", function() {';
			$this->error->clear();
			echo <<<JS
			jQuery.ajax({
				url: "{$this->attributes["action"]}",
				type: "{$this->attributes["method"]}",
				data: jQuery("#$id").serialize(),
				success: function(response) {
					if(response != undefined && typeof response == "object" && response.errors) {
JS;
			$this->error->applyAjaxErrorResponse();
			echo <<<JS
						jQuery("html, body").animate({ scrollTop: jQuery("#$id").offset().top }, 500 );
					}
					else {
JS;
			/*A callback function can be specified to handle any post submission events.*/
			if(!empty($this->ajaxCallback))
				echo $this->ajaxCallback, "(response);";

			echo '}';

			if(!in_array("jQueryUIButtons", $this->prevent)) {
				echo 'jQuery("#', $id, ' button[type=submit] span.ui-button-text").css("padding-right", "1em").find("img").remove();';
				echo 'jQuery("#', $id, ' button[type=submit]").button("enable");';
			}	
			else
				echo 'jQuery("#', $id, '").find("button[type=submit]").removeAttr("disabled");';

			echo <<<JS
				}
			});
			return false;
		});

JS;
		}

		echo <<<JS
	});	
</script>	
JS;
	}

	protected function renderJSFiles() {
		$urls = array();
		if(!in_array("jQuery", $this->prevent))
			$urls[] = $this->_prefix . "://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js";
		if(!in_array("jQueryUI", $this->prevent))
			$urls[] = $this->_prefix . "://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js";
		foreach($this->_elements as $element) {
			$elementUrls = $element->getJSFiles();
			if(is_array($elementUrls))
				$urls = array_merge($urls, $elementUrls);
		}		

		/*This section prevents duplicate css files from being loaded.*/ 
		if(!empty($urls)) {	
			$urls = array_values(array_unique($urls));
			foreach($urls as $url)
				echo '<script type="text/javascript" src="', $url, '"></script>';
		}	
	}

	/*The save method serialized the form's instance and saves it in the session.*/
	protected function save() {
		$_SESSION["pfbc"][$this->attributes["id"]]["form"] = serialize($this);
	}

	/*Valldation errors are saved in the session after the form submission, and will be displayed to the user
	when redirected back to the form.*/
	public static function setError($id, $errors, $element = "") {
		if(!is_array($errors))
			$errors = array($errors);
		if(empty($_SESSION["pfbc"][$id]["errors"][$element]))
			$_SESSION["pfbc"][$id]["errors"][$element] = array();

		foreach($errors as $error)
			$_SESSION["pfbc"][$id]["errors"][$element][] = $error;
	}

	protected static function _setSessionValue($id, $element, $value) {
		$_SESSION["pfbc"][$id]["values"][$element] = $value;
	}

	/*An associative array is used to pre-populate form elements.  The keys of this array correspond with
	the element names.*/
	public function setValues(array $values) {
        $this->_values = array_merge($this->_values, $values);
    }
}
