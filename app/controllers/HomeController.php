<?php
namespace app\controllers;

use ce_core\Controller;

/**
 * HomeController
 */
class HomeController extends FrontendController
{
    
    public function index()
    {
        $viewData = [
            'name' => 'hung',
            'age' => 20
        ];
        
    	$this->renderView('/about', $viewData);
    }

    public function about()
    {
    	$viewData = [
            'name' => 'hung',
            'age' => 20
        ];

    	$this->renderView('about', $viewData);
    }

    public function product()
    {
        $this->renderView('product');
    }
}