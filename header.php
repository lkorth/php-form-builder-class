<?php
$directory = dirname(__FILE__);

if(strpos(getcwd(), "/examples") !== false) {
	$examplePath = "";
	$indexPath = "../index.php";
	$versionPath = "../version";
	$prettifyPath = "../prettify";
}
else {
	$examplePath = "examples/";
	$indexPath = "";
	$versionPath = "version";
	$prettifyPath = "prettify";
}

$version = file_get_contents($versionPath);

function prettyprint($code) {
	echo '<pre class="prettyprint linenums">', str_replace("\t", str_repeat("&nbsp", 4), htmlspecialchars($code)), '</pre>';
}
?>	

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>PHP Form Builder Class</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
			.sidebar-nav {
				padding: 9px 0;
			}
		</style>
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap-combined.min.css" rel="stylesheet">
		<link href="<?php echo $prettifyPath; ?>/prettify.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/js/bootstrap.min.js"></script>
		<script src="<?php echo $prettifyPath; ?>/prettify.js"></script>
	</head>

	<body onload="prettyPrint()">
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="<?php echo $indexPath; ?>">PHP Form Builder Class</a>
					<div class="nav-collapse collapse">
						<p class="navbar-text pull-right">
							Sponsored by <img src="http://www.imavex.com/schemes/IMAVEX.COM/images/imavex-logo.png" alt="imavex" style="height: 25px; margin-top: -3px; cursor: pointer;" onclick="window.location = 'http://www.imavex.com/';"/>
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
							<li><a href="http://code.google.com/p/php-form-builder-class/downloads/list">Download PFBC <?php echo $version; ?></a></li>
							<li><a href="<?php echo $indexPath; ?>#whats-new-in-3x">What's New in 3.x</a></li>
							<li><a href="<?php echo $indexPath; ?>#getting-started">Getting Started</a></li>
							<li><a href="http://groups.google.com/group/php-form-builder-class/">Mailing List</a></li>
							<li><a href="http://code.google.com/p/php-form-builder-class/issues/list">Bug Tracker</a></li>
							<li class="nav-header">Examples</li>
							<?php
							$script = basename($_SERVER["PHP_SELF"]);
							?>
							<li<?php if($script == "form-elements.php") echo ' class="active"';?>><a href="<?php echo $examplePath; ?>form-elements.php">Form Elements</a></li>
							<li<?php if($script == "html5.php") echo ' class="active"';?>><a href="<?php echo $examplePath; ?>html5.php">HTML5</a></li>
							<li<?php if($script == "views.php") echo ' class="active"';?>><a href="<?php echo $examplePath; ?>views.php">Views</a></li>
							<li<?php if($script == "validation.php") echo ' class="active"';?>><a href="<?php echo $examplePath; ?>validation.php">Validation</a></li>
							<li<?php if($script == "ajax.php") echo ' class="active"';?>><a href="<?php echo $examplePath; ?>ajax.php">Ajax</a></li>
						</ul>
					</div>
				</div>
				<div class="span9">
