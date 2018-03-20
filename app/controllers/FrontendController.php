<?php
namespace app\controllers;
use ce_core\Controller;

class FrontendController extends Controller
{
	public function __construct()
	{	
		parent::__construct();
		$this->setLayoutMaster(\ce_core\Registry::getInstance()->config['layout_master']);
	}
}