<?php
namespace Academy\EmailModule\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Academy\EmailModule\Helper\Email;
use Psr\Log\LoggerInterface;


class EmailPlugin
{
    private $Email;
    private $logger;

    public function __construct(
        Email $email,
        LoggerInterface $logger
    ) {
        $this->Email = $email;
        $this->logger = $logger;
    }
    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        $saveOptions = false
    )
    {
        $this->Email->sendEmail(
            $product->getSku(),
            $product->getName(),
            $product->getPrice()
        );
        $this->logger->info('Email sent by request');
    }
}
