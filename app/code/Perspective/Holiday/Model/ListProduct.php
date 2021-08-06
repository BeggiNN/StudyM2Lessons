<?php

namespace Perspective\Holiday\Model;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    protected $_helperData;
    public function __construct(\Perspective\Holiday\Helper\Data $helperData, Context $context, PostHelper $postDataHelper, Resolver $layerResolver, CategoryRepositoryInterface $categoryRepository, Data $urlHelper, array $data = [])
    {
        $this->_helperData = $helperData;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    public function getProductDetailsHtml(\Magento\Catalog\Model\Product $product)
    {
        $html = $this->getLayout()->createBlock('Perspective\Holiday\Block\Attribute')->setProduct($product)->setTemplate('Perspective_Holiday::attribute.phtml')->toHtml();
        $renderer = $this->getDetailsRenderer($product->getTypeId());
        if ($renderer) {
            $renderer->setProduct($product);
            return $html.$renderer->toHtml();
        }
        return '';
    }

}
