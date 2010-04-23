<?php
error_reporting(E_ALL);
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
			<title>PHP Form Builder Class | Examples | Tooltips</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="pfbc-css.php?id=tooltip&width=300" rel="stylesheet" type="text/css"/>
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
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/" target="_blank">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Tooltips</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Tooltips</b> - Tooltips can be added to your form element titles using a jQuery plugin called qTip which can be found at http://craigsworks.com/projects/qtip/.  To activate a tooltip for a field element, simply include the <i>tooltip</i> element attribute.  This parameter can contain plain text and/or rich, html content.  
				You can customize the tooltip's border and icon with the <i>tooltipBorderColor</i> and <i>tooltipIcon</i> form attributes respectively.</p>

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

echo '<pre>' . htmlentities('<style type="text/css">
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
?>') . '</pre>';

				?>
			</div>	
		</body>
	</html>	
	<?php
}
?>

