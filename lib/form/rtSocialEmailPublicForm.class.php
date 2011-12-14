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
 * rtSocialEmailPublicForm
 *
 * @package    rtCorePlugin
 * @subpackage forms
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtSocialEmailPublicForm extends sfForm
{
  public function setup()
  {
    $user = sfContext::getInstance()->getUser();

    // Format
    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    // Widgets
    $this->widgetSchema['from_name']  = new sfWidgetFormInput(array(),array('readonly' => $user->isAuthenticated() ? true : false));
    $this->widgetSchema['from_email'] = new sfWidgetFormInput(array(),array('readonly' => $user->isAuthenticated() ? true : false));
    $this->widgetSchema['to_email']   = new sfWidgetFormInput();
    $this->widgetSchema['note']       = new sfWidgetFormTextarea();
    $this->widgetSchema['copy']       = new sfWidgetFormInputCheckbox();

    // Labels
    $this->widgetSchema->setLabel('from_name',"Your Name");
    $this->widgetSchema->setLabel('from_email',"Your Email");
    $this->widgetSchema->setLabel('to_email', "Recipients Email");
    $this->widgetSchema->setLabel('copy', " ");

    // Help texts
    if(!$user->isAuthenticated())
    {
      $this->widgetSchema->setHelp('from_name',"Required");
      $this->widgetSchema->setHelp('from_email',"Required");
    }
    $this->widgetSchema->setHelp('to_email',"One email or comma separated for multiple.");
    $this->widgetSchema->setHelp('copy'    ,"Send me a copy of this email");

    // Defaults
    if($user->isAuthenticated())
    {
      $this->widgetSchema->setDefault('from_name', sprintf('%s %s',$user->getGuardUser()->getFirstName(),$user->getGuardUser()->getLastName()));
      $this->widgetSchema->setDefault('from_email',$user->getGuardUser()->getEmailAddress());
    }
    $this->widgetSchema->setDefault('note',"I thought you might be interested in this...");
    
    // Validators
    $this->setValidator('from_name',  new sfValidatorString(array('required' => $user->isAuthenticated() ? false : true),array('required' => 'Please provide your name')));
    $this->setValidator('from_email', new sfValidatorEmail(array('required' => $user->isAuthenticated() ? false : true),array('required' => 'Please provide your email address')));
    $this->setValidator('to_email',   new sfValidatorString(array('required' => true),array('required' => 'Please provide a recipients email address')));
    $this->setValidator('note',       new sfValidatorString(array('required' => false)));
    $this->setValidator('copy',       new sfValidatorBoolean(array('required' => false)));

    $this->widgetSchema->setNameFormat('rt_social[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}