<?php 
namespace ce_core\Exceptions;
use \Exception;

class AppException extends Exception
{
    /**
     * summary
     */
    public function __construct($message, $code=0)
    {
    	set_exception_handler([$this, 'errorHandle']);
        parent::__construct($message, $code);
    }

    public function errorHandle($e)
    {
    	echo 123;
    	echo "<pre>";
    	print_r($e);
    }
}