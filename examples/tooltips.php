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
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | Tooltips</title>
			<style type="text/css">
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
		</head>
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Tooltips</b> - Tooltips can be added to your form element titles using a jQuery plugin called qTip which can be found at http://craigsworks.com/projects/qtip/.  To activate a tooltip for a field element, simply include the <i>tooltip</i> element attribute.  This parameter can contain plain text and/or rich, html content.  
			You can customize the tooltip's border and icon with the <i>tooltipBorderColor</i> and <i>tooltipIcon</i> form attributes respectively.</p>
			<?php
			$form = new form("tooltip");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "300")
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
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "300")
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Basic/Plain Text Tooltip:", "field0", "", array("tooltip" => "This is a basic/plain text tooltip."));
$form->addTextbox("HTML/Styled Tooltip:", "field1", "", array("tooltip" => \'<div class="tooltipTitle">HTML/Styled Tooltip Example</div><div class="tooltipBody">This example demonstates how to incorporate rich text into tooltips.</div>\'));
$form->addButton();
$form->render();
?>') . '</pre>';
			?>

			<a href="../index.php">Back to Project Home Page</a>
		</body>
	</html>	
	<?php
}
?>

