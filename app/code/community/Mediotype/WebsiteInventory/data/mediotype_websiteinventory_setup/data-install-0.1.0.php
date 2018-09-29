<?php
/**
 * Created by PhpStorm.
 * User: Mediotype
 * Date: 3/24/16
 * Time: 10:13 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

//TODO duplicate out inventory records on a per website id (from core_website) basis if they don't exist in the cataloginventory_stock_item table

$installer->endSetup();