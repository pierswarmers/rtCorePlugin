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


    $this->widgetSchema->setHelp('password', 'Required - at least 6 characters long');
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
