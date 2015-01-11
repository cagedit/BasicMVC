<?php
namespace Core;
class Bootstrap
{

	/**
	 * Constructor
	 *
	 * Load all the Core files required in order for the application to run.
	 */
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

		new \Controllers\TestController;
	}

}