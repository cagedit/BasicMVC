<?php
use \Core\View;

function view($path, $vars = null)
{
	$view = new \Core\View($path, $vars);
	return $view;
}