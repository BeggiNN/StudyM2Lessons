<?php


namespace Perspective\CancelOrder\Controller\Order;

use Magento\Sales\Controller\OrderInterface;
use Magento\Framework\App\Action\Context;

class Cancel extends \Magento\Framework\App\Action\Action implements OrderInterface
{
    /**
     * @var \Magento\Sales\Api\OrderManagementInterface
     */
    protected $_order;
    /**
     * @var \Magento\Framework\App\ResourceConnection $resource
     */
    protected $resource;
    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;
    protected $request;
    protected $order;

    /**
     * Cancel constructor.
     * @param \Magento\Sales\Api\OrderManagementInterface $orderManagementInterface
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Sales\Api\OrderManagementInterface $orderManagementInterface,
        \Magento\Framework\App\RequestInterface $request,
        Context $context
    ) {
        $this->_order = $orderManagementInterface;
        $this->_request = $request;
        $this->connection = $resource->getConnection();
        $this->resource = $resource;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = trim($this->_request->getParam('id'), '#');
        $comment = $this->_request->getParam('comment');
        $reason = $this->_request->getParam('reason');
        $cancel = $this->_order->cancel($id);
        if ($cancel) {
            $this->messageManager->addSuccess("Your order has been cancelled successfully.");
            $canceled = 'Customer';
            $data = [
                [
                    'order_id' => $id,
                    'reason' => $reason,
                    'comment' => $comment,
                    'cancel' => $canceled]
            ];
            $tableName = 'cancel_order';
            $this->connection->insertMultiple($tableName, $data);
        } else {
            $this->messageManager->addError("Sorry, We cant cancel your order right now.");
        }
    }
}
