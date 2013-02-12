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
$version = file_get_contents("../version");
?>

<div class="page-header">
	<h1>Views</h1>
</div>

<p>In PFBC, views are responsible for converting a form's properties and elements into HTML, 
CSS, and javascript for the browser to display. There are four views provided in the project's 
download: SideBySide, Vertical, Inline and Search.</p>

<?php
$form = new Form("sidebyside");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new Element\Hidden("form", "sidebyside"));
$form->addElement(new Element\HTML('<legend>SideBySide <small>default</small></legend>'));
$form->addElement(new Element\Email("Email Address:", "Email", array(
	"required" => 1
)));
$form->addElement(new Element\Password("Password:", "Password", array(
	"required" => 1
)));
$form->addElement(new Element\Checkbox("", "Remember", array(
	"1" => "Remember me"
)));
$form->addElement(new Element\Button("Login"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#php53-1" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5 >= 5.3.0)</a></li>
	<li><a href="#php5-1" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5)</a></li>
</ul>

<div class="tab-content">
	<div id="php53-1" class="tab-pane active">

<?php
prettyprint('<?php
use PFBC\Form;
use PFBC\Element;

include("PFBC/Form.php");
$form = new Form("sidebyside");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new Element\Hidden("form", "sidebyside"));
$form->addElement(new Element\HTML(\'<legend>SideBySide <small>default</small></legend>\'));
$form->addElement(new Element\Email("Email Address:", "Email", array(
	"required" => 1
)));
$form->addElement(new Element\Password("Password:", "Password", array(
	"required" => 1
)));
$form->addElement(new Element\Checkbox("", "Remember", array(
	"1" => "Remember me"
)));
$form->addElement(new Element\Button("Login"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();');
?>

	</div>
	<div id="php5-1" class="tab-pane">

<?php
prettyprint('<?php
include("PFBC/Form.php");
$form = new Form("sidebyside");
$form->configure(array(
    "prevent" => array("bootstrap", "jQuery")
));
$form->addElement(new Element_Hidden("form", "sidebyside"));
$form->addElement(new Element_HTML(\'<legend>SideBySide <small>default</small></legend>\'));
$form->addElement(new Element_Email("Email Address:", "Email", array(
	"required" => 1
)));
$form->addElement(new Element_Password("Password:", "Password", array(
	"required" => 1
)));
$form->addElement(new Element_Checkbox("", "Remember", array(
	"1" => "Remember me"
)));
$form->addElement(new Element_Button("Login"));
$form->addElement(new Element_Button("Cancel", "button", array(
    "onclick" => "history.go(-1);"
)));
$form->render();');
?>

	</div>
</div>	

<?php
$form = new Form("vertical");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Vertical,
	"labelToPlaceholder" => 1
));
$form->addElement(new Element\Hidden("form", "vertical"));
$form->addElement(new Element\HTML('<legend>Vertical</legend>'));
$form->addElement(new Element\Textbox("Subject", "Subject"));
$form->addElement(new Element\Textarea("Comment", "Comment", array(
	"class" => "span6"
)));
$form->addElement(new Element\Button("Post Comment"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#php53-2" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5 >= 5.3.0)</a></li>
	<li><a href="#php5-2" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5)</a></li>
</ul>

<div class="tab-content">
	<div id="php53-2" class="tab-pane active">

<?php
prettyprint('<?php
use PFBC\Form;
use PFBC\Element;
use PFBC\View;

include("PFBC/Form.php");
$form = new Form("vertical");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Vertical,
	"labelToPlaceholder" => 1
));
$form->addElement(new Element\Hidden("form", "vertical"));
$form->addElement(new Element\HTML(\'<legend>Vertical</legend>\'));
$form->addElement(new Element\Textbox("Subject", "Subject"));
$form->addElement(new Element\Textarea("Comment", "Comment", array(
	"class" => "span6"
)));
$form->addElement(new Element\Button("Post Comment"));
$form->addElement(new Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();');
?>

	</div>
	<div id="php5-2" class="tab-pane">

<?php
prettyprint('<?php
include("PFBC/Form.php");
$form = new Form("vertical");
$form->configure(array(
    "prevent" => array("bootstrap", "jQuery", "focus"),
    "view" => new View_Vertical,
    "labelToPlaceholder" => 1
));
$form->addElement(new Element_Hidden("form", "vertical"));
$form->addElement(new Element_HTML(\'<legend>Vertical</legend>\'));
$form->addElement(new Element_Textbox("Subject", "Subject"));
$form->addElement(new Element_Textarea("Comment", "Comment", array(
	"class" => "span6"
)));
$form->addElement(new Element_Button("Post Comment"));
$form->addElement(new Element_Button("Cancel", "button", array(
    "onclick" => "history.go(-1);"
)));
$form->render();');
?>

	</div>
</div>	

<?php
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
?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#php53-3" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5 >= 5.3.0)</a></li>
	<li><a href="#php5-3" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5)</a></li>
</ul>

<div class="tab-content">
	<div id="php53-3" class="tab-pane active">

<?php
prettyprint('<?php
use PFBC\Form;
use PFBC\Element;
use PFBC\View;

include("PFBC/Form.php");
$form = new Form("inline");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Inline,
	"labelToPlaceholder" => 1
));
$form->addElement(new Element\Hidden("form", "inline"));
$form->addElement(new Element\HTML(\'<legend>Inline</legend>\'));
$form->addElement(new Element\Email("Email Address", "Email", array(
	"required" => 1
)));
$form->addElement(new Element\Password("Password", "Password", array(
	"required" => 1
)));
$form->addElement(new Element\Checkbox("", "Remember", array(
	"1" => "Remember me"
)));
$form->addElement(new Element\Button("Login"));
$form->render();');
?>

	</div>
	<div id="php5-3" class="tab-pane">

<?php
prettyprint('<?php
include("PFBC/Form.php");
$form = new Form("inline");
$form->configure(array(
    "prevent" => array("bootstrap", "jQuery", "focus"),
    "view" => new View_Inline,
    "labelToPlaceholder" => 1
));
$form->addElement(new Element_Hidden("form", "inline"));
$form->addElement(new Element_HTML(\'<legend>Inline</legend>\'));
$form->addElement(new Element_Email("Email Address", "Email", array(
	"required" => 1
)));
$form->addElement(new Element_Password("Password", "Password", array(
	"required" => 1
)));
$form->addElement(new Element_Checkbox("", "Remember", array(
	"1" => "Remember me"
)));
$form->addElement(new Element_Button("Login"));
$form->render();');
?>

	</div>
</div>

<?php
$form = new Form("search");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Search
));
$form->addElement(new Element\Hidden("form", "search"));
$form->addElement(new Element\HTML('<legend>Search</legend>'));
$form->addElement(new Element\Search("", "Search", array(
	"placeholder" => "Search", 
	"append" => '<button class="btn btn-primary">Go</button>'
)));
$form->render();
?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#php53-4" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5 >= 5.3.0)</a></li>
	<li><a href="#php5-4" data-toggle="tab">PFBC <?php echo $version; ?> (PHP 5)</a></li>
</ul>

<div class="tab-content">
	<div id="php53-4" class="tab-pane active">

<?php
prettyprint('<?php
use PFBC\Form;
use PFBC\Element;
use PFBC\View;

include("PFBC/Form.php");
$form = new Form("search");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus"),
	"view" => new View\Search
));
$form->addElement(new Element\Hidden("form", "search"));
$form->addElement(new Element\HTML(\'<legend>Search</legend>\'));
$form->addElement(new Element\Search("", "Search", array(
	"placeholder" => "Search", 
	"append" => \'<button class="btn btn-primary">Go</button>\'
)));
$form->render();');
?>

	</div>
	<div id="php5-4" class="tab-pane">

<?php
prettyprint('<?php
include("PFBC/Form.php");
$form = new Form("search");
$form->configure(array(
    "prevent" => array("bootstrap", "jQuery", "focus"),
    "view" => new View_Search
));
$form->addElement(new Element_Hidden("form", "search"));
$form->addElement(new Element_HTML(\'<legend>Search</legend>\'));
$form->addElement(new Element_Search("", "Search", array(
	"placeholder" => "Search", 
	"append" => \'<button class="btn btn-primary">Go</button>\'
)));
$form->render();');
?>

	</div>
</div>

<?php
include("../footer.php");
