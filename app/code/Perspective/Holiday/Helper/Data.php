<?php

namespace Perspective\Holiday\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_HOLIDAY = 'holidaySection/';

    /**
     * @var \Perspective\Holiday\Model\HolidayFactory
   price  */
    protected $_model;

    protected $_view;

    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Perspective\Holiday\Model\HolidayFactory $model,
        \Magento\Catalog\Block\Product\View\AbstractView $view,
        Context $context
    ) {
        $this->_model = $model;
        $this->_view = $view;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        $value = $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return $value;
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HOLIDAY . 'general/' . $code, $storeId);
    }

    /**
     * Get holidays id.
     * @param $id
     * @return \Perspective\Holiday\Model\Holiday
     */
    public function getById($id)
    {
        return $this->_model->create()->load($id);
    }

    /**
     * Get Atrribute.
     * @return int|mixed|null
     */
    public function getAttributes(){
        $product = $this->_view->getProduct();
        $attr = $product->getData('holiday');
        if ($attr == 1) {
            return $attr;
        }else{
            return 0;
        }
    }
}
