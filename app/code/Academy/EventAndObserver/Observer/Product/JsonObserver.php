<?php

namespace Academy\EventAndObserver\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class JsonObserver implements ObserverInterface
{
    private ManagerInterface $messageManager;

    public function __construct(ManagerInterface $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    public function execute(Observer $observer)
    {
        $wantedData = $observer->getData('wantedData');

        $this->messageManager->addSuccessMessage($wantedData);
    }
}
