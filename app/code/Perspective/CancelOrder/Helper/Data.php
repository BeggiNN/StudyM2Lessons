<?php


namespace Perspective\CancelOrder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    const XML_PATH = 'cancel/';

    protected $customerSession;
    protected $groupRepository;

    public function __construct(
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Customer\Model\Session $customerSession,
        Context $context
    ) {
        $this->customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH . 'general/' . $code, $storeId);
    }

    public function getStatusModule()
    {
        return $this->getGeneralConfig('enable');
    }

    public function getOrderStatus($currectStatus)
    {
        $status = explode(",", $this->getGeneralConfig('status'));
        if (in_array($currectStatus, $status)) {
            return true;
        } else {
            return false;
        }
    }

    public function getGroupsCustomer()
    {
        return $this->getGeneralConfig('group');
    }
}
