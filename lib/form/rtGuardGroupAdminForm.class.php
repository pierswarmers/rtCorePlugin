<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class rtGuardGroupAdminForm extends BasesfGuardGroupForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    parent::setup();
    unset($this['created_at'], $this['updated_at'], $this['users_list']);
    $this->setWidget('description', new sfWidgetFormInputText());
    $this->setValidator('name', new sfValidatorString(array('max_length' => 255, 'required' => true)));
    $this->setWidget('permissions_list', new sfWidgetFormDoctrineChoice(array('expanded' => true ,'multiple' => true, 'model' => 'sfGuardPermission')));
    $this->setWidget('users_list', new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'sfGuardUser')));
  }
}
