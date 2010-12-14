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

    // Optionally configured ReCAPTCHA widget and validator.
    if(sfConfig::has('app_recaptcha_public_key'))
    {
      $this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array(
        'public_key' => sfConfig::get('app_recaptcha_public_key'),
        'theme' => sfConfig::get('app_recaptcha_theme', 'clean')
      ));
      $this->validatorSchema['captcha'] = new sfValidatorReCaptcha(array(
        'private_key' => sfConfig::get('app_recaptcha_private_key')
      ), array('captcha' => 'The captcha you entered didn\'t pass validation, please try again.'));
    }

    // Labels
    $this->widgetSchema->setLabel('name',"Name:");
    $this->widgetSchema->setLabel('email',"Email Address:");
    $this->widgetSchema->setLabel('phone',"Phone Number:");
    $this->widgetSchema->setLabel('comments',"Comment:");

    // Help texts
    $this->widgetSchema->setHelp('name',"Required");
    $this->widgetSchema->setHelp('email',"Required");

    // Validators
    $this->setValidator('name', new sfValidatorString(array('required' => true),array('required' => 'Please provide a name')));
    $this->setValidator('email', new sfValidatorEmail(array('required' => true),array('required' => 'Please provide a valid email address')));
    $this->setValidator('phone', new sfValidatorString(array('required' => false)));
    $this->setValidator('comments', new sfValidatorString(array('required' => false)));

    $this->widgetSchema->setNameFormat('bd_basic_form[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}