<?php

namespace Perspective\Holiday\Model\Config\Source;

class Custom implements \Magento\Framework\Option\ArrayInterface
{
    protected $_model;

    public function __construct(
        \Perspective\Holiday\Model\HolidayFactory $model
    ) {
        $this->_model = $model;
    }
    public function toOptionArray()
    {
        $holidays = $this->_model->create()->getCollection();
        $arr = $this->_toArray();
        $ret = [];

        foreach ($arr as $key => $value) {
            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $ret;
    }

    /**
     * Get holidays.
     * @return array
     */
    private function _toArray()
    {
        $holidays = $this->_model->create()->getCollection();
        foreach ($holidays as $items) {
            $holidaysList[$items->getId()] =$items->getName();
        }
        return $holidaysList;
    }
}
