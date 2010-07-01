<?php

class Createsnippetadminpermission extends Doctrine_Migration_Base
{
  public function up()
  {
    $permission = new sfGuardPermission();
    $permission->setName('admin_snippet');
    $permission->setDescription('Administrator permission for snippets');
    $permission->save();

    $group = Doctrine::getTable('sfGuardGroup')->findOneByName('admin');
    $group_permission = new sfGuardGroupPermission();
    $group_permission->setGroupId($group->getId());
    $group_permission->setPermissionId($permission->getId());
    $group_permission->save();
  }

  public function down()
  {
    Doctrine::getTable('sfGuardPermission')->findByName('admin_snippet')->delete();
  }
}
