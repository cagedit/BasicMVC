<?php
namespace Core;
use \Core\GenericHelper;
use \Core\ErrorHandler;
class Router
{
	private $routes;

	public function __construct()
	{

	}

	public function addRoute($route, $return)
	{
		$this->routes[$route] = $return;
	}

	public function getRoute($location)
	{
		if (isset($this->routes[$route])) {
			return $this->routes[$location];
		}
	}
}