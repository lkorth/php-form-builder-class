<?php
session_start();
error_reporting(E_ALL);
include("PFBC/Form.php");

if(isset($_POST["form"])) {
	Form::isValid($_POST["form"]);
	header("Location: " . $_SERVER["PHP_SELF"]);
	exit();	
}

include("header.php");
?>

<div class="hero-unit">
	<h1>PHP Form Builder Class</h1>
	<p>This project promotes rapid development of HTML forms through an object-oriented PHP framework.</p>
	<p><a href="http://code.google.com/p/php-form-builder-class/downloads/list" class="btn btn-primary btn-large"><i class="icon-download icon-white"></i> Download PFBC 3.0</a></p>
</div>

<a name="whats-new-in-3x"></a>
<h2>What's New in 3.x</h2>
<p>Unlike the 2.x branch, version 3.x doesn't represent a complete rewrite from its previous version.  In fact, most of the PHP code for creating
and validating forms has remained unchanged in this new major version release.  So, what's different?</p>

<p>The most significant enhancement is the integration with <a href="http://twitter.github.com/bootstrap/">Bootstrap</a> - a front-end 
framework from Twitter.  Bootstrap incorporates responsive CSS, which means your forms not only look and behave great in the latest 
desktop browser, but in tablet and smartphone browsers as well.  To see responsive CSS in action, resize your browser window and watch how the 
login form in the Getting Started section (above) responds.</p>

<p>Another enhancement in version 3.x is the addition of 13 HTML5 elements, which you can check out in our <a href="examples/html5.php">HTML5 
example</a>.  HTML5 form elements and attributes improve your form's usability - especially on tablets and smartphones where data is inputted
with virtual keyboards.</p>

<p>Here are a few more differences between PFBC 3.x and 2.x to be aware of if you're planning on upgrading.</p>
<ul>
	<li>In version 3.x, the Form class constructor no longer includes the width parameter.</li>
	<li>PFBC 3.x contains new view classes - SideBySide, Vertical, Inline, and Search.  The views used in version 2.x are no longer supported.</li>
	<li>The description element property that existed in PFBC 2.x has been replaced by two properties in 3.x - shortDesc and longDesc.  ShortDesc
	is displayed inline while longDesc is displayed block.</li>
	<li>jQuery UI js/css files are no longer included by default.  The js/css files will only be added when an elements that make use of jQuery 
	UI (jQueryUIDate, Checksort, and Sort) is added to the form.</li>
	<li>The Date element in PFBC 2.x has been renamed to jQueryUIDate.  The new Date element in version 3.x is HTML5's input type="date".</li>
	<li>The Email element now uses input type="email" as apposed to type="text".</li>
	<li>The required Element property now sets the HTML5 required attribute triggering client-side validation when supported by the web browser.</li>
	<li>Validation errors have been restyled using Bootstrap specific classes.</li>
</ul>

<a name="getting-started"></a>
<h2>Getting Started</h2>
<p>Before writing any code, you'll first need to download the latest version of PFBC, extract the contents of the zip file, 
and upload the PFBC directory within the document root of your web server. The other files/directories outside of the PFBC 
folder (like this one) that are included in the download are provided only for instruction and can be omitted from your production environment.</p>

<p>Once the PFBC directory is up on your web server, you're ready to create your first form.  Below you'll find a sample login 
form that we'll talk through in detail.
</p>

<?php
echo '<pre>', highlight_string('<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/PFBC/Form.php");

$form = new PFBC\Form("login");
$form->addElement(new PFBC\Element\HTML(\'<legend>Login</legend>\'));
$form->addElement(new PFBC\Element\Hidden("form", "login"));
$form->addElement(new PFBC\Element\Email("Email Address:", "Email", array("required" => 1)));
$form->addElement(new PFBC\Element\Password("Password:", "Password", array("required" => 1)));
$form->addElement(new PFBC\Element\Checkbox("", "Remember", array("1" => "Remember me")));
$form->addElement(new PFBC\Element\Button("Login"));
$form->addElement(new PFBC\Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>', true), '</pre>';

$form = new PFBC\Form("login");
$form->configure(array(
	"prevent" => array("bootstrap", "jQuery", "focus")
));
$form->addElement(new PFBC\Element\HTML('<legend>Login</legend>'));
$form->addElement(new PFBC\Element\Hidden("form", "login"));
$form->addElement(new PFBC\Element\Email("Email Address:", "Email", array("required" => 1)));
$form->addElement(new PFBC\Element\Password("Password:", "Password", array("required" => 1)));
$form->addElement(new PFBC\Element\Checkbox("", "Remember", array("1" => "Remember me")));
$form->addElement(new PFBC\Element\Button("Login"));
$form->addElement(new PFBC\Element\Button("Cancel", "button", array(
	"onclick" => "history.go(-1);"
)));
$form->render();
?>

<p><strong>Line 1:</strong> PFBC users PHP sessions in the validation process, so you'll need to ensure you have session_start(); in your 
webpage - before outputting anything to the browser.  If you forget, you'll be reminded by an error message displayed above your form.</p>

<p><strong>Line 2:</strong> In order to create an instance of the Form class, you'll need to first include /PFBC/Form.php. The specific 
line above assumes that the PFBC directory is sitting in your server's document root.</p>

<p><strong>Line 4:</strong> In the Form class' constructor, a unique identifier is supplied - "login" in this sample.  You'll reference
this same identifier in the validation process.</p>

<p><strong>Lines 5-12:</strong> Fields are added to the form with the addElement method.</p>

<p><strong>Line 13:</strong> The render method outputs the form's HTML, CSS, and javascript to the web browser.</p>

<p>Now that you've had a crash course in PFBC, go check out the example files that are included in the navigation above.  They demonstrate
how the validation process works, what form elements are supported, and much more.</p>

<?php
include("footer.php");
