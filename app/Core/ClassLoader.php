<?php
function __autoload($class)
{
	$class = str_replace('\\', '/', $class);
	$filePath = realpath('../app') . '/' . $class . '.php';

	if (file_exists($filePath)) {
		require_once($filePath);
	}
}
