<?php

namespace Man\EventAndObserver\Observer\Product;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface;
use Magento\Quote\Model\Quote\Item;


class CustomPrice implements ObserverInterface
{
    protected Item $item;
    protected ManagerInterface $messageManager;

    public function __construct(Item $item, ManagerInterface $messageManager)
    {
        $this->item = $item;
        $this->messageManager = $messageManager;
    }

    public function execute(Observer $observer)
    {
        $this->messageManager->addWarningMessage('TEST MESSAGE');

        $item = $observer->getEvent()->getData('quote_item');
        $item->getParentItem() ? $item->getParentItem() : $item;


        $product = $item->getProduct();
        $price = $product->getPrice();
        $amount = $product->getQty();
        $newPrice = 9999;
        $newAmount = $amount * 20;


        $item->setCustomPrice($newPrice);
        $item->setQty($newAmount);
        $item->setOriginalCustomPrice($newPrice);
        $item->getProduct()->setIsSuperMode(true);
    }

}
