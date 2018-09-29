<?php
/**
 *
 * @author  Joel    @Mediotype
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `cataloginventory_stock_item` ADD `website_id` INT(10) DEFAULT 0 AFTER   `item_id`;

ALTER TABLE `cataloginventory_stock_item` DROP INDEX UNQ_CATALOGINVENTORY_STOCK_ITEM_PRODUCT_ID_STOCK_ID;
ALTER TABLE `cataloginventory_stock_item` ADD UNIQUE KEY `UNQ_CATALOGINVENTORY_STOCK_ITEM_PRODUCT_ID_STOCK_ID` (`product_id`, `website_id`, `stock_id`);

    ");

$installer->endSetup();