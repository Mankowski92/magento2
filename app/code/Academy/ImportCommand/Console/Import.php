<?php

namespace Academy\ImportCommand\Console;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{
    const FILE = 'file';
    const SERIALIZED = 'serialized';
    const VALUE = 'value';


    protected $reader;
    protected $file;
    protected $json;
    protected $fileName = null;
    protected $serialized = null;
    protected $value = null;
    protected $productFactory;
    protected $resourceModel;

    protected $state;
    protected $storeManager;

    public function __construct(
        Json                                         $json,
        Reader                                       $reader,
        File                                         $file,
        ProductFactory                               $productFactory,
        State                                        $state,
        \Magento\Store\Model\StoreManagerInterface   $storeManager,
        \Magento\Catalog\Model\ResourceModel\Product $resourceModel

    )
    {
        parent::__construct();
        $this->reader = $reader;
        $this->file = $file;
        $this->json = $json;
        $this->state = $state;
        $this->storeManager = $storeManager;
        $this->productFactory = $productFactory;
        $this->resourceModel = $resourceModel;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->state->setAreaCode(Area::AREA_ADMINHTML);
        $this->storeManager->setCurrentStore($this->storeManager->getDefaultStoreView()->getWebsiteId());

        $product = $this->productFactory->create();
        $test = $this->resourceModel->save($product);

        try {
            $test = 'DUPA DUPA';
            $fileName = $input->getOption(self::FILE);
            $serialized = $input->getOption(self::SERIALIZED);
            $value = $input->getOption(self::VALUE);
            echo $test;


            $moduleEtcPath = $this->reader->getModuleDir(
                \Magento\Framework\Module\Dir::MODULE_ETC_DIR,
                'Academy_ImportCommand'
            );

            $fullFileName = $moduleEtcPath . '/' . $fileName;
            $fileContent = $this->file->fileGetContents($fullFileName);
            $unserializedData = $this->json->unserialize($fileContent);

            $output->writeln("\n<info>You are looking for $fileName \n</info>");
            $output->writeln("Full path to file: $fullFileName\n");
            $output->writeln("$test");

            if ($this->file->isExists($fullFileName)) {
                $output->writeln("<comment>FILE EXIST\n</comment>");
                $output->writeln("<info>File content: \n </info>" . $fileContent);
            } else {
                $output->writeln('<error>FILE DOES NOT EXIST</error>');
            }

            if ($serialized) {
                $output->writeln("<info>Unserialized data: </info>");

                var_dump($unserializedData) . "\n";
            } else {
                $output->writeln("<info>Put flag '--serialized true' to see unserialized content\n </info> ");
            }

            $keys_array = array_keys($unserializedData['product']);
            $isExisting = (in_array("$value", $keys_array));

            if ($value && $isExisting) {
                $unserializedData = $this->json->unserialize($fileContent);
                $output->writeln("\nvalue of $value is " . $unserializedData['product']["$value"]);
            } else {
                $output->writeln("<error>\nThere is no key $value. Please try one of:</error>\n");
                foreach ($keys_array as $item) {
                    echo "$item \n";
                }
                echo "\n";
            }
        } catch (FileSystemException $e) {
            echo $e;
        }
    }

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
        $this->addOption(
            self::SERIALIZED,
            null,
            InputOption::VALUE_NONE,
            'Serialized'
        );
        $this->addOption(
            self::VALUE,
            null,
            InputOption::VALUE_OPTIONAL,
            'Value'
        );
        parent::configure();
    }
}
