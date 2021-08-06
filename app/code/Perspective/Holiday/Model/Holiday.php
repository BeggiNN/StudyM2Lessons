<?php

namespace Perspective\Holiday\Model;

class Holiday extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Holiday cache tag
     */
    const CACHE_TAG = 'perspective_holiday_days';

    /**
     * Holidays statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    /**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Perspective\Holiday\Model\ResourceModel\Holiday::class);
    }

    /**
     * Prepare block's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
