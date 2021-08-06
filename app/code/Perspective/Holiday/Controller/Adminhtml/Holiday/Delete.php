<?php


namespace Perspective\Holiday\Controller\Adminhtml\Holiday;

/**
 * Class Delete
 * @package Perspective\Holiday\Controller\Adminhtml\Holiday
 */

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Perspective_Holiday::holiday_delete';

    /**
     * Delete Holiday
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $bannerId = (int)$this->getRequest()->getParam('holiday_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($bannerId && (int) $bannerId > 0) {
            try {
                $model = $this->_objectManager->create('Perspective\Holiday\Model\Holiday');
                $model->load($bannerId);
                $model->delete();
                $this->messageManager->addSuccess(__('The Holiday has been deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to the question grid
                return $resultRedirect->setPath('*/*/index');
            }
        }
        // display error message
        $this->messageManager->addError(__('Holiday doesn\'t exist any longer.'));
        // go to the question grid
        return $resultRedirect->setPath('*/*/index');
    }
}
