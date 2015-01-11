<?php
namespace Controllers;
class TestController extends BaseController
{
	public function __construct()
	{
		return \Core\View::make('Sub.file');
	}
}