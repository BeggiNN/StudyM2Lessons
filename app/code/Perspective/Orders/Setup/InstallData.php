<?php


namespace Perspective\Orders\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    public function install(ModuleDataSetupInterface $setup,
                            ModuleContextInterface $context)
    {
        for ($i = 9; $i <= 20; $i++) {
            $setup->getConnection()->update(
                $setup->getTable('sales_sequence_profile'),
                [
                    'prefix' => NULL
                ],
                [
                    "meta_id = $i"
                ],
            );
        }
        for ($i = 9; $i <= 20; $i += 4) {
            $setup->getConnection()->update(
                $setup->getTable('sales_sequence_meta'),
                [
                    'sequence_table' => 'sequence_order_1'
                ],
                [
                    "meta_id = $i"
                ],
            );
        }
        for ($i = 12; $i <= 20; $i += 4) {
            $setup->getConnection()->update(
                $setup->getTable('sales_sequence_meta'),
                [
                    'sequence_table' => 'sequence_shipment_1'
                ],
                [
                    "meta_id = $i"
                ],
            );
        }
        for ($i = 10; $i <= 20; $i += 4) {
            $setup->getConnection()->update(
                $setup->getTable('sales_sequence_meta'),
                [
                    'sequence_table' => 'sequence_invoice_1'
                ],
                [
                    "meta_id = $i"
                ],
            );
        }
        for ($i = 11; $i <= 20; $i += 4) {
            $setup->getConnection()->update(
                $setup->getTable('sales_sequence_meta'),
                [
                    'sequence_table' => 'sequence_creditmemo_1'
                ],
                [
                    "meta_id = $i"
                ],
            );
        }
    }
}
