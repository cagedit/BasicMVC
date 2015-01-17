<?php
namespace Controllers;
use \Core\View;
use \Core\Functions;
use \Core\Request;
class TestController extends BaseController
{
	public function index($something)
	{
		return view('partials.test', ['something' => 'abcd123'])->get();
	}

	public function submit()
	{
		$request = Request::request();
		return view('partials.submitted')->withPost()->get();
	}
}