<?php
namespace Academy\EmailModule\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $scopeConfig;
    protected $product;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);

        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->scopeConfig = $scopeConfig;
    }

    public function getEmails()
    {
        $this->logger->info('Get emails function fired');
        $emails = $this->scopeConfig->getValue(
            'product/email/emailList',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $emails;
    }

    public function sendEmail($product, $subject)
    {

        try {
            $existingProduct = $product->getSku();

            $newName = $product->getName();
            $newPrice = $product->getPrice();

            $desiredProduct = $subject->get($existingProduct);

            $oldPrice = $desiredProduct->getPrice();
            $oldName = $desiredProduct->getName();

            $exist = true;

            $ExistTemp = [
                'templateVar'  => 'Existing product in database modified',
                'product' => 'Product ' . $oldName . ' modified.' . ' New name is ' . $newName,
                'price' => 'Now it costs ' . $newPrice  . ' old cost was ' . $oldPrice,

            ];
        } catch (NoSuchEntityException $e) {
            $newProductName = $product->getName();
            $newProductPrice = $product->getPrice();

            $exist = false;

            $NoExistTemop = [
                'templateVar'  => 'New product added to databse',
                'product' => 'Product ' . $newProductName . ' added to database.',
                'price' => 'It costs ' . $newProductPrice
            ];
        }

        $mails = $this->getEmails();
        $readyEmailList = explode(",", $mails);

        $exist ? $properTemplateVars = $ExistTemp : $properTemplateVars = $NoExistTemop;

        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Marcin Mańkowski'),
                'email' => $this->escaper->escapeHtml('marcin.mankowski@solteq.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('email_demo_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars($properTemplateVars)
                ->setFrom($sender)
                ->addTo($readyEmailList)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
