<?php


namespace Perspective\Holiday\Controller\Adminhtml\Holiday;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Perspective_Holiday::days';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory
) {
    $this->resultPageFactory = $resultPageFactory;
    parent::__construct($context);
}

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
{
    /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
    $resultPage = $this->resultPageFactory->create();
    $resultPage->setActiveMenu('Perspective_Holiday::days')
        ->addBreadcrumb(__('Holidays'), __('Holidays'))
        ->addBreadcrumb(__('Holiday'), __('Holiday')
        )->getConfig()->getTitle()->prepend(__('Holidays'));

    return $resultPage;
}
}
