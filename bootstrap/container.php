<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(dirname(__FILE__)));
define('DS',DIRECTORY_SEPARATOR);

require_once(dirname(__FILE__) .'/../ce_core/App.php');
require_once ('../vendor/autoload.php');

 
$run     = new \Whoops\Run;
$handler = new \Whoops\Handler\PrettyPageHandler;
$JsonHandler = new \Whoops\Handler\JsonResponseHandler;
 
$run->pushHandler($JsonHandler);
$run->pushHandler($handler);
$run->register();