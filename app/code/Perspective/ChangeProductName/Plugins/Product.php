<?php

namespace Perspective\ChangeProductName\Plugins;

class Product
{
    public function aftergetName(\Magento\Catalog\Model\Product $product, $name)
    {
        $price = $product->getData('price');
        if ($price < 50){
            $name .= " Custom text 1";
        }
        else
        {
            $name .= " Custom text 2";
        }
        return $name;
    }
}
