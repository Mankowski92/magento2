<?php

namespace Academy\TestPlugin\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;

class productRepositoryPlugin
{

    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beforeGetById(
        ProductRepositoryInterface $subject,
                                   $productId,
                                   $editMode = false,
                                   $storeId = null,
                                   $forceReload = false
    )
    {
        $this->logger->info('Before get product by ID ' . $productId);
        return [$productId, $editMode, $storeId, $forceReload];
    }
}

