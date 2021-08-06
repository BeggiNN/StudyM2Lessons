<?php


namespace Perspective\AddCustomPrice\Plugin;

use Magento\Catalog\Model\ProductRepository;

class Product
{
    protected $product;

    protected $_productCollectionFactory;

    protected $_request;

    protected $_helper;

    public function __construct(
        \Perspective\AddCustomPrice\Helper\Data $_helper,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        ProductRepository $product
    ) {
        $this->_request = $request;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_helper = $_helper;
        $this->product = $product;
    }

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $enable = boolval($this->_helper->getGeneralConfig('enable'));
        if ($enable) {
            $page = $this->_request->getFullActionName();
            if ($page == 'catalog_category_view') {
                $customPrice = $subject->getCustomPrice();
                if (!empty($customPrice)) {
                    $result = $customPrice;
                    return $result;
                } else {
                    return $result;
                }
            } else {
                return $result;
            }
        }
        return $result;
    }
}
