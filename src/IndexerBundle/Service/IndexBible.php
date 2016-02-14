<?php

namespace IndexerBundle\Service;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class IndexBible
{	
	private $container;
	private $filepath;

	public function __construct(Container $container) {
        $this->container = $container;
    }

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
		$spreadsheet = $this->container->get('phpexcel')->createPHPExcelObject($this->filepath);

		$worksheets = $spreadsheet->getWorkSheetIterator();

		$entity_array = [];

		foreach ($spreadsheet->getWorkSheetIterator() as $index => $worksheet) 
		{
			$entity = [];
			$entity['title'] = $worksheet->getTitle();
			$entity['chapters'] = [];

			foreach ($worksheet->getRowIterator() as $key => $row) 
			{
				$cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(true);
               	$cell_array = [];

                foreach ($cellIterator as $cell) 
                {
                    if (!is_null($cell)) 
                    {
                    	$cell_array[] = $cell->getCalculatedValue();
                    }
                }
                $chapter_verse = preg_replace("/[^\d:]*/", "", $cell_array[0]);
                $chapter_verse_array = preg_split("/:/", $chapter_verse);
                $chapter = $chapter_verse_array[0];
                $verse_number = $chapter_verse_array[1];

                $entity['chapters'][(int) $chapter][(int) $verse_number] = $cell_array[1];

			}
				var_dump($entity);
                exit;
		}	

	}
}