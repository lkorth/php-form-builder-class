<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>PHP Form Builder Class | Home</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('version'));?></a></div>
		<div id="pfbc_banner">
			<h2>PHP Form Builder Class</h2>
			<h5><span>Version: <?php echo(file_get_contents('version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('release'));?></span></h5>
		</div>

		<div id="pfbc_content">
			<b>About This Project:</b>
			<div>
			The goals of this project are to...
				<ul style="margin-top: 0; padding-top: 0;">
					<li>promote rapid development of forms through an object-oriented PHP structure.</li>
					<li>eliminate the grunt/repetitive work of writing the html and javascript validation when building forms.</li>
					<li>reduce human error by using a consistent/tested utility.</li>
					<li>incorporate complex elements such as jquery, google maps, tooltips, captcha, and html web editors quickly and with little effort.</li>
				</ul>
			</div>

			<b>Included Functionality:</b>
			<div>
				<ul style="margin-top: 0; padding-top: 0;">
					<li>Ajax Form Submission</li>
					<li>Javascript and PHP Validation</li>
					<li>jQuery Elements - date, datetime, time, daterange, sort, checksort, slider, rating, colorpicker (<a href="http://www.jquery.com/">jQuery</a>)</li>
					<li>Google Maps Element - latlng (<a href="http://code.google.com/apis/maps/documentation/v3/">Google Maps API v3</a>)</li>
					<li>Hybrid Form Element Types - state, country, yesno, truefalse, date, datetime, time, daterange, sort, latlng, checksort, webeditor, slider, rating, captcha, html, colorpicker, email</li>
					<li>File Upload Support</li>
					<li>Email Address Validation</li>
					<li>Two Wysiwyg Web Editors (<a href="http://tinymce.moxiecode.com/">TinyMCE</a>, <a href="http://ckeditor.com/">CKEditor</a>)</li>
					<li>Tooltips (<a href="http://craigsworks.com/projects/qtip/">jQuery qTip Plugin</a>)</li>
					<li>Captcha (<a href="http://recaptcha.net">reCAPTCHA</a>)</li>
					<li>Flexible Div Layout</li>
					<li>XHTML 1.0 Strict Compliant</li>
				</ul>
			</div>

			<b>Installation Instructions:</b>
			<div>
				<ol style="margin-top: 0; padding-top: 0;">
					<li><a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download</a> and unzip formbuilder.zip</li>
					<li>Upload the php-form-builder-class directory to your web server.</li>
					<li>index.php, style.css, and the examples directory are included only for instruction and can be omitted once in production.</li>
					<li>It is recommended that the scripts building/rendering your forms be located in the same folder as the php-form-builder-class directory.  Doing so will eliminate the need for specifying the <i>includesPath</i> attribute while building your forms.  An alternative is to make use of symbolic links within your file structure.  See the example - Invalid includes Directory Path Error - provided below for more details on the <i>includesPath</i> form attribute.</li>
					<li>Be sure to review the examples provided below as well as review the source of class.form.php.</li>
					<li>If you have any questions about using this project, suggestions for new features, or need to report a bug, please use the Google Code Project Hosting issue tracker located at http://code.google.com/p/php-form-builder-class/issues/list</li>
				</ol>
			</div>

			<b>System Requirements:</b>
			<div>
				<ul style="margin-top: 0; padding-top: 0;">
					<li>PHP 5 or greater</li>
				</ul>
			</div>	

			<b>Documentation:</b>
			<div>
				<ul style="margin-top: 0; padding-top: 0;">
					<li><a href="documentation/index.php">Developer's Reference Guide</a></li>
				</ul>
			</div>	

			<b>Included Tutorials/Examples:</b>
			<div>
				<ul style="margin-top: 0; padding-top: 0;">
					<li><a href="examples/form-elements.php">All Supported Form Elements</a></li>
					<li><a href="examples/ajax.php">Ajax</a></li>
					<li><a href="examples/jquery.php">jQuery</a></li>
					<li><a href="examples/php-validation.php">PHP Validation</a></li>
					<li><a href="examples/email-validation.php">Email Validation</a></li>
					<li><a href="examples/js-validation.php">Javascript Validation</a></li>
					<li><a href="examples/google-maps.php">Google Maps</a></li>
					<li><a href="examples/layout.php">Layout</a></li>
					<li><a href="examples/tooltips.php">Tooltips</a></li>
					<li><a href="examples/captcha.php">Captcha</a></li>
					<li><a href="examples/web-editors.php">Web Editors</a></li>
					<li><a href="examples/buttons.php">Buttons</a></li>
					<li><a href="examples/conditional-scenarios.php">Conditional Scenarios</a></li>
					<li><a href="examples/custom-css.php">Custom CSS Styling</a></li>
					<li><a href="examples/includes-directory-path-error.php">Invalid includes Directory Path Error</a></li>
				</ul>
			</div>

			<b>Donate:</b>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<div>
				If you would like to support the development of this project with a monetary donation, please use the button provided below to securely submit your donation through PayPal.<br/>
				<table cellpadding="2" cellspacing="0" border="0">
				<tr>
					<td align="left" valign="top">
						<input type="hidden" name="cmd" value="_s-xclick" />
						<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----"/>
						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!"/>
						<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"/>
					</td>
					<td align="left" valign="top">
						<img src="http://www.paypal.com/en_US/i/logo/paypal_logo.gif" alt="paypal"/>
					</td>
				</tr>
				</table>
			</div>
			</form>
		</div>	
	</body>
</html>
