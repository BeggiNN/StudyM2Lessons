<?php

namespace Perspective\Access\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{
    protected $helperData;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Perspective\Access\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        echo $this->helperData->getGeneralConfig('enable') . "</br>";
        echo $this->helperData->getGeneralConfig('display_text');
        exit();

    }
}
