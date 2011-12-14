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
 * rtGuardRegisterStandardForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardRegisterStandardForm extends rtGuardUserPublicForm
{
  public function setup()
  {
    parent::setup();

    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    $this->useFields(array(
      'first_name',
      'last_name',
      'email_address',
      'password',
      'date_of_birth',
    ));

    $this->widgetSchema['captcha'] = new rtWidgetFormCaptcha();
    $this->widgetSchema->setLabel('captcha', 'Are you human');
    $this->setValidator('captcha', new rtValidatorCaptcha(array('required' => true), array('required' => 'This question is required, please try again.','invalid' => 'The answer you entered didn\'t pass validation, please try again.')));
  }
}