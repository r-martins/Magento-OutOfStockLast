<?php
class RicardoMartins_OutofstockLast_Model_CatalogSearch_Mysql4_Fulltext_Collection
    extends Mage_CatalogSearch_Model_Mysql4_Fulltext_Collection
{
   public function setOrder($attribute, $dir = 'desc')
    {
        if ($attribute == 'relevance') {
            $this->setOrder("on_top","DESC");
            $this->_relevanceSortOrder = ($dir == 'asc') ? SORT_ASC : SORT_DESC;
            $this->addOrder(self::RELEVANCE_ORDER_NAME);
        }
        else {
            parent::setOrder('on_top', 'DESC');
            parent::setOrder($attribute, $dir);
        }
        return $this;
    }
}
