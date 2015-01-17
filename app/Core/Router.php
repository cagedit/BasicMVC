<?php
namespace Core;
class Router
{
	private static $getRoutes  = [];
	private static $postRoutes = [];
	private static $hasPost;
	private static $dynamicVars = [];

	/**
	 * Set a route that uses the GET method
	 * @param  string $route  The route to set
	 * @param  mixed  $output Either the callable function or route to controller@method
	 */
	public static function get($route, $output)
	{
		self::setRoute('get', $route, $output);

	}

	/**
	 * Set a route that uses the POST method
	 * @param  string $route  The route to set
	 * @param  mixed  $output Either the callable function or route to controller@method
	 */
	public static function post($route, $output)
	{
		self::setRoute('post', $route, $output);
	}

	/**
	 * Set the route provided by either post or get method
	 * @param  string         The method to route for
	 * @param  string $route  The route to set
	 * @param  mixed  $output Either the callable function or route to controller@method
	 */
	public static function setRoute($method, $route, $output)
	{
		// Removing first / makes it easier to route
		if (substr($route, 0, 1) == '/') {
			$route = substr($route, 1);
		}

		if (empty($route)) {
			$route = '/';
		}

		if ($method == 'get') {
			self::$getRoutes[$route] = $output;
		} elseif ($method == 'post') {
			self::$postRoutes[$route] = $output;
		}
	}

	/**
	 * Route to the correct view
	 */
	public static function route()
	{
		if (self::hasPost()) {
			$routes = self::$postRoutes;
		} else {
			$routes = self::$getRoutes;
		}

		$currentRoute = $_SERVER['REQUEST_URI'];

		$currentRoute = explode('?', $currentRoute);
		$currentRoute = $currentRoute[0];

		$currentRoute = explode('#', $currentRoute);
		$currentRoute = $currentRoute[0];

		$currentRoute = explode('/', $currentRoute);
		$currentRoute = array_filter($currentRoute);
		$currentRoute = array_values($currentRoute);

		if (empty($currentRoute)) {
			$currentRoute = $routes['/'];
		} else {
			$currentRoute = self::determineRoute($currentRoute, $routes);
		}

		self::execute($currentRoute, self::$dynamicVars);
	}

	/**
	 * Determine where to route the page
	 * @param  array $currentRoute   The URL in the browser
	 * @param  array $possibleRoutes All of the possible routes that exist
	 * @return mixed                 Either string route to controller@method or
	 *                               callable function containing view
	 */
	public static function determineRoute($currentRoute, $possibleRoutes)
	{
		$currentCount = count($currentRoute);

		foreach ($possibleRoutes as $location => $action) {
			$location = explode('/', $location);
			$location = array_filter($location);
			if ($currentCount !== count($location)) {
				continue;
			}

			$i = 0;
			foreach ($location as $directory) {
				$firstChar = $directory[0];
				$lastChar = $directory[strlen($directory) -1];
				$dynamicVar = $firstChar == '{' && $lastChar == '}';
				if ($dynamicVar) {
					self::$dynamicVars[$directory] = $currentRoute[$i];
				} elseif ($directory != $currentRoute[$i]) {
					continue 2;
				}
				++$i;

				if ($i == count($currentRoute)) {
					return $action;
				}
			}
		}

		return function(){};
	}

	public static function hasPost()
	{
		if (!isset(self::$hasPost)) {
			self::$hasPost = !empty($_POST);
		}
		return self::$hasPost;
	}

	public static function execute($routeAction, $vars = [])
	{
		if (is_callable($routeAction)) {
			$output = call_user_func_array($routeAction, $vars);
			echo $output;
		} elseif (is_string($routeAction) && strpos($routeAction, '@') !== false) {
			$controllerMethod = explode('@', $routeAction);
			$controller = '\\Controllers\\' . $controllerMethod[0];
			$method = $controllerMethod[1];

			if (method_exists($controller, $method)) {
				$controller = new $controller;
				$output = call_user_func_array([$controller, $method], $vars);
				echo $output;
			}
		}
	}
}