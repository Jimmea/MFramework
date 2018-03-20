<?php 
namespace ce_core;
/**
 * summary
 */
class Registry
{
    private static $instance;
    private $storage;
    public function __construct(){}

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __set($name, $value)
    {
        if (!isset($this->storage[$name])) 
        {
            $this->storage[$name] = $value;    
        }else
        {
        	throw new \Exception("Can not set \"$value\" to \"$name\". $name already exists");
        }
    }

    public function __get($name)
    {   
        if (array_key_exists($name, $this->storage)) 
        {
            return $this->storage[$name];
        }
       return null;
    }
}
