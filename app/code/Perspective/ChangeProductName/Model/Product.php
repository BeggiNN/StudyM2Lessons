<?php

namespace Perspective\ChangeProductName\Model;

class Product extends \Magento\Catalog\Model\Product {
    public function getName()
    {
        $name = parent::getName();
        $price = $this->getData('price');
            if ($price < 60) {
                $name .= "Custom text 1";
            }else {
                $name .= "Custom text 2";
            }
        return $name;
    }
}
