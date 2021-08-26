<?php

namespace Academy\JsModule\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;

class ReturnJson implements ActionInterface
{

    private JsonFactory $resultJsonFactory;
    private RequestInterface $request;
    private EventManager $eventManager;

    public function __construct(JsonFactory      $resultJsonFactory,
                                Context          $context,
                                RequestInterface $request,
                                EventManager     $eventManager
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->eventManager = $eventManager;
    }

    public function execute()
    {
        $params = $this->request->getParams();

        $data = json_encode($params);

        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($data);

        $this->eventManager->dispatch('js_event', ['wantedData' => $params['data']]);

        return $resultJson;
    }
}
