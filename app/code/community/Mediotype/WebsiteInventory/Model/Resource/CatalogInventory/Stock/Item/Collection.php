<?php
/**
 *
 * @author  Joel    @Mediotype
 */ 
class Mediotype_WebsiteInventory_Model_Resource_CatalogInventory_Stock_Item_Collection extends Mage_CatalogInventory_Model_Resource_Stock_Item_Collection {

    /**
     * Join Stock Status to collection
     *
     * @param int $storeId
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    public function joinStockStatus($storeId = null)
    {
        $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        $this->getSelect()->joinLeft(
            array('status_table' => $this->getTable('cataloginventory/stock_status')),
            'main_table.product_id=status_table.product_id'
            . ' AND main_table.stock_id=status_table.stock_id'
            . $this->getConnection()->quoteInto(' AND status_table.website_id=?', $websiteId),
            array('stock_status')
        );

        $this->getSelect()->where( "status_table.website_id = ? " , $websiteId  );

        return $this;
    }

}