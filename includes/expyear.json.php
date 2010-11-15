<?php
$numberofyears = 10;
$yearKeys = "";
$yearVals = "";
for($y = 0; $y < $numberofyears; ++$y) {
	$yearKeys .= '"' . date("y", strtotime("+$y years")) . '"';
	$yearVals .= '"' . date("Y", strtotime("+$y years")) . '"';
	if($y < ($numberofyears - 1)) {
		$yearKeys .= ",\n";
		$yearVals .= ",\n";
	}	
}

$jsonExpYear = <<<STR
{ 
	"keys": 
	[ 
		"", 
		$yearKeys
	], 
	"values": 
	[ 
		"--Select a Year --", 
		$yearVals
	] 
}
STR;
