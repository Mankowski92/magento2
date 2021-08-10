<?php

namespace Academy\ImportCommand\Console;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Module\Dir\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{

    public const FILE_NAME_ARGUMENT = 'file';
    public const IMPORT_DIR = '/import/';
    const FILE = 'file';

    protected function configure()
    {
        $this->setName('import:importcommand');
        $this->setDescription('Test import from command line');
        $this->addOption(
            self::FILE,
            null,
            InputOption::VALUE_REQUIRED,
            'File'
        );

        parent::configure();
    }

    protected $reader;
    protected $file;
    protected $fileName = null;

    public function __construct(
        reader $reader,
        File   $file
    )
    {
        parent::__construct();
        $this->reader = $reader;
        $this->file = $file;
    }


    protected
    function execute(InputInterface $input, OutputInterface $output)
    {

//        DirectoryList::VAR_DIR

        try {
            $fileName = $input->getOption(self::FILE);

            $moduleEtcPath = $this->reader->getModuleDir(
                \Magento\Framework\Module\Dir::MODULE_ETC_DIR,
                'Academy_ImportCommand'
            );

            $fullFileName = $moduleEtcPath . '/' . $fileName;
            $output->writeln('<info>You are looking for ' . $fileName . '</info>');
            $output->writeln('Full path to file: ' . $moduleEtcPath . '/' . $fileName);
            if ($this->file->isExists($fullFileName)) {
                echo "FILE EXIST\n";
            } else {
                echo "FILE DOES NOT EXIST\n";
            }
        } catch (FileSystemException $e) {
            echo $e;
        }
    }
}
