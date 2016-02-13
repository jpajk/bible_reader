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
                'filepath',
                InputArgument::OPTIONAL,
                'Provide the filepath for indexing.'
            )
            ->addArgument(
                'plugin',
                InputArgument::OPTIONAL,
                'Provide the plugin that will handle the indexing.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filepath = $input->getArgument('filepath');
        $plugin = $input->getArgument('plugin');
        
        $output->writeln($filepath . '' . $plugin);
        
    }
}

