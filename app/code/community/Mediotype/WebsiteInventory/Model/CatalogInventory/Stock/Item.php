<?php
/**
 *
 * @author  Joel    @Mediotype
 */ 
class Mediotype_WebsiteInventory_Model_CatalogInventory_Stock_Item extends Mage_CatalogInventory_Model_Stock_Item {

    /**
     * Load item data by product
     *
     * @param   mixed $product
     * @return  Mage_CatalogInventory_Model_Stock_Item
     */
    public function loadByProduct($product)
    {
        if ($product instanceof Mage_Catalog_Model_Product) {
            $this->setWebsiteId($product->getStore()->getWebsiteId());
            $product = $product->getId();
        } else {
            $this->setWebsiteId(Mage::app()->getStore($this->getStoreId())->getWebsiteId());
        }
        $this->_getResource()->loadByProductId($this, $product);
        $this->setOrigData();
        return $this;
    }

    /**
     * Adding stock data to product
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  Mage_CatalogInventory_Model_Stock_Item
     */
    public function assignProduct(Mage_Catalog_Model_Product $product)
    {
        if (!$this->getId() || !$this->getProductId()) {
            $this->setWebsiteId($product->getStore()->getWebsiteId());
            $this->_getResource()->loadByProductId($this, $product->getId());
            $this->setOrigData();
        }

        $this->setProduct($product);
        $product->setStockItem($this);

        $product->setIsInStock($this->getIsInStock());
        Mage::getSingleton('cataloginventory/stock_status')
            ->assignProduct($product, $this->getStockId(), $this->getStockStatus());
        return $this;
    }

}