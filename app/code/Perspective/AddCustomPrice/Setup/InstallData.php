<?php


namespace Perspective\AddCustomPrice\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{
    /**
     * Eav setup factory
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory, \Magento\Catalog\Model\Product\Attribute\Backend\Price $price)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'allow_modify',
            [
                "type"     => "int",
                "backend"  => "",
                "label"    => "Allow modify",
                "input"    => "boolean",
                "source"   => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                "visible"  => false,
                "required" => false,
                "default" => "",
                "frontend" => "",
                "unique"     => false,
                "note"       => "",
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'custom_price',
            [
                'type' => 'decimal',
                'label' => 'Custom Price',
                'input' => 'price',
                'source' => '',
                'frontend' => '',
                'required' => false,
                'backend' => '',
                'default' => null,
                'user_defined' => true,
                'unique' => false,
                'group' => 'General',
            ]
        );

    }
}

