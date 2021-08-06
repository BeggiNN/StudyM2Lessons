<?php

namespace Perspective\UiComponent\Model\Ui\Frontend\Checkout;

use Magento\Checkout\Model\CompositeConfigProvider;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class   ShippingOptionsConfigProvider implements ConfigProviderInterface
{
    /** @var string  */
    const CONFIG_SECTION_AND_GROUP = 'componentUI/general/';

    /** @var string  */
    const FIELD_ENABLE_MODULE = 'enable';

    /** @var string  */
    const FIELD_TITLE = 'title';

    /** @var string  */
    const FIELD_DESCRIPTION = 'description';

    /** @var ScopeConfigInterface  */
    private $scopeConfig;

    /** @var StoreManagerInterface  */
    private $storeManager;

    /** @var LoggerInterface  */
    private $logger;

    /** @var array  */
    private $output = [];

    /**
     * ShippingOptionsConfigProvider constructor.
     * @param ScopeConfigInterface $config
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     */
    public function __construct(ScopeConfigInterface $config,
                                StoreManagerInterface $storeManager,
                                LoggerInterface $logger)
    {
        $this->scopeConfig = $config;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        if(!empty($this->output)){
            return $this->output;
        }
        try{
            $config = [
                'enabled' => $this->getEnabled(),
                'title' => $this->getTitle(),
                'description' => $this->getDescription()
            ];
            $this->output['shipping_options'] = $config;
        }
        catch (\Throwable $throwable){
            $this->logger->critical($throwable->getMessage());
        }
        return $this->output;
    }

    /**
     * @return bool
     * @throws NoSuchEntityException
     */
    private function getEnabled(){
        return $this->scopeConfig->isSetFlag(self::CONFIG_SECTION_AND_GROUP . self::FIELD_ENABLE_MODULE,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    /**
     * @return mixed
     * @throws NoSuchEntityException
     */
    private function getTitle(){
        return $this->scopeConfig->getValue(self::CONFIG_SECTION_AND_GROUP . self::FIELD_TITLE,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    /**
     * @return mixed
     * @throws NoSuchEntityException
     */
    private function getDescription(){
        return $this->scopeConfig->getValue(self::CONFIG_SECTION_AND_GROUP . self::FIELD_DESCRIPTION,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }
}