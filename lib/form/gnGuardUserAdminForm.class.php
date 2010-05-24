<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class gnGuardUserAdminForm extends sfGuardUserAdminForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    parent::setup();
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off'));
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off'));
    $this->setWidget('groups_list', new sfWidgetFormDoctrineChoice(array('expanded' => true ,'multiple' => true, 'model' => 'sfGuardGroup')));
    $this->setWidget('permissions_list', new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'sfGuardPermission')));
  }

  public function getModelName()
  {
    return 'gnGuardUser';
  }
}
