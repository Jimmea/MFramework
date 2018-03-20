<?php 
require_once (dirname(__FILE__) .'/../bootstrap/container.php');
$config = require_once(dirname(__FILE__) .'/../config/app.php');
$app = new App($config);
echo $app->run();
