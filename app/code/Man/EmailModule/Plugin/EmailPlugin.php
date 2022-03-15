<?php
namespace Man\EmailModule\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Man\EmailModule\Helper\Email;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;


class EmailPlugin
{
    private $Email;
    private $logger;
    private $scopeConfig;

    public function __construct(
        Email $email,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->Email = $email;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
    }
    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        $saveOptions = false
    )
    {
        if ($this->scopeConfig->isSetFlag(
            'product/email/emailOnCreation',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            $this->Email->sendEmail(
                $product->getSku(),
                $product->getName(),
                $product->getPrice()
            );
        }
        $this->logger->info('Email sent by request');
    }
}
