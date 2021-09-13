<?php
namespace Academy\EmailModule\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;

use Magento\Catalog\Api\ProductRepositoryInterface;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $scopeConfig;
    protected $product;

    private ProductRepositoryInterface $productRepository;


    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);

        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
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

    public function sendEmail($sku, $name, $price)
    {
        try {
            $existingProduct = $this->productRepository->get($sku);

            $oldName = $existingProduct->getName($sku);
            $oldPrice = $existingProduct->getPrice($sku);

            $temp = [
                'templateVar'  => 'Existing product in database modified',
                'product' => 'Product ' . $oldName . ' modified.' . ' New name is ' . $name,
                'price' => 'Now it costs ' . $price  . ' old cost was ' . $oldPrice,
            ];

        } catch (NoSuchEntityException $e) {

            $temp = [
                'templateVar'  => 'New product added to databse',
                'product' => 'Product ' . $name . ' added to database.',
                'price' => 'It costs ' . $price
            ];
        }

        $mails = $this->getEmails();
        $readyEmailList = explode(",", $mails);

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
                ->setTemplateVars($temp)
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
