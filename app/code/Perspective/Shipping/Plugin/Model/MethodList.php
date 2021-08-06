<?php


namespace Perspective\Shipping\Plugin\Model;


class MethodList
{
    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function afterGetAvailableMethods(
        \Magento\Payment\Model\MethodList $subject,
        $availableMethods,
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        $shippingMethod = $this->getShippingMethodFromQuote($quote);
            foreach ($availableMethods as $key => $method) {
               if ($shippingMethod !== 'shipping_shipping') {
                   if (($method->getCode() == 'perspective_payment')) {
                       unset($availableMethods[$key]);
                   }
               }
        }
        return $availableMethods;



    }

    /**
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @return string
     */
    private function getShippingMethodFromQuote($quote)
    {
        if($quote) {
            return $quote->getShippingAddress()->getShippingMethod();
        }

        return '';
    }
}
