## Project Overview

The PFBC (PHP Form Builder Class) project is developed with the following goals in mind...

* Promote rapid development of forms through an object-oriented PHP structure.
* Eliminate the grunt/repetitive work of writing the html and validation when building forms.
* Reduce human error by using a consistent/tested utility.

This project was first release to the open source community on April, 24 2009 at [PHPClass.org](http://www.phpclasses.org/package/5350-PHP-Generate-HTML-and-Javascript-for-displaying-forms.html). It was moved to its current location at [Google's Project Hosting service](http://code.google.com/p/php-form-builder-class) on November 16, 2009. Since the initial release, the project has gone through over 20 version releases and is still under active development.

The most significant enhancement in version 3.x is the integration with Bootstrap - a front-end framework from Twitter. Bootstrap incorporates responsive CSS, which means your forms not only look and behave great in the latest desktop browser, but in tablet and smartphone browsers as well.

## System Requirements

PHP 5 >= 5.3

## Installation Instructions

Before writing any code, you'll first need to download the latest version of PFBC and upload the PFBC directory within the document root of your web server. The other files/directories outside of the PFBC folder that are included in the download are provided only for instruction and can be omitted from your production environment.

## Examples/Tutorials

The links provided below are meant to demonstrate the key features included in the project. Currently, these links are using the pfbc3.0-php5 release, please see the examples included with the project for PHP 5.3 namespaced examples.

* [Form Elements](http://www.imavex.com/pfbc3.x-php5/examples/form-elements.php)
* [HTML5](http://www.imavex.com/pfbc3.x-php5/examples/html5.php)
* [Views](http://www.imavex.com/pfbc3.x-php5/examples/views.php)
* [Validation](http://www.imavex.com/pfbc3.x-php5/examples/validation.php)
* [Ajax](http://www.imavex.com/pfbc2.x-php5/examples/ajax.php)

## Code Samples

```php
<?php
//PFBC 3.x PHP 5 >= 5.3
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/PFBC/Form.php");
$form = new PFBC\Form("GettingStarted");
$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyTextbox"));
$form->addElement(new PFBC\Element\Select("My Select:", "MySelect", array(
   "Option #1",
   "Option #2",
   "Option #3"
)));
$form->addElement(new PFBC\Element\Button);
$form->render();

//PFBC 3.x PHP 5
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/PFBC/Form.php");
$form = new Form("GettingStarted");
$form->addElement(new Element_Textbox("My Textbox:", "MyTextbox"));
$form->addElement(new Element_Select("My Select:", "MySelect", array(
   "Option #1",
   "Option #2",
   "Option #3"
)));
$form->addElement(new Element_Button);
$form->render();
?>
```