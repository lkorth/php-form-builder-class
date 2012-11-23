<?php
use PFBC\Form;
use PFBC\Element;
use PFBC\View;

session_start();
error_reporting(E_ALL);
include("../PFBC/Form.php");

if(isset($_POST["form"])) {
	Form::isValid($_POST["form"]);
	header("Location: " . $_SERVER["PHP_SELF"]);
	exit();	
}

include("../header.php");

?>
<div class="page-header">
	<h1>Views</h1>
</div>

<p>In PFBC, views are responsible for converting a form's properties and elements into HTML, 
CSS, and Javascript for the browser to display. There are four views provided in the project's 
download: SideBySide, Vertical, Inline and Search.</p>

<?php
$form = new Form("sidebyside");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new Element\Hidden("form", "sidebyside"));
$form->addElement(new Element\HTML('<legend>SideBySide <small>default</small></legend>'));
$form->addElement(new Element\Email("Email Address:", "Email", array("required" => 1)));
$form->addElement(new Element\Password("Password:", "Password", array("required" => 1)));
$form->addElement(new Element\Checkbox("", "Remember", array("1" => "Remember me")));
$form->addElement(new Element\Button("Login"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new Form("sidebyside");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new Element\Hidden("form", "sidebyside"));
$form->addElement(new Element\HTML(\'<legend>SideBySide <small>default</small></legend>\'));
$form->addElement(new Element\Email("Email Address:", "Email", array("required" => 1)));
$form->addElement(new Element\Password("Password:", "Password", array("required" => 1)));
$form->addElement(new Element\Checkbox("", "Remember", array("1" => "Remember me")));
$form->addElement(new Element\Button("Login"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>', true), '</pre>';

$form = new Form("vertical");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Vertical,
	"labelToPlaceholder" => 1
));
$form->addElement(new Element\Hidden("form", "vertical"));
$form->addElement(new Element\HTML('<legend>Vertical</legend>'));
$form->addElement(new Element\Textbox("Subject", "Subject"));
$form->addElement(new Element\Textarea("Comment", "Comment", array("class" => "span6")));
$form->addElement(new Element\Button("Post Comment"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new Form("vertical");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Vertical,
	"labelToPlaceholder" => 1
));
$form->addElement(new Element\Hidden("form", "vertical"));
$form->addElement(new Element\HTML(\'<legend>Vertical</legend>\'));
$form->addElement(new Element\Textbox("Subject", "Subject"));
$form->addElement(new Element\Textarea("Comment", "Comment", array("class" => "span6")));
$form->addElement(new Element\Button("Post Comment"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>', true), '</pre>';

$form = new Form("inline");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Inline,
	"labelToPlaceholder" => 1
));
$form->addElement(new Element\Hidden("form", "inline"));
$form->addElement(new Element\HTML('<legend>Inline</legend>'));
$form->addElement(new Element\Email("Email Address", "Email", array("required" => 1)));
$form->addElement(new Element\Password("Password", "Password", array("required" => 1)));
$form->addElement(new Element\Checkbox("", "Remember", array("1" => "Remember me")));
$form->addElement(new Element\Button("Login"));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new Form("inline");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Inline,
	"labelToPlaceholder" => 1
));
$form->addElement(new Element\Hidden("form", "inline"));
$form->addElement(new Element\HTML(\'<legend>Inline</legend>\'));
$form->addElement(new Element\Email("Email Address", "Email", array("required" => 1)));
$form->addElement(new Element\Password("Password", "Password", array("required" => 1)));
$form->addElement(new Element\Checkbox("", "Remember", array("1" => "Remember me")));
$form->addElement(new Element\Button("Login"));
$form->render();
?>', true), '</pre>';

$form = new Form("search");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Search
));
$form->addElement(new Element\Hidden("form", "search"));
$form->addElement(new Element\HTML('<legend>Search</legend>'));
$form->addElement(new Element\Search("", "Search", array("placeholder" => "Search", "append" => '<button class="btn btn-primary">Go</button>')));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new Form("search");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Search
));
$form->addElement(new Element\Hidden("form", "search"));
$form->addElement(new Element\HTML(\'<legend>Search</legend>\'));
$form->addElement(new Element\Search("", "Search", array("placeholder" => "Search", "append" => \'<button class="btn btn-primary">Go</button>\')));
$form->render();
?>', true), '</pre>';

include("../footer.php");
