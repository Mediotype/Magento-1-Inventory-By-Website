<?php
/**
 *
 * @author  Joel    @Mediotype
 */ 
class Mediotype_WebsiteInventory_Block_Adminhtml_Catalog_Product_Edit_Action_Attribute_Tab_Inventory extends Mage_Adminhtml_Block_Catalog_Product_Edit_Action_Attribute_Tab_Inventory {

    protected function _toHtml()
    {
        $html = parent::_toHtml();

        $hideScopeHtml = "<style>#table_cataloginventory .scope-label { display:none; }</style>";

        return $hideScopeHtml . $html;
    }

}