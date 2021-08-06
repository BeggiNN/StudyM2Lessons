<?php

namespace Perspective\Holiday\Block\Adminhtml\Holiday\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Perspective\Holiday\Block\Adminhtml\Holiday\Edit\GenericButton;

/**
 * Class SaveAndContinueButton
 */
class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->_isAllowedAction('Perspective_Holiday::holiday_create') || $this->_isAllowedAction('Perspective_Holiday::holiday_update')) {
            $data = [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit'],
                    ],
                ],
                'sort_order' => 80,
            ];
        }
        return $data;
    }
}
