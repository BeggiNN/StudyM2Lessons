<?php


namespace Perspective\CancelOrder\Model\Config\Source;

class CustomerGroup implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $ret = [
            ['value' => 'General', 'label' => 'General'],
            ['value' => 'Retailer', 'label' => 'Retailer'],
            ['value' => 'Wholesale', 'label' => 'Wholesale'],
        ];
        return $ret;
    }
}
