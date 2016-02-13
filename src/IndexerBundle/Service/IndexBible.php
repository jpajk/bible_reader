<?php

namespace IndexerBundle\Service;
use \DOMDocument;

class IndexBible
{	
	private $filepath;

	public function setFilePath($filepath)
	{
		$this->filepath = (string) $filepath;
	}	

	public function indexBook()
	{
		$exists = file_exists($this->filepath);
	
		if ($exists) 
		{
			$this->performIndexing();
		}
	}

	private function performIndexing()
	{
		$contents = (string) file_get_contents($this->filepath);		
		$dom = new \DOMWrap\Document();
		$dom->html($contents);
		$nodes = $dom->find('div.book');

		var_dump($nodes->first()->find('h3')[0]->nodeValue);

		exit;

	}
}