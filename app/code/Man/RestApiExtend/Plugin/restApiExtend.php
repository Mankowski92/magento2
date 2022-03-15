<?php

namespace Man\RestApiExtend\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class restApiExtend
{

    public function __construct()
    {
    }

    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        $saveOptions
    )
    {
        $product->setPrice(9999);
    }
}
