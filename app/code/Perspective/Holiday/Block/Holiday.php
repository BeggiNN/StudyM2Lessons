<?php

namespace Perspective\Holiday\Block;

class Holiday extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Perspective\Holiday\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Perspective\Holiday\Model\HolidayFactory
     */
    protected $_model;

    /**
     * @var \Magento\Catalog\Block\Product\View\AbstractView
     */
    protected $_view;

    protected $productRepository;

    public function __construct(
        \Perspective\Holiday\Helper\Data $helper,
        \Perspective\Holiday\Model\HolidayFactory $model,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Block\Product\View\AbstractView $view,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) {
        $this->_view = $view;
        $this->_helper = $helper;
        $this->_model = $model;
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get Holidays.
     * @return array|string
     */
    public function getHoliday()
    {
        $enable = $this->_helper->getGeneralConfig('enable');
        if ($enable) {
            $id = $this->_helper->getGeneralConfig('holidays');
            if ($id) {
                $id = str_replace(",", "", $id);
                $id = str_split($id);
                foreach ($id as $value) {
                    $holidays[$value] = $this->_helper->getById($value);
                }
                return [$holidays, true];
            }
        }
        return false;
    }

    /**
     * Get price product.
     * @return float
     */
    public function getPriceProduct(){
        $product = $this->_view->getProduct();
        $price = $product->getFinalPrice();
        return $price;
    }

    /**
     * Get Discount.
     * @return mixed
     */
    public function getPercent()
    {
        return $this->_helper->getGeneralConfig('discount');
    }

    /**
     * Get Atrribute.
     * @return int|mixed|null
     */
    public function getAttributes(){
       return $this->_helper->getAttributes();
    }
}
