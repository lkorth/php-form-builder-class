<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1"))) {
	$form = new form("webeditors_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: web-editors.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: web-editors.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Web Editors";
	include("../header.php");
	?>

	<p><b>Web Editors</b> - This project has support for two web editors - TinyMCE and CKEditor.  More information about these editors can be found at
	<a href="http://tinymce.moxiecode.com/">http://tinymce.moxiecode.com/</a> and <a href="http://ckeditor.com/">http://ckeditor.com/</a> respectively.
	Below, you will find several form/element attributes that affect the behavior of these two html wysiwyg editors.</p>

	<ul style="margin: 0;">
		<li>preventTinyMCELoad - The "preventTinyMCELoad" form attribtue is used to prevent TinyMCE's javascript file from being loaded twice if
		it has already been included either by or external to this project.</li>
		<li>preventTinyMCEInitLoad - This form attribute prevents TinyMCE's init function from being invoked, which is responsible for converting 
		all textareas with the appropriate class applied into TinyMCE web editors.  If you're using this project multiple times on the same webpage, and a previous form
		uses the addWebEditor function, you will need to use this form attribute prevent TinyMCE's init function from being invoke multiple times.
		Chances are that if you find yourself needing to apply the "preventTinyMCELoad" attribute, you will also need to apply this form attribute.</li>
		<li>preventCKEditorLoad - The "preventCKEditorLoad" form attribtue is used to prevent CKEditor's javascript file from being loaded twice if
		it has already been included either by or external to this project.</li>
		<li>basic - This element attribute is used to render a minified version of each web editor's control bar.</li>
	</ul>

	<p>Below you'll find several ways you can use the addWebEditor and addCKEditor functions in your development.</p>

	<?php
	$form = new form("webeditors_0");
	$form->setAttributes(array(
		"includesPath" => "../includes",
		"width" => 655, 
	));

	if(!empty($_GET["errormsg_0"]))
		$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_0");
	$form->addWebEditor("TinyMCE Web Editor:", "MyWebEditor");
	$form->addWebEditor("TinyMCE Web Editor w/Basic Attribute:", "MyWebEditorBasic", "", array("basic" => 1));
	$form->addButton();
	$form->render();
	?>

	<br/><br/>

	<?php
	$form = new form("webeditors_1");
	$form->setAttributes(array(
		"includesPath" => "../includes",
		"width" => "850"
	));

	if(!empty($_GET["errormsg_1"]))
		$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_1");
	$form->addCKEditor("CKEditor Web Editor:", "MyCKEditor");
	$form->addCKEditor("CKEditor Web Editor w/Basic Attribute:", "MyCKEditorBasic", "", array("basic" => 1));
	$form->addButton();
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("webeditors_0");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 655, 
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->addWebEditor("TinyMCE Web Editor:", "MyWebEditor");
$form->addWebEditor("TinyMCE Web Editor w/Basic Attribute:", "MyWebEditorBasic", "", array("basic" => 1));
$form->addButton();
$form->render();
?>

<br/><br/>

<?php
$form = new form("webeditors_1");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => "850"
));

if(!empty($_GET["errormsg_1"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_1");
$form->addCKEditor("CKEditor Web Editor:", "MyCKEditor");
$form->addCKEditor("CKEditor Web Editor w/Basic Attribute:", "MyCKEditorBasic", "", array("basic" => 1));
$form->addButton();
$form->render();
?>', true), '</pre>';

	include("../footer.php");
}
?>

