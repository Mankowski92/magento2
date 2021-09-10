<?php
namespace Academy\EmailModule\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Academy\EmailModule\Helper\Email;
use Psr\Log\LoggerInterface;


class EmailPlugin
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
    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        $saveOptions
    )
    {
        $this->helperEmail->sendEmail($product, $subject);
    }
}
