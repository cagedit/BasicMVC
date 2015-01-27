<?php
namespace Core;

use View;
use Functions;

class TemplatingEngine
{
	private $master;
	private $subFile;

	public function __construct($data)
	{
		$this->master = $data;

		// If the very first method on the page is the extends command set it
		if (isset($this->methods[1][0]) && $this->methods[1][0] == 'extends') {
			$master = $this->methods[2][0];
			$this->subFile = $this->master;

			$this->master = view('master')->get();
			$this->replaceSectionContent();
		}
	}

	public function getData()
	{
		return $this->master;
	}

	/**
	 * Replaces the yield commands in the master with the contents of that same
	 * section in the sub file
	 */
	public function replaceSectionContent()
	{
		if (empty($this->master) || empty($this->subFile)) {
			return;
		}

		preg_match_all("/@section\('([a-zA-Z0-9]{0,30})'\)([\s\S]*?)@endsection/im", $this->subFile, $sectionMatches);
		preg_match_all("/@yield\('([a-zA-Z0-9]{1,30})'\)/im", $this->master, $yieldMatches);

		if (empty($sectionMatches) || empty($yieldMatches)) {
			return;
		}

		foreach ($sectionMatches[1] as $index => $sectionName) {
			$content[$sectionName] = $sectionMatches[2][$index];
		}

		foreach ($yieldMatches[1] as $index => $matchName) {
			if (isset($content[$matchName])) {
				$this->master = str_replace($yieldMatches[0][$index], $content[$matchName], $this->master);
			} else {
				$this->master = str_replace($yieldMatches[0][$index], '', $this->master);
			}
		}
	}

}