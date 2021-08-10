<?php

namespace Academy\CustomCommand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Partytip extends Command
{
    protected function configure()
    {
        $this->setName('party:shoppinglist');
        $this->setDescription('Demo command line');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello World\n");

        $output->writeln("All you need to have a great party is:\n");

        $array = ['cheap beer', 'warm vodka', 'old bread', 'stinky cheese'];

        foreach ($array as $item) {
            echo "$item\n";
        }


    }
}
