<?php

namespace IndexerBundle\Service;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use EntityBundle\Entity\Book;
use EntityBundle\Entity\Chapter;
use EntityBundle\Entity\Verse;

class IndexBible
{	
	private $container;
	private $filepath;

	public function __construct(Container $container) {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
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

		foreach ($spreadsheet->getWorkSheetIterator() as $worksheet) 
		{
			$entity = [];
			$entity['title'] = $worksheet->getTitle();
			$entity['chapters'] = [];

			echo "Indexing " . $entity['title'] . "\n";

			foreach ($worksheet->getRowIterator() as $row) 
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

			$book = new Book();			
			$book->setName($entity['title']);

			foreach ($entity['chapters'] as $index => $chapter) 
			{
				$obj_chapter = new Chapter();
				$obj_chapter->setBook($book);
				$obj_chapter->setNumber($index);
				$book->addChapter($obj_chapter);

				foreach ($chapter as $key => $verse) 
				{
					$obj_verse = new Verse();
					$obj_verse->setChapter($obj_chapter);
					$obj_verse->setNumber($key);
					$obj_verse->setContent($verse);
					$obj_chapter->addVerse($obj_verse);
					$this->persist($obj_verse);
				}
				$this->persist($obj_chapter);
			}
			$this->persist($book);

			$this->em->flush();
    		$this->em->clear();
		}	

		echo "Done indexing\n";

	}

	private function persist($entity)
	{
		$this->em->persist($entity);    	
	}
}