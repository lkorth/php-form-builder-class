<?php
$numberofyears = 10;
$years = "";
for($y = 0; $y < $numberofyears; ++$y) {
	$years .= '"' . date("y", strtotime("+$y years")) . '"';
	if($y < ($numberofyears - 1))
		$years .= ",\n";
}

$jsonExpYear = <<<STR
{ 
	"keys": 
	[ 
		"", 
		$years
	], 
	"values": 
	[ 
		"--Select a Year --", 
		$years
	] 
}
STR;
