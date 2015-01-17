<?php
namespace Core;

class Request
{
	private static $post;
	private static $request;
	private static $get;

	public static function get()
	{
		if (empty(self::$get)) {
			self::$get = $_GET;
		}
		return self::$get;
	}

	public static function post()
	{
		if (empty(self::$post)) {
			self::$post = $_POST;
		}
		return self::$post;
	}

	public static function request()
	{
		if (empty(self::$request)) {
			self::$request = $_REQUEST;
		}
		return self::$request;
	}
}
