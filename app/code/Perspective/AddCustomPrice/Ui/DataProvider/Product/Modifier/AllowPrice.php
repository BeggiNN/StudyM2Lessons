<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Perspective\AddCustomPrice\Ui\DataProvider\Product\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\ProductAlert\Model\Price;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;

class AllowPrice extends AbstractModifier
{
    const FIELD_MESSAGE_AVAILABLE = 'custom_price';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        LocatorInterface $locator,
        ArrayManager $arrayManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'product-details' => [
                    'children' => $this->getFields(),
                    ]
            ]
        );
        $product = $this->locator->getProduct();
        $enabled = boolval($product->getData('allow_modify'));
        $meta['product-details']['children']['custom_price']['arguments']['data']['config']['default'] = $product->getData('custom_price');
        $meta['product-details']['children']['custom_price']['arguments']['data']['config']['disabled'] = !$enabled;
        if ($enabled)
        {
            $meta['product-details']['children']['allow_modify']['arguments']['data']['config']['value'] = "1";
        }
        else
        {
            $meta['product-details']['children']['allow_modify']['arguments']['data']['config']['value'] = "0";
        }
        return $meta;
    }

    /**
     * Customization of allow custom price field
     *
     * @param array $meta
     * @return array
     */
    protected function getFields()
    {
        return [
            'custom_price' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                                'label'         => __('Custom Price'),
                                'componentType' => Field::NAME,
                                'formElement'   => Input::NAME,
                                'dataScope'     => 'custom_price',
                                'additionalClasses' => 'admin__field-x-small_prices',
                                'dataType'      => Text::NAME,
                                'sortOrder'     => 40
                                ],
                            ],
                        ],
                    ],
                    'allow_modify' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'dataType' => 'number',
                                    'formElement' => \Magento\Ui\Component\Form\Element\Checkbox::NAME,
                                    'componentType' => Field::NAME,
                                    'description' => __('Allow Modify'),
                                    'dataScope' => 'allow_modify',
                                    'sortOrder'     => 400,
                                    'valueMap' => [
                                        'false' => '0',
                                        'true' => '1',
                                    ],
                                ],
                            ],
                        ],
                    ],
            ];
    }
}
