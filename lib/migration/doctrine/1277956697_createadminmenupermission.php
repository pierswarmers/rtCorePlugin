<?php

class Createadminmenupermission extends Doctrine_Migration_Base
{
  public function up()
  {
    $permission = new sfGuardPermission();
    $permission->setName('show_admin_menu');
    $permission->setDescription('Administration menu to be displayed');
    $permission->save();

    $group = Doctrine::getTable('sfGuardGroup')->findOneByName('admin');
    $group_permission = new sfGuardGroupPermission();
    $group_permission->setGroupId($group->getId());
    $group_permission->setPermissionId($permission->getId());
    $group_permission->save();
  }

  public function down()
  {
    Doctrine::getTable('sfGuardPermission')->findByName('show_admin_menu')->delete();
  }
}
