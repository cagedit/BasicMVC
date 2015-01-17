<?php
/**
 * Automatically load all of the classes that are namespaced correctly
 *
 * @param  string $class The name of the class (including namespace)
 */
function __autoload($class)
{
	$class = str_replace('\\', '/', $class);
	$filePath = realpath('../app') . '/' . $class . '.php';

	if (file_exists($filePath)) {
		require_once($filePath);
	}
}
