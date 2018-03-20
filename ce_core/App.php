<?php 
require_once(dirname(__FILE__).'/Autoload.php');
use ce_core\Registry;

class App
{
	private $router;

	public function __construct($config)
	{	
		new Autoload();
		Registry::getInstance()->config = $config;
		$this->router = new Router();
		
	}

	public function run()
	{
		return $this->router->run();
	}
}