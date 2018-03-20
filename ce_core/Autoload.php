<?php 
class Autoload
{
	public function __construct()
	{
		spl_autoload_register(array($this, 'autoloadClass'));
		$this->autoloadFile();
	}

	private function autoloadClass($class)
	{
		$pathName = ROOT.DS.str_replace('\\', DS, $class) . '.php';
		if (is_readable($pathName)) 
			require_once($pathName);
		else
		{
			// throw new ce_core\Exceptions\AppException("$class not exists");
		}
	}

	private function defaulFileLoad()
	{
		return [
			'ce_core/Router.php',
			'routers/web.php',
		];	
	}

	private function autoloadFile()
	{
		foreach ($this->defaulFileLoad() as $file) 
		{
			require_once(ROOT.DS.$file);
		}
	}
}