<?php

namespace Perspective\ChangeProductName\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Product implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        // TODO: Implement execute() method.
        $collection = $observer->getEvent()->getData('collection');
        foreach ($collection as $product)
        {
            $price = $product->getData('price');
            $name = $product->getData('name');
            if ($price < 50){
                $name .= " Custom text 1";
            }
            else
            {
                $name .= " Custom text 2";
            }
        $product->setData('name', $name);
        }
    }
}
