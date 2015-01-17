<?php
namespace Core;
class GenericHelper
{
	private static $staticPath;

	public static function staticPath()
	{
		if(empty(self::$staticPath)) {
			self::$staticPath = realpath('../');
		}

		return self::$staticPath;
	}

	public static function appPathAppend($append)
	{
		$path = self::staticPath();
		$path = $path . '/app/' . $append;
		return $path;
	}
}