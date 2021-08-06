<?php


namespace Perspective\CancelOrder\Model;

class Orders extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'cancel_order';

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
        $this->_init(\Perspective\CancelOrder\Model\ResourceModel\Orders::class);
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
