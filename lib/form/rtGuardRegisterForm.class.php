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
 * rtGuardRegisterForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardRegisterForm extends rtGuardUserPublicForm
{
  public function setup()
  {
    parent::setup();
//
//    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));
//
//    $years = range(date('Y') - sfConfig::get('app_rt_user_age_year_buffer', 100), date('Y'));
//
//    $options = array(
//      'format' => '%day%/%month%/%year%',
//      'years' => array_combine($years, $years)
//    );
//
//    $this->setWidget('date_of_birth',  new sfWidgetFormDate($options));
//
//    $this->widgetSchema->setHelp('first_name', 'Required');
//    $this->setValidator('first_name', new sfValidatorString(array('required' => true)));
//    $this->widgetSchema->setHelp('last_name', 'Required');
//    $this->setValidator('last_name', new sfValidatorString(array('required' => true)));
//
//
//    $this->widgetSchema->setHelp('email_address', 'Required');
//    $this->widgetSchema->setHelp('username', 'Required');
//
//
//    $this->widgetSchema->setHelp('password', 'Required - at least 6 characters long');
//    $this->setValidator('password', new sfValidatorString(array('required' => true, 'min_length' => 6)));
//    $this->widgetSchema->setHelp('password_again', 'Once again, just to be sure');
//
//
//    $this->widgetSchema->setHelp('url', 'Must start with: http:// or https://');
//    $this->setValidator('url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Please enter a valid website address.')));
//
//    $this->widgetSchema->setLabel('url', 'Website');
//    $this->widgetSchema->setHelp('url', 'Must start with: http:// or https://');
//    $this->setValidator('url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Please enter a valid website address.')));
//
//    $this->validatorSchema->setPostValidator(
//      new sfValidatorAnd(array(
//        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('email_address')), array('invalid' => 'That email address is already taken.')),
//        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username')), array('invalid' => 'That username is already taken.')),
//      ))
//    );
//
//    // Optionally configured Captcha widget and validator.
//    if(sfConfig::get('app_rt_captcha_enabled', true))
//    {
//      $this->widgetSchema['captcha'] = new rtWidgetFormCaptcha();
//      $this->widgetSchema->setLabel('captcha', 'Are you human');
//      $this->setValidator('captcha', new rtValidatorCaptcha(array('required' => true), array('required' => 'The captcha is required, please try again.','invalid' => 'The captcha you entered didn\'t pass validation, please try again.')));
//    }
//
//    // Optionally configured Honeypot widget and validator.
//    if(sfConfig::get('app_rt_honeypot_enabled', true))
//    {
//      $this->widgetSchema['special_name'] = new rtWidgetFormHoneypot();
//      $this->setValidator('special_name', new rtValidatorHoneypot(array('required' => false),array()));
//    }
  }
}