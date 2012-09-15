<?php
session_start();
error_reporting(E_ALL);
include("../PFBC/Form.php");

if(isset($_POST["form"])) {
	PFBC\Form::isValid($_POST["form"]);
	header("Location: " . $_SERVER["PHP_SELF"]);
	exit();	
}

include("../header.php");

?>
<div class="page-header">
	<h1>Form Elements</h1>
</div>

<p>PFBC has support for 32 form elements: Button, Captcha, Checkbox, Checksort, CKEditor, 
Color, Country, Date, DateTimeLocal, DateTime, Email, File, Hidden, HTML, jQueryUIDate, Month,
Number, Password, Phone, Radio, Range, Search, Select, Sort, State, Textarea, Textbox, Time,
TinyMCE, Url, Week, YesNo.</p>

<p><span class="label label-important">Important</span> In each of the example forms provided, you'll
notice that the form's prevent property is set to an array containing "bootstrap" and "jQuery".  This prevents
the css/js include files from being loaded a second time by PFBC as they're already being included in a header
file (header.php).  If your system already includes jQuery or bootstrap, it's recommended that you edit the prevent
property in PFBC/Form.php so you don't have to set it (the prevent property) each time you create a form.</p>

<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("form-elements");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new PFBC\Element\Hidden("form", "form-elements"));
$form->addElement(new PFBC\Element\HTML('<legend>Standard</legend>'));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\File("File:", "File"));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio Buttons:", "RadioButtons", $options));
$form->addElement(new PFBC\Element\Checkbox("Checkboxes:", "Checkboxes", $options));
$form->addElement(new PFBC\Element\HTML('<legend>HTML5</legend>'));
$form->addElement(new PFBC\Element\Phone("Phone:", "Phone"));
$form->addElement(new PFBC\Element\Search("Search:", "Search"));
$form->addElement(new PFBC\Element\Url("Url:", "Url"));
$form->addElement(new PFBC\Element\Email("Email:", "Email"));
$form->addElement(new PFBC\Element\Date("Date:", "Date"));
$form->addElement(new PFBC\Element\DateTime("DateTime:", "DateTime"));
$form->addElement(new PFBC\Element\DateTimeLocal("DateTime-Local:", "DateTimeLocal"));
$form->addElement(new PFBC\Element\Month("Month:", "Month"));
$form->addElement(new PFBC\Element\Week("Week:", "Week"));
$form->addElement(new PFBC\Element\Time("Time:", "Time"));
$form->addElement(new PFBC\Element\Number("Number:", "Number"));
$form->addElement(new PFBC\Element\Range("Range:", "Range"));
$form->addElement(new PFBC\Element\Color("Color:", "Color"));
$form->addElement(new PFBC\Element\HTML('<legend>jQuery UI</legend>'));
$form->addElement(new PFBC\Element\jQueryUIDate("Date:", "jQueryUIDate"));
$form->addElement(new PFBC\Element\Checksort("Checksort:", "Checksort", $options));
$form->addElement(new PFBC\Element\Sort("Sort:", "Sort", $options));
$form->addElement(new PFBC\Element\HTML('<legend>WYSIWYG Editor</legend>'));
$form->addElement(new PFBC\Element\TinyMCE("TinyMCE:", "TinyMCE"));
$form->addElement(new PFBC\Element\CKEditor("CKEditor:", "CKEditor"));
$form->addElement(new PFBC\Element\HTML('<legend>Custom/Other</legend>'));
$form->addElement(new PFBC\Element\State("State:", "State"));
$form->addElement(new PFBC\Element\Country("Country:", "Country"));
$form->addElement(new PFBC\Element\YesNo("Yes/No:", "YesNo"));
$form->addElement(new PFBC\Element\Captcha("Captcha:"));
$form->addElement(new PFBC\Element\Button);
$form->addElement(new PFBC\Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();

echo '<pre>', highlight_string('<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("form-elements");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new PFBC\Element\Hidden("form", "form-elements"));
$form->addElement(new PFBC\Element\HTML(\'<legend>Standard</legend>\'));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\File("File:", "File"));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio Buttons:", "RadioButtons", $options));
$form->addElement(new PFBC\Element\Checkbox("Checkboxes:", "Checkboxes", $options));
$form->addElement(new PFBC\Element\HTML(\'<legend>HTML5</legend>\'));
$form->addElement(new PFBC\Element\Phone("Phone:", "Phone"));
$form->addElement(new PFBC\Element\Search("Search:", "Search"));
$form->addElement(new PFBC\Element\Url("Url:", "Url"));
$form->addElement(new PFBC\Element\Email("Email:", "Email"));
$form->addElement(new PFBC\Element\Date("Date:", "Date"));
$form->addElement(new PFBC\Element\DateTime("DateTime:", "DateTime"));
$form->addElement(new PFBC\Element\DateTimeLocal("DateTime-Local:", "DateTimeLocal"));
$form->addElement(new PFBC\Element\Month("Month:", "Month"));
$form->addElement(new PFBC\Element\Week("Week:", "Week"));
$form->addElement(new PFBC\Element\Time("Time:", "Time"));
$form->addElement(new PFBC\Element\Number("Number:", "Number"));
$form->addElement(new PFBC\Element\Range("Range:", "Range"));
$form->addElement(new PFBC\Element\Color("Color:", "Color"));
$form->addElement(new PFBC\Element\HTML(\'<legend>jQuery UI</legend>\'));
$form->addElement(new PFBC\Element\jQueryUIDate("Date:", "jQueryUIDate"));
$form->addElement(new PFBC\Element\Checksort("Checksort:", "Checksort", $options));
$form->addElement(new PFBC\Element\Sort("Sort:", "Sort", $options));
$form->addElement(new PFBC\Element\HTML(\'<legend>WYSIWYG Editor</legend>\'));
$form->addElement(new PFBC\Element\TinyMCE("TinyMCE:", "TinyMCE"));
$form->addElement(new PFBC\Element\CKEditor("CKEditor:", "CKEditor"));
$form->addElement(new PFBC\Element\HTML(\'<legend>Custom/Other</legend>\'));
$form->addElement(new PFBC\Element\State("State:", "State"));
$form->addElement(new PFBC\Element\Country("Country:", "Country"));
$form->addElement(new PFBC\Element\YesNo("Yes/No:", "YesNo"));
$form->addElement(new PFBC\Element\Captcha("Captcha:"));
$form->addElement(new PFBC\Element\Button);
$form->addElement(new PFBC\Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>', true), '</pre>';

include("../footer.php");
