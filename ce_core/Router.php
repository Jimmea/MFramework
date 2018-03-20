<?php 
class Router 
{
	private static $routers = [];
	private $config;

	public function __construct()
	{
		$this->config = ce_core\Registry::getInstance()->config;
	}
	/**
	 * Get uri on url
	 * @param void 
	 * @return string
	 */
	private function getRequestUrl()
	{
		$basePath = $this->config['base_path'];
		$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		$url = str_replace($basePath, '', $url);
		$url = ($url === '' || empty($url)) ? '/' : $url;
		return $url;
	}

	/**
	 * [getRequestMethod description]
	 * @return string
	 */
	private function getRequestMethod()
	{
		return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
	}

	private static function setRouter($method, $url, $callable)
	{
		self::$routers[] = [$method, $url, $callable];
	}

	public static function get($url, $callable)
	{
		self::setRouter('GET', $url, $callable);	
	}

	public static function post($url, $callable)
	{
		self::setRouter('POST', $url, $callable);	
	}

	public static function any($url, $callable)
	{
		self::setRouter('GET|POST', $url, $callable);	
	}

	private function map()
	{
		$params = [];
		$checkRoute = false;
		$requestUrl = $this->getRequestUrl();
		$requestMethod = $this->getRequestMethod();
		$routers = self::$routers;


		foreach ($routers as $route) 
		{
			list ($method,$url,$action) = $route;	
			if (strpos($method, $requestMethod) === FALSE) continue;
			
			if ($url === '*') 
			{
				$checkRoute = true;
			}
			elseif (strpos($url, '{') === FALSE) 
			{
				if (strcmp(strtolower($url), strtolower($requestUrl)) === 0) 
				{
					$checkRoute = true;
				}else 
				{
					continue;
				}			
			}
			elseif (strpos($url, '}') === FALSE) 
			{
				continue;
			}
			else
			{
				$routerParams = explode('/', $url);
				$requestParams = explode('/', $requestUrl);

				if (count($routerParams) !== count($requestParams)) {
					continue;
				}

				// Put array param to $params
				foreach ($routerParams as $indexKey => $rp) 
				{
					if (preg_match('/^{\w+}$/', $rp)) 
					{
						$params[] = $requestParams[$indexKey];		
					}	
				}
				$checkRoute = true;
			}


			if ($checkRoute === true) 
			{
				if (is_callable($action)) 
				{
					call_user_func_array($action, $params);
				}elseif (is_string($action)) 
				{
					$this->compileRouter($action, $params);	
				}	
				return;	
			}else
			{
				continue;
			}
		}
		return;
	}
	
	private function compileRouter($action, $params)
	{
		$classNameMethod = explode('@', $action);
		if (count($classNameMethod) != 2) 
		{
			throw new Exception('Router error');
		}
		
		$className = $classNameMethod[0];
		$methodName = $classNameMethod[1];
		$classNameNamespace = 'app\\controllers\\'.$className;

		$object = new $classNameNamespace();
		if (!class_exists($classNameNamespace)) 
		{
			throw new Exception('Class not found');	
		}


		if (!method_exists($classNameNamespace,$methodName)) 
		{
			throw new Exception('Method '.methodName . ' not exist');		
		}

		// Call to controller
		ce_core\Registry::getInstance()->controller = $className;
		ce_core\Registry::getInstance()->method = $methodName;
		call_user_func_array([$object, $methodName], $params);
	}

	public function run()
	{
		$this->map();	
	}
}