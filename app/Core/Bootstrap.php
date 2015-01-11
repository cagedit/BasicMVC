<?php
namespace Core;
class Bootstrap
{

	public function __construct()
	{
		$loadOnly = ['ClassLoader'];
		$instantiate = ['Router', 'GenericHelper'];

		foreach ($loadOnly as $neededClass) {
			require_once($neededClass . '.php');
		}

		foreach ($instantiate as $neededClass) {
			require_once($neededClass. '.php');
			$class = '\Core\\' . $neededClass;
			new $class;
		}

		new \Controllers\TestController('test');
	}

}