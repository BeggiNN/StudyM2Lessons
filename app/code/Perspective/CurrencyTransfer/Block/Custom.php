<?php

namespace Perspective\CurrencyTransfer\Block;


class Custom extends \Magento\Framework\View\Element\Template {


    protected $_helperData;
    protected $_productRepository;
    protected $_session;
    protected $_view;
    public function __construct(
        \Magento\Catalog\Block\Product\View\AbstractView $view,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Perspective\CurrencyTransfer\Helper\Data $helperData,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    )
    {
        $this->_view = $view;
        $this->_productRepository = $productRepository;
        $this->_helperData = $helperData;
        parent::__construct($context, $data);
    }


    public function getInfoCourse($courseEnable, $course) {

        if ($this->getProduct()) {
            $price = $this->getProduct()->getFinalPrice();
        }else {
            $price = $this->_view->getProduct()->getFinalPrice();
        }

        $enable = $this->_helperData->getGeneralConfig($courseEnable);
        $value = $this->_helperData->getGeneralConfig($course);
        $value = str_replace(',', '.', $value);
        $value = (float)$value;
        $value *= $price;
        return [$enable, $value];
    }

}
