addCatalogInventoryToProductCollection<?php
/**
 *
 */ 
class Mediotype_WebsiteInventory_Model_Resource_CatalogInventory_Stock_Item extends Mage_CatalogInventory_Model_Resource_Stock_Item {

    /**
     * Loading stock item data by product
     *
     * @param Mage_CatalogInventory_Model_Stock_Item $item
     * @param int $productId
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item
     */
    public function loadByProductId(Mage_CatalogInventory_Model_Stock_Item $item, $productId)
    {
        $select = $this->_getLoadSelect('product_id', $productId, $item)
            ->where('stock_id = :stock_id AND website_id = :website_id');
        $data = $this->_getReadAdapter()->fetchRow($select, array(':stock_id' => $item->getStockId(), ':website_id' => $item->getWebsiteId()));
        if ($data) {
            $item->setData($data);
        }
        $this->_afterLoad($item);
        return $this;
    }

    /**
     * Add join for catalog in stock field to product collection
     *
     * @param Mage_Catalog_Model_Resource_Product_Collection $productCollection
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item
     */
    public function addCatalogInventoryToProductCollection($productCollection)
    {

        $adapter = $this->_getReadAdapter();
        $isManageStock = (int)Mage::getStoreConfig(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_MANAGE_STOCK);
        $stockExpr = $adapter->getCheckSql('cisi.use_config_manage_stock = 1', $isManageStock, 'cisi.manage_stock');
        $stockExpr = $adapter->getCheckSql("({$stockExpr} = 1)", 'cisi.is_in_stock', '1');

        $websiteId = Mage::app()->getStore(null)->getWebsiteId();
        $productCollection->joinTable(
            array('cisi' => 'cataloginventory/stock_item'),
            'product_id=entity_id',
            array(
                'is_saleable'           => new Zend_Db_Expr($stockExpr),
                'inventory_in_stock'    => 'is_in_stock',
                'website_id'            => 'website_id',
            ),
            "cisi.website_id=".$websiteId,
            'left'
        );

        return $this;
    }

}