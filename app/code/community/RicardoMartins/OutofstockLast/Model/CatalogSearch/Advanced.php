<?php
class RicardoMartins_OutofstockLast_Model_CatalogSearch_Advanced extends Mage_CatalogSearch_Model_Advanced
{
    /**
     * Retrieve advanced search product collection
     *
     * @return Mage_CatalogSearch_Model_Mysql4_Advanced_Collection
     */
    public function getProductCollection(){
        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getResourceModel('catalogsearch/advanced_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
                ->addTaxPercents()
                ->addStoreFilter();

            $this->_productCollection->getSelect()->joinLeft(
                array('_inventory_table'=>'cataloginventory_stock_item'),
                "_inventory_table.product_id = e.entity_id",
                array('is_in_stock', 'manage_stock')
            );

            $this->_productCollection->addExpressionAttributeToSelect('on_top',
                '(CASE WHEN (((_inventory_table.use_config_manage_stock = 1) AND (_inventory_table.is_in_stock = 1)) OR  ((_inventory_table.use_config_manage_stock = 0) AND (1 - _inventory_table.manage_stock + _inventory_table.is_in_stock >= 1))) THEN 1 ELSE 0 END)',
                array());

            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($this->_productCollection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($this->_productCollection);
        }
        return $this->_productCollection;
    }
}
