<?php

namespace Perspective\Prices\Block;

use Exception;
use Magento\Catalog\Api\SpecialPriceStorageInterface;
use Magento\Catalog\Api\TierPriceStorageInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class Price extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;
    protected $_view;
    protected $_rulePriceFactory;
    protected $_tierPrice;
    protected $_specialPrice;
    protected $_helper;
    protected $_configurable;

    public function __construct(
        Configurable $configurable,
        TierPriceStorageInterface $tierPrice,
        SpecialPriceStorageInterface $specialPrice,
        // \Magento\Catalog\Pricing\Price\BasePrice $basePrice,
        \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory $rule,
        \Magento\Catalog\Block\Product\View\AbstractView $view,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Backend\Block\Template\Context $context,
        \Perspective\Prices\Helper\Data $helper,
        array $data = []
    ) {
        $this->_configurable = $configurable;
        $this->_specialPrice = $specialPrice;
        $this->_tierPrice = $tierPrice;
        $this->_rulePriceFactory = $rule;
        $this->_view = $view;
        $this->_productRepository = $productRepository;
        $this->_helper = $helper;
        parent::__construct($context, $data);
    }

    public function getPrices()
    {
        $product = $this->_view->getProduct();
        $sku = $product->getSku();
        $id = $product->getId();
        $i = 0;
        if ($product->getTypeId() == "bundle") {
            $final_price = $product->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
            $base_price = $product->getPriceInfo()->getPrice('regular_price')->getMinimalPrice()->getValue();
            $special_price = ($product->getSpecialPrice()) ? $product->getSpecialPrice() : "-";
            $i++;
        } else {
            if ($product->canConfigure()) {
                $maxValue = 999;
                $base_price = $product->getPriceInfo()->getPrice('regular_price')->getValue();
                $arr_ids = $this->_configurable->getChildrenIds($id)[0];
                foreach ($arr_ids as $value) {
                    $skuChild = $this->_productRepository->getById($value)->getSku();
                    $check = $this->_specialPrice->get([$skuChild]);
                    if (!empty($check)) {
                        $special_price = $check[0]->getPrice();
                        if ($special_price < $maxValue && $special_price != null) {
                            $maxValue = $special_price;
                            $nameChild = $skuChild;
                            $childId = true;
                        }
                    }
                }
                if (!empty($special_price)) {
                    $special_price = $maxValue;
                } else {
                    $special_price = "-";
                }
                $final_price = ($product->getFinalPrice()) ? $product->getFinalPrice() : "-";
                $i++;
            }
        }
        if ($i == 0) {
            $final_price = ($product->getFinalPrice()) ? $product->getFinalPrice() : "-";
            $base_price = ($product->getPrice()) ? $product->getPrice() : "-";
            $special_price = ($product->getSpecialPrice()) ? $product->getSpecialPrice() : "-";
        }
        if ($tier_price_discount = $this->_tierPrice->get([$sku])) {
            $tier_price_discount = $this->_tierPrice->get([$sku])[0]->getData('price');
            $tier_price = $base_price * ((100 - $tier_price_discount) / 100);
        } else {
            $tier_price = "-";
        }
        $catalogRule = null;

        try {
            $ruleName = 'Ruleee';
            $catalogRule = $this->_rulePriceFactory->create()
                ->addFieldToFilter('name', $ruleName)->getData();
            $is_active = $catalogRule[0]['is_active'];
            $discount_amount = $catalogRule[0]['discount_amount'];
            if ($is_active) {
                $catalog_rule_price = $base_price * ((100 - $discount_amount) / 100);
            }
        } catch (Exception $exception) {
            $catalog_rule_price = "-";
        }
        if (isset($childId)) {
            $special_priceId = 999;
            $arr = [$base_price, $tier_price, $catalog_rule_price];
            foreach ($arr as $value) {
                if ($value != "-" && $special_priceId > $value) {
                    $special_priceId = $value;
                }
            }
            return [$base_price, $final_price, $special_price, $tier_price, $catalog_rule_price, $nameChild, $special_priceId];
        } else {
            return [$base_price, $final_price, $special_price, $tier_price, $catalog_rule_price];
        }
    }
    public function getSettingsArray(){

        $enable_module= $this->_helper->getGeneralConfig("enable");
        $base_price_enable = $this->_helper->getGeneralConfig("base_price");
        $final_price_enable = $this->_helper->getGeneralConfig("final_price");
        $special_price_enable = $this->_helper->getGeneralConfig("special_price");
        $tier_price_enable = $this->_helper->getGeneralConfig("tier_price");
        $catalog_price_enable = $this->_helper->getGeneralConfig("catalog_rule_price");

        return [$enable_module, $base_price_enable, $final_price_enable, $special_price_enable, $tier_price_enable, $catalog_price_enable];
    }
}
