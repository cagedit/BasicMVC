<?php
namespace Core;
class GenericHelper
{
	private static $staticPath;

	public function __construct()
	{

	}

	public static function staticPath()
	{
		if(empty(self::$staticPath)) {
			self::$staticPath = realpath('../');
		}

		return self::$staticPath;
	}
}