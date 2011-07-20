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
 * rtContactForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtContactForm extends sfForm
{
  public function setup()
  {
    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    // Widgets
    $this->widgetSchema['name']     = new sfWidgetFormInput(array(), array());
    $this->widgetSchema['email']    = new sfWidgetFormInput(array(), array());
    $this->widgetSchema['phone']    = new sfWidgetFormInput(array(), array());
    $this->widgetSchema['comments'] = new sfWidgetFormTextarea(array(),array());

    // Labels
    $this->widgetSchema->setLabel('name',"Name:");
    $this->widgetSchema->setLabel('email',"Email Address:");
    $this->widgetSchema->setLabel('phone',"Phone Number:");
    $this->widgetSchema->setLabel('comments',"Comment:");

    // Validators
    $this->setValidator('name', new sfValidatorString(array('required' => true),array('required' => 'Please provide a name')));
    $this->setValidator('email', new sfValidatorEmail(array('required' => true),array('required' => 'Please provide a valid email address')));
    $this->setValidator('phone', new sfValidatorString(array('required' => false)));
    $this->setValidator('comments', new sfValidatorString(array('required' => false)));

    // Optionally configured Captcha widget and validator.
    if(sfConfig::get('app_rt_captcha_enabled', true))
    {
      $this->widgetSchema['captcha'] = new rtWidgetFormCaptcha();
      $this->widgetSchema->setLabel('captcha', 'Are you human');
      $this->setValidator('captcha', new rtValidatorCaptcha(array('required' => true), array('required' => 'The captcha is required, please try again.','invalid' => 'The captcha you entered didn\'t pass validation, please try again.')));
    }

    // Optionally configured Honeypot widget and validator.
    if(sfConfig::get('app_rt_honeypot_enabled', true))
    {
      $this->widgetSchema['special_name'] = new rtWidgetFormHoneypot();
      $this->setValidator('special_name', new rtValidatorHoneypot(array('required' => false),array()));
    }

    $this->widgetSchema->setNameFormat('bd_basic_form[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}