<?php

namespace Perspective\QtyProduct\Block;

class Custom extends \Magento\Framework\View\Element\Template {

    protected $_helperData;
    protected $_productRepository;
    protected $_session;
    protected $_view;
    protected $_stockItemRepository;
    protected $configurable;

    public function __construct(
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\Catalog\Block\Product\View\AbstractView $view,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Perspective\QtyProduct\Helper\Data $helperData,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    )
    {
        $this->configurable = $configurable;
        $this->_stockItemRepository = $stockItemRepository;
        $this->_view = $view;
        $this->_productRepository = $productRepository;
        $this->_helperData = $helperData;
        parent::__construct($context, $data);
    }

    public function getInfoQty($vendor, $enable)
    {
        if ($this->getProduct())
        {
            $id = $this->getProduct()->getId();
            $arrays = $this->configurable->getChildrenIds($id);
            foreach ($arrays[0] as $item){
                $id = $item;
                break;
            }
            $qty = $this->_stockItemRepository->get($id)->getQty();
        }else
        {
            $id = $this->_view->getProduct()->getId();
            $arrays = $this->configurable->getChildrenIds($id);
            foreach ($arrays[0] as $item){
                $id = $item;
                break;
            }
            $qty = $this->_stockItemRepository->get($id)->getQty();
        }

        $value = $this->_helperData->getGeneralConfig($vendor);
        $enablem = $this->_helperData->getGeneralConfig($enable);
        return [$qty, $enablem, $value];
    }
}
