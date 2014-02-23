<?php
class RicardoMartins_OutofstockLast_Model_CatalogSearch_Layer extends Mage_CatalogSearch_Model_Layer
{
    public function prepareProductCollection($collection)
    {
        $collection->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addSearchFilter(Mage::helper('catalogsearch')->getQuery()->getQueryText())
            ->setStore(Mage::app()->getStore())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite();
        $collection->getSelect()->joinLeft(
                array('_inventory_table'=>'cataloginventory_stock_item'),
                "_inventory_table.product_id = e.entity_id",
                array('is_in_stock', 'manage_stock')
            );
        $collection->addExpressionAttributeToSelect('on_top',
            '(CASE WHEN (((_inventory_table.use_config_manage_stock = 1)
            AND (_inventory_table.is_in_stock = 1)) OR  ((_inventory_table.use_config_manage_stock = 0)
            AND (1 - _inventory_table.manage_stock + _inventory_table.is_in_stock >= 1)))
            THEN 1 ELSE 0 END)',
        array());
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);
        return $this;
    }
}