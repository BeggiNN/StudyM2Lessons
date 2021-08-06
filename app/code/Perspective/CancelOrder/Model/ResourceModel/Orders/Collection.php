<?php

namespace Perspective\CancelOrder\Model\ResourceModel\Orders;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'cancel_order';
    protected $_eventObject = 'orders_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Perspective\CancelOrder\Model\Orders::class,
            \Perspective\CancelOrder\Model\ResourceModel\Orders::class
        );
    }
}
