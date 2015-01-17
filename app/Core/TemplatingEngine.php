<?php
namespace Core;

use View;
use Functions;

class TemplatingEngine
{
	private $data;

	public function __construct($data)
	{
		$this->data = $data;
		$this->methods = $this->getMethods();
		// If the very first method on the page is the extends command set it
		if (isset($this->methods[1][0]) && $this->methods[1][0] == 'extends') {
			$master = $this->methods[2][0];
			$subdata = $this->data;

			$this->data = view('master')->get();
		}
	}

	public function getData()
	{
		return $this->data;
	}

	/**
	 * Get an array of all of the @methods that are in the view
	 *
	 * Note this is called automatically by the constructor
	 * @return array All of the @methods
	 */
	public function getMethods()
	{
		preg_match_all("/@([a-z]{1,20})\(\'([a-z]{1,40})\'\)/mi", $this->data, $matches);
		return $matches;
	}

}