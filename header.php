<?php
$cwd = str_replace("\\", "/", getcwd());
if(strpos($cwd, "/examples") !== false) {
	$pathPrefix = "../";
	$examplePathPrefix = "";
}
else {
	$pathPrefix = "";
	$examplePathPrefix = "examples/";
}

$version = file_get_contents($pathPrefix . "version");

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

		<link href="<?php echo $pathPrefix; ?>PFBC/Resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
			.sidebar-nav {
				padding: 9px 0;
			}
		</style>
		<link href="<?php echo $pathPrefix; ?>PFBC/Resources/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="<?php echo $pathPrefix; ?>prettify/prettify.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<script type="text/javascript" src="<?php echo $pathPrefix; ?>PFBC/Resources/jquery.min.js"></script>
		<script src="<?php echo $pathPrefix; ?>PFBC/Resources/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo $pathPrefix; ?>prettify/prettify.js"></script>
	</head>

	<body onload="prettyPrint()">
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="<?php echo $pathPrefix; ?>index.php">PHP Form Builder Class</a>
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
							<li><a href="<?php echo $pathPrefix; ?>index.php#whats-new-in-3x">What's New in 3.x</a></li>
							<li><a href="<?php echo $pathPrefix; ?>index.php#getting-started">Getting Started</a></li>
							<li><a href="http://groups.google.com/group/php-form-builder-class/">Mailing List</a></li>
							<li><a href="http://code.google.com/p/php-form-builder-class/issues/list">Bug Tracker</a></li>
							<li class="nav-header">Examples</li>
							<?php
							$script = basename($_SERVER["PHP_SELF"]);
							?>
							<li<?php if($script == "form-elements.php") echo ' class="active"';?>><a href="<?php echo $examplePathPrefix; ?>form-elements.php">Form Elements</a></li>
							<li<?php if($script == "html5.php") echo ' class="active"';?>><a href="<?php echo $examplePathPrefix; ?>html5.php">HTML5</a></li>
							<li<?php if($script == "views.php") echo ' class="active"';?>><a href="<?php echo $examplePathPrefix; ?>views.php">Views</a></li>
							<li<?php if($script == "validation.php") echo ' class="active"';?>><a href="<?php echo $examplePathPrefix; ?>validation.php">Validation</a></li>
							<li<?php if($script == "ajax.php") echo ' class="active"';?>><a href="<?php echo $examplePathPrefix; ?>ajax.php">Ajax</a></li>
						</ul>
					</div>
				</div>
				<div class="span9">
