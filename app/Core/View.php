<?php
namespace Core;

use \Core\Request;
use \Core\TemplatingEngine;
use \Core\GenericHelper;

class View
{
	private $path;
	private $vars = [];

	/**
	 * Constructor
	 *
	 * Set the path and vars if provided
	 *
	 * @param string $path The path of the view
	 * @param array  $vars The variables to inject into the page
	 */
	public function __construct($path, $vars)
	{
		$path = $this->getPath($path);
		$this->path = $path;

		if (is_array($vars)) {
			$this->with($vars);
		}
	}

	/**
	 * Get the view that was built by constructor and other methods in this class
	 *
	 * @return string The output buffer of the echoed view
	 */
	public function get()
	{
		foreach ($this->vars as $name => $value) {
			$$name = $value;
		}

		if (file_exists($this->path)) {
			ob_start();
			require_once($this->path);
			$view = ob_get_clean();

			$view = $this->parseView($view);

			ob_start();
			echo $view;
			$view = ob_get_clean();

			return $view;
		}

	}

	/**
	 * Get the path of the view when given the view shorthand
	 *
	 * @param  string $view The shorthand path
	 * @return string       The converted real dir to the view
	 */
	public function getPath($view)
	{
		$path = str_replace('.', '/', $view) . '.php';
		$path = 'Views/' . $path;
		$path = GenericHelper::appPathAppend($path);

		return $path;
	}

	/**
	 * The place where you would do replacements before returning the view
	 * @param  string $view The full HTML of the view
	 * @return string       The parsed/replaced HTML
	 */
	public function parseView($view)
	{
		$parser = new \Core\TemplatingEngine($view);
		$view = $parser->getData();

		return $view;
	}

	/**
	 * Attach vars to the view that will be created
	 * @param  mixed  $first  Either the string value of a single variable name
	 *                        or an array of name => value combinations
	 * @param  mixed  $second Either the string value that should be set for this
	 *                        var or null if array was used in $first
	 * @return object         $this object
	 */
	public function with($first, $second = null)
	{
		if (is_array($first)) {
			$this->vars += $first;
		} elseif (is_string($first)) {
			$this->vars[$first] = $second;
		}
		return $this;
	}

	/**
	 * Attaches the post variables to the view
	 * @return object $this object
	 */
	public function withPost()
	{
		$post = \Core\Request::post();
		$this->with('post', $post);
		return $this;
	}
}