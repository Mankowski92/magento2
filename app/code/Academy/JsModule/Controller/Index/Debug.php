<?php

namespace Academy\JsModule\Controller\Index;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use \Psr\Log\LoggerInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Debug extends Action
{
    protected PageFactory $resultPageFactory;
    protected JsonFactory $resultJsonFactory;
    protected LoggerInterface $logger;
    private RequestInterface $request;
    private EventManager $eventManager;

    public function __construct(
        Context          $context,
        PageFactory      $resultPageFactory,
        JsonFactory      $resultJsonFactory,
        LoggerInterface  $logger,
        RequestInterface $request,
        EventManager     $eventManager
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->request = $request;
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $params = $this->request->getParams();

        $params ? $dataFromParams = $params['data'] : $dataFromParams = '';

        $data = json_encode($params);

        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($data);

        $this->eventManager->dispatch('js_event', ['wantedData' => $dataFromParams]);

        return $resultJson;
    }
}
