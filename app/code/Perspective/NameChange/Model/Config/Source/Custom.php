<?php

namespace Perspective\NameChange\Model\Config\Source;

class Custom implements \Magento\Framework\Option\ArrayInterface
{
    protected $_categoryFactory;
    protected $_categoryCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }
    public function getCategoryCollection()
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        return $collection;
    }
    public function toOptionArray()
    {
        $arr = $this->_toArray();
        $ret = [];

        foreach ($arr as $key => $value) {
            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $ret;
    }

    private function _toArray()
    {
        $categories = $this->getCategoryCollection();

        $catagoryList = [];
        foreach ($categories as $category) {
            $catagoryList[$category->getEntityId()] = $category->getName() . " (ID: " . $category->getId() . ")";
        }

        return $catagoryList;
    }
}
