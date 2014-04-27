<?php

/**
 * use https://github.com/panique/php-mvc bootstrap
 * HFGL application website
 *
 * @package hfgl
 * @author HAMDANE Yasmine, GUEMOURI Aiman, SALMON Thomas, NGUYEN Thi Quynh Nga, CHEVALIER Josian, VLADISLAV Fitc
 * @link http://moule.informatique.univ-paris-diderot.fr:8080/groups/afk-lol
 * @link http://tsalmon.fr/gl
 * @link https://github.com/tsalmon/HFGL
 * @license http://opensource.org/licenses/MIT MIT License
 */

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("<p>Sorry, HFGL doesn't run on a PHP version < 5.3.7<p>");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    //require_once("application/libraries/password_compatibility_library.php");
}

if(!file_exists(getcwd().'/files') && !mkdir(getcwd().'/files')){
	exit("Error: can't create repository");
}

// load the (optional) Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application config (error reporting etc.)
require 'application/config/config.php';


//load application class
require 'application/libs/application.php';
require 'application/libs/controller.php';
//$app = new Application();
?>