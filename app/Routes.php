<?php
use Core\Router;
Router::addRoute('/', function() {
	return 'test';
});