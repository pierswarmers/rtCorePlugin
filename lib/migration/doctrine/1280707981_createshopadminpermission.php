<?php

class Createshopadminpermission extends Doctrine_Migration_Base
{
  public function up()
  {
    // Start order permission
    $order = new sfGuardPermission();
    $order->setName('admin_shop_order');
    $order->setDescription('Administrator orders in shop');
    $order->save();

    $o_group = Doctrine::getTable('sfGuardGroup')->findOneByName('admin');
    $group_order = new sfGuardGroupPermission();
    $group_order->setGroupId($o_group->getId());
    $group_order->setPermissionId($order->getId());
    $group_order->save();
    // End order permission

    // Start promotion permission
    $promotion = new sfGuardPermission();
    $promotion->setName('admin_shop_promotion');
    $promotion->setDescription('Administrator promotions in shop');
    $promotion->save();

    $p_group = Doctrine::getTable('sfGuardGroup')->findOneByName('admin');
    $group_promotion = new sfGuardGroupPermission();
    $group_promotion->setGroupId($p_group->getId());
    $group_promotion->setPermissionId($promotion->getId());
    $group_promotion->save();
    // End promotion permission

    // Start voucher permission
    $voucher = new sfGuardPermission();
    $voucher->setName('admin_shop_voucher');
    $voucher->setDescription('Administrator vouchers in shop');
    $voucher->save();

    $v_group = Doctrine::getTable('sfGuardGroup')->findOneByName('admin');
    $group_voucher = new sfGuardGroupPermission();
    $group_voucher->setGroupId($v_group->getId());
    $group_voucher->setPermissionId($voucher->getId());
    $group_voucher->save();
    // End voucher permission
  }

  public function down()
  {
    Doctrine::getTable('sfGuardPermission')->findByName('admin_shop_order')->delete();
    Doctrine::getTable('sfGuardPermission')->findByName('admin_shop_promotion')->delete();
    Doctrine::getTable('sfGuardPermission')->findByName('admin_shop_voucher')->delete();
  }
}