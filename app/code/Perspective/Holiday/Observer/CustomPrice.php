<?php


namespace Perspective\Holiday\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class CustomPrice implements ObserverInterface
{

    /**
     * @var \Perspective\Holiday\Helper\Data
     */
    protected $_helper;

    protected $block;

    public function __construct(
        \Perspective\Holiday\Helper\Data $helper,
        \Perspective\Holiday\Block\Holiday $block
    )
    {
        $this->_helper = $helper;
        $this->block = $block;
    }

    public function execute(Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);
        $discount = $this->_helper->getGeneralConfig('discount');
        $double = $discount / 2;
        $price = $item->getPrice();
        $attr = $item->getData('product');
        $attribute = $attr->getData('holiday');
        $holidays = $this->block->getHoliday();
        if ($attribute == 1) {
            if ($holidays[1]) {
                foreach ($holidays[0] as $holiday) {
                    $status = $holiday->getStatus();
                    if ($status != 2) {
                        $today = date("Y-m-d");
                        $finish = $holiday->getFinish();
                        $day = $holiday->getDay();
                        $start = $holiday->getStart();
                        if ($start <= $today && $finish >= $today) {
                            if ($start <= $today && $day >= $today) {
                                $customPrice = $price * ((100 - $discount) / 100);
                                $item->setCustomPrice($customPrice);
                                $item->setOriginalCustomPrice($customPrice);
                                $item->getProduct()->setIsSuperMode(true);
                                break;
                            } elseif ($day <= $today && $finish >= $today) {
                                $customPrice = $price * ((100 - $double) / 100);
                                $item->setCustomPrice($customPrice);
                                $item->setOriginalCustomPrice($customPrice);
                                $item->getProduct()->setIsSuperMode(true);
                                break;
                            }
                        }
                    }
                }
            }
        }else{
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            $item->getProduct()->setIsSuperMode(true);
        }
    }
}
