<?php

namespace Perspective\Holiday\Controller\Adminhtml\Holiday;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('holiday_id');

            if (empty($data['holiday_id'])) {
                $data['holiday_id'] = null;
            }

            /** @var \Perspective\Holiday\Model\Holiday $model */
            $model = $this->_objectManager->create('Perspective\Holiday\Model\Holiday')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This group no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the holiday.'));
                $this->dataPersistor->clear('perspective_holiday_days');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['holiday_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the holiday.'));
            }

            $this->dataPersistor->set('perspective_holiday_days', $data);
            return $resultRedirect->setPath('*/*/edit', ['holiday_id' => $this->getRequest()->getParam('holiday_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
