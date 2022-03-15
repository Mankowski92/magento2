<?php

namespace Man\EventAndObserver\Observer\Product;

use Psr\Log\LoggerInterface;
use Exception;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface;

class MyObserver implements ObserverInterface
{

    private ManagerInterface $messageManager;
    protected LoggerInterface $logger;


    public function __construct(
        ManagerInterface $messageManager,
        LoggerInterface $logger
    ) {
        $this->messageManager = $messageManager;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $this->logger->error('Observer execution start');

        $wantedData = $observer->getData('wantedData');

        function checkIfJson($string, $return_data = false)
        {
            $data = json_decode($string);

            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : true) : false;
        }

        $isJson = checkIfJson($wantedData);

        if ($isJson && $wantedData !== '') {
            $this->logger->error("Lets log your valid json data: $wantedData", [], []);
            $this->messageManager->addSuccessMessage("You have put this data: $wantedData");
        } else {
            $this->logger->error('User tried to log invalid data');
            $this->messageManager->addErrorMessage("Data $wantedData is not valid");
        }

        try {
            echo "echo from try \n";
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}

