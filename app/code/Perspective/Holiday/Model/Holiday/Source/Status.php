<?php

namespace Perspective\Holiday\Model\Holiday\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \Perspective\Holiday\Model\Holiday
     */
    protected $holiday;

    /**
     * Constructor
     *
     * @param \Perspective\Holiday\Model\Holiday $holiday
     */
    public function __construct(\Perspective\Holiday\Model\Holiday $holiday)
    {
        $this->holiday = $holiday;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->holiday->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
