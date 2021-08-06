<?php

namespace Perspective\Holiday\Model\ResourceModel\Holiday;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'holiday_id';
    protected $_eventPrefix = 'perspective_holiday_days';
    protected $_eventObject = 'holiday_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Perspective\Holiday\Model\Holiday::class,
            \Perspective\Holiday\Model\ResourceModel\Holiday::class);
    }
}

