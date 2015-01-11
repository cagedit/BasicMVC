<?php
namespace Core;

class Redirect
{
	public function pageNotFound()
	{
		return View::make('errors.404error');
	}
}