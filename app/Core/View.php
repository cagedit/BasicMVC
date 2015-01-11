<?php
namespace Core;
use \Core\GenericHelper;
class View
{
	public static function make($path)
	{
		$path = self::getPath($path);

		if (file_exists($path)) {
			ob_start();
			require_once($path);
			return ob_get_clean();
		}
	}

	public static function getPath($view)
	{
		$path = str_replace('.', '/', $view) . '.php';
		$path = 'Views/' . $path;
		$path = GenericHelper::appPathAppend($path);

		return $path;
	}
}