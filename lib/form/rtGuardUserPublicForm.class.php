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
 * rtGuardUserPublicForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardUserPublicForm extends rtGuardUserForm
{
  public function setup()
  {
    parent::setup();

    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    unset(
      $this['is_active'],
      $this['is_super_admin'],
      $this['groups_list'],
      $this['permissions_list']
    );


    $this->widgetSchema->setHelp('first_name', 'Required');
    $this->setValidator('first_name', new sfValidatorString(array('required' => true)));
    $this->widgetSchema->setHelp('last_name', 'Required');
    $this->setValidator('last_name', new sfValidatorString(array('required' => true)));


    $this->widgetSchema->setHelp('email_address', 'Required');
    $this->widgetSchema->setHelp('username', 'Required');


    $this->widgetSchema->setHelp('password', 'Must be at least 6 characters long');
    $this->setValidator('password', new sfValidatorString(array('required' => false, 'min_length' => 6)));
    $this->widgetSchema->setHelp('password_again', 'Once again, just to be sure');


    $this->widgetSchema->setHelp('url', 'Must start with: http:// or https://');
    $this->setValidator('url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Please enter a valid website address.')));

    $this->widgetSchema->setLabel('url', 'Website');
    $this->widgetSchema->setHelp('url', 'Must start with: http:// or https://');
    $this->setValidator('url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Please enter a valid website address.')));



    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('email_address')), array('invalid' => 'That email address is already taken.')),
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username')), array('invalid' => 'That username is already taken.')),
      ))
    );
  }
}
?>
