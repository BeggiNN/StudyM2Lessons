<?php

namespace Perspective\UpdateCart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    public $productRepository;
    public function __construct(\Magento\Swatches\Helper\Data $swatchHelper, Context $context)
    {
        $this->swatchHelper = $swatchHelper;
        parent::__construct($context);
    }

    /**
     * Get hashcode by option Id
     *
     * @param $optionId
     * @return mixed
     */
    public function getCodeColor($optionId)
    {
        $hashcodeData = $this->swatchHelper->getSwatchesByOptionsId([$optionId]);
        return $hashcodeData[$optionId]['value'];
    }
}
