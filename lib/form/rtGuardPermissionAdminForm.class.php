<?php
/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtGuardPermissionAdminForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardPermissionAdminForm extends BasesfGuardPermissionForm
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
    $this->setWidget('groups_list', new sfWidgetFormDoctrineChoice(array('expanded' => true ,'multiple' => true, 'model' => 'sfGuardGroup')));
    //$this->setWidget('users_list', new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'sfGuardUser')));
  }
}
