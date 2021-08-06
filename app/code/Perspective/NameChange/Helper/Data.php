<?php
namespace Perspective\NameChange\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected $categoryFactory;
    protected $_view;

    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Block\Product\View\AbstractView $view,
        Context $context
    ) {
        $this->_view = $view;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    const XML_PATH_BASIC = 'multiSelectSection/';

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
        return $this->getConfigValue(self::XML_PATH_BASIC . 'general/' . $code, $storeId);
    }

    /**
     * Check the product in the category whether it is.
     * @param $product
     * @return string
     */
    public function getRow($product)
    {
        $enable_module = $this->getGeneralConfig("enable");
        if ($enable_module) {
            $id = $this->getGeneralConfig("multiSelect");
            if ($product->canBeShowInCategory($id)) {
                $collection = $this->categoryFactory->create()->load($id);
                $name = $collection->getName();
                $sku = $product->getSku();
                $type = $product->getTypeId();
                return $name . "_" . $id . "_" . $sku . "_  " . $type;
            }
        }
        return "";
    }
}
