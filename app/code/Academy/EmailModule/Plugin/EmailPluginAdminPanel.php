<?php
namespace Academy\EmailModule\Plugin;

use Academy\EmailModule\Helper\Email;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Controller\Adminhtml\Product\Save;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;


class EmailPluginAdminPanel
{
    private $helperEmail;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Email $helperEmail,
        LoggerInterface $logger
    ) {
        $this->helperEmail = $helperEmail;
        $this->logger = $logger;;
    }
    public function beforeExecute(Save $subject, ProductRepositoryInterface $item = null,
    ProductInterface $product = null)
    {
        $this->helperEmail->sendEmail($product, $subject);
        $this->logger->info('Email sent by admin panel');
    }
}
