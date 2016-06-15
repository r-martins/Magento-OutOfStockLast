<?php
/**
 * Class RicardoMartins_OutofstockLast_Model_Catalog_Layer
 *
 * @author    Ricardo Martins <ricardo@ricardomartins.net.br>
 * @see http://www.ishoni.com/2011/09/magento-out-of-stock-pushed-to-end-of.html
 */

class RicardoMartins_OutofstockLast_Model_Catalog_Layer extends Mage_Catalog_Model_Layer
{
    /**
     * Retrieve current layer product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    public function getProductCollection()
    {
        if (isset($this->_productCollections[$this->getCurrentCategory()->getId()])) {
            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];
        } else {
            $collection = $this->getCurrentCategory()->getProductCollection();
            $collection->getSelect()->joinLeft(
array('stock_status' => $collection->getTable('cataloginventory/stock_status')),
'e.entity_id = stock_status.product_id AND stock_status.website_id='.Mage::app()->getWebsite()->getId()
);
$collection->getSelect()->order('stock_status DESC');
            $this->prepareProductCollection($collection);
            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;
        }

        return $collection;
    }
}