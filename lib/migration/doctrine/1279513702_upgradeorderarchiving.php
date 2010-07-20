<?php

class Upgradeorderarchiving extends Doctrine_Migration_Base
{
  public function preUp()
  {
    parent::preUp();
    $query = Doctrine::getTable('rtShopOrder')->getQueryObject();
    $query->delete()->execute();
  }

  public function up()
  {
    $this->renameColumn('rt_shop_order', 'email', 'email_address');
    $this->renameColumn('rt_shop_order', 'closed_shipping_rate', 'shipping_charge');

    // tax
    $this->renameColumn('rt_shop_order', 'closed_taxes', 'tax_charge');
    $this->addColumn('rt_shop_order', 'tax_component', 'float', null, array());
    $this->addColumn('rt_shop_order', 'tax_mode', 'string', '50', array());
    $this->addColumn('rt_shop_order', 'tax_rate', 'float', null, array());

    // promotion
    $this->renameColumn('rt_shop_order', 'closed_promotions', 'promotion_reduction');
    $this->addColumn('rt_shop_order', 'promotion_id', 'integer', null, array());
    $this->addColumn('rt_shop_order', 'promotion_data', 'text', null, array());

    // voucher
    $this->addColumn('rt_shop_order', 'voucher_reduction', 'float', null, array());
    $this->addColumn('rt_shop_order', 'voucher_id', 'integer', null, array());
    $this->addColumn('rt_shop_order', 'voucher_data', 'text', null, array());

    // products
    $this->renameColumn('rt_shop_order', 'closed_products', 'products_data');
    $this->changeColumn('rt_shop_order', 'products_data', 'text');
    
    // totals
    $this->addColumn('rt_shop_order', 'items_charge', 'float', null, array());
    $this->renameColumn('rt_shop_order', 'closed_total', 'total_charge');

    // payment
    $this->addColumn('rt_shop_order', 'payment_data', 'text', null, array());
    $this->removeColumn('rt_shop_order', 'payment_approved');
    $this->removeColumn('rt_shop_order', 'payment_response');
  }

  public function down()
  {
    $this->renameColumn('rt_shop_order', 'email_address', 'email');
    $this->renameColumn('rt_shop_order', 'shipping_charge', 'closed_shipping_rate');
    
    // tax
    $this->renameColumn('rt_shop_order', 'tax_charge', 'closed_taxes');
    $this->removeColumn('rt_shop_order', 'tax_component');
    $this->removeColumn('rt_shop_order', 'tax_mode');
    $this->removeColumn('rt_shop_order', 'tax_rate');

    // promotion
    $this->renameColumn('rt_shop_order', 'promotion_reduction', 'closed_promotions');
    $this->removeColumn('rt_shop_order', 'promotion_id');
    $this->removeColumn('rt_shop_order', 'promotion_data');

    // voucher
    $this->removeColumn('rt_shop_order', 'voucher_reduction');
    $this->removeColumn('rt_shop_order', 'voucher_id');
    $this->removeColumn('rt_shop_order', 'voucher_data');

    // products
    $this->renameColumn('rt_shop_order', 'products_data', 'closed_products');
    $this->changeColumn('rt_shop_order', 'closed_products', 'text');

    // totals
    $this->removeColumn('rt_shop_order', 'items_charge');
    $this->renameColumn('rt_shop_order', 'total_charge', 'closed_total');

    // payment
    $this->removeColumn('rt_shop_order', 'payment_data');
    $this->addColumn('rt_shop_order', 'payment_approved', 'integer', 1, array());
    $this->addColumn('rt_shop_order', 'payment_response', 'string', null, array());
  }
}
