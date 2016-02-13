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
		if (file_exists($this->filepath)) 
		{
			$this->performIndexing();
		}
		else
			exit("Couldn't find the file!\n");
	}

	private function performIndexing()
	{
		$contents = (string) file_get_contents($this->filepath);		
		$dom = new \DOMWrap\Document();
		$dom->html($contents);
		$nodes = $dom->find('div.book');
		$entities_array = [];

		foreach ($nodes as $key => $node) 
		{			
			$title = $node->find('h3')->first();
			$verses = $node->find('p');

			if (isset($title->nodeValue)) 
			{
				$entities_array['title_' . $key] = $title->nodeValue;

				foreach ($verses as $index => $verse) 
				{
					if (isset($verse->nodeValue)) 
					{
						$entities_array['verse_' . $key . '_' . $index] = $verse;						
					}					
				}

			}


		}

		var_dump($entities_array);
		exit;		

	}
}