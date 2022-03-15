<?php
namespace Man\EmailModule\Plugin;

use Magento\Catalog\Controller\Adminhtml\Product\Save;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Man\EmailModule\Helper\Email;

class EmailPluginAdminPanel
{

    private ScopeConfigInterface $scopeConfig;
    private Email $Email;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Email $Email
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->Email = $Email;
    }

    public function beforeExecute(Save $subject)
    {
        $product = $subject->getRequest()->getPostValue()['product'];

        if ($this->scopeConfig->isSetFlag(
            'product/email/emailOnCreation',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            $this->Email->sendEmail(
                $product['sku'],
                $product['name'],
                $product['price']
            );
        }
    }

}
