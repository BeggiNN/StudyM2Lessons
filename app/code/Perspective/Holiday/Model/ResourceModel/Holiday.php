<?php

namespace Perspective\Holiday\Model\ResourceModel;

class Holiday extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('perspective_holiday_days', 'holiday_id');
    }

}

