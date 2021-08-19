<?php

namespace Academy\ImportCommand\Console;

use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\CatalogImportExport\Model\Import\Proxy\Product\ResourceModel;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Validation\ValidationException;
use Magento\Inventory\Model\SourceItem;
use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\InventoryApi\Api\SourceItemsSaveInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{
    private const FILE = 'file';
    private const ADDDATA = 'addData';

    protected string $fileName = '';
    protected int $addData = 0;

    protected Reader $reader;
    protected File $file;
    protected Json $json;
    protected ProductFactory $productFactory;
    protected ResourceModel $resourceModel;
    protected State $state;
    protected StoreManagerInterface $storeManager;
    protected SourceItemsSaveInterface $sourceItemsSaveInterface;
    protected SourceItemInterfaceFactory $sourceItem;

    public function __construct(
        Json                       $json,
        Reader                     $reader,
        File                       $file,
        ProductFactory             $productFactory,
        State                      $state,
        StoreManagerInterface      $storeManager,
        ResourceModel              $resourceModel,
        SourceItemsSaveInterface   $sourceItemsSaveInterface,
        SourceItemInterfaceFactory $sourceItem
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
        $this->sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->sourceItem = $sourceItem;

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getOption(self::FILE);
        $addData = $input->getOption(self::ADDDATA);
        $moduleEtcPath = $this->reader->getModuleDir(
            \Magento\Framework\Module\Dir::MODULE_ETC_DIR,
            'Academy_ImportCommand'
        );
        $fullFileName = $moduleEtcPath . '/' . $fileName;
        $exist = ($this->file->isExists($fullFileName));

        if ($exist) {
            $fileContent = $this->file->fileGetContents($fullFileName);
        }

        try {
            $output->writeln("\n<info>You are looking for $fileName \n</info>");
            $output->writeln("Full path to file: $fullFileName\n");

            if ($this->file->isExists($fullFileName)) {
                $output->writeln("<comment>FILE EXIST\n</comment>");
                $output->writeln("<info>File content: \n </info>" . $fileContent);
            } else {
                $output->writeln('<error>FILE DOES NOT EXIST</error>');
                echo "\n";
            }

            if ($addData && $exist) {
                $output->writeln("<info>Adding products to database process starts\n</info>");
                $productData = $this->json->unserialize($fileContent);

                $this->createProduct($productData['allProducts']);
                $output->writeln("<info>Adding process done</info>\n");
            }
        } catch (FileSystemException $e) {
            $output->writeln('Error: ' . $e->getMessage());
        }

    }


    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    private function createProduct(array $productData)
    {
        $this->state->setAreaCode(Area::AREA_ADMINHTML);
        $this->storeManager->setCurrentStore($this->storeManager->getDefaultStoreView()->getWebsiteId());

        $sourceItems = [];

        foreach ($productData as $eachProduct) {
            $productName = $eachProduct['name'];
            $imagePath = '/var/www/html/pub/media/custom_products_images/' . $eachProduct['imagePath'];

            echo "Adding $productName...\n";

            $product = $this->productFactory->create();

            $product->setName($eachProduct['name'])
                ->setTypeId(Type::TYPE_SIMPLE)
                ->setAttributeSetId($eachProduct['attribute_set_id'])
                ->setSku($eachProduct['sku'])
                ->setVisibility($eachProduct['visibility'])
                ->setPrice($eachProduct['price'])
                ->setStatus($eachProduct['status'])
                ->addImageToMediaGallery($imagePath, ['image', 'small_image', 'thumbnail'], false, false)
                ->setWebsiteIds([1])
                ->setCategoryIds([3, 6])
                ->setCustomAttribute(
                    'awesome_level',
                    $eachProduct['option']
                );

            $this->resourceModel->save($product);

            $sourceItem = $this->sourceItem->create();
            $sourceItem->setSourceCode('default');
            $sourceItem->setQuantity(100);
            $sourceItem->setSku($eachProduct['sku']);
            $sourceItem->setStatus(SourceItemInterface::STATUS_IN_STOCK);
        }

        try {
            $this->sourceItemsSaveInterface->execute([$sourceItems]);
        } catch (CouldNotSaveException | InputException | ValidationException $e) {
            echo "Exception: " . $e->getMessage();
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
            self::ADDDATA,
            null,
            InputOption::VALUE_NONE,
            'addData'
        );
        parent::configure();

    }
}


