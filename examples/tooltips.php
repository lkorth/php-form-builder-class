<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	echo "<pre>" . htmlentities(print_r($_POST,true)) . "</pre>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Tooltips</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
			<style type="text/css">
				.tooltipTitle {
					font-weight: bold;
					color: #990000;;
					font-weight: bold;
					border-bottom: 1px solid #cccccc;
					font-size: 14px;
				}
				.tooltipBody {
					padding-top: 5px;
				}
			</style>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Tooltips</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Tooltips</b> - Tooltips can be added to your form element titles using a jQuery plugin called Poshy Tip which can be found at http://vadikom.com/tools/poshy-tip-jquery-plugin-for-stylish-tooltips/.  To activate a tooltip for a field element, simply include the <i>tooltip</i> element attribute.  This parameter can contain plain text and/or rich, html content.  
				You can customize the tooltip's icon with the <i>tooltipIcon</i> form attribute.</p>

				<?php
				$form = new form("tooltip");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 300
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Basic/Plain Text Tooltip:", "field0", "", array("tooltip" => "This is a basic/plain text tooltip."));
				$form->addTextbox("HTML/Styled Tooltip:", "field1", "", array("tooltip" => '<div class="tooltipTitle">HTML/Styled Tooltip Example</div><div class="tooltipBody">This example demonstates how to incorporate rich text into tooltips.</div>'));
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
	.tooltipTitle {
		font-weight: bold;
		color: #990000;;
		font-weight: bold;
		border-bottom: 1px solid #cccccc;
		font-size: 14px;
	}
	.tooltipBody {
		font-size: 12px;
		padding-top: 5px;
	}
</style>

<?php			
$form = new form("tooltip");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 300
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Basic/Plain Text Tooltip:", "field0", "", array("tooltip" => "This is a basic/plain text tooltip."));
$form->addTextbox("HTML/Styled Tooltip:", "field1", "", array("tooltip" => \'<div class="tooltipTitle">HTML/Styled Tooltip Example</div><div class="tooltipBody">This example demonstates how to incorporate rich text into tooltips.</div>\'));
$form->addButton();
$form->render();
?>', true), '</pre>';

				?>
			</div>	
		</body>
	</html>	
	<?php
}
?>

