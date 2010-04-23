<?php
header("Content-Type: text/css");

$formid = "";
if(!empty($_GET["id"]))
	$formid = "#" . $_GET["id"] . " ";

echo <<<STR
$formid.pfbc-label {
	display: block;
}
$formid.pfbc-buttons {
	text-align: right;
}
$formid.pfbc-required {
	color: #990000; 
}
$formid.pfbc-radio {
	float: left;
	margin: 0 4px;
}
$formid.pfbc-radio-first {
	margin-left: 0 !important;
}
$formid.pfbc-radio-last {
	margin-right: 0 !important;
}
$formid.pfbc-checkbox {
	float: left;
	margin: 0 4px;
}
$formid.pfbc-checkbox-first {
	margin-left: 0 !important;
}
$formid.pfbc-checkbox-last {
	margin-right: 0 !important;
}
$formid.pfbc-element {
	padding-bottom: 5px;
}

STR;

if(!empty($_GET["map"]))
{
	if(!isset($_GET["mapMargin"]))
		$_GET["mapMargin"] = 1;

	for($i = 1; $i <= 10; ++$i)
	{
		$elementWidth = number_format((($_GET["width"] - ($_GET["mapMargin"] * 2 * ($i - 1)))  / $i), 2, ".", "");
		$textboxWidth = $elementWidth - 6;
		$textareaWidth = $elementWidth - 2;
		$selectWidth = $elementWidth;
		
				echo <<<STR
$formid.pfbc-map-columns-$i .pfbc-textbox {
	width: {$textboxWidth}px;
}
$formid.pfbc-map-columns-$i .pfbc-textarea {
	width: {$textboxWidth}px;
}
$formid.pfbc-map-columns-$i .pfbc-select {
	width: {$selectWidth}px;
}

STR;
	}
}
else
{
	$textboxWidth = $_GET["width"] - 6;
	$textareaWidth = $_GET["width"] - 2;
	$selectWidth = $_GET["width"];
	echo <<<STR
$formid.pfbc-textbox {
	width: {$textboxWidth}px;
}
$formid.pfbc-textarea {
	width: {$textareaWidth}px;
}
$formid.pfbc-select {
	width: {$selectWidth}px;
}

STR;
}
?>
