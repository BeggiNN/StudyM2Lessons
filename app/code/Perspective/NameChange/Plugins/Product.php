<?php

namespace Perspective\NameChange\Plugins;

use Perspective\NameChange\Helper\Data;

class Product
{
    protected $data;

    public function __construct(Data $data)
    {
        $this->data = $data;
    }
    public function afterGetName(\Magento\Catalog\Model\Product $product, $name) {
        $text = (string)$this->data->getRow($product);
        $name .= " " . $text ;
        return $name;
    }
}
