<?php 
namespace ce_core;
use ce_core\Registry;
class Controller
{
    private $layout = null;
    private $config;

    public function __construct()
    {
        $this->config = Registry::getInstance()->config;
    }
	
	function redirect($url='', $isEnd= true, $responseCode = 302)
	{
		header("Location:".$url, true, $responseCode);
		if ($isEnd) exit();
	}

    public function setLayoutMaster($layout = null)
    {
        $this->layout = $layout;
    }

     /**
     * Get content view
     * @param  [type] $view [description]
     * @param  string|array $data [description]
     * @return [type]       [description]
     */
	public function renderView($view, $data=array())
	{
        $dirViewDefault = ROOT.$this->config['view_default'];
	    $content = $this->getViewContent($view, $dirViewDefault, $data);
    

        if ($this->layout) 
        {
            $layoutMaster = $dirViewDefault.'/layout/'. $this->layout;
            if (file_exists($layoutMaster)) 
            {
                require($layoutMaster);
            }   
        }else
        {
            throw new \Exception('Invalid layout master');
        }
	}

    public function include($view, $data = array())
    {
        $dirViewDefault = ROOT.$this->config['view_default'].DS;
        $viewPath   = $dirViewDefault.ltrim($view, '/').$this->config['view_extension'];
        $this->autoCreateFileView($dirViewDefault, $viewPath);
        
        //Phần này mai sau cho debug
        $data['view'] = str_replace(ROOT, '', $viewPath);
        if (is_array($data)) 
        {
            extract($data, EXTR_PREFIX_SAME, 'data');    
        }else
        {
            $data= $data;
        }
        require($viewPath);
    }

    /**
     * Get content view
     * @param  [type] $view [description]
     * @param  string|array $data [description]
     * @return [type]       [description]
     */
    private function getViewContent($view, $dirViewDefault, $data= array())
    {
        $controller = strtolower(Registry::getInstance()->controller);
        $folderView = str_replace('controller', '', $controller);
        $folderView = $dirViewDefault.DS.rtrim($folderView, '/').DS;
        $viewPath   = $folderView.ltrim($view, '/').$this->config['view_extension'];
        $this->autoCreateFileView($folderView, $viewPath);

        //Phần này mai sau cho debug
        $data['view'] = str_replace(ROOT, '', $viewPath);
        if (is_array($data)) 
        {
            extract($data, EXTR_PREFIX_SAME, 'data');    
        }
        else
        {
            $data= $data;
        }

        ob_start();
        require($viewPath);
        return ob_get_clean();
    }

    /**
     * Tạo tự động view cho người dùng tránh gây lãng phí time cho dev
     * @param  string $folderView
     * @param  string $viewPath  
     * @return void
     */
    private function autoCreateFileView($folderView, $viewPath)
    {
        // Automatically generate folder and file if it's not exists
        if (!file_exists($folderView)) mkdir($folderView, 0777);
        if (!file_exists($viewPath)) 
        {
            $myFileGenerate = fopen($viewPath, 'w') or die("can't open file");
            $syntaxFile = "<?php \n //Logic code view here \n";
            fwrite($myFileGenerate, $syntaxFile);
            fclose($myFileGenerate);
        }
    }    
}


