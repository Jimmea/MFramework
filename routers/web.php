<?php 
Router::get('/', 'HomeController@index');

Router::get('/about', 'HomeController@about');
Router::get('/product', 'HomeController@product');

Router::any('/*',function() {
	echo "Not found";
});