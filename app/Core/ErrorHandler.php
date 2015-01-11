<?php
namespace Core;
use \Core\Redirect;

class ErrorHandler
{
	public function throwPageNotFound()
	{
		Redirect::pageNotFound();
	}
}