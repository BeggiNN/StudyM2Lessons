<?php


namespace Perspective\CancelOrder\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class HTMLLink extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /** Url Path */
    const PRODUCT_URL_PATH_EDIT = 'admin/sales/order/view/order_id/';

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as $key => $item) {
                if (isset($item['order_id'])) {
                    $id = $item['order_id'];
                    $url = $this->urlBuilder->getBaseUrl() . self::PRODUCT_URL_PATH_EDIT . $id;
                    $dataSource['data']['items'][$key]['action'] = "<a href='$url'>View Order</a>";
                }
            }
        }
        return $dataSource;
    }
}
