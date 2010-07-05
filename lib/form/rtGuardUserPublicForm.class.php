<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rtGuardUserPublicForm
 *
 * @author pierswarmers
 */
class rtGuardUserPublicForm extends rtGuardUserForm
{
  public function setup()
  {
    parent::setup();

    unset(
      $this['is_active'],
      $this['is_super_admin'],
      $this['groups_list'],
      $this['permissions_list']
    );
  }
}
?>
