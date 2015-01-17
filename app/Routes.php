<?php
use Core\Router;
Router::get('/', function() {
	return 'asdfasdfasddfasd';
});

Router::get('/test/{id}', function($id) {
	return 'The ID is ' . $id;
});

Router::get('/{something}/test', function($something) {
	return $something;
});

Router::get('/{something}/bind', 'TestController@index');

Router::post('/{something}/bind', 'TestController@submit');