<?php


namespace Perspective\CancelOrder\Model\Config\Source;

class OrderStatus implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $ret = [
            ['value' => 'Pending', 'label' => 'Pending'],
            ['value' => 'Processing', 'label' => 'Processing'],
            ['value' => 'Suspected Fraud', 'label' => 'Suspected Fraud'],
        ];
        return $ret;
    }
}
