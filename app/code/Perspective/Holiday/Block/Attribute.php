<?php


namespace Perspective\Holiday\Block;


use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class Attribute extends Template
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    private $product;

    public function __construct(Template\Context $context,
                                Registry $registry,
                                array $data = [])
    {
        $this->registry = $registry;

        parent::__construct($context, $data);
    }


    /**
     * @return Product
     */
    private function getProduct()
    {
            $this->product = $this->registry->registry('product');

        return $this->product;
    }

    public function getAttribute()
    {
        $product = $this->getData('product');
        $attr = $product->getData('holiday');
        return $attr;
    }

}
