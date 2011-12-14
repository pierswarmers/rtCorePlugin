<?php

class Createshoporderworkflowpermissions extends Doctrine_Migration_Base
{
  public function up()
  {
    // Start order picking permission
    $picking = new sfGuardPermission();
    $picking->setName('admin_shop_order_picking');
    $picking->setDescription('Administrator orders in shop');
    $picking->save();

    $o_group = Doctrine::getTable('sfGuardGroup')->findOneByName('admin');
    $group_order = new sfGuardGroupPermission();
    $group_order->setGroupId($o_group->getId());
    $group_order->setPermissionId($picking->getId());
    $group_order->save();
    // End order picking permission

    // Start order dispatch permission
    $dispatch = new sfGuardPermission();
    $dispatch->setName('admin_shop_order_dispatch');
    $dispatch->setDescription('Administrator promotions in shop');
    $dispatch->save();

    $p_group = Doctrine::getTable('sfGuardGroup')->findOneByName('admin');
    $group_promotion = new sfGuardGroupPermission();
    $group_promotion->setGroupId($p_group->getId());
    $group_promotion->setPermissionId($dispatch->getId());
    $group_promotion->save();
    // End order dispatch permission

    // Add new column shipping_code to shop order table
    $this->addColumn('rt_shop_order', 'shipping_code', 'string', '50', array());
  }

  public function down()
  {
    Doctrine::getTable('sfGuardPermission')->findByName('admin_shop_order_picking')->delete();
    Doctrine::getTable('sfGuardPermission')->findByName('admin_shop_order_dispatch')->delete();
    $this->removeColumn('rt_shop_order', 'shipping_code');
  }
}