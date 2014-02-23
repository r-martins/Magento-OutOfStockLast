<?php
class RicardoMartins_OutofstockLast_Model_CatalogSearch_Mysql4_Advanced_Collection extends
    Mage_CatalogSearch_Model_Mysql4_Advanced_Collection
{
    public function setOrder($attribute, $dir='desc')
    {
    $this->addAttributeToSort('on_top', 'desc');
        parent::setOrder($attribute, $dir);
        return $this;
    }
}