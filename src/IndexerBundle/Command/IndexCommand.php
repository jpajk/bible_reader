<?php

namespace IndexerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class IndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('index:book')
            ->setDescription('Index the book according to the required plugin')
            ->addArgument(
                'plugin',
                InputArgument::OPTIONAL,
                'Provide the plugin that will handle the indexing.'
            )
            ->addArgument(
                'filepath',
                InputArgument::OPTIONAL,
                'Provide the filepath for indexing.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = [
                'plugin' => $input->getArgument('plugin'),
                'filepath' => $input->getArgument('filepath'),
            ];                

        /** This will probably will change if we add more book indexers. */
        if ($params['plugin'] == 'bible') 
        {            
            $this->dispatchBibleIndexing($params);
        }
        else 
            exit("Couldn't find the plugin!\n");        
    }

    private function dispatchBibleIndexing(array $params)
    {
        $indexer = $this->getContainer()->get('indexer.indexbible');
        $indexer->setFilePath($params['filepath']);
        $indexer->indexBook();
    }
}

