<?php


namespace Perspective\AddCustomPrice\Observer;

use Magento\Framework\Event\Observer;

class HandleSaveProduct implements \Magento\Framework\Event\ObserverInterface
{
    protected $request;
    protected $_productRepository;
    protected $_helper;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Perspective\AddCustomPrice\Helper\Data $_helper
    ) {
        $this->request = $request;
        $this->_productRepository = $productRepository;
        $this->_helper = $_helper;
    }

    public function execute(Observer $observer)
    {
        $arr = $this->request->getParam('product');
        $id = $this->request->getParam('id');
        $product = $this->_productRepository->getById($id);
        if (!empty($arr)){
            $enable = $arr['allow_modify'];
            if ($enable == '0'){
                $attr = $observer->getData('product');
                $productPrice = $product->getPrice();
                $percent = $this->_helper->getPercent();
                $price = $productPrice + $productPrice * ($percent / 100);
                $attr->setData('custom_price', $price);
            }
        }
    }
}
