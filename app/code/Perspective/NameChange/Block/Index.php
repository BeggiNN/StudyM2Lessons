<?php

namespace Perspective\NameChange\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_helper;
    protected $_session;
    protected $_registry;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Perspective\NameChange\Helper\Data $helper,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_registry = $registry;
        $this->_session = $session;
        $this->_helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Get the end date of the sale
     * @return float|int
     */

    public function getSalesEnd()
    {
        $time = $this->_helper->getGeneralConfig('endDate');
        $nowTime = date('Y-m-d');
        $timeUnix = strtotime($time);
        $nowUnix = strtotime($nowTime);
        $endSales = abs($timeUnix - $nowUnix) / 86400;
        $enable_module = $this->_helper->getGeneralConfig("enable");
        if ($enable_module) {
            $id = $this->_helper->getGeneralConfig("multiSelect");
            $product = $this->_registry->registry('current_product');
            if ($product->canBeShowInCategory($id)) {
                if ($endSales <= 10) {
                    return $time;
                } else {
                    return "";
                }
            }
        }
        return "";
    }
}
